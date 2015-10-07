<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_telephone.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_telephone.php");


class BL_managePerson_telephone
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_telephone::addPerson_telephone($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_telephone::deletePerson_telephone($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_telephone::updatePerson_telephone($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_telephone($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_telephone = new Person_telephone();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_telephone->PhoneId = $packet[1];
		$obj_newPerson_telephone->PhoneNumber = $packet[2];
		$obj_newPerson_telephone->Type = $packet[3];
		$obj_newPerson_telephone->PersonId = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_telephone = DAL_managePerson_telephone::addPerson_telephone($obj_newPerson_telephone);
            if ($obj_retResult_Person_telephone->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_telephone->data->wsGetPerson_telephoneData();
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

    public static function addPerson_telephone2($PhoneId,$PhoneNumber,$Type,$PersonId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_telephone = new Person_telephone();
		
		$obj_newuser->setPerson_telephone($PhoneId,$PhoneNumber,$Type,$PersonId);
       // $isExist = BL_managePerson_telephone::isExist($obj_newPerson_telephone->id);

        if (!$isExist)
        {
            $obj_retResult_Person_telephone = DAL_managePerson_telephone::addPerson_telephone($obj_newPerson_telephone);
            if ($obj_retResult_Person_telephone->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_telephone->data;
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
            $obj_retResult->msg = "Sorry! Person_telephone already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_telephone($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_telephone = new Person_telephone();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_telephone->PhoneId = $packet[0];
		$obj_Person_telephone->PhoneNumber = $packet[1];
		$obj_Person_telephone->Type = $packet[2];
		$obj_Person_telephone->PersonId = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_telephone = DAL_managePerson_telephone::update($obj_Person_telephone);

        if ($obj_retResult_Person_telephone->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_telephone updation is Success";
			$retrunUserpacket = $obj_retResult_Person_telephone->data->wsGetPerson_telephoneData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_telephone updation is Failed";
			$result_Person_telephone = DAL_managePerson_telephone::getPerson_telephoneByPhoneId($obj_Person_telephone->PhoneId);
			if($result_Person_telephone->type ==1)
			{
			$retrunUserpacket = $result_Person_telephone->data->wsGetPerson_telephoneData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_telephone2($PhoneId,$PhoneNumber,$Type,$PersonId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_telephone = new Person_telephone();
	
		$obj_newPerson_telephone->PhoneId=$PhoneId;
		$obj_newPerson_telephone->PhoneNumber=$PhoneNumber;
		$obj_newPerson_telephone->Type=$Type;
		$obj_newPerson_telephone->PersonId=$PersonId;

	   
        $issuccess = DAL_managePerson_telephone::updatePerson_telephone($obj_newPerson_telephone);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_telephone::getPerson_telephoneByPhoneId($obj_newPerson_telephone->PhoneId);
            $obj_retResult->msg = "Person_telephone updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_telephone updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_telephoneList()
    {
        $obj_retResult = DAL_managePerson_telephone::getPerson_telephoneList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_telephoneList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_telephone::getAllPerson_telephone($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_telephone::searchPerson_telephoneByPhoneId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_telephone List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>PhoneId</th>";
		$html .= "<th>PhoneNumber</th>";
		$html .= "<th>Type</th>";
		$html .= "<th>PersonId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_telephoneList as $obj_Person_telephone)
            {               

                    $html .= $obj_Person_telephone->drawTableViewPerson_telephone(); 
                
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

	public static function deletePerson_telephone($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$PhoneId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_PhoneId =0;
			
			$retResult = BL_managePerson_telephone::getPerson_telephoneListByPhoneId($PhoneId);
			if($retResult->type ==1)
			{
			
			$obj_Person_telephone = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_telephone::deletePerson_telephone($obj_Person_telephone->PhoneId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_PhoneId = $obj_Person_telephone->PhoneId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_telephone";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_telephone you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_telephone->PhoneId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_telephoneListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_telephone::getPerson_telephoneListByPersonId($personId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_telephoneListByPhoneId($PhoneId)
    {
        $obj_retResult = DAL_managePerson_telephone::getPerson_telephoneListByPhoneId($PhoneId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_telephone($PhoneId,$ChildPhoneId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_telephone::getPerson_telephoneListByPhoneId($ChildPhoneId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_telephoneList = $obj_retResult->data;
				$obj_Person_telephone = $arr_Person_telephoneList[0];
				
				$arrParentIds = explode(",",$obj_Person_telephone->Url);
				
				foreach($arrParentIds as $Person_telephoneParentId)
				{
					if($Person_telephoneParentId == $PhoneId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>