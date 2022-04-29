<?php
if(!isset($pageName)){
    $pageName="Default Page Name";
}
?>

<head>
    <link rel="icon" type="image/x-icon" href="Images/Logo.png">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="Scripts/bootstrap.bundle.min.js"></script>
    <script src="Scripts/bootstrap.js"></script>
    <script src="Scripts/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="Styles/bootstrap.css">

    <style>
        body{
            padding-top: 75px;
        }

        .stack-top9{
            z-index: 9;
        }
        .stack-top8{
            z-index: 8;
        }
        .homepage-text{
            margin: 10px;
        }
        .stack-top0{
            padding-top: 50px;
            z-index: 0;
        }
    </style>

    <title><?php echo $pageName?></title>
</head>

    <?php

    if(!isset($this_page))
    $this_page='News DB Home';

    function checkActivePage($this_page_check, $this_page) {
        if($this_page_check==$this_page){
            echo " active\"";
        }
        else{
            echo "\"";
        }
    }

    function checkActiveDropdown($dropDownArray, $this_page){
        foreach ($dropDownArray as $item) {
            if($item==$this_page){
                echo " active\"";
                return;
            }
        }

        echo "\"";
    }
    ?>

<div class="container">
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark stack-top9">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"> <img src="Images/logo.png" width="30" height="30" alt=""> News Database</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link<?php checkActivePage('News DB Home', $this_page)?> href="homepage.php">Home
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?php checkActiveDropdown(['Import News Article', 'Import Other 1', 'Import Other 2'], $this_page)?> data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Imports</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item<?php checkActivePage('Import News Article', $this_page)?> href="importnewsarticledata.php">Import News Article</a>
                        <a class="dropdown-item<?php checkActivePage('Import Other 1', $this_page)?>" href="Import2.php">Import 1</a>
                        <a class="dropdown-item<?php checkActivePage('Import Other 2', $this_page)?>" href="Import3.php">Import 2</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?php checkActiveDropdown(['Report News Article', 'Report Other 1', 'Report Other 2'], $this_page)?> data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Reports</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item<?php checkActivePage('Report News Article', $this_page)?> href="news_article_report.php">Report News Article</a>
                        <a class="dropdown-item<?php checkActivePage('Report Other 1', $this_page)?>" href="Report2.php">Import 1</a>
                        <a class="dropdown-item<?php checkActivePage('Report Other 2', $this_page)?>" href="Report3.php">Import 2</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
</div>