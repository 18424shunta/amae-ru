let map;//地図
let marker ;
let markers = [];//マーカー

let personSelect;//プルダウンメニュー
// var fish_catch_count_chart;//グラフ
var ctx; //
// var calendar_Selected_date;//カレンダー

var selected_person_id = "1";//プルダウンメニュー選択値
var selected_start_date = gettoday();//カレンダー選択値
// var selected_end_date = gettoday();//カレンダー選択値

/* -------------------------------------
 * 人選択
 * ------------------------------------*/
function valueChange() {
  console.log('新しく ' + personSelect.value + ' を選択しました');
  selected_person_id = personSelect.value;
  // updateChart(fish_catch_count_chart);
  // resetMarkers();
  delete_markers();
  plot_marker();
}
/* -------------------------------------
 * 本日の日付
 * ------------------------------------*/
function gettoday() {
  const date = new Date()
  const Y = date.getFullYear()
  const M = ("00" + (date.getMonth() + 1)).slice(-2)
  const D = ("00" + date.getDate()).slice(-2)
  const time = Y + "-" + M + "-" + D;
  return time;
}
/* -------------------------------------
 *部品の初期化
 * ------------------------------------*/
$(document).ready(function () {
  // 人
  personSelect = document.getElementById('name');
  personSelect.options[2].selected = true;
  personSelect.addEventListener('change', valueChange);
  $('#name').val(selected_person_id);
  // カレンダー
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    aspectRatio: 1,
    locale: "ja",
    contentHeight: 'auto',
    height: 250,
    dayCellContent: function (e) {
      e.dayNumberText = e.dayNumberText.replace('日', '');
    },
    select: function (date) { // ユーザが日付を選択したときの処理
      // console.log("select callback");
      console.log(date);
      // テキストボックスの初期化
      $("#start_date").val();
      // $("#end_date").val();

      // 取得した日は1日分多いので期間最終日を一日引く
      // var _e_date = date.end.setDate(date.end.getDate() - 1);
      // var end_date = formattedDate(_e_date);

      // 選択した期間をテキストボックスに設置
      $("#start_date").val(date.startStr);
      // $("#end_date").val(end_date);
      selected_start_date = date.startStr;
      // selected_end_date = end_date;
      // マーカー更新
      delete_markers();
      plot_marker();
    }
  });
  calendar.render();
});


/* -------------------------------
  * 時間の書式を整える処理
  * -------------------------------*/
function formattedDate(unixtime) {
  var _date = new Date(unixtime);

  var y = _date.getFullYear();
  var m = _date.getMonth() + 1;
  var d = _date.getDate();

  m = ("00" + m).slice(-2); // 桁のゼロ埋め
  d = ("00" + d).slice(-2);

  return y + "-" + m + "-" + d;
}
/* -------------------------------------
 *データ取得
 * ------------------------------------*/
function POST_data(parameter, url) {
  return $.ajax({
    url: url,
    type: "POST",
    data: parameter,
    catch: false
  });
}

/* -------------------------------------
 *地図
 * ------------------------------------*/
function init_map() {
  // let marker;
  let infoWindow;
  let MyLatLng = { lat: 34.482202426091355, lng: 136.8249725042339};//鳥羽駅座標:34.48699198479235, 136.84317924173925//鳥羽商船34.482202426091355, 136.8249725042339
  let Options = {
    zoom: 11,      //地図の縮尺値
    center: MyLatLng,    //地図の中心座標
    mapTypeId: 'roadmap'   //地図の種類
  };
  map = new google.maps.Map(document.getElementById('map'), Options);
  plot_marker();
}
/* -------------------------------------
 *マーカー
 * ------------------------------------*/
// マーカーセット
function plot_marker() {
  var parameter = { "s_date": selected_start_date, "person_id": selected_person_id };//"e_date": selected_end_date,
  POST_data(parameter, "api/get_gps_movie.php").then(function (data) {

    data = JSON.parse(data);
    // console.log(data);
    console.log("gps データ数："+data.length); // デバックするために必要なデータを出力する
    for (var i = 0; i < data.length; i++) {
      // console.log(data[i]["latitude"]);
      // parseInt(data[i]["latitude"], 10);
      marker = new google.maps.Marker({ // マーカーの追加
        position: { lat: parseFloat(data[i]["latitude"]), lng: parseFloat(data[i]["longitude"]) }, // マーカーを立てる位置を指定
        map: map // マーカーを立てる地図を指定
      });
      // マーカーオブジェクトを配列 markers（グローバル変数）に保存する
      markers.push(marker);
    }
  });
}

function delete_markers() {
  if(markers.length > 0){
    for(var i=0; i<markers.length; i++) {
      // マーカーを一つづつ削除
      markers[i].setMap(null);
    }
  }
  // 今までのマーカーオブジェクトを配列から削除する
  markers = [];
}
