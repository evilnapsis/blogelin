<?php
class SettingData extends Extra {
    public static $tablename = "setting";
    public $id;
    public $setting_key;
    public $setting_value;
    public $created_at;

    public function __construct() {
        $this->created_at = "NOW()";
    }

    public function add() {
        $sql = "insert into ".self::$tablename." (setting_key,setting_value,created_at) ";
        $sql .= "value (\"$this->setting_key\",\"$this->setting_value\",$this->created_at)";
        return Executor::doit($sql);
    }

    public function update() {
        $sql = "update ".self::$tablename." set setting_value=\"$this->setting_value\" where setting_key=\"$this->setting_key\"";
        Executor::doit($sql);
    }

    public static function getByKey($key) {
        $sql = "select * from ".self::$tablename." where setting_key=\"$key\"";
        $query = Executor::doit($sql);
        return Model::one($query[0], new SettingData());
    }

    public static function getValue($key) {
        $s = self::getByKey($key);
        if($s) return $s->setting_value;
        return "";
    }

    public static function getAll() {
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new SettingData());
    }
}
?>
