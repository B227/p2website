<?php

    /* Your Database Name */
    $dbname = 'gameboos_SM';

    /* Your Database User Name and Passowrd */
    $username = 'gameboos_itcuser';
    $password = 'ITCTest123!';

    try {
      /* Establish the database connection */
      $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      /* select all the weekly tasks from the table googlechart */
      $result = $conn->query('SELECT * FROM SM3');
      $result2 = $conn->query('SELECT * FROM SM3');



      $rows = array();
      $table = array();
      $rows2 = array();
      $table2 = array();
      $table['cols'] = array(
        array('label' => 'Time Stamp', 'type' => 'string'),
        array('label' => 'EffectHour', 'type' => 'number')

    );
      $table2['cols'] = array(
        array('label' => 'Time Stamp', 'type' => 'string'),
        array('label' => 'Effect', 'type' => 'number')

    );
        /* Extract the information from $result */
        foreach($result as $r) {

          $temp = array();

          // the following line will be used to slice the Pie chart

          $temp[] = array('v' => (string) $r['timeStamp']); 

          // Values of each slice

          $temp[] = array('v' => (int) $r['effectHour']); 
          $rows[] = array('c' => $temp);
        }

                /* Extract the information from $result */
        foreach($result2 as $r2) {

          $temp2 = array();

          // the following line will be used to slice the Pie chart

          $temp2[] = array('v' => (string) $r2['timeStamp']); 

          // Values of each slice

          $temp2[] = array('v' => (int) $r2['effect']); 
          $rows2[] = array('c' => $temp2);
        }

    $table['rows'] = $rows;
    $table2['rows'] = $rows2;

    // convert data into JSON format
    $jsonTable = json_encode($table);
    $jsonTable2 = json_encode($table2);
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

// Continues Function

        </script>
      </head>

      <body>
        <!--this is the div that will hold the pie chart-->
        <div id="chart_effectHour"></div>
        <div id="chart_effect"></div>
      </body>
    </html>
