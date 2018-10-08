<?php
/**
@author: evilnapsis
@brief: Funcion para automatizar codigo de twitter bootstrap
**/

class Bs {
	// funcion para crear campos en los formularios
	public static function fginput($label,$value,$type,$name_id,$required,$cl='form-control'){
       $html="";
       $html.= '<div class="form-group">';
       if($type!='hidden'){

       $html.='<label for="'.$name_id.'">'.$label.'</label>';
       }
       if($type=="file"){ $cl = ""; }
       else if($type=="password"){ $value=""; }
       $required="";
       if($required==1){ $required="required"; }
       if($type=="textarea"){
        $html.="<textarea $required name='".$name_id."' id='".$name_id."' class='".$cl."' placeholder='".$label."'>".$value."</textarea>";
      }
       else{
       $html.='<input type="'.$type.'" $required name="'.$name_id.'" value="'.$value.'" class="'.$cl.'" id="'.$name_id.'" placeholder="'.$label.'">';

       }
       $html.='</div>';
       return $html;
   }

   // funcion para crear botones
   public static function button($title,$t,$btn='default',$size='md'){
   	return '<button type="'.$t.'" class="btn btn-'.$btn.' btn-'.$size.'">'.$title.'</button>';
   }
   public static function a($title,$href,$btn='default',$size='md'){
   	return '<a href="'.$href.'" class="btn btn-'.$btn.' btn-'.$size.'">'.$title.'</a>';
   }
   // funcion para tomar todos los campos definidos en el schema.php y crear un formulario para insertar
   public static function render_new($schema,$action="add",$custom_field=array()){
		foreach($schema as $su=>$sub){
      if(in_array($action, explode(",", $sub["actions"]))){
			 echo Bs::fginput($sub["label"],"",$sub["form"],$su,$sub["required"]);
      }
		}
   }

   // funcion para tomar todos los campos definidos en el schema.php y crear un formulario para modificar
   public static function render_edit($schema,$datamodel,$action="edit"){
    foreach($schema as $su=>$sub){
      if(in_array($action, explode(",", $sub["actions"]))){
        echo Bs::fginput($sub["label"],$datamodel->{$su},$sub["form"],$su,$sub["required"]);
        if(isset($sub[$action]) ){
          $go = false;
          $s = $sub[$action];
          $sx = explode(":", $s);
          if(count($sx)==2){
            $wh = explode("x", $sx[1]);
            $go = true;
            if(count($wh)==2){ $go=true; }
          }
          if($go){
            $src = $sub["upload"].$datamodel->{$su};
            //echo $src;
            if($datamodel->{$su}!=""&& file_exists($src)){
              echo "<img src='".$src."' style='width: ".$wh[0]."px; height".$wh[1]."px'>";
            }
          }
        }
      }
    }
   }
   // funcion para generar un select apartir de un array de datos proporcionados
   public static function select($label,$name_id,$data,$selected="",$cl='form-control'){  
       $html= '<div class="form-group">';
       $html.='<label for="'.$name_id.'">'.$label.'</label>';
       $html.='<select $required name="'.$name_id.'" class="'.$cl.'" id="'.$name_id.'">';
       foreach($data as $k){
        //print_r($data);
        $sel = "";
        if($k['k']==$selected){ $sel='selected'; }

       $html.="<option value='".$k['k']."' $sel>".$k['l']."</option>";
      }
       $html.="</select></div>";
       echo $html;

   }

}

?>