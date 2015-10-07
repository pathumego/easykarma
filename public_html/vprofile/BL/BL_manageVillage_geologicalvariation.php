<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Village_geologicalvariation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageVillage_geologicalvariation.php");


class BL_manageVillage_geologicalvariation
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageVillage_geologicalvariation::addVillage_geologicalvariation($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageVillage_geologicalvariation::deleteVillage_geologicalvariation($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageVillage_geologicalvariation::updateVillage_geologicalvariation($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addVillage_geologicalvariation($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newVillage_geologicalvariation = new Village_geologicalvariation();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newVillage_geologicalvariation->TblId = $packet[1];
		$obj_newVillage_geologicalvariation->VillageId = $packet[2];
		$obj_newVillage_geologicalvariation->Variation = $packet[3];
		$obj_newVillage_geologicalvariation->Description = $packet[4];
		$obj_newVillage_geologicalvariation->PrimaryGeoLayerTypeId = $packet[5];
		$obj_newVillage_geologicalvariation->SoilTypeId = $packet[6];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Village_geologicalvariation = DAL_manageVillage_geologicalvariation::addVillage_geologicalvariation($obj_newVillage_geologicalvariation);
            if ($obj_retResult_Village_geologicalvariation->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Village_geologicalvariation->data->wsGetVillage_geologicalvariationData();
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

    public static function addVillage_geologicalvariation2($TblId,$VillageId,$Variation,$Description,$PrimaryGeoLayerTypeId,$SoilTypeId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newVillage_geologicalvariation = new Village_geologicalvariation();
		
		$obj_newuser->setVillage_geologicalvariation($TblId,$VillageId,$Variation,$Description,$PrimaryGeoLayerTypeId,$SoilTypeId);
       // $isExist = BL_manageVillage_geologicalvariation::isExist($obj_newVillage_geologicalvariation->id);

        if (!$isExist)
        {
            $obj_retResult_Village_geologicalvariation = DAL_manageVillage_geologicalvariation::addVillage_geologicalvariation($obj_newVillage_geologicalvariation);
            if ($obj_retResult_Village_geologicalvariation->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Village_geologicalvariation->data;
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
            $obj_retResult->msg = "Sorry! Village_geologicalvariation already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_geologicalvariation($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Village_geologicalvariation = new Village_geologicalvariation();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Village_geologicalvariation->TblId = $packet[0];
		$obj_Village_geologicalvariation->VillageId = $packet[1];
		$obj_Village_geologicalvariation->Variation = $packet[2];
		$obj_Village_geologicalvariation->Description = $packet[3];
		$obj_Village_geologicalvariation->PrimaryGeoLayerTypeId = $packet[4];
		$obj_Village_geologicalvariation->SoilTypeId = $packet[5];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Village_geologicalvariation = DAL_manageVillage_geologicalvariation::update($obj_Village_geologicalvariation);

        if ($obj_retResult_Village_geologicalvariation->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Village_geologicalvariation updation is Success";
			$retrunUserpacket = $obj_retResult_Village_geologicalvariation->data->wsGetVillage_geologicalvariationData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_geologicalvariation updation is Failed";
			$result_Village_geologicalvariation = DAL_manageVillage_geologicalvariation::getVillage_geologicalvariationByTblId($obj_Village_geologicalvariation->TblId);
			if($result_Village_geologicalvariation->type ==1)
			{
			$retrunUserpacket = $result_Village_geologicalvariation->data->wsGetVillage_geologicalvariationData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateVillage_geologicalvariation2($TblId,$VillageId,$Variation,$Description,$PrimaryGeoLayerTypeId,$SoilTypeId)
    {
        $obj_retResult = new returnResult();
        $obj_newVillage_geologicalvariation = new Village_geologicalvariation();
	
		$obj_newVillage_geologicalvariation->TblId=$TblId;
		$obj_newVillage_geologicalvariation->VillageId=$VillageId;
		$obj_newVillage_geologicalvariation->Variation=$Variation;
		$obj_newVillage_geologicalvariation->Description=$Description;
		$obj_newVillage_geologicalvariation->PrimaryGeoLayerTypeId=$PrimaryGeoLayerTypeId;
		$obj_newVillage_geologicalvariation->SoilTypeId=$SoilTypeId;

	   
        $issuccess = DAL_manageVillage_geologicalvariation::updateVillage_geologicalvariation($obj_newVillage_geologicalvariation);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageVillage_geologicalvariation::getVillage_geologicalvariationByTblId($obj_newVillage_geologicalvariation->TblId);
            $obj_retResult->msg = "Village_geologicalvariation updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Village_geologicalvariation updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getVillage_geologicalvariationList()
    {
        $obj_retResult = DAL_manageVillage_geologicalvariation::getVillage_geologicalvariationList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getVillage_geologicalvariationList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageVillage_geologicalvariation::getAllVillage_geologicalvariation($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageVillage_geologicalvariation::searchVillage_geologicalvariationByTblId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Village_geologicalvariation List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TblId</th>";
		$html .= "<th>VillageId</th>";
		$html .= "<th>Variation</th>";
		$html .= "<th>Description</th>";
		$html .= "<th>PrimaryGeoLayerTypeId</th>";
		$html .= "<th>SoilTypeId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Village_geologicalvariationList as $obj_Village_geologicalvariation)
            {               

                    $html .= $obj_Village_geologicalvariation->drawTableViewVillage_geologicalvariation(); 
                
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

	public static function deleteVillage_geologicalvariation($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TblId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TblId =0;
			
			$retResult = BL_manageVillage_geologicalvariation::getVillage_geologicalvariationListByTblId($TblId);
			if($retResult->type ==1)
			{
			
			$obj_Village_geologicalvariation = $retResult->data[0];			
			$obj_result2 = DAL_manageVillage_geologicalvariation::deleteVillage_geologicalvariation($obj_Village_geologicalvariation->TblId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TblId = $obj_Village_geologicalvariation->TblId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Village_geologicalvariation";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Village_geologicalvariation you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Village_geologicalvariation->TblId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getVillage_geologicalvariationListByTblId($TblId)
    {
        $obj_retResult = DAL_manageVillage_geologicalvariation::getVillage_geologicalvariationListByTblId($TblId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildVillage_geologicalvariation($TblId,$ChildTblId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageVillage_geologicalvariation::getVillage_geologicalvariationListByTblId($ChildTblId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Village_geologicalvariationList = $obj_retResult->data;
				$obj_Village_geologicalvariation = $arr_Village_geologicalvariationList[0];
				
				$arrParentIds = explode(",",$obj_Village_geologicalvariation->Url);
				
				foreach($arrParentIds as $Village_geologicalvariationParentId)
				{
					if($Village_geologicalvariationParentId == $TblId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>