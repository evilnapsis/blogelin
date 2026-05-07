<?php
class ExpenseData extends Extra {
    public static $tablename = "expense";
    public $id;
    public $amount;
    public $category;
    public $description;
    public $date;
    public $created_at;

    public function __construct() {
        $this->created_at = "NOW()";
        $this->date = date("Y-m-d");
    }

    public function add() {
        $sql = "insert into ".self::$tablename." (amount,category,description,date,created_at) ";
        $sql .= "value ($this->amount,\"$this->category\",\"$this->description\",\"$this->date\",$this->created_at)";
        return Executor::doit($sql);
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename." order by date desc";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ExpenseData());
    }
}
?>
