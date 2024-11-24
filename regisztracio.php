<?php
$db = new mysqli("localhost", "feltalalokdb", "UvegPohar111", "feltalalokdb");
if ($db->connect_error) {
    die("Kapcsolódás sikertelen: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $db->real_escape_string($_POST['email']);
    $felhasznalonev = $db->real_escape_string($_POST['felhasznalonev']);
    $teljes_nev = $db->real_escape_string($_POST['teljes_nev']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO felhasznalok (email, felhasznalonev, teljes_nev, password_hash, rang) VALUES ('$email', '$felhasznalonev', '$teljes_nev', '$password', 'Regisztrált látogató')";

    if ($db->query($sql) === TRUE) {
        echo "Regisztráció sikeres!";
    } else {
        echo "Regisztráció sikertelen.";
    }
}
$db->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>
<body>
	<div id="wrapper">
			<div id="main">
				<div class="inner">
					<h1>Regisztráció</h1>
					<form action="regisztracio.php" method="POST">
						<label for="email">E-mail:</label>
						<input type="email" id="email" name="email" required><br><br>
						<label for="felhasznalonev">Felhasználónév:</label>
						<input type="text" id="felhasznalonev" name="felhasznalonev" required><br><br>
						<label for="teljes_nev">Teljes név:</label>
						<input type="text" id="teljes_nev" name="teljes_nev"><br><br>
						<label for="password">Jelszó:</label>
						<input type="password" id="password" name="password" required><br><br>
						<button type="submit">Regisztráció</button>
					</form>
				</div>
			</div>
	</div>
</body>
</html>
