<?php
class IncomeData extends Extra {
    public static $tablename = "income";
    public $id;
    public $amount;
    public $source;
    public $date;
    public $created_at;

    public function __construct() {
        $this->created_at = "NOW()";
        $this->date = date("Y-m-d");
    }

    public function add() {
        $sql = "insert into ".self::$tablename." (amount,source,date,created_at) ";
        $sql .= "value ($this->amount,\"$this->source\",\"$this->date\",$this->created_at)";
        return Executor::doit($sql);
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename." order by date desc";
        $query = Executor::doit($sql);
        return Model::many($query[0], new IncomeData());
    }
}
?>
