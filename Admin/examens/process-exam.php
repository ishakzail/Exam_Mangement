<?php 
         

    // database connection
    $connection = new mysqli('localhost', 'root', '', 'gestion_etudiants')or die(mysqli_error($mysqli));
    
    
    // ajoute
    if(isset($_POST['ajouter-e'])){
        $date_exam = $_POST['date_exam'];
        $mat_id = $_POST['id_mat'];
        $sql = "INSERT INTO examen  (date_exam, mat_id ) VALUES ('$date_exam' , (select id_mat from matiere where id_mat = '$mat_id'));";
        mysqli_query($connection, $sql);   
            header("location: listes-exams.php");
    }
    
    // suppresion
    if(isset($_GET['supprimer'])){
        $id_exam = $_GET['supprimer'];
        $sqlS = "DELETE from examen where id_exam = $id_exam" ;
        mysqli_query($connection,$sqlS);

        header("location: listes-exams.php");
    }

    // modification get
    if(isset($_GET['modifier'])){
        $id_exam = $_GET['modifier'];
        $res = $connection->query("SELECT e.id_exam , m.nom_mat , e.date_exam , e.mat_id from examen e , matiere m where e.id_exam = $id_exam") or die ($connection->error); 
            $row = $res->fetch_array();
            $date_exam = $row['date_exam'];
            $mat_id = $row['mat_id'];
    }
    // modification post
    if(isset($_POST['update'])){
        $id_exam = $_POST['id_exam'];
        $date_exam = $_POST['date_exam'];
        $mat_id = $_POST['id_mat'];
        
        $sqlM = "UPDATE examen SET date_exam ='$date_exam' , mat_id= '$mat_id' where id_exam = '$id_exam'";
        $connection -> query($sqlM) or die ($connection->error);

        header("location: listes-exams.php");

    }


    ?>