<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_climate.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_climate.php");


class BL_manageVillage_climate
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_climate::addVillage_climate($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_climate::deleteVillage_climate($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_climate::updateVillage_climate($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_climate($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_climate = new Village_climate();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_climate->ClimateId = $packet[1];
		$obj_newVillage_climate->VillageId = $packet[2];
		$obj_newVillage_climate->ClimateReagion = $packet[3];
		$obj_newVillage_climate->RainFall = $packet[4];
		$obj_newVillage_climate->Temparature = $packet[5];
		$obj_newVillage_climate->Humidity = $packet[6];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_climate = DAL_manageVillage_climate::addVillage_climate($obj_newVillage_climate);
            if ($obj_retResult_Village_climate->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_climate->data->wsGetVillage_climateData();
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

    public static function addVillage_climate2($ClimateId,$VillageId,$ClimateReagion,$RainFall,$Temparature,$Humidity)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_climate = new Village_climate();
		
		$obj_newuser->setVillage_climate($ClimateId,$VillageId,$ClimateReagion,$RainFall,$Temparature,$Humidity);
       // $isExist = BL_manageVillage_climate::isExist($obj_newVillage_climate->id);

        if (!$isExist)
        {
            $obj_retResult_Village_climate = DAL_manageVillage_climate::addVillage_climate($obj_newVillage_climate);
            if ($obj_retResult_Village_climate->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_climate->data;
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
            $obj_retResult->msg = "Sorry! Village_climate already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_climate($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_climate = new Village_climate();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_climate->ClimateId = $packet[0];
		$obj_Village_climate->VillageId = $packet[1];
		$obj_Village_climate->ClimateReagion = $packet[2];
		$obj_Village_climate->RainFall = $packet[3];
		$obj_Village_climate->Temparature = $packet[4];
		$obj_Village_climate->Humidity = $packet[5];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_climate = DAL_manageVillage_climate::update($obj_Village_climate);

        if ($obj_retResult_Village_climate->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_climate updation is Success";
			$retrunUserpacket = $obj_retResult_Village_climate->data->wsGetVillage_climateData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_climate updation is Failed";
			$result_Village_climate = DAL_manageVillage_climate::getVillage_climateByClimateId($obj_Village_climate->ClimateId);
			if($result_Village_climate->type ==1)
			{
			$retrunUserpacket = $result_Village_climate->data->wsGetVillage_climateData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_climate2($ClimateId,$VillageId,$ClimateReagion,$RainFall,$Temparature,$Humidity)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_climate = new Village_climate();
	
		$obj_newVillage_climate->ClimateId=$ClimateId;
		$obj_newVillage_climate->VillageId=$VillageId;
		$obj_newVillage_climate->ClimateReagion=$ClimateReagion;
		$obj_newVillage_climate->RainFall=$RainFall;
		$obj_newVillage_climate->Temparature=$Temparature;
		$obj_newVillage_climate->Humidity=$Humidity;

	   
        $issuccess = DAL_manageVillage_climate::updateVillage_climate($obj_newVillage_climate);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_climate::getVillage_climateByClimateId($obj_newVillage_climate->ClimateId);
            $obj_retResult->msg = "Village_climate updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_climate updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_climateList()
    {
        $obj_retResult = DAL_manageVillage_climate::getVillage_climateList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_climateList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_climate::getAllVillage_climate($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_climate::searchVillage_climateByClimateId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_climate List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ClimateId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>ClimateReagion</th>";
		$html .= "<th>RainFall</th>";
		$html .= "<th>Temparature</th>";
		$html .= "<th>Humidity</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_climateList as $obj_Village_climate)
            {               

                    $html .= $obj_Village_climate->drawTableViewVillage_climate(); 
                
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

	public static function deleteVillage_climate($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ClimateId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ClimateId =0;
			
			$retResult = BL_manageVillage_climate::getVillage_climateListByClimateId($ClimateId);
			if($retResult->type ==1)
			{
			
			$obj_Village_climate = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_climate::deleteVillage_climate($obj_Village_climate->ClimateId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ClimateId = $obj_Village_climate->ClimateId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_climate";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_climate you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_climate->ClimateId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_climateListByClimateId($ClimateId)
    {
        $obj_retResult = DAL_manageVillage_climate::getVillage_climateListByClimateId($ClimateId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_climate($ClimateId,$ChildClimateId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_climate::getVillage_climateListByClimateId($ChildClimateId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_climateList = $obj_retResult->data;
				$obj_Village_climate = $arr_Village_climateList[0];
				
				$arrParentIds = explode(",",$obj_Village_climate->Url);
				
				foreach($arrParentIds as $Village_climateParentId)
				{
					if($Village_climateParentId == $ClimateId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>