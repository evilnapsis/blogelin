<?php
class PostData {
	public static $tablename = "post";


	public $id;
	public $title;
	public $brief;
	public $content;
	public $image;
	public $created_at;
	public $status;
	public $category_id;

	public function __construct(){
		$this->title = "";
		$this->brief = "";
		$this->content = "";
		$this->image = "";
		$this->created_at = "NOW()";
		$this->status = 1;
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (title,brief,content,category_id,image,created_at) ";
		$sql .= "value (\"$this->title\",\"$this->brief\",\"$this->content\",$this->category_id,\"$this->image\",NOW())";
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

// partiendo de que ya tenemos creado un objecto PostData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set title=\"$this->title\",brief=\"$this->brief\",content=\"$this->content\",image=\"$this->image\",category_id=\"$this->category_id\",status=$this->status where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PostData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());

	}
	
		public static function getAllActive(){
		$sql = "select * from ".self::$tablename." where status=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());

	}
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where title like '%$q%' or content like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}


	public static function getLatest($limit=10){
		$sql = "select * from ".self::$tablename." order by created_at desc limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}

	public static function count(){
		$sql = "select count(*) as c from ".self::$tablename;
		$query = Executor::doit($sql);
		$r = $query[0]->fetch_array();
		return $r['c'];
	}

}

?>