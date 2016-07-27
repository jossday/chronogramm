<?php
session_start();
require("config.php");
$search = htmlentities(addslashes($_GET['q']));
$req = $bdd->prepare('SELECT * FROM events WHERE headline LIKE \'%'.$search.'%\' OR contenu LIKE \'%'.$search.'%\' OR year LIKE \'%'.$search.'%\' OR letter_month LIKE \'%'.$search.'%\'');
$req->execute();
$req->setFetchMode(PDO::FETCH_OBJ);
$res = $req->fetchAll();
if (count($res)!=0){
  $events = array();
  foreach($res as $data){
    $media = array("url" => "$data->media");
    $date = array("month" => "$data->month", "day" => "$data->day", "year" => "$data->year");
    $headline = array("headline" => "$data->headline");
    $eventSingle = array("media" => $media, "start_date" => $date, "text" => $headline);
    array_push($events, $eventSingle);
  }
  $fileEvents = fopen('search.json', 'r+');
  fputs($fileEvents, '{"events":'.json_encode($events).'}');
  fclose($fileEvents);
}
else
{
echo "No result";
}

?>
