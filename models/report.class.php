<?php 
class Report
{
	var $query; // string query
	var $inners;

	var $start_table;
	var $start_primarykey;
	var $start_bd;
	var $first_join;
	var $first_where;

	var $columns;
	var $columnswhere;
	
	var $tables;

	var $inner_str;
	var $columns_str;

	var $log="";

	function Report($start_table_="mdl_user",$start_primarykey_="id",$start_bd_='prepacoppel',$first_join_="",$first_where_="true" ){
		$this->start_table=$start_table_;
		$this->start_primarykey=$start_primarykey_;
		$this->start_bd=$start_bd_;
		$this->first_join=$first_join_;
		$this->first_where=$first_where_;

	}

	function AddTable($table){
		if(!in_array($table, $this->tables)){
			array_push($this->tables,$table);
		}else{
			$this->log.="<br>Table already exist.";
		}
	}

	function AddColumn($column){
			array_push($this->columns,$column);
			//AddTable($column->$table);
			$this->log.="<br>Column Added.";

		
	}

	function GenerateWhere($wherestr="",$alias=""){
		$wherestr= rtrim(ltrim($wherestr));
		if(!empty($wherestr)){

			$pos = strpos($wherestr,' ');

			if($pos===FALSE){
				$wherestr=" and '".$wherestr."'=".$alias."  ";
			}else{
				$wherestr=str_replace(' ', " =  ".$alias." OR ", $wherestr);
				$wherestr.=" =  ".$alias." OR false ";
				$wherestr=" AND (".$wherestr.") ";
			}
			
			return $wherestr;
		}else{
			return "";
		}
		

	}

	function GenerateSQL($limit=0){
		$limit_str="";
		$where_str="";
		if(is_numeric($limit) && $limit>0){
			$limit_str=" LIMIT ".$limit." ";
		}
		$columns_tmp="";
		$joins="";
		for ($i=0; $i < count($this->columns); $i++) { 
			$col=$this->columns[$i];
			switch ($col->type) {
				case 0:
					$columns_tmp.=",".$col->table.".".$col->name." ";
					if($col->isFilter){
						$where_str.=$this->GenerateWhere($this->columnswhere[$i],$col->table.".".$col->name);
					}
				break;
				case 1:
					$columns_tmp.=",".$col->subsql." as ".$col->alias." ";
					if($col->isFilter){
						$where_str.=$this->GenerateWhere($this->columnswhere[$i],$col->subsql);
					}
				break;
				case 2:

					for ($k=0; $k < count($col->subcolumns) ; $k++) { 
						$sucol=$col->subcolumns[$k];
						//$columns_tmp.=",".$sucol->subsql." as ".$sucol->alias." ";
						$columns_tmp.=",".$sucol->name." as  ".$sucol->alias."  ";
						$joins.=" ".$sucol->subsql." ";

					}

				break;
				default:
					$this->log.="<br>Column without type.";
				break;
			}
		
		}

		$columns_tmp2=substr($columns_tmp, 1); // remove the first ","
		$query_tmp="SELECT ".$columns_tmp2." FROM ".$this->start_table." ".$this->first_join."   ".$joins." WHERE ".$this->first_where." ".$where_str." ORDER BY mdl_user.id ASC ".$limit_str;
		$this->query=$query_tmp;
		return $this->query;
	}


	function ResultToArray($result,$head=true){ // convert mysql result to obj
	// $head 
	// true=name columns from sql query 
	// false= name column from $column->desc

		$array_report=array();
		$array_titles=array();
		$array_rows=array();

		$k=0;
		$totaltitle=0;

        if($head){
        	$j=0;
            foreach (array_keys($title) as $val) {
            	array_push($array_rows,$val);
            	array_push($array_titles,$val);
                $j++;
            }
        }else{
        	$j=0;
            foreach ($this->columns as $val) {

            	if($val->type==2){ // if have subcolumns

            		foreach ($val->subcolumns as $subval) {
            			array_push($array_titles,$subval->desc);
            			array_push($array_rows,$subval->alias);

            			$j++;
            		}

            	}else{
            		array_push($array_titles,$val->desc);
            		array_push($array_rows,$val->alias);

                	$j++;

            	}
            }
        }
		array_push($array_report,$array_titles);
		$k=1;
		


		while($row=mysql_fetch_assoc($result)){
			$i=0;
			
		
				$results_row=array();
				foreach ($array_rows as $row_str) {
					array_push($results_row,$row[$row_str]);
					$i++;
				}
				array_push($array_report,$results_row);

				//$array_report[$k]=$row;


			$k++;
		}

	
		return $array_report;
	}




}
?>

