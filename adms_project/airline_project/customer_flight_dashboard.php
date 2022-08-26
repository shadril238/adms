<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">

    <title>AMS</title>
    <link rel="stylesheet" href="style2.css">
    </head>
    <body>
    <div class="container">
        <h1>CUSTOMER FLIGHT DASHBOARD</h1>
    </div>
    <div id="mainHolder" style="overflow: auto; max-height: 500px;">
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

<div class="center">    
  <form method="post">

    <div class="txt_field">
      <input type="text" name="departure" required>
      <label>Departure</label>
    </div>

    <div class="txt_field">
      <input type="text" name="destination" required>
        <label>Destination</label>
      </div>

      <div class="txt_field">
        <input type="date" name="d_time" required>
        <label>Departure Time</label>
      </div>

      <div class="txt_field">
      <input type="date" name="a_time" required>
        <label>Arival Time</label>
      </div>

      <div class="txt_field">
        <input type="number" name="cost" required>
        <label>Flight Cost </label>
      </div>

      <div class="txt_field">
        <input type="text" name="f_class" required>
        <label>Flight Class </label>
      </div>

      <div class="txt_field">
        <input type="number" name="mgr_id" required>
        <label>Assigned Manager ID </label>
      </div>

      <input type="submit" value="ADD FLIGHT" name="submit">
    </form>
</div>      

<?php
    if (isset($_POST['submit'])) {
      $departure=$_POST["departure"];
      $destination = $_POST["destination"];
      $d_time = date("d-m-Y",strtotime($_POST["d_time"]));
      $a_time = date("d-m-Y ",strtotime($_POST["a_time"]));
      $cost = $_POST["cost"];    
      $f_class = $_POST["f_class"];
      $mgr_id = $_POST["mgr_id"];
      
      $query="INSERT INTO FLIGHT VALUES (seq_flight_id.NEXTVAL, '$departure','$destination',to_date('".$d_time."','dd-mm-yy'), to_date('".$a_time."','dd-mm-yy'), '$cost', '$f_class','$mgr_id')";
      $stid = oci_parse($conn, $query);
      
      if (!$stid) {
        $m = oci_error($conn);
        trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      $r = oci_execute($stid );
      if (!$r) {
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      else{
        echo '<script>alert("Booking status pending. Waiting for payment")</script>';
      } 
    }      
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
</body>
</html>