<?php
class AuditData extends Extra {
    public static $tablename = "audit_log";
    public $id;
    public $user_id;
    public $action; // add, update, del, login, logout
    public $table_name;
    public $record_id;
    public $details;
    public $ip_address;
    public $created_at;

    public function __construct() {
        $this->created_at = "NOW()";
        $this->ip_address = $_SERVER['REMOTE_ADDR'];
    }

    public function add() {
        $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "NULL";
        $sql = "insert into ".self::$tablename." (user_id,action,table_name,record_id,details,ip_address,created_at) ";
        $sql .= "value ($user_id,\"$this->action\",\"$this->table_name\",\"$this->record_id\",\"$this->details\",\"$this->ip_address\",$this->created_at)";
        return Executor::doit($sql);
    }

    public static function log($action, $table="", $record_id=0, $details="") {
        $a = new AuditData();
        $a->action = $action;
        $a->table_name = $table;
        $a->record_id = $record_id;
        $a->details = $details;
        $a->add();
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename." order by created_at desc limit 500";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AuditData());
    }
}
?>
