<?php
function getRankings($last_place, $pq, $compQuality){
    $ranks = [];
    for ($i = 1; $i <= $last_place; $i++) {
        $pilot_place = $i;
        $p_placing = ($last_place - $pilot_place + 1) / $last_place;
        $pp = max([pow($p_placing, 1 + $pq), $p_placing * $p_placing]);
        $pp_r = round($pp, 2);
        $w = round($pp * $compQuality * 100, 1);
        $ranks[] = $w;
    }
    return $ranks;
}