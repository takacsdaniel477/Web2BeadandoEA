<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>PDF létrehozás</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">
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
					</div>
			</div>
	</body>
</html>