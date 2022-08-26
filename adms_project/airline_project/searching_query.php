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
        <h1>SEARCHING QUERIES</h1>
    </div>
    
</div>
    <div class="row">
        <div class="column">
            <!--one-->
            <h2 style="color:white;">Flight With Minimum Cost</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    $conn = oci_connect('ADMS', 'tiger', '//localhost/XE');   
                    if (!$conn) {
                    echo 'Failed to connect to oracle' . "<br>";
                    }

                    $stid = oci_parse($conn, 'select * from flight where flight_cost=(select min(flight_cost) from flight)');
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
        </div>    
        <div class="column">

        <h2 style="color:white;">Manager Who Approved Maximum Flights</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    
                    $stid = oci_parse($conn, 'select mgr_id,mgr_name from manager where mgr_id in (select m.mgr_id from manager m, flight f where m.mgr_id=f.mgr_id group by m.mgr_id having count(m.mgr_id) in (select max(count(m.mgr_id)) from manager m, flight f where m.mgr_id=f.mgr_id group by m.mgr_id))');
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>MANAGER_ID</th>
                        <th>MANAGER_NAME</th>
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['MGR_ID'] . "</td>";
                echo "<td>" . $row['MGR_NAME'] . "</td>";
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>
        <div class="column">
            <h2 style="color:white;">Customer With Maximum Booked Flight</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    
                    $stid = oci_parse($conn, "select * from customer where customer_id in (select c.customer_id from customer c, flight f, booking b where c.customer_id=b.customer_id and b.flight_id=f.flight_id group by c.customer_id having count(c.customer_id) in (select max(count(c.customer_id)) from customer c, flight f, booking b where c.customer_id=b.customer_id and b.flight_id=f.flight_id group by c.customer_id))");
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>CUSTOMER_ID</th>
                        <th>CUSTOMER_NAME</th>
                        <th>CUSTOMER_EMAIL</th>
                        <th>CUSTOMER_PHN</th>                        
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['CUSTOMER_ID'] . "</td>";
                echo "<td>" . $row['CUSTOMER_NAME'] . "</td>";
                echo "<td>" . $row['CUSTOMER_EMAIL'] . "</td>";
                echo "<td>" . $row['CUSTOMER_PHN'] . "</td>";
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column">
            <!--two-->
            <h2 style="color:white;">FLIGHT-WISE TOTAL BOOKED TICKETS</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    $stid = oci_parse($conn, 'select f.flight_id, sum(t.total_ticket) as booked_tickets from flight f, ticket t, order_ticket ot where t.ticket_id=ot.ticket_id and ot.flight_id=f.flight_id group by f.flight_id');
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>FLIGHT_ID</th>
                        <th>TOTAL BOOKED TICKETS</th>
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['FLIGHT_ID'] . "</td>";
                echo "<td>" . $row['BOOKED_TICKETS'] . "</td>";
                
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>    
        <div class="column">
            <h2 style="color:white;">Business Class Flight Lowest Cost</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    
                    $stid = oci_parse($conn, "select flight_id,departure,destination, departure_time from flight where flight_class='business' and flight_cost in (select min(flight_cost) from flight where flight_class='business')");
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>FLIGHT_ID</th>
                        <th>DEPARTURE</th>
                        <th>DESTINATION</th>
                        <th>DEPARTURE_TIME</th>
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['FLIGHT_ID'] . "</td>";
                echo "<td>" . $row['DEPARTURE'] . "</td>";
                echo "<td>" . $row['DESTINATION'] . "</td>";
                echo "<td>" . $row['DEPARTURE_TIME'] . "</td>";
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>
        <div class="column">
        <h2 style="color:white;">Customers Who Booked FLights</h2>
            <div id="mainHolder" style="overflow: auto; max-height: 300px;">
                <?php
                    
                    $stid = oci_parse($conn, "select distinct c.customer_name, c.customer_email from customer c, ticket t where
                    c.customer_id=t.customer_id and ticket_status='pending'");
                    oci_execute($stid);
                    echo "<table border='1'>
                    <tr>
                        <th>CUSTOMER_NAME</th>
                        <th>CUSTOMER_EMAIL</th>
                        
                    </tr>";

                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                echo "<tr>";
                echo "<td>" . $row['CUSTOMER_NAME'] . "</td>";
                echo "<td>" . $row['CUSTOMER_EMAIL'] . "</td>";
                echo "</tr>";
                }
                echo "</table>\n";
                ?>
            </div>
        </div>
    </div>



     

<?php  
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
</body>
</html>