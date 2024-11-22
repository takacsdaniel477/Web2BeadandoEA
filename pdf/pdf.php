
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>PDF - Találmányok adatainak lekérése</title>
</head>
<body>
    <div class="form-container">
        <h2>Találmányok adatainak lekérése</h2>
        <form method="POST" action="create.php" target="_blank">
		
            <div class="form-group">
                <label for="nev">Feltaláló neve:</label>
                <input type="text" id="nev" name="nev" value="">
            </div>
			<br>
            <div class="form-group">
                <label for="talnev">Találmány neve:</label>
                <input type="text" id="talnev" name="talnev" value="">
            </div>
			<br>
            <div class="form-group">
                <label for="szuletes">Születési év nagyobb, mint:</label>
                <input type="text" id="szuletes" name="szuletes" value="">
            </div>
            <br>
            <button type="submit">PDF létrehozás</button>
        </form>
    </div>
</body>
</html>