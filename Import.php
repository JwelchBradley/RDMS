<?php
if(!isset($pageFile)){
    $pageFile = 'importnewsarticledata.php';
}
if(!isset($this_page)){
    $this_page = 'Import Page';
}
if(!isset($importPageMessage)){
    $importPageMessage = 'Default Import Message';
}
?>

<style>
    .chooseFile{
        width: 20%;
    }

    .importMessagePadding{
        padding-bottom: 30px;
    }

    .buttonPadding{
        padding-top: 15px;
    }
</style>

<!DOCTYPE html>
<html>
<body>
<div class="container mb-3">
    <h1 class="text-dark display-3 fw-bold"><?php echo $this_page?></h1>

    <div class="importMessagePadding text-dark lead fw-bold">
        <?php echo $importPageMessage ?>
    </div>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select data to upload:
        <input class="form-control chooseFile" type="file" name="fileToUpload" id="fileToUpload">
        <input type="hidden" name="page" value=<?php echo "\"$pageFile\""?>>
        <div class="container buttonPadding align-items-center">
            <input type="reset" value="clear">
        <input type="submit" value="Upload Import Data" name="submit">
        </div>
    </form>
</div>
</body>
</html>
</body>