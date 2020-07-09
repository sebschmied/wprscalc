<?php
$civlid=33136;
if (isset($argv[1])){
    $civlid = $argv[1];
}
if (isset($_GET["civlid"])) {
    $civlid = $_GET["civlid"];
}

$html = file_get_contents("http://civlrankings.fai.org/?a=322&person_id=$civlid");
$re = '/<td>Paragliding<\/td><td>\d\d\d\d-\d\d-\d\d<\/td><td><a href=\'\?a=326&ladder_id=3&ranking_date=\d\d\d\d-\d\d-\d\d&name=.*\'>[0-9.]+<\/a>/';
$num = preg_match($re, $html, $matches);
$current = $matches[0];
$beginning = '/<td>Paragliding<\/td><td>\d\d\d\d-\d\d-\d\d<\/td><td><a href=\'\?a=326&ladder_id=3&ranking_date=\d\d\d\d-\d\d-\d\d&name=.*\'>/';
$current = preg_replace($beginning, '', $current);
$current = rtrim($current, "</a>");

$score = floatval($current);
echo $score;
return $score;

//$xpath = '/html/body/form/div[3]/table/tr[2]/td[3]/a/text()';
//$result = $xml->xpath($xpath);

//var_dump($result);