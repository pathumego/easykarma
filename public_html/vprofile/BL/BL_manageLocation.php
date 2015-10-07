<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Location.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageLocation.php");


class BL_manageLocation
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageLocation::addLocation($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageLocation::deleteLocation($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageLocation::updateLocation($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addLocation($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newLocation = new Location();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newLocation->LocationId = $packet[1];
		$obj_newLocation->Name = $packet[2];
		$obj_newLocation->LocationType = $packet[3];
		$obj_newLocation->Description = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Location = DAL_manageLocation::addLocation($obj_newLocation);
            if ($obj_retResult_Location->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Location->data->wsGetLocationData();
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

    public static function addLocation2($LocationId,$Name,$LocationType,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newLocation = new Location();
		
		$obj_newuser->setLocation($LocationId,$Name,$LocationType,$Description);
       // $isExist = BL_manageLocation::isExist($obj_newLocation->id);

        if (!$isExist)
        {
            $obj_retResult_Location = DAL_manageLocation::addLocation($obj_newLocation);
            if ($obj_retResult_Location->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Location->data;
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
            $obj_retResult->msg = "Sorry! Location already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateLocation($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Location = new Location();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Location->LocationId = $packet[0];
		$obj_Location->Name = $packet[1];
		$obj_Location->LocationType = $packet[2];
		$obj_Location->Description = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Location = DAL_manageLocation::update($obj_Location);

        if ($obj_retResult_Location->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Location updation is Success";
			$retrunUserpacket = $obj_retResult_Location->data->wsGetLocationData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Location updation is Failed";
			$result_Location = DAL_manageLocation::getLocationByLocationId($obj_Location->LocationId);
			if($result_Location->type ==1)
			{
			$retrunUserpacket = $result_Location->data->wsGetLocationData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateLocation2($LocationId,$Name,$LocationType,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newLocation = new Location();
	
		$obj_newLocation->LocationId=$LocationId;
		$obj_newLocation->Name=$Name;
		$obj_newLocation->LocationType=$LocationType;
		$obj_newLocation->Description=$Description;

	   
        $issuccess = DAL_manageLocation::updateLocation($obj_newLocation);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageLocation::getLocationByLocationId($obj_newLocation->LocationId);
            $obj_retResult->msg = "Location updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Location updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getLocationList()
    {
        $obj_retResult = DAL_manageLocation::getLocationList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getLocationList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageLocation::getAllLocation($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageLocation::searchLocationByLocationId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Location List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>LocationId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>LocationType</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_LocationList as $obj_Location)
            {               

                    $html .= $obj_Location->drawTableViewLocation(); 
                
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

	public static function deleteLocation($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$LocationId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_LocationId =0;
			
			$retResult = BL_manageLocation::getLocationListByLocationId($LocationId);
			if($retResult->type ==1)
			{
			
			$obj_Location = $retResult->data[0];			
			$obj_result2 = DAL_manageLocation::deleteLocation($obj_Location->LocationId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_LocationId = $obj_Location->LocationId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Location";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Location you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Location->LocationId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getLocationListByLocationId($LocationId)
    {
        $obj_retResult = DAL_manageLocation::getLocationListByLocationId($LocationId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildLocation($LocationId,$ChildLocationId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageLocation::getLocationListByLocationId($ChildLocationId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_LocationList = $obj_retResult->data;
				$obj_Location = $arr_LocationList[0];
				
				$arrParentIds = explode(",",$obj_Location->Url);
				
				foreach($arrParentIds as $LocationParentId)
				{
					if($LocationParentId == $LocationId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>