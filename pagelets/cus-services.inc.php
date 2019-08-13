<?php
	if (isset($_POST['submit'])) { // Handle the form.
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

		// If everything's okay.
			$query = "INSERT INTO Users (userName, password, Rank) VALUES ('{$_SESSION['post']['userName']}', SHA1('{$_SESSION['post']['password']}'), '1')";	


			$result = @mysqli_query($dbc, $query);//Run the query
			$queryTwo = "INSERT INTO Customers (userName, FirstName, LastName, phoneNum, Email, Address, state, Rank) VALUES ('{$_SESSION['post']['userName']}', '{$_SESSION['post']['firstName']}','{$_SESSION['post']['lastName']}','{$_SESSION['post']['phone']}','{$_SESSION['post']['email']}','{$_SESSION['post']['address']}','{$_SESSION['post']['state']}','1')";
			$resultTwo = @mysqli_query($dbc, $queryTwo);

			if ($result && $resultTwo) {//if Everything ran ok
				echo '<p>SUCESS!!!!</p>';
			}else{//If it did not run ok
				echo '<p>You could not be registered due to a system error. We apologize for any inconvenience.</p><p>' . mysqli_error($dbc) . '</p>';
			}

		//Get customer ID
		$cusID = mysqli_insert_id($dbc);

		if (isset($_POST['switch_3'])) {
			$planTest = TRUE;
		} else {
			$planTest = FALSE;
			echo '<p>You forgot to select a plan!</p>';
		}

		if (empty($_POST['times'])) {
			$times = FALSE;
			echo '<p>You forgot to select a time!</p>';
		} else {
			$times = $_POST['times'];
		}

		$plan = $_POST['switch_3'];
		$mulching = $_POST['mulching'];
		$weeding = $_POST['Weeding'];
		$hedging = $_POST['Hedging'];
		$garden = $_POST['GardenMaintanence'];
		$weedControl = $_POST['WeedControl'];
		$treeTrim = $_POST['TreeTrimming'];
		$presureWashing = $_POST['preasureWashing'];

		if ($planTest && $times) {
			// If everything's okay.
			//get current user ID and make query
			//Send info to DB
			$query = "INSERT INTO Services(CustomerID, Plan, Mulching, Weeding, TreePruning, Gardening, Hedging, WeedControl) VALUES ('$cusID','$plan', '$mulching', '$weeding', '$treeTrim', '$garden', '$hedging', '$weedControl')";
			$result = @mysqli_query($dbc, $query);//Run the query

			$queryTwo = "INSERT INTO Assignments (CustomerID, CustomerPlan, Address, phone) VALUES ('$cusID', '$plan', '{$_SESSION['post']['address']}', '{$_SESSION['post']['phone']}') ";
			$resultTwo = @mysqli_query($dbc, $queryTwo);//Run the query
			if ($result && $resultTwo) {//if Everything ran ok
				mysqli_close($dbc); // Close the database connection.
				$_SESSION = array();
				session_destroy();
				//Send user to home page.
				header("Location: index.php?pagelet=login");
				}else{//If it did not run ok
					echo '<p>Error.</p><p>' . mysqli_error($dbc) . '</p>';
				}

		}
	}
?>
<div class="content-wrap">
	<div class="cusHome">
		<div>
			<h1>Plans and Services</h1>
		</div>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=cus-services">
			<div id="servicebtn-container">		
			    <div class="switch-field">
					<input type="radio" id="switch_3_left" name="switch_3" value="ParI" checked/>
					<label for="switch_3_left">Par I</label>
					<input type="radio" id="switch_3_center" name="switch_3" value="ParII" />
					<label for="switch_3_center">Par II</label>
					<input type="radio" id="switch_3_right" name="switch_3" value="ParIII" />
					<label for="switch_3_right">Par III</label>
			    </div>
			</div>
			<hr>
			<div id="plans">
				<div id="ParI" class="plan">
					<div>
						<h2>Area</h2>
						<p>500 Sq. Ft.</p>
					</div>
					<div>
						<h2>Includes</h2>
						<p>Hedging, Mulching, Edging</p>
					</div>
					<div>
						<h2>Price per service</h2>
						<p>$25.00</p>
					</div>
				</div>
				<div id="ParII" class="plan">
					<div>
						<h2>Area</h2>
						<p>500 - 1000 Sq. Ft.</p>
					</div>
					<div>
						<h2>Includes</h2>
						<p>Hedging, Mulching, Edging</p>
					</div>
					<div>
						<h2>Price per service</h2>
						<p>$35.00</p>
					</div>
				</div>
				<div id="ParIII" class="plan">
					<div>
						<h2>Area</h2>
						<p>+1000 Sq. Ft.</p>
					</div>
					<div>
						<h2>Includes</h2>
						<p>Hedging, Mulching, Edging</p>
					</div>
					<div>
						<h2>Price per service</h2>
						<p>$50.00</p>
					</div>
				</div>
			</div>
			<div>
				<div id="service-amount">
					<h2>Services Per Month</h2>
					<select name="times" required>
						<option value="">--</option>
						<option value="weekly">weekly</option>
						<option value="monthly">mothly</option>
						<option value="annually">annually</option>
					</select>
				</div>
			</div>
			<hr>
			<div>
				<div id="add-services">
					<div>
						<h2>Additional Services</h2>
					</div>
					<div id="input-flex">
						<input type="hidden" name="mulching" value="0"/>
						<input type="checkbox" name = mulching value="1">Mulching</input>
						<input type="hidden" name="Hedging" value="0"/>
						<input type="checkbox" name = "Hedging" value="1">Hedging</input>
						<input type="hidden" name="GardenMaintanence" value="0"/>
						<input type="checkbox" name="GardenMaintanence" value="1">Garden Maintanence</input>
						<input type="hidden" name="WeedControl" value="0"/>
						<input type="checkbox" name="WeedControl" value="1">Weed Control</input>
						<input type="hidden" name="Weeding" value="0"/>
						<input type="checkbox" name="Weeding" value="1">Weeding</input>
						<input type="hidden" name="TreeTrimming" value="0"/>
						<input type="checkbox" name="TreeTrimming" value="1">Tree Trimming</input>
						<input type="hidden" name="preasureWashing" value="0"/>
						<input type="checkbox" name="preasureWashing" value="1">Preasure Washing</input>
					</div>
				</div>
			</div>
			<hr>
			<div>
				<div>
					<a href="javascript:history.back();" class="non-action">Back</a>
					<input type="submit" name="submit" value="Register" class="action">
				</div>
			</div>
		</form>
	</div>
</div>