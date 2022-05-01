<?php $this_page='Article, Category, Media Report'?>
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
</style>

<body>
<div class="container">
    <h1>News Data Report</h1>

    <?php
    if($connection_error){
        output_error("Database connection failure!", $connection_error_message);
    }
    else {
        function output_table_open()
        {
            echo "<table class=\"table table-striped\">\n";
            echo "<tr class=\"pizzaDataHeaderRow\">\n";
            echo "    <td>ArticleID</td>\n";
            echo "    <td>Title</td>\n";
            echo "    <td>AuthorID</td>\n";
            echo "    <td>Date Published</td>\n";
            echo "    <td>Last Updated</td>\n";
            echo "    <td>Description</td>\n";
            echo "    <td>Language</td>\n";
            echo "</tr>\n";
        }

        function output_table_close()
        {
            echo "</table>";
        }

        function output_article_row($ArticleID, $Title, $AuthorID, $DatePublished, $LastUpdated, $Description, $Language)
        {
            echo "<tr\n>";
            echo "    <td>" . $ArticleID . "</td>\n";
            echo "    <td>" . $Title . "</td>\n";
            echo "    <td>" . $AuthorID . "</td>\n";
            echo "    <td>" . $DatePublished . "</td>\n";
            echo "    <td>" . $LastUpdated . "</td>\n";
            echo "    <td>" . $Description . "</td>\n";
            echo "    <td>" . $Language . "</td>\n";
            echo "</td>";
        }

        function output_person_detail_row($Category, $Media)
        {

            $category_str = "None";
            if ($Category[0] != NULL) {
                $category_str = $Category[1] . ".\n";
            }

            $media_str = "None";
            if ($Media[0] != NULL) {
                $media_str = " #" . $Media[0] . ", \"" . $Media[1] . "\"" . "\n";
            }

            echo "<tr>\n";
            echo "    <td style='padding-left: 100px' colspan='7'>\n";
            echo "  Category: " . $category_str . "\n<br/>";
            echo " Media: " . $media_str . "\n<br/>";
            echo "     </td>\n";
            echo "</tr>\n";
        }

        $query = " SELECT * "
            . "FROM article t0"
            . " LEFT OUTER JOIN news_category t1 ON t0.Category = t1.CategoryID"
            . " LEFT OUTER JOIN media t2 ON t0.ArticleID = t2.AssociatedArticle";

        $result = mysqli_query($con, $query);

        if (!$result) {
            if (mysqli_errno($con)) {
                output_error("Data retrieval error!", mysqli_error($con));
            } else {
                echo "No Article Data Found!";
            }
        } else {
            output_table_open();

            $last_article = null;
            $category = array();
            $media = array();

            while ($row = $result->fetch_array()) {
                if ($last_article != $row["ArticleID"]) {
                    if ($last_article != null) {
                        output_person_detail_row($category, $media);
                    }

                    output_article_row($row["ArticleID"], $row["Title"], $row["Author"], $row["DatePublished"], $row["LastUpdated"], $row["Description"], $row["Language"]);
                    $category = array($row["CategoryID"], $row["Name"], $row["CategoryDescription"], $row["Department"]);
                    $media = array($row["MediaID"], $row["MediaTitle"], $row["Type"], $row["MediaDescription"], $row["AssociatedArticle"]);

                }

                if (!in_array($row["CategoryID"], $category)) {
                    $category = array($row["CategoryID"], $row["Name"], $row["CategoryDescription"], $row["Department"]);
                }
                if (!in_array($row["MediaID"], $media)) {
                    $media = array($row["MediaID"], $row["MediaTitle"], $row["Type"], $row["MediaDescription"], $row["AssociatedArticle"]);
                }
                $last_article = $row["ArticleID"];


            }

            output_person_detail_row($category, $media);
            output_table_close();
        }

    }?>
</div>

</body>

<?php include_once ("footer.php"); ?>
</html>}