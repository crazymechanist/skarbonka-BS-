<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'off');
	
	include_once 'CustomException.php';
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT); #pokazuje jedynie błędy, a nie ostrzeżenia
	
	try{
		$connection_SQL = new mysqli($host , $db_user , $db_password , $db_name);
		if ($connection_SQL->connect_errno!=0){ #brak połącznia z bazą danych
			throw new Exception(mysqli_connect_errno());
		}
		else{
			//czy taki email juz istnieje
			$result = $connection_SQL->query("SELECT * FROM incomes_category");
			
			if(!$result) throw new Exception($connection_SQL->error);
			
			$how_many_results = $result->num_rows;
			
			if($how_many_results==0){
				echo '<select class="custom-select" name="categoty_of_inc" id="type2">';
				echo '<option disabled value="brak">BRAK</option>';
				echo '</select>';
			}
			else{
				echo '<select class="custom-select" name="categoty_of_inc" id="type2"> ';
				for ($i = 1; $i <= $how_many_results; $i++){
					$row = mysqli_fetch_assoc($result);
					$id_cat = $row["id_income_category"];
					$cat_name = $row["income_category"];
					echo '<option value="'.$id_cat.'">'.$cat_name.'</option>';				
				}
				echo '</select>';
			}
			$result -> free_result();
			$connection_SQL->close();	
		}
	}
	catch(Exception $e){
		echo '<div class="error">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</div>';
		echo '<br/>Informacja deweloperska; '.$e->getCode();
		exit();			
	}
?>
