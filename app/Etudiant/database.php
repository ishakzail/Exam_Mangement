<?php 

    $email = $_POST['email'];
    $motdepass = $_POST['motdepass'];

    $connection = mysqli_connect("localhost" , "root" , "","gestion_etudiants");


    $result = mysqli_query($connection ,"select * from etudiant where email = '$email' and motdepass = '$motdepass' ")
        or die ("Failed to query database");

    $row = mysqli_fetch_array($result);

    if($row['email'] == $email && $row['motdepass'] == $motdepass){
        header("location : tableau-bord");
    }else {
        echo "Information does not match";
    }

    mysqli_close($connection);

?>