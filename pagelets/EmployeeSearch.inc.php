<!--Alexander Grimes March 4th 2017
	This page was created to allow managers/employess to search/add/delete employees as well as view info-->
<div class="dashboard">
	<?php
		include("includes/dashboard-nav.inc.php");
	?>
	<div class="dash-display">
		<div id="cusSearch">
			<h2>Employee Search</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=EmployeeSearch">
				<div>
					<label>Employee #:</label><input type="text" name="EmployeeID">
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

			//Insert new Employee
			//April 16th 2017
			if (isset($_POST['submit'])) {
				$userName = $_POST['userName'];
				$FirstName = $_POST['FirstName'];
				$LastName = $_POST['LastName'];
				$Phone = $_POST['Phone'];
				$Email = $_POST['email'];
				$password = $_POST['password'];
				$query = "INSERT INTO Users (userName, password, Rank) VALUES ('$userName', SHA1('$password'), '3')";	
				$upResult = @mysqli_query($dbc, $query);
				$queryTwo = "INSERT INTO Employees (userName, FirstName, LastName, PhoneNumber, Email) VALUES ('$userName','$FirstName', '$LastName','$Phone','$Email')";
				$resultTwo = @mysqli_query($dbc, $queryTwo);

				if ($upResult && $resultTwo) {//if Everything ran ok
					echo '<p>SUCESS!!!!</p>';
				}else{//If it did not run ok
					echo '<p>You could not be registered due to a system error. We apologize for any inconvenience.</p><p>' . mysqli_error($dbc) . '</p>';
				}
			}
			//Delete employee
			//April 16th 2017
			if (isset($_POST['delete'])) {
				$empID = $_POST['empID'];
				$userName = $_POST['userName'];
				$query = "DELETE FROM Users WHERE userName = '$userName'";	
				$upResult = @mysqli_query($dbc, $query);

				if ($upResult) {//if Everything ran ok
					echo '<p>SUCESS!!!!</p>';
				}else{//If it did not run ok
					echo '<p>You could not be registered due to a system error. We apologize for any inconvenience.</p><p>' . mysqli_error($dbc) . '</p>';
				}
			}
			//Displays all employees in a table that is also sortable
			$display = 10;
			if (isset($_GET['p']) && is_numeric($_GET['p'])) {
				$pages = $_GET['p'];
			}
			else{
				$q = "SELECT COUNT(EmployeeID) FROM Employees";
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
					$order_by = 'EmployeeID ASC';
					break;

				case 'name':
					$order_by = 'LastName ASC';
					break;

				case 'address':
					$order_by = 'Email ASC';
					break;
				
				default:
					$order_by = 'EmployeeID ASC';
					$sort = 'id';
					break;
			}
			if (isset($_POST['search'])) {
				$fields = array('EmployeeID','FirstName', 'LastName');
				$conditions = array();
				foreach ($fields as $field) {
					if (isset($_POST[$field]) && $_POST[$field] != '') {
						$conditions[] = "$field LIKE '" . mysqli_escape_string($dbc , $_POST[$field]) . "%'";
					}
				}
				$query = "SELECT EmployeeID AS id, CONCAT(LastName, ', ', FirstName) AS name, Email AS email FROM Employees";

				if (count($fields) > 0) {
					//Search conditions
					$query .= " WHERE " . implode (' AND ', $conditions);
					$query .= " ORDER BY $order_by LIMIT $start, $display";
				}
			}else{
				$query = "SELECT EmployeeID AS id, CONCAT(LastName, ', ', FirstName) AS name, userName AS userName, Email AS email FROM Employees ORDER BY $order_by LIMIT $start, $display";
			}
			$r = @mysqli_query($dbc, $query);

			echo '<table>
					<tr>
						<th><a href="index.php?pagelet=EmployeeSearch&sort=id">Employee ID</a></th>
						<th><a href="index.php?pagelet=EmployeeSearch&sort=name">Name</a></th>
						<th>User Name</th>
						<th><a href="index.php?EmployeeSearch&sort=address">Email</a></th>
					</tr>';

			$bg = '#eeeeee';//Background color
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$bg = ($bg =='#eeeeee' ? '#fff' : '#eeeeee'); //Switch bg color
				echo '
					<tr bgcolor ="' . $bg . '">
						<td>' . $row['id'] . '</td>
						<td>' . $row['name'] . '</td>
						<td>' . $row['userName'] . '</td>
						<td>' . $row['email'] . '</td>
					</tr>';
			}
			echo '</table>';
			mysqli_free_result($r);
			mysqli_close($dbc);

			if ($pages > 1) {
				echo "</br><p>";

				$current_page = ($start/$display) + 1;

				if ($current_page != 1) {
					echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=customer-search?s=' . ($start - $display) . '&p=' . $pages . '$sorts=' . $sort . '">Previous</a>';
				}

				for($i = 1; $i <= $pages; $i++){
					if($i != $current_page){
						echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=customer-search?s=' . (($display * ($i -1))) . '&p=' . $pages . '$sorts=' . $sort . '">' . $i . '</a>';
					}else{
						echo $i . ' ';
					}
				}

				if ($current_page != $pages) {
					echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=customer-search?s=' . ($start + $display) . '&p=' . $pages . '$sorts' . $sort  . '">Next</a>';
				}
				echo '</p>';
			}
			//Add employee form(only visible to maganers)
			//April 16th 2017
			if ($_SESSION['Rank'] == 2) {

			?>
			<div>
				<p><h3>Add Employee</h3></p>
				<form id="admin" name="addEmp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=EmployeeSearch" method="post">
					<label>User Name:</label><input type="text" name="userName"></input>
					<label>First Name:</label><input type="text" name="FirstName">
					<label>Last Name:</label><input type="text" name="LastName">
					<label>Phone #:</label><input type="text" name="Phone"></input>
					<label>Email:</label><input type="text" name="email"></input>
					<label>Password</label><input type="text" name="password"></input>
					<input type="submit" name="submit" value = "Submit">
				</form>
			</div>
		<?php
		}
		//Delete employee form(only visible to managers)
		//April 16th 2017
		if ($_SESSION['Rank'] == 2) {

			?>
			<div>
				<p><h3>Delete Employee</h3></p>
				<form id="admin" name="delEmp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=EmployeeSearch" method="post">
					<label>EmployeeID</label><input type="text" name="empID"></input>
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