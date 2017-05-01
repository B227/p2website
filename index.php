<?php

    /* Your Database Name */
    $dbname = 'SM';

    /* Your Database User Name and Passowrd */
    $username = 'root';
    $password = 'kopkaffe';

    try {
      /* Establish the database connection */
      $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      /* Gathering Data from the differnet databases */
      // effect
      $result = $conn-> prepare('SELECT id, effect, effectHour, voltage, ampere, timeStamp, totalStr FROM SM1 WHERE id = :smid');
      $result->execute(array('smid' => 1));
      //effecthour
      $result2 = $conn-> prepare('SELECT id, effect, effectHour, voltage, ampere, timeStamp, totalStr FROM SM1 WHERE id = :smid');
      $result2->execute(array('smid' => 1));
      //voltage
      $result3 = $conn-> prepare('SELECT id, effect, effectHour, voltage, ampere, timeStamp, totalStr FROM SM1 WHERE id = :smid');
      $result3->execute(array('smid' => 1));
      //ampere
      $result4 = $conn-> prepare('SELECT id, effect, effectHour, voltage, ampere, timeStamp, totalStr FROM SM1 WHERE id = :smid');
      $result4->execute(array('smid' => 1));

      /* Creating Arrays for the different data */
      $rows = array();
      $table = array();
      $rows2 = array();
      $table2 = array();
      $rows3 = array();
      $table3 = array();
      $rows4 = array();
      $table4 = array();
      $table['cols'] = array(
        array('label' => 'Time Stamp', 'type' => 'string'),
        array('label' => 'EffectHour', 'type' => 'number')

    );
      $table2['cols'] = array(
        array('label' => 'Time Stamp', 'type' => 'string'),
        array('label' => 'Effect', 'type' => 'number')

    );
     $table3['cols'] = array(
        array('label' => 'Time Stamp', 'type' => 'string'),
        array('label' => 'Voltage', 'type' => 'number')

    );
     $table4['cols'] = array(
        array('label' => 'Time Stamp', 'type' => 'string'),
        array('label' => 'Ampere', 'type' => 'number')

    );

        /* Extract the information from $result for #1 */
        foreach($result as $r) {

          $temp = array();

          // the following line will be used to slice the Pie chart

          $temp[] = array('v' => (string) $r['timeStamp']); 

          // Values of each slice

          $temp[] = array('v' => (int) $r['effectHour']); 
          $rows[] = array('c' => $temp);
        }

       /* Extract the information from $result for #2 */
        foreach($result2 as $r2) {

          $temp2 = array();

          // the following line will be used to slice the Pie chart

          $temp2[] = array('v' => (string) $r2['timeStamp']); 

          // Values of each slice

          $temp2[] = array('v' => (int) $r2['effect']); 
          $rows2[] = array('c' => $temp2);
        }
       /* Extract the information from $result for #3 */
        foreach($result3 as $r3) {

          $temp3 = array();

          // the following line will be used to slice the Pie chart

          $temp3[] = array('v' => (string) $r3['timeStamp']); 

          // Values of each slice

          $temp3[] = array('v' => (int) $r3['voltage']); 
          $rows3[] = array('c' => $temp3);
        }
        /* Extract the information from $result for #4 */
        foreach($result4 as $r4) {

          $temp4 = array();

          // the following line will be used to slice the Pie chart

          $temp4[] = array('v' => (string) $r4['timeStamp']); 

          // Values of each slice

          $temp4[] = array('v' => (int) $r4['ampere']); 
          $rows4[] = array('c' => $temp4);
        }
/* Filling Out Rows */
    $table['rows'] = $rows;
    $table2['rows'] = $rows2;
    $table3['rows'] = $rows3;
    $table4['rows'] = $rows4;

    // convert data into JSON format
    $jsonTable = json_encode($table);
    $jsonTable2 = json_encode($table2);
    $jsonTable3 = json_encode($table3);
    $jsonTable4 = json_encode($table4);
    //echo $jsonTable;
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    ?>


    <html>
      <head>
        <!--Load the Ajax API-->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawEffectHour);
        google.setOnLoadCallback(drawEffect);
        google.setOnLoadCallback(drawVoltage);
        google.setOnLoadCallback(drawAmpere);
        
// Function for EffectHour
        function drawEffectHour() {

          // Create our data table out of JSON data loaded from server.
          var data = new google.visualization.DataTable(<?=$jsonTable?>);
          var options = {
               title: 'EffectHour',
              is3D: 'true',
              width: 800,
              height: 600
            };
          // Instantiate and draw our chart, passing in some options.
          // Do not forget to check your div ID
          var chart = new google.visualization.LineChart(document.getElementById('chart_effectHour'));
          chart.draw(data, options);
        }
//Function for Effect
function drawEffect() {

          // Create our data table out of JSON data loaded from server.
          var data = new google.visualization.DataTable(<?=$jsonTable2?>);
          var options = {
               title: 'Effect',
              is3D: 'true',
              width: 800,
              height: 600
            };
          // Instantiate and draw our chart, passing in some options.
          // Do not forget to check your div ID
          var chart = new google.visualization.LineChart(document.getElementById('chart_effect'));
          chart.draw(data, options);
        }
//Function for VOltage
function drawVoltage() {

          // Create our data table out of JSON data loaded from server.
          var data = new google.visualization.DataTable(<?=$jsonTable3?>);
          var options = {
               title: 'Voltage',
              is3D: 'true',
              width: 800,
              height: 600
            };
          // Instantiate and draw our chart, passing in some options.
          // Do not forget to check your div ID
          var chart = new google.visualization.LineChart(document.getElementById('chart_voltage'));
          chart.draw(data, options);
        }
//Function for Ampere
function drawAmpere() {

          // Create our data table out of JSON data loaded from server.
          var data = new google.visualization.DataTable(<?=$jsonTable4?>);
          var options = {
               title: 'Effect',
              is3D: 'true',
              width: 800,
              height: 600
            };
          // Instantiate and draw our chart, passing in some options.
          // Do not forget to check your div ID
          var chart = new google.visualization.LineChart(document.getElementById('chart_ampere'));
          chart.draw(data, options);
        }

// Continues Function

        </script>
      </head>

      <body>
      <center>
        <!--this is the div that will hold the pie chart-->
<h1>Effect/Hour</h1>       
 <div id="chart_effectHour"></div>
<h1>Effect</h1>        
<div id="chart_effect"></div>
<h1>Voltage</h1>        
<div id="chart_voltage"></div>
<h1>Ampere</h1>        
<div id="chart_ampere"></div>
	</center>      
</body>
    </html>
