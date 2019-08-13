<?php

if (isset($_POST['submit'])) { // Handle the form.
	error_reporting(E_ALL);
	//Register user in database.
	//require_once('/home/student060/upload/DB-info.php');//connect to DB.
	require_once('DB-info.php');
		//Function to escape data.
		function escapeData($data){
			global $dbc;
			if(ini_get('magic_quotes_gpc')){
				$data = stripcslashes($data);
			}
			return mysql_real_escape_string($dbc,$data);
		}

	if (empty($_POST['firstName'])) {
		$firstName = FALSE;
		echo '<p>You forgot to enter your name!</p>';
	} else {
		$firstName = trim(stripslashes($_POST['firstName']));
	}

	// Check for an email address.
	if (empty($_POST['email'])) {
		$email = FALSE;
		echo '<p>You forgot to enter your email address!</p>';
	} else {
		$email = trim(stripslashes($_POST['email']));
	}

	// Check for a lastname.
	if (empty($_POST['lastName'])) {
		$lastName = FALSE;
		echo '<p>You forgot to enter your last name!</p>';
	} else {
		$lastName = trim(stripslashes($_POST['lastName']));
	}

	if (empty($_POST['phone'])) {
		$phone = FALSE;
		echo '<p>You forgot to enter your phone number!</p>';
	} else {
		$phone = trim(stripslashes($_POST['phone']));
		$phone = preg_replace('/\D+/', '', $phone);
	}

	if (empty($_POST['address'])) {
		$address = FALSE;
		echo '<p>You forgot to enter your address!</p>';
	} else {
		$address = trim(stripslashes($_POST['address']));
	}
	if (empty($_POST['state'])) {
		$state = FALSE;
		echo '<p>You forgot to enter your state!</p>';
	} else {
		$state = trim(stripslashes($_POST['state']));
	}
	if (empty($_POST['userName'])) {
		$userName = FALSE;
		echo '<p>You forgot to enter your userName!</p>';
	} else {
		$userName = trim(stripslashes($_POST['userName']));
	}
	if (empty($_POST['password'])) {
		$password = FALSE;
		echo '<p>Please enter a password</p>';
	}elseif($_POST['password'] != $_POST['con-pass']){
		$password = FALSE;
		echo '<p>Your passwords do not match</p>';
	}
	 else {
		$password = $_POST['password'];
	}

	if ($firstName && $lastName && $email && $phone && $address && $state && $password && $userName) {
	// If everything's okay.

	//See if user is in database
		session_start();
		$_SESSION['post'] = $_POST;
		$query = "SELECT userName FROM Users WHERE userName = '$userName'";
		$result =  @mysqli_query($dbc, $query);//Run the query
		if(mysqli_num_rows($result)==0){//If user can't be found
			//Send to next form
		 	mysqli_close($dbc); // Close the database connection.
			header('Location: index.php?pagelet=cus-services');
		}else{
			echo '<p>That username is already taken.</p>'; //  If user is in the database;
			mysqli_close($dbc); // Close the database connection.
		}
	}else{
		echo "<p>Please try again.</p>";
	}
}
?>
<div class="content-wrap">
	<div class="cusHome">
		<div><h1>Create New Account</h1></div>
		<form class="forms" name="info-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=cus-info" onsubmit="validateInfo()" method="post">
			<div class="input-group">
				<label>First Name</label>
				<input type="text" name="firstName" value="<?php if (isset($_POST['firstName'])) echo $_POST['firstName']; ?>" required/>
				<label>Last Name</label>
				<input type="text" name="lastName" value="<?php if (isset($_POST['lastName'])) echo $_POST['lastName']; ?>" required/>
			</div>

			<div class="input-group">
				<label>Your Email</label>
				<input type="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required/>
				<label>Your Phone #</label>
				<input type="text" name="phone" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" required/>
			</div>

			<div class="input-group">
				<label>Your Street Address</label>
				<input type="text" name="address" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>" required/>
				<label>State</label>
				<input type="text" name="state" value="<?php if (isset($_POST['state'])) echo $_POST['address']; ?>" required/>
			</div>
			<div class="input-group">
				<label>User Name</label>
				<input type="text" name="userName" value="<?php if (isset($_POST['userName'])) echo $_POST['userName']; ?>" required/>
				<label>Password</label>
				<input type="password" name="password" size="20" maxlength="20">
				<label>Re-Type Password</label>
				<input type="password" name="con-pass">
			</div>
			<div>
				<div>
					<a href="javascript:history.back();" class="non-action">Back</a>
					<input type="submit" name="submit" value="Continue" class="action">
				</div>
			</div>
		</form>
	</div>
</div>