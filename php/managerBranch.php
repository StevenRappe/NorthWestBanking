<?php

include('finalConnectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
	<head>
		<title>Search for a Manager by Branch</title>
		
	</head>
  
	<body bgcolor="FireBrick">
  
		<?php
  
		$branch_num = $_POST['branch_num'];

		$query = "SELECT e.emp_ssn_num, e.name, e.employee_phone_num, b.branch_num FROM
		Employee e JOIN Branch b ON e.emp_ssn_num = b.manager_ssn_num
		WHERE b.branch_num = ?";

		if ($conn->connect_errno) {
			echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
		}

		?>

		<hr>
		Manager from selected branch
		<p>
		emp_ssn_num, name, employee_phone_num, branch_num

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


			if (!$stmt->bind_result($emp_ssn_num, $name, $employee_phone_num, $branch_num)) {
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}



			while ($stmt->fetch()) {
				printf ("%s %s %s %s<br>", $emp_ssn_num, $name, $employee_phone_num, $branch_num);
			}
			$stmt->close();
		}


		mysqli_close($conn);

		?>

	
		<p>
	</body>
</html>