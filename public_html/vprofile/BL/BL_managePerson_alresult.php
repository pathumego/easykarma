<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_alresult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_alresult.php");


class BL_managePerson_alresult
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_alresult::addPerson_alresult($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_alresult::deletePerson_alresult($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_alresult::updatePerson_alresult($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_alresult($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_alresult = new Person_alresult();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_alresult->ALResultId = $packet[1];
		$obj_newPerson_alresult->SubjectId = $packet[2]== "" ? 0 :$packet[2];
		$obj_newPerson_alresult->SchoolId = $packet[3]== "" ? 0 :$packet[3];
		$obj_newPerson_alresult->Grade = $packet[4];
		$obj_newPerson_alresult->Language = $packet[5];
		$obj_newPerson_alresult->DateTime = $packet[6];
		$obj_newPerson_alresult->PersonId = $packet[7];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_alresult = DAL_managePerson_alresult::addPerson_alresult($obj_newPerson_alresult);
            if ($obj_retResult_Person_alresult->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_alresult->data->wsGetPerson_alresultData();
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

    public static function addPerson_alresult2($ALResultId,$SubjectId,$SchoolId,$Grade,$Language,$DateTime,$PersonId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_alresult = new Person_alresult();
		
		$obj_newuser->setPerson_alresult($ALResultId,$SubjectId,$SchoolId,$Grade,$Language,$DateTime,$PersonId);
       // $isExist = BL_managePerson_alresult::isExist($obj_newPerson_alresult->id);

        if (!$isExist)
        {
            $obj_retResult_Person_alresult = DAL_managePerson_alresult::addPerson_alresult($obj_newPerson_alresult);
            if ($obj_retResult_Person_alresult->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_alresult->data;
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
            $obj_retResult->msg = "Sorry! Person_alresult already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_alresult($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_alresult = new Person_alresult();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_alresult->ALResultId = $packet[0];
		$obj_Person_alresult->SubjectId = $packet[1];
		$obj_Person_alresult->SchoolId = $packet[2];
		$obj_Person_alresult->Grade = $packet[3];
		$obj_Person_alresult->Language = $packet[4];
		$obj_Person_alresult->DateTime = $packet[5];
		$obj_Person_alresult->PersonId = $packet[6];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_alresult = DAL_managePerson_alresult::update($obj_Person_alresult);

        if ($obj_retResult_Person_alresult->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_alresult updation is Success";
			$retrunUserpacket = $obj_retResult_Person_alresult->data->wsGetPerson_alresultData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_alresult updation is Failed";
			$result_Person_alresult = DAL_managePerson_alresult::getPerson_alresultByALResultId($obj_Person_alresult->ALResultId);
			if($result_Person_alresult->type ==1)
			{
			$retrunUserpacket = $result_Person_alresult->data->wsGetPerson_alresultData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_alresult2($ALResultId,$SubjectId,$SchoolId,$Grade,$Language,$DateTime,$PersonId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_alresult = new Person_alresult();
	
		$obj_newPerson_alresult->ALResultId=$ALResultId;
		$obj_newPerson_alresult->SubjectId=$SubjectId;
		$obj_newPerson_alresult->SchoolId=$SchoolId;
		$obj_newPerson_alresult->Grade=$Grade;
		$obj_newPerson_alresult->Language=$Language;
		$obj_newPerson_alresult->DateTime=$DateTime;
		$obj_newPerson_alresult->PersonId=$PersonId;

	   
        $issuccess = DAL_managePerson_alresult::updatePerson_alresult($obj_newPerson_alresult);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_alresult::getPerson_alresultByALResultId($obj_newPerson_alresult->ALResultId);
            $obj_retResult->msg = "Person_alresult updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_alresult updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_alresultList()
    {
        $obj_retResult = DAL_managePerson_alresult::getPerson_alresultList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_alresultList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_alresult::getAllPerson_alresult($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_alresult::searchPerson_alresultByALResultId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_alresult List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ALResultId</th>";
		$html .= "<th>SubjectId</th>";
		$html .= "<th>SchoolId</th>";
		$html .= "<th>Grade</th>";
		$html .= "<th>Language</th>";
		$html .= "<th>DateTime</th>";
		$html .= "<th>PersonId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_alresultList as $obj_Person_alresult)
            {               

                    $html .= $obj_Person_alresult->drawTableViewPerson_alresult(); 
                
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

	public static function deletePerson_alresult($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ALResultId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ALResultId =0;
			
			$retResult = BL_managePerson_alresult::getPerson_alresultListByALResultId($ALResultId);
			if($retResult->type ==1)
			{
			
			$obj_Person_alresult = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_alresult::deletePerson_alresult($obj_Person_alresult->ALResultId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ALResultId = $obj_Person_alresult->ALResultId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_alresult";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_alresult you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_alresult->ALResultId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_alresultListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_alresult::getPerson_alresultListByPersonId($personId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_alresultListByALResultId($ALResultId)
    {
        $obj_retResult = DAL_managePerson_alresult::getPerson_alresultListByALResultId($ALResultId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_alresult($ALResultId,$ChildALResultId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_alresult::getPerson_alresultListByALResultId($ChildALResultId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_alresultList = $obj_retResult->data;
				$obj_Person_alresult = $arr_Person_alresultList[0];
				
				$arrParentIds = explode(",",$obj_Person_alresult->Url);
				
				foreach($arrParentIds as $Person_alresultParentId)
				{
					if($Person_alresultParentId == $ALResultId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>