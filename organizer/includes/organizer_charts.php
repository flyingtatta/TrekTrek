<?php
  $trek_organizer_id = $_SESSION['user_id'];
  $treks = recordCountTreks('treks', $trek_organizer_id);
  //tablename, where data, where clause
  $treks_status_on  = recordCountForTreks('treks','trek_status','On',$trek_organizer_id);
  $treks_status_off = recordCountForTreks('treks','trek_status','Off',$trek_organizer_id);
  $trek_type        = recordCount('trek_type');
?>


<div class="container mt-5">
  <script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Date', 'Count'],

      <?php

      $element_text = ['Treks', 'Treks On', 'Treks Off','Type-of-Treks'];
      $element_count = [$treks, $treks_status_on, $treks_status_off, $trek_type];

      for($i = 0; $i < sizeof($element_text); $i++){
        echo "['{$element_text[$i]}'" . ", "."{$element_count[$i]}],";
      }
      ?>
    ]);

    var options = {
      chart: {
        title:    '',
        subtitle: '',
      }
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
  </script>
  <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
</div>
