<?php
class CategoryData {
	public static $tablename = "category";

	public $id;
	public $name;
	public $color;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->name = "";
		$this->color = "#000000";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,color,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->color\",$this->created_at)";
		return Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CategoryData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by name asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CategoryData());
	}
}
?>
