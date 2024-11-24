<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Magyar Nemzeti Bank árfolyamok</title>
</head>
<body>
    <?= isset($result) ? $result : '' ?>
    <br>
    <h2>Magyar Nemzeti Bank árfolyamok</h2>
    <form method="post">
        <div class="form-group">
            <label for="dropdown">Valuta:</label>
            <select id="dropdown" name="dropdown">
                <option value="EUR">EUR - HUF</option>
                <option value="USD">USD - HUF</option>
                <option value="AUD">AUD - HUF</option>
                <option value="CHF">CHF - HUF</option>
                <option value="GBP">GBP - HUF</option>
            </select><br><br>
			Dátum: <input type="text" name="datum" id="datum"><br><br>
        </div>
        <br>
        <input type="submit" value="Küldés">
    </form>
	
	<h1>Árfolyam</h1>
	
	<pre>
		<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dropdown'])) {
			try {
				$client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
				
				$params = [
					'startDate' => $_POST['datum'],
					'endDate' => $_POST['datum'],
					'currencyNames' => $_POST['dropdown']
				];
				
				$params2 = [
					'startDate' => '2024-10-01',
					'endDate' => '2024-10-31',
					'currencyNames' => $_POST['dropdown']
				];
				
				$exchangeRates = (array)simplexml_load_string($client->GetExchangeRates($params)->GetExchangeRatesResult);
				$exchangeRates2 = (array)simplexml_load_string($client->GetExchangeRates($params2)->GetExchangeRatesResult);
				
				$result = (array)simplexml_load_string($client->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult);
				$result2 = (array)simplexml_load_string($client->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult);

				$rate = $exchangeRates['Day'][0]->Rate[0];
				
				$rates = [];
				foreach ($exchangeRates2['Day'] as $day) {
					$rates[] = str_replace(',', '.', (string)$day->Rate);
				}

				$ratearray = array((string) $result["Day"]->Rate[8], (string) $result["Day"]->Rate[31], (string) $result["Day"]->Rate[0]);
				array_push($ratearray, (string) $result["Day"]->Rate[4], (string) $result["Day"]->Rate[6], (string) $result["Day"]->Rate[7]);
				array_push($ratearray, (string) $result["Day"]->Rate[9], (string) $result["Day"]->Rate[12], (string) $result["Day"]->Rate[15], (string) $result["Day"]->Rate[29]);
				
				foreach ($ratearray as $r) {
				  $r = str_replace(",",".",$r);
				}
				
				echo "<p style='font-size: 30px;'>A kiválasztott valuta értéke a választott napon: <b>".$rate."</b></p>";
				
				echo "<h2>2024 október napi árfolyamadatok</h2>";
				echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>
				   <tr>
					   <th>Árfolyam</th>
				   </tr>";

				for($i = 0; $i < count($rates); $i++) {
				   echo "<tr>
						   <td>{$rates[$i]}</td>
						 </tr>";
				}

				echo "</table>";

			} catch (SoapFault $e) {
				$rate = "Hiba! " .$e->getMessage();
			}
		}
		?>
	</pre>
	
	<div>
  <canvas id="grafikon"></canvas>
</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	
	<script>
	  const ctx = document.getElementById('grafikon');
	  
		var js_rate = "<?php echo $rate; ?>";
		js_rate = js_rate.replace(",", ".");
		var numeric_rate = parseFloat(js_rate);
		
		var js_rate_array = <?php echo json_encode($rates); ?>;

		var numeric_rates = js_rate_array.map(rate => parseFloat(rate));

	  new Chart(ctx, {
		type: 'bar',
		data: {
		  labels: ["10.01","10.02","10.03","10.04","10.07","10.08","10.09","10.10","10.11","10.14","10.15","10.16","10.17","10.18","10.21","10.22","10.24","10.25","10.28","10.29","10.30","10.31"],
		  datasets: [{
			label: 'árfolyam',
			data: numeric_rates,
			borderWidth: 1
		  }]
		},
		options: {
		  scales: {
			y: {
			  beginAtZero: true
			}
		  }
		}
	  });

	</script>
</body>
</html>