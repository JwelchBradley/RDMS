<?php
$this_page='Import News Article';
$pageName="Import News Article";
$pageFile = 'importnewsarticledata.php';

$importPageMessage =
    "
        On this page you may import an unormalized .csv file containing the data for your news article.
        It will be imported directly into our database which will automatically be synced with our report pages.
        It's as simple as clicking a few buttons and you can see all of our data neatly laid out for your eyes.
    ";

$tableNames = [ "Author", "Article", "Source" ];
$tableLengths = [3, 8, 3];
$columnNames = [ "DepartmentID", "FirstName", "LastName", "LanguageID", "Category", "AuthorID", "ArticleType", "Title", "DatePublished", "LastUpdated", "Description", "ArticleID", "SourceType", "Citation"];
$updateColumns = [ "FirstName", "Title" ];
$foreignKeyColumns = [ "DepartmentID", "LanguageID", "AuthorID", "ArticleID" ];
$foreignKeyTables = [ "Department", "Language", "Author", "Article" ];
$foreignKeyColumnsInForeignTable = [ "Title", "Description", "FirstName", "Title" ];
?>

<?php include_once("header.php"); ?>

<?php include_once("Import.php"); ?>

<?php include_once ("footer.php"); ?>
