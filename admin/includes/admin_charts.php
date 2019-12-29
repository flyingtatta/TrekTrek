<?php
$accounts   = recordCount('users');
//tablename, where data, where clause
$users      = recordCountFor('users', 'user_role','User');
$organizers = recordCountFor('users', 'user_role','Organizer');
$admin      = recordCountFor('users', 'user_role','Admin');

$treks      = recordCount('treks');
$trek_type  = recordCount('trek_type');
?>


<script type="text/javascript">
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['', 'Count'],

    <?php

    $element_text = ['Accounts','Users','Organizers', 'Admin', 'Treks','Type-of-Treks'];
    $element_count = [$accounts,$users,$organizers,$admin,$treks,$trek_type];

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
<div class="container mt-5">
  <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
</div>
