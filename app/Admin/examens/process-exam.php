<?php 
    

    if (!isset($_SESSION)) session_start();
    // database connection
    $connection = new mysqli('mariadb', 'izail', 'izail1337', 'gestion_etudiants')or die(mysqli_error($mysqli));
    
    require_once __DIR__ . '../../../vendor/autoload.php';
    // ajoute
    if(isset($_POST['ajouter-e']))
    {

        $date_exam = $_POST['date_exam'];
        $mat_id = $_POST['id_mat'];
        $prof_id = $_POST['id_prof'];
        $salle_id = $_POST['id_salle'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];
        $prof_sup = $_POST['prof_sup'];
        $type_exam = $_POST['type_exam'];
        
        /* check hours */
        $QueryCheck_salle = "SELECT * from examen WHERE salle_id = '$salle_id' AND date_exam = '$date_exam' AND heure_debut = '$heure_debut'";
        $check_salle_and_date = mysqli_query($connection, $QueryCheck_salle);
        $rs2 = mysqli_fetch_array($check_salle_and_date);
        $rs2 = $rs2['0'];


        /* check assistant professor */
        $QueryCheck_prof = "SELECT * from examen WHERE salle_id = '$salle_id' AND date_exam = '$date_exam' AND heure_debut = '$heure_debut' AND prof_sup = '$prof_sup'";
        $check_prof_assistant = mysqli_query($connection, $QueryCheck_prof);
        $rs3 = mysqli_fetch_array($check_prof_assistant);
        $rs3 = $rs3['0'];

        /* check salle capacity */
        $QueryCheck_salle_cpty = "SELECT capacite from salle WHERE  id_salle = $salle_id";
        $check_salle_capacity = mysqli_query($connection, $QueryCheck_salle_cpty);
        $rs4 = mysqli_fetch_array($check_salle_capacity);
        $rs4 = $rs4['0'];

        /* count student by section */
        $Query_count_std_section = "SELECT count(e.id_etud) AS NbrEtudiant  from matiere m, filieres f , etudiant e WHERE f.id_fil = e.fil_id AND m.fil_id = f.id_fil";
        $count_std_by_section = mysqli_query($connection, $Query_count_std_section);
        $rs5 = mysqli_fetch_array($count_std_by_section);
        $rs5 = $rs5['0'];

        /* get filiere */ 
        $Query_get_filiere = "SELECT f.id_fil FROM filieres f , matiere m WHERE f.id_fil = m.fil_id AND m.id_mat = '$mat_id'";
        $get_fil = mysqli_query($connection, $Query_get_filiere);
        $filiere = mysqli_fetch_array($get_fil);
        $filiere = $filiere['0'];

         /* check if subject is valid */
        $check_section = "SELECT * from professeurs_filieres WHERE prof_id = '$prof_id' AND fil_id = '$filiere'";
        $check_section_exist = mysqli_query($connection, $check_section);
        $rs6 = mysqli_fetch_array($check_section_exist);
        $rs6 = $rs6[0];

        /* Check date before */
        $current_date = date('Y-m-d');

        /* Check date of the exam */
        $dateDifference = strtotime($current_date) - strtotime($date_exam);
        

        if ($dateDifference >= 0) 
        { 
            $_SESSION['message_exam'] = "Impossible de reserver une date avant le $current_date";
            header("location: ajouter-exam.php");
        }
        else if ($rs3)
        {
            $_SESSION['message_exam'] = "Le professeur $prof_sup est déja assistant dans un autre exam en même heure";
            header("location: ajouter-exam.php");
        }
        else if (!$rs6)
        {
            $_SESSION['message_exam'] = "Ce professeur n'enseigne  pas cette matiere";
            header("location: ajouter-exam.php");
        }
        else if ($heure_fin - $heure_debut < 1)
        {
            $_SESSION['message_exam'] = "Au mois la durée d'un exam doit etre une heure ou plus";
            header("location: ajouter-exam.php");
        }
        else if  (((strtotime($heure_fin) - strtotime($heure_debut) / 60) < 60) || $heure_debut == $heure_fin )
        {
            $_SESSION['message_exam'] = "Impossible de commencer un exam à $heure_debut et terminer à $heure_fin";
            header("location: ajouter-exam.php");
        }
        else if (($heure_debut < "08:00") 
            || ($heure_fin > "19:00"))
        {
            $_SESSION['message_exam'] = "L'heure de l'exam doit etre entre 08:00 et 19:00";
            header("location: ajouter-exam.php");
        }
        else if ($rs2 > 0)
        {
            $_SESSION['message_exam'] = "La salle est déja reservé le $date_exam a $heure_debut";
            header("location: ajouter-exam.php");
        }
        else if ($rs4 < $rs5 )
        {
            $_SESSION['message_exam'] = "Le nombre des étudiants de cette filiere  dépasse la capacité de la salle";
            header("location: ajouter-exam.php");
        }
        else 
        {
            $dbQuery = "INSERT INTO examen  (date_exam, mat_id , prof_id, salle_id, heure_debut, heure_fin , prof_sup, type_exam) 
            VALUES ('$date_exam' , (select id_mat from matiere where id_mat = '$mat_id'),
            (select id_prof from professeurs where id_prof = '$prof_id'), 
            (select id_salle from salle where id_salle = '$salle_id'), 
            '$heure_debut' , '$heure_fin', '$prof_sup', '$type_exam'
            );";
            mysqli_query($connection, $dbQuery);   
            header("location: listes-exams.php");
        }
        
    }
    
    // suppresion
    if(isset($_GET['supprimer']))
    {
        $id_exam = $_GET['supprimer'];
        $sqlS = "DELETE from examen where id_exam = $id_exam" ;
        mysqli_query($connection,$sqlS);

        header("location: listes-exams.php");
    }

    // modification get
    if(isset($_GET['modifier']))
    {
        $id_exam = $_GET['modifier'];
        $res = $connection->query("SELECT e.id_exam , e.date_exam , m.nom_mat , e.mat_id, p.nom, s.num_salle, 
                            e.heure_debut, e.heure_fin , e.prof_sup, e.type_exam
                            from examen e , matiere m , professeurs p, salle s where e.mat_id = m.id_mat
                            AND e.prof_id = p.id_prof AND e.salle_id = s.id_salle") or die ($connection->error); 
            $row = $res->fetch_array();
            $date_exam = $row['date_exam'];
            $mat_id = $row['mat_id'];
            $nom = $row['nom'];
            $num_salle = $row['num_salle'];
            $heure_debut = $row['heure_debut'];
            $heure_fin = $row['heure_fin'];
            $prof_sup = $row['prof_sup'];
            $type_exam = $row['type_exam'];
    }
    // modification post
    if(isset($_POST['update']))
    {
        $id_exam = $_POST['id_exam'];
        $date_exam = $_POST['date_exam'];
        $mat_id = $_POST['id_mat'];
        $prof_id = $_POST['id_prof'];
        $salle_id = $_POST['id_salle'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];
        $type_exam = $_POST['type_exam'];
        $prof_sup = $_POST['prof_sup'];

        /* check hours */
        $QueryCheck_salle = "SELECT * from examen WHERE salle_id = '$salle_id' AND date_exam = '$date_exam' AND heure_debut = '$heure_debut'";
        $check_salle_and_date = mysqli_query($connection, $QueryCheck_salle);
        $rs2 = mysqli_fetch_array($check_salle_and_date);
        $rs2 = $rs2['0'];


        /* check assistant professor */
        $QueryCheck_prof = "SELECT * from examen WHERE salle_id = '$salle_id' AND date_exam = '$date_exam' AND heure_debut = '$heure_debut' AND prof_sup = '$prof_sup'";
        $check_prof_assistant = mysqli_query($connection, $QueryCheck_prof);
        $rs3 = mysqli_fetch_array($check_prof_assistant);
        $rs3 = $rs3['0'];

        /* check salle capacity */
        $QueryCheck_salle_cpty = "SELECT s.capacite from examen e , salle s WHERE $salle_id = s.id_salle";
        $check_salle_capacity = mysqli_query($connection, $QueryCheck_salle_cpty);
        $rs4 = mysqli_fetch_array($check_salle_capacity);
        $rs4 = $rs4['0'];

        /* count student by section */
        $Query_count_std_section = "SELECT count(e.id_etud) AS NbrEtudiant  from matiere m, filieres f , etudiant e WHERE f.id_fil = e.fil_id AND m.fil_id = f.id_fil";
        $count_std_by_section = mysqli_query($connection, $Query_count_std_section);
        $rs5 = mysqli_fetch_array($count_std_by_section);
        $rs5 = $rs5['0'];

        /* get filiere */ 
        $Query_get_filiere = "SELECT f.id_fil FROM filieres f , matiere m WHERE f.id_fil = m.fil_id AND m.id_mat = '$mat_id'";
        $get_fil = mysqli_query($connection, $Query_get_filiere);
        $filiere = mysqli_fetch_array($get_fil);
        $filiere = $filiere['0'];

         /* check if subject is valid */
        $check_section = "SELECT * from professeurs_filieres WHERE prof_id = '$prof_id' AND fil_id = '$filiere'";
        $check_section_exist = mysqli_query($connection, $check_section);
        $rs6 = mysqli_fetch_array($check_section_exist);
        $rs6 = $rs6[0];
        
        /* Check date before */
        $current_date = date('Y-m-d');

        /* Check date of the exam */
        $dateDifference = strtotime($current_date) - strtotime($date_exam);
        
        if (!$rs6)
        {
            $_SESSION['message_exam'] = "Ce professeur n'enseigne pas cette matiere";
            header("location: ajouter-exam.php");
        }
        else if ($dateDifference >= 0) 
        { 
            $_SESSION['message_exam'] = "Impossible de reserver une date avant le $current_date";
            header("location: modifier-exams.php?modifier=$id_exam");
        }
        else if ($rs3)
        {
            $_SESSION['message_exam'] = "Le professeur $prof_sup est déja assistant dans un autre exam en même heure";
            header("location: modifier-exams.php?modifier=$id_exam");
        }
        else if ($heure_fin - $heure_debut < 1)
        {
            $_SESSION['message_exam'] = "Au mois la durée d'un exam doit etre une heure ou plus";
            header("location: modifier-exams.php?modifier=$id_exam");
        }
        else if  (((strtotime($heure_fin) - strtotime($heure_debut) / 60) < 60) || $heure_debut == $heure_fin )
        {
            $_SESSION['message_exam'] = "Impossible de commencer un exam à $heure_debut et terminer à $heure_fin";
            header("location: modifier-exams.php?modifier=$id_exam");
        }
        else if (($heure_debut < "08:00") 
            || ($heure_fin > "18:00"))
        {
            $_SESSION['message_exam'] = "L'heure de l'exam doit etre entre 08:00 et 18:00";
            header("location: modifier-exams.php?modifier=$id_exam");
        }
        else if ($rs2 > 0)
        {
            $_SESSION['message_exam'] = "La salle est déja reservé le $date_exam a $heure_debut";
            header("location: modifier-exams.php?modifier=$id_exam");
        }
        else if ($rs4 < $rs5 )
        {
            // echo "le nombre des etudiant $rs4 depasse la capacité de la salle $rs5";
            // exit();
            $_SESSION['message_exam'] = "Le nombre des étudiants de cette filiere  dépasse la capacité de la salle";
            header("location: modifier-exams.php?modifier=$id_exam");
        } 
        else 
        {
        $sqlM = "UPDATE examen SET date_exam ='$date_exam' , mat_id= '$mat_id', prof_id= '$prof_id', salle_id= '$salle_id', 
        heure_debut= '$heure_debut', heure_fin= '$heure_fin' , type_exam= '$type_exam', prof_sup= '$prof_sup' where id_exam = '$id_exam' ";
        $connection -> query($sqlM) or die ($connection->error);

        header("location: listes-exams.php");
        }
        
        
    }
    if(isset($_GET['print']))
    {
        $id_exam = $_GET['print'];

        
        $res = $connection->query("SELECT e.id_exam , e.date_exam , m.nom_mat , e.mat_id, p.nom, s.num_salle, 
                            e.heure_debut, e.heure_fin , e.prof_sup, e.type_exam
                            from examen e , matiere m , professeurs p, salle s where e.mat_id = m.id_mat
                            AND e.prof_id = p.id_prof AND e.salle_id = s.id_salle") or die ($connection->error); 
        $row = $res->fetch_array();
        $date_exam = $row['date_exam'];
        $mat_id = $row['mat_id'];
        $nom = $row['nom'];  
        $num_salle = $row['num_salle'];            
        $heure_debut = $row['heure_debut'];
        $heure_fin = $row['heure_fin'];
        $prof_sup = $row['prof_sup'];
        $type_exam = $row['type_exam'];

        /* get salle type */
        $Query_get_salle_type = "SELECT s.type_salle from examen e , salle s WHERE e.salle_id = s.id_salle";
        $get_salle_type = mysqli_query($connection, $Query_get_salle_type);
        $salle_type = mysqli_fetch_array($get_salle_type);
        $salle_type = $salle_type['0'];

        /* get filiere */ 
        $Query_get_filiere = "SELECT f.nom_filiere FROM filieres f , matiere m WHERE f.id_fil = m.fil_id";
        $get_fil = mysqli_query($connection, $Query_get_filiere);
        $filiere = mysqli_fetch_array($get_fil);
        $filiere = $filiere['0'];

        /* get professeur */ 
        $Query_get_professeur = "SELECT  CONCAT(p.nom,' ',p.prenom) FROM professeurs p,  matiere m WHERE p.id_prof = m.prof_id";
        $get_prof = mysqli_query($connection, $Query_get_professeur);
        $prof_nom = mysqli_fetch_array($get_prof);
        $prof_nom = $prof_nom['0'];

        /* get matiere */ 
        $Query_get_matiere = "SELECT m.nom_mat FROM matiere m , examen e WHERE e.mat_id = m.id_mat";
        $get_matiere = mysqli_query($connection, $Query_get_matiere);
        $matiere_nom = mysqli_fetch_array($get_matiere);
        $matiere_nom = $matiere_nom['0'];
        
        $htmlContent = '<html>
        <head>
          <title>EXAM le '.$date_exam.' par Mr '.$prof_nom.'</title>
      
          <style>
                  .table-style {
                    border-collapse : collapse;  
                    width : 100%;
                  }
          </style>
        </head>
      
        <body>
              <div class="title" style="text-align:center">
                  <h3>PV des devoirs surveillés</h3>
              </div>
              <table class="table-style" border="1">
                 
                  <tbody>
                      <tr>
                          <td>Date</td>
                          <td> '.$date_exam.' à '.$heure_debut.' </td>
                          <td>Local</td>
                          <td>'.$salle_type.'  '.$num_salle.'</td>
                      </tr>
                      <tr>
                          <td>Filiere</td>
                          <td>'.$filiere.'</td>
                          <td>Matiere</td>
                          <td>'.$matiere_nom.'</td>
                          
                      </tr>
                      <tr>
                          <td>Enseignant</td>
                          <td>'.$prof_nom.'</td>
                          <td>Signature</td>
                          <td></td>
                          
                      </tr>
                  </tbody>
              </table>
              <br>
              <table class="table-style" border="1" >
                  <tbody>
                      <tr>
                          <td>Nombre Etudiants</td>
                          <td></td>
                          <td>Nombre des etudiants presents</td>
                          <td></td>
                          
                      </tr>
                      <tr>
                          <td>Nombre des etudiants absents</td>
                          <td></td>
                          <td>Nombre de copies rendues</td>
                          <td></td>
                          
                      </tr>
                      <tr>
                          <td colspan="4"> Liste des etudiants absents :
                              <br><br><br><br><br><br><br><br>
                          </td>
                          
                      </tr>
                      <tr>
                          <td colspan="4">  observations : 
                              <br><br><br><br><br><br><br><br>
                          </td>
                      </tr>
                      
                  </tbody>
              </table>
              <br>
              <table class="table-style" border="1">
                 
                  <tbody>
                      <tr>
                          <td >Surveillents administratifs</td>
                          <td >Signature</td>
                      </tr>
                      <tr>
                          <td >'.$prof_sup.'</td>
                          <td ><br></td>
                      </tr>
                      <tr>
                          <td ><br></td>
                          <td ><br></td>
                      </tr>
                  </tbody>
              </table>
        </body>
      </html>';
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($htmlContent);
        $mpdf->Output();
        
        // $mpdf = new \Mpdf\Mpdf();
        // $data = '<h3> id exam is :'. $id_exam.'</h3> <br>';
        // $data = '<h3> date exam is :'. $date_exam.'</h3>';
        // $mpdf->WriteHTML($data);
        // $mpdf->Output();
    }

?>