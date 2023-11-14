<?php 
         

    if (!isset($_SESSION)) session_start();
    // database connection
    $connection = new mysqli('mariadb', 'izail', 'izail1337', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter'])){
        $appogee = $_POST['appogee'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $fil_id = $_POST['id_fil'];

        /* check if appogge already exist */
        $check_appogee = "SELECT * from etudiant WHERE appogee ='$appogee' AND id_etud != '$id_etud'";
        $check_appogee_exist = mysqli_query($connection, $check_appogee);
        $res2 = mysqli_fetch_array($check_appogee_exist);
        $res2 = $res2[0];

        /* check if student already exist */
        $QueryCheck_etudiant = "SELECT id_etud from etudiant WHERE appogee ='$appogee' AND nom = '$nom' AND prenom = '$prenom' AND fil_id = '$fil_id'";
        $check_etduiant_exist = mysqli_query($connection, $QueryCheck_etudiant);
        $res1 = mysqli_fetch_array($check_etduiant_exist);
        $res1 = $res1[0];

        $checkNumber = "SELECT count(*) from etudiant";
        $check_number_of_student = mysqli_query($connection, $checkNumber);
        $res3 = mysqli_fetch_array($check_number_of_student);
        $res3 = $res3[0];

        if ($res2 && $res3 != 1)
        {
            $_SESSION['message_etudiant'] = "Numero d'appogee déja existant"; 
            header("location: ajouter-etudiants.php");
        }
        else if ($res1 && $res3 != 1)
        {
            $_SESSION['message_etudiant'] = "Etudiant déja existant"; 
            header("location: ajouter-etudiants.php");
        }
        else 
        {
            $sql = "INSERT INTO etudiant (appogee, nom, prenom , email , fil_id , role_id)
                VALUES ('$appogee', '$nom', '$prenom' , '$email' , (select id_fil from filieres where id_fil = '$fil_id') , 2);";
            mysqli_query($connection, $sql); 
            header("location: listes-etudiants.php");
            $_SESSION['message_a'] = "Etudiant bien ajouté"; 
        }
        
        
    }
    
    // suppresion
    if(isset($_GET['supprimer'])){
        $id_etud = $_GET['supprimer'];
        $sqlS = "DELETE from etudiant where id_etud = $id_etud" ;
        mysqli_query($connection,$sqlS);

        $_SESSION['message_s'] = "Etudiant bien supprimé";
        $_SESSION['msg_type'] = "danger";

        header("location: listes-etudiants.php");
    }

    // modification get
    if(isset($_GET['modifier'])){
        $id_etud = $_GET['modifier'];
        $res = $connection->query("SELECT * from etudiant e, filieres f where e.id_etud = $id_etud") or die ($connection->error); 
            $row = $res->fetch_array();
            $appogee = $row['appogee'];
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email']; 
            $nom_fil = $row['nom_filiere'];
    }
    // modification post
    if(isset($_POST['update'])){
        $id_etud = $_POST['id_etud'];
        $fil_id = $_POST['id_fil'];
        $appogee = $_POST['appogee'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];

        /* check if appogge already exist */
        $check_appogee = "SELECT id_etud from etudiant WHERE appogee ='$appogee'";
        $check_appogee_exist = mysqli_query($connection, $check_appogee);
        $res2 = mysqli_fetch_array($check_appogee_exist);
        $res2 = $res2[0];

        $QueryCheck_etudiant = "SELECT id_etud from etudiant WHERE nom = '$nom' AND prenom = '$prenom' AND email = '$email' AND fil_id = '$fil_id'";
        $check_etduiant_exist = mysqli_query($connection, $QueryCheck_etudiant);
        $res1 = mysqli_fetch_array($check_etduiant_exist);
        $res1 = $res1[0];

        $checkNumber = "SELECT count(*) from etudiant";
        $check_number_of_student = mysqli_query($connection, $checkNumber);
        $res3 = mysqli_fetch_array($check_number_of_student);
        $res3 = $res3[0]; 

        if ($res2 && $res3 != 1)
        {
            $_SESSION['message_etudiant'] = "Vous avez tapez un numero d'appogee d'un étudiant déja existant"; 
            header("location: modifier-etudiants.php?modifier=$id_etud");
        }
        else if ($res1 && $res3 != 1)
        {
            $_SESSION['message_etudiant'] = "Vous avez tapez des informations d'un étudiant déja existant"; 
            header("location: modifier-etudiants.php?modifier=$id_etud");
        }
        else {
            $sqlM = "UPDATE etudiant SET nom ='$nom' , prenom= '$prenom' , email='$email' , fil_id = '$fil_id' 
                         where id_etud = '$id_etud'";
            $connection -> query($sqlM) or die ($connection->error);

            header("location: listes-etudiants.php");
        }
        

    }

    // // affichage note tableau
    // if(isset($_GET['afficher'])){
    //     $id_etud = $_GET['afficher'];
    //     $res = $connection->query("SELECT * from etudiant where id_etud = $id_etud") or die ($connection->error); 
    //         $row = $res->fetch_array();
    //         $nom = $row['nom'];
    //         $prenom = $row['prenom'];
    //         $email = $row['email'];
    //         $filiere = $row['filiere'];
    // }

    // // GET in ajouter note 
    // if(isset($_GET['display'])){
    //     $id_etud = $_GET['display'];
    //     $res = $connection->query("SELECT * from etudiant where id_etud = $id_etud") or die ($connection->error); 
    //         $row = $res->fetch_array();
    //         $nom = $row['nom'];
    //         $prenom = $row['prenom'];
    //         $email = $row['email'];
    //         $filiere = $row['filiere'];
    // }
    
   

    // // ajoute d'une note
    // if(isset($_POST['ajouter-n'])){
        
    //      $count = count($_POST['id_etud']);


    //     for($i=0 ; $i <$count ; $i++){
    //         $sqlN = "INSERT INTO note (id_etud , id_mat ,noteMat)
    //            values ('";
    //            $sqlN .= $_POST['id_etud'][$i] . "' , '";
    //            $sqlN .= $_POST['id_mat'][$i] . "' , '";
    //            $sqlN .= $_POST['noteMat'][$i] . "')";

    //         $connection -> query($sqlN) or die ($connection->error);

    //         header("location: listes-notes.php?afficher=$id_etud[$i]"); break;

    //         continue;
    //     }
        
        
    //     //$_SESSION['message_a'] = "Note bien ajouté"; 
        
        
    // }

    
    ?>
