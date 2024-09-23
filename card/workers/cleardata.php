
<?php
include('connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate password
    $password=$_POST["password"];


    $sql = "SELECT password FROM users WHERE id = '1'";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
      $pass= $row["password"];

    }

  
      // Verify hashed password retrieved from the database
      if ($password == $pass) {
 
        // Password is correct, proceed with clearing data

        // Truncate table 'stock'
        $truncate_stock_query = "TRUNCATE TABLE stock";
        mysqli_query($connection, $truncate_stock_query);

        // Truncate table 'product'
        $truncate_product_query = "TRUNCATE TABLE product";
        mysqli_query($connection, $truncate_product_query);

        // Truncate table 'historic'
        $truncate_historic_query = "TRUNCATE TABLE historic";
        mysqli_query($connection, $truncate_historic_query);

        // Delete all data from 'users' except admin
        $delete_users_query = "DELETE FROM users WHERE role != 'admin'";
        mysqli_query($connection, $delete_users_query);

         // Truncate table 'historic'
         $truncate_privilages_query = "TRUNCATE TABLE privilages";
         mysqli_query($connection, $truncate_privilages_query);

         $truncate_privilages_query = "TRUNCATE TABLE contact_messages";
         mysqli_query($connection, $truncate_privilages_query);




        echo "<script>alert('done')</script>";
    }else{
      echo "<script>alert('incorect admin password')</script>";
    }
   
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> CLEAR</title>
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
  <style>
    ul li{
      list-style: none;
    }
  </style>


</head>

<body>

  <?php
  include ("./includes/header.php");
  include ("./includes/menu.php");
  ?>



  <main id="main" class="main">



    <section class="section dashboard">
      <div class="row">
       
        <div class="col-lg-4">
          <div class="row">

          <div class="card">
    <div class="card-body">
        <h5 class="card-title">DELETE ALL SYSTEM DATA</h5>
        <form id="clearDataForm" action="cleardata.php" method="post">
  <input type="password" class="form-control" name="password" placeholder="ENTER PASSWORD" required><br>
  <input type="submit" value="Clear Data" class="btn btn-danger col-12">
</form>

<script>
document.getElementById("clearDataForm").addEventListener("submit", function(event) {
  // Ask for confirmation before submitting the form
  var confirmClear = confirm("Are you sure you want to delete all system data?");
  if (!confirmClear) {
    // Prevent form submission if user cancels
    event.preventDefault();
  }
});
</script>


     
       
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


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>