<form method="GET" action="dgb_examen.php" >
<h2>DIVIDIR UNA CALIFICACION EN DIFERENTES BLOQUES examenes</h2>
<br>
	<!--CALIFICACION:<input value="" name="cali" type="number">-->
	<!--<br>#DE TAREAS A DIVIDIR<input value="" name="divisor" type="number" >-->
	LIMIT: <input value="0" name="limit" type="number" >
	<input value="CALCULAR" name="lol" type="submit" >
</form>
<?php 

	include 'config.php';

function GetPromedio($cali=10,$dividir=2){ //$total= total de calificacion $dividir, el numero de veces que se va a divir la calificacion total 

		//$ciento1=10;
		//echo "<br><strong>Calificacion: ".$cali."</strong>";
		//echo "<br>=======================";

		$puntos=0;
		$calis2=array();		
		$calis=array();

		for ($i=0; $i < $dividir; $i++) { 
			$calis[$i]=$cali;
			//echo "<br><strong> Tarea ".($i+1)." : ".$cali."</strong>";
			$puntos+=$cali;
			$calis2[$i]=0;
		}

		//echo "<br>Puntos para repartir: ".$puntos;
		//echo "<br>_______________________________";
		//echo "<br>TAREAS CON CALIFICACION ACOMODADADAS ALEATORIAMENTE";

		for ($i=0; $i < $dividir; $i++){ 


			if($puntos>0){
				if($puntos >$cali){
					$calis2[$i]=rand($cali,10);
				}else{
					$calis2[$i]=$puntos;
				}
			}
			
			$puntos-=$calis2[$i];
			//echo "<br><strong> Tarea ".($i+1)." : ".$calis2[$i]." </strong> ||  puntos restantes: ".$puntos."  ";
		}

		return $calis2;
}

