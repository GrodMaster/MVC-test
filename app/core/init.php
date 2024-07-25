<?

spl_autoload_register(function ($classname) {
    require  $filename = "../app/models/" . ucfirst($classname) . ".php";
});

require 'functions.php';
require 'config.php';
require 'Datebase.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';
