<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_talent.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_talent.php");


class BL_managePerson_talent
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_talent::addPerson_talent($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_talent::deletePerson_talent($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_talent::updatePerson_talent($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_talent($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_talent = new Person_talent();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_talent->TblId = $packet[1];
		$obj_newPerson_talent->PersonId = $packet[2];
		$obj_newPerson_talent->TalentId = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_talent = DAL_managePerson_talent::addPerson_talent($obj_newPerson_talent);
            if ($obj_retResult_Person_talent->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_talent->data->wsGetPerson_talentData();
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

    public static function addPerson_talent2($TblId,$PersonId,$TalentId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_talent = new Person_talent();
		
		$obj_newuser->setPerson_talent($TblId,$PersonId,$TalentId);
       // $isExist = BL_managePerson_talent::isExist($obj_newPerson_talent->id);

        if (!$isExist)
        {
            $obj_retResult_Person_talent = DAL_managePerson_talent::addPerson_talent($obj_newPerson_talent);
            if ($obj_retResult_Person_talent->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_talent->data;
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
            $obj_retResult->msg = "Sorry! Person_talent already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_talent($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_talent = new Person_talent();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_talent->TblId = $packet[0];
		$obj_Person_talent->PersonId = $packet[1];
		$obj_Person_talent->TalentId = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_talent = DAL_managePerson_talent::update($obj_Person_talent);

        if ($obj_retResult_Person_talent->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_talent updation is Success";
			$retrunUserpacket = $obj_retResult_Person_talent->data->wsGetPerson_talentData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_talent updation is Failed";
			$result_Person_talent = DAL_managePerson_talent::getPerson_talentByTblId($obj_Person_talent->TblId);
			if($result_Person_talent->type ==1)
			{
			$retrunUserpacket = $result_Person_talent->data->wsGetPerson_talentData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_talent2($TblId,$PersonId,$TalentId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_talent = new Person_talent();
	
		$obj_newPerson_talent->TblId=$TblId;
		$obj_newPerson_talent->PersonId=$PersonId;
		$obj_newPerson_talent->TalentId=$TalentId;

	   
        $issuccess = DAL_managePerson_talent::updatePerson_talent($obj_newPerson_talent);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_talent::getPerson_talentByTblId($obj_newPerson_talent->TblId);
            $obj_retResult->msg = "Person_talent updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_talent updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_talentList()
    {
        $obj_retResult = DAL_managePerson_talent::getPerson_talentList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_talentList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_talent::getAllPerson_talent($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_talent::searchPerson_talentByTblId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_talent List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>TblId</th>";
		$html .= "<th>PersonId</th>";
		$html .= "<th>TalentId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_talentList as $obj_Person_talent)
            {               

                    $html .= $obj_Person_talent->drawTableViewPerson_talent(); 
                
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

	public static function deletePerson_talent($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$TblId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_TblId =0;
			
			$retResult = BL_managePerson_talent::getPerson_talentListByTblId($TblId);
			if($retResult->type ==1)
			{
			
			$obj_Person_talent = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_talent::deletePerson_talent($obj_Person_talent->TblId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_TblId = $obj_Person_talent->TblId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_talent";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_talent you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_talent->TblId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_talentListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_talent::getPerson_talentListByPersonId($personId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_talentListByTblId($TblId)
    {
        $obj_retResult = DAL_managePerson_talent::getPerson_talentListByTblId($TblId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_talent($TblId,$ChildTblId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_talent::getPerson_talentListByTblId($ChildTblId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_talentList = $obj_retResult->data;
				$obj_Person_talent = $arr_Person_talentList[0];
				
				$arrParentIds = explode(",",$obj_Person_talent->Url);
				
				foreach($arrParentIds as $Person_talentParentId)
				{
					if($Person_talentParentId == $TblId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>