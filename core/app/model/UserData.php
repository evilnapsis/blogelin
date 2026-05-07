<?php
class UserData extends Extra {
    public static $tablename = "user";
    public $id;
    public $username;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $is_active;
    public $is_verified;
    public $rol_id;
    public $created_at;

    public function __construct() {
        $this->name = "";
        $this->lastname = "";
        $this->username = "";
        $this->email = "";
        $this->password = "";
        $this->is_active = 1;
        $this->is_verified = 0;
        $this->created_at = "NOW()";
    }

    public function add() {
        $sql = "insert into ".self::$tablename." (username,name,lastname,email,password,is_active,is_verified,rol_id,created_at) ";
        $sql .= "value (\"$this->username\",\"$this->name\",\"$this->lastname\",\"$this->email\",\"$this->password\",$this->is_active,$this->is_verified,$this->rol_id,$this->created_at)";
        return Executor::doit($sql);
    }

    public function del() {
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function delBy($k, $v) {
        $sql = "delete from ".self::$tablename." where $k=\"$v\"";
        Executor::doit($sql);
    }

    public function update() {
        $sql = "update ".self::$tablename." set username=\"$this->username\",name=\"$this->name\",lastname=\"$this->lastname\",email=\"$this->email\",is_active=$this->is_active,is_verified=$this->is_verified,rol_id=$this->rol_id where id=$this->id";
        Executor::doit($sql);
    }

    public function update_passwd() {
        $sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
        Executor::doit($sql);
    }

    public function updateById($k, $v) {
        $sql = "update ".self::$tablename." set $k=\"$v\" where id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id) {
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new UserData());
    }

    public static function getBy($k, $v) {
        $sql = "select * from ".self::$tablename." where $k=\"$v\"";
        $query = Executor::doit($sql);
        return Model::one($query[0], new UserData());
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new UserData());
    }

    public static function getAllBy($k, $v) {
        $sql = "select * from ".self::$tablename." where $k=\"$v\"";
        $query = Executor::doit($sql);
        return Model::many($query[0], new UserData());
    }

    public static function getLike($q) {
        $sql = "select * from ".self::$tablename." where name like '%$q%' or lastname like '%$q%' or username like '%$q%'";
        $query = Executor::doit($sql);
        return Model::many($query[0], new UserData());
    }
}

?>