<?php 
    
    if (!isset($_SESSION)) session_start();
    // database connection
    $connection = new mysqli('mariadb', 'izail', 'izail1337', 'gestion_etudiants') or die(mysqli_error($mysqli));
    
    $nom_dept = "";
    $update = false ;

    // ajoute
    if(isset($_POST['ajouter']))
    {
        $nom_dept = $_POST['nom_dept'];

        /* check if deprtment already exist */
        $QueryCheck_departement = "SELECT id_dept from departements WHERE nom_dept = '$nom_dept' ";
        $check_departement_exist = mysqli_query($connection, $QueryCheck_departement);
        $res1 = mysqli_fetch_array($check_departement_exist);
        $res1 = $res1[0];

        
        if ($res1)
        {
            $_SESSION['message_departement'] = "departement déja existant"; 
            header("location: ajouter-departement.php");
        }
        else 
        {
            $sql = "INSERT INTO departements (nom_dept)
                    VALUES ('$nom_dept');";

            mysqli_query($connection, $sql); 
            header("location: listes-departements.php");
            $_SESSION['message_a'] = "Département bien ajouté"; 
        }
    }
    
    // suppresion
    if(isset($_GET['supprimer']))
    {
        $id_dept = $_GET['supprimer'];

        /* check if deprtment belongs to a section */
        $QueryCheck_departement_fil = "SELECT count(*) from departements d , filieres f WHERE f.dept_id = $id_dept AND f.dept_id = d.id_dept ";
        $check_departement_belongs_fil = mysqli_query($connection, $QueryCheck_departement_fil);
        $res2 = mysqli_fetch_array($check_departement_belongs_fil);
        $res2 = $res2[0];

        if ($res2)
        {
            $_SESSION['message_s'] = "Ce departement contient au moins une filiere, il faut la supprimer "; 
            header("location: listes-departements.php");
        }
        else 
        {
            $sqlS = "DELETE from departements where id_dept = $id_dept" ;
            mysqli_query($connection,$sqlS);
            $_SESSION['message_s'] = "Departement  bien supprimé";
            header("location: listes-departements.php");
        }
    }

    // modification get
    if(isset($_GET['modifier']))
    {
        $id_dept = $_GET['modifier'];
        $res = $connection->query("SELECT * from departements where id_dept = $id_dept") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom_dept = $row['nom_dept'];
    }

    // modification post
    if(isset($_POST['update']))
    {
        $id_dept = $_POST['id_dept'];
        $nom_dept = $_POST['nom_dept'];
        $sqlM = "UPDATE departements SET nom_dept ='$nom_dept'
        where id_dept = '$id_dept'";
        $connection -> query($sqlM) or die ($connection->error);

        header("location: listes-departements.php");
    }

    // affichage note tableau
    if(isset($_GET['afficher']))
    {
        $id_dept = $_GET['afficher'];
        $res = $connection->query("SELECT * from departement where id_dept = $id_dept") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom_dept = $row['nom_dept'];
    }

    // GET in ajouter note 
    if(isset($_GET['display']))
    {
        $id_dept = $_GET['display'];
        $res = $connection->query("SELECT * from departements where id_dept = $id_dept") or die ($connection->error); 
            $row = $res->fetch_array();
            $nom_dept = $row['nom_dept'];
    }
    
?>
