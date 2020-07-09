<?php
// https://www.fai.org/sites/default/files/civl/documents/sporting_code_s7_e_-_wprs_2019.pdf


// if you know any of these values (e.g. from the WPRS, or when experimenting), you can set them here and ignore the rest.
// If not, leave them on false and fill the factors they are made of.
$pq_override = false;
$ta_override = false;
$pn_override = false;
$td_override = false;

/*
 * Participants quality
 */
//  the sum of previous month ranking-points for the top 1/2 ranked pilots that are entered in the competition
$pq_srp = 7850.9;

// sum of ranking-points as if those pilots would have been the top ranked pilots of the world
$pq_srtp = 12090.9;


/*
 * Participants number
 */
// total number of pilots in comp
$no_of_pilots = 83;

//total number of comp participants in the entire WPRS over the last 12 months
$no_of_pilots_last_12_months = 6543;

//total number of comps in the entire WPRS over the last 12 months
$no_of_comps_last_12_months = 96;

/*
 * Comp quality
 */
//number of tasks (completed or stopped, not canceled) in the comp
$number_of_tasks = 2;

/*
 * Rank spread
 */
//rank achieved by the last placed pilot(s)
//Usually less than the number of participants because ranks are shared by pilots with equal scores
$last_place = 80;

/*
 * Time devaluation
 */

//days since end of comp (=last task)
$days_since_end_of_comp = 0;
/******************************************************************************/
/*
 * Do not change any of the variables that follow, they are constants defined by the FAI.
 */

define('TD_B', $td_b = 20);
define('TD_A', $td_a = 2);
define('TA', $ta = 0);
define('PN_MAX', $pn_max = 1.2);
define('PQ_MIN', $pq_min = 0.2);

PQ_MIN;
PN_MAX;
TA;
TD_A;
TD_B;

/*
 * Calculations start here.
 */

$pq = $pq_srp / $pq_srtp * (1 - $pq_min) + $pq_min;
if ($pq_override !== false) {
    $pq = $pq_override;
}
echo "participant quality: $pq out of 1.0" . PHP_EOL;



$avg_number_of_participants_last_12_months = $no_of_pilots_last_12_months / $no_of_comps_last_12_months;
$pn = sqrt($no_of_pilots / $avg_number_of_participants_last_12_months);
if ($pn > $pn_max) {
    $pn = $pn_max;
}
if ($pn_override !== false) {
    $pn = $pn_override;
}
echo "participant number: $pn out of $pn_max" . PHP_EOL;



if ($number_of_tasks > 0) {
    $ta = 0.5;
}

if ($number_of_tasks > 1) {
    $ta = 0.8;
}

if ($number_of_tasks > 2) {
    $ta = 1.0;
}
if ($ta_override !== false) {
    $ta = $ta_override;
}
echo "comp success: $ta out of 1.0 ($number_of_tasks of 3 tasks)" . PHP_EOL;

$td = 1 / (1 + pow($td_a, ($days_since_end_of_comp / 1096.0 * $td_b - $td_b / 2.0)));
if ($td_override !== false) {
    $td = $td_override;
}
echo "time devaluation: $td" . PHP_EOL . PHP_EOL;

$competition_ranking = $pq * $pn * $ta;
echo "total comp quality: $competition_ranking" . PHP_EOL . PHP_EOL;
echo "WPRS points:" . PHP_EOL.PHP_EOL;
for ($i = 1; $i <= $last_place; $i++) {
    $pilot_place = $i;
    $p_placing = ($last_place - $pilot_place + 1) / $last_place;
    $pp = max([pow($p_placing, 1 + $pq), $p_placing * $p_placing]);
    $pp_r = round($pp, 2);
    $w = round($pp * $pq * $pn * $ta * $td * 100, 1);
    echo "Rank $i: $w ($pp_r)" . PHP_EOL;
}


