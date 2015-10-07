<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Geographytype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageGeographytype.php");


class BL_manageGeographytype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageGeographytype::addGeographytype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageGeographytype::deleteGeographytype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageGeographytype::updateGeographytype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addGeographytype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newGeographytype = new Geographytype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newGeographytype->GeogrophyTypeId = $packet[1];
		$obj_newGeographytype->Name = $packet[2];
		$obj_newGeographytype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Geographytype = DAL_manageGeographytype::addGeographytype($obj_newGeographytype);
            if ($obj_retResult_Geographytype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Geographytype->data->wsGetGeographytypeData();
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

    public static function addGeographytype2($GeogrophyTypeId,$Name,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newGeographytype = new Geographytype();
		
		$obj_newuser->setGeographytype($GeogrophyTypeId,$Name,$Description);
       // $isExist = BL_manageGeographytype::isExist($obj_newGeographytype->id);

        if (!$isExist)
        {
            $obj_retResult_Geographytype = DAL_manageGeographytype::addGeographytype($obj_newGeographytype);
            if ($obj_retResult_Geographytype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Geographytype->data;
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
            $obj_retResult->msg = "Sorry! Geographytype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGeographytype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Geographytype = new Geographytype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Geographytype->GeogrophyTypeId = $packet[0];
		$obj_Geographytype->Name = $packet[1];
		$obj_Geographytype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Geographytype = DAL_manageGeographytype::update($obj_Geographytype);

        if ($obj_retResult_Geographytype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Geographytype updation is Success";
			$retrunUserpacket = $obj_retResult_Geographytype->data->wsGetGeographytypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Geographytype updation is Failed";
			$result_Geographytype = DAL_manageGeographytype::getGeographytypeByGeogrophyTypeId($obj_Geographytype->GeogrophyTypeId);
			if($result_Geographytype->type ==1)
			{
			$retrunUserpacket = $result_Geographytype->data->wsGetGeographytypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateGeographytype2($GeogrophyTypeId,$Name,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newGeographytype = new Geographytype();
	
		$obj_newGeographytype->GeogrophyTypeId=$GeogrophyTypeId;
		$obj_newGeographytype->Name=$Name;
		$obj_newGeographytype->Description=$Description;

	   
        $issuccess = DAL_manageGeographytype::updateGeographytype($obj_newGeographytype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageGeographytype::getGeographytypeByGeogrophyTypeId($obj_newGeographytype->GeogrophyTypeId);
            $obj_retResult->msg = "Geographytype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Geographytype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getGeographytypeList()
    {
        $obj_retResult = DAL_manageGeographytype::getGeographytypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getGeographytypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageGeographytype::getAllGeographytype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageGeographytype::searchGeographytypeByGeogrophyTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Geographytype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>GeogrophyTypeId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_GeographytypeList as $obj_Geographytype)
            {               

                    $html .= $obj_Geographytype->drawTableViewGeographytype(); 
                
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

	public static function deleteGeographytype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$GeogrophyTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_GeogrophyTypeId =0;
			
			$retResult = BL_manageGeographytype::getGeographytypeListByGeogrophyTypeId($GeogrophyTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Geographytype = $retResult->data[0];			
			$obj_result2 = DAL_manageGeographytype::deleteGeographytype($obj_Geographytype->GeogrophyTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_GeogrophyTypeId = $obj_Geographytype->GeogrophyTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Geographytype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Geographytype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Geographytype->GeogrophyTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getGeographytypeListByGeogrophyTypeId($GeogrophyTypeId)
    {
        $obj_retResult = DAL_manageGeographytype::getGeographytypeListByGeogrophyTypeId($GeogrophyTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildGeographytype($GeogrophyTypeId,$ChildGeogrophyTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageGeographytype::getGeographytypeListByGeogrophyTypeId($ChildGeogrophyTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_GeographytypeList = $obj_retResult->data;
				$obj_Geographytype = $arr_GeographytypeList[0];
				
				$arrParentIds = explode(",",$obj_Geographytype->Url);
				
				foreach($arrParentIds as $GeographytypeParentId)
				{
					if($GeographytypeParentId == $GeogrophyTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>