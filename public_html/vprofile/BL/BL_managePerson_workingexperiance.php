<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_workingexperiance.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_workingexperiance.php");


class BL_managePerson_workingexperiance
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_workingexperiance::addPerson_workingexperiance($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_workingexperiance::deletePerson_workingexperiance($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_workingexperiance::updatePerson_workingexperiance($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_workingexperiance($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_workingexperiance = new Person_workingexperiance();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_workingexperiance->WorkExpId = $packet[1];
		$obj_newPerson_workingexperiance->CompanyId = $packet[2];
		$obj_newPerson_workingexperiance->StartDate = $packet[3];
		$obj_newPerson_workingexperiance->EndDate = $packet[4];
		$obj_newPerson_workingexperiance->Position = $packet[5];
		$obj_newPerson_workingexperiance->PersonId = $packet[6];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_workingexperiance = DAL_managePerson_workingexperiance::addPerson_workingexperiance($obj_newPerson_workingexperiance);
            if ($obj_retResult_Person_workingexperiance->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_workingexperiance->data->wsGetPerson_workingexperianceData();
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

    public static function addPerson_workingexperiance2($WorkExpId,$CompanyId,$StartDate,$EndDate,$Position,$PersonId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_workingexperiance = new Person_workingexperiance();
		
		$obj_newuser->setPerson_workingexperiance($WorkExpId,$CompanyId,$StartDate,$EndDate,$Position,$PersonId);
       // $isExist = BL_managePerson_workingexperiance::isExist($obj_newPerson_workingexperiance->id);

        if (!$isExist)
        {
            $obj_retResult_Person_workingexperiance = DAL_managePerson_workingexperiance::addPerson_workingexperiance($obj_newPerson_workingexperiance);
            if ($obj_retResult_Person_workingexperiance->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_workingexperiance->data;
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
            $obj_retResult->msg = "Sorry! Person_workingexperiance already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_workingexperiance($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_workingexperiance = new Person_workingexperiance();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_workingexperiance->WorkExpId = $packet[0];
		$obj_Person_workingexperiance->CompanyId = $packet[1];
		$obj_Person_workingexperiance->StartDate = $packet[2];
		$obj_Person_workingexperiance->EndDate = $packet[3];
		$obj_Person_workingexperiance->Position = $packet[4];
		$obj_Person_workingexperiance->PersonId = $packet[5];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_workingexperiance = DAL_managePerson_workingexperiance::update($obj_Person_workingexperiance);

        if ($obj_retResult_Person_workingexperiance->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_workingexperiance updation is Success";
			$retrunUserpacket = $obj_retResult_Person_workingexperiance->data->wsGetPerson_workingexperianceData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_workingexperiance updation is Failed";
			$result_Person_workingexperiance = DAL_managePerson_workingexperiance::getPerson_workingexperianceByWorkExpId($obj_Person_workingexperiance->WorkExpId);
			if($result_Person_workingexperiance->type ==1)
			{
			$retrunUserpacket = $result_Person_workingexperiance->data->wsGetPerson_workingexperianceData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_workingexperiance2($WorkExpId,$CompanyId,$StartDate,$EndDate,$Position,$PersonId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_workingexperiance = new Person_workingexperiance();
	
		$obj_newPerson_workingexperiance->WorkExpId=$WorkExpId;
		$obj_newPerson_workingexperiance->CompanyId=$CompanyId;
		$obj_newPerson_workingexperiance->StartDate=$StartDate;
		$obj_newPerson_workingexperiance->EndDate=$EndDate;
		$obj_newPerson_workingexperiance->Position=$Position;
		$obj_newPerson_workingexperiance->PersonId=$PersonId;

	   
        $issuccess = DAL_managePerson_workingexperiance::updatePerson_workingexperiance($obj_newPerson_workingexperiance);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_workingexperiance::getPerson_workingexperianceByWorkExpId($obj_newPerson_workingexperiance->WorkExpId);
            $obj_retResult->msg = "Person_workingexperiance updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_workingexperiance updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_workingexperianceList()
    {
        $obj_retResult = DAL_managePerson_workingexperiance::getPerson_workingexperianceList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_workingexperianceList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_workingexperiance::getAllPerson_workingexperiance($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_workingexperiance::searchPerson_workingexperianceByWorkExpId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_workingexperiance List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>WorkExpId</th>";
		$html .= "<th>CompanyId</th>";
		$html .= "<th>StartDate</th>";
		$html .= "<th>EndDate</th>";
		$html .= "<th>Position</th>";
		$html .= "<th>PersonId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_workingexperianceList as $obj_Person_workingexperiance)
            {               

                    $html .= $obj_Person_workingexperiance->drawTableViewPerson_workingexperiance(); 
                
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

	public static function deletePerson_workingexperiance($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$WorkExpId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_WorkExpId =0;
			
			$retResult = BL_managePerson_workingexperiance::getPerson_workingexperianceListByWorkExpId($WorkExpId);
			if($retResult->type ==1)
			{
			
			$obj_Person_workingexperiance = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_workingexperiance::deletePerson_workingexperiance($obj_Person_workingexperiance->WorkExpId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_WorkExpId = $obj_Person_workingexperiance->WorkExpId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_workingexperiance";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_workingexperiance you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_workingexperiance->WorkExpId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_workingexperianceListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_workingexperiance::getPerson_workingexperianceListByPersonId($personId);
        return $obj_retResult;
    }
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_workingexperianceListByWorkExpId($WorkExpId)
    {
        $obj_retResult = DAL_managePerson_workingexperiance::getPerson_workingexperianceListByWorkExpId($WorkExpId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_workingexperiance($WorkExpId,$ChildWorkExpId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_workingexperiance::getPerson_workingexperianceListByWorkExpId($ChildWorkExpId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_workingexperianceList = $obj_retResult->data;
				$obj_Person_workingexperiance = $arr_Person_workingexperianceList[0];
				
				$arrParentIds = explode(",",$obj_Person_workingexperiance->Url);
				
				foreach($arrParentIds as $Person_workingexperianceParentId)
				{
					if($Person_workingexperianceParentId == $WorkExpId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>