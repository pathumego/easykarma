<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Organization.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOrganization.php");


class BL_manageOrganization
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageOrganization::addOrganization($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageOrganization::deleteOrganization($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageOrganization::updateOrganization($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addOrganization($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newOrganization = new Organization();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newOrganization->OrganizationId = $packet[1];
		$obj_newOrganization->Name = $packet[2];
		$obj_newOrganization->Description = $packet[3];
		$obj_newOrganization->Address = $packet[4];
		$obj_newOrganization->telephone = $packet[5];
		$obj_newOrganization->fax = $packet[6];
		$obj_newOrganization->website = $packet[7];
		$obj_newOrganization->email = $packet[8];
		$obj_newOrganization->OrganizationTypeId = $packet[9]== "" ? 0 :$packet[9] ;
		$obj_newOrganization->OrganizationSubTypeId = $packet[10]== "" ? 0 :$packet[10] ;

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Organization = DAL_manageOrganization::addOrganization($obj_newOrganization);
            if ($obj_retResult_Organization->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Organization->data->wsGetOrganizationData();
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

    public static function addOrganization2($OrganizationId,$Name,$Description,$Address,$telephone,$fax,$website,$email,$OrganizationTypeId,$OrganizationSubTypeId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newOrganization = new Organization();
		
		$obj_newuser->setOrganization($OrganizationId,$Name,$Description,$Address,$telephone,$fax,$website,$email,$OrganizationTypeId,$OrganizationSubTypeId);
       // $isExist = BL_manageOrganization::isExist($obj_newOrganization->id);

        if (!$isExist)
        {
            $obj_retResult_Organization = DAL_manageOrganization::addOrganization($obj_newOrganization);
            if ($obj_retResult_Organization->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Organization->data;
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
            $obj_retResult->msg = "Sorry! Organization already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOrganization($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Organization = new Organization();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Organization->OrganizationId = $packet[0];
		$obj_Organization->Name = $packet[1];
		$obj_Organization->Description = $packet[2];
		$obj_Organization->Address = $packet[3];
		$obj_Organization->telephone = $packet[4];
		$obj_Organization->fax = $packet[5];
		$obj_Organization->website = $packet[6];
		$obj_Organization->email = $packet[7];
		$obj_Organization->OrganizationTypeId = $packet[8];
		$obj_Organization->OrganizationSubTypeId = $packet[9];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Organization = DAL_manageOrganization::update($obj_Organization);

        if ($obj_retResult_Organization->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Organization updation is Success";
			$retrunUserpacket = $obj_retResult_Organization->data->wsGetOrganizationData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Organization updation is Failed";
			$result_Organization = DAL_manageOrganization::getOrganizationByOrganizationId($obj_Organization->OrganizationId);
			if($result_Organization->type ==1)
			{
			$retrunUserpacket = $result_Organization->data->wsGetOrganizationData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOrganization2($OrganizationId,$Name,$Description,$Address,$telephone,$fax,$website,$email,$OrganizationTypeId,$OrganizationSubTypeId)
    {
        $obj_retResult = new returnResult();
        $obj_newOrganization = new Organization();
	
		$obj_newOrganization->OrganizationId=$OrganizationId;
		$obj_newOrganization->Name=$Name;
		$obj_newOrganization->Description=$Description;
		$obj_newOrganization->Address=$Address;
		$obj_newOrganization->telephone=$telephone;
		$obj_newOrganization->fax=$fax;
		$obj_newOrganization->website=$website;
		$obj_newOrganization->email=$email;
		$obj_newOrganization->OrganizationTypeId=$OrganizationTypeId;
		$obj_newOrganization->OrganizationSubTypeId=$OrganizationSubTypeId;

	   
        $issuccess = DAL_manageOrganization::updateOrganization($obj_newOrganization);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageOrganization::getOrganizationByOrganizationId($obj_newOrganization->OrganizationId);
            $obj_retResult->msg = "Organization updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Organization updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getOrganizationList()
    {
        $obj_retResult = DAL_manageOrganization::getOrganizationList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getOrganizationList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageOrganization::getAllOrganization($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageOrganization::searchOrganizationByOrganizationId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Organization List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>OrganizationId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>Description</th>";
		$html .= "<th>Address</th>";
		$html .= "<th>telephone</th>";
		$html .= "<th>fax</th>";
		$html .= "<th>website</th>";
		$html .= "<th>email</th>";
		$html .= "<th>OrganizationTypeId</th>";
		$html .= "<th>OrganizationSubTypeId</th>";

		$html .= "</tr>";
		
            foreach ($arr_OrganizationList as $obj_Organization)
            {               

                    $html .= $obj_Organization->drawTableViewOrganization(); 
                
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

	public static function deleteOrganization($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$OrganizationId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_OrganizationId =0;
			
			$retResult = BL_manageOrganization::getOrganizationListByOrganizationId($OrganizationId);
			if($retResult->type ==1)
			{
			
			$obj_Organization = $retResult->data[0];			
			$obj_result2 = DAL_manageOrganization::deleteOrganization($obj_Organization->OrganizationId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_OrganizationId = $obj_Organization->OrganizationId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Organization";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Organization you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Organization->OrganizationId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getOrganizationListByOrganizationId($OrganizationId)
    {
        $obj_retResult = DAL_manageOrganization::getOrganizationListByOrganizationId($OrganizationId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildOrganization($OrganizationId,$ChildOrganizationId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageOrganization::getOrganizationListByOrganizationId($ChildOrganizationId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_OrganizationList = $obj_retResult->data;
				$obj_Organization = $arr_OrganizationList[0];
				
				$arrParentIds = explode(",",$obj_Organization->Url);
				
				foreach($arrParentIds as $OrganizationParentId)
				{
					if($OrganizationParentId == $OrganizationId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>