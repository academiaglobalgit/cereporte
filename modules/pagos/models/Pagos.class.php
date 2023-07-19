<?php 
	class Pagos extends Connection {

		function Pagos(){
		 	$this->Connect();
		}


		function GetPagosByAlumno($id_tb_alumno=0){

		 	$query="SELECT tp.*,concat('(',ts.nomenclatura,')',ts.nombre) as servicio,tpt.descripcion as tipo FROM escolar.tb_pagos tp 
		 	inner join tb_servicios ts on ts.id=tp.id_servicio
		 	inner join tb_pagos_tipos tpt on tpt.id=tp.id_tipo

		 	WHERE tp.id_alumno=".$id_tb_alumno."  ";
		 	$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;

		}


		function GetServicios($id_plan_estudio=0){

		 	$query="SELECT ts.*,concat('(',ts.nomenclatura,')',ts.nombre) as nomenclatura_nombre FROM escolar.tb_servicios ts WHERE ts.id_plan_estudio=".$id_plan_estudio." order by ts.id ASC; ";
		 	$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;

		}


		function InsertPago($id_tb_alumno=0,$id_tipo=1,$id_servicio=0,$monto=0,$fecha_pago="00-00-0000",$fecha_periodo="00-00-0000"){

			$originalDate = $fecha_pago;
			 @$fecha_pago = date("Y-m-d", strtotime($originalDate));
			$originalDate = $fecha_periodo;
			 @$fecha_periodo = date("Y-m-d", strtotime($originalDate)); 
			 
		 	$query="CALL escolar.rv_proc_pagos_add(".$id_tb_alumno.",".$id_tipo.",".$id_servicio.",".$monto.",'".$fecha_pago."','".$fecha_periodo."'); ";
		 	$result=$this->Query($query);
			
			if($result['success']){
				 $new_id_pago=$this->last_insert_id();

				$this->Bitacora($_SESSION['id_persona'],"PAGOS","CREACION","Pago con ID(".$new_id_pago.") registrado con el monto ($".$monto.") del alumno con el ID en la tabla TB_ALUMNOS: ".$id_tb_alumno);

				$result['message']="Pago Registrado Correctamente.";

			}else{
				$result['message']="No se ha podido registrar el pago. code #1001 :".$result['message'];
			}
			
			return $result;

		}


	}
?>