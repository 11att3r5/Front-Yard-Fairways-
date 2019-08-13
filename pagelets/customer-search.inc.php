<!--Alexander Grimes March 4th 2017
	This page was created to allow employees to search/add/delete customers as well as view info-->
<div class="dashboard">
	<?php
		include("includes/dashboard-nav.inc.php");
	?>
	<div class="dash-display">
		<div id="cusSearch">
			<h2>Customer Search</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=customer-search">
				<div>
					<label>Customer #:</label><input type="text" name="CustomerID">
				</div>
				<div>
					<label>First Name:</label><input type="text" name="FirstName">
				</div>
				<div>
					<label>Last Name:</label><input type="text" name="LastName">
				</div>
				<div class="button-container">
					<input type="submit" name="search" value="Search">
				</div>
			</form>
			<div id="search-results">
				
		<?php
			require_once('DB-info.php');//connect to DB.

			//Insert new customer if add customer has been submitted
			// April 16th, 2017
			if (isset($_POST['addCustomer'])) { // Handle the form.
				//Register user in database.
				//Function to escape data.
				function escapeData($data){
					global $dbc;
					if(ini_get('magic_quotes_gpc')){
						$data = stripcslashes($data);
					}
					return mysql_real_escape_string($dbc,$data);
				}

				$userName = $_POST['userName'];
				$password = $_POST['password'];
				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$phoneNum = $_POST['phone'];
				$email = $_POST['email'];
				$address = $_POST['address'];
				$state = $_POST['state'];

				// If everything's okay.
					$query = "INSERT INTO Users (userName, password, Rank) VALUES ('$userName', SHA1('$password'), '1')";	


					$result = @mysqli_query($dbc, $query);//Run the query
					$queryTwo = "INSERT INTO Customers (userName, FirstName, LastName, phoneNum, Email, Address, state, Rank) VALUES ('$userName', '$firstName', '$lastName', '$phoneNum', '$email', '$address', '$state', '1')";
					$resultTwo = @mysqli_query($dbc, $queryTwo);

					if ($result && $resultTwo) {//if Everything ran ok
						echo '<p>SUCESS!!!!</p>';
					}else{//If it did not run ok
						echo '<p>You could not be registered due to a system error. We apologize for any inconvenience.</p><p>' . mysqli_error($dbc) . '</p>';
					}

					$cusID = mysqli_insert_id($dbc);
					$plan = $_POST['plan'];
					$mulching = $_POST['mulching'];
					$weeding = $_POST['Weeding'];
					$hedging = $_POST['Hedging'];
					$garden = $_POST['GardenMaintanence'];
					$weedControl = $_POST['WeedControl'];
					$treeTrim = $_POST['TreeTrimming'];
					$presureWashing = $_POST['preasureWashing'];

					$query = "INSERT INTO Services(CustomerID, Plan, Mulching, Weeding, TreePruning, Gardening, Hedging, WeedControl) VALUES ('$cusID','$plan', '$mulching', '$weeding', '$treeTrim', '$garden', '$hedging', '$weedControl')";
					$result = @mysqli_query($dbc, $query);//Run the query

					$queryTwo = "INSERT INTO Assignments (CustomerID, CustomerPlan, Address, phone) VALUES ('$cusID', '$plan', '$address', '$phone') ";
					$resultTwo = @mysqli_query($dbc, $queryTwo);//Run the query
			}
			//Delete Customer and all data associated
			//April 16th 2017
			if (isset($_POST['delete'])) {
				$cusID = $_POST['cusID'];
				$userName = $_POST['userName'];
				$query = "DELETE FROM Users WHERE userName = '$userName'";	
				$upResult = @mysqli_query($dbc, $query);

				if ($upResult) {//if Everything ran ok
					echo '<p>SUCESS!!!!</p>';
				}else{//If it did not run ok
					echo '<p>You could not be registered due to a system error. We apologize for any inconvenience.</p><p>' . mysqli_error($dbc) . '</p>';
				}
			}

			//Display all customers in a table also sortable
			//March 4th 2017
			$display = 10;
			if (isset($_GET['p']) && is_numeric($_GET['p'])) {
				$pages = $_GET['p'];
			}
			else{
				$q = "SELECT COUNT(CustomerID) FROM Customers";
				$r = @mysqli_query($dbc, $q);
				$row = @mysqli_fetch_array($r, MYSQLI_NUM);
				$records = $row[0];
				if ($records > $display) {
					$pages = ceil($records/$display);
				}else{
					$pages = 1;
				}
			}

			if (isset($_GET['s']) && is_numeric($_GET['s'])) {
				$start = $_GET['s'];
			}else{
				$start = 0;
			}

			$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'id';

			switch ($sort) {
				case 'id':
					$order_by = 'CustomerID ASC';
					break;

				case 'name':
					$order_by = 'LastName ASC';
					break;

				case 'address':
					$order_by = 'Address ASC';
					break;
				
				default:
					$order_by = 'CustomerID ASC';
					$sort = 'id';
					break;
			}
			if (isset($_POST['search'])) {
				$fields = array('CustomerID','FirstName', 'LastName');
				$conditions = array();
				foreach ($fields as $field) {
					if (isset($_POST[$field]) && $_POST[$field] != '') {
						$conditions[] = "$field LIKE '" . mysqli_escape_string($dbc , $_POST[$field]) . "%'";
					}
				}
				$query = "SELECT CustomerID AS id, CONCAT(LastName, ', ', FirstName) AS name, CONCAT(Address, ' ', state) AS address FROM Customers";

				if (count($fields) > 0) {
					//Search conditions
					$query .= " WHERE " . implode (' AND ', $conditions);
					$query .= " ORDER BY $order_by LIMIT $start, $display";
				}
			}else{
				$query = "SELECT CustomerID AS id, CONCAT(LastName, ', ', FirstName) AS name, userName AS userName, CONCAT(Address, ' ', state) AS address FROM Customers ORDER BY $order_by LIMIT $start, $display";
			}
			$r = @mysqli_query($dbc, $query);

			echo '<table>
					<tr>
						<th><a href="index.php?pagelet=customer-search&sort=id">Customer #</a></th>
						<th><a href="index.php?pagelet=customer-search&sort=name">Name</a></th>
						<th><a href="index.php?pagelet=customer-search&sort=userName">User Name</a></th>
						<th><a href="index.php?pagelet=customer-search&sort=address">address</a></th>
					</tr>';

			$bg = '#eeeeee';//Background color
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$bg = ($bg =='#eeeeee' ? '#fff' : '#eeeeee'); //Switch bg color
				echo '
					<tr bgcolor ="' . $bg . '">
						<td>' . $row['id'] . '</td>
						<td>' . $row['name'] . '</td>
						<td>' . $row['userName'] . '</td>
						<td>' . $row['address'] . '</td>
					</tr>';
			}
			echo '</table>';
			mysqli_free_result($r);
			mysqli_close($dbc);

			if ($pages > 1) {
				echo "</br><p>";

				$current_page = ($start/$display) + 1;

				if ($current_page != 1) {
					echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?pagelet=customer-search?s=' . ($start - $display) . '&p=' . $pages . '$sorts=' . $sort . '">Previous</a>';
				}

				for($i = 1; $i <= $pages; $i++){
					if($i != $current_page){
						echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?pagelet=customer-search?s=' . (($display * ($i -1))) . '&p=' . $pages . '$sorts=' . $sort . '">' . $i . '</a>';
					}else{
						echo $i . ' ';
					}
				}

				if ($current_page != $pages) {
					echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?pagelet=customer-search?s=' . ($start + $display) . '&p=' . $pages . '$sorts=' . $sort  . '">Next</a>';
				}
				echo '</p>';
			}

			//Add Customer form(only visible to managers)
			//April 16th 2017
			if ($_SESSION['Rank'] == 2) {

			?>
			<div>
				<p><h3>Add Customer</h3></p>
				<form id="admin" name="addEmp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=customer-search" method="post">
					<label>User Name:</label><input type="text" name="userName"></input>
					<label>First Name:</label><input type="text" name="firstName">
					<label>Last Name:</label><input type="text" name="lastName">
					<label>Phone #:</label><input type="text" name="phone"></input>
					<label>Address</label><input type="text" name="address"></input>
					<label>State</label><input type="text" name="state"></input>
					</br>
					<label>Email:</label><input type="text" name="email"></input>
					<label>Password</label><input type="text" name="password"></input>
					<div>
					<label>Service</label>
						<select name="plan" required>
							<option value="ParI">Par I</option>
							<option value="ParII">Par II</option>
							<option value="ParIII">Par III</option>
						</select>
					<label>Sq. Ft.</label>
						<select>
							<option>500FT</option>
							<option>1000FT</option>
							<option>+1000FT</option>
						</select>
					</div>
					<div>
						<label>Additional Services</label></br>
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
					<input type="submit" name="addCustomer" value = "Submit">
				</form>
			</div>
		<?php
		}
		//Delete customer and all associated data(only visible to managers)
		//April 16th 2017
		if ($_SESSION['Rank'] == 2) {

			?>
			<div>
				<p><h3>Delete Customer</h3></p>
				<form id="admin" name="delEmp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=customer-search" method="post">
					<label>Customer ID</label><input type="text" name="cusID"></input>
					<label>User Name</label><input type="text" name="userName"></input>
					<input type="submit" name="delete" value = "Submit">
				</form>
			</div>
		<?php
		}
		?>
			</div>
		</div>
	</div>
</div>