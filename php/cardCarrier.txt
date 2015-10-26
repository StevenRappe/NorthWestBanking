<?php

include('finalConnectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
	<head>
		<title>Search for Customers by Bank Card Carrier</title>
		
	</head>
  
	<body bgcolor="FireBrick">
  
		<?php
  
		$card_carrier = $_POST['card_carrier'];

		$query = "SELECT c.ssn_num, c.name, c.account_num, b.card_carrier FROM Customer c JOIN
		Account a on c.ssn_num = a.customer_ssn JOIN BankCard b on
		a.account_num = b.account_num WHERE b.card_carrier = ?";

		if ($conn->connect_errno) {
			echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
		}

		?>

		<hr>
		Employees from selected branch
		<p>
		ssn_num, name, account_num, card_carrier

		<hr>

		<?php
		if (!($stmt = $conn->prepare($query))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		else{


			if (!($stmt->bind_param("s", $card_carrier))){
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->bind_result($ssn_num, $name, $account, $card_carrier)) {
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}



			while ($stmt->fetch()) {
				printf ("%s %s %s %s<br>", $ssn_num, $name, $account, $card_carrier);
			}
			$stmt->close();
		}


		mysqli_close($conn);

		?>

	
		<p>
	</body>
</html>