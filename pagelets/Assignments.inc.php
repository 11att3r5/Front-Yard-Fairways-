<div class="dashboard">
	<?php
		include("includes/dashboard-nav.inc.php");
	?>
	<div class="dash-display">
		<div id="assignments">
			<h2>Assignments</h2>
		<?php
			require_once('DB-info.php');//connect to DB.

			if (isset($_POST['submit'])) {
				$CusNum = $_POST['CusNum'];
				$Emp = $_POST['EmpNum'];
				$query = "UPDATE Assignments SET EmployeeID = '$Emp' WHERE CustomerID = '$CusNum'";
				$upResult = @mysqli_query($dbc, $query);
				if (mysqli_affected_rows($dbc) == 1) {
					echo "Update Sucessful!";
				}
			}
			
			$display = 10;
			if (isset($_GET['p']) && is_numeric($_GET['p'])) {
				$pages = $_GET['p'];
			}
			else{
				$q = "SELECT COUNT(EmpId) FROM Assignments";
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

				case 'Employee':
					$order_by = 'EmployeeID';
					break;

				case 'address':
					$order_by = 'Address ASC';
					break;
				
				default:
					$order_by = 'CustomerID ASC';
					$sort = 'id';
					break;
			}
			$query = "SELECT EmployeeID AS employee, CustomerID AS id, CustomerPlan AS plan, Address AS address FROM Assignments ORDER BY $order_by LIMIT $start, $display";
			$r = @mysqli_query($dbc, $query);

			echo '<table>
					<tr>
						<th><a href="index.php?pagelet=Assignments&sort=id">Customer #</a></th>
						<th><a href="index.php?pagelet=Assignments&sort=plan">Plan</a></th>
						<th><a href="index.php?pagelet=Assignments&sort=Employee">Employee</a></th>
						<th><a href="index.php?pagelet=Assignments&sort=address">address</a></th>
						<th></th>
					</tr>';

			$bg = '#eeeeee';//Background color
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$bg = ($bg =='#eeeeee' ? '#fff' : '#eeeeee'); //Switch bg color
				echo '
					<tr bgcolor ="' . $bg . '">
						<td>' . $row['id'] . '</td>
						<td>' . $row['plan'] . '</td>
						<td>' . $row['employee'] .'</td>
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
					echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Assignments?s=' . ($start - $display) . '&p=' . $pages . '$sorts=' . $sort . '">Previous</a>';
				}

				for($i = 1; $i <= $pages; $i++){
					if($i != $current_page){
						echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Assignments?s=' . (($display * ($i -1))) . '&p=' . $pages . '$sorts=' . $sort . '">' . $i . '</a>';
					}else{
						echo $i . ' ';
					}
				}

				if ($current_page != $pages) {
					echo '<a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Assignments?s=' . ($start + $display) . '&p=' . $pages . '$sorts' . $sort  . '">Next</a>';
				}
				echo '</p>';
			}

			if ($_SESSION['Rank'] == 2) {

			?>
				<p><h3>Assign Employee</h3></p>
				<form id="admin" name="assignEmp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Assignments" method="post">
					<label>Customer#:</label><input type="text" name="CusNum">
					<label>Employee#:</label><input type="text" name="EmpNum">
					<input type="submit" name="submit" value = "Submit">
				</form>
		<?php
		}
		?>
		</div>
	</div>
</div>