<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../config.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/common.php");
class DAL_manageVillage_image
{
	//---------------------------------------------------------------------------------------------------------
	
    public static function addVillage_image($obj_Village_image)
    {

        $db = config::dbconfig();
        $obj_retresult = new returnResult();
        $obj_Village_image->PictureId = DAL_manageVillage_image::getLastVillage_imageId()+1;
		
		 $sql = "INSERT INTO tbl_village_image (PictureId,VillageId,PicturePath,Description) 
		VALUES (".
		common::noSqlInject($obj_Village_image->PictureId).",".common::noSqlInject($obj_Village_image->VillageId).","."'".common::noSqlInject($obj_Village_image->PicturePath)."'".","."'".common::noSqlInject($obj_Village_image->Description)."'".
		");";

        $rs = mysql_query($sql);
        if (mysql_affected_rows() > 0)
        {
            $obj_retresult->type = 1;
            $obj_retresult->msg = "success";
			$obj_retresult->data = $obj_Village_image;
        }
        else
        {
            $obj_retresult->type = 0;
            $obj_retresult->msg = "failed";
        }

        return $obj_retresult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getLastVillage_imageId()
    {

        $lastID = 0;
        $db = config::dbconfig();
         $sql = "SELECT MAX(PictureId) as maxId FROM  tbl_village_image";
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

    public static function getVillage_imageList()
    {
    	  $db = config::dbconfig();

        $arr_Village_imageList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_image ORDER BY PictureId DESC"; //status should be include to sql for get non deleted item
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_image = new Village_image();
		$obj_Village_image->PictureId= $row["PictureId"];
		$obj_Village_image->VillageId= $row["VillageId"];
		$obj_Village_image->PicturePath= $row["PicturePath"];
		$obj_Village_image->Description= $row["Description"];

        array_push($arr_Village_imageList, $obj_Village_image);
        }
		
		if(count($arr_Village_imageList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_imageList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;
    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_imageByPictureId($PictureId)
    {
    		
        $db = config::dbconfig();        
		$obj_retresult = new returnResult();
		$obj_Village_image = new Village_image();
		$obj_Village_image->PictureId = -1;
		$sql = "SELECT * FROM tbl_village_image WHERE PictureId=".$PictureId;
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		        
		$obj_Village_image->PictureId= $row["PictureId"];
		$obj_Village_image->VillageId= $row["VillageId"];
		$obj_Village_image->PicturePath= $row["PicturePath"];
		$obj_Village_image->Description= $row["Description"];

        }
		
		if($obj_Village_image->PictureId >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_image;
		}
		else
		{
			$obj_retresult->type =0;			
		}

        return $obj_retresult;

    }
	
	//---------------------------------------------------------------------------------------------------------

    public static function getVillage_imageListByPictureId($PictureId)
    {
    		
        $db = config::dbconfig();

        $arr_Village_imageList = array ();
		$obj_retresult = new returnResult();
        $sql = "SELECT * FROM tbl_village_image WHERE PictureId=".$PictureId." ORDER BY PictureId DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($rs))
        {		
        $obj_Village_image = new Village_image();
		$obj_Village_image->PictureId= $row["PictureId"];
		$obj_Village_image->VillageId= $row["VillageId"];
		$obj_Village_image->PicturePath= $row["PicturePath"];
		$obj_Village_image->Description= $row["Description"];

        array_push($arr_Village_imageList, $obj_Village_image);
        }
		
		if(count($arr_Village_imageList) >0 )
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $arr_Village_imageList;
		}
		else
		{
			$obj_retresult->type =0;
			
		}

        return $obj_retresult;

    }

	//---------------------------------------------------------------------------------------------------------


	public static function deleteVillage_image($PictureId)
    {
    		
        $db = config::dbconfig();
		$arr_cardList = array();
		$obj_retresult = new returnResult();
        $sql = "DELETE FROM tbl_village_image WHERE PictureId=".$PictureId;
        $rs = mysql_query($sql) or die(mysql_error());
		
		if($rs)
		{
			$obj_retresult->type =1;
		}
		
		return $obj_retresult;
	}
	


	//---------------------------------------------------------------------------------------------------------
	
	public static function update($obj_Village_image)
	{
		$db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		try{
	
	$sql = "UPDATE tbl_village_image SET ". 
	"PictureId=".common::noSqlInject($obj_Village_image->PictureId).","."VillageId=".common::noSqlInject($obj_Village_image->VillageId).","."PicturePath="."'".common::noSqlInject($obj_Village_image->PicturePath)."'".","."Description="."'".common::noSqlInject($obj_Village_image->Description)."'".	        
	" WHERE  PictureId=".$obj_Village_image->PictureId;		 
		 
        $rs = mysql_query($sql);
		//if(mysql_affected_rows()> 0)
		//{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_image;
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
	
	public static function disableVillage_image($PictureId)
	{
		 $db = config::dbconfig();
		$obj_retresult = new returnResult();
		
		$sql = "UPDATE tbl_village_image SET Status=0 WHERE  PictureId=".$PictureId;		 
	        
		 
        $rs = mysql_query($sql);
		if(mysql_affected_rows()> 0)
		{
			$obj_retresult->type = 1;
			$obj_retresult->data = $obj_Village_image;
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
