<?php
include ('connection.php');
checkPrivilege('View Product');

// Get the product ID from the URL parameter



$total = 0;
$t = 0;

$qp = "select * from product";
$rp = mysqli_query($connection, $qp);
$mump = mysqli_num_rows($rp);


$query = "select sum(total_cost) from stock ";
$result = mysqli_query($connection, $query);
$num = mysqli_num_rows($result);
if ($num > 0) {

  while ($row = mysqli_fetch_array($result)) {

    $total = $total + $row["0"];
    $t = $t + $row["0"];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>OGB GARAGE-product</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/icon1.png" rel="icon">
  <link href="assets/img/icon1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">



</head>

<body>

  <?php
  include ("./includes/header.php");
  include ("./includes/menu.php");
  ?>



  <main id="main" class="main">



    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">


            <!-- <div class="col-xxl-3 col-md-4">
              <div class="card info-card">
                <div class="card-body">
                  <br>
                  <img src="assets/img/sp.png" class="card-img-top" alt="...">
                  <div class="card-body">
                    <p class="card-title">product name</p>
                    <p class="card-text">description</p>
                      <div class="ps-1">
                      <h6>0 quantities</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">quantity</span>

                    </div>
                  </div>
                </div>

              </div>
            </div> -->

            <div class="col-lg-9">
              <div class="row">
                <?php

                $id = isset($_GET['pid']) ? intval($_GET['pid']) : null;

                // Initialize the query string
                $query = "SELECT p.pid, p.*, s.quantity AS product_quantity, s.unit_cost AS unit_cost, s.total_cost AS total_cost  
          FROM `product` AS p 
          LEFT JOIN `stock` AS s ON p.pid = s.pid";

                // Append WHERE clause if ID is provided
                if ($id !== null) {
                  $query .= " WHERE p.pid = $id";
                }



                // Retrieve products with updated quantity from the database
                // $query = "SELECT p.pid, p.*, s.quantity AS product_quantity,s.unit_cost AS unit_cost ,s.total_cost AS total_cost  FROM `product` AS p LEFT JOIN `stock` AS s ON p.pid = s.pid where p.pid=$id";
                

                $result = mysqli_query($connection, $query);


                // Check if there are any products
                if (mysqli_num_rows($result) > 0) {
                  // Loop through each product
                  while ($row = mysqli_fetch_assoc($result)) {
                    // Initialize quantity to 0 if not found in stock table
                    $quantity = isset($row['product_quantity']) ? $row['product_quantity'] : 0;

                    // Output HTML card for each product
                    ?>

                   <div class="col-xxl-4 col-md-6">
    <a href="stock.php?pid=<?php echo $row['pid']; ?>">
        <div class="card info-card">
            <div class="card-body">
                <br>
                <?php if (!empty($row['image'])): ?>
                    <img src="<?php echo "../Dashboard/".$row['image']; ?>" class="card-img-top" alt="<?php echo $row['pname']; ?>"
                        style='height:6cm;width:100%'>
                <?php endif; ?>
                <div class="card-body">
                    <p class="card-title"><?php echo $row['pname']; ?></p>
                    <!--<p class="card-text"><?php //echo $row['decription']; ?></p>-->
                    <div class="ps-1">
                        <h6><?php echo $quantity; ?> quantities</h6>
                        <div class="row">
                            <div class="col-6">
                                <span class="text-success small pt-1 fw-bold"><?php echo formatMoney($row['unit_cost']); ?></span>
                                <br>
                                <span class="text-muted small pt-2 ps-1">unity cost</span><br>
                            </div>
                            <div class="col-6">
                                <span class="text-success small pt-1 fw-bold"><?php echo formatMoney($row['total_cost']);?></span>
                                <br>
                                <span class="text-muted small pt-2 ps-1" style='text-align:center'>total cost</span>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </a>
</div><!-- End Sales Card -->

                    <?php
                  }
                } else {
                  // If no products found
                  echo '<p>No products found</p>';
                }
                ?>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="col-xxl-12 col-md-12">
                <div class="card info-card">
                  <?php

                  if ($mump > 0) {
                    ?>

                    <div class="card-body">
                      <br>
                      <?php
                      // echo $mump;
                      if ($mump > 0) {
                        if ($total = 0) {
                          ?>
                          <img src="assets/img/dsv.png" class="card-img-top" alt="...">
                          <?php
                        } else {
                          ?>
                          <img src="assets/img/ust.jpg" class="card-img-top" alt="...">
                          <?php
                        }
                      }


                      ?>

                      <div class="card-body">

                        <p class="card-text">
                        <h5 style='background-color:whitesmoke;padding:4px,width:100%;text-align:center'>stock value</h5>
                        </p>
                        <div class="ps-1">
                          <h6 style='background-color:;padding:4px,width:100%;text-align:center'><?php  echo formatMoney($t);?></h6>

                        </div>
                      </div>
                      <?php
                  } else {
                    ?>
                      <img src="assets/img/sorry.png" class="card-img-top" alt="...">
                      <?php

                  }

                  ?>
                  </div>

                </div>
              </div>
            </div>





          </div><!-- End Customers Card -->


        </div>
      </div><!-- End Left side columns -->


      <!-- </div> -->
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->

  <?php
  include ("./includes/footer.php");
  ?>

  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

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