<?php 
         
    if (!isset($_SESSION)) session_start();
    // database connection
    $connection = new mysqli('mariadb', 'izail', 'izail1337', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $nom_mat = "";
    $semestre = "";
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter'])){
        $nom_mat = $_POST['nom_mat'];
        $semestre = $_POST['semestre'];
        $fil_id = $_POST['id_fil'];
        $prof_id = $_POST['id_prof'];
        $sql = "INSERT INTO matiere  (nom_mat, semestre, fil_id, prof_id ) VALUES ('$nom_mat' , '$semestre' , (select id_fil from filieres where id_fil = '$fil_id'), (select id_prof from professeurs where id_prof = '$prof_id'));";

        /* check if subject already exist */
        $check_subject = "SELECT id_mat from matiere WHERE nom_mat = '$nom_mat' AND fil_id = '$fil_id' AND prof_id = '$prof_id' AND semestre ='$semestre'";
        $check_subject_exist = mysqli_query($connection, $check_subject);
        if ($check_subject_exist && mysqli_num_rows($check_subject_exist) > 0) {
            $res1 = mysqli_fetch_array($check_subject_exist);
            $res1 = $res1[0];
        } else {
            $res1 = null;
        }
        // $res1 = mysqli_fetch_array($check_subject_exist);
        // $res1 = $res1[0];

        /* check if subject is valid */
        $check_section = "SELECT * from professeurs_filieres WHERE prof_id = '$prof_id' AND fil_id = '$fil_id'";
        $check_section_exist = mysqli_query($connection, $check_section);
        $res2 = mysqli_fetch_array($check_section_exist);
        $res2 = $res2[0];


        if (!$res2)
        {
            $_SESSION['message_matiere'] = "Ce professeur n'enseigne pas cette filiere"; 
            header("location: ajouter-matiere.php");
        }
        else if ($res1)
        {
            $_SESSION['message_matiere'] = "Matiere déja existant"; 
            header("location: ajouter-matiere.php");
        }
        else 
        {
            mysqli_query($connection, $sql);     
            header("location: listes-matieres.php");
            $_SESSION['message_filiere'] = "Matiere Bien Ajouté";  
        }
    }
    
    // suppresion
    if(isset($_GET['supprimer'])){
        $id_mat = $_GET['supprimer'];
        $sqlS = "DELETE from matiere where id_mat = $id_mat" ;
        mysqli_query($connection,$sqlS);
        header("location: listes-matieres.php");
    }

    // modification get
    if(isset($_GET['modifier'])){
        $id_mat = $_GET['modifier'];
        $res = $connection->query("SELECT * from matiere where id_mat = $id_mat") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom_mat = $row['nom_mat'];
            $semestre = $row['semestre'];
    }
    
    // modification post
    if(isset($_POST['update'])){
        $id_mat = $_POST['id_mat'];
        $nom_mat = $_POST['nom_mat'];
        $semestre = $_POST['semestre'];
        $fil_id = $_POST['id_fil'];
        $prof_id = $_POST['id_prof'];
        $sqlM = "UPDATE matiere SET nom_mat ='$nom_mat' , semestre= '$semestre', fil_id = '$fil_id' , prof_id = '$prof_id' where id_mat = '$id_mat'";

        /* check if subject already exist */
        $check_subject = "SELECT id_mat from matieres WHERE nom_mat = '$nom_mat' AND fil_id = '$fil_id' AND prof_id = '$prof_id' AND semestre ='$semestre'";
        $check_subject_exist = mysqli_query($connection, $check_subject);
        $res1 = mysqli_fetch_array($check_subject_exist);
        $res1 = $res1[0];

        /* check if subject is valid */
        $check_section = "SELECT * from professeurs_filieres WHERE prof_id = '$prof_id' AND fil_id = '$fil_id'";
        $check_section_exist = mysqli_query($connection, $check_section);
        $res2 = mysqli_fetch_array($check_section_exist);
        $res2 = $res2[0];

        // if (!is_int($semestre))
        // {
        //     $_SESSION['message_matiere'] = "Semestre doit etre en entier"; 
        //     header("location: ajouter-matiere.php");
        // }
        // else 
        if (!$res2)
        {
            $_SESSION['message_matiere'] = "Ce professeur n'enseigne  pas cette filiere"; 
            header("location: modifier-matieres.php?modifier=$id_mat");
        }
        else if ($res1)
        {
            $_SESSION['message_matiere'] = "Matiere déja existant"; 
            header("location: modifier-matieres.php?modifier=$id_mat");
        }
        else 
        {
            $connection -> query($sqlM) or die ($connection->error);
            header("location: listes-matieres.php");
        }
    }
?>
