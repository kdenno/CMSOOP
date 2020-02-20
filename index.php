<?php
define("VIEWS",__DIR__."/Views/");
require("Config/config.php");
$appController = new AppController();
// initialize app
$appController->init();
?>