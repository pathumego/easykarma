<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Foresttype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageForesttype.php");


class BL_manageForesttype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageForesttype::addForesttype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageForesttype::deleteForesttype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageForesttype::updateForesttype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addForesttype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newForesttype = new Foresttype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newForesttype->ForestTypeId = $packet[1];
		$obj_newForesttype->Name = $packet[2];
		$obj_newForesttype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Foresttype = DAL_manageForesttype::addForesttype($obj_newForesttype);
            if ($obj_retResult_Foresttype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Foresttype->data->wsGetForesttypeData();
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

    public static function addForesttype2($ForestTypeId,$Name,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newForesttype = new Foresttype();
		
		$obj_newuser->setForesttype($ForestTypeId,$Name,$Description);
       // $isExist = BL_manageForesttype::isExist($obj_newForesttype->id);

        if (!$isExist)
        {
            $obj_retResult_Foresttype = DAL_manageForesttype::addForesttype($obj_newForesttype);
            if ($obj_retResult_Foresttype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Foresttype->data;
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
            $obj_retResult->msg = "Sorry! Foresttype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateForesttype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Foresttype = new Foresttype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Foresttype->ForestTypeId = $packet[0];
		$obj_Foresttype->Name = $packet[1];
		$obj_Foresttype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Foresttype = DAL_manageForesttype::update($obj_Foresttype);

        if ($obj_retResult_Foresttype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Foresttype updation is Success";
			$retrunUserpacket = $obj_retResult_Foresttype->data->wsGetForesttypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Foresttype updation is Failed";
			$result_Foresttype = DAL_manageForesttype::getForesttypeByForestTypeId($obj_Foresttype->ForestTypeId);
			if($result_Foresttype->type ==1)
			{
			$retrunUserpacket = $result_Foresttype->data->wsGetForesttypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateForesttype2($ForestTypeId,$Name,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newForesttype = new Foresttype();
	
		$obj_newForesttype->ForestTypeId=$ForestTypeId;
		$obj_newForesttype->Name=$Name;
		$obj_newForesttype->Description=$Description;

	   
        $issuccess = DAL_manageForesttype::updateForesttype($obj_newForesttype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageForesttype::getForesttypeByForestTypeId($obj_newForesttype->ForestTypeId);
            $obj_retResult->msg = "Foresttype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Foresttype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getForesttypeList()
    {
        $obj_retResult = DAL_manageForesttype::getForesttypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getForesttypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageForesttype::getAllForesttype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageForesttype::searchForesttypeByForestTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Foresttype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ForestTypeId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_ForesttypeList as $obj_Foresttype)
            {               

                    $html .= $obj_Foresttype->drawTableViewForesttype(); 
                
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

	public static function deleteForesttype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ForestTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ForestTypeId =0;
			
			$retResult = BL_manageForesttype::getForesttypeListByForestTypeId($ForestTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Foresttype = $retResult->data[0];			
			$obj_result2 = DAL_manageForesttype::deleteForesttype($obj_Foresttype->ForestTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ForestTypeId = $obj_Foresttype->ForestTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Foresttype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Foresttype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Foresttype->ForestTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getForesttypeListByForestTypeId($ForestTypeId)
    {
        $obj_retResult = DAL_manageForesttype::getForesttypeListByForestTypeId($ForestTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildForesttype($ForestTypeId,$ChildForestTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageForesttype::getForesttypeListByForestTypeId($ChildForestTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_ForesttypeList = $obj_retResult->data;
				$obj_Foresttype = $arr_ForesttypeList[0];
				
				$arrParentIds = explode(",",$obj_Foresttype->Url);
				
				foreach($arrParentIds as $ForesttypeParentId)
				{
					if($ForesttypeParentId == $ForestTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>