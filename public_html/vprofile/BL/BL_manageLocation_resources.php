<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Location_resources.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageLocation_resources.php");


class BL_manageLocation_resources
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageLocation_resources::addLocation_resources($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageLocation_resources::deleteLocation_resources($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageLocation_resources::updateLocation_resources($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addLocation_resources($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newLocation_resources = new Location_resources();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newLocation_resources->ResourceId = $packet[1];
		$obj_newLocation_resources->LocationId = $packet[2];
		$obj_newLocation_resources->ResourceType = $packet[3];
		$obj_newLocation_resources->ResourcePath = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Location_resources = DAL_manageLocation_resources::addLocation_resources($obj_newLocation_resources);
            if ($obj_retResult_Location_resources->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Location_resources->data->wsGetLocation_resourcesData();
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

    public static function addLocation_resources2($ResourceId,$LocationId,$ResourceType,$ResourcePath)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newLocation_resources = new Location_resources();
		
		$obj_newuser->setLocation_resources($ResourceId,$LocationId,$ResourceType,$ResourcePath);
       // $isExist = BL_manageLocation_resources::isExist($obj_newLocation_resources->id);

        if (!$isExist)
        {
            $obj_retResult_Location_resources = DAL_manageLocation_resources::addLocation_resources($obj_newLocation_resources);
            if ($obj_retResult_Location_resources->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Location_resources->data;
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
            $obj_retResult->msg = "Sorry! Location_resources already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateLocation_resources($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Location_resources = new Location_resources();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Location_resources->ResourceId = $packet[0];
		$obj_Location_resources->LocationId = $packet[1];
		$obj_Location_resources->ResourceType = $packet[2];
		$obj_Location_resources->ResourcePath = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Location_resources = DAL_manageLocation_resources::update($obj_Location_resources);

        if ($obj_retResult_Location_resources->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Location_resources updation is Success";
			$retrunUserpacket = $obj_retResult_Location_resources->data->wsGetLocation_resourcesData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Location_resources updation is Failed";
			$result_Location_resources = DAL_manageLocation_resources::getLocation_resourcesByResourceId($obj_Location_resources->ResourceId);
			if($result_Location_resources->type ==1)
			{
			$retrunUserpacket = $result_Location_resources->data->wsGetLocation_resourcesData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateLocation_resources2($ResourceId,$LocationId,$ResourceType,$ResourcePath)
    {
        $obj_retResult = new returnResult();
        $obj_newLocation_resources = new Location_resources();
	
		$obj_newLocation_resources->ResourceId=$ResourceId;
		$obj_newLocation_resources->LocationId=$LocationId;
		$obj_newLocation_resources->ResourceType=$ResourceType;
		$obj_newLocation_resources->ResourcePath=$ResourcePath;

	   
        $issuccess = DAL_manageLocation_resources::updateLocation_resources($obj_newLocation_resources);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageLocation_resources::getLocation_resourcesByResourceId($obj_newLocation_resources->ResourceId);
            $obj_retResult->msg = "Location_resources updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Location_resources updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getLocation_resourcesList()
    {
        $obj_retResult = DAL_manageLocation_resources::getLocation_resourcesList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getLocation_resourcesList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageLocation_resources::getAllLocation_resources($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageLocation_resources::searchLocation_resourcesByResourceId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Location_resources List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ResourceId</th>";
		$html .= "<th>LocationId</th>";
		$html .= "<th>ResourceType</th>";
		$html .= "<th>ResourcePath</th>";

		$html .= "</tr>";
		
            foreach ($arr_Location_resourcesList as $obj_Location_resources)
            {               

                    $html .= $obj_Location_resources->drawTableViewLocation_resources(); 
                
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

	public static function deleteLocation_resources($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ResourceId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ResourceId =0;
			
			$retResult = BL_manageLocation_resources::getLocation_resourcesListByResourceId($ResourceId);
			if($retResult->type ==1)
			{
			
			$obj_Location_resources = $retResult->data[0];			
			$obj_result2 = DAL_manageLocation_resources::deleteLocation_resources($obj_Location_resources->ResourceId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ResourceId = $obj_Location_resources->ResourceId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Location_resources";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Location_resources you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Location_resources->ResourceId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getLocation_resourcesListByResourceId($ResourceId)
    {
        $obj_retResult = DAL_manageLocation_resources::getLocation_resourcesListByResourceId($ResourceId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildLocation_resources($ResourceId,$ChildResourceId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageLocation_resources::getLocation_resourcesListByResourceId($ChildResourceId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Location_resourcesList = $obj_retResult->data;
				$obj_Location_resources = $arr_Location_resourcesList[0];
				
				$arrParentIds = explode(",",$obj_Location_resources->Url);
				
				foreach($arrParentIds as $Location_resourcesParentId)
				{
					if($Location_resourcesParentId == $ResourceId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>