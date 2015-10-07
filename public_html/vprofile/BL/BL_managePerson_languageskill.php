<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_languageskill.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_languageskill.php");


class BL_managePerson_languageskill
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_languageskill::addPerson_languageskill($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_languageskill::deletePerson_languageskill($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_languageskill::updatePerson_languageskill($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_languageskill($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_languageskill = new Person_languageskill();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_languageskill->LangSkillId = $packet[1];
		$obj_newPerson_languageskill->PersonId = $packet[2];
		$obj_newPerson_languageskill->Language = $packet[3];
		$obj_newPerson_languageskill->SkillType = $packet[4];
		$obj_newPerson_languageskill->Grade = $packet[5];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_languageskill = DAL_managePerson_languageskill::addPerson_languageskill($obj_newPerson_languageskill);
            if ($obj_retResult_Person_languageskill->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_languageskill->data->wsGetPerson_languageskillData();
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

    public static function addPerson_languageskill2($LangSkillId,$PersonId,$Language,$SkillType,$Grade)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_languageskill = new Person_languageskill();
		
		$obj_newuser->setPerson_languageskill($LangSkillId,$PersonId,$Language,$SkillType,$Grade);
       // $isExist = BL_managePerson_languageskill::isExist($obj_newPerson_languageskill->id);

        if (!$isExist)
        {
            $obj_retResult_Person_languageskill = DAL_managePerson_languageskill::addPerson_languageskill($obj_newPerson_languageskill);
            if ($obj_retResult_Person_languageskill->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_languageskill->data;
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
            $obj_retResult->msg = "Sorry! Person_languageskill already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_languageskill($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_languageskill = new Person_languageskill();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_languageskill->LangSkillId = $packet[0];
		$obj_Person_languageskill->PersonId = $packet[1];
		$obj_Person_languageskill->Language = $packet[2];
		$obj_Person_languageskill->SkillType = $packet[3];
		$obj_Person_languageskill->Grade = $packet[4];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_languageskill = DAL_managePerson_languageskill::update($obj_Person_languageskill);

        if ($obj_retResult_Person_languageskill->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_languageskill updation is Success";
			$retrunUserpacket = $obj_retResult_Person_languageskill->data->wsGetPerson_languageskillData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_languageskill updation is Failed";
			$result_Person_languageskill = DAL_managePerson_languageskill::getPerson_languageskillByLangSkillId($obj_Person_languageskill->LangSkillId);
			if($result_Person_languageskill->type ==1)
			{
			$retrunUserpacket = $result_Person_languageskill->data->wsGetPerson_languageskillData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_languageskill2($LangSkillId,$PersonId,$Language,$SkillType,$Grade)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_languageskill = new Person_languageskill();
	
		$obj_newPerson_languageskill->LangSkillId=$LangSkillId;
		$obj_newPerson_languageskill->PersonId=$PersonId;
		$obj_newPerson_languageskill->Language=$Language;
		$obj_newPerson_languageskill->SkillType=$SkillType;
		$obj_newPerson_languageskill->Grade=$Grade;

	   
        $issuccess = DAL_managePerson_languageskill::updatePerson_languageskill($obj_newPerson_languageskill);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_languageskill::getPerson_languageskillByLangSkillId($obj_newPerson_languageskill->LangSkillId);
            $obj_retResult->msg = "Person_languageskill updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_languageskill updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_languageskillList()
    {
        $obj_retResult = DAL_managePerson_languageskill::getPerson_languageskillList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_languageskillList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_languageskill::getAllPerson_languageskill($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_languageskill::searchPerson_languageskillByLangSkillId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_languageskill List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>LangSkillId</th>";
		$html .= "<th>PersonId</th>";
		$html .= "<th>Language</th>";
		$html .= "<th>SkillType</th>";
		$html .= "<th>Grade</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_languageskillList as $obj_Person_languageskill)
            {               

                    $html .= $obj_Person_languageskill->drawTableViewPerson_languageskill(); 
                
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

	public static function deletePerson_languageskill($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$LangSkillId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_LangSkillId =0;
			
			$retResult = BL_managePerson_languageskill::getPerson_languageskillListByLangSkillId($LangSkillId);
			if($retResult->type ==1)
			{
			
			$obj_Person_languageskill = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_languageskill::deletePerson_languageskill($obj_Person_languageskill->LangSkillId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_LangSkillId = $obj_Person_languageskill->LangSkillId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_languageskill";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_languageskill you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_languageskill->LangSkillId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_languageskillListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_languageskill::getPerson_languageskillListByPersonId($personId);
        return $obj_retResult;
    }
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_languageskillListByLangSkillId($LangSkillId)
    {
        $obj_retResult = DAL_managePerson_languageskill::getPerson_languageskillListByLangSkillId($LangSkillId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_languageskill($LangSkillId,$ChildLangSkillId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_languageskill::getPerson_languageskillListByLangSkillId($ChildLangSkillId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_languageskillList = $obj_retResult->data;
				$obj_Person_languageskill = $arr_Person_languageskillList[0];
				
				$arrParentIds = explode(",",$obj_Person_languageskill->Url);
				
				foreach($arrParentIds as $Person_languageskillParentId)
				{
					if($Person_languageskillParentId == $LangSkillId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>