<?php
require("traitements/config.php");
$req = $bdd->prepare("SELECT headline, media, month, day, year FROM events");
$req->execute();
$req->setFetchMode(PDO::FETCH_OBJ);
$events = array();
while($data = $req->fetch()){
  $media = array("url" => "$data->media");
  $date = array("month" => "$data->month", "day" => "$data->day", "year" => "$data->year");
  $headline = array("headline" => "$data->headline");
  $eventSingle = array("media" => $media, "start_date" => $date, "text" => $headline);
  array_push($events, $eventSingle);
}
$fileEvents = fopen('traitements/timeline.json', 'r+');
fputs($fileEvents, '{"events":'.json_encode($events).'}');
fclose($fileEvents);
?>
