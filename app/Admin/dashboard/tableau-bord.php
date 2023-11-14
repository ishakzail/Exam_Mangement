<?php
    if(!isset($_SESSION)){
        session_start();
    }else{
        session_destroy();
        session_start(); 
    }
    if(!$_SESSION['email']){
        header("location : login.php");
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

    <title>Tableau de bord - ADMIN</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
      <?php  include("../side-bar.php"); ?>
         
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php  include("../navbar.php"); ?>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                        Tableau de bord 
                    <!-- Content Row -->
                    <div class="row">
                        <?php 
                            $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                            
                            $sql1 = "SELECT count(*) as nbEtud from etudiant";
                            $res = mysqli_query($connection, $sql1); 
                            $nb = $res->fetch_assoc();
                            
                        ?>
                        <!-- carte Etudiants -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Nombre des Etudiantes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nb['nbEtud']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- carte Professeurs -->
                        <?php 
                            $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                            
                            $sql1 = "SELECT count(*) as nbProf from professeurs";
                            $res = mysqli_query($connection, $sql1); 
                            $nb = $res->fetch_assoc();
                            
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Nombre de professeurs</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nb['nbProf']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- carte Professeurs -->
                        <?php 
                            $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                            
                            $sql1 = "SELECT count(*) as nbFil from filieres";
                            $res = mysqli_query($connection, $sql1); 
                            $nb = $res->fetch_assoc();
                            
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               Nombre de filieres</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nb['nbFil']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-school fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- carte Departement -->
                        <?php 
                            $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                            
                            $sql1 = "SELECT count(*) as nbDept from departements";
                            $res = mysqli_query($connection, $sql1); 
                            $nb = $res->fetch_assoc();
                            
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               Nombre de departements</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nb['nbDept']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-school fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- carte Salle -->
                        <?php 
                            $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                            
                            $sql1 = "SELECT count(*) as nbSalle from salle";
                            $res = mysqli_query($connection, $sql1); 
                            $nb = $res->fetch_assoc();
                            
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               Nombre de salles</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nb['nbSalle']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- carte 2 -->
                        <?php 
                            $sql2 = "SELECT count(*) as nbMat from matiere";
                            $res = mysqli_query($connection, $sql2); 
                            $nb = $res->fetch_assoc(); 
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Nombre des Matières</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nb['nbMat']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- carte 3 -->
                        <?php 
                            $sql3 = "SELECT count(*) as nbExam from examen";
                            $res = mysqli_query($connection, $sql3); 
                            $nb = $res->fetch_assoc(); 
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Nombre des Examens</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nb['nbExam']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.container-fluid -->
                   
            </div>
            <!-- End of Main Content -->

           

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    
    <?php  include("../logout_modal.php"); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>


</body>

</html>