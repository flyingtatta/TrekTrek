<?php
include 'includes/organizer_header.php';
session_start();

if (isOrganizer()){
  include 'includes/organizer_navigation.php';

  $treks = recordCount('treks');
  //tablename, where data, where clause

  $treks_status_on  = recordCountFor('treks', 'trek_status', 'On');
  $treks_status_off = recordCountFor('treks', 'trek_status', 'Off');
?>


  <div class="container mt-5">
    <script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Date', 'Count'],

        <?php

        $element_text = ['Treks', 'Treks On', 'Treks Off'];
        $element_count = [$treks, $treks_status_on, $treks_status_off];

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

<?php
  include 'includes/organizer_footer.php';

}else{
  header("Location: ../index.php");
}
?>
