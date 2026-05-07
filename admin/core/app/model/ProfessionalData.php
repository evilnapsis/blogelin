<?php
class ProfessionalData {
	public static $tablename = "professional";

	public $id;
	public $user_id;
	public $category_id;
	public $license_number;
	public $appointment_duration;
	public $image;
	public $biography;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->user_id = "";
		$this->category_id = "";
		$this->license_number = "";
		$this->appointment_duration = 30;
		$this->image = "";
		$this->biography = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (user_id,category_id,license_number,image,appointment_duration,biography,created_at) ";
		$sql .= "value ($this->user_id,$this->category_id,\"$this->license_number\",\"$this->image\",$this->appointment_duration,\"$this->biography\",$this->created_at)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set category_id=$this->category_id,license_number=\"$this->license_number\",image=\"$this->image\",appointment_duration=$this->appointment_duration,biography=\"$this->biography\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ProfessionalData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProfessionalData());
	}

	public static function getAllByCategory($category_id){
		$sql = "select * from ".self::$tablename." where category_id=$category_id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProfessionalData());
	}
	public static function getBy($k, $v){
		$sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ProfessionalData());
	}
	public static function getAllBy($k, $v){
		$sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProfessionalData());
	}
}
?>
