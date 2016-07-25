<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ChronoGramm</title>
    <meta name="description" content="">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1,width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
	   <link rel="shortcut icon" href="https://cdn.knightlab.com/libs/blueline/latest/assets/logos/favicon.ico">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
     <link title="timeline-styles" rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
     <link title="timeline-styles" rel="stylesheet" href="css/style.css">
     <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
  </head>
  <body>
      <div id="header">
        <a href="index.php">
          <h1>ChronoGramm</h1>
          <h3>L'actualité d'un coup d'oeil</h3>
        </a>
      </div>
      <div id='timeline-embed' style="width: 100%; height: 800px"></div>
      <?php
      require('traitements/getEvents.php');
      ?>
      <script type="text/javascript">
        var additionalOptions = {
            start_at_slide: 0,
            debug:true
        }
        var data = $("#data").html();
        console.log(data);
        timeline = new TL.Timeline('timeline-embed',
          'traitements/timeline.json', additionalOptions);
      </script>
  </body>
</html>
