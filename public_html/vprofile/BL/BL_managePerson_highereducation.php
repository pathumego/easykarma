<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_highereducation.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_highereducation.php");


class BL_managePerson_highereducation
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_highereducation::addPerson_highereducation($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_highereducation::deletePerson_highereducation($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_highereducation::updatePerson_highereducation($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_highereducation($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_highereducation = new Person_highereducation();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_highereducation->ResultId = $packet[1];
		$obj_newPerson_highereducation->SubjectId = $packet[2]== "" ? 0 :$packet[2];
		$obj_newPerson_highereducation->InstituteId = $packet[3]== "" ? 0 :$packet[3];
		$obj_newPerson_highereducation->Grade = $packet[4];
		$obj_newPerson_highereducation->Language = $packet[5];
		$obj_newPerson_highereducation->DateTime = $packet[6];
		$obj_newPerson_highereducation->PersonId = $packet[7];
		$obj_newPerson_highereducation->Level = $packet[8];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_highereducation = DAL_managePerson_highereducation::addPerson_highereducation($obj_newPerson_highereducation);
            if ($obj_retResult_Person_highereducation->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_highereducation->data->wsGetPerson_highereducationData();
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

    public static function addPerson_highereducation2($ResultId,$SubjectId,$InstituteId,$Grade,$Language,$DateTime,$PersonId,$Level)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_highereducation = new Person_highereducation();
		
		$obj_newuser->setPerson_highereducation($ResultId,$SubjectId,$InstituteId,$Grade,$Language,$DateTime,$PersonId,$Level);
       // $isExist = BL_managePerson_highereducation::isExist($obj_newPerson_highereducation->id);

        if (!$isExist)
        {
            $obj_retResult_Person_highereducation = DAL_managePerson_highereducation::addPerson_highereducation($obj_newPerson_highereducation);
            if ($obj_retResult_Person_highereducation->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_highereducation->data;
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
            $obj_retResult->msg = "Sorry! Person_highereducation already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_highereducation($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_highereducation = new Person_highereducation();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_highereducation->ResultId = $packet[0];
		$obj_Person_highereducation->SubjectId = $packet[1];
		$obj_Person_highereducation->InstituteId = $packet[2];
		$obj_Person_highereducation->Grade = $packet[3];
		$obj_Person_highereducation->Language = $packet[4];
		$obj_Person_highereducation->DateTime = $packet[5];
		$obj_Person_highereducation->PersonId = $packet[6];
		$obj_Person_highereducation->Level = $packet[7];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_highereducation = DAL_managePerson_highereducation::update($obj_Person_highereducation);

        if ($obj_retResult_Person_highereducation->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_highereducation updation is Success";
			$retrunUserpacket = $obj_retResult_Person_highereducation->data->wsGetPerson_highereducationData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_highereducation updation is Failed";
			$result_Person_highereducation = DAL_managePerson_highereducation::getPerson_highereducationByResultId($obj_Person_highereducation->ResultId);
			if($result_Person_highereducation->type ==1)
			{
			$retrunUserpacket = $result_Person_highereducation->data->wsGetPerson_highereducationData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_highereducation2($ResultId,$SubjectId,$InstituteId,$Grade,$Language,$DateTime,$PersonId,$Level)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_highereducation = new Person_highereducation();
	
		$obj_newPerson_highereducation->ResultId=$ResultId;
		$obj_newPerson_highereducation->SubjectId=$SubjectId;
		$obj_newPerson_highereducation->InstituteId=$InstituteId;
		$obj_newPerson_highereducation->Grade=$Grade;
		$obj_newPerson_highereducation->Language=$Language;
		$obj_newPerson_highereducation->DateTime=$DateTime;
		$obj_newPerson_highereducation->PersonId=$PersonId;
		$obj_newPerson_highereducation->Level=$Level;

	   
        $issuccess = DAL_managePerson_highereducation::updatePerson_highereducation($obj_newPerson_highereducation);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_highereducation::getPerson_highereducationByResultId($obj_newPerson_highereducation->ResultId);
            $obj_retResult->msg = "Person_highereducation updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_highereducation updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_highereducationList()
    {
        $obj_retResult = DAL_managePerson_highereducation::getPerson_highereducationList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_highereducationList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_highereducation::getAllPerson_highereducation($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_highereducation::searchPerson_highereducationByResultId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_highereducation List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>ResultId</th>";
		$html .= "<th>SubjectId</th>";
		$html .= "<th>InstituteId</th>";
		$html .= "<th>Grade</th>";
		$html .= "<th>Language</th>";
		$html .= "<th>DateTime</th>";
		$html .= "<th>PersonId</th>";
		$html .= "<th>Level</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_highereducationList as $obj_Person_highereducation)
            {               

                    $html .= $obj_Person_highereducation->drawTableViewPerson_highereducation(); 
                
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

	public static function deletePerson_highereducation($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$ResultId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_ResultId =0;
			
			$retResult = BL_managePerson_highereducation::getPerson_highereducationListByResultId($ResultId);
			if($retResult->type ==1)
			{
			
			$obj_Person_highereducation = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_highereducation::deletePerson_highereducation($obj_Person_highereducation->ResultId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_ResultId = $obj_Person_highereducation->ResultId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_highereducation";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_highereducation you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_highereducation->ResultId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_highereducationListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_highereducation::getPerson_highereducationListByPersonId($personId);
        return $obj_retResult;
    }
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_highereducationListByResultId($ResultId)
    {
        $obj_retResult = DAL_managePerson_highereducation::getPerson_highereducationListByResultId($ResultId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_highereducation($ResultId,$ChildResultId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_highereducation::getPerson_highereducationListByResultId($ChildResultId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_highereducationList = $obj_retResult->data;
				$obj_Person_highereducation = $arr_Person_highereducationList[0];
				
				$arrParentIds = explode(",",$obj_Person_highereducation->Url);
				
				foreach($arrParentIds as $Person_highereducationParentId)
				{
					if($Person_highereducationParentId == $ResultId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>