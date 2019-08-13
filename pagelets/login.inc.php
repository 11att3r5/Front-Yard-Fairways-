<?php 
	
	if (isset($_POST['Login'])) {
		require_once('DB-info.php');//connect to DB.

		if (!empty($_POST['user-name'])) {
			$user = trim(stripcslashes($_POST['user-name']));
		}else{
			echo "<p>You forgot to enter your user name.</p>";
			$user = FALSE;
		}
		if (!empty($_POST['password'])) {
			$pass = $_POST['password'];
		}else{
			$pass = FALSE;
			echo "<p>You forgot your password</p>";
		}

		if ($user && $pass) {
			$query = "SELECT userName, password, Rank FROM Users WHERE userName = '$user' AND password = sha1('$pass')";
			$results = mysqli_query($dbc, $query) or trigger_error("Query: $query\n</br> Error:" . mysqli_error($dbc));

			if (@mysqli_num_rows($results) ==1) {
				$row = mysqli_fetch_array($results,MYSQLI_NUM);
				mysqli_free_result($results);
				mysqli_close($dbc);
				$_SESSION = array();
				$_SESSION['userName'] = $row[0];
				$_SESSION['password'] = $row[1];
				$_SESSION['Rank'] = $row[2];
				setcookie('user', $_SESSION['userName'], time()+3600, '/','',0,0);

				$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

				if ((substr($url,-1) == '/') OR (substr($url, -1) == '\\')) {
					$url = substr($url, 0, -1);
				}
				if ($_SESSION['Rank'] == 2 || $_SESSION['Rank'] == 3) {
					setcookie('emp', $_SESSION['Rank'], time()+3600, '/', '',0,0);
					$url .= '/index.php?pagelet=Dashboard';
				}elseif ($_SESSION['Rank'] == 1) {
					$url .= '/index.php?pagelet=cus-home';
				}else{
					$url .= '/index.php';
				}

				ob_end_clean();
				header("Location: $url");
				exit();
			}else{
				echo '<p class="error">Either the user name and password entered do not match those on file or you have not yet activated your account.</p>'; 
			}
		}else{
			echo "<p> Please try again</p>";
		}
		mysqli_close($dbc);
	}
?>
<div class="content-wrap">
	<div id="login">
		<div id="login-text">
			<p>Mauris interdum, neque quis interdum rhoncus, nulla augue varius diam, ac sagittis tortor augue vitae eros. Nulla facilisi. Mauris scelerisque est ut pellentesque euismod. Cras eget mollis nisl. In a augue gravida, scelerisque tellus at, blandit velit. Nunc nulla felis, dictum vel eros a, consequat pharetra nisl. In commodo ipsum ut tellus tincidunt, ut consectetur turpis dapibus.</p>
		</div>
		<div id="login-form">
			<fieldset>
				<legend>Sign in</legend>
				<form class="forms center" onsubmit="return validateLogin()" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=login">
					<div class="input-group">
					<label>User Name</label>
					<input type="text" name="user-name">
					</div>
					<div class="input-group">
					<label>Password</label>
					<input type="password" name="password" size="20" maxlength="20">
					</div>
					<div>
						<input type="submit" name="Login" value="Login">
					</div>
				</form>
			</fieldset>
			<div class="non-action">
				<a href="">Create New Account</a>
			</div>
		</div>
	</div>
</div>