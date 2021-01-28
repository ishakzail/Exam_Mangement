<?php 
         

    // database connection
    $connection = new mysqli('localhost', 'root', '', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $nom = "";
    $prenom = "";
    $filiere = "";
    $email = "";
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter'])){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $motdepass = $_POST['motdepass'];
        $filiere = $_POST['filiere'];
        $hash_pass = password_hash($motdepass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO etudiant (nom, prenom , email , motdepass , filiere , role_id)
                VALUES ('$nom', '$prenom' , '$email' , '$hash_pass' , '$filiere' , 2);";

        mysqli_query($connection, $sql); 
        $_SESSION['message_a'] = "Etudiants bien ajouté"; 
        
        header("location: listes-etudiants.php");
    }
    
    // suppresion
    if(isset($_GET['supprimer'])){
        $id_etud = $_GET['supprimer'];
        $sqlS = "DELETE from etudiant where id_etud = $id_etud" ;
        mysqli_query($connection,$sqlS);

        $_SESSION['message_s'] = "Etudiant est bien supprimé";
        $_SESSION['msg_type'] = "danger";

        header("location: listes-etudiants.php");
    }

    // modification get
    if(isset($_GET['modifier'])){
        $id_etud = $_GET['modifier'];
        $res = $connection->query("SELECT * from etudiant where id_etud = $id_etud") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email'];
            $filiere = $row['filiere'];
    }
    // modification post
    if(isset($_POST['update'])){
        $id_etud = $_POST['id_etud'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $motdepass = $_POST['motdepass'];
        $filiere = $_POST['filiere'];
        $hash_pass = password_hash($motdepass, PASSWORD_DEFAULT);

        $sqlM = "UPDATE etudiant SET nom ='$nom' , prenom= '$prenom' , email='$email' , filiere = '$filiere' 
        ,motdepass = '$hash_pass' where id_etud = '$id_etud'";
        $connection -> query($sqlM) or die ($connection->error);

        header("location: listes-etudiants.php");

    }


    
    ?>
