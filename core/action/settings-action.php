<?php
/**
* settings-action.php
*/
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "update") {
    foreach($_POST as $key => $value) {
        $s = SettingData::getByKey($key);
        if($s) {
            $s->setting_value = $value;
            $s->update();
        } else {
            $s = new SettingData();
            $s->setting_key = $key;
            $s->setting_value = $value;
            $s->add();
        }
    }
    AuditData::log("update", "setting", 0, "Actualización de configuración general");
    Core::redir("./?view=settings");
}

if($opt == "update_branding") {
    if(isset($_FILES["logo"])) {
        $up = new Upload($_FILES["logo"]);
        if($up->uploaded) {
            $up->file_new_name_body = "logo";
            $up->image_resize = true;
            $up->image_ratio_y = true;
            $up->image_x = 400;
            $up->process("storage/");
            if($up->processed) {
                AuditData::log("update", "setting", 0, "Actualización de logo institucional");
            }
        }
    }
    Core::redir("./?view=settings");
}

if($opt == "update_smtp") {
    foreach($_POST as $key => $value) {
        $s = SettingData::getByKey($key);
        if($s) {
            $s->setting_value = $value;
            $s->update();
        } else {
            $s = new SettingData();
            $s->setting_key = $key;
            $s->setting_value = $value;
            $s->add();
        }
    }
    AuditData::log("update", "setting", 0, "Actualización de parámetros SMTP");
    Core::redir("./?view=settings");
}
?>
