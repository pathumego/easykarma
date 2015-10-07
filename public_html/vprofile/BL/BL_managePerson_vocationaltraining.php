<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_vocationaltraining.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_vocationaltraining.php");


class BL_managePerson_vocationaltraining
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_vocationaltraining::addPerson_vocationaltraining($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_vocationaltraining::deletePerson_vocationaltraining($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_vocationaltraining::updatePerson_vocationaltraining($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_vocationaltraining($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_vocationaltraining = new Person_vocationaltraining();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_vocationaltraining->VocationalTrainId = $packet[1];
		$obj_newPerson_vocationaltraining->FieldName = $packet[2];
		$obj_newPerson_vocationaltraining->CourseName = $packet[3];
		$obj_newPerson_vocationaltraining->InstituteId = $packet[4];
		$obj_newPerson_vocationaltraining->StartDate = $packet[5];
		$obj_newPerson_vocationaltraining->EndDate = $packet[6];
		$obj_newPerson_vocationaltraining->CertificateType = $packet[7];
		$obj_newPerson_vocationaltraining->PersonId = $packet[8];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_vocationaltraining = DAL_managePerson_vocationaltraining::addPerson_vocationaltraining($obj_newPerson_vocationaltraining);
            if ($obj_retResult_Person_vocationaltraining->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_vocationaltraining->data->wsGetPerson_vocationaltrainingData();
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

    public static function addPerson_vocationaltraining2($VocationalTrainId,$FieldName,$CourseName,$InstituteId,$StartDate,$EndDate,$CertificateType,$PersonId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_vocationaltraining = new Person_vocationaltraining();
		
		$obj_newuser->setPerson_vocationaltraining($VocationalTrainId,$FieldName,$CourseName,$InstituteId,$StartDate,$EndDate,$CertificateType,$PersonId);
       // $isExist = BL_managePerson_vocationaltraining::isExist($obj_newPerson_vocationaltraining->id);

        if (!$isExist)
        {
            $obj_retResult_Person_vocationaltraining = DAL_managePerson_vocationaltraining::addPerson_vocationaltraining($obj_newPerson_vocationaltraining);
            if ($obj_retResult_Person_vocationaltraining->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_vocationaltraining->data;
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
            $obj_retResult->msg = "Sorry! Person_vocationaltraining already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_vocationaltraining($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_vocationaltraining = new Person_vocationaltraining();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_vocationaltraining->VocationalTrainId = $packet[0];
		$obj_Person_vocationaltraining->FieldName = $packet[1];
		$obj_Person_vocationaltraining->CourseName = $packet[2];
		$obj_Person_vocationaltraining->InstituteId = $packet[3];
		$obj_Person_vocationaltraining->StartDate = $packet[4];
		$obj_Person_vocationaltraining->EndDate = $packet[5];
		$obj_Person_vocationaltraining->CertificateType = $packet[6];
		$obj_Person_vocationaltraining->PersonId = $packet[7];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_vocationaltraining = DAL_managePerson_vocationaltraining::update($obj_Person_vocationaltraining);

        if ($obj_retResult_Person_vocationaltraining->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_vocationaltraining updation is Success";
			$retrunUserpacket = $obj_retResult_Person_vocationaltraining->data->wsGetPerson_vocationaltrainingData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_vocationaltraining updation is Failed";
			$result_Person_vocationaltraining = DAL_managePerson_vocationaltraining::getPerson_vocationaltrainingByVocationalTrainId($obj_Person_vocationaltraining->VocationalTrainId);
			if($result_Person_vocationaltraining->type ==1)
			{
			$retrunUserpacket = $result_Person_vocationaltraining->data->wsGetPerson_vocationaltrainingData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_vocationaltraining2($VocationalTrainId,$FieldName,$CourseName,$InstituteId,$StartDate,$EndDate,$CertificateType,$PersonId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_vocationaltraining = new Person_vocationaltraining();
	
		$obj_newPerson_vocationaltraining->VocationalTrainId=$VocationalTrainId;
		$obj_newPerson_vocationaltraining->FieldName=$FieldName;
		$obj_newPerson_vocationaltraining->CourseName=$CourseName;
		$obj_newPerson_vocationaltraining->InstituteId=$InstituteId;
		$obj_newPerson_vocationaltraining->StartDate=$StartDate;
		$obj_newPerson_vocationaltraining->EndDate=$EndDate;
		$obj_newPerson_vocationaltraining->CertificateType=$CertificateType;
		$obj_newPerson_vocationaltraining->PersonId=$PersonId;

	   
        $issuccess = DAL_managePerson_vocationaltraining::updatePerson_vocationaltraining($obj_newPerson_vocationaltraining);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_vocationaltraining::getPerson_vocationaltrainingByVocationalTrainId($obj_newPerson_vocationaltraining->VocationalTrainId);
            $obj_retResult->msg = "Person_vocationaltraining updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_vocationaltraining updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_vocationaltrainingList()
    {
        $obj_retResult = DAL_managePerson_vocationaltraining::getPerson_vocationaltrainingList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_vocationaltrainingList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_vocationaltraining::getAllPerson_vocationaltraining($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_vocationaltraining::searchPerson_vocationaltrainingByVocationalTrainId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_vocationaltraining List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>VocationalTrainId</th>";
		$html .= "<th>FieldName</th>";
		$html .= "<th>CourseName</th>";
		$html .= "<th>InstituteId</th>";
		$html .= "<th>StartDate</th>";
		$html .= "<th>EndDate</th>";
		$html .= "<th>CertificateType</th>";
		$html .= "<th>PersonId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_vocationaltrainingList as $obj_Person_vocationaltraining)
            {               

                    $html .= $obj_Person_vocationaltraining->drawTableViewPerson_vocationaltraining(); 
                
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

	public static function deletePerson_vocationaltraining($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$VocationalTrainId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_VocationalTrainId =0;
			
			$retResult = BL_managePerson_vocationaltraining::getPerson_vocationaltrainingListByVocationalTrainId($VocationalTrainId);
			if($retResult->type ==1)
			{
			
			$obj_Person_vocationaltraining = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_vocationaltraining::deletePerson_vocationaltraining($obj_Person_vocationaltraining->VocationalTrainId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_VocationalTrainId = $obj_Person_vocationaltraining->VocationalTrainId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_vocationaltraining";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_vocationaltraining you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_vocationaltraining->VocationalTrainId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_vocationaltrainingListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_vocationaltraining::getPerson_vocationaltrainingListByPersonId($personId);
        return $obj_retResult;
    }
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_vocationaltrainingListByVocationalTrainId($VocationalTrainId)
    {
        $obj_retResult = DAL_managePerson_vocationaltraining::getPerson_vocationaltrainingListByVocationalTrainId($VocationalTrainId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_vocationaltraining($VocationalTrainId,$ChildVocationalTrainId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_vocationaltraining::getPerson_vocationaltrainingListByVocationalTrainId($ChildVocationalTrainId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_vocationaltrainingList = $obj_retResult->data;
				$obj_Person_vocationaltraining = $arr_Person_vocationaltrainingList[0];
				
				$arrParentIds = explode(",",$obj_Person_vocationaltraining->Url);
				
				foreach($arrParentIds as $Person_vocationaltrainingParentId)
				{
					if($Person_vocationaltrainingParentId == $VocationalTrainId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>