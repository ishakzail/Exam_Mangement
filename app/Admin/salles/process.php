<?php 
    // database connection
    $connection = new mysqli('mariadb', 'izail', 'izail1337', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter']))
    {
        $num_salle = $_POST['num_salle'];
        $type_salle = $_POST['type_salle'];
        $capacite = $_POST['capacite'];

        $sql = "INSERT INTO salle (num_salle, type_salle, capacite)
                VALUES ('$num_salle','$type_salle', '$capacite');";

        mysqli_query($connection, $sql); 
        header("location: listes-salles.php");
        $_SESSION['message_a'] = "Salle bien ajouté"; 
        
    }
    
    // suppresion
    if(isset($_GET['supprimer']))
    {
        $id_salle = $_GET['supprimer'];
        $sqlS = "DELETE from salle where id_salle = $id_salle" ;
        mysqli_query($connection,$sqlS);

        $_SESSION['message_s'] = "salle est bien supprimé";
        $_SESSION['msg_type'] = "danger";

        header("location: listes-salles.php");
    }

    // modification get
    if(isset($_GET['modifier']))
    {
        $id_salle = $_GET['modifier'];
        $res = $connection->query("SELECT * from salle where id_salle = $id_salle") or die ($connection->error); 
            $row = $res->fetch_array();
            $num_salle = $row['num_salle'];
            $type_salle = $row['type_salle'];
            $capacite = $row['capacite'];
    }

    // modification post
    if(isset($_POST['update']))
    {
        $id_salle = $_POST['id_salle'];
        $num_salle = $_POST['num_salle'];
        $type_salle = $_POST['type_salle'];
        $capacite = $_POST['capacite'];
        $sqlM = "UPDATE salle SET num_salle ='$num_salle' , type_salle ='$type_salle' ,  capacite ='$capacite'
        where id_salle = '$id_salle'";
        $connection -> query($sqlM) or die ($connection->error);

        header("location: listes-salles.php");
    }
    
?>
