<?php
function getAvgParticipants()
{
    $html = file_get_contents("http://civlrankings.fai.org/?a=327&ladder_id=3");
    $re = '/<td>[0-9.]*<\/td><td>[0-9.]*<\/td><td>[0-9]*<\/td><td style=\'white-space:nowrap;\'>[0-9]{4}-[0-9]{2}-[0-9]{2}<\/td><td>[0-9]+<\/td><td>[0-9]+/m';

    preg_match($re, $html, $matches);

    $numComps = lastyearNumberOfComps($matches[0]);
    $totalPilots = lastyearTotalPilots($matches[0]);

    return $numComps / $totalPilots;
}

function lastyearNumberOfComps($str){
    $re = '/<td>[0-9.]*<\/td><td>[0-9.]*<\/td><td>[0-9]*<\/td><td style=\'white-space:nowrap;\'>[0-9]{4}-[0-9]{2}-[0-9]{2}<\/td><td>/m';
    $s = preg_replace($re, '', $str);
    $s = preg_replace('/\d+$/', '', $s);
    return intval($s);
}

function lastyearTotalPilots($str){
    preg_match('/\d+$/', $str, $matches);
    return intval($matches[0]);
}