<?php
$target_dir = "C:\Users\jwelc\PhpstormProjects\RDMS\uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$pageName = $_POST["page"];

if(!isset($tableNames)){
    $tableNames = [];
}
if(!isset($tableColumns)){
    $tableColumns = ['Column1', 'Column2'];
}
if(!isset($tableLengths))
$tableLengths = [5, 2, 2];
if(!isset($columnNames))
$columnNames = ["Category", "Title", "Data published", "Last Updated", "Description", "Source type", "Citation", "Fname", "Lname"];
if(!isset($updateColumns)){
    $updateColumns = [];
}
$updateDoubleColumns = [ ];
$foreignKeyColumns = [ ];
$foreignKeyTables = [ ];
$foreignKeyColumnsInForeignTable = [ ];
?>

<?php include_once($pageName); ?>

<style>
    .error{
        color: red;
    }
    .correct{
        color: green;
    }
</style>

<div class="container">
<?php
CheckFile($imageFileType, $uploadOk);
#region Check File Functions
function CheckFile($imageFileType, &$uploadOk){
    // Check if it is an actual file
    if(isset($_POST["submit"])) {
        $check = filesize($_FILES["fileToUpload"]["tmp_name"]);

        if($check !== false) {
            $uploadOk = 1;
            CheckIfFileTooLarge($uploadOk);

            CheckFileType($imageFileType, $uploadOk);

            if($uploadOk==1)
                PrintFileSize($check);
        } else {
            echo "<div class=\"error fw-bold\">File is not valid.</div>";
            $uploadOk = 0;
        }
    }
}

function PrintFileSize($check){
    echo "<div class=\"container correct fw-bold\">File is valid with size - ";

    if($check < 1000){
        echo $check . " bytes";
    }
    else if($check < 1000000){
        echo $check/1000 . " kilobytes";
    }
    else if($check < 1000000000){
        echo $check/1000000 . " megabytes";
    }
    else{
        echo $check/1000000000 . " gigabytes";
    }

    echo ".</div>\n";
}

function CheckIfFileTooLarge(&$uploadOk){
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 10000000) {
        echo "<div class=\"error fw-bold\">Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }
}

function CheckFileType($imageFileType, &$uploadOk){
    // Allow certain file formats
    if($imageFileType != "csv" && $uploadOk==1) {
        echo "<div class=\"error fw-bold\">Sorry, only CSV files are allowed.</div>";
        $uploadOk = 0;
    }
}
#endregion

UploadFile($uploadOk, $target_file, $tableNames, $tableLengths, $columnNames, $updateColumns, $foreignKeyColumns, $foreignKeyTables, $foreignKeyColumnsInForeignTable, $updateDoubleColumns);
#region Upload File Functions (note also calls connect to server & database insert/update)
function UploadFile($uploadOk, $target_file, $tableNames, $tableLengths, $columnNames, $updateColumns, $foreignKeyColumns, $foreignKeyTables, $foreignKeyColumnsInForeignTable, $updateDoubleColumns){
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<div class=\"error fw-bold\">Sorry, your file was not uploaded.</div>";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            ConnectToServer($target_file, $tableNames, $tableLengths, $columnNames, $updateColumns, $foreignKeyColumns, $foreignKeyTables, $foreignKeyColumnsInForeignTable, $updateDoubleColumns);
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "<div class=\"error fw-bold\">Sorry, there was an error uploading your file.</div>";
        }
    }
}
#endregion

function ConnectToServer($target_file, $tableNames, $tableLengths, $columnNames, $updateColumns, $foreignKeyColumns, $foreignKeyTables, $foreignKeyColumnsInForeignTable, $updateDoubleColumns){
    $con = @mysqli_connect("localhost", "NewsUser",
        "asdfqwer1234", "newsapplication");

    if(mysqli_connect_errno()){
        $import_error_message = "<div class=\"error fw-bold\">Failed to connect to MySQL: " . mysqli_connect_error() . "</div>";
        echo $import_error_message;
    }
    else{
        try{
            InsertIntoTable($target_file, $con, $tableNames, $tableLengths, $columnNames, $updateColumns, $foreignKeyColumns, $foreignKeyTables, $foreignKeyColumnsInForeignTable, $updateDoubleColumns);
        }
        catch (Error $exception){
            $import_error_message = "<div class=\"error\">Unhandled Exception!</div>"
                . $exception->getMessage() . " at"
                . $exception->getFile() . " (line "
                . $exception->getLine() . "). <br/>";
            echo $import_error_message;
        }
    }
}

