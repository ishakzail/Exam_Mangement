<?php 

    if (!isset($_SESSION)) session_start();
    // database connection
    $connection = new mysqli('mariadb', 'izail', 'izail1337', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter']))
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $sql = "INSERT INTO professeurs  (nom, prenom, email ) 
            VALUES ('$nom' , '$prenom', '$email');";

        /* check if professor already exist */
        $Check_professor = "SELECT id_prof from professeurs WHERE nom = '$nom' AND prenom = '$prenom' AND email = '$email'";
        $check_professor_exist = mysqli_query($connection, $Check_professor);
        $res1 = mysqli_fetch_array($check_professor_exist);
        $res1 = $res1[0];

        if ($res1)
        {
            $_SESSION['message_professeur'] = "Professeur déja existant"; 
            header("location: ajouter-professeur.php");
        }
        else 
        {
            mysqli_query($connection, $sql); 
            header("location: listes-professeurs.php");
            $_SESSION['message_professeur'] = "Professeur bien ajouté"; 
        }
        
    }
    
    // suppresion
    if(isset($_GET['supprimer']))
    {
        $id_prof = $_GET['supprimer'];
        $sqlS = "DELETE from professeurs where id_prof = $id_prof" ;
        mysqli_query($connection,$sqlS);

        $_SESSION['message_s'] = "professeur est bien supprimé";
        $_SESSION['msg_type'] = "danger";

        header("location: listes-professeurs.php");
    }

    // modification get
    if(isset($_GET['modifier']))
    {
        $id_prof = $_GET['modifier'];
        $res = $connection->query("SELECT * from professeurs WHERE id_prof = $id_prof") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email'];

    }

    // modification post
    if(isset($_POST['update']))
    {
        $id_prof = $_POST['id_prof'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        

        /* check if professor already exist */
        $Check_professor = "SELECT id_prof from professeurs WHERE nom = '$nom' AND prenom = '$prenom' AND email = '$email'";
        $check_professor_exist = mysqli_query($connection, $Check_professor);
        $res1 = mysqli_fetch_array($check_professor_exist);
        $res1 = $res1[0];

        if ($res1)
        {
            $_SESSION['message_professeur'] = "Vous avez tapez des informations d'un professeur déja existant"; 
            header("location: modifier-professeurs.php?modifier=$id_prof");
        }
        else 
        {
            $sqlM = "UPDATE professeurs SET nom ='$nom' , prenom = '$prenom' , email = '$email' where id_prof = '$id_prof'";
            $connection -> query($sqlM) or die ($connection->error);
            header("location: listes-professeurs.php");
        }

        
    }

    // affichage filieres tableau
    if(isset($_GET['afficher'])){
        $id_prof = $_GET['afficher'];
        $res = $connection->query("SELECT * from professeurs where id_prof = $id_prof") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email'];
        }

    // ajouter filiere "GET"
    if(isset($_GET['ajouter_fil'])){
        $id_prof = $_GET['ajouter_fil'];
        $res = $connection->query("SELECT * from professeurs where id_prof = $id_prof") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email'];
    }
    
    // ajoute d'une filiere "POST"
    if(isset($_POST['ajouter_f'])){
        $fil_id = $_POST['id_fil'];
        $prof_id = $_POST['prof_id'];
        $sqlN ="INSERT INTO professeurs_filieres  (prof_id, fil_id) 
            VALUES ('$prof_id' , '$fil_id');";
        $connection -> query($sqlN) or die ($connection->error);
        header("location: listes-filieres.php?afficher=$prof_id");  
    }


    // suppresion d'es filieres d'un prof
    if(isset($_GET['supprimer_f']))
    {
        $prof_id = $_GET['supprimer_f'];
        $fil_id = $_GET['fil_id'];
        $sqlS = "DELETE  from professeurs_filieres where  prof_id = $prof_id AND fil_id = $fil_id";
        mysqli_query($connection,$sqlS);

        $_SESSION['message_s'] = "filiere est bien supprimé";
        $_SESSION['msg_type'] = "danger";

        header("location: listes-filieres.php?afficher=$prof_id");
    }
?>
