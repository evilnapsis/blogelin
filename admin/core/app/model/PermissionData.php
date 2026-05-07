<?php
class PermissionData extends Extra {
	public static $tablename = "permission";

	public $id;
	public $rol_id;
	public $view_name;
	public $can_view;
	public $can_add;
	public $can_edit;
	public $can_delete;

	public function __construct(){
		$this->rol_id = "";
		$this->view_name = "";
		$this->can_view = 1;
		$this->can_add = 0;
		$this->can_edit = 0;
		$this->can_delete = 0;
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (rol_id,view_name,can_view,can_add,can_edit,can_delete) ";
		$sql .= "value (\"$this->rol_id\",\"$this->view_name\",$this->can_view,$this->can_add,$this->can_edit,$this->can_delete)";
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
		$sql = "update ".self::$tablename." set can_view=$this->can_view,can_add=$this->can_add,can_edit=$this->can_edit,can_delete=$this->can_delete where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PermissionData());
	}

	public static function getAllByRolId($id){
		$sql = "select * from ".self::$tablename." where rol_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PermissionData());
	}

    public static function getByRolView($rol_id, $view_name){
		$sql = "select * from ".self::$tablename." where rol_id=$rol_id and view_name=\"$view_name\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PermissionData());
	}

}
?>
