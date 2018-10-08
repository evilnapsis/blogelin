<?php



class Table {

	public static function render($data=array(), $extra=""){

		$table = "<table class=\"table table-bordered\">";
		$table .= "<thead>";
		foreach($data["header"] as $h){
			$table .= "<th>$h</th>";
		}
		$table .="</thead>";
		foreach($data["body"] as $b){
			$table.="<tr>";
			foreach($b as $d){
				$table .= "<td>".$d."</td>";
			}
			$table.="</tr>";
		}
		$table .="</table>";
		return $table;
	}

}


?>