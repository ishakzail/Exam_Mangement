<?php
        session_start();
        if(count($_POST)>0) {
            $connection = mysqli_connect("localhost" , "root" , "","gestion_etudiants");
        
        
            $result = mysqli_query($connection ,"select * from etudiant where email = '".$_POST["email"]."' and motdepass = '".$_POST["motdepass"]."' ")
                or die ("Failed to query database");
        
            $row = mysqli_fetch_array($result);
                if(is_array($row)){
                $_SESSION["id_etud"] = $row['id_etud'];
                $_SESSION["email"] = $row['email'];

                }else {
                    $message = "Invalid Email or Password !";
                }
        }
        if(isset($_SESSION["id_etud"])){
            echo "<script>window.open('notes/listes-notes.php','_self')</script>";  
        }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LOGIN ETUDIANT</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                
                    <div class="col-lg-7">
                        <form method="POST" action="">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">ETUDIANT PANEL</h1>
                                </div>
                                <form class="user">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="email" name="email"
                                                placeholder="Email">
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="motdepass"
                                                id="motdepass" placeholder="Password">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" >
                                                    Se connecter
                                            </input>
                                        </div>
                                    </div>
                                    <hr>
                                    
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    
</body>
    
</html>