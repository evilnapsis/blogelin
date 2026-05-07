<?php
class OfficeData extends Extra {
    public static $tablename = "office";
    public $id;
    public $name;
    public $location;
    public $created_at;

    public function __construct() {
        $this->name = "";
        $this->location = "";
        $this->created_at = "NOW()";
    }

    public function add() {
        $sql = "insert into ".self::$tablename." (name,location,created_at) ";
        $sql .= "value (\"$this->name\",\"$this->location\",$this->created_at)";
        return Executor::doit($sql);
    }

    public function del() {
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public function update() {
        $sql = "update ".self::$tablename." set name=\"$this->name\",location=\"$this->location\" where id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id) {
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new OfficeData());
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename." order by name asc";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OfficeData());
    }

    public static function getLike($q) {
        $sql = "select * from ".self::$tablename." where name like '%$q%' or location like '%$q%'";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OfficeData());
    }
}
?>
