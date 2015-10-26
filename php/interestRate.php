<?php

include('finalConnectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
	<head>
		<title> Search for Customers by Loan Interest Rate </title>
		
	</head>
  
	<body bgcolor="FireBrick">
  
		<?php
  
		$interest_rate = $_POST['interest_rate'];

		$query = "SELECT c.ssn_num, c.name, c.account_num FROM Customer c
		JOIN Transactions t on c.ssn_num = t.customer_ssn_num JOIN Loan l
		ON t.transaction_num = l.transaction_num WHERE l.interest_rate > ?";

		if ($conn->connect_errno) {
			echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
		}

		?>

		<hr>
		Employees with at least selected interest rate
		<p>
		ssn_num, name, account_num

		<hr>

		<?php
		if (!($stmt = $conn->prepare($query))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		else{


			if (!($stmt->bind_param("s", $interest_rate))){
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->bind_result($ssn_num, $name, $account_num)) {
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}



			while ($stmt->fetch()) {
				printf ("%s %s %s <br>", $ssn_num, $name, $account_num);
			}
			$stmt->close();
		}


		mysqli_close($conn);

		?>

	
		<p>
	</body>
</html>