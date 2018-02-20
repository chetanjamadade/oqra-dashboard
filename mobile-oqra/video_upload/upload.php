<?php
if(!isset($_FILES['file']) || ($_FILES['file']['tmp_name'] == ''))
    echo "Please choose a file.";
else {
    $uploadfile =  $_FILES['file']['name'];
    $uploadfilename = $_FILES['file']['tmp_name'];  
}

$location = '../uploads/';

if(move_uploaded_file($uploadfilename, $location.$uploadfile)){
    echo 'File uploaded..';
} else {
    echo 'Error to upload..';
}
exit;
?>
<!DOCTYPE html>
<html>
<body style="display: none;">
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload Image" name="submit">
</form>
</body>
</html>