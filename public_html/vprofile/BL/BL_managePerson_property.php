<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_property.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_property.php");


class BL_managePerson_property
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_property::addPerson_property($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_property::deletePerson_property($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_property::updatePerson_property($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_property($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_property = new Person_property();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_property->PropertyId = $packet[1];
		$obj_newPerson_property->PropertyName = $packet[2];
		$obj_newPerson_property->PropertyType = $packet[3];
		$obj_newPerson_property->AssessValue = $packet[4];
		$obj_newPerson_property->Description = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_property = DAL_managePerson_property::addPerson_property($obj_newPerson_property);
            if ($obj_retResult_Person_property->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_property->data->wsGetPerson_propertyData();
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

    public static function addPerson_property2($PropertyId,$PropertyName,$PropertyType,$AssessValue,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_property = new Person_property();
		
		$obj_newuser->setPerson_property($PropertyId,$PropertyName,$PropertyType,$AssessValue,$Description);
       // $isExist = BL_managePerson_property::isExist($obj_newPerson_property->id);

        if (!$isExist)
        {
            $obj_retResult_Person_property = DAL_managePerson_property::addPerson_property($obj_newPerson_property);
            if ($obj_retResult_Person_property->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_property->data;
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
            $obj_retResult->msg = "Sorry! Person_property already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_property($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_property = new Person_property();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_property->PropertyId = $packet[0];
		$obj_Person_property->PropertyName = $packet[1];
		$obj_Person_property->PropertyType = $packet[2];
		$obj_Person_property->AssessValue = $packet[3];
		$obj_Person_property->Description = $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_property = DAL_managePerson_property::update($obj_Person_property);

        if ($obj_retResult_Person_property->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_property updation is Success";
			$retrunUserpacket = $obj_retResult_Person_property->data->wsGetPerson_propertyData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_property updation is Failed";
			$result_Person_property = DAL_managePerson_property::getPerson_propertyByPropertyId($obj_Person_property->PropertyId);
			if($result_Person_property->type ==1)
			{
			$retrunUserpacket = $result_Person_property->data->wsGetPerson_propertyData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_property2($PropertyId,$PropertyName,$PropertyType,$AssessValue,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_property = new Person_property();
	
		$obj_newPerson_property->PropertyId=$PropertyId;
		$obj_newPerson_property->PropertyName=$PropertyName;
		$obj_newPerson_property->PropertyType=$PropertyType;
		$obj_newPerson_property->AssessValue=$AssessValue;
		$obj_newPerson_property->Description=$Description;

	   
        $issuccess = DAL_managePerson_property::updatePerson_property($obj_newPerson_property);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_property::getPerson_propertyByPropertyId($obj_newPerson_property->PropertyId);
            $obj_retResult->msg = "Person_property updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_property updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_propertyList()
    {
        $obj_retResult = DAL_managePerson_property::getPerson_propertyList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_propertyList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_property::getAllPerson_property($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_property::searchPerson_propertyByPropertyId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_property List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>PropertyId</th>";
		$html .= "<th>PropertyName</th>";
		$html .= "<th>PropertyType</th>";
		$html .= "<th>AssessValue</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_propertyList as $obj_Person_property)
            {               

                    $html .= $obj_Person_property->drawTableViewPerson_property(); 
                
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

	public static function deletePerson_property($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$PropertyId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_PropertyId =0;
			
			$retResult = BL_managePerson_property::getPerson_propertyListByPropertyId($PropertyId);
			if($retResult->type ==1)
			{
			
			$obj_Person_property = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_property::deletePerson_property($obj_Person_property->PropertyId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_PropertyId = $obj_Person_property->PropertyId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_property";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_property you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_property->PropertyId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_propertyListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_property::getPerson_propertyListByPersonId($personId);
        return $obj_retResult;
    }
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_propertyListByPropertyId($PropertyId)
    {
        $obj_retResult = DAL_managePerson_property::getPerson_propertyListByPropertyId($PropertyId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_property($PropertyId,$ChildPropertyId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_property::getPerson_propertyListByPropertyId($ChildPropertyId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_propertyList = $obj_retResult->data;
				$obj_Person_property = $arr_Person_propertyList[0];
				
				$arrParentIds = explode(",",$obj_Person_property->Url);
				
				foreach($arrParentIds as $Person_propertyParentId)
				{
					if($Person_propertyParentId == $PropertyId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>