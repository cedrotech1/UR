<?php
include ('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UR-HUYE-CARDS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./icon1.png" rel="icon">
  <link href="./icon1.png" rel="apple-touch-icon">

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

</head>

<body>

<?php  
include("./includes/header.php");
include("./includes/menu.php");
?>



<main id="main" class="main">

<div class="pagetitle">
      <h1>Data </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">data</li>
          <li class="breadcrumb-item active">upload</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->






    <section class="section dashboard">
      <div class="row">
      <!-- <div class="col-lg-1"></div> -->
        <!-- Left side columns -->
        <div class="col-lg-6">
          <div class="row">

          <div class="card">
            <div class="card-body">
            <br>
              <h5 class="card-title">UPLOAD DATA FORM</h5>
              <br>

              <!-- Floating Labels Form -->
              <!-- <form class="row g-3" action='add_product.php' method="post" enctype="multipart/form-data"> -->
                <div class="col-md-12">
                  <div class="form-floating">
                    <input class="form-control" type="file" id="excelFile" accept=".xls,.xlsx" />
                    <label for="floatingName">DATA</label>
                  </div>
                </div>
               
            
                <br>
          
                <div class="text-center">
                  <button type="submit" id="uploadButton" name="saveproduct" class="btn btn-primary">save data</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              <!-- </form> -->

            </div>
          </div>
    
   
          </div>
        </div><!-- End Left side columns -->


      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <script>
        document.getElementById('uploadButton').addEventListener('click', function () {
            uploadExcel();
        });

        function uploadExcel() {
            var fileInput = document.getElementById('excelFile');
            var file = fileInput.files[0];
            
            if (!file) {
                alert("Please select an Excel file.");
                return;  // Exit the function if no file is selected
            }

            var reader = new FileReader();
            
            // When the file is read
            reader.onload = function (e) {
                var data = new Uint8Array(e.target.result);  // Reading the binary data
                var workbook = XLSX.read(data, { type: 'array' });  // Reading the file into a workbook
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];  // Get the first sheet
                var excelRows = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });  // Convert sheet to JSON
                
                // Log the data for debugging
                console.log(excelRows);

                // Send the extracted data to the server via fetch
                fetch('upload_excel.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ data: excelRows })  // Send the data as JSON
                })
                .then(response => response.text())
                .then(responseText => {
                    console.log(responseText);  // Inspect the response from the server
                    alert("DONE");  // Show response message
                    window.location.href="add_data.php";
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            };

            // Read the file as an array buffer
            reader.readAsArrayBuffer(file);
        }
    </script>
  
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

  <!-- <script>
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
  </script> -->

</body>

</html>
