<?php


/**
* Form.php
* Clase para crear inputs y selects de formularios
**/

class Form 
{
	
	public static function input($type="text",$name="",$value="",$place="",$extra="")
	{
		return "<input type=\"$type\" name=\"$name\" value=\"$value\" placeholder=\"$place\" class=\"form-control\" $extra>";
	}

	/* sin class-form, util para input hidden, file, checkbox, radio ...*/
	public static function input2($type="hidden",$name="",$value="",$extra="")
	{
		return "<input type=\"$type\" name=\"$name\" value=\"$value\" $extra>";
	}

	public static function submit($value="Submit",$c="default",$extra="")
	{
		return "<input type=\"submit\" value=\"$value\" class=\"btn btn-$c\" $extra>";
	}

	public static function select($name="",$data=array(),$value="",$extra="")
	{
		$select = "<select name=\"$name\" $extra class=\"form-control\">";
		$selected = "";
		foreach($data as $d){
			if($d["value"]==$value){ $selected="selected"; }else{ $selected=""; }
			$select .= "<option value=\"".$d["value"]."\" $selected>".$d["name"]."</option>";
		}
		$select.="</select>";
		return $select;
	}

	public static function upload($name_field, $file_location){
		$filename = "";
		$up = new Upload($_FILES[$name_field]);
		if($up->uploaded){
			$up->Process($file_location);
			if($up->processed){
				$filename = $up->file_dst_name;
			}
		}
		return $filename;

	}

}


?>