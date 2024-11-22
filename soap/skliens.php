<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SOAP kliens</title>
</head>
<body>
    <h2>SOAP kliens</h2>
	<p>Kérje le a találmányok listáját, a feltalálókkal együtt!</p>
	<p>Szűrhet találmánynév alapján, ha nem szeretne szűrni, akkor hagyja üresen a mezőt!</p>
    <form method="post">
        <div class="form-group">
            <label for="talalmany">Találmány:</label>
			<input type="talalmany" id="talalmany" name="talalmany">
        </div>
        <br>
        <input type="submit" value="Lekérés">
    </form>
	<br>
	<br>
	<div>
</div>

<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') { //isset($_POST['talalmany'])
	   $options = array(
	   "location" => "http://feltalaloktakacsdaniel.nhely.hu/soap/sszerver.php",
	   "uri" => "http://feltalaloktakacsdaniel.nhely.hu/soap/sszerver.php",
	   'keep_alive' => false,
	   );		
	   try {
		$skliens = new SoapClient(null, $options);	
		echo $skliens->talalmanyok_es_kutatok($_POST['talalmany'])."<br>";

	   } catch (SoapFault $e) {
			var_dump($e);
	   }
	}
?>
