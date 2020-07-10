<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Comp WPRS prognosis</title>
    <meta name="description" content="Can't wait ...">
    <meta name="author" content="Sebastian Schmied">

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

echo "<h2>Estimate for comp $compid WPRS points</h2>" . PHP_EOL;
echo "<p>Assuming $tasks tasks (set <em>tasks</em> parameter in URL) and current month's rankings.</p>" . PHP_EOL;
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
    echo "<li>\t<strong>$rankings[$i]</strong> points</li>". PHP_EOL;
}
echo "</ol>". PHP_EOL;
?>

</div>
<p>Get other comp IDs <a href="http://civlrankings.fai.org/FL.aspx?a=303">here</a> and set the compid parameter in the url.</p>

</body>