<?php
$this_page='Import Other 1';
$pageName="Import Comment";
$pageFile = 'Import2.php';

$importPageMessage =
    "
        On this page you may import an unormalized .csv file containing the data for your comment.
        It will be imported directly into our database which will automatically be synced with our report pages.
        It's as simple as clicking a few buttons and you can see all of our data neatly laid out for your eyes.
    ";

$tableNames = [ "User", "Comment", "Subscription" ];
$tableLengths = [8, 4, 2];
$columnNames = [ "SubscriptionID", "FirstName", "LastName", "Username", "Password", "EmailAddress", "SubscriptionStartDate", "SubscriptionEndDate", "ArticleID", "UserID", "Text", "Likes", "Title", "Price"];
$updateColumns = [ "EmailAddress", "Username", "Title"];
$foreignKeyColumns = [ "SubscriptionID", "ArticleID", "UserID" ];
$foreignKeyTables = [ "Subscription", "Article", "User" ];
$foreignKeyColumnsInForeignTable = [ "Title", "Title", "Username" ];
?>

    <head>
        <title>News Database Import 2</title>
    </head>

<?php include_once("header.php"); ?>

<?php include_once("Import.php"); ?>

<?php include_once ("footer.php"); ?>
