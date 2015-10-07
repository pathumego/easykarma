<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Alsubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageAlsubjects.php");


class BL_manageAlsubjects
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageAlsubjects::addAlsubjects($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageAlsubjects::deleteAlsubjects($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageAlsubjects::updateAlsubjects($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addAlsubjects($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newAlsubjects = new Alsubjects();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newAlsubjects->SubjectId = $packet[1];
		$obj_newAlsubjects->SubjectName = $packet[2];
		$obj_newAlsubjects->SubjectNumber = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Alsubjects = DAL_manageAlsubjects::addAlsubjects($obj_newAlsubjects);
            if ($obj_retResult_Alsubjects->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Alsubjects->data->wsGetAlsubjectsData();
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

    public static function addAlsubjects2($SubjectId,$SubjectName,$SubjectNumber)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newAlsubjects = new Alsubjects();
		
		$obj_newuser->setAlsubjects($SubjectId,$SubjectName,$SubjectNumber);
       // $isExist = BL_manageAlsubjects::isExist($obj_newAlsubjects->id);

        if (!$isExist)
        {
            $obj_retResult_Alsubjects = DAL_manageAlsubjects::addAlsubjects($obj_newAlsubjects);
            if ($obj_retResult_Alsubjects->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Alsubjects->data;
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
            $obj_retResult->msg = "Sorry! Alsubjects already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateAlsubjects($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Alsubjects = new Alsubjects();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Alsubjects->SubjectId = $packet[0];
		$obj_Alsubjects->SubjectName = $packet[1];
		$obj_Alsubjects->SubjectNumber = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Alsubjects = DAL_manageAlsubjects::update($obj_Alsubjects);

        if ($obj_retResult_Alsubjects->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Alsubjects updation is Success";
			$retrunUserpacket = $obj_retResult_Alsubjects->data->wsGetAlsubjectsData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Alsubjects updation is Failed";
			$result_Alsubjects = DAL_manageAlsubjects::getAlsubjectsBySubjectId($obj_Alsubjects->SubjectId);
			if($result_Alsubjects->type ==1)
			{
			$retrunUserpacket = $result_Alsubjects->data->wsGetAlsubjectsData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateAlsubjects2($SubjectId,$SubjectName,$SubjectNumber)
    {
        $obj_retResult = new returnResult();
        $obj_newAlsubjects = new Alsubjects();
	
		$obj_newAlsubjects->SubjectId=$SubjectId;
		$obj_newAlsubjects->SubjectName=$SubjectName;
		$obj_newAlsubjects->SubjectNumber=$SubjectNumber;

	   
        $issuccess = DAL_manageAlsubjects::updateAlsubjects($obj_newAlsubjects);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageAlsubjects::getAlsubjectsBySubjectId($obj_newAlsubjects->SubjectId);
            $obj_retResult->msg = "Alsubjects updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Alsubjects updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getAlsubjectsList()
    {
        $obj_retResult = DAL_manageAlsubjects::getAlsubjectsList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getAlsubjectsList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageAlsubjects::getAllAlsubjects($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageAlsubjects::searchAlsubjectsBySubjectId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Alsubjects List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>SubjectId</th>";
		$html .= "<th>SubjectName</th>";
		$html .= "<th>SubjectNumber</th>";

		$html .= "</tr>";
		
            foreach ($arr_AlsubjectsList as $obj_Alsubjects)
            {               

                    $html .= $obj_Alsubjects->drawTableViewAlsubjects(); 
                
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

	public static function deleteAlsubjects($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$SubjectId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_SubjectId =0;
			
			$retResult = BL_manageAlsubjects::getAlsubjectsListBySubjectId($SubjectId);
			if($retResult->type ==1)
			{
			
			$obj_Alsubjects = $retResult->data[0];			
			$obj_result2 = DAL_manageAlsubjects::deleteAlsubjects($obj_Alsubjects->SubjectId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_SubjectId = $obj_Alsubjects->SubjectId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Alsubjects";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Alsubjects you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Alsubjects->SubjectId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getAlsubjectsListBySubjectId($SubjectId)
    {
        $obj_retResult = DAL_manageAlsubjects::getAlsubjectsListBySubjectId($SubjectId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildAlsubjects($SubjectId,$ChildSubjectId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageAlsubjects::getAlsubjectsListBySubjectId($ChildSubjectId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_AlsubjectsList = $obj_retResult->data;
				$obj_Alsubjects = $arr_AlsubjectsList[0];
				
				$arrParentIds = explode(",",$obj_Alsubjects->Url);
				
				foreach($arrParentIds as $AlsubjectsParentId)
				{
					if($AlsubjectsParentId == $SubjectId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>