<?php
	require_once('DB-info.php');//connect to DB.
	//get the user ID
	$idQuery = "SELECT CustomerID AS id FROM Customers WHERE userName = '{$_SESSION['userName']}'";
	$idResult = @mysqli_query($dbc, $idQuery);
	if ($idResult) {
		while ($id = mysqli_fetch_array($idResult, MYSQLI_ASSOC)) {
			$_SESSION['CustomerID'] =  $id['id'];
		}	
	}
	else{
		echo '<p>Error.</p><p>' . mysqli_error($dbc) . '</p>';
	}  
	//Edit info code
	if (isset($_POST['editSub'])) {
		$ad = $_POST['address'];
		$mail = $_POST['email'];
		$phone = $_POST['phone'];
		$update = "UPDATE Customers SET Address = '$ad', Email = '$mail', phoneNum = '$phone' WHERE CustomerID = '{$_SESSION['CustomerID']}' LIMIT 1";
		$upResult = @mysqli_query($dbc, $update);
		if (mysqli_affected_rows($dbc) == 1) {
			echo "Update Sucessful!";
		}
	}

	//select query
	$query = "SELECT CustomerID AS id, CONCAT(FirstName, ' ', LastName) AS name, Address AS address, Email AS email, phoneNum AS phone FROM Customers WHERE CustomerID = '{$_SESSION['CustomerID']}'";
	$infoResults = @mysqli_query($dbc, $query);//Run the query
	if($infoResults){
		while($row = mysqli_fetch_array($infoResults, MYSQLI_ASSOC)){
?>
<div class="content-wrap">
	<div class="cusHome">
		<div id="top">
			<h2><?php echo "" . $row['name'] ?></h2>
			<hr>
			<a href="#" class="editBtn non-action">Edit</a>
		</div>
		<div class="on">
			<p>Customer #: <?php echo "" . $row['id']; ?> </p>
			<p>Address: <?php echo "" . $row['address']; ?></p>
			<p>Email: <?php echo "" . $row['email']; ?> </p>
			<p>Phone: <?php echo "" . $row['phone']; ?> </p>
		</div>
		<div class="on off">
			<form method="post" name="editInfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=cus-home">
			<p>Customer #: <?php echo "" . $row['id']; ?></p>
			<p>
			<lable>Address: </lable><input type="text" name="address" value="<?php echo $row['address'];?>"/>
			</p>
			<p>
			<lable>Email: </lable><input type="text" name="email" value="<?php echo $row['email']; ?>"/>
			</p>
			<p>
			<lable>Phone: </lable><input type="text" name="phone" value="<?php echo $row['phone']; ?>"/>
			<p>
			<input type="submit" name="editSub" value="submit" class="action">
			</form>
		</div>
	<?php   
		//Edit info code
		if (isset($_POST['editSub'])) {
			$ad = $_POST['address'];
			$mail = $_POST['email'];
			$phone = $_POST['phone'];
			$update = "UPDATE Customers SET Address = '$ad', Email = '$mail', phoneNum = '$phone' WHERE CustomerID = '{$_SESSION['CustomerID']}' LIMIT 1";
			$upResult = @mysqli_query($dbc, $update);
			if ($upResult) {
				alert("Update Sucessful!");
			}
		}
	?>
	<?php
			}	
		}else{
			echo '<p>Error.</p><p>' . mysqli_error($dbc) . '</p>';
		}
		$serviceQuery = "SELECT Plan AS plan, Mulching As mulch, Weeding AS weeds, TreePruning AS treeprun, Gardening AS garden, Hedging AS hedging, WeedControl AS weedcontrol FROM Services WHERE CustomerID = '{$_SESSION['CustomerID']}'";
		$serviceResults = @mysqli_query($dbc, $serviceQuery);
		if($serviceResults){
			while ($r = mysqli_fetch_array($serviceResults, MYSQLI_ASSOC)) {
	?>
		<div>
			<h2>Services</h2>
			<hr>
			<h3>Plan</h3>
			<div>
				<p> <?php echo "" . $r['plan']; ?></p>
			</div>
			<div>
				<?php if ($r['plan'] == 'ParI') {
					echo "<p>Under 500sq. ft.</p>";
				}elseif ($r['plan'] == 'ParII') {
					echo "<p>500 - 1000 Sq. ft.</p>";
				}else{
					echo "<p>Over 1000 Sq. ft.</p>";
				} ?>
			</div>
			<div>
				<?php if ($r['plan'] == 'ParI') {
					echo "<p>Edging, Mowing, Blowing</p>";
				}elseif ($r['plan'] == 'ParII') {
					echo "<p>Edging, Mowing, Blowing</p>";
				}else{
					echo "<p>Edging, Mowing, Blowing</p>";
				} ?>
			</div>
		</div>
		<div>
			<h2>Additional Services</h2>
			<hr>
			<?php 
				if ($r['mulch'] == 1) {
					echo "<p>Mulching</p>";
				}
				if ($r['weeds'] == 1) {
					echo "<p>Weeding</p>";
				}
				if ($r['treeprun'] == 1) {
					echo "<p>Tree Trimming</p>";
				}
				if ($r['garden'] == 1) {
					echo "<p>Gardening</p>";
				}
				if ($r['hedging'] == 1) {
					echo "<p>Hedging</p>";
				}
				if ($r['weedcontrol'] == 1) {
					echo "<p>Weed Control</p>";
				}
			?>
		</div>
		<!--
		<div id="cus-logout">
			<a href="index.php?pagelet=logout" class="non-action">Logout</a>
		</div>
		-->
	</div>
</div>
<?php
		}
	}
mysqli_close($dbc);
?>