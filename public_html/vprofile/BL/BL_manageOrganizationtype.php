<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Organizationtype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOrganizationtype.php");


class BL_manageOrganizationtype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageOrganizationtype::addOrganizationtype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageOrganizationtype::deleteOrganizationtype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageOrganizationtype::updateOrganizationtype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addOrganizationtype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newOrganizationtype = new Organizationtype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newOrganizationtype->OrganizationTypeId = $packet[1];
		$obj_newOrganizationtype->OrganizationTypeName = $packet[2];
		$obj_newOrganizationtype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Organizationtype = DAL_manageOrganizationtype::addOrganizationtype($obj_newOrganizationtype);
            if ($obj_retResult_Organizationtype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Organizationtype->data->wsGetOrganizationtypeData();
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

    public static function addOrganizationtype2($OrganizationTypeId,$OrganizationTypeName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newOrganizationtype = new Organizationtype();
		
		$obj_newuser->setOrganizationtype($OrganizationTypeId,$OrganizationTypeName,$Description);
       // $isExist = BL_manageOrganizationtype::isExist($obj_newOrganizationtype->id);

        if (!$isExist)
        {
            $obj_retResult_Organizationtype = DAL_manageOrganizationtype::addOrganizationtype($obj_newOrganizationtype);
            if ($obj_retResult_Organizationtype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Organizationtype->data;
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
            $obj_retResult->msg = "Sorry! Organizationtype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOrganizationtype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Organizationtype = new Organizationtype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Organizationtype->OrganizationTypeId = $packet[0];
		$obj_Organizationtype->OrganizationTypeName = $packet[1];
		$obj_Organizationtype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Organizationtype = DAL_manageOrganizationtype::update($obj_Organizationtype);

        if ($obj_retResult_Organizationtype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Organizationtype updation is Success";
			$retrunUserpacket = $obj_retResult_Organizationtype->data->wsGetOrganizationtypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Organizationtype updation is Failed";
			$result_Organizationtype = DAL_manageOrganizationtype::getOrganizationtypeByOrganizationTypeId($obj_Organizationtype->OrganizationTypeId);
			if($result_Organizationtype->type ==1)
			{
			$retrunUserpacket = $result_Organizationtype->data->wsGetOrganizationtypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOrganizationtype2($OrganizationTypeId,$OrganizationTypeName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newOrganizationtype = new Organizationtype();
	
		$obj_newOrganizationtype->OrganizationTypeId=$OrganizationTypeId;
		$obj_newOrganizationtype->OrganizationTypeName=$OrganizationTypeName;
		$obj_newOrganizationtype->Description=$Description;

	   
        $issuccess = DAL_manageOrganizationtype::updateOrganizationtype($obj_newOrganizationtype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageOrganizationtype::getOrganizationtypeByOrganizationTypeId($obj_newOrganizationtype->OrganizationTypeId);
            $obj_retResult->msg = "Organizationtype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Organizationtype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getOrganizationtypeList()
    {
        $obj_retResult = DAL_manageOrganizationtype::getOrganizationtypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getOrganizationtypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageOrganizationtype::getAllOrganizationtype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageOrganizationtype::searchOrganizationtypeByOrganizationTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Organizationtype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>OrganizationTypeId</th>";
		$html .= "<th>OrganizationTypeName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_OrganizationtypeList as $obj_Organizationtype)
            {               

                    $html .= $obj_Organizationtype->drawTableViewOrganizationtype(); 
                
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

	public static function deleteOrganizationtype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$OrganizationTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_OrganizationTypeId =0;
			
			$retResult = BL_manageOrganizationtype::getOrganizationtypeListByOrganizationTypeId($OrganizationTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Organizationtype = $retResult->data[0];			
			$obj_result2 = DAL_manageOrganizationtype::deleteOrganizationtype($obj_Organizationtype->OrganizationTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_OrganizationTypeId = $obj_Organizationtype->OrganizationTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Organizationtype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Organizationtype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Organizationtype->OrganizationTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getOrganizationtypeListByOrganizationTypeId($OrganizationTypeId)
    {
        $obj_retResult = DAL_manageOrganizationtype::getOrganizationtypeListByOrganizationTypeId($OrganizationTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildOrganizationtype($OrganizationTypeId,$ChildOrganizationTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageOrganizationtype::getOrganizationtypeListByOrganizationTypeId($ChildOrganizationTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_OrganizationtypeList = $obj_retResult->data;
				$obj_Organizationtype = $arr_OrganizationtypeList[0];
				
				$arrParentIds = explode(",",$obj_Organizationtype->Url);
				
				foreach($arrParentIds as $OrganizationtypeParentId)
				{
					if($OrganizationtypeParentId == $OrganizationTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>