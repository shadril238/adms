<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>AMS</title>
    <link rel="stylesheet" href="style2.css">
    <style>
    a:link, a:visited {
    background-color: #2691d9;
    border-radius: 25px;
    color: white;
    padding: 14px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    }

    a:hover, a:active {
    background-color: skyblue;
    }
    </style>
    </head>
    <body>
    <a href="index.php" >HOME</a>
    <a href="ADMIN_DASHBORD.php" >ADMIN DASHBOARD</a>
    <div class="container">
        <h1>PROCEDURE</h1>
    </div>
    <div id="mainHolder" style="overflow: auto; max-height: 450px;">
    <?php
        $conn = oci_connect('ADMS', 'tiger', '//localhost/XE');   
        if (!$conn) {
          echo 'Failed to connect to oracle' . "<br>";
        }

        $stid = oci_parse($conn, 'SELECT * FROM flight');
        oci_execute($stid);
        echo "<table border='1'>
        <tr>
            <th>FLIGHT_ID</th>
            <th>DEPARTURE</th>
            <th>DESTINATION</th>
            <th>DEPARTURE_TIME</th>
            <th>ARRIVAL_TIME</th>
            <th>FLIGHT_COST</th>
            <th>FLIGHT_CLASS</th>
            
        </tr>";

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
    echo "<tr>";
    echo "<td>" . $row['FLIGHT_ID'] . "</td>";
    echo "<td>" . $row['DEPARTURE'] . "</td>";
    echo "<td>" . $row['DESTINATION'] . "</td>";
    echo "<td>" . $row['DEPARTURE_TIME'] . "</td>";
    echo "<td>" . $row['ARRIVAL_TIME'] . "</td>";
    echo "<td>" . $row['FLIGHT_COST'] . "</td>";
    echo "<td>" . $row['FLIGHT_CLASS'] . "</td>";
    echo "</tr>";
    }
    echo "</table>\n";
    ?>
</div>
    <div class="row">
        <div class="column">
        <div class="center">    
            <form method="post">            

            <div class="txt_field">
                <input type="number" name="f_id" required>
                <label>Flight ID </label>
            </div>

            <div class="txt_field">
                <input type="number" name="cost" required>
                <label>Flight Cost </label>
            </div>

            <input type="submit" value="UPDATE FLIGHT COST" name="submit">
            </form>
        </div>
        </div>
        <div class="column">
        <div class="center">    
            <form method="post">            

            <div class="txt_field">
                <input type="number" name="f_id1" required>
                <label>Flight ID </label>
            </div>

            <div class="txt_field">
                <input type="text" name="departure" required>
                <label>Flight Departure</label>
            </div>

            <input type="submit" value="UPDATE FLIGHT DESTINATION" name="submit1">
            </form>
        </div>  
        </div>
    </div>
  </div>


     

<?php
    if (isset($_POST['submit'])) {
        $f_id=$_POST["f_id"];
      $cost = $_POST["cost"];    

      $query="begin 
              p_flight.flight_cost_up(:f_id,:cost);
              end;";
      $stid = oci_parse($conn, $query);
      
      oci_bind_by_name($stid,':f_id',$f_id,50);
      oci_bind_by_name($stid,':cost',$cost,50);
    
      if (!$stid ) {
        $m = oci_error($conn);
        trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      
      $r = oci_execute($stid );
      if ($r) {
        echo '<script>alert("Updated Successfully")</script>';
        header("refresh: 0");  
      }
      else{
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");    
      }
    }    
    else if (isset($_POST['submit1'])) {
      $f_id1=$_POST["f_id1"];
      $departure = $_POST["departure"];    

      $query1="begin 
              p_flight.flight_departure_up(:f_id1,:departure);
              end;";
      $stid1 = oci_parse($conn, $query1);
      
      oci_bind_by_name($stid1,':f_id1',$f_id1,50);
      oci_bind_by_name($stid1,':departure',$departure,50);
    
      if (!$stid1 ) {
        $m1 = oci_error($conn);
        trigger_error('Could not parse statement: '. $m1['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      
      $r1 = oci_execute($stid1 );
      if ($r1) {
        echo '<script>alert("Updated Successfully")</script>';
        header("refresh: 0");  
      }
      else{
        $m1 = oci_error($stid1);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");    
      }
    }  
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
</body>
</html>