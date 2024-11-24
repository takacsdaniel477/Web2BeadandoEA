<?php
$db = new mysqli("localhost", "feltalalokdb", "UvegPohar111", "feltalalokdb");
if ($db->connect_error) {
    die("Kapcsolódás sikertelen: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $felhasznalonev = $db->real_escape_string($_POST['felhasznalonev']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM felhasznalok WHERE felhasznalonev = '$felhasznalonev'";
    $result = $db->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {

    		session_start();
    		$_SESSION['felhasznalonev'] = $felhasznalonev;
			$_SESSION['rang'] = $row['rang'];
	
    		header("Location: http://feltalaloktakacsdaniel.nhely.hu");
    		exit();
        } else {
            echo "Hibás jelszó!";
        }
    } else {
        echo "Hibás felhasználónév!";
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>
<body>
	<div id="wrapper">
			<div id="main">
				<div class="inner">
					<h1>Bejelentkezés</h1>
					<form action="bejelentkezes.php" method="POST">
						<label for="felhasznalonev">Felhasználónév:</label>
						<input type="text" id="felhasznalonev" name="felhasznalonev" required><br><br>
						<label for="password">Jelszó:</label>
						<input type="password" id="password" name="password" required><br><br>
						<button type="submit">Bejelentkezés</button>
					</form>
				</div>
			</div>
	</div>
</body>
</html>