function InsertIntoTable($target_file, $con, $tableNames, $tableLengths, $columnNames, $updateColumns, $foreignKeyColumns, $foreignKeyTables, $foreignKeyColumnsInForeignTable, $updateDoubleColumns){
    // opens file and gets contents
    $contents = file_get_contents($target_file);
    $lines = explode("\n", $contents);
    $file = fopen($target_file, "r") or die("<div class=\"error\">Unable to open file!</div>");

    // Loops through each line
    foreach ($lines as $line) {
        $parsed_csv_line = str_getcsv($line);

        $hasSkippedHeaders = false;

        $currentRowIndex=0;
        $currentForeignRow = 0;
        for($x = 0; $x < count($tableNames); $x++){
            $tableHeaders = "";
            $valuesForThisTable = null;
            $isUpdate = false;
            $updateColumn = "";
            $updateKey = "";

            for($y = $currentRowIndex; $y < $tableLengths[$x]+$currentRowIndex; $y++){
                $tableHeaders .= $columnNames[$y] . ", ";


                if(in_array($columnNames[$y], $foreignKeyColumns)){
                    $query = "SELECT * FROM " . $foreignKeyTables[$currentForeignRow] . " WHERE " . $foreignKeyColumnsInForeignTable[$currentForeignRow] . " = '" . $parsed_csv_line[$y] . "'";
                    echo $query;
                    $result = mysqli_query($con, $query);
                    $hasFound = true;
                    while ($row = mysqli_fetch_assoc($result) AND $hasFound) {
                        $valuesForThisTable .= $row[ $columnNames[$y] ] . ",";
                        $hasFound = false;
                    }
                    $currentForeignRow++;
                    //echo mysqli_fetch_assoc($result);
                }
                else if($y<count($parsed_csv_line)){
                    $valuesForThisTable .= $parsed_csv_line[$y] . ",";
                }

                if(in_array($columnNames[$y], $updateColumns) AND !$isUpdate){
                    $query = "SELECT * FROM " . $tableNames[$x] . " WHERE " . $columnNames[$y] . " = '" . $parsed_csv_line[$y] . "'";
                    Echo $query;
                    $result = mysqli_query($con, $query) -> num_rows;

                    if($result > 0){
                        $isUpdate = true;
                        $updateColumn = $columnNames[$y];
                        $updateKey = $parsed_csv_line[$y];
                    }
                }
            }

            $tableHeaders = rtrim($tableHeaders, ", ");

            // Updates the table
            if($isUpdate){
                $valuesForThisTableArray = explode(",", $valuesForThisTable);
                $sql = "UPDATE " . $tableNames[$x];
                $sql .= " SET ";
                $tableHeadersArray = explode(", ", $tableHeaders);

                for($z = 0; $z < count($tableHeadersArray); $z++){
                    $sql .= $tableHeadersArray[$z] . "='" . $valuesForThisTableArray[$z] . "', ";
                }
                $sql = rtrim($sql, ", ");
                $sql .= " WHERE " . $updateColumn . "='" . $updateKey . "'";
            }

            // Inserts to the table
            else{
                $sql = "INSERT into $tableNames[$x]( ";
                $sql .= $tableHeaders;
                $sql = rtrim($sql, ", ");

                // Sets Values
                $sql .= ") values (";
                $valuesForThisTable = substr($valuesForThisTable, 0, -1);
                $valuesForThisTableArray = explode(",", $valuesForThisTable);

                foreach ($valuesForThisTableArray as $item) {
                    $sql .= "'" . $item . "'" . ",";
                }

                $sql = rtrim($sql, ",");
                $sql .= ")";
            }

            echo $sql;
            $currentRowIndex += $tableLengths[$x];
            mysqli_query($con, $sql);
        }

        echo "<div class=\"container\">" . implode(", ", $parsed_csv_line) . "</div>";
    }

    fclose($file);
    unlink($target_file);
}
?></div>