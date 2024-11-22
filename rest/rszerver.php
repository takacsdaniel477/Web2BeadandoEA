<?php
$eredmeny = "";

try {
	$dbh = new PDO('mysql:host=localhost;dbname=feltalalokdb', 'feltalalokdb', 'UvegPohar111',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
	
	switch($_SERVER['REQUEST_METHOD']) {
		case "GET":
				$sql = "select * from talalmany order by tkod";     
				$sth = $dbh->query($sql);
				$eredmeny .= "<table><tr style=\"background-color:lightgrey\"><th>TKod</th><th>Találmány</th></tr>";
				while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
					$eredmeny .= "<tr>";
					foreach($row as $column)
						$eredmeny .= "<td style=\"text-align: center;\">".$column."</td>";
					$eredmeny .= "</tr>";
				}
				
				$eredmeny .= "</table>";
			break;
		case "POST":
				$incoming = file_get_contents("php://input");
				parse_str($incoming, $data);

				echo $incoming;
				
				$sql = "insert into talalmany(talnev) values (:talnev)";
				$sth = $dbh->prepare($sql);
				$count = $sth->execute(Array(":talnev"=>$data["talnev"]));			
				$newid = $dbh->lastInsertId();
				
				$eredmeny .= $count." hozzáadva! ID: ".$newid;
			break;
		case "DELETE":
				$data = array();
				$incoming = file_get_contents("php://input");
				parse_str($incoming, $data);
				
				$sql = "delete from kapcsol where tkod=:tkod; delete from talalmany where tkod=:tkod;";
				$sth = $dbh->prepare($sql);
				$count = $sth->execute(Array(":tkod" => $data["tkod"]));
				
				$eredmeny .= $count." törölve! ID:".$data["tkod"];
			break;			
		case "PUT":
				$data = array();
				$incoming = file_get_contents("php://input");
				parse_str($incoming, $data);

				if($data['talnev'] != "" && $data['tkod'] != "") 
				{
					$sql = "update talalmany set talnev=:talnev where tkod=:tkod";
					$sth = $dbh->prepare($sql);
					$count = $sth->execute([
								":talnev" => $data["talnev"],
								":tkod" => $data["tkod"]
							]);
							
					$eredmeny .= "Rekord frissítve! ID:".$data["tkod"];
				} else {
					echo "Hibás paraméterek!";
				}
			break;
			}
}
catch (PDOException $e) {
	$eredmeny = $e->getMessage();
}
echo $eredmeny;

?>