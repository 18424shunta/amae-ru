<?php
  ini_set( 'display_errors', 1 );
  include '../db_config.php';
  $selected_start_date = $_POST["s_date"];//"2021-06-25 00:00:00";
  $selected_end_date = $_POST["e_date"];//"2021-06-25 23:59:59";
  $selected_person_id = $_POST["person_id"];//"1";
//   $selected_start_date = "2021-06-25 00:00:00";
//   $selected_end_date = "2021-06-25 23:59:59";
//   $selected_person_id = "1";
  $num01 = (int) $selected_person_id;
  try
  {
    // connect
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql="SELECT latitude,longitude FROM `GPS` WHERE person_id={$selected_person_id}  AND date_time>='{$selected_start_date} 00:00:00' AND date_time<='{$selected_end_date} 23:59:59'";
    if($num01=="0"){
    $sql="SELECT latitude,longitude FROM `GPS` WHERE date_time>='{$selected_start_date} 00:00:00' AND date_time<='{$selected_end_date} 23:59:59'";
    }
    $stmt = $db->query($sql);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
    print(json_encode($data));
    $db = null;
  }catch(PDOException $e)
  {
   echo $e->getMessage();
   exit;
  }
?>