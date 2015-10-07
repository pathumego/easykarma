<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Olsubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageOlsubjects.php");


class BL_manageOlsubjects
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageOlsubjects::addOlsubjects($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageOlsubjects::deleteOlsubjects($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageOlsubjects::updateOlsubjects($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addOlsubjects($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newOlsubjects = new Olsubjects();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newOlsubjects->SubjectId = $packet[1];
		$obj_newOlsubjects->SubjectName = $packet[2];
		$obj_newOlsubjects->SubjectNumber = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Olsubjects = DAL_manageOlsubjects::addOlsubjects($obj_newOlsubjects);
            if ($obj_retResult_Olsubjects->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Olsubjects->data->wsGetOlsubjectsData();
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

    public static function addOlsubjects2($SubjectId,$SubjectName,$SubjectNumber)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newOlsubjects = new Olsubjects();
		
		$obj_newuser->setOlsubjects($SubjectId,$SubjectName,$SubjectNumber);
       // $isExist = BL_manageOlsubjects::isExist($obj_newOlsubjects->id);

        if (!$isExist)
        {
            $obj_retResult_Olsubjects = DAL_manageOlsubjects::addOlsubjects($obj_newOlsubjects);
            if ($obj_retResult_Olsubjects->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Olsubjects->data;
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
            $obj_retResult->msg = "Sorry! Olsubjects already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOlsubjects($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Olsubjects = new Olsubjects();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Olsubjects->SubjectId = $packet[0];
		$obj_Olsubjects->SubjectName = $packet[1];
		$obj_Olsubjects->SubjectNumber = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Olsubjects = DAL_manageOlsubjects::update($obj_Olsubjects);

        if ($obj_retResult_Olsubjects->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Olsubjects updation is Success";
			$retrunUserpacket = $obj_retResult_Olsubjects->data->wsGetOlsubjectsData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Olsubjects updation is Failed";
			$result_Olsubjects = DAL_manageOlsubjects::getOlsubjectsBySubjectId($obj_Olsubjects->SubjectId);
			if($result_Olsubjects->type ==1)
			{
			$retrunUserpacket = $result_Olsubjects->data->wsGetOlsubjectsData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateOlsubjects2($SubjectId,$SubjectName,$SubjectNumber)
    {
        $obj_retResult = new returnResult();
        $obj_newOlsubjects = new Olsubjects();
	
		$obj_newOlsubjects->SubjectId=$SubjectId;
		$obj_newOlsubjects->SubjectName=$SubjectName;
		$obj_newOlsubjects->SubjectNumber=$SubjectNumber;

	   
        $issuccess = DAL_manageOlsubjects::updateOlsubjects($obj_newOlsubjects);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageOlsubjects::getOlsubjectsBySubjectId($obj_newOlsubjects->SubjectId);
            $obj_retResult->msg = "Olsubjects updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Olsubjects updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getOlsubjectsList()
    {
        $obj_retResult = DAL_manageOlsubjects::getOlsubjectsList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getOlsubjectsList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageOlsubjects::getAllOlsubjects($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageOlsubjects::searchOlsubjectsBySubjectId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Olsubjects List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>SubjectId</th>";
		$html .= "<th>SubjectName</th>";
		$html .= "<th>SubjectNumber</th>";

		$html .= "</tr>";
		
            foreach ($arr_OlsubjectsList as $obj_Olsubjects)
            {               

                    $html .= $obj_Olsubjects->drawTableViewOlsubjects(); 
                
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

	public static function deleteOlsubjects($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$SubjectId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_SubjectId =0;
			
			$retResult = BL_manageOlsubjects::getOlsubjectsListBySubjectId($SubjectId);
			if($retResult->type ==1)
			{
			
			$obj_Olsubjects = $retResult->data[0];			
			$obj_result2 = DAL_manageOlsubjects::deleteOlsubjects($obj_Olsubjects->SubjectId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_SubjectId = $obj_Olsubjects->SubjectId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Olsubjects";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Olsubjects you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Olsubjects->SubjectId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getOlsubjectsListBySubjectId($SubjectId)
    {
        $obj_retResult = DAL_manageOlsubjects::getOlsubjectsListBySubjectId($SubjectId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildOlsubjects($SubjectId,$ChildSubjectId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageOlsubjects::getOlsubjectsListBySubjectId($ChildSubjectId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_OlsubjectsList = $obj_retResult->data;
				$obj_Olsubjects = $arr_OlsubjectsList[0];
				
				$arrParentIds = explode(",",$obj_Olsubjects->Url);
				
				foreach($arrParentIds as $OlsubjectsParentId)
				{
					if($OlsubjectsParentId == $SubjectId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>