<?php
class ProfessionalRatingData {
	public static $tablename = "professional_rating";

	public $id;
	public $professional_id;
	public $person_id;
	public $stars;
	public $comment;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->professional_id = "";
		$this->person_id = "";
		$this->stars = "";
		$this->comment = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (professional_id,person_id,stars,comment,created_at) ";
		$sql .= "value ($this->professional_id,$this->person_id,$this->stars,\"$this->comment\",$this->created_at)";
		return Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ProfessionalRatingData());
	}

	public static function getAllByProfessional($professional_id){
		$sql = "select * from ".self::$tablename." where professional_id=$professional_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProfessionalRatingData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProfessionalRatingData());
	}
}
?>
