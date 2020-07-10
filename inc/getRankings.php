<?php
function getRankings($last_place, $pq, $compQuality){
    $ranks = [];
    for ($rank = 1; $rank <= $last_place; $rank++) {
        $p_placing = ($last_place - $rank + 1) / $last_place;
        $pp = max([pow($p_placing, 1 + $pq), pow($p_placing, 2)]);
        $w = round($pp * $compQuality * 100, 1);
        $ranks[] = (float)$w;
    }
    return $ranks;
}