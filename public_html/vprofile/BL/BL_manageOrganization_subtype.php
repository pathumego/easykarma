<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Organization_subtype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOrganization_subtype.php");


class BL_manageOrganization_subtype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageOrganization_subtype::addOrganization_subtype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageOrganization_subtype::deleteOrganization_subtype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageOrganization_subtype::updateOrganization_subtype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addOrganization_subtype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newOrganization_subtype = new Organization_subtype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newOrganization_subtype->OrganizationSubTypeId = $packet[1];
		$obj_newOrganization_subtype->OrganizationSubTypeName = $packet[2];
		$obj_newOrganization_subtype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Organization_subtype = DAL_manageOrganization_subtype::addOrganization_subtype($obj_newOrganization_subtype);
            if ($obj_retResult_Organization_subtype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Organization_subtype->data->wsGetOrganization_subtypeData();
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

    public static function addOrganization_subtype2($OrganizationSubTypeId,$OrganizationSubTypeName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newOrganization_subtype = new Organization_subtype();
		
		$obj_newuser->setOrganization_subtype($OrganizationSubTypeId,$OrganizationSubTypeName,$Description);
       // $isExist = BL_manageOrganization_subtype::isExist($obj_newOrganization_subtype->id);

        if (!$isExist)
        {
            $obj_retResult_Organization_subtype = DAL_manageOrganization_subtype::addOrganization_subtype($obj_newOrganization_subtype);
            if ($obj_retResult_Organization_subtype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Organization_subtype->data;
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
            $obj_retResult->msg = "Sorry! Organization_subtype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOrganization_subtype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Organization_subtype = new Organization_subtype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Organization_subtype->OrganizationSubTypeId = $packet[0];
		$obj_Organization_subtype->OrganizationSubTypeName = $packet[1];
		$obj_Organization_subtype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Organization_subtype = DAL_manageOrganization_subtype::update($obj_Organization_subtype);

        if ($obj_retResult_Organization_subtype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Organization_subtype updation is Success";
			$retrunUserpacket = $obj_retResult_Organization_subtype->data->wsGetOrganization_subtypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Organization_subtype updation is Failed";
			$result_Organization_subtype = DAL_manageOrganization_subtype::getOrganization_subtypeByOrganizationSubTypeId($obj_Organization_subtype->OrganizationSubTypeId);
			if($result_Organization_subtype->type ==1)
			{
			$retrunUserpacket = $result_Organization_subtype->data->wsGetOrganization_subtypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOrganization_subtype2($OrganizationSubTypeId,$OrganizationSubTypeName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newOrganization_subtype = new Organization_subtype();
	
		$obj_newOrganization_subtype->OrganizationSubTypeId=$OrganizationSubTypeId;
		$obj_newOrganization_subtype->OrganizationSubTypeName=$OrganizationSubTypeName;
		$obj_newOrganization_subtype->Description=$Description;

	   
        $issuccess = DAL_manageOrganization_subtype::updateOrganization_subtype($obj_newOrganization_subtype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageOrganization_subtype::getOrganization_subtypeByOrganizationSubTypeId($obj_newOrganization_subtype->OrganizationSubTypeId);
            $obj_retResult->msg = "Organization_subtype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Organization_subtype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getOrganization_subtypeList()
    {
        $obj_retResult = DAL_manageOrganization_subtype::getOrganization_subtypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getOrganization_subtypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageOrganization_subtype::getAllOrganization_subtype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageOrganization_subtype::searchOrganization_subtypeByOrganizationSubTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Organization_subtype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>OrganizationSubTypeId</th>";
		$html .= "<th>OrganizationSubTypeName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Organization_subtypeList as $obj_Organization_subtype)
            {               

                    $html .= $obj_Organization_subtype->drawTableViewOrganization_subtype(); 
                
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

	public static function deleteOrganization_subtype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$OrganizationSubTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_OrganizationSubTypeId =0;
			
			$retResult = BL_manageOrganization_subtype::getOrganization_subtypeListByOrganizationSubTypeId($OrganizationSubTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Organization_subtype = $retResult->data[0];			
			$obj_result2 = DAL_manageOrganization_subtype::deleteOrganization_subtype($obj_Organization_subtype->OrganizationSubTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_OrganizationSubTypeId = $obj_Organization_subtype->OrganizationSubTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Organization_subtype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Organization_subtype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Organization_subtype->OrganizationSubTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getOrganization_subtypeListByOrganizationSubTypeId($OrganizationSubTypeId)
    {
        $obj_retResult = DAL_manageOrganization_subtype::getOrganization_subtypeListByOrganizationSubTypeId($OrganizationSubTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildOrganization_subtype($OrganizationSubTypeId,$ChildOrganizationSubTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageOrganization_subtype::getOrganization_subtypeListByOrganizationSubTypeId($ChildOrganizationSubTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Organization_subtypeList = $obj_retResult->data;
				$obj_Organization_subtype = $arr_Organization_subtypeList[0];
				
				$arrParentIds = explode(",",$obj_Organization_subtype->Url);
				
				foreach($arrParentIds as $Organization_subtypeParentId)
				{
					if($Organization_subtypeParentId == $OrganizationSubTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>