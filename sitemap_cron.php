<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$all_prognozi = $db->getAllShowingPrognozi();
$pages_prognozi = ceil(count($all_prognozi)/30);

$all_novosti = $db->getAllShowingPosts();
$pages_novosti = ceil(count($all_novosti)/5);

$all_otzivi = $db->getAllOtzivi();
$pages_otzivi = ceil(count($all_otzivi)/30);

$all_tags = $db->getAllTags();

$all_championats = $db->getAllChampionats();


$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";



$xml .= "<url>";
$xml .= "<loc>https://bebets.ru</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/enter.php</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/register.php</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/prognozi.php</loc>";
$xml .= "<changefreq>daily</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/express-today.php</loc>";
$xml .= "<changefreq>daily</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/systema.php</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/podpiska.php</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/otzivi.php</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/garanty.php</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";
$xml .= "<url>";
$xml .= "<loc>https://bebets.ru/championats.php</loc>";
$xml .= "<changefreq>weekly</changefreq>";
$xml .= "</url>";

foreach($all_prognozi as $prognoz){
    $xml .= "<url>";
    $xml .= "<loc>https://bebets.ru/".$prognoz->getSsilka().".html</loc>";
    $xml .= "<changefreq>daily</changefreq>";
    $xml .= "</url>";
}
foreach($all_novosti as $novost){
    $xml .= "<url>";
    $xml .= "<loc>https://bebets.ru/".$novost->getSsilka().".html</loc>";
    $xml .= "<changefreq>daily</changefreq>";
    $xml .= "</url>";
}
foreach($all_tags as $tag){
    $xml .= "<url>";
    $xml .= "<loc>https://bebets.ru/".$tag->getSsilka().".html</loc>";
    $xml .= "<changefreq>daily</changefreq>";
    $xml .= "</url>";
}

foreach($all_championats as $championat){
    $xml .= "<url>";
    $xml .= "<loc>https://bebets.ru/".$championat->getSsilka().".html</loc>";
    $xml .= "<changefreq>daily</changefreq>";
    $xml .= "</url>";
    $xml .= "<url>";
    $xml .= "<loc>https://bebets.ru/".$championat->getSsilka()."-vse-turi.html</loc>";
    $xml .= "<changefreq>daily</changefreq>";
    $xml .= "</url>";
}


if($pages_prognozi>1){
    for($i=2;$i<=$pages_prognozi;$i++){
        $xml .= "<url>";
        $xml .= "<loc>https://bebets.ru/prognozi.php?p=".$i."</loc>";
        $xml .= "<changefreq>daily</changefreq>";
        $xml .= "</url>";
    }
}
if($pages_novosti>1){
    for($i=2;$i<=$pages_novosti;$i++){
        $xml .= "<url>";
        $xml .= "<loc>https://bebets.ru/news.php?p=".$i."</loc>";
        $xml .= "<changefreq>daily</changefreq>";
        $xml .= "</url>";
    }
}
if($pages_otzivi>1){
    for($i=2;$i<=$pages_novosti;$i++){
        $xml .= "<url>";
        $xml .= "<loc>https://bebets.ru/otzivi.php?p=".$i."</loc>";
        $xml .= "<changefreq>weekly</changefreq>";
        $xml .= "</url>";
    }
}



$xml .="</urlset>";
file_put_contents("/home/bebets/bebets.ru/www/sitemap.xml", $xml);



?>