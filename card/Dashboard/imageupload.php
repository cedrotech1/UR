<?php
// Include database connection file
include("connection.php");

// Check if the token is provided
if (isset($_GET['token'])) {
    $encodedToken = $_GET['token'];
    $decodedToken = base64_decode($encodedToken);

    // Check if the decoded token contains the delimiter
    if (strpos($decodedToken, '|') !== false) {
        list($token, $regnumber) = explode('|', $decodedToken);

        // Fetch token from database based on encoded token and registration number
        $sql = "SELECT email FROM info WHERE token='$encodedToken' AND regnumber='$regnumber'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);

        // Validate the token
        if ($row) {
            // echo "Token is valid. You can proceed with the authentication.<br>";
            // echo "Registration Number: " . htmlspecialchars($regnumber);
            // Perform further actions like showing a form or redirecting the user
        } else {
            echo "Invalid token or registration number.";
            echo"<script>window.location.href='../tokenrequest.php'</script>";
        }
    } else {
        // echo "Invalid token format.";
        echo"<script>window.location.href='../tokenrequest.php'</script>";
    }
} else {
    echo "Token not provided.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UR-HUYE</title>
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


</head>

<body>

<?php  
include("./includes/studentHeader.php");
include("./includes/studentMenu.php");
?>



<main id="main" class="main">



    <section class="section dashboard">
      <div class="row">


      <div class="col-lg-12">
              <div class="row">
                <?php
                $id = $regnumber;

                // Initialize the query string
                $query = "SELECT * FROM info";

                // Append WHERE clause if ID is provided
                if ($id !== null) {
                  $query .= " WHERE regnumber = '$id'";
                }

                $result = mysqli_query($connection, $query);

                // Check if there are any records
                if (mysqli_num_rows($result) > 0) {
                  // Loop through each record
                  while ($row = mysqli_fetch_assoc($result)) {
                    // Output HTML card for each record
                    ?>

                    <div class="col-xxl-4 col-md-6">
                      <div class="card info-card" style="background: url('./2.png') no-repeat center center/cover; background-size: cover; position: relative;border:1px solid gray">
                        <div class="card-body">
                          <div class="ps-1" style="color:black">
                            <div class="row">
                              <div class="col-6" style=""> <img src="./logo.png" alt="" style="height:auto;width:100%;margin-left:-0.7cm"></div>
                              <div class="col-6">
                                 <h6 style="padding-Top:0.6cm;text-transform:uppercase;text-align:right;font-size:28px;color:black">
                                  <b>
                                  <?php echo htmlspecialchars($row['campus']); ?> Campus</h6>
                                  </b>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-12"> 
                              <!-- <h2 style="text-align:center">College: <?php //echo htmlspecialchars($row['college']); ?></h2></div> -->
                              <h3 style="text-align:center;text-transform:uppercase;text-style:bold"><b>college of business and economics</b></h3></div>
                            </div>
                            <div class="row">
                              <div class="col-12"></div>
                             
                            </div>

                            <div class="row">
                              <div class="col-8">
                             
                            <h5 style="text-align:right;padding-bottom:0.2cm"> <b><u>STUDENT ID CARD</u></b> </h5>
                            <ul>
                                  <li><b>Names: <?php echo htmlspecialchars($row['names']); ?></b></li>
                                  <li><b>School: <?php echo htmlspecialchars($row['school']); ?></b></li>
                                  <li><b>Program: <?php echo htmlspecialchars($row['program']); ?></b></li>
                                  <li><b>Year of Study: <?php echo htmlspecialchars($row['yearofstudy']); ?></b></li>
                              </ul>

                            <p style="text-align:left;padding-top:0cm,font-size:16px">
                               <b><i> Expiry Date: <?php echo htmlspecialchars($row['expireddate']); ?></i></b>
                              </p>
                            
                              </div>
                              <div class="col-4" style="">
                                <!-- <img src="./card.jpg" alt="" style="height:3.5cm;width:3cm;margin-top:0.3cm"> -->
                                <p style="margin-top:4cm">
                                <b><i>Reg: <?php echo htmlspecialchars($row['regnumber']); ?></i></b>
                              </p>
                              </div>
                            </div>
                            
                            <div class="row">
                              <div class="col-6"></div>
                              <div class="col-1"></div>
                              <div class="col-4">  </div>
                            </div>
                          
                          
                          </div>
                        </div>
                      </div>
                    </div><!-- End Info Card -->

                    <?php
                  }
                } else {
                  // If no records found
                  echo '<p>No record found</p>';
                }
                ?>
              </div>
            </div>












      <!-- <div class="col-lg-1"></div> -->
        <!-- Left side columns -->
        <div class="col-lg-10">
          <div class="row">

          <div class="card">
            <div class="card-body">
                <br>
              <h5 class="card-title">UPLOAD CARD IMAGE</h5>
              <br>

              <!-- Floating Labels Form -->
              <form class="row g-3" action='' method="post" enctype="multipart/form-data">
              

                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="file" class="form-control" id="image" name='image' required onchange="previewImage(this)">
                    <label for="floatingName"> </label>
                  </div>
                  <div id="imagePreviewContainer">
                    <!-- Image preview will be displayed here -->
                  </div>
                </div>
          
                <div class="text-center">
                  <button type="submit" name="saveproduct" class="btn btn-primary">save</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
          </div>
    
   
          </div>
        </div><!-- End Left side columns -->


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

  <script>
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          var imagePreview = document.createElement('img');
          imagePreview.src = e.target.result;
          imagePreview.style.maxWidth = '100%';
          imagePreview.style.height = 'auto';
          
          var previewContainer = document.getElementById('imagePreviewContainer');
          previewContainer.innerHTML = ''; // Clear previous preview
          previewContainer.appendChild(imagePreview);
        }

        reader.readAsDataURL(input.files[0]); // Read the selected file as a data URL
      }
    }
  </script>

</body>

</html>
<?php
if (isset($_POST['saveproduct'])) {


   
    
            // File upload
            $target_dir = "upload/"; // Directory where files will be saved
            $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)); // Get the file extension

            // Generate a unique filename using timestamp
            $timestamp = time();
            $target_file = $target_dir . $timestamp . '.' . $imageFileType; // New filename with timestamp

            // Check if file already exists (unlikely with timestamp, but just in case)
            while (file_exists($target_file)) {
                $timestamp = time(); // Regenerate timestamp if filename already exists
                $target_file = $target_dir . $timestamp . '.' . $imageFileType;
            }

            // Check if file is an actual image
            $check = getimagesize($_FILES["image"]["tmp_name"]);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "<script>alert('Sorry, file already exists.')</script>";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["image"]["size"] > 5000000) {
                echo "<script>alert('Sorry, your file is too large.')</script>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script>alert('Sorry, your file was not uploaded.')</script>";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                    // Insert data into product table
                    // $ok = mysqli_query($connection, "INSERT INTO `images`(`id`, `image`) 
                    // VALUES (null,'$image_path')");

$ok = mysqli_query($connection, "UPDATE info SET picture='$image_path' WHERE regnumber='$regnumber'");

// $ok = mysqli_query($connection, "UPDATE info SET token='$encodedToken' WHERE email='$email'");
                    if ($ok) {
                       
                            echo "<script>alert('Image inserted successfully.')</script>";
                            echo "<script>window.location.href='view_products.php'</script>";
                        
                    } else {
                        echo "<script>alert('Failed to insert product.')</script>";
                    }
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
                }
            }
        

}
?>
