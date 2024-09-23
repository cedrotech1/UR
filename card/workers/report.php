<?php
include('connection.php');
checkPrivilege('Report');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>OGB GARAGE-report</title>
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


</head>

<body>

  <?php
  include ("./includes/header.php");
  include ("./includes/menu.php");
  ?>



  <main id="main" class="main">



    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-1"></div>
        <!-- Left side columns -->
        <div class="col-lg-10">
          <div class="row">

          <div class="card">
    <div class="card-body">
        <h5 class="card-title">DIFFERENT REPORT</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                    data-bs-target="#home-justified" type="button" role="tab" aria-controls="home"
                    aria-selected="true">day report</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                    data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile"
                    aria-selected="false">weekly/month report</button>
            </li>
          
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab1" data-bs-toggle="tab" data-bs-target="#contact-year"
                    type="button" role="tab" aria-controls="contact" aria-selected="false">year report</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-md-6">
                       <!-- day report -->
                    <form class="mt-3" action="day_report.php" method="POST">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="col-sm-12">
                                <select class="form-select" name="report">
                                    <option value="stockin">stock in</option>
                                    <option value="stockout">stock out</option>
                                    <option value="general">general report</option>
                                </select>
                            </div>
                            <br>
                            <button type="submit" name='day' class="btn btn-primary">get day report</button>
                        </form>


                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-md-6">
                    <form class="mt-3" action="week_report.php" method="POST">
                            <div class="mb-3">
                                <label for="date" class="form-label">From</label>
                                <input type="date" class="form-control" id="date" name="from" required>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">To</label>
                                <input type="date" class="form-control" id="date" name="to" required>
                            </div>

                            <div class="col-sm-12">
                                <select class="form-select" name="report">
                                    <option value="stockin">stock in</option>
                                    <option value="stockout">stock out</option>
                                    <option value="general">general report</option>
                                </select>
                            </div>
                            <br>
                            <button type="submit" name='day' class="btn btn-primary">get week/month report</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="contact-year" role="tabpanel" aria-labelledby="contact-tab1">
                <div class="row">
                    <div class="col-md-6">
                        <form class="mt-3" action="year_report.php" method="POST">
                            <div class="mb-3">
                                <label for="year" class="form-label">Year:</label>
                                <select class="form-select" id="year" name="year">
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2026">2028</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                            <select class="form-select" name="report">
                                    <option value="stockin">stock in</option>
                                    <option value="stockout">stock out</option>
                                    <option value="general">general report</option>
                                </select>
                            </div>
                            <br>
                            <button type="submit" name='day' class="btn btn-primary">get year report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- End Default Tabs -->
    </div>
</div>



          </div>
        </div><!-- End Left side columns -->


      </div>
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