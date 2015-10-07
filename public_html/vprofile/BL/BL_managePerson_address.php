<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_address.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_address.php");


class BL_managePerson_address
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_address::addPerson_address($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_address::deletePerson_address($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_address::updatePerson_address($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_address($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_address = new Person_address();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_address->AddressId = $packet[1];
		$obj_newPerson_address->Address = $packet[2];
		$obj_newPerson_address->AddressType = $packet[3];
		$obj_newPerson_address->VillageId = $packet[4];
		$obj_newPerson_address->PersonId = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_address = DAL_managePerson_address::addPerson_address($obj_newPerson_address);
            if ($obj_retResult_Person_address->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_address->data->wsGetPerson_addressData();
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

    public static function addPerson_address2($AddressId,$Address,$AddressType,$VillageId,$PersonId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_address = new Person_address();
		
		$obj_newuser->setPerson_address($AddressId,$Address,$AddressType,$VillageId,$PersonId);
       // $isExist = BL_managePerson_address::isExist($obj_newPerson_address->id);

        if (!$isExist)
        {
            $obj_retResult_Person_address = DAL_managePerson_address::addPerson_address($obj_newPerson_address);
            if ($obj_retResult_Person_address->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_address->data;
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
            $obj_retResult->msg = "Sorry! Person_address already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_address($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_address = new Person_address();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_address->AddressId = $packet[0];
		$obj_Person_address->Address = $packet[1];
		$obj_Person_address->AddressType = $packet[2];
		$obj_Person_address->VillageId = $packet[3] == "" ? 0 : $packet[3];
		$obj_Person_address->PersonId = $packet[4] == "" ? 0 :  $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_address = DAL_managePerson_address::update($obj_Person_address);

        if ($obj_retResult_Person_address->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_address updation is Success";
			$retrunUserpacket = $obj_retResult_Person_address->data->wsGetPerson_addressData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_address updation is Failed";
			$result_Person_address = DAL_managePerson_address::getPerson_addressByAddressId($obj_Person_address->AddressId);
			if($result_Person_address->type ==1)
			{
			$retrunUserpacket = $result_Person_address->data->wsGetPerson_addressData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_address2($AddressId,$Address,$AddressType,$VillageId,$PersonId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_address = new Person_address();
	
		$obj_newPerson_address->AddressId=$AddressId;
		$obj_newPerson_address->Address=$Address;
		$obj_newPerson_address->AddressType=$AddressType;
		$obj_newPerson_address->VillageId=$VillageId;
		$obj_newPerson_address->PersonId=$PersonId;

	   
        $issuccess = DAL_managePerson_address::updatePerson_address($obj_newPerson_address);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_address::getPerson_addressByAddressId($obj_newPerson_address->AddressId);
            $obj_retResult->msg = "Person_address updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_address updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_addressList()
    {
        $obj_retResult = DAL_managePerson_address::getPerson_addressList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_addressList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_address::getAllPerson_address($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_address::searchPerson_addressByAddressId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_address List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>AddressId</th>";
		$html .= "<th>Address</th>";
		$html .= "<th>AddressType</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>PersonId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_addressList as $obj_Person_address)
            {               

                    $html .= $obj_Person_address->drawTableViewPerson_address(); 
                
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

	public static function deletePerson_address($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$AddressId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_AddressId =0;
			
			$retResult = BL_managePerson_address::getPerson_addressListByAddressId($AddressId);
			if($retResult->type ==1)
			{
			
			$obj_Person_address = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_address::deletePerson_address($obj_Person_address->AddressId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_AddressId = $obj_Person_address->AddressId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_address";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_address you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_address->AddressId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_addressListByAddressId($AddressId)
    {
        $obj_retResult = DAL_managePerson_address::getPerson_addressListByAddressId($AddressId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_addressListByPersonId($PersonId)
    {
        $obj_retResult = DAL_managePerson_address::getPerson_addressListByPersonId($PersonId);
        return $obj_retResult;
    }
    
    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_address($AddressId,$ChildAddressId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_address::getPerson_addressListByAddressId($ChildAddressId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_addressList = $obj_retResult->data;
				$obj_Person_address = $arr_Person_addressList[0];
				
				$arrParentIds = explode(",",$obj_Person_address->Url);
				
				foreach($arrParentIds as $Person_addressParentId)
				{
					if($Person_addressParentId == $AddressId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>