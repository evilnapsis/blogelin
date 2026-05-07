<?php
class StaffData extends Extra {
    public static $tablename = "staff";
    public $id;
    public $user_id;
    public $position;
    public $created_at;

    public function __construct() {
        $this->position = "";
        $this->created_at = "NOW()";
    }

    public function add() {
        $sql = "insert into ".self::$tablename." (user_id,position,created_at) ";
        $sql .= "value ($this->user_id,\"$this->position\",$this->created_at)";
        return Executor::doit($sql);
    }

    public function del() {
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public function update() {
        $sql = "update ".self::$tablename." set position=\"$this->position\" where id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id) {
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new StaffData());
    }

    public static function getByUserId($user_id) {
        $sql = "select * from ".self::$tablename." where user_id=$user_id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new StaffData());
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new StaffData());
    }
}
?>
