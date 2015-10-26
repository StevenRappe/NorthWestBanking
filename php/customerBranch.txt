<?php

include('finalConnectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
	<head>
		<title> Search for Customers by Branch </title>
		
	</head>
  
	<body bgcolor="FireBrick">
  
		<?php
  
		$branch_num = $_POST['branch_num'];

		$query = "SELECT c.ssn_num, c.name, c.account_num, a.branch_num FROM Customer c
		JOIN Account a ON c.ssn_num = a.customer_ssn
		WHERE a.branch_num = ?";

		if ($conn->connect_errno) {
			echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
		}

		?>

		<hr>
		Customers from selected branch
		<p>
		ssn_num, name, account_num, branch_num

		<hr>

		<?php
		if (!($stmt = $conn->prepare($query))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		else{


			if (!($stmt->bind_param("s", $branch_num))){
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->bind_result($ssn_num, $name, $account_num, $branch_num)) {
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}



			while ($stmt->fetch()) {
				printf ("%s %s %s %s<br>", $ssn_num, $name, $account_num, $branch_num);
			}
			$stmt->close();
		}


		mysqli_close($conn);

		?>

	
		<p>
	</body>
</html>