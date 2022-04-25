<?php $this_page='Report News Article'?>
<?php include_once("header.php"); ?>

<?php
$connection_error = false;
$connection_error_message = "";

$con = @mysqli_connect("localhost", "newsfella",
    "password", "sakila");

if(mysqli_connect_errno()){
    $connection_error = true;
    $connection_error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
}

function output_error ($title, $message) {
    echo "<spawn style=\"color: red;\">\n";
    echo "    <h1>" . $title . "</h1>\n";
    echo "    <h1>" . $message . "</h1>\n";
    echo "</span>\n";
}
?>
<html>
<head>
    <title>
        News Article Data Report
    </title>
</head>

<style>
    .pizzaDataHeaderRow td { padding-right: 20px; }
    .pizzaDataRow td{padding-left: 10px;}
    .pizzaDataDetailsCell {padding-left: 20px !important;}
</style>

<body>
<div class="container">
    <h1>News Data Report</h1>

    <?php if($connection_error){
        output_error("Database connection failure!", $connection_error_message);
    }else{
        function output_table_open(){
            echo "<table class=\"table table-striped\">\n";
            echo "<tr class=\"pizzaDataHeaderRow\">\n";
            echo"    <td>ArticleID</td>\n";
            echo"    <td>Title</td>\n";
            echo"    <td>Category</td>\n";
            echo"    <td>Date Published</td>\n";
            echo"    <td>Last Updated</td>\n";
            echo"    <td>Description</td>\n";
            echo"    <td>Language</td>\n";
            echo "</tr>\n";
        }

        function output_table_close(){
            echo "</table>";
        }

        function output_article_row($ArticleID, $Title, $Category, $DatePublished, $LastUpdated, $Description, $Language){
            echo "<tr\n";
            echo "    <td>" . $ArticleID . "</td>\n";
            echo "    <td>" . $Title . "</td>\n";
            echo "    <td>" . $Category . "</td>\n";
            echo "    <td>" . $DatePublished . "</td>\n";
            echo "    <td>" . $LastUpdated . "</td>\n";
            echo "    <td>" . $Description . "</td>\n";
            echo "    <td>" . $Language . "</td>\n";
            echo "</td>";
        }

        function output_person_detail_row($AuthorID, $Citation){

            $sources_str = "None";
            if( sizeof($Citation) > 0)
                $sources_str = implode(", ", $Citation);

            echo "<tr>\n";
            echo "    <td colspan=\"3\>\n";
            echo "          Author: " . $AuthorID . "<br/>\n";
            echo "          Sources: " . $sources_str . "\n";
            echo "     </td>\n";
            echo "</tr>\n";
        }

        $query = " SELECT * "
            . "FROM article t0"
            . " LEFT OUTER JOIN source t1 ON t0.ArticleID = t1.Article"
            . " LEFT OUTER JOIN author t2 ON t0.Author = t2.AuthorID";

        $result = mysqli_query($con, $query);

        if(! $result){
            if(mysqli_errno($con)){
                output_error("Data retrieval error!", mysqli_error($con));
            }
            else{
                echo "No Article Data Found!";
            }
        }else {
            output_table_open();

            $last_article = null;
            $sources = array();
            $authors = array();

            while($row = $result -> fetch_array()) {
                if($last_article != $row["ArticleID"]) {
                    if($last_article != null) {
                        output_person_detail_row($authors, $sources);
                    }

                    output_article_row($row["ArticleID"], $row["Title"], $row["Category"], $row["DatePublished"], $row["LastUpdated"], $row["Description"], $row["Language"]);
                    $sources = array();
                    $authors = array();

                }

                if(!in_array($row["Citation"], $sources))
                    $sources = $row["Citation"];
                if(!in_array($row["FirstName"], $authors))
                    $authors = $row["FirstName"];
                $last_article = $row["ArticleID"];
            }

            output_table_close();
        }
    } ?>
</div>

</body>

<?php include_once ("footer.php"); ?>
</html>