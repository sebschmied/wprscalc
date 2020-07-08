<?php
// https://www.fai.org/sites/default/files/civl/documents/sporting_code_s7_e_-_wprs_2019.pdf
//  the sum of previous month ranking-points for the top 1/2 ranked pilots that are entered in the competition
$pq_srp = 8186.9;

// sum of ranking-points as if those pilots would have been the top ranked pilots of the world
$pq_srtp = 	12649.9;

$no_of_pilots = 83;
$no_of_pilots_last_12_months = 6543;
$no_of_comps_last_12_months = 96;
$number_of_tasks = 2;
$days_since_end_of_comp = 0;

$last_place = 80;


$pq_min = 0.2;
$pq_override = false;
$pq = $pq_srp / $pq_srtp * (1 - $pq_min) + $pq_min;
if ($pq_override !== false){
    $pq = $pq_override;
}
echo "pq: $pq" . PHP_EOL;


$pn_max = 1.2;
$avg_number_of_participants_last_12_months = $no_of_pilots_last_12_months / $no_of_comps_last_12_months;
$pn = sqrt($no_of_pilots /  $avg_number_of_participants_last_12_months);
if ($pn > $pn_max){
    $pn = $pn_max;

}
echo "pn: $pn" . PHP_EOL;


$ta = 0;
if ($number_of_tasks > 0){
    $ta = 0.5;
}

if ($number_of_tasks > 1){
    $ta = 0.8;
}

if ($number_of_tasks > 2){
    $ta = 1.0;
}

echo "ta: $ta" . PHP_EOL;


$td_a = 2;
$td_b = 20;

$td = 1/(1 + pow($td_a, ($days_since_end_of_comp / 1096.0 * $td_b - $td_b / 2.0)) );

echo "td: $td" . PHP_EOL;

$competition_ranking = $pq * $pn * $ta;
echo "comp rank: $competition_ranking" . PHP_EOL;

for ($i=1; $i<=$last_place; $i++){
    $pilot_place = $i;
    $p_placing = ($last_place - $pilot_place + 1) / $last_place;
    $pp = max([pow($p_placing, 1 + $pq), $p_placing * $p_placing]);
    $pp_r = round($pp, 2);
    $w =round( $pp * $pq * $pn * $ta * $td*100, 1);
    echo "Rank $i: $w ($pp_r pilot points)" . PHP_EOL;
}


