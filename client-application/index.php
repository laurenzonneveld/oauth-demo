<?php

require __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

ob_start();
require 'index.phtml';
$html = ob_get_contents();
ob_end_clean();

$response = new \Symfony\Component\HttpFoundation\Response($html, 200);
$response->send();
