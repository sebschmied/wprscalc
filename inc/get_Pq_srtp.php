<?php
/**
 * @param $amount
 * @param $matches
 * @return mixed
 */
function get_pq_srtp($amount)
{
    $points = [];
    $start_rank = 1;
    while (count($points) < $amount) {
        $html = file_get_contents("http://civlrankings.fai.org/?start_rank=1&a=326&ladder_id=3&start_rank=$start_rank");
        $re = '/<\/a><\/td><td>\d+.\d<\/td><td>/m';
        preg_match_all($re, $html, $matches);


        foreach ($matches[0] as $m) {
            $m = preg_replace('/<\/a><\/td><td>/', '', $m);
            $m = preg_replace('/<\/td><td>/', '', $m);
            $points[] = floatval($m);
        }
        $start_rank += 100;
    }
    $topx = array_slice($points, 0, $amount);
    return  array_sum($topx);

}

