<?php
class ScheduleData {
	public static $tablename = "schedule";

	public $id;
	public $professional_id;
	public $day_of_week;
	public $start_time;
	public $end_time;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->professional_id = "";
		$this->day_of_week = "";
		$this->start_time = "";
		$this->end_time = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (professional_id,day_of_week,start_time,end_time,created_at) ";
		$sql .= "value ($this->professional_id, $this->day_of_week, \"$this->start_time\", \"$this->end_time\", $this->created_at)";
		return Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ScheduleData());
	}

	public static function getAllByProfessional($professional_id){
		$sql = "select * from ".self::$tablename." where professional_id=$professional_id order by day_of_week asc, start_time asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ScheduleData());
	}

	public static function getAllByProfessionalAndDay($professional_id, $day){
		$sql = "select * from ".self::$tablename." where professional_id=$professional_id and day_of_week=$day order by start_time asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ScheduleData());
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}
}
?>
