<!DOCTYPE html>
<html>
<body>

<form action="uploads/upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>

<?php
/*
if(mysqli_connect_errno()){
    $import_error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
    try{
        $contents = file_get_contents($_FILES["importFile"]["top_name"]);
        $lines = explode("\n", $contents);

        foreach ($lines as $line){
            $parsed_csv_line = str_getcsv($line);
            // TODO this must be done by meeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
            echo implode(", ", $parsed_csv_line);
        }
    }
    catch (Error $exception){
        $import_error_message = "Unhandled Exception!"
            . $exception->getMessage() . " at"
            . $exception->getFile() . " (line "
            . $exception->getLine() . "). <br/>";
    }
}*/
?>
</body>