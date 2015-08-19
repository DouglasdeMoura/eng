<?php
header('Content-type: text/css');
require_once 'scss/vendor/autoload.php';
use Leafo\ScssPhp\Compiler;
$scss = new Compiler();
$scss->setFormatter(new Leafo\ScssPhp\Formatter\Expanded);
echo $scss->compile('@import "style.scss";');
