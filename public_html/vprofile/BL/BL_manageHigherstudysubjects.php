<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Higherstudysubjects.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageHigherstudysubjects.php");


class BL_manageHigherstudysubjects
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageHigherstudysubjects::addHigherstudysubjects($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageHigherstudysubjects::deleteHigherstudysubjects($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageHigherstudysubjects::updateHigherstudysubjects($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addHigherstudysubjects($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newHigherstudysubjects = new Higherstudysubjects();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newHigherstudysubjects->SubjectId = $packet[1];
		$obj_newHigherstudysubjects->SubjectName = $packet[2];
		$obj_newHigherstudysubjects->SubjectNumber = $packet[3];
		$obj_newHigherstudysubjects->SubjectField = $packet[4];
		$obj_newHigherstudysubjects->Level = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Higherstudysubjects = DAL_manageHigherstudysubjects::addHigherstudysubjects($obj_newHigherstudysubjects);
            if ($obj_retResult_Higherstudysubjects->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Higherstudysubjects->data->wsGetHigherstudysubjectsData();
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

    public static function addHigherstudysubjects2($SubjectId,$SubjectName,$SubjectNumber,$SubjectField,$Level)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newHigherstudysubjects = new Higherstudysubjects();
		
		$obj_newuser->setHigherstudysubjects($SubjectId,$SubjectName,$SubjectNumber,$SubjectField,$Level);
       // $isExist = BL_manageHigherstudysubjects::isExist($obj_newHigherstudysubjects->id);

        if (!$isExist)
        {
            $obj_retResult_Higherstudysubjects = DAL_manageHigherstudysubjects::addHigherstudysubjects($obj_newHigherstudysubjects);
            if ($obj_retResult_Higherstudysubjects->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Higherstudysubjects->data;
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
            $obj_retResult->msg = "Sorry! Higherstudysubjects already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateHigherstudysubjects($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Higherstudysubjects = new Higherstudysubjects();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Higherstudysubjects->SubjectId = $packet[0];
		$obj_Higherstudysubjects->SubjectName = $packet[1];
		$obj_Higherstudysubjects->SubjectNumber = $packet[2];
		$obj_Higherstudysubjects->SubjectField = $packet[3];
		$obj_Higherstudysubjects->Level = $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Higherstudysubjects = DAL_manageHigherstudysubjects::update($obj_Higherstudysubjects);

        if ($obj_retResult_Higherstudysubjects->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Higherstudysubjects updation is Success";
			$retrunUserpacket = $obj_retResult_Higherstudysubjects->data->wsGetHigherstudysubjectsData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Higherstudysubjects updation is Failed";
			$result_Higherstudysubjects = DAL_manageHigherstudysubjects::getHigherstudysubjectsBySubjectId($obj_Higherstudysubjects->SubjectId);
			if($result_Higherstudysubjects->type ==1)
			{
			$retrunUserpacket = $result_Higherstudysubjects->data->wsGetHigherstudysubjectsData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateHigherstudysubjects2($SubjectId,$SubjectName,$SubjectNumber,$SubjectField,$Level)
    {
        $obj_retResult = new returnResult();
        $obj_newHigherstudysubjects = new Higherstudysubjects();
	
		$obj_newHigherstudysubjects->SubjectId=$SubjectId;
		$obj_newHigherstudysubjects->SubjectName=$SubjectName;
		$obj_newHigherstudysubjects->SubjectNumber=$SubjectNumber;
		$obj_newHigherstudysubjects->SubjectField=$SubjectField;
		$obj_newHigherstudysubjects->Level=$Level;

	   
        $issuccess = DAL_manageHigherstudysubjects::updateHigherstudysubjects($obj_newHigherstudysubjects);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageHigherstudysubjects::getHigherstudysubjectsBySubjectId($obj_newHigherstudysubjects->SubjectId);
            $obj_retResult->msg = "Higherstudysubjects updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Higherstudysubjects updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getHigherstudysubjectsList()
    {
        $obj_retResult = DAL_manageHigherstudysubjects::getHigherstudysubjectsList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getHigherstudysubjectsList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageHigherstudysubjects::getAllHigherstudysubjects($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageHigherstudysubjects::searchHigherstudysubjectsBySubjectId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Higherstudysubjects List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>SubjectId</th>";
		$html .= "<th>SubjectName</th>";
		$html .= "<th>SubjectNumber</th>";
		$html .= "<th>SubjectField</th>";
		$html .= "<th>Level</th>";

		$html .= "</tr>";
		
            foreach ($arr_HigherstudysubjectsList as $obj_Higherstudysubjects)
            {               

                    $html .= $obj_Higherstudysubjects->drawTableViewHigherstudysubjects(); 
                
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

	public static function deleteHigherstudysubjects($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$SubjectId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_SubjectId =0;
			
			$retResult = BL_manageHigherstudysubjects::getHigherstudysubjectsListBySubjectId($SubjectId);
			if($retResult->type ==1)
			{
			
			$obj_Higherstudysubjects = $retResult->data[0];			
			$obj_result2 = DAL_manageHigherstudysubjects::deleteHigherstudysubjects($obj_Higherstudysubjects->SubjectId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_SubjectId = $obj_Higherstudysubjects->SubjectId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Higherstudysubjects";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Higherstudysubjects you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Higherstudysubjects->SubjectId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getHigherstudysubjectsListBySubjectId($SubjectId)
    {
        $obj_retResult = DAL_manageHigherstudysubjects::getHigherstudysubjectsListBySubjectId($SubjectId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildHigherstudysubjects($SubjectId,$ChildSubjectId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageHigherstudysubjects::getHigherstudysubjectsListBySubjectId($ChildSubjectId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_HigherstudysubjectsList = $obj_retResult->data;
				$obj_Higherstudysubjects = $arr_HigherstudysubjectsList[0];
				
				$arrParentIds = explode(",",$obj_Higherstudysubjects->Url);
				
				foreach($arrParentIds as $HigherstudysubjectsParentId)
				{
					if($HigherstudysubjectsParentId == $SubjectId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>