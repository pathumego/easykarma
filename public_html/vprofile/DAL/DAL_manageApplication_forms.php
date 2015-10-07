<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageApplication_forms
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addApplication_forms($obj_Application_forms)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Application_forms->_id = DAL_manageApplication_forms::getLastApplication_formsId()+1;
		
		 $sql = "INSERT INTO tbl_application_forms (_id,ref_no,mobile_no,mic_no,cus_title,nic_code,nic_no,cus_name,cus_name_other,cus_country,cus_company,cus_address1,cus_address2,district,cus_telephone,cus_occupation,other,amount_spend,no_of_family1,no_of_family2,cus_language,cus_email,sim_no,added_date,img_name,doc_path,folder_path,job_id,meta,status) 
		VALUES (".
		common::noSqlInject($obj_Application_forms->_id).",".common::noSqlInject($obj_Application_forms->ref_no).","."'".common::noSqlInject($obj_Application_forms->mobile_no)."'".",".common::noSqlInject($obj_Application_forms->mic_no).","."'".common::noSqlInject($obj_Application_forms->cus_title)."'".","."'".common::noSqlInject($obj_Application_forms->nic_code)."'".","."'".common::noSqlInject($obj_Application_forms->nic_no)."'".","."'".common::noSqlInject($obj_Application_forms->cus_name)."'".","."'".common::noSqlInject($obj_Application_forms->cus_name_other)."'".","."'".common::noSqlInject($obj_Application_forms->cus_country)."'".","."'".common::noSqlInject($obj_Application_forms->cus_company)."'".","."'".common::noSqlInject($obj_Application_forms->cus_address1)."'".","."'".common::noSqlInject($obj_Application_forms->cus_address2)."'".","."'".common::noSqlInject($obj_Application_forms->district)."'".",".common::noSqlInject($obj_Application_forms->cus_telephone).","."'".common::noSqlInject($obj_Application_forms->cus_occupation)."'".","."'".common::noSqlInject($obj_Application_forms->other)."'".",".common::noSqlInject($obj_Application_forms->amount_spend).",".common::noSqlInject($obj_Application_forms->no_of_family1).",".common::noSqlInject($obj_Application_forms->no_of_family2).",".common::noSqlInject($obj_Application_forms->cus_language).","."'".common::noSqlInject($obj_Application_forms->cus_email)."'".","."'".common::noSqlInject($obj_Application_forms->sim_no)."'".","."'".common::noSqlInject($obj_Application_forms->added_date)."'".","."'".common::noSqlInject($obj_Application_forms->img_name)."'".","."'".common::noSqlInject($obj_Application_forms->doc_path)."'".","."'".common::noSqlInject($obj_Application_forms->folder_path)."'".",".common::noSqlInject($obj_Application_forms->job_id).","."'".common::noSqlInject($obj_Application_forms->meta)."'".",".common::noSqlInject($obj_Application_forms->status).
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Application_forms;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastApplication_formsId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(_id) as maxId FROM  tbl_application_forms";
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

    public static function getApplication_formsList()
    {
    	  $db = config::dbconfig();

        $arr_Application_formsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_application_forms ORDER BY _id DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Application_forms = new Application_forms();
		$obj_Application_forms->_id= $row["_id"];
		$obj_Application_forms->ref_no= $row["ref_no"];
		$obj_Application_forms->mobile_no= $row["mobile_no"];
		$obj_Application_forms->mic_no= $row["mic_no"];
		$obj_Application_forms->cus_title= $row["cus_title"];
		$obj_Application_forms->nic_code= $row["nic_code"];
		$obj_Application_forms->nic_no= $row["nic_no"];
		$obj_Application_forms->cus_name= $row["cus_name"];
		$obj_Application_forms->cus_name_other= $row["cus_name_other"];
		$obj_Application_forms->cus_country= $row["cus_country"];
		$obj_Application_forms->cus_company= $row["cus_company"];
		$obj_Application_forms->cus_address1= $row["cus_address1"];
		$obj_Application_forms->cus_address2= $row["cus_address2"];
		$obj_Application_forms->district= $row["district"];
		$obj_Application_forms->cus_telephone= $row["cus_telephone"];
		$obj_Application_forms->cus_occupation= $row["cus_occupation"];
		$obj_Application_forms->other= $row["other"];
		$obj_Application_forms->amount_spend= $row["amount_spend"];
		$obj_Application_forms->no_of_family1= $row["no_of_family1"];
		$obj_Application_forms->no_of_family2= $row["no_of_family2"];
		$obj_Application_forms->cus_language= $row["cus_language"];
		$obj_Application_forms->cus_email= $row["cus_email"];
		$obj_Application_forms->sim_no= $row["sim_no"];
		$obj_Application_forms->added_date= $row["added_date"];
		$obj_Application_forms->img_name= $row["img_name"];
		$obj_Application_forms->doc_path= $row["doc_path"];
		$obj_Application_forms->folder_path= $row["folder_path"];
		$obj_Application_forms->job_id= $row["job_id"];
		$obj_Application_forms->meta= $row["meta"];
		$obj_Application_forms->status= $row["status"];

        array_push($arr_Application_formsList, $obj_Application_forms);
        }
		
		if(count($arr_Application_formsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Application_formsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getApplication_formsBy_id($_id)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Application_forms = new Application_forms();
		$obj_Application_forms->_id = -1;
		$sql = "SELECT * FROM tbl_application_forms WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Application_forms->_id= $row["_id"];
		$obj_Application_forms->ref_no= $row["ref_no"];
		$obj_Application_forms->mobile_no= $row["mobile_no"];
		$obj_Application_forms->mic_no= $row["mic_no"];
		$obj_Application_forms->cus_title= $row["cus_title"];
		$obj_Application_forms->nic_code= $row["nic_code"];
		$obj_Application_forms->nic_no= $row["nic_no"];
		$obj_Application_forms->cus_name= $row["cus_name"];
		$obj_Application_forms->cus_name_other= $row["cus_name_other"];
		$obj_Application_forms->cus_country= $row["cus_country"];
		$obj_Application_forms->cus_company= $row["cus_company"];
		$obj_Application_forms->cus_address1= $row["cus_address1"];
		$obj_Application_forms->cus_address2= $row["cus_address2"];
		$obj_Application_forms->district= $row["district"];
		$obj_Application_forms->cus_telephone= $row["cus_telephone"];
		$obj_Application_forms->cus_occupation= $row["cus_occupation"];
		$obj_Application_forms->other= $row["other"];
		$obj_Application_forms->amount_spend= $row["amount_spend"];
		$obj_Application_forms->no_of_family1= $row["no_of_family1"];
		$obj_Application_forms->no_of_family2= $row["no_of_family2"];
		$obj_Application_forms->cus_language= $row["cus_language"];
		$obj_Application_forms->cus_email= $row["cus_email"];
		$obj_Application_forms->sim_no= $row["sim_no"];
		$obj_Application_forms->added_date= $row["added_date"];
		$obj_Application_forms->img_name= $row["img_name"];
		$obj_Application_forms->doc_path= $row["doc_path"];
		$obj_Application_forms->folder_path= $row["folder_path"];
		$obj_Application_forms->job_id= $row["job_id"];
		$obj_Application_forms->meta= $row["meta"];
		$obj_Application_forms->status= $row["status"];

        }
		
		if($obj_Application_forms->_id >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Application_forms;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getApplication_formsListBy_id($_id)
    {
    		
        $db = config::dbconfig();

        $arr_Application_formsList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_application_forms WHERE _id=".$_id." ORDER BY _id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Application_forms = new Application_forms();
		$obj_Application_forms->_id= $row["_id"];
		$obj_Application_forms->ref_no= $row["ref_no"];
		$obj_Application_forms->mobile_no= $row["mobile_no"];
		$obj_Application_forms->mic_no= $row["mic_no"];
		$obj_Application_forms->cus_title= $row["cus_title"];
		$obj_Application_forms->nic_code= $row["nic_code"];
		$obj_Application_forms->nic_no= $row["nic_no"];
		$obj_Application_forms->cus_name= $row["cus_name"];
		$obj_Application_forms->cus_name_other= $row["cus_name_other"];
		$obj_Application_forms->cus_country= $row["cus_country"];
		$obj_Application_forms->cus_company= $row["cus_company"];
		$obj_Application_forms->cus_address1= $row["cus_address1"];
		$obj_Application_forms->cus_address2= $row["cus_address2"];
		$obj_Application_forms->district= $row["district"];
		$obj_Application_forms->cus_telephone= $row["cus_telephone"];
		$obj_Application_forms->cus_occupation= $row["cus_occupation"];
		$obj_Application_forms->other= $row["other"];
		$obj_Application_forms->amount_spend= $row["amount_spend"];
		$obj_Application_forms->no_of_family1= $row["no_of_family1"];
		$obj_Application_forms->no_of_family2= $row["no_of_family2"];
		$obj_Application_forms->cus_language= $row["cus_language"];
		$obj_Application_forms->cus_email= $row["cus_email"];
		$obj_Application_forms->sim_no= $row["sim_no"];
		$obj_Application_forms->added_date= $row["added_date"];
		$obj_Application_forms->img_name= $row["img_name"];
		$obj_Application_forms->doc_path= $row["doc_path"];
		$obj_Application_forms->folder_path= $row["folder_path"];
		$obj_Application_forms->job_id= $row["job_id"];
		$obj_Application_forms->meta= $row["meta"];
		$obj_Application_forms->status= $row["status"];

        array_push($arr_Application_formsList, $obj_Application_forms);
        }
		
		if(count($arr_Application_formsList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Application_formsList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function delete($_id)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_application_forms WHERE _id=".$_id;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Application_forms)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_Application_forms SET ". 
	"_id=".common::noSqlInject($obj_Application_forms->_id).","."ref_no=".common::noSqlInject($obj_Application_forms->ref_no).","."mobile_no="."'".common::noSqlInject($obj_Application_forms->mobile_no)."'".","."mic_no=".common::noSqlInject($obj_Application_forms->mic_no).","."cus_title="."'".common::noSqlInject($obj_Application_forms->cus_title)."'".","."nic_code="."'".common::noSqlInject($obj_Application_forms->nic_code)."'".","."nic_no="."'".common::noSqlInject($obj_Application_forms->nic_no)."'".","."cus_name="."'".common::noSqlInject($obj_Application_forms->cus_name)."'".","."cus_name_other="."'".common::noSqlInject($obj_Application_forms->cus_name_other)."'".","."cus_country="."'".common::noSqlInject($obj_Application_forms->cus_country)."'".","."cus_company="."'".common::noSqlInject($obj_Application_forms->cus_company)."'".","."cus_address1="."'".common::noSqlInject($obj_Application_forms->cus_address1)."'".","."cus_address2="."'".common::noSqlInject($obj_Application_forms->cus_address2)."'".","."district="."'".common::noSqlInject($obj_Application_forms->district)."'".","."cus_telephone=".common::noSqlInject($obj_Application_forms->cus_telephone).","."cus_occupation="."'".common::noSqlInject($obj_Application_forms->cus_occupation)."'".","."other="."'".common::noSqlInject($obj_Application_forms->other)."'".","."amount_spend=".common::noSqlInject($obj_Application_forms->amount_spend).","."no_of_family1=".common::noSqlInject($obj_Application_forms->no_of_family1).","."no_of_family2=".common::noSqlInject($obj_Application_forms->no_of_family2).","."cus_language=".common::noSqlInject($obj_Application_forms->cus_language).","."cus_email="."'".common::noSqlInject($obj_Application_forms->cus_email)."'".","."sim_no="."'".common::noSqlInject($obj_Application_forms->sim_no)."'".","."added_date="."'".common::noSqlInject($obj_Application_forms->added_date)."'".","."img_name="."'".common::noSqlInject($obj_Application_forms->img_name)."'".","."doc_path="."'".common::noSqlInject($obj_Application_forms->doc_path)."'".","."folder_path="."'".common::noSqlInject($obj_Application_forms->folder_path)."'".","."job_id=".common::noSqlInject($obj_Application_forms->job_id).","."meta="."'".common::noSqlInject($obj_Application_forms->meta)."'".","."status=".common::noSqlInject($obj_Application_forms->status).	        
	" WHERE  _id=".$obj_Application_forms->_id;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Application_forms;
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
	
	public static function disableApplication_forms($_id)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_Application_forms SET Status=0 WHERE  _id=".$_id;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Application_forms;
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
