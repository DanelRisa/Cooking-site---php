<?php
session_start();
require_once 'common/connect.php'; // Assuming your database connection is established here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'] ?? '';

    // Check if the post ID exists and if an image was uploaded
    if ($post_id && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define the target directory where the image will be stored
        $uploadFolder = "uploads/";

        // Generate a unique file name to avoid overwriting
        $newFileName = uniqid() . '.' . $fileExtension;

        $dest_path = $uploadFolder . $newFileName;

        // Move the uploaded file to the desired location
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            updateImageURL($post_id, $dest_path, $pdo); // $pdo is your database connection variable

            // Redirect back to the post page after successful upload
            header("Location: index.php");
            exit();
        } else {
            // Handle if the file upload failed
            $_SESSION['upload_error'] = "File upload failed.";
            header("Location: index.php");
            exit();
        }
    } else {
        // Handle if the required data is missing
        $_SESSION['upload_error'] = "Error uploading file.";
        header("Location: index.php");
        exit();
    }
}
?>
