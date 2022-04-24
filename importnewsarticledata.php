<?php $this_page='Import News Article'?>
<?php include_once("header.php"); ?>

<body>
<div class="container">
    <!-- The data encoding type, enctype, MUST be specified as below -->
    <form enctype="multipart/form-data" action="__URL__" method="POST">
        <!-- MAX_FILE_SIZE must precede the file input field -->
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <!-- Name of input element determines name in $_FILES array -->
        Send this file: <input name="importFile" type="file" />
        <input type="submit" value="Upload File" />
    </form>
</div>

<?php
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
}
?>
</body>

<?php include_once ("footer.php"); ?>
