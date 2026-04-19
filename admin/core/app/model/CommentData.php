<?php
class CommentData {
	public static $tablename = "comment";


	public $id;
	public $name;
	public $comment;
	public $email;
	public $post_id;
	public $created_at;
	public $status;

	public function __construct(){
		$this->name = "";
		$this->comment = "";
		$this->email = "";
		$this->created_at = "NOW()";
		$this->status = 1;
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,comment,email,post_id,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->comment\",\"$this->email\",$this->post_id, NOW())";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto CommentData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",comment=\"$this->comment\",email=\"$this->email\",status=\"$this->status\" where id=$this->id";
		Executor::doit($sql);
	}

	public function accept(){
		$sql = "update ".self::$tablename." set status=2 where id=$this->id";
		Executor::doit($sql);
	}

	public function denied(){
		$sql = "update ".self::$tablename." set status=0 where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CommentData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new CommentData());

	}

	public static function getPublicByPost($id){
		$sql = "select * from ".self::$tablename." where post_id=$id and status=2" ;
		$query = Executor::doit($sql);
		return Model::many($query[0],new CommentData());
	}
	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CommentData());
	}


	public static function getLatest($limit=10){
		$sql = "select * from ".self::$tablename." order by created_at desc limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CommentData());
	}

	public static function count(){
		$sql = "select count(*) as c from ".self::$tablename;
		$query = Executor::doit($sql);
		$r = $query[0]->fetch_array();
		return $r['c'];
	}

}

?>