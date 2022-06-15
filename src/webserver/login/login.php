<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	header("location: ../index.php");
	exit;
}

// Include config file
require_once("/app/config/credentials.php");
require_once("../database_structure.php");

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$success = true;

	// Check if username is empty
	if (empty($_POST["username"])) {
		$success = false;
		$username_err = "Bitte Benutzernamen eingeben.";
	} else {
		$username = trim(htmlspecialchars($_POST["username"]));
	}

	// Check if password is empty
	if (empty($_POST["password"])) {
		$success = false;
		$password_err = "Bitte Passwort eingeben";
	} else {
		$password = trim(htmlspecialchars($_POST["password"]));
	}

	// Validate credentials
	if ($success === true) {
		// Prepare a select statement
		$sql = "SELECT UserId, Username, password FROM User WHERE Username = ?";

		if ($stmt = $connection->prepare($sql)) {
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("s", $param_username);

			// Set parameters
			$param_username = $username;

			// Attempt to execute the prepared statement
			if ($stmt->execute()) {
				// Store result
				$stmt->store_result();

				// Check if username exists, if yes then verify password
				if ($stmt->num_rows == 1) {
					// Bind result variables
					$stmt->bind_result($userId, $username, $hashed_password);
					if ($stmt->fetch()) {
						if (password_verify($password, $hashed_password)) {
							// Password is correct, so start a new session
							session_start();

							// Store data in session variables
							$_SESSION["loggedin"] = true;
							$_SESSION["userId"] = $userId;
							$_SESSION["username"] = $username;

							// Redirect user to welcome page
							header("location: ../index.php");
						} else {
							// Password is not valid, display a generic error message
							$login_err = "Benutzername oder Passwort ist falsch.";
						}
					}
				} else {
					// Username doesn't exist, display a generic error message
					$login_err = "Benutzername oder Passwort ist falsch.";
				}
			} else {
				echo "Ein unerwarteter Fehler. Bitte versuchen es später nochmal.";
			}

			// Close statement
			$stmt->close();
		}
	}

	// Close connection
	$connection->close();
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="login.css">
</head>

<body>
	<div class="wrapper">
		<h2>Login</h2>

		<?php
		if (!empty($login_err)) {
			echo '<div class="alert alert-danger">' . $login_err . '</div>';
		}
		?>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" autocomplete="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
				<span class="invalid-feedback"><?php echo $username_err; ?></span>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" autocomplete="current-password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
				<span class="invalid-feedback"><?php echo $password_err; ?></span>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Login">
			</div>
			<!--<p>Noch kein Benutzerkonto? <a href="../registration/index.php">Hier klicken.</a>.</p>-->
		</form>
	</div>
</body>

</html>