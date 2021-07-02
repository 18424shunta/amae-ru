<?php
  include 'db_config.php';

  $person_data = array();

  try
  {
     // connect
     $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     // 人を取得
     $stmt = $db->query("SELECT * FROM person");
     $person_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

     $db = null;
  }
  catch(PDOException $e)
  {
   echo $e->getMessage();
   exit;
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>あまえーる.グラフ</title>
  <link rel="stylesheet" href="css/styles.css">
  
  <script
    src="https://code.jquery.com/jquery-3.5.1.js"
    integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous">
  </script>
  
  <!-- fullcalendar -->
  <!-- <link href='fullcalendar/fullcalendar.min.css' rel='stylesheet' />
  <link href='fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
  <script src='fullcalendar/lib/moment.min.js'></script>
  <script src='fullcalendar/fullcalendar.min.js'></script> -->

  <!-- calendar -->
  <script src='sample_calendar/fullcalendar/lib/main.min.js'></script>
  <script src='sample_calendar/fullcalendar/lib/locales-all.js'></script>
  <link href='sample_calendar/fullcalendar/lib/main.min.css' rel='stylesheet' />
  
  <!-- <script>
    var jqOther = jQuery.noConflict(true);
  </script> -->
  <!-- datalabelsプラグインを呼び出す -->
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <!-- chart-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  
</head>

<body>
<div class="boxContainer">
  <div class="box_left">
    <div class="box">
      <select name='person' id="name">
      <option value='0'>全体</option>
        <?php
          foreach($person_data as $p){
            $name = $p['name'];
            $id = $p['id'];
            echo "<option value='$id'>$name</option>";
          }
        ?>
      </select>
      <!-- calendar -->
      <div class="calendar"></div>
      <div id="calendar"></div>
      <!-- 日付表示 -->
      <div class="date_txt">
        期間開始<input id="start_date" type="text"></input>
        <!-- <br> -->
        期間終了<input id="end_date" type="text"></input>
      </div>
      <!-- map -->
      <div class="map_place">
        <div id="map"></div>
      </div>
    </div>
  </div>

  <div class="box">
    <!-- center -->
    <div class="chart">
      <canvas id="fish_catch_count"　width="250%" height="250%"></canvas>
    </div>
    <!-- <div class="right">右</div> -->
  </div>
</div>

  <script src='js/main.js'></script>
    <!-- map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjpcBI57XAEzvIqzNBEj4eIpVzRaRe93U&libraries=geometry&callback=init_map"></script>
</body>
</html>