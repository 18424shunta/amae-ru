<?php
  ini_set( 'display_errors', 1 );
  include '../db_config.php';
  // $selected_date = "2021-06-12";
  // $selected_person_id = "2";
  $selected_start_date = $_POST["s_date"];
  $selected_end_date = $_POST["e_date"];
  $selected_person_id = $_POST["person_id"];
  $num01 = (int) $selected_person_id;
  try{
    // connect
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql="select sum(catch_fish) as catch ,fish_id,person_id,date ,fish.name as name
    from catch 
    left join fish on fish.id=catch.fish_id 
    WHERE person_id=$selected_person_id AND date>='$selected_start_date' AND date<='$selected_end_date' group by fish_id  ";

    if($num01=="0"){
      $sql="select sum(catch_fish) as catch ,fish_id,person_id,date ,fish.name as name
      from catch 
      left join fish on fish.id=catch.fish_id 
      WHERE date>='$selected_start_date' AND date<='$selected_end_date' group by fish_id  ";
    }
    $stmt = $db->query($sql);

    $catch = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $fish_sum=array_column($catch,"catch");
    $fish_name=array_column($catch,"name");

    $ret =array("fish_sum"=>$fish_sum,"fish_name"=>$fish_name);

    $db = null;
   }
   catch(PDOException $e)
   {
    echo $e->getMessage();
    exit;
   }
   header('Content-Type: application/json'); // apiにしますよーってやつ
   $json = json_encode($ret);
   print ($json);  
?>