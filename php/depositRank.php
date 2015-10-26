<?php

include('finalConnectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
	<head>
		<title> Search for Customers by Deposit Size </title>
		
	</head>
  
	<body bgcolor="FireBrick">
  
		<?php
  
		$amount = $_POST['amount'];

		$query = "SELECT c.ssn_num, c.name, c.account_num, d.amount FROM Customer c
		JOIN Transactions t on c.ssn_num = t.customer_ssn_num JOIN Deposit d
		ON t.transaction_num = d.transaction_num WHERE d.amount > ? ORDER BY 4 desc";

		if ($conn->connect_errno) {
			echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
		}

		?>

		<hr>
		Customers by Deposit Size
		<p>
		ssn_num, name, account_num, amount

		<hr>

		<?php
		if (!($stmt = $conn->prepare($query))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		else{


			if (!($stmt->bind_param("s", $amount))){
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->bind_result($ssn_num, $name, $account_num, $amount)) {
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}



			while ($stmt->fetch()) {
				printf ("%s %s %s %s<br>", $ssn_num, $name, $account_num, $amount);
			}
			$stmt->close();
		}


		mysqli_close($conn);

		?>

	
		<p>
	</body>
</html>