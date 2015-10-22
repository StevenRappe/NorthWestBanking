<?php

include('finalConnectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
	<head>
		<title> Search for employees by job title </title>
		
	</head>
  
	<body bgcolor="FireBrick">
  
		<?php
  
		$job_title = $_POST['job_title'];

		$query = "SELECT e.emp_ssn_num, e.name, e.salary, e.job_title FROM Employee e
		WHERE e.job_title = ?";

		if ($conn->connect_errno) {
			echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
		}

		?>

		<hr>
		Employees from selected branch
		<p>
		emp_ssn_num, name, salary, job_title

		<hr>

		<?php
		if (!($stmt = $conn->prepare($query))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		else{


			if (!($stmt->bind_param("s", $job_title))){
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}


			if (!$stmt->bind_result($emp_ssn_num, $name, $salary, $job_title)) {
				echo "Bind Failed: (" . $stmt->errno . ") " . $stmt->error;
			}



			while ($stmt->fetch()) {
				printf ("%s %s %s %s<br>", $emp_ssn_num, $name, $salary, $job_title);
			}
			$stmt->close();
		}


		mysqli_close($conn);

		?>

	
		<p>
	</body>
</html>