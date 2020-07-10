<?php
require_once 'getPilotRank.php';

function get_Pq_srp(array $participants, &$half){
    $points = [];
    foreach ($participants as $p){
        $pilotPoints = getPilotPoints($p);
        if ($pilotPoints === 0){
            continue;
        }
        $points[] = $pilotPoints;

    }

    $half = round(count($points) / 2);

    rsort($points);

    $firstHalf = array_slice($points, 0, $half);


    return array_sum($firstHalf);
}