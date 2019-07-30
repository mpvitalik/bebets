<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
$html = file_get_contents("https://terrikon.com/football/england/championship/");

libxml_use_internal_errors(true);

$doc = new DOMDocument();
$doc->loadHTML($html);
$finder = new DomXPath($doc);


echo $doc->saveHTML($doc);