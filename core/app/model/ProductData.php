<?php
class ProductData {
	public static $tablename = "product";

	public $id;
	public $name;
	public $description;
	public $price_in;
	public $price_out;
	public $duration;
	public $stock;
	public $image;
	public $category_id;
	public $kind;
	public $is_active;
	public $is_web;
	public $created_at;

	public function __construct(){
		$this->id = "";
		$this->name = "";
		$this->description = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->duration = 0;
		$this->stock = 0;
		$this->image = "";
		$this->category_id = "";
		$this->kind = 1; // 1: Producto, 2: Servicio
		$this->is_active = 1;
		$this->is_web = 0;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,description,price_in,price_out,duration,stock,image,category_id,kind,is_active,is_web,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->description\",\"$this->price_in\",\"$this->price_out\",\"$this->duration\",\"$this->stock\",\"$this->image\",$this->category_id,$this->kind,$this->is_active,$this->is_web,$this->created_at)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",description=\"$this->description\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",duration=\"$this->duration\",stock=\"$this->stock\",image=\"$this->image\",category_id=$this->category_id,kind=$this->kind,is_active=$this->is_active,is_web=$this->is_web where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ProductData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by name";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getServices(){
		$sql = "select * from ".self::$tablename." where kind=2 and is_active=1 order by name";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

    public static function getAllByCategory($category_id){
		$sql = "select * from ".self::$tablename." where category_id=$category_id order by name";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}
}
?>
