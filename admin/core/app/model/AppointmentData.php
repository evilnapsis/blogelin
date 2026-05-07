<?php
class AppointmentData {
	public static $tablename = "appointment";

	public $id;
	public $person_id;
	public $professional_id;
	public $office_id;
	public $product_id;
	public $date;
	public $time;
	public $reason;
	public $status;
	public $payment_method_id;
	public $kind;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->person_id = "";
		$this->professional_id = "";
		$this->office_id = "";
		$this->product_id = "";
		$this->date = "";
		$this->time = "";
		$this->reason = "";
		$this->status = "pending";
		$this->payment_method_id = "";
		$this->kind = 1; // 1: Internal, 2: Web
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (person_id,professional_id,office_id,product_id,date,time,reason,status,payment_method_id,kind,created_at) ";
		$sql .= "value ($this->person_id,$this->professional_id,$this->office_id,$this->product_id,\"$this->date\",\"$this->time\",\"$this->reason\",\"$this->status\",$this->payment_method_id,$this->kind,$this->created_at)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set person_id=$this->person_id,professional_id=$this->professional_id,office_id=$this->office_id,product_id=$this->product_id,date=\"$this->date\",time=\"$this->time\",reason=\"$this->reason\",status=\"$this->status\",payment_method_id=$this->payment_method_id where id=$this->id";
		Executor::doit($sql);
	}

    public function checkin(){
		$sql = "update ".self::$tablename." set office_id=$this->office_id,status=\"En Servicio\" where id=$this->id";
		Executor::doit($sql);
	}

	public function finish(){
		$sql = "update ".self::$tablename." set status=\"Finalizado\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new AppointmentData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by date desc, time desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AppointmentData());
	}

	public static function getAllByProfessional($professional_id){
		$sql = "select * from ".self::$tablename." where professional_id=$professional_id order by date desc, time desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AppointmentData());
	}

	public static function getByDateRange($start, $end){
		$sql = "select * from ".self::$tablename." where date >= \"$start\" and date <= \"$end\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AppointmentData());
	}

	public static function getAllByProfessionalAndDate($professional_id, $date){
		$sql = "select * from ".self::$tablename." where professional_id=$professional_id and date=\"$date\" and status != \"cancelled\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AppointmentData());
	}

	public static function getAllByPersonId($person_id){
		$sql = "select * from ".self::$tablename." where person_id=$person_id order by date desc, time desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AppointmentData());
	}
}
?>
