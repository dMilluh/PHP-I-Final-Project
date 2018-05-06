<!-- Daniel Miller - Program 6 - PHP I -->

<?php session_start(); ?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>
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
<form action="index.php" method="POST">
Username: <input type="text" name="username"><br><br>
Password: <input type="text" name="password"><br><br>
<input type="submit" value="Log In" name="login"><br>
</form>
</div>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
      if(isset($_POST['username']) && isset($_POST['password'])) {
           $user = $_POST['username'];
           $pw = $_POST['password'];
   
           $db = new SQLite3('travel_expenses.sqlite') or die('Unable to open database');

          $sql = "SELECT * FROM members WHERE USERNAME = '$user' AND PASSWORD = '$pw'";
          $result = $db->query($sql);
          $row = $result->fetchArray(SQLITE3_ASSOC);
  
          if(!empty($row)) { 
              $_SESSION['id'] = $row['emp_id'];
              $_SESSION['user'] = $row['username']; 
              header("Location: travel_page.php");
          }
     }
     echo "Login failed.";
 }
?>
