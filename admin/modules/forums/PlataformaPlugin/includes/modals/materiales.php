<?php
echo '<div class="modal fade out" id="material_'.$data->id.'_'.$USER->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-sm" style="margin-top:140px;">
        <div class="modal-content ">

            <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size:14px;">cerrar ×</span></button>
                    <br/>';

                    $code_material="";
                   /* foreach($materiales as $material){
                        $cadenatexto = $material->mimetype;

                        $pdf = "pdf";
                        $doc = "msword"; $docx= "wordprocessingml";
                        $ppt = "powerpoint"; $pptx="presentationml";
                        $comparacionpdf = strpos($cadenatexto,$pdf);
                        $comparaciondoc = strpos($cadenatexto,$doc); $comparaciondocx = strpos($cadenatexto,$docx);
                        $comparacionppt = strpos($cadenatexto,$ppt); $comparacionpptx = strpos($cadenatexto,$pptx);
                        if($comparacionpdf	== true){
                            $code_material .= '<div class="row locato" style="border-bottom:1px solid #e3e3e3; ">
                                                    <br/>
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-3">
                                                            <a href="'.$CFG->wwwroot.'/mod/resource/view.php?id='.$material->id.'" ><i class="fa fa-file-pdf-o fa-3x" aria-hidden="true" style="color:#fb0c0c;"></i></a>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <a href="'.$CFG->wwwroot.'/mod/resource/view.php?id='.$material->id.'" ><p>Descargar Material en PDF</p></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                ';
                        }elseif($comparaciondoc == true or $comparaciondocx == true){
                            $code_material .= '<div class="row locato" style="border-bottom:1px solid #e3e3e3; ">
                                                    <br/>
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-3">
                                                            <a href="'.$CFG->wwwroot.'/mod/resource/view.php?id='.$material->id.'" ><i class="fa fa-file-word-o fa-3x" aria-hidden="true" style="color:#2a5699;"></i></a>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <a href="'.$CFG->wwwroot.'/mod/resource/view.php?id='.$material->id.'" ><p>Descargar Material en Word</p></a>
                                                        </div>
                                                    </div>
                                                </div>';
                        }elseif($comparacionppt == true or $comparacionpptx == true){
                            $code_material .= '<div class="row locato" style="border-bottom:1px solid #e3e3e3;">
                                                    <br/>
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-3">
                                                            <a href="'.$CFG->wwwroot.'/mod/resource/view.php?id='.$material->id.'" ><i class="fa fa-file-powerpoint-o fa-3x" aria-hidden="true" style="color:#f68424;"></i></a>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <a href="'.$CFG->wwwroot.'/mod/resource/view.php?id='.$material->id.'" ><p>Descargar Material en Powerpoint</p></a>
                                                        </div>
                                                    </div>
                                                </div>';
                        }else{
                            $code_material .= '<div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-3">
                                                            <i class="fa fa-file-o fa-3x" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <p><a href="'.$CFG->wwwroot.'/mod/resource/view.php?id='.$material->id.'" >Ver Material</a></p>
                                                        </div>
                                                    </div>
                                                </div>';

                        }

                    }*/
                    /*    
                    if($data->id == 3){
                        $material_actual = 64;    
                    }else if($data->id == 4){
                        $material_actual = 59;     
                    }else if($data->id == 5){
                        $material_actual = 48;        
                    }else if($data->id == 6){
                        $material_actual = 63;     
                    } 
                    */   
                    $code_material .= '<div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-3">
                                                            <i class="fa fa-file-o fa-3x" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <p><a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$material_actual.'" target="_blank" >Ver Material</a></p>
                                                        </div>
                                                    </div>
                                                </div>';

                    echo '<h4 align="center" class="locato" style="border-bottom:1px solid #e3e3e3; margin-bottom:0px;">Material para Estudiar</h4></br>';
                    echo $code_material;
            echo '</div>
        </div>
    </div>
</div>';

echo '<div class="modal fade out" id="foros_'.$data->id.'_'.$USER->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-md" style="margin-top:140px;">
        <div class="modal-content ">

            <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size:14px;">cerrar ×</span></button>
                    <br/>';

                    $code_foros="";

                    $code_foros .= '<div class="row">
                                                       
                                                        <div class="col-md-4 col-md-offset-4">


                                                            <p><i class="fa fa-comments-o fa-3x" aria-hidden="true"></i> <a href="'.$CFG->wwwroot.'/plataforma/foros.php?id_materia='.$data->id.'&id_examen='.$id_scorm.'"  >Ingresar a Foros</a></p>
                                                        </div>
                                                </div>';
                                                
                    echo '<h4 align="center" class="locato" style="border-bottom:1px solid #e3e3e3; margin-bottom:0px;">Necesitas reponder los foros antes de presentar el examen.</h4></br>';
                    echo $code_foros;
            echo '</div>
        </div>
    </div>
</div>';




?>