<?php
if (isset($_POST['saveproduct'])) {




  // File upload
  $target_dir = "./uploads/"; // Directory where files will be saved
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
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
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
      $ok = mysqli_query($connection,  "INSERT INTO images (id, regnumber, image) VALUES (NULL, '$regnumber', '$image_path')");


      // $ok = mysqli_query($connection, "UPDATE info SET token='$encodedToken' WHERE email='$email'");
      if ($ok) {

        echo "<script>alert('Image inserted successfully.')</script>";
        echo "<script>window.location.href='imageupload.php?token=$encodedToken'</script>";

      } else {
        echo "<script>alert('Failed to insert product.')</script>";
      }
    } else {
      echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
    }
  }


}
?>