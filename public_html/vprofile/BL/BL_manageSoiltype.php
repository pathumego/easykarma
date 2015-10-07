<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Soiltype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSoiltype.php");


class BL_manageSoiltype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageSoiltype::addSoiltype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageSoiltype::deleteSoiltype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageSoiltype::updateSoiltype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addSoiltype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newSoiltype = new Soiltype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newSoiltype->TblId = $packet[1];
		$obj_newSoiltype->SoilTypeId = $packet[1];
		$obj_newSoiltype->SoilTypeName = $packet[3];
		$obj_newSoiltype->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Soiltype = DAL_manageSoiltype::addSoiltype($obj_newSoiltype);
            if ($obj_retResult_Soiltype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Soiltype->data->wsGetSoiltypeData();
            }
            else
            {
                $obj_retResult->type = 0;
                $obj_retResult->msg = "Failed";
				
            }

       // }
       // else
       // {
       //     $obj_retResult->type = 0;
       //     $obj_retResult->msg = "Sorry! User already exist";
       // }
       
		}
		$returnPacket = array ($obj_retResult->type,$obj_retResult->msg,$dummyId);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
	}
    //---------------------------------------------------------------------------------------------------------

    public static function addSoiltype2($TblId,$SoilTypeId,$SoilTypeName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newSoiltype = new Soiltype();
		
		$obj_newuser->setSoiltype($TblId,$SoilTypeId,$SoilTypeName,$Description);
       // $isExist = BL_manageSoiltype::isExist($obj_newSoiltype->id);

        if (!$isExist)
        {
            $obj_retResult_Soiltype = DAL_manageSoiltype::addSoiltype($obj_newSoiltype);
            if ($obj_retResult_Soiltype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Soiltype->data;
            }
            else
            {
                $obj_retResult->type = 0;
                $obj_retResult->msg = "Failed";
				
            }

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Sorry! Soiltype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSoiltype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Soiltype = new Soiltype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Soiltype->TblId = $packet[0];
		$obj_Soiltype->SoilTypeId = $packet[1];
		$obj_Soiltype->SoilTypeName = $packet[2];
		$obj_Soiltype->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Soiltype = DAL_manageSoiltype::update($obj_Soiltype);

        if ($obj_retResult_Soiltype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Soiltype updation is Success";
			$retrunUserpacket = $obj_retResult_Soiltype->data->wsGetSoiltypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Soiltype updation is Failed";
			$result_Soiltype = DAL_manageSoiltype::getSoiltypeByTblId($obj_Soiltype->TblId);
			if($result_Soiltype->type ==1)
			{
			$retrunUserpacket = $result_Soiltype->data->wsGetSoiltypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSoiltype2($TblId,$SoilTypeId,$SoilTypeName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newSoiltype = new Soiltype();
	
		$obj_newSoiltype->TblId=$TblId;
		$obj_newSoiltype->SoilTypeId=$SoilTypeId;
		$obj_newSoiltype->SoilTypeName=$SoilTypeName;
		$obj_newSoiltype->Description=$Description;

	   
        $issuccess = DAL_manageSoiltype::updateSoiltype($obj_newSoiltype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageSoiltype::getSoiltypeByTblId($obj_newSoiltype->TblId);
            $obj_retResult->msg = "Soiltype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Soiltype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getSoiltypeList()
    {
        $obj_retResult = DAL_manageSoiltype::getSoiltypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getSoiltypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageSoiltype::getAllSoiltype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageSoiltype::searchSoiltypeByTblId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Soiltype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TblId</th>";
		$html .= "<th>SoilTypeId</th>";
		$html .= "<th>SoilTypeName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_SoiltypeList as $obj_Soiltype)
            {               

                    $html .= $obj_Soiltype->drawTableViewSoiltype(); 
                
            }
		$html .= "</table></div>";
        }
        else
        {
            $html = "No user found";

        }
        return $html;
    }
	
    //---------------------------------------------------------------------------------------------------------  

	public static function deleteSoiltype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TblId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TblId =0;
			
			$retResult = BL_manageSoiltype::getSoiltypeListByTblId($TblId);
			if($retResult->type ==1)
			{
			
			$obj_Soiltype = $retResult->data[0];			
			$obj_result2 = DAL_manageSoiltype::deleteSoiltype($obj_Soiltype->TblId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TblId = $obj_Soiltype->TblId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Soiltype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Soiltype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Soiltype->TblId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getSoiltypeListByTblId($TblId)
    {
        $obj_retResult = DAL_manageSoiltype::getSoiltypeListByTblId($TblId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildSoiltype($TblId,$ChildTblId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageSoiltype::getSoiltypeListByTblId($ChildTblId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_SoiltypeList = $obj_retResult->data;
				$obj_Soiltype = $arr_SoiltypeList[0];
				
				$arrParentIds = explode(",",$obj_Soiltype->Url);
				
				foreach($arrParentIds as $SoiltypeParentId)
				{
					if($SoiltypeParentId == $TblId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>