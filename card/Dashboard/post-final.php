<?php
include('connection.php');

if (isset($_POST['saveproduct'])) {
    $caption = $_POST['caption'];
    $pid = $_POST['id'];


    if ($caption != '') {
       
                $ok = mysqli_query($connection, "UPDATE `post` SET `caption`='$caption'  WHERE `pid`=$pid");
                if ($ok) {
                    echo "<script>alert('Post updated successfully.')</script>";
                    echo "<script>window.location.href='view_posts.php'</script>";
                    exit(); // Stop script execution
                } else {
                    echo "<script>alert('Failed to update post.')</script>";
                }
            }else{
                echo "<script>alert('Please caption plz.')</script>";
                echo "<script>window.location.href='view_posts.php'</script>";
            }
        
    
}
?>
