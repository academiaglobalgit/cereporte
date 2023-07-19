<?php 
class Column
{
	var $id; // identifiquer object OPTIONAL
	var $type; // 0= column with alias 1=subquery column with alias 2=subcolumns
	var $name; // column name in table
	var $alias; // if subquery
	var $subsql; // (sub query)
	var $table; // table name from
	var $desc; // description
	var $subcolumns; 
	var $isFilter; //has filter

	function Column($id_=0,$type_=0,$name_="",$alias_="",$subsql_="",$table_="",$desc_="Column",$isFilter_=false){
		$this->id=$id_;
		$this->type=$type_;
		$this->name=$name_;
		$this->alias=$alias_;
		$this->subsql=$subsql_;
		$this->table=$table_;
		$this->desc=$desc_;
		$this->isFilter=$isFilter_;

	}


}
?>