<?php
class PersonData {
	public static $tablename = "person";

	public $id;
	public $name;
	public $lastname;
	public $company;
	public $email;
	public $phone;
	public $address;
	public $kind;
	public $user_id;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->name = "";
		$this->lastname = "";
		$this->company = "";
		$this->email = "";
		$this->phone = "";
		$this->address = "";
		$this->kind = 1; // 1: Client, 2: Supplier
		$this->user_id = "NULL";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,lastname,company,email,phone,address,kind,user_id,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->company\",\"$this->email\",\"$this->phone\",\"$this->address\",$this->kind,$this->user_id,$this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$user_id = ($this->user_id != null && $this->user_id != "" && $this->user_id != "NULL") ? $this->user_id : "NULL";
		$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",company=\"$this->company\",email=\"$this->email\",phone=\"$this->phone\",address=\"$this->address\",kind=$this->kind,user_id=$user_id where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		if($id == "" || $id == "NULL" || $id == null) return null;
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PersonData());
	}

	public static function getByUserId($user_id){
		if($user_id == "" || $user_id == "NULL" || $user_id == null) return null;
		$sql = "select * from ".self::$tablename." where user_id=$user_id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PersonData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getClients(){
		$sql = "select * from ".self::$tablename." where kind=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getSuppliers(){
		$sql = "select * from ".self::$tablename." where kind=2";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where (name like \"%$q%\" or lastname like \"%$q%\" or phone like \"%$q%\" or email like \"%$q%\") and kind=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}
}
?>
