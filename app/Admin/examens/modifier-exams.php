<?php 
    session_start();
    if(!$_SESSION['email']){
        header("location : login.php");
    }
    require_once 'process-exam.php';
?>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification de de l'examen <?php echo $id_exam; ?></h6>
                        </div>
                        <br>
                    <form class="user" style="margin-left : 35% "; method="POST" action="process-exam.php">
                        <?php  
                            
                            if(isset($_SESSION['message_exam'])){ ?>
                            <div class="alert alert-danger" style = "margin-left : -50%">  
                                <?php  
                                    echo $_SESSION['message_exam'];
                                    unset($_SESSION['message_exam']);
                                ?> 
                            </div>
                        <?php } ?>
                        <input type="hidden" name="id_exam" value="<?php echo $id_exam; ?>" >
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <?php
                                    $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                                    $sql = "SELECT * from matiere ";
                                    $res = mysqli_query($connection, $sql);
                                
                                ?>
                                <select name="id_mat" class="custom-select custom-select-sm form-control form-control-sm">
                                <?php  while($row = mysqli_fetch_array($res)){ ?>
                                    <option value="<?php echo $row['id_mat'] ?>"><?php echo $row['nom_mat']; ?> </option>   
                                <?php } ?>
                                
                                </select>
                            </div> 
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <?php
                                $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                                $sql = "SELECT * from professeurs";
                                $res = mysqli_query($connection, $sql);
                            
                            ?>
                            <select class="custom-select custom-select-sm form-control form-control-sm" name="id_prof">
                            <?php  while($row = mysqli_fetch_array($res)){ ?>
                                <option value="<?php echo $row['id_prof'] ?>"><?php echo $row['nom']; ?> </option>   
                            <?php } ?>
                            
                            </select>
                            
                            </div> 
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <?php
                                $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                                $sql = "SELECT * from  salle";
                                $res = mysqli_query($connection, $sql);
                            
                            ?>
                            <select class="custom-select custom-select-sm form-control form-control-sm" name="id_salle">
                            <?php  while($row = mysqli_fetch_array($res)){ ?>
                                <option value="<?php echo $row['id_salle'] ?>"><?php echo $row['num_salle']; ?> </option>   
                            <?php } ?>
                            
                            </select>
                            
                            </div> 
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="date" class="form-control form-control-user" name="date_exam"
                                value="<?php echo $date_exam; ?>"  id="date_exam" placeholder="Date">
                            </div>    
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="time" class="form-control form-control-user" name="heure_debut"
                                value="<?php echo $heure_debut; ?>" id="heure_debut" placeholder="Heure de début">
                            </div>    
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="time" class="form-control form-control-user" name="heure_fin"
                                value="<?php echo $heure_fin; ?>" id="heure_fin" placeholder="Heure de fin">
                            </div>    
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" name="prof_sup"
                                value="<?php echo $prof_sup; ?>"  id="prof_sup" placeholder="Professeur Assistant">
                            </div>    
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" name="type_exam"
                                value="<?php echo $type_exam; ?>" id="type_exam" placeholder="Type Exam">
                            </div>    
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <button type="submit"  name="update" class="btn btn-primary btn-user btn-block">
                                Modifier 
                                </button>
                            </div>    
                        </div>
                        
                               
                    </form>
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

   


</body>
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

    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/datatables-demo.js"></script>

   
