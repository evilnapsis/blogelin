<?php
/**
* backup-action.php
* Genera un volcado SQL de la base de datos para descarga
*/
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "download") {
    $db = Database::getCon();
    $tables = array();
    $result = $db->query("SHOW TABLES");
    while($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    $return = "";
    foreach($tables as $table) {
        $result = $db->query("SELECT * FROM ".$table);
        $num_fields = $result->field_count;

        $return .= "DROP TABLE IF EXISTS ".$table.";";
        $row2 = $db->query("SHOW CREATE TABLE ".$table)->fetch_row();
        $return .= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while($row = $result->fetch_row()) {
                $return .= "INSERT INTO ".$table." VALUES(";
                for($j=0; $j<$num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= "\"".$row[$j]."\"" ; } else { $return.= "\"\""; }
                    if ($j<($num_fields-1)) { $return.= ","; }
                }
                $return .= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    $filename = "backup_fullmedik_".date("Y-m-d_H-i-s").".sql";
    header("Content-type: application/sql");
    header("Content-Disposition: attachment; filename=$filename");
    echo $return;
    
    AuditData::log("backup", "database", 0, "Generación y descarga de respaldo SQL");
    exit();
}
?>
