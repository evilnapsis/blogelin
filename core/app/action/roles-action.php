<?php
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "save_permissions") {
    $rol_id = $_POST["rol_id"];
    
    // 1. Limpiar permisos actuales para este rol
    $sql_clear = "delete from permission where rol_id=$rol_id";
    Executor::doit($sql_clear);

    // 2. Insertar nuevos permisos
    if(isset($_POST["perm"])) {
        foreach($_POST["perm"] as $view => $actions) {
            $p = new PermissionData();
            $p->rol_id = $rol_id;
            $p->view_name = $view;
            $p->can_view = isset($actions["view"]) ? 1 : 0;
            $p->can_add = isset($actions["add"]) ? 1 : 0;
            $p->can_edit = isset($actions["edit"]) ? 1 : 0;
            $p->can_delete = isset($actions["delete"]) ? 1 : 0;
            $p->add();
        }
    }
    
    Core::redir("./?view=roles");
}
?>
