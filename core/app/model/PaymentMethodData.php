<?php
class PaymentMethodData {
	public static $tablename = "payment_method";

	public $id;
	public $name;
	public $short;
	public $is_web;
	public $is_active;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->name = "";
		$this->short = "";
		$this->is_web = 0;
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,short,is_web,is_active,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->short\",$this->is_web,$this->is_active,$this->created_at)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",short=\"$this->short\",is_web=$this->is_web,is_active=$this->is_active where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PaymentMethodData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentMethodData());
	}

	public static function getWebMethods(){
		$sql = "select * from ".self::$tablename." where is_web=1 and is_active=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentMethodData());
	}

    public static function getPublic(){
		$sql = "select * from ".self::$tablename." where is_active=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentMethodData());
	}
}
?>
