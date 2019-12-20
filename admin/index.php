<?php
include 'includes/admin_header.php';
session_start();

if (isAdmin()){
  include 'includes/admin_navigation.php';

  $users = recordCount('users');
  //tablename, where data, where clause
  $organizers = recordCountFor('users', 'user_role','Organizer');
  $admin = recordCountFor('users', 'user_role','Admin');
  $treks = recordCount('treks');

?>


  <div class="container mt-5">
    <script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Date', 'Count'],

        <?php

        $element_text = ['Users', 'Organizers', 'Admin', 'Treks'];
        $element_count = [$users,$organizers,$admin,$treks];

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
  include 'includes/admin_footer.php';

}else{
  header("Location: ../index.php");
}
?>
