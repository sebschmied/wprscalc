<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Comp WPRS prognosis</title>
    <meta name="description" content="Can't wait ...">
    <meta name="author" content="Sebastian Schmied">
    <meta name="robots" content="noindex" /> <!-- Every call scrapes a number of FAI pages - better not get too much attention -->

    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-cg6SkqEOCV1NbJoCu11+bm0NvBRc8IYLRGXkmNrqUBfTjmMYwNKPWBTIKyw9mHNJ" crossorigin="anonymous">

</head>
<body style="margin:1em;">


<div>
<?php
require_once "inc/get_Pq_srtp.php";
require_once "inc/get_Pq_srp.php";
require_once "inc/getParticipants.php";
require_once "inc/getAvgParticipants.php";
require_once "inc/getCompQuality.php";
require_once "inc/getRankings.php";

$compid = 5427;
$tasks = 3;
$days_since_end_of_comp = 0;

if (isset($_GET["compid"])){
    $compid = $_GET["compid"];
}

if (isset($_GET["tasks"])){
    $tasks = $_GET["tasks"];
}

if (isset($_GET["days"])){
    $tasks = $_GET["days"];
}

echo "<h2>Estimate for <a href='http://civlrankings.fai.org/FL.aspx?a=310&l=0&competition_id=$compid'>comp #$compid</a> WPRS points</h2>" . PHP_EOL;
echo "<p>Assuming $tasks tasks (set <em>tasks</em> parameter in URL) and current month's rankings, and that the current average number of participants doesn't change significantly.</p>" . PHP_EOL;
echo "<p>Get other comp IDs <a href=\"http://civlrankings.fai.org/FL.aspx?a=303\">here</a> and set the <em>compid</em> and <em>tasks</em> parameters in the url. Don't try comps that have already been scored - P_q and P_n will be off. This tool is meant only to get an estimate of your score between comp being sent to FAI and the monthly WPRS update for those that can't wait. For all older comps, simply look them up.</p>";
$participants = getParticipants($compid, $lastRank);
$no_of_participants = count($participants);
$pq_srp = get_Pq_srp($participants, $half);
$pq_srtp =  get_pq_srtp($half);



$avgParticipants = getAvgParticipants();

echo "<h3>Parameters</h3>";
$compQuality = getCompQuality($pq_srp, $pq_srtp, $no_of_participants, $avgParticipants, $tasks, $days_since_end_of_comp, $pq);
$rankings = getRankings($lastRank, $pq, $compQuality);

echo "<p>total rating for comp $compid: $compQuality</p>" . PHP_EOL;
echo "<h3>WPRS points by rank</h3>";
echo "<ol>". PHP_EOL;
for ($i=0; $i<count($rankings); $i++){
    $points = number_format($rankings[$i], 1);
    echo "<li>\t<strong><span style='font-size: larger;'>$points</span></strong></li>". PHP_EOL;
}
echo "</ol>". PHP_EOL;
?>

</div>

</body>