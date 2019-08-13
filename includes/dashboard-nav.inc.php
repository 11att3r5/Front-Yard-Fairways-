<div id="dashnav">
	<div id="profile-pic">
		<?php
			echo "<img src=\"upload/{$_SESSION['EmpPhoto']}\" alt=\"{$_SESSION['EmpPhoto']}\" />";
		?>
		<form name="uploadForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Dashboard" method="post" enctype="multipart/form-data">
			<input type="file" name="image">

			<input type="submit" name="uploadImg" value="submit">
		</form>
	</div>
	<div id="dash-links">
		<ul id="list">
			<li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Dashboard">Home</a></li>
			<li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=request-time-off">Request time off</a></li>
			<li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=customer-search">Customer Search</a></li>
			<li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=Assignments">Assignments</a></li>
			<li><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?pagelet=EmployeeSearch">Employee Search</a></li>
		</ul>
	</div>
	<a href="index.php?pagelet=logout">Logout</a>
</div>