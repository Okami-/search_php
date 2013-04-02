<?php

function get_db_connection() {

	//change to get
	//get db_connect server
	$username = '#';
	$password = '#';
	$database = '#';
	$dbhost = 'localhost';
	$table = '#';
	
	mysql_connect($dbhost, $username, $password) or die (mysql_error());
	mysql_select_db($database) or die (mysql_error());
	
}
	function search_results($keywords) {
		$returned_results = array();
		$where = "";
		
		#splits the keywords variable into an array from the spaces explode doesn't count for spaces prior to search term
		$keywords = preg_split('/[\s]+/', $keywords);
		
		#counts the $keywords variable that was made into an array
		$total_keywords = count($keywords);
		
		#cycles through the array of $keywords setting them seperately for each $keyword
		foreach ($keywords as $key=>$keyword) {
			#this statement is what searches through the 'label' table appending the mysql statement to $where if there is more
			#than 1 result it adds AND to the statement. Since arrays are 0 based it subtracts 1.
			$where .= "`label` LIKE '%$keyword%'";
			if ($key != ($total_keywords - 1)) {
				$where .= " AND ";
			}
		}
		
		$results = "SELECT `variable`, `label`, `type`, `observedn`, `missingn` FROM `#` WHERE $where";
		
		$results_num = ($results = mysql_query($results)) ? mysql_num_rows($results) : 0;
		
		if ($results_num === 0) {
			return false;
		} else {
			while ($results_row = mysql_fetch_assoc($results)) {
				$returned_results[] = array(
								'variable' => $results_row['variable'],
								'type' => $results_row['type'],
								'label' => $results_row['label'],
								'observedn' => $results_row['observedn'],
								'missingn' => $results_row['missingn']
								
			);
		}
			return $returned_results;
		}
	}
?>
