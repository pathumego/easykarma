<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageLanguage
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addLanguage($obj_Language)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Language->LangId = DAL_manageLanguage::getLastLanguageId()+1;
		
		 $sql = "INSERT INTO tbl_language (LangId,LangTag,English,Sinhala,Tamil,Bangla,Nepali,Lang1,Lang2,Lang3) 
		VALUES (".
		common::noSqlInject($obj_Language->LangId).","."'".common::noSqlInject($obj_Language->LangTag)."'".","."'".common::noSqlInject($obj_Language->English)."'".","."'".common::noSqlInject($obj_Language->Sinhala)."'".","."'".common::noSqlInject($obj_Language->Tamil)."'".","."'".common::noSqlInject($obj_Language->Bangla)."'".","."'".common::noSqlInject($obj_Language->Nepali)."'".","."'".common::noSqlInject($obj_Language->Lang1)."'".","."'".common::noSqlInject($obj_Language->Lang2)."'".","."'".common::noSqlInject($obj_Language->Lang3)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Language;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastLanguageId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(LangId) as maxId FROM  tbl_language";
        $rs = mysql_query($sql);
        if ((mysql_num_rows($rs)) > 0)
        {
            while ($row = mysql_fetch_array($rs))
            {
                $maxId = $row["maxId"];
                $lastID = is_null($maxId)?0:$maxId;
            }
        }

        return $lastID;

    }
	
	    //---------------------------------------------------------------------------------------------------------

    public static function getLanguageList()
    {
    	  $db = config::dbconfig();

        $arr_LanguageList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_language ORDER BY LangId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Language = new Language();
		$obj_Language->LangId= $row["LangId"];
		$obj_Language->LangTag= $row["LangTag"];
		$obj_Language->English= $row["English"];
		$obj_Language->Sinhala= $row["Sinhala"];
		$obj_Language->Tamil= $row["Tamil"];
		$obj_Language->Bangla= $row["Bangla"];
		$obj_Language->Nepali= $row["Nepali"];
		$obj_Language->Lang1= $row["Lang1"];
		$obj_Language->Lang2= $row["Lang2"];
		$obj_Language->Lang3= $row["Lang3"];

        array_push($arr_LanguageList, $obj_Language);
        }
		
		if(count($arr_LanguageList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_LanguageList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
		    //---------------------------------------------------------------------------------------------------------

    public static function getLanguageListByName($lang)
    {
    	  $db = config::dbconfig();

        $arr_LanguageList = array();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_language ORDER BY LangId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Language = new Language();
		$arr_LanguageList[$row["LangTag"]] = $row[$lang];
        }
		
		if(count($arr_LanguageList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_LanguageList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	//---------------------------------------------------------------------------------------------------------

    public static function getLanguageByLangId($LangId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Language = new Language();
		$obj_Language->LangId = -1;
		$sql = "SELECT * FROM tbl_language WHERE LangId=".$LangId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Language->LangId= $row["LangId"];
		$obj_Language->LangTag= $row["LangTag"];
		$obj_Language->English= $row["English"];
		$obj_Language->Sinhala= $row["Sinhala"];
		$obj_Language->Tamil= $row["Tamil"];
		$obj_Language->Bangla= $row["Bangla"];
		$obj_Language->Nepali= $row["Nepali"];
		$obj_Language->Lang1= $row["Lang1"];
		$obj_Language->Lang2= $row["Lang2"];
		$obj_Language->Lang3= $row["Lang3"];

        }
		
		if($obj_Language->LangId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Language;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getLanguageListByLangId($LangId)
    {
    		
        $db = config::dbconfig();

        $arr_LanguageList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_language WHERE LangId=".$LangId." ORDER BY LangId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Language = new Language();
		$obj_Language->LangId= $row["LangId"];
		$obj_Language->LangTag= $row["LangTag"];
		$obj_Language->English= $row["English"];
		$obj_Language->Sinhala= $row["Sinhala"];
		$obj_Language->Tamil= $row["Tamil"];
		$obj_Language->Bangla= $row["Bangla"];
		$obj_Language->Nepali= $row["Nepali"];
		$obj_Language->Lang1= $row["Lang1"];
		$obj_Language->Lang2= $row["Lang2"];
		$obj_Language->Lang3= $row["Lang3"];

        array_push($arr_LanguageList, $obj_Language);
        }
		
		if(count($arr_LanguageList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_LanguageList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteLanguage($LangId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_language WHERE LangId=".$LangId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Language)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Language SET ". 
	"LangId=".common::noSqlInject($obj_Language->LangId).","."LangTag="."'".common::noSqlInject($obj_Language->LangTag)."'".","."English="."'".common::noSqlInject($obj_Language->English)."'".","."Sinhala="."'".common::noSqlInject($obj_Language->Sinhala)."'".","."Tamil="."'".common::noSqlInject($obj_Language->Tamil)."'".","."Bangla="."'".common::noSqlInject($obj_Language->Bangla)."'".","."Nepali="."'".common::noSqlInject($obj_Language->Nepali)."'".","."Lang1="."'".common::noSqlInject($obj_Language->Lang1)."'".","."Lang2="."'".common::noSqlInject($obj_Language->Lang2)."'".","."Lang3="."'".common::noSqlInject($obj_Language->Lang3)."'".	        
	" WHERE  LangId=".$obj_Language->LangId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Language;
			$obj_retresult->msg = "success";
			
		//}
		//else
		//{
		//	$obj_retresult->type = 0;
		//	$obj_retresult->msg = "failed";
		//}
		}
		catch(Exception $ex)
		{
			$obj_retresult->type = 0;
			$obj_retresult->msg = "failed";
		}

		return $obj_retresult;
	}
	
	//---------------------------------------------------------------------------------------------------------
	
	public static function disableLanguage($LangId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Language SET Status=0 WHERE  LangId=".$LangId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Language;
			$obj_retresult->msg = "success";
			
		}
		else
		{
			$obj_retresult->type = 0;
			$obj_retresult->msg = "failed";
		}

		return $obj_retresult;
	}
	

	//---------------------------------------------------------------------------------------------------------

}
?>