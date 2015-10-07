<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageAutocomplete
{
	 public static function getSearchList($table, $arr_coloumns,$select_iDcoloumn,$select_valuecoloumn,  $searchtext)
    {

    	$db = config::dbconfig();

        $arr_SearchList = array();
		$obj_retresult = new returnResult();
		
        $sql = "SELECT * FROM ".$table." where "; 
		
		foreach($arr_coloumns as $key=>$coloumn)
		{
		$sql .= $coloumn." like '%".$searchtext."%'";
		if($key != count($arr_coloumns) -1)
		{
		$sql .= " OR ";
		}
		}
		
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
	
		$filed = $row[$select_iDcoloumn]."_".$row[$select_valuecoloumn];
		
        array_push($arr_SearchList, $filed );
        }
		
		
		if(count($arr_SearchList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_SearchList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	public static function getPrimaryValue($table, $primary_coloumns,$primaryId,$select_valuecoloumn)
    {

    	$db = config::dbconfig();

		$filed = "";
		
        $sql = "SELECT * FROM ".$table." where ".$primary_coloumns."=".$primaryId; 

        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {			
		$filed = $row[$select_valuecoloumn];
        }
		
		
		if($filed != "")
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $filed;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;
    }
	

}