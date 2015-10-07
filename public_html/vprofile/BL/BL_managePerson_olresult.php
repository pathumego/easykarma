<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_olresult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_olresult.php");


class BL_managePerson_olresult
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_olresult::addPerson_olresult($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_olresult::deletePerson_olresult($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_olresult::updatePerson_olresult($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_olresult($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_olresult = new Person_olresult();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_olresult->OLResultId = $packet[1];
		$obj_newPerson_olresult->SubjectId = $packet[2];
		$obj_newPerson_olresult->SchoolId = $packet[3];
		$obj_newPerson_olresult->Grade = $packet[4];
		$obj_newPerson_olresult->Language = $packet[5];
		$obj_newPerson_olresult->DateTime = $packet[6];
		$obj_newPerson_olresult->PersonId = $packet[7];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_olresult = DAL_managePerson_olresult::addPerson_olresult($obj_newPerson_olresult);
            if ($obj_retResult_Person_olresult->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_olresult->data->wsGetPerson_olresultData();
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

    public static function addPerson_olresult2($OLResultId,$SubjectId,$SchoolId,$Grade,$Language,$DateTime,$PersonId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_olresult = new Person_olresult();
		
		$obj_newuser->setPerson_olresult($OLResultId,$SubjectId,$SchoolId,$Grade,$Language,$DateTime,$PersonId);
       // $isExist = BL_managePerson_olresult::isExist($obj_newPerson_olresult->id);

        if (!$isExist)
        {
            $obj_retResult_Person_olresult = DAL_managePerson_olresult::addPerson_olresult($obj_newPerson_olresult);
            if ($obj_retResult_Person_olresult->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_olresult->data;
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
            $obj_retResult->msg = "Sorry! Person_olresult already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_olresult($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_olresult = new Person_olresult();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_olresult->OLResultId = $packet[0];
		$obj_Person_olresult->SubjectId = $packet[1];
		$obj_Person_olresult->SchoolId = $packet[2];
		$obj_Person_olresult->Grade = $packet[3];
		$obj_Person_olresult->Language = $packet[4];
		$obj_Person_olresult->DateTime = $packet[5];
		$obj_Person_olresult->PersonId = $packet[6];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_olresult = DAL_managePerson_olresult::update($obj_Person_olresult);

        if ($obj_retResult_Person_olresult->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_olresult updation is Success";
			$retrunUserpacket = $obj_retResult_Person_olresult->data->wsGetPerson_olresultData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_olresult updation is Failed";
			$result_Person_olresult = DAL_managePerson_olresult::getPerson_olresultByOLResultId($obj_Person_olresult->OLResultId);
			if($result_Person_olresult->type ==1)
			{
			$retrunUserpacket = $result_Person_olresult->data->wsGetPerson_olresultData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_olresult2($OLResultId,$SubjectId,$SchoolId,$Grade,$Language,$DateTime,$PersonId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_olresult = new Person_olresult();
	
		$obj_newPerson_olresult->OLResultId=$OLResultId;
		$obj_newPerson_olresult->SubjectId=$SubjectId;
		$obj_newPerson_olresult->SchoolId=$SchoolId;
		$obj_newPerson_olresult->Grade=$Grade;
		$obj_newPerson_olresult->Language=$Language;
		$obj_newPerson_olresult->DateTime=$DateTime;
		$obj_newPerson_olresult->PersonId=$PersonId;

	   
        $issuccess = DAL_managePerson_olresult::updatePerson_olresult($obj_newPerson_olresult);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_olresult::getPerson_olresultByOLResultId($obj_newPerson_olresult->OLResultId);
            $obj_retResult->msg = "Person_olresult updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_olresult updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_olresultList()
    {
        $obj_retResult = DAL_managePerson_olresult::getPerson_olresultList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_olresultList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_olresult::getAllPerson_olresult($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_olresult::searchPerson_olresultByOLResultId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_olresult List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>OLResultId</th>";
		$html .= "<th>SubjectId</th>";
		$html .= "<th>SchoolId</th>";
		$html .= "<th>Grade</th>";
		$html .= "<th>Language</th>";
		$html .= "<th>DateTime</th>";
		$html .= "<th>PersonId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_olresultList as $obj_Person_olresult)
            {               

                    $html .= $obj_Person_olresult->drawTableViewPerson_olresult(); 
                
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

	public static function deletePerson_olresult($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$OLResultId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_OLResultId =0;
			
			$retResult = BL_managePerson_olresult::getPerson_olresultListByOLResultId($OLResultId);
			if($retResult->type ==1)
			{
			
			$obj_Person_olresult = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_olresult::deletePerson_olresult($obj_Person_olresult->OLResultId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_OLResultId = $obj_Person_olresult->OLResultId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_olresult";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_olresult you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_olresult->OLResultId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_olresultListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_olresult::getPerson_olresultListByPersonId($personId);
        return $obj_retResult;
    }
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_olresultListByOLResultId($OLResultId)
    {
        $obj_retResult = DAL_managePerson_olresult::getPerson_olresultListByOLResultId($OLResultId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_olresult($OLResultId,$ChildOLResultId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_olresult::getPerson_olresultListByOLResultId($ChildOLResultId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_olresultList = $obj_retResult->data;
				$obj_Person_olresult = $arr_Person_olresultList[0];
				
				$arrParentIds = explode(",",$obj_Person_olresult->Url);
				
				foreach($arrParentIds as $Person_olresultParentId)
				{
					if($Person_olresultParentId == $OLResultId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>