<?php 
         

    // database connection
    $connection = new mysqli('localhost', 'root', '', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $nom_mat = "";
    $date = "";
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter'])){
        $date = date("Y-m-d");
        $count = count($_POST['id_mat']);
            for($i = 0 ; $i< $count ; $i++){
                $sql = "INSERT INTO matiere  (date, $mat_id ) VALUES ('$date' , '$mat_id');";
                mysqli_query($connection, $sql) or die (mysqli_error($mysqli));      
            }
        
        header("location: listes-exams.php");
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
        
        $sqlM = "UPDATE matiere SET nom_mat ='$nom_mat' , semestre= '$semestre' where id_mat = '$id_mat'";
        $connection -> query($sqlM) or die ($connection->error);

        header("location: listes-matieres.php");

    }


    
    ?>
