<?php
class PaymentData {
	public static $tablename = "payment";

	public $id;
	public $appointment_id;
	public $amount;
	public $payment_method_id;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->appointment_id = "NULL";
		$this->amount = "";
		$this->payment_method_id = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (appointment_id,amount,payment_method_id,created_at) ";
		$sql .= "value ($this->appointment_id,\"$this->amount\",$this->payment_method_id,$this->created_at)";
		return Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PaymentData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentData());
	}

    public static function getAllByAppointment($appointment_id){
		$sql = "select * from ".self::$tablename." where appointment_id=$appointment_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PaymentData());
	}

	public static function sumByAppointmentId($appointment_id){
		$sql = "select sum(amount) as s from ".self::$tablename." where appointment_id=$appointment_id";
		$query = Executor::doit($sql);
		$row = $query[0]->fetch_assoc();
		return $row["s"] ?? 0;
	}
}
?>
