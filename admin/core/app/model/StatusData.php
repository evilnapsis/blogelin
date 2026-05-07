<?php
class StatusData extends Extra {
    public static $tablename = "status";
    public $id;
    public $name;

    public function __construct() {
        $this->name = "";
    }

    public static function getById($id) {
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new StatusData());
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new StatusData());
    }
}
?>
