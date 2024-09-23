<?php
include('connection.php');
checkPrivilege('Dashboard');


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> OGB GARAGE</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/icon1.png" rel="icon">
  <link href="assets/img/icon1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


</head>

<body>

<?php  
include("./includes/header.php");
include("./includes/menu.php");
?>



  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

            

                <div class="card-body">
                  <h5 class="card-title">Messages <span>| </span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-envelope"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        
                      <?php
                      $total = 0;
                      $t = 0;
                      
                      $qp = "select * from product";
                      $rp = mysqli_query($connection, $qp);
                      $mump = mysqli_num_rows($rp);
                      
                      
                      $query = "select count(id) from contact_messages";
                      $result = mysqli_query($connection, $query);
                      $num = mysqli_num_rows($result);
                      if ($num > 0) {
                      
                        while ($row = mysqli_fetch_array($result)) {
                      
                        //  echo formatMoney($total = $total + $row["0"]);
                         
                        echo  $row["0"];
                        }
                      }

                      ?>
                       messages
                      </h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

               

                <div class="card-body">
                  <h5 class="card-title">Stock  <span>| value</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                      <?php
                      $total = 0;
                      $t = 0;
                      
                      $qp = "select * from product";
                      $rp = mysqli_query($connection, $qp);
                      $mump = mysqli_num_rows($rp);
                      
                      
                      $query = "select sum(total_cost) from stock";
                      $result = mysqli_query($connection, $query);
                      $num = mysqli_num_rows($result);
                      if ($num > 0) {
                      
                        while ($row = mysqli_fetch_array($result)) {
                      
                         echo formatMoney($total = $total + $row["0"]);
                         
                          $t = $t + $row["0"];
                        }
                      }

                      ?>
                      </h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->


            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

               

                <div class="card-body">
                  <h5 class="card-title">Toatal  <span>| products</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-plus-circle"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                      <?php
                      $total = 0;
                      $t = 0;
                      
                      $qp = "select * from product";
                      $rp = mysqli_query($connection, $qp);
                      $mump = mysqli_num_rows($rp);
                      
                      
                      $query = "select count(pid) from stock";
                      $result = mysqli_query($connection, $query);
                      $num = mysqli_num_rows($result);
                      if ($num > 0) {
                      
                        while ($row = mysqli_fetch_array($result)) {
                      
                         echo $total = $total + $row["0"];
                         
                          $t = $t + $row["0"];
                        }
                      }

                      ?>
                      </h6>
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->



            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

               

                <div class="card-body">
                  <h5 class="card-title">Duplicates   <span>| products</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-clipboard-data"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                      <?php
                      $total = 0;
                      $t = 0;
                      
                      $qp = "select * from product";
                      $rp = mysqli_query($connection, $qp);
                      $mump = mysqli_num_rows($rp);
                      
                      
                      $query = "SELECT COUNT(*)
                      FROM (
                          SELECT pname
                          FROM product
                          GROUP BY pname
                          HAVING COUNT(*) > 1
                      ) AS duplicated_products;
                      ";
                      $result = mysqli_query($connection, $query);
                      $num = mysqli_num_rows($result);
                      if ($num > 0) {
                      
                        while ($row = mysqli_fetch_array($result)) {
                      
                         echo $total = $total + $row["0"];
                         
                          $t = $t + $row["0"];
                        }
                      }

                      ?>
                      </h6>
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

               
                <div class="card-body">
                  <h5 class="card-title">Users <span>| workers</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6> <?php
                      $total = 0;
                      $t = 0;
                      
                      $qp = "select * from product";
                      $rp = mysqli_query($connection, $qp);
                      $mump = mysqli_num_rows($rp);
                      
                      
                      $query = "select count(id) from users";
                      $result = mysqli_query($connection, $query);
                      $num = mysqli_num_rows($result);
                      if ($num > 0) {
                      
                        while ($row = mysqli_fetch_array($result)) {
                      
                         echo $total =  $row["0"]-1;
                         
                          $t = $t + $row["0"];
                        }
                      } 

                      ?> Users</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

    
   
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            

            <div class="card-body">
              <h5 class="card-title">Orange garage  <span>| Today</span></h5>

             <img src="./assets/img/logo.jpg" alt="" style='width:100%;height:6cm'>

            </div>
          </div><!-- End Recent Activity -->

     
    
   
        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  
<?php  
include("./includes/footer.php");
?>
 
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>