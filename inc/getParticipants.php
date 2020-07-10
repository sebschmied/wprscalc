<?php
//$compid=5427;



function getParticipants($compid, &$lastRank)
{
    $html = file_get_contents("http://civlrankings.fai.org/?a=334&competition_id=$compid");
    $re = '/&person_id=\d+/m';
    preg_match_all($re, $html, $matches);
    $civlids = [];
    foreach ($matches[0] as $m) {

        $civlids[] = (int)filter_var($m, FILTER_SANITIZE_NUMBER_INT);
    }

    $re = '/<\/td><\/tr><tr><td class=\'table2\' nowrap=\'1\'>\d+ <\/td><td class=\'table2\' nowrap=\'1\'><a href=/m';
    $ranks = [];
    preg_match_all($re, $html, $matches_ranks );

    foreach ($matches_ranks[0] as $r){

        $r = preg_replace('/<\/td><\/tr><tr><td class=\'table2\' nowrap=\'1\'>/', '', $r);
        $r = preg_replace('/ <\/td><td class=\'table2\' nowrap=\'1\'><a href=/', '', $r);
        $ranks[] = intval($r);
    }
    //var_export($ranks);
    $lastRank = end($ranks);

    return $civlids;
}
