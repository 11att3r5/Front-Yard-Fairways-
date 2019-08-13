<?php
	require_once('DB-info.php');//connect to DB.

	$idQuery = "SELECT EmployeeID AS id FROM Employees WHERE userName = '{$_SESSION['userName']}'";
	$idResult = @mysqli_query($dbc, $idQuery);
	if ($idResult) {
		while ($id = mysqli_fetch_array($idResult, MYSQLI_ASSOC)) {
			$_SESSION['EmpId'] =  $id['id'];
		}	
	}
	else{
		echo '<p>Error.</p><p>' . mysqli_error($dbc) . '</p>';
	}

		//Edit info code
	if (isset($_POST['editSub'])) {
		$mail = $_POST['email'];
		$phone = $_POST['phone'];
		$update = "UPDATE Employees SET Email = '$mail', PhoneNumber = '$phone' WHERE EmployeeID = '{$_SESSION['EmpId']}' LIMIT 1";
		$upResult = @mysqli_query($dbc, $update);
	}
	//Upload Image
	if (isset($_POST['uploadImg'])) {
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			if (move_uploaded_file($_FILES['image']['tmp_name'], "upload/{$_FILES['image']['name']}")) {
			}else{
				echo "File not uploaded";
				$i = '';
			}
			$i = $_FILES['image']['name'];
		}else{
			$i ='';
		}

		//Update database
		$query = "UPDATE Employees SET Photo = '$i' WHERE EmployeeID = {$_SESSION['EmpId']}";
		$result = @mysqli_query($dbc, $query);//Run the query
	}

	$query = "SELECT EmployeeID AS id, Photo AS photo, CONCAT(FirstName, ' ', LastName) AS name, PhoneNumber AS phone, Email AS email FROM Employees WHERE EmployeeID = '{$_SESSION['EmpId']}'";
	$infoResult = @mysqli_query($dbc, $query);//Run the query
	if($infoResult){
		while($row = mysqli_fetch_array($infoResult, MYSQLI_ASSOC)){
			$_SESSION['EmpPhoto'] = $row['photo'];
?>
<div class="dashboard">
	<?php
		include("includes/dashboard-nav.inc.php");
	?>
	<div class="dash-display">
		<div>
			<h2 class="center">Employee Dashboard</h2>
		</div>	
		<div class="on">
			<a href="#" class="editBtn">Edit</a>
			<p><h3>General Info</h3></p>
			</br>
			<p>Name: <?php echo "" . $row['name']; ?></p>
			<p>Email: <?php  echo "" . $row['email'];?></p>
			<p>Phone: <?php  echo "" . $row['phone'];?></p>
		</div>
		<div class="on off">
			<a href="#" class="editBtn">Edit</a>
			<form method="post" name="editInfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Dashboard">
			<p><h3>General Info</h3></p>
			</br>
			<p>Name: <?php echo "" . $row['name']; ?></p>
			<p>
				<label>Email: </label><input type="text" name="email" value="<?php echo $row['email']; ?>"/>
			</p>
			<p>
				<label>Phone: </label><input type="text" name="phone" value="<?php echo $row['phone']; ?>"/>
			</p>
			<input type="submit" name="editSub" value="submit">
			</form>
		</div>
<?php
	}
}
	$q = "SELECT StartDay AS start, EndDay AS endDay FROM TimeOff WHERE EmployeeID = '{$_SESSION['EmpId']}'";
	$timeResult = @mysqli_query($dbc, $q);//Run the query
	if ($timeResult) {
		while($r = mysqli_fetch_array($timeResult, MYSQLI_ASSOC)){
?>

			<div id="timeOff">
				<p><h3>Requested Time Off</h3></p>
				<p>Starting Day</p>
				<p><?php echo "" . $r['start']; ?></p>
				<p>Ending Day</p>
				<p><?php echo "" . $r['endDay']; ?></p>
			</div>
<?php 
	}
}else{
?>
			</br>
			<div id="timeOff">
				<p><h3>Requested Time Off</h3></p>
				<p>Starting Day</p>
				<p><?php echo "--/--/----"?></p>
				<p>Ending Day</p>
				<p><?php echo "--/--/----"?></p>
			</div>
<?php
	}
?>
			<div>
				<p><h3>Assignments</h3></p>
<?php
	require_once('DB-info.php');//connect to DB.
	
	$display = 10;
	if (isset($_GET['p']) && is_numeric($_GET['p'])) {
		$pages = $_GET['p'];
	}
	else{
		$q = "SELECT COUNT(EmpId) FROM Assignments WHERE EmployeeID = '{$_SESSION['EmpId']}'";
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

		case 'plan':
			$order_by = 'CustomerPlan ASC';
			break;

		case 'address':
			$order_by = 'Address ASC';
			break;
		
		default:
			$order_by = 'CustomerID ASC';
			$sort = 'id';
			break;
	}
	$query = "SELECT CustomerID AS id, CustomerPlan AS plan, Address AS address FROM Assignments WHERE EmployeeID = '{$_SESSION['EmpId']}' ORDER BY $order_by LIMIT $start, $display";
	$r = @mysqli_query($dbc, $query);

	echo '<table>
			<tr>
				<th><a href="index.php?pagelet=customer-search&sort=id">Customer #</a></th>
				<th><a href="index.php?pagelet=customer-search&sort=plan">Plan</a></th>
				<th>Details</th>
				<th><a href="index.php?pagelet=customer-search&sort=address">address</a></th>
				<th></th>
			</tr>';

	$bg = '#eeeeee';//Background color
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$bg = ($bg =='#eeeeee' ? '#fff' : '#eeeeee'); //Switch bg color
		echo '
			<tr bgcolor ="' . $bg . '">
				<td>' . $row['id'] . '</td>
				<td>' . $row['plan'] . '</td>
				<td></td>
				<td>' . $row['address'] . '</td>
				<td></td>
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
?>
		</div>
	</div>
</div>