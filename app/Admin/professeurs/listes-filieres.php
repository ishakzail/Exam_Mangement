<?php 
    session_start(); 
    if(!$_SESSION['email']){
        header("location : login.php");
    }
    require_once 'process.php';

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

                <!-- Page Heading -->
                    <a href="ajouter-filiere.php?ajouter_fil=<?php echo $id_prof; ?>"  class="btn btn-primary" style="margin-left : 1%;">Ajouter une filiere</a>
                    <br><br>
                    <?php  
                        
                        if(isset($_SESSION['message_s'])){ ?>
                        <div class="alert alert-danger" style ="float : right;">  
                            <?php  
                                echo $_SESSION['message_s'];
                                unset($_SESSION['message_s']);
                            ?> 
                        </div>
                    <?php } ?>

                <!-- Requete -->
                <?php 
                    $connection = mysqli_connect('mariadb', 'izail', 'izail1337', 'gestion_etudiants');
                    $sql = "SELECT f.nom_filiere , pf.prof_id , pf.fil_id FROM professeurs_filieres pf , professeurs p , filieres f WHERE pf.prof_id =$id_prof  AND f.id_fil = pf.fil_id AND pf.prof_id = p.id_prof;";
                    $res = mysqli_query($connection, $sql);
                    $res_num_row = mysqli_num_rows($res);
                ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tableau des filieres du professeur <?php echo $nom. " " .$prenom; ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nom Filiere</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nom Filiere</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>                                     
                                    <tbody> 
                                        <?php
                                        while($row = mysqli_fetch_array($res)){ ?>
                                            <tr>
                                                
                                                <td><?php echo $row[0]; ?> </td>                                               
                                                <td> 
                                                    
                                                    <a href="process.php?supprimer_f=<?php echo $row[1]; ?>&fil_id=<?php echo $row[2]; ?>"
                                                        class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            
                                    <?php }  ?>
                                    </tbody>
                                </table>
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



