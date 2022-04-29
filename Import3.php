<?php
$this_page='Import Other 2';
$pageName="Import Article Category";
$pageFile = 'Import3.php';

$importPageMessage =
    "
        On this page you may import an unormalized .csv file containing the data for your news article.
        It will be imported directly into our database which will automatically be synced with our report pages.
        It's as simple as clicking a few buttons and you can see all of our data neatly laid out for your eyes.
    ";

$tableNames = [ "Category", "Media", "Article" ];
$tableLengths = [3, 4, 8];
$columnNames = [ "DepartmentID", "Name", "Description", "ArticleID", "Title", "Type", "Description", "LanguageID", "Category", "AuthorID", "ArticleType", "Title", "DatePublished", "LastUpdated", "Description" ];
$updateColumns = [ "Name", "Title", "Title" ];
$foreignKeyColumns = [ "DepartmentID", "ArticleID", "LanguageID", "AuthorID" ];
$foreignKeyTables = [ "Department", "Article", "Language", "Author" ];
$foreignKeyColumnsInForeignTable = [ "Title", "Title", "Description", "FirstName" ];
?>

    <head>
        <title>News Database Import 3</title>
    </head>

<?php include_once("header.php"); ?>

<?php include_once("Import.php"); ?>

<?php include_once("footer.php"); ?>
