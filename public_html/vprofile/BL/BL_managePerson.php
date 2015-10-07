<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson.php");


class BL_managePerson
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson::addPerson($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson::deletePerson($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson::updatePerson($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson = new Person();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson->PersonId = $packet[1];
		$obj_newPerson->FullName = $packet[2];
		$obj_newPerson->NickName = $packet[3];
		$obj_newPerson->OtherNames = $packet[4];
		$obj_newPerson->DrivingLicenceNo = $packet[5];
		$obj_newPerson->PassportNo = $packet[6];
		$obj_newPerson->PermanentAddress = $packet[7];
		$obj_newPerson->Email = $packet[8];
		$obj_newPerson->Website = $packet[9];
		$obj_newPerson->Description = $packet[10];
		$obj_newPerson->Gender = $packet[11];
		$obj_newPerson->DOB = $packet[12];
		$obj_newPerson->Height = $packet[13] == "" ? 0.0 :$packet[13];
		$obj_newPerson->Weight = $packet[14] == "" ? 0.0 :$packet[14];
		$obj_newPerson->HairColor = $packet[15];
		$obj_newPerson->EyeColor = $packet[16];
		$obj_newPerson->BloodType = $packet[17];
		$obj_newPerson->Occupation = $packet[18];
		$obj_newPerson->MonthlyIncome = $packet[19] == "" ? 0.0 :$packet[19];
		$obj_newPerson->FutureTargets = $packet[20];
		$obj_newPerson->FutureNeeds = $packet[21];
		$obj_newPerson->DOD = $packet[22];
		$obj_newPerson->Picture = $packet[23];
		$obj_newPerson->NIC = $packet[24];
		$obj_newPerson->Status = 1;

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person = DAL_managePerson::addPerson($obj_newPerson);
            if ($obj_retResult_Person->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person->data->wsGetPersonData();
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

    public static function addPerson2($PersonId,$FullName,$NickName,$OtherNames,$DrivingLicenceNo,$PassportNo,$PermanentAddress,$Email,$Website,$Description,$Gender,$DOB,$Height,$Weight,$HairColor,$EyeColor,$BloodType,$Occupation,$MonthlyIncome,$FutureTargets,$FutureNeeds,$DOD,$Picture,$NIC,$Status)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson = new Person();
		
		$obj_newuser->setPerson($PersonId,$FullName,$NickName,$OtherNames,$DrivingLicenceNo,$PassportNo,$PermanentAddress,$Email,$Website,$Description,$Gender,$DOB,$Height,$Weight,$HairColor,$EyeColor,$BloodType,$Occupation,$MonthlyIncome,$FutureTargets,$FutureNeeds,$DOD,$Picture,$NIC,$Status);
       // $isExist = BL_managePerson::isExist($obj_newPerson->id);

        if (!$isExist)
        {
            $obj_retResult_Person = DAL_managePerson::addPerson($obj_newPerson);
            if ($obj_retResult_Person->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person->data;
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
            $obj_retResult->msg = "Sorry! Person already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person = new Person();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person->PersonId = $packet[0];
		$obj_Person->FullName = $packet[1];
		$obj_Person->NickName = $packet[2];
		$obj_Person->OtherNames = $packet[3];
		$obj_Person->DrivingLicenceNo = $packet[4];
		$obj_Person->PassportNo = $packet[5];
		$obj_Person->PermanentAddress = $packet[6];
		$obj_Person->Email = $packet[7];
		$obj_Person->Website = $packet[8];
		$obj_Person->Description = $packet[9];
		$obj_Person->Gender = $packet[10];
		$obj_Person->DOB = $packet[11];
		$obj_Person->Height = $packet[12];
		$obj_Person->Weight = $packet[13];
		$obj_Person->HairColor = $packet[14];
		$obj_Person->EyeColor = $packet[15];
		$obj_Person->BloodType = $packet[16];
		$obj_Person->Occupation = $packet[17];
		$obj_Person->MonthlyIncome = $packet[18] == "" ? 0.0 : $packet[18];
		$obj_Person->FutureTargets = $packet[19];
		$obj_Person->FutureNeeds = $packet[20];
		$obj_Person->DOD = $packet[21];
		$obj_Person->Picture = $packet[22];
		$obj_Person->NIC = $packet[23];
		$obj_Person->Status = $packet[24] == "" ? 1 :$packet[24];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person = DAL_managePerson::update($obj_Person);

        if ($obj_retResult_Person->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person updation is Success";
			$retrunUserpacket = $obj_retResult_Person->data->wsGetPersonData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person updation is Failed";
			$result_Person = DAL_managePerson::getPersonByPersonId($obj_Person->PersonId);
			if($result_Person->type ==1)
			{
			$retrunUserpacket = $result_Person->data->wsGetPersonData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson2($PersonId,$FullName,$NickName,$OtherNames,$DrivingLicenceNo,$PassportNo,$PermanentAddress,$Email,$Website,$Description,$Gender,$DOB,$Height,$Weight,$HairColor,$EyeColor,$BloodType,$Occupation,$MonthlyIncome,$FutureTargets,$FutureNeeds,$DOD,$Picture,$NIC,$Status)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson = new Person();
	
		$obj_newPerson->PersonId=$PersonId;
		$obj_newPerson->FullName=$FullName;
		$obj_newPerson->NickName=$NickName;
		$obj_newPerson->OtherNames=$OtherNames;
		$obj_newPerson->DrivingLicenceNo=$DrivingLicenceNo;
		$obj_newPerson->PassportNo=$PassportNo;
		$obj_newPerson->PermanentAddress=$PermanentAddress;
		$obj_newPerson->Email=$Email;
		$obj_newPerson->Website=$Website;
		$obj_newPerson->Description=$Description;
		$obj_newPerson->Gender=$Gender;
		$obj_newPerson->DOB=$DOB;
		$obj_newPerson->Height=$Height;
		$obj_newPerson->Weight=$Weight;
		$obj_newPerson->HairColor=$HairColor;
		$obj_newPerson->EyeColor=$EyeColor;
		$obj_newPerson->BloodType=$BloodType;
		$obj_newPerson->Occupation=$Occupation;
		$obj_newPerson->MonthlyIncome=$MonthlyIncome;
		$obj_newPerson->FutureTargets=$FutureTargets;
		$obj_newPerson->FutureNeeds=$FutureNeeds;
		$obj_newPerson->DOD=$DOD;
		$obj_newPerson->Picture=$Picture;
		$obj_newPerson->NIC=$NIC;
		$obj_newPerson->Status=$Status;

	   
        $issuccess = DAL_managePerson::updatePerson($obj_newPerson);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson::getPersonByPersonId($obj_newPerson->PersonId);
            $obj_retResult->msg = "Person updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPersonList()
    {
        $obj_retResult = DAL_managePerson::getPersonList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPersonList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson::getAllPerson($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson::searchPersonByPersonId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>PersonId</th>";
		$html .= "<th>FullName</th>";
		$html .= "<th>NickName</th>";
		$html .= "<th>OtherNames</th>";
		$html .= "<th>DrivingLicenceNo</th>";
		$html .= "<th>PassportNo</th>";
		$html .= "<th>PermanentAddress</th>";
		$html .= "<th>Email</th>";
		$html .= "<th>Website</th>";
		$html .= "<th>Description</th>";
		$html .= "<th>Gender</th>";
		$html .= "<th>DOB</th>";
		$html .= "<th>Height</th>";
		$html .= "<th>Weight</th>";
		$html .= "<th>HairColor</th>";
		$html .= "<th>EyeColor</th>";
		$html .= "<th>BloodType</th>";
		$html .= "<th>Occupation</th>";
		$html .= "<th>MonthlyIncome</th>";
		$html .= "<th>FutureTargets</th>";
		$html .= "<th>FutureNeeds</th>";
		$html .= "<th>DOD</th>";
		$html .= "<th>Picture</th>";
		$html .= "<th>NIC</th>";
		$html .= "<th>Status</th>";

		$html .= "</tr>";
		
            foreach ($arr_PersonList as $obj_Person)
            {               

                    $html .= $obj_Person->drawTableViewPerson(); 
                
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

	public static function deletePerson($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$PersonId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_PersonId =0;
			
			$retResult = BL_managePerson::getPersonListByPersonId($PersonId);
			if($retResult->type ==1)
			{
			
			$obj_Person = $retResult->data[0];			
			$obj_result2 = DAL_managePerson::deletePerson($obj_Person->PersonId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_PersonId = $obj_Person->PersonId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person->PersonId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getPersonListByPersonId($PersonId)
    {
        $obj_retResult = DAL_managePerson::getPersonListByPersonId($PersonId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson($PersonId,$ChildPersonId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson::getPersonListByPersonId($ChildPersonId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_PersonList = $obj_retResult->data;
				$obj_Person = $arr_PersonList[0];
				
				$arrParentIds = explode(",",$obj_Person->Url);
				
				foreach($arrParentIds as $PersonParentId)
				{
					if($PersonParentId == $PersonId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>