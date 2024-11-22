<?php
$url = "http://feltalaloktakacsdaniel.nhely.hu/rest/rszerver.php";
$result = "";
if(isset($_POST['tkod']))
{
  $_POST['tkod'] = trim($_POST['tkod']);
  $_POST['talnev'] = trim($_POST['talnev']);
  
  if($_POST['tkod'] == "" && $_POST['talnev'] != "")
  {
      $data = Array("talnev" => $_POST["talnev"]);
      $ch = curl_init($url);
	  
      curl_setopt($ch, CURLOPT_POST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
      $result = curl_exec($ch);
      curl_close($ch);
  }
  
  elseif($_POST['tkod'] >= 1 && ($_POST['talnev'] != ""))
  {
      $data = Array("tkod" => $_POST["tkod"], "talnev" => $_POST["talnev"]);
      $ch = curl_init($url);
	  
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
      $result = curl_exec($ch);
      curl_close($ch);
  }
  
  elseif($_POST['tkod'] >= 1)
  {
      $data = Array("tkod" => $_POST["tkod"]);
      $ch = curl_init($url);
	  
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
      $result = curl_exec($ch);
      curl_close($ch);
  }
  
  elseif($_POST['tkod'] == "")
  {
    $result = "Hiba: Hiányos adatok!";
  }
  
  else
  {
    echo "Hiba: Nem megfelelő azonosító! ID: ".$_POST['tkod']."<br>";
  }
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tabla = curl_exec($ch);
curl_close($ch);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>REST kliens - Feltalálók</title>
</head>
<body>
    <?= $result ?>
    <br>
    <h2>Új adatok bevitele (POST), régiek módosítása (PUT)/törlése (DELETE)</h2>
    <form method="post">
		Tkod: <input type="text" name="tkod"><br><br>
		Találmány: <input type="text" name="talnev"><br><br>
		<input type="submit" value = "Beküldés">
    </form>
	<h2>Adatlekérés (GET):</h2>
    <?= $tabla ?>
</body>
</html>
