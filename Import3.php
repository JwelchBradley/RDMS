<?php
$this_page='Import Other 2';
$pageName="Update Article Category";
$pageFile = 'Import3.php';

$importPageMessage =
    "
        On this page you may import an unormalized .csv file containing the data for your news article.
        It will be imported directly into our database which will automatically be synced with our report pages.
        It's as simple as clicking a few buttons and you can see all of our data neatly laid out for your eyes.
    ";

$tableNames = [ "Article", "Category", "Media" ];
$tableLengths = [8, 3, 4];
$columnNames = [ "LanguageID", "Category", "AuthorID", "ArticleType", "Title", "DatePublished", "LastUpdated", "Description", "DepartmentID", "Name", "Description", "ArticleID", "Title", "Type", "Description" ];
$updateColumns = [ "Title", "Name", "Title" ];
$foreignKeyColumns = [ "LanguageID", "AuthorID", "DepartmentID", "ArticleID" ];
$foreignKeyTables = [ "Language", "Author", "Department", "Article" ];
$foreignKeyColumnsInForeignTable = [ "Description", "FirstName", "Title", "Title"];
?>

    <head>
        <title>News Database Import 3</title>
    </head>

<?php include_once("header.php"); ?>

<?php include_once("Import.php"); ?>

<?php include_once("footer.php"); ?>
