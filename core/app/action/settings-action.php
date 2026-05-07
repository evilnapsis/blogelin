<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
    foreach($_POST as $key => $value){
        $s = SettingData::getByKey($key);
        if($s){
            $s->setting_value = $value;
            $s->update();
        } else {
            $s = new SettingData();
            $s->setting_key = $key;
            $s->setting_value = $value;
            $s->add();
        }
    }
    Core::redir("./?view=settings&opt=all");
}

if(isset($_GET["opt"]) && $_GET["opt"]=="update_branding"){
    if(isset($_FILES["logo"]) && $_FILES["logo"]["name"]!=""){
        $logo = new Upload($_FILES["logo"]);
        if($logo->uploaded){
            $logo->file_new_name_body = "logo";
            $logo->file_overwrite = true;
            $logo->Process("storage/");
            if($logo->processed){
                // Logo updated successfully
            }
        }
    }
    Core::redir("./?view=settings&opt=all");
}
?>
