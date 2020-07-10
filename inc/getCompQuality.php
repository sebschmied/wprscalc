<?php
function getCompQuality($pq_srp, $pq_srtp, $no_of_pilots, $avg_number_of_participants_last_12_months, $number_of_tasks, $days_since_end_of_comp, &$pq)
{
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

    $pq =
        $pq_srp
        /
        $pq_srtp
        * (1 - $pq_min)
        + $pq_min;


    echo "participant quality: $pq out of 1.0" . PHP_EOL;

    $pn = sqrt($no_of_pilots / $avg_number_of_participants_last_12_months);
    if ($pn > $pn_max) {
        $pn = $pn_max;
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

    echo "comp success: $ta out of 1.0 ($number_of_tasks of 3 tasks)" . PHP_EOL;

    $td = 1 / (1 + pow($td_a, ($days_since_end_of_comp / 1096.0 * $td_b - $td_b / 2.0)));

    echo "time devaluation: $td" . PHP_EOL . PHP_EOL;

    $competition_ranking = $pq * $pn * $ta;
    return $competition_ranking;
}