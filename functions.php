<?php
include "DatabaseInfo.php"

function queryMaker() {

	//get all variables and parse
	$mainQuery = $_GET["main"];
	$table = $_GET["table"];
	$condition = $_GET["condition"];
	$group = $_GET["group"];
	$order = $_GET["order"];
	$limit = $_GET["limit"];
	$SQL = "";
	//first part
	$SQL .= "SELECT " . $mainQuery . " from " . $table;
	//checks conditions
	if (!empty($condition)){
		$conditions = explode(",", $condition);
		$previousStatement = false; // tracks if there was a previous statement to add &&
		$SQL .= " Where "; // adds where meaning that a condition comes after
		$statement = 0; //number of statements processed by the query
		for ($i = 0; $i < count($conditions); $i++){
			if ($statement%2 === 0 && $conditions[$i] != ""){
				//checks if is the first value in the conditions
				if ($previousStatement) {$SQL .= " and ";} else {$previousStatement = true;}
				$SQL .= " ( " . $conditions[$i];
				$statement++;
			}else{
				if(is_numeric($conditions[$i]) || strtotime($conditions[$i])){  //is number or date
					$SQL .= " >= ". $conditions[$i] . ") and ( ". $conditions[$i - 1]
						. " <= " . $conditions[$i + 1] . " )";
					$i++;
				}elseif($conditions[$i - 1] == "hist_stage"){
					$SQL .= " like '".$conditions[$i]."') ";
				}else{
					$SQL .= " = '".$conditions[$i]."') ";
				}
				$statement++;
			}
		}

	}
	//checks for group
	if (!empty($group)){$SQL .= " GROUP BY " . $group ; }
	//checks for order
	if(!empty($order)){ $SQL .= " ORDER BY ". explode(",", $order)[0] . " " .  explode(",", $order)[1] ;}
	//include limit if there is any
	if (!empty($limit)){ $SQL .= " limit ". $limit;}
	$SQL .= ";";
	return $SQL;
}

function makeConn(){
	//start connection to database (comes from DatabaseInfo.php now)
	/*$servername = "";
	$username = "";
	$password = "";
	$dbname = "";""*/

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connectioncode, main, condition, group, order, limit
	if (!$conn) {
		echo "Bad Connection";
		exit();
	}
	return $conn;
}


function jsonMaker($q){
	$conn = makeConn();
	//$test  = array();
	$sql = $q;
	$result = "";
	$result = $conn->query($sql);
	$header = explode(",", $_GET["main"]);
	//if it counts for the best of
	if ($_GET["code"] == 2){array_push($header, "count");}
	$json = array($header);
	$flag = false;
	if (strpos($_GET["main"],"state")!== false){ $flag = true;}

	//input stuff on the table
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_array(MYSQL_NUM)) {
		$ar = array();

			foreach ($row as $r){
				if (is_numeric($r) && ($row[0] != $r)){array_push($ar, intval($r));}
				elseif($flag) {array_push($ar, 'US-'.$r);}
				else {array_push($ar, $r);}
			}
		array_push($json, $ar);
		}
	}


	$conn->close();
	return json_encode($json);

	//echo json_encode($test );
}
function showColumns(){

	$conn = makeConn();
	$sql = "show columns from " . $_GET["table"] . " ;";
	$sql = "show columns from Admissions;";
	$result = "";
	$result = $conn->query($sql);
	$ret = array();
	//input stuff on the table
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//echo $row['hi'];
			array_push($ret,$row['Field']);
		}
	}
	return json_encode($ret);
}

switch ($_GET["code"]){
	//return simple queries data
	case 1 : 
		echo queryBuilderSimple($_GET["main"]);
	break;
	//return json for the data requested
	case 2:
		echo jsonMaker(queryBuilder($_GET["main"], $_GET["Yr_From"], $_GET["Yr_to"], $_GET["hist_stage"], $_GET["option"], $_GET["order"], $_GET["limit"]));
	break;
	case 3:
	//returns columns in Admissions
		echo showColumns();
	break;
	case 4: 
		echo jsonMaker(queryBuilder2($_GET["main"], $_GET["Yr_From"], $_GET["Yr_to"], $_GET["hist_stage"], $_GET["option"], $_GET["order"], $_GET["limit"]));
	break;
//test case 2
	case 5:
		echo queryMaker();
	break;
	default:
		echo jsonMaker(queryMaker());
}
?>
