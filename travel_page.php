<!-- Daniel Miller - Program 6 - PHP I -->

<?php
session_start();
  $id = $_SESSION['id'];
  $user = $_SESSION['user']; 
  
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Trip Tracker</title>
</head>
<style>
h1 {
	text-align: center;
}
div {
	text-align: center;
	border: 1px solid;
	padding: 20px;
	width: 520px;
	margin: 0 auto;
}
</style>
<div>
<h1>Trip Tracker</h1>
<h2>Welcome <?php echo $user; ?>! </h2>
<form action="travel_page.php" method="POST">
	Trip Date: <input type="text" name="date"><br><br>
	Miles Traveled: <input type="number" name="miles"><br><br>
	Gallons Used: <input type="number" name="gallons"><br><br>
	Location: <select name="city"> 
				<option value="chicago">Chicago </option>
				<option value="cincinnati">Cincinnati </option>
				<option value="indianapolis">Indy </option>
				<option value="nashville">Nashville</option>
				<option value="st. louis">St. Louis</option>
			</select><br><br>
	<input type="submit" value="Submit" name="submit"><br>

<?php

 if($_SERVER['REQUEST_METHOD'] == "POST") {
      $date = $_POST['date'];
      $miles = $_POST['miles'];
	  $gallons = $_POST['gallons'];
	  $location = $_POST['city'];
	  
	  $db = new SQLite3('travel_expenses.sqlite') or die('Unable to open database');
	  $sql = "INSERT INTO trips VALUES(NULL, '$id', '$date', '$location', '$miles', '$gallons')";
	  $result = $db->exec($sql) or die("Error: INSERT into trips failed"); 
      echo "<p>Insert operation successful</p>";
		
	 $sql = "SELECT trips.emp_id, trips.date, trips.destination, trips.gallons, trips.miles, members.lastname FROM trips JOIN members ON trips.emp_id = members.emp_id WHERE trips.emp_id = '$id'";
     $result = $db->query($sql);
	  
      echo "<table cellspacing='10'>";
      echo "<tr><th>Employee</th><th>Date</th><th>Location</th><th>MPG</th></tr>";
  
      while($row = $result->fetchArray(SQLITE3_ASSOC)) {
          echo "<tr>";
			 echo "<td>" . $row['lastname'] . "</td>";
             echo "<td>" . $row['date'] . "</td>";
			 echo "<td>" . $row['destination'] . "</td>";
			 $mpgr = $row['miles'] / $row['gallons'];
			 $mpg = round($mpgr, 1);
             echo "<td>" . $mpg . "</td>";
          echo "</tr>";
	  }
}

?>
</div>
</html>
