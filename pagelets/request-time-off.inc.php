<?php
	if (isset($_POST['submit'])) { // Handle the form.
		error_reporting(E_ALL);
		//Register user in database.
		require_once('DB-info.php');//connect to DB.
		//Function to escape data.
		function escapeData($data){
			global $dbc;
			if(ini_get('magic_quotes_gpc')){
				$data = stripcslashes($data);
			}
			return mysql_real_escape_string($dbc,$data);
		}
		
		if (empty($_POST['start'])) {
			$start = FALSE;
			echo "You need a start day.";
		}else{
			$start = $_POST['start'];
		}
		if (empty($_POST['end'])) {
			$end = FALSE;
			echo "You need an end day.";
		}else{
			$end = $_POST['end'];
		}

		if ($start && $end) {
			$query = "INSERT INTO TimeOff (EmployeeID, StartDay, EndDay) VALUES ('{$_SESSION['EmpId']}', '$start', '$end')";
			$result =  @mysqli_query($dbc, $query);//Run the query
			if ($result) {
				echo "SUCCESS";
			}else{
				echo '<p>Error.</p><p>' . mysqli_error($dbc) . '</p>';
			}
		}else{
			echo "error";
		}
	}
?>
<div class="dashboard">
	<?php
		include("includes/dashboard-nav.inc.php");
	?>
	<div class="dash-display">
		<div class="center">
			<h2>Request Time Off</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=request-time-off">
				<label>Start Day</label><input type="date" name="start">
				<label>End Day</label><input type="date" name="end">
				<div class="button-conatiner">
					<input type="submit" name="submit" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>