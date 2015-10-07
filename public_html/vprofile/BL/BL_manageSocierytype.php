<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Socierytype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageSocierytype.php");


class BL_manageSocierytype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageSocierytype::addSocierytype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageSocierytype::deleteSocierytype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageSocierytype::updateSocierytype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addSocierytype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newSocierytype = new Socierytype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newSocierytype->SocieryTypeId = $packet[1];
		$obj_newSocierytype->SocieryTypeName = $packet[2];
		$obj_newSocierytype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Socierytype = DAL_manageSocierytype::addSocierytype($obj_newSocierytype);
            if ($obj_retResult_Socierytype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Socierytype->data->wsGetSocierytypeData();
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

    public static function addSocierytype2($SocieryTypeId,$SocieryTypeName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newSocierytype = new Socierytype();
		
		$obj_newuser->setSocierytype($SocieryTypeId,$SocieryTypeName,$Description);
       // $isExist = BL_manageSocierytype::isExist($obj_newSocierytype->id);

        if (!$isExist)
        {
            $obj_retResult_Socierytype = DAL_manageSocierytype::addSocierytype($obj_newSocierytype);
            if ($obj_retResult_Socierytype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Socierytype->data;
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
            $obj_retResult->msg = "Sorry! Socierytype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSocierytype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Socierytype = new Socierytype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Socierytype->SocieryTypeId = $packet[0];
		$obj_Socierytype->SocieryTypeName = $packet[1];
		$obj_Socierytype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Socierytype = DAL_manageSocierytype::update($obj_Socierytype);

        if ($obj_retResult_Socierytype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Socierytype updation is Success";
			$retrunUserpacket = $obj_retResult_Socierytype->data->wsGetSocierytypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Socierytype updation is Failed";
			$result_Socierytype = DAL_manageSocierytype::getSocierytypeBySocieryTypeId($obj_Socierytype->SocieryTypeId);
			if($result_Socierytype->type ==1)
			{
			$retrunUserpacket = $result_Socierytype->data->wsGetSocierytypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateSocierytype2($SocieryTypeId,$SocieryTypeName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newSocierytype = new Socierytype();
	
		$obj_newSocierytype->SocieryTypeId=$SocieryTypeId;
		$obj_newSocierytype->SocieryTypeName=$SocieryTypeName;
		$obj_newSocierytype->Description=$Description;

	   
        $issuccess = DAL_manageSocierytype::updateSocierytype($obj_newSocierytype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageSocierytype::getSocierytypeBySocieryTypeId($obj_newSocierytype->SocieryTypeId);
            $obj_retResult->msg = "Socierytype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Socierytype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getSocierytypeList()
    {
        $obj_retResult = DAL_manageSocierytype::getSocierytypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getSocierytypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageSocierytype::getAllSocierytype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageSocierytype::searchSocierytypeBySocieryTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Socierytype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>SocieryTypeId</th>";
		$html .= "<th>SocieryTypeName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_SocierytypeList as $obj_Socierytype)
            {               

                    $html .= $obj_Socierytype->drawTableViewSocierytype(); 
                
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

	public static function deleteSocierytype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$SocieryTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_SocieryTypeId =0;
			
			$retResult = BL_manageSocierytype::getSocierytypeListBySocieryTypeId($SocieryTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Socierytype = $retResult->data[0];			
			$obj_result2 = DAL_manageSocierytype::deleteSocierytype($obj_Socierytype->SocieryTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_SocieryTypeId = $obj_Socierytype->SocieryTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Socierytype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Socierytype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Socierytype->SocieryTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getSocierytypeListBySocieryTypeId($SocieryTypeId)
    {
        $obj_retResult = DAL_manageSocierytype::getSocierytypeListBySocieryTypeId($SocieryTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildSocierytype($SocieryTypeId,$ChildSocieryTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageSocierytype::getSocierytypeListBySocieryTypeId($ChildSocieryTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_SocierytypeList = $obj_retResult->data;
				$obj_Socierytype = $arr_SocierytypeList[0];
				
				$arrParentIds = explode(",",$obj_Socierytype->Url);
				
				foreach($arrParentIds as $SocierytypeParentId)
				{
					if($SocierytypeParentId == $SocieryTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>