<?php

function getPilotPoints($civlid)
{
    $html = file_get_contents("http://civlrankings.fai.org/?a=322&person_id=$civlid");
    $re = '/<td>Paragliding<\/td><td>\d\d\d\d-\d\d-\d\d<\/td><td><a href=\'\?a=326&ladder_id=3&ranking_date=\d\d\d\d-\d\d-\d\d&name=.*\'>[0-9.]+<\/a>/';
    preg_match($re, $html, $matches);
    if (count($matches) === 0) {
        return 0;
    }
    $current = $matches[0];
    $beginning = '/<td>Paragliding<\/td><td>\d\d\d\d-\d\d-\d\d<\/td><td><a href=\'\?a=326&ladder_id=3&ranking_date=\d\d\d\d-\d\d-\d\d&name=.*\'>/';
    $current = preg_replace($beginning, '', $current);
    $current = rtrim($current, "</a>");

    $score = floatval($current);
    return $score;
}
