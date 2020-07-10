<pre>
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

$participants = getParticipants($compid, $lastRank);
$no_of_participants = count($participants);
$pq_srp = get_Pq_srp($participants, $half);
$pq_srtp =  get_pq_srtp($half);



$avgParticipants = getAvgParticipants();


$compQuality = getCompQuality($pq_srp, $pq_srtp, $no_of_participants, $avgParticipants, $tasks, $days_since_end_of_comp, $pq);
$rankings = getRankings($lastRank, $pq, $compQuality);

echo "total rating for comp $compid: $compQuality" . PHP_EOL;
for ($i=0; $i<count($rankings); $i++){
    $rank = $i+1;
    echo "Rank $rank: $rankings[$i]";
    echo PHP_EOL;


}
?>
</pre>