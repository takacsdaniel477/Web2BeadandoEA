<?php
	class Szolgaltatas {
		public function talalmanyok_es_kutatok($talalmany)  {
			$eredmeny = "";

			try {
				$dbh = new PDO('mysql:host=localhost;dbname=feltalalokdb', 'feltalalokdb', 'UvegPohar111',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
				$dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
		
				$sql = "select k.*,t.* from kutato k join kapcsol ka on k.fkod=ka.fkod join talalmany t on t.tkod=ka.tkod where talnev LIKE :talalmany";
				//$sth = $dbh->query($sql);		
				$sth = $dbh->prepare($sql);
				$sth->execute(Array(":talalmany" => "%".$talalmany."%"));
				
				$eredmeny .= "<table><tr style=\"background-color:lightgrey;\"><th>Fkod</th><th>Kutató neve</th><th>Született</th><th>Meghalt</th><th>Tkod</th><th>Találmány</th></tr>";
				while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
					$eredmeny .= "<tr>";
					foreach($row as $column)
						$eredmeny .= "<td style=\"text-align: center;\">".$column."</td>";
					$eredmeny .= "</tr>";
				}
				$eredmeny .= "</table>";
			}
			catch (PDOException $e) {
			  $eredmeny["hibakod"] = 1;
			  $eredmeny["uzenet"] = $e->getMessage();
			}
			
			return $eredmeny;
		}

	}
	$options = array(
	"uri" => "http://feltalaloktakacsdaniel.nhely.hu/soap/sszerver.php");
	$server = new SoapServer(null, $options);
	$server->setClass('Szolgaltatas');
	$server->handle();
?>
