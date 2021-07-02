<?php
  ini_set( 'display_errors', 1 );
  include '../db_config.php';
  $selected_start_date = $_POST["s_date"];//"2021-06-25 00:00:00";
  $selected_person_id = $_POST["person_id"];//"1";
//   $selected_start_date = "2021-06-11";
//   $selected_person_id = "1";
//   echo $selected_start_date;
  try
  {
    // connect
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql="SELECT latitude,longitude FROM `GPS` WHERE person_id='{$selected_person_id}'  AND date_time>='{$selected_start_date} 00:00:00' AND date_time<='{$selected_start_date} 23:59:59'";
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