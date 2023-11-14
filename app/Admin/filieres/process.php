<?php 

    if (!isset($_SESSION)) session_start();
    // database connection
    $connection = new mysqli('mariadb', 'izail', 'izail1337', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $nom_filiere = "";
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter']))
    {
        $nom_filiere = $_POST['nom_filiere'];
        $dept_id = $_POST['id_dept'];
        $sql = "INSERT INTO filieres  (nom_filiere, dept_id ) 
            VALUES ('$nom_filiere' , (select id_dept from departements where id_dept = '$dept_id'));";

        /* check if professor already exist */
        $check_section = "SELECT id_fil from filieres WHERE nom_filiere = '$nom_filiere' AND dept_id = '$dept_id'";
        $check_section_exist = mysqli_query($connection, $check_section);
        $res1 = mysqli_fetch_array($check_section_exist);
        $res1 = $res1[0];

        if ($res1)
        {
            $_SESSION['message_filiere'] = "Filiere déja existant"; 
            header("location: ajouter-filiere.php");
        }
        else 
        {
            mysqli_query($connection, $sql); 
            header("location: listes-filieres.php");
            $_SESSION['message_filiere'] = "Filiere bien ajouté"; 
        }
        
    }
    
    // suppresion
    if(isset($_GET['supprimer']))
    {
        $id_fil = $_GET['supprimer'];
        

        /* check if a section belongs to a subject */
        $Query_check_fil_mat = "SELECT count(*) from matiere m , filieres f WHERE m.fil_id = $id_fil AND m.fil_id = f.id_fil ";
        $check_fileiere_belongs_mat = mysqli_query($connection, $Query_check_fil_mat);
        if ($check_fileiere_belongs_mat) {
            $res2_array = mysqli_fetch_array($check_fileiere_belongs_mat);
        
            // Check if the result is not empty before accessing its elements
            if (!empty($res2_array)) {
                $res2 = $res2_array[0];
            }
            else $res2 = null;
        } 
        else {
            $res2 = null;
        }

        /* check if a section has a student */
        $checkSectionStudent = "SELECT count(*) from etudiant e , filieres f WHERE e.fil_id = $id_fil AND e.fil_id = f.id_fil ";
        $check_Section_student = mysqli_query($connection, $checkSectionStudent);
        $res3 = mysqli_fetch_array($check_Section_student);
        $res3 = $res3[0];

        /* check if a section has a professor */
        $checkSectionprofessor = "SELECT count(*) from professeurs_filieres WHERE fil_id = $id_fil";
        $check_Section_professor = mysqli_query($connection, $checkSectionprofessor);
        $res4 = mysqli_fetch_array($check_Section_professor);
        $res4 = $res4[0];
        
        if ($res4)
        {
            $_SESSION['message_s'] = "Impossible de supprimer cette filiere car elle contient au moin un professeur"; 
            header("location: listes-filieres.php");
        }
        else if ($res3)
        {
            $_SESSION['message_s'] = "Impossible de supprimer cette filiere car elle contient au moin un etudiant "; 
            header("location: listes-filieres.php");
        }
        else if ($res2)
        {
            $_SESSION['message_s'] = "Cette filiere contient au moins une matiere, il faut la supprimer "; 
            header("location: listes-filieres.php");
        }
        else 
        {
            $sqlS = "DELETE from filieres where id_fil = $id_fil" ;
            mysqli_query($connection,$sqlS);
            $_SESSION['message_s'] = "filiere est bien supprimé";

            header("location: listes-filieres.php");
        }

        
    }

    // modification get
    if(isset($_GET['modifier']))
    {
        $id_fil = $_GET['modifier'];
        $res = $connection->query("SELECT f.id_fil , f.nom_filiere ,f.dept_id,  d.nom_dept from filieres f , departements d where f.id_fil = $id_fil") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom_filiere = $row['nom_filiere'];
            $dept_id = $row['dept_id'];
    }

    // modification post
    if(isset($_POST['update']))
    {
        $id_fil = $_POST['id_fil'];
        $nom_filiere = $_POST['nom_filiere'];
        $dept_id = $_POST['id_dept'];

        $sqlM = "UPDATE filieres SET nom_filiere ='$nom_filiere' , dept_id = '$dept_id' where id_fil = '$id_fil'";
        $connection -> query($sqlM) or die ($connection->error);

        header("location: listes-filieres.php");
    }

    
?>
