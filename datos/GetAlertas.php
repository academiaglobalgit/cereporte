<?php
		 include 'config.php';

         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");
         $mysql->Connectar();
   
				//optiene el ultimo folio
			$alertas="select * from escolar.tb_alertas a  where a.activo=1 order by a.id DESC limit 1  ";
						
			if($result_alerts=$mysql->Query($alertas)){
				if(mysql_num_rows($result_alerts)>0){
					$row=mysql_fetch_array($result_alerts);
					echo $row['mensaje'];
				}else{
					echo "no";
				}

			}else{
				echo "no";
			}
         $mysql->Cerrar();




?>