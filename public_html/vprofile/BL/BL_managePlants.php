<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Plants.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePlants.php");


class BL_managePlants
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePlants::addPlants($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePlants::deletePlants($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePlants::updatePlants($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPlants($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPlants = new Plants();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPlants->PlantId = $packet[1];
		$obj_newPlants->Name = $packet[2];
		$obj_newPlants->Description = $packet[3];
		$obj_newPlants->BioName = $packet[4];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Plants = DAL_managePlants::addPlants($obj_newPlants);
            if ($obj_retResult_Plants->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Plants->data->wsGetPlantsData();
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

    public static function addPlants2($PlantId,$Name,$Description,$BioName)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPlants = new Plants();
		
		$obj_newuser->setPlants($PlantId,$Name,$Description,$BioName);
       // $isExist = BL_managePlants::isExist($obj_newPlants->id);

        if (!$isExist)
        {
            $obj_retResult_Plants = DAL_managePlants::addPlants($obj_newPlants);
            if ($obj_retResult_Plants->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Plants->data;
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
            $obj_retResult->msg = "Sorry! Plants already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePlants($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Plants = new Plants();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Plants->PlantId = $packet[0];
		$obj_Plants->Name = $packet[1];
		$obj_Plants->Description = $packet[2];
		$obj_Plants->BioName = $packet[3];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Plants = DAL_managePlants::update($obj_Plants);

        if ($obj_retResult_Plants->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Plants updation is Success";
			$retrunUserpacket = $obj_retResult_Plants->data->wsGetPlantsData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Plants updation is Failed";
			$result_Plants = DAL_managePlants::getPlantsByPlantId($obj_Plants->PlantId);
			if($result_Plants->type ==1)
			{
			$retrunUserpacket = $result_Plants->data->wsGetPlantsData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePlants2($PlantId,$Name,$Description,$BioName)
    {
        $obj_retResult = new returnResult();
        $obj_newPlants = new Plants();
	
		$obj_newPlants->PlantId=$PlantId;
		$obj_newPlants->Name=$Name;
		$obj_newPlants->Description=$Description;
		$obj_newPlants->BioName=$BioName;

	   
        $issuccess = DAL_managePlants::updatePlants($obj_newPlants);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePlants::getPlantsByPlantId($obj_newPlants->PlantId);
            $obj_retResult->msg = "Plants updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Plants updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPlantsList()
    {
        $obj_retResult = DAL_managePlants::getPlantsList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPlantsList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePlants::getAllPlants($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePlants::searchPlantsByPlantId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Plants List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>PlantId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>Description</th>";
		$html .= "<th>BioName</th>";

		$html .= "</tr>";
		
            foreach ($arr_PlantsList as $obj_Plants)
            {               

                    $html .= $obj_Plants->drawTableViewPlants(); 
                
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

	public static function deletePlants($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$PlantId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_PlantId =0;
			
			$retResult = BL_managePlants::getPlantsListByPlantId($PlantId);
			if($retResult->type ==1)
			{
			
			$obj_Plants = $retResult->data[0];			
			$obj_result2 = DAL_managePlants::deletePlants($obj_Plants->PlantId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_PlantId = $obj_Plants->PlantId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Plants";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Plants you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Plants->PlantId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getPlantsListByPlantId($PlantId)
    {
        $obj_retResult = DAL_managePlants::getPlantsListByPlantId($PlantId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPlants($PlantId,$ChildPlantId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePlants::getPlantsListByPlantId($ChildPlantId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_PlantsList = $obj_retResult->data;
				$obj_Plants = $arr_PlantsList[0];
				
				$arrParentIds = explode(",",$obj_Plants->Url);
				
				foreach($arrParentIds as $PlantsParentId)
				{
					if($PlantsParentId == $PlantId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>