function DividirMateria($id_materia=0,$id_alumno=0,$cali=0,$bloques_materia=1){
		
		$mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepacoppel");

		$querys="";
		$querys2="";

		do{
			/*EXAMEN FINAL */

			$ex_final=rand(3,$cali);//calificacion del Ex Final es random
			$ex_final_pts=$ex_final*0.4; //numero del porcentage 5.4

			/*BLOQUES */
			$bloques_pts=$cali-$ex_final_pts; //numero del porcentaje  3.6
			$cali_bloques=($bloques_pts*10)/6; //CALIFICACION FINAL DE LOS BLOQUES
		}
		while ($cali_bloques > 10);
		
		$id_ex_final=0;
		if(!$mysql->Connectar()){
			die("ERROR AL CONNECTAR A LA BD".mysql_error());
		}else{
			
			


			//$query_get_examen_final="SELECT q.id,q.name,c.fullname FROM mdl_quiz q INNER JOIN  mdl_course c on c.id=q.course inner join mdl_course_categories cc on cc.id=c.category inner join mdl_course_modules cm on cm.instance=q.id  where c.id='".$id_materia."' and cm.module=16 and (cc.id=6 OR cc.id=7) and cm.visible=1 and c.visible=1 and cc.parent=4 and q.name like '%Final%' order by c.id ASC, q.id asc LIMIT 1";


			$query_get_examen_final="SELECT q.id,q.name,c.fullname FROM mdl_quiz q 
										INNER JOIN  mdl_course c on c.id=q.course 
										inner join mdl_course_categories cc on cc.id=c.category 
										inner join mdl_course_modules cm on cm.instance=q.id
										inner join ag_examenes ae on ae.id=cm.id
										where  c.id='".$id_materia."' and cm.module=16
										and cm.visible=1 and c.visible=1  and ae.id_tipo=2
										and cc.parent=4  order by c.id ASC, q.id asc limit 1;
										";

			if($result_ex=$mysql->Query($query_get_examen_final)){
				$row=mysql_fetch_assoc($result_ex);
				$id_ex_final=$row["id"];
			}
		}

		 $querys.=" (".$id_ex_final.",".$id_alumno.",".$ex_final.") , ";

		$str_html="<br><br>
		<style>
		td{
			border-style:solid;	
		}
		th{
			border-style:solid;	
		}
		</style>
		<table >
		<tr>
			<th colspan='2' >CALIFICACION FINAL: ".$cali."</th>
		</tr>
		<tr>
			<th>CALIFICACION EXAMEN FINAL (40%)</th>
			<th>CALIFICACION BLOQUES (60%)</th>
		</tr>
		<tr>
			<td>".$ex_final."(".$ex_final_pts.")</td>
			<td>".$cali_bloques."(".$bloques_pts.")</td>
		<tr>
		</table>
		";

		$n_bloques=$bloques_materia;

		/*dividir $cali_bloques en los bloques */
		$bloques=GetPromedio($cali_bloques,$n_bloques);


		//divide la calificaicon de cada bloque
		$str_html.="<table>
		<tr>
			<th>BLOQUE</th>
			<th>Actividades</th>
			<th>Portafolio</th>
			<th>Examen</th>
		</tr>
		";

		$examenes_bloques=array();
		//$query_examenes_bloques='SELECT q.id FROM mdl_quiz q INNER JOIN  mdl_course c on c.id=q.course inner join mdl_course_categories cc on cc.id=c.category inner join mdl_course_modules cm on cm.instance=q.id  where c.id="'.$id_materia.'" and cm.module=16 and cm.visible=1 and c.visible=1 and cc.parent=4 and q.name like "%Actividad integradora%" order by c.id ASC, q.id ASC';
		$query_examenes_bloques="SELECT q.id,q.name,c.fullname FROM mdl_quiz q 
								INNER JOIN  mdl_course c on c.id=q.course 
								inner join mdl_course_categories cc on cc.id=c.category 
								inner join mdl_course_modules cm on cm.instance=q.id
								inner join ag_examenes ae on ae.id=cm.id
								where  c.id='".$id_materia."' and cm.module=16
								and cm.visible=1 and c.visible=1  and ae.id_tipo=1
								and cc.parent=4  order by c.id ASC, q.id asc ;
								";
			$k=0;
			if($result_ex2=$mysql->Query($query_examenes_bloques)){
				while($row2=mysql_fetch_assoc($result_ex2)){
					$examenes_bloques[$k]=$row2["id"];
					$k++;
				}
			}
		for ($i=0; $i < count($bloques); $i++) { //recorre los bloques para dividir cada calificacion en Actividades portafolio y examen del bloque
			$str_html.="
				<th>".$bloques[$i]."</th>
			";
			$a_p_e=GetPromedio($bloques[$i],3); // array de calificaciones de  actividades, portafolio y examenes.

			$query_bloques="INSERT INTO ag_bloques_grades (id_alumno,id_materia,numero,actividades_calificacion,portafolio_calificacion,examen_calificacion,calificacion,fecha_registro) values (".$id_alumno.",".$id_materia.",".($i+1).",".$a_p_e[0].",".$a_p_e[1].",".$a_p_e[2].",".$bloques[$i].",now())";
			/*if($mysql->Query($query_bloques)){
			}*/

			for($j=0; $j < count($a_p_e); $j++){
				$str_html.="<td>".$a_p_e[$j]."</td>";
				if($j==2){ // si es el ultimo elemento: examen del bloque

					//$ex_bloque=GetPromedio($a_p_e[$j],1); // examen del bloque
						$querys2.=" (".$examenes_bloques[$i].",".$id_alumno.",".$a_p_e[$j].") , ";

				}else if($j==1) // portafolio
				{
					//$a_p=GetPromedio($a_p_e[$j],rand(1,2)); 
				}
				else{ //actividades
					//$a_p=GetPromedio($a_p_e[$j],rand(1,2)); 
				}
			}

			$str_html.="</tr>";
		}
		$str_html.="</table>";

		$result=[]; //querys
		$result[0]= $querys; // querys examenes Final
		$result[1]= $querys2; // querys examenes bloque
		$result[2]= $str_html; // querys examenes bloque

	 return $result;
}


