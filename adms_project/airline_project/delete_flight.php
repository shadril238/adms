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
    <a href="ADMIN_DASHBORD.php" >ADMIN DASHBORD</a> 

    <div class="container">
        <h1>FLIGHT DASHBOARD FOR DELETION</h1>
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
 
    <!--delete-->
    <div class="center">    
    <form method="post">

    <div class="txt_field">
      <input type="text" name="f_id" required>
      <label>Flight ID</label>
    </div>
      <input type="submit" value="Delete FLIGHT" name="submit">
    </form>
    </div> 

<?php
    if (isset($_POST['submit'])){
      $f_id=$_POST["f_id"];

      $sql="begin
      delete_flight(:f_id);
      end;";
      $stid = oci_parse($conn, $sql);
      oci_bind_by_name($stid,':f_id',$f_id,50);

      if (!$stid) {
        $m = oci_error($conn);
        trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      $r = oci_execute($stid );
      if ($r) {
        oci_commit($conn);
        echo '<script>alert("Flight deleted successfully")</script>';
        header("refresh: 0; url=delete_flight.php"); 
      }
      else {
        echo '<script>alert("Flight deletion unsuccessfull")</script>';
        //header("refresh: 0; url=delete_flight.php");
      } 
    }
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
        
</body>
</html>