if(isset($_GET['lol']) ){
	$limit=(int)$_GET['limit'];
	$materia_calificacion = [];
	$materia_id = [];
	$materia_usuario = [];
	$materia_bloques = [];
	$materia_nombres= [];

	$mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepacoppel");
	if($mysql->Connectar())
	{		
			$k=0;
			if($result_ex2=$mysql->Query($query_examenes_bloques)){
				while($row2=mysql_fetch_assoc($result_ex2)){
					$examenes_bloques[$k]=$row2["id"];
					$k++;
				}
			}

		$query_solomaterias="SELECT c.id,c.fullname,cc.name,(SELECT count(q.id) FROM mdl_quiz q 
								INNER JOIN  mdl_course co on co.id=q.course 
								inner join mdl_course_categories cc on cc.id=co.category 
								inner join mdl_course_modules cm on cm.instance=q.id
								inner join ag_examenes ae on ae.id=cm.id
								where  co.id=c.id  and cm.module=16
								and cm.visible=1 and co.visible=1  and ae.id_tipo=1
								and cc.parent=4  order by co.id ASC, q.id asc ) as bloques

								 FROM  mdl_course c
								inner join mdl_course_categories cc on cc.id=c.category where  c.visible=1 and cc.visible=1
									and cc.parent=4  order by cc.name asc,c.id asc  " ;


		$query = "SELECT ag.id_alumno,concat(mu.firstname,' ',mu.lastname) as nombre_alumno,ag.id_materia,ag.calificacion,c.fullname,(SELECT count(q.id) FROM mdl_quiz q 
								INNER JOIN  mdl_course co on co.id=q.course 
								inner join mdl_course_categories cc on cc.id=co.category 
								inner join mdl_course_modules cm on cm.instance=q.id
								inner join ag_examenes ae on ae.id=cm.id
								where  co.id=c.id and cm.module=16
								and cm.visible=1 and co.visible=1  and ae.id_tipo=1
								and cc.parent=4  order by co.id ASC, q.id asc ) as bloques
								
								FROM ag_calificaciones ag left join mdl_user mu on mu.id=ag.id_alumno  INNER JOIN  mdl_course c on c.id=ag.id_materia inner join mdl_course_categories cc on cc.id=c.category  where c.visible=1 and cc.parent=4 order by ag.id_alumno ASC  limit ".$limit." ";

		$resultado = $mysql->Query($query_solomaterias);
		if($resultado)
		{
					$tabla_materias="
					MATERIAS REALIZADAS POR ALUMNO:
					<table style='border-color:#ccc; border-style:solid;' >
					<thead>
						<th>INDICE</th>
						<th>ALUMNO</th>
						<th>ID MATERIA</th>
						<th>MATERIA</th>
						<th>bloques</th>
					</thead>
					";
			for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
			{
				$materia_usuario[$indice] = $fila['id_alumno'];
				$materia_id[$indice] = $fila['id_materia'];
				$materia_nombres[$indice] = $fila['fullname'];
				$materia_calificacion[$indice] = $fila['calificacion'];
				$materia_bloques[$indice] = $fila['bloques'];
				/*switch ($materia_id[$indice]) 
				{
					case 71: $materia_bloques[$indice] = 10; break;
					case 3: $materia_bloques[$indice] = 8; break;
					case 7: $materia_bloques[$indice] = 4; break;
					case 12: $materia_bloques[$indice] = 4; break;
					case 5: $materia_bloques[$indice] = 10; break;
					case 70: $materia_bloques[$indice] = 3; break;
					case 6: $materia_bloques[$indice] = 7; break;
					case 58: $materia_bloques[$indice] = 10; break;
					case 9: $materia_bloques[$indice] = 10; break;
					case 10: $materia_bloques[$indice] = 13; break;
					case 18: $materia_bloques[$indice] = 4; break;
					default: $materia_bloques[$indice] = 0;	break;
				}*/
					$tabla_materias.="
					<tr>
					<td>".($indice+1)."</td>
					<td>".$fila['nombre_alumno']."</td>
						<td>".$fila['id']."</td>
						<td>".$fila['fullname']."</td>
						<td>". $fila['bloques']."</td>
					</tr>
					";
			}
			$tabla_materias.="</table><br>";
			echo $tabla_materias;
		}
		else
		{
			echo mysql_error();
		}

		$mysql->Cerrar();
	}
	else 
	{
		echo mysql_error();
	}

	/*$querys_query="INSERT INTO mdl_quiz_grades (quiz,userid,grade,timemodified) VALUES ";
	$querys_query2="INSERT INTO mdl_quiz_grades (quiz,userid,grade,timemodified) VALUES ";

	for($indice = 0; $indice < count($materia_id); $indice++)
	{
		//echo "<h3>".$materia_nombres[$indice]."</h3>";
		$str_query=DividirMateria($materia_id[$indice],$materia_usuario[$indice],$materia_calificacion[$indice],$materia_bloques[$indice]);
		$querys_query.=" ".$str_query[0];
		$querys_query2.=" ".$str_query[1];
		$querys_query3.=" ".$str_query[2];

	}
	
	echo "QUERY INSERT EXAMENES FINALES <br> ___________________________ <br>
		<textarea  rows='4' cols='50' >".$querys_query."</textarea>
		<br>QUERY INSERT  FINALES BLOQUES <br> ___________________________ <br>
		<textarea  rows='4' cols='50' >".$querys_query2."</textarea>
		<br>
		".$querys_query3."
	" ;*/

}
 




?>