<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Person_educationlevel.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_managePerson_educationlevel.php");


class BL_managePerson_educationlevel
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_managePerson_educationlevel::addPerson_educationlevel($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_managePerson_educationlevel::deletePerson_educationlevel($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_managePerson_educationlevel::updatePerson_educationlevel($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addPerson_educationlevel($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newPerson_educationlevel = new Person_educationlevel();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newPerson_educationlevel->EducationLevelId = $packet[1];
		$obj_newPerson_educationlevel->SchoolId = $packet[2]== "" ? 0 :$packet[2];
		$obj_newPerson_educationlevel->StartYear = $packet[3];
		$obj_newPerson_educationlevel->StartClass = $packet[4];
		$obj_newPerson_educationlevel->EndYear = $packet[5];
		$obj_newPerson_educationlevel->EndClass = $packet[6];
		$obj_newPerson_educationlevel->PersonId = $packet[7];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Person_educationlevel = DAL_managePerson_educationlevel::addPerson_educationlevel($obj_newPerson_educationlevel);
            if ($obj_retResult_Person_educationlevel->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Person_educationlevel->data->wsGetPerson_educationlevelData();
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

    public static function addPerson_educationlevel2($EducationLevelId,$SchoolId,$StartYear,$StartClass,$EndYear,$EndClass,$PersonId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newPerson_educationlevel = new Person_educationlevel();
		
		$obj_newuser->setPerson_educationlevel($EducationLevelId,$SchoolId,$StartYear,$StartClass,$EndYear,$EndClass,$PersonId);
       // $isExist = BL_managePerson_educationlevel::isExist($obj_newPerson_educationlevel->id);

        if (!$isExist)
        {
            $obj_retResult_Person_educationlevel = DAL_managePerson_educationlevel::addPerson_educationlevel($obj_newPerson_educationlevel);
            if ($obj_retResult_Person_educationlevel->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Person_educationlevel->data;
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
            $obj_retResult->msg = "Sorry! Person_educationlevel already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_educationlevel($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Person_educationlevel = new Person_educationlevel();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Person_educationlevel->EducationLevelId = $packet[0];
		$obj_Person_educationlevel->SchoolId = $packet[1];
		$obj_Person_educationlevel->StartYear = $packet[2];
		$obj_Person_educationlevel->StartClass = $packet[3];
		$obj_Person_educationlevel->EndYear = $packet[4];
		$obj_Person_educationlevel->EndClass = $packet[5];
		$obj_Person_educationlevel->PersonId = $packet[6];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Person_educationlevel = DAL_managePerson_educationlevel::update($obj_Person_educationlevel);

        if ($obj_retResult_Person_educationlevel->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Person_educationlevel updation is Success";
			$retrunUserpacket = $obj_retResult_Person_educationlevel->data->wsGetPerson_educationlevelData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_educationlevel updation is Failed";
			$result_Person_educationlevel = DAL_managePerson_educationlevel::getPerson_educationlevelByEducationLevelId($obj_Person_educationlevel->EducationLevelId);
			if($result_Person_educationlevel->type ==1)
			{
			$retrunUserpacket = $result_Person_educationlevel->data->wsGetPerson_educationlevelData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updatePerson_educationlevel2($EducationLevelId,$SchoolId,$StartYear,$StartClass,$EndYear,$EndClass,$PersonId)
    {
        $obj_retResult = new returnResult();
        $obj_newPerson_educationlevel = new Person_educationlevel();
	
		$obj_newPerson_educationlevel->EducationLevelId=$EducationLevelId;
		$obj_newPerson_educationlevel->SchoolId=$SchoolId;
		$obj_newPerson_educationlevel->StartYear=$StartYear;
		$obj_newPerson_educationlevel->StartClass=$StartClass;
		$obj_newPerson_educationlevel->EndYear=$EndYear;
		$obj_newPerson_educationlevel->EndClass=$EndClass;
		$obj_newPerson_educationlevel->PersonId=$PersonId;

	   
        $issuccess = DAL_managePerson_educationlevel::updatePerson_educationlevel($obj_newPerson_educationlevel);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_managePerson_educationlevel::getPerson_educationlevelByEducationLevelId($obj_newPerson_educationlevel->EducationLevelId);
            $obj_retResult->msg = "Person_educationlevel updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Person_educationlevel updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getPerson_educationlevelList()
    {
        $obj_retResult = DAL_managePerson_educationlevel::getPerson_educationlevelList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getPerson_educationlevelList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_managePerson_educationlevel::getAllPerson_educationlevel($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_managePerson_educationlevel::searchPerson_educationlevelByEducationLevelId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Person_educationlevel List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>EducationLevelId</th>";
		$html .= "<th>SchoolId</th>";
		$html .= "<th>StartYear</th>";
		$html .= "<th>StartClass</th>";
		$html .= "<th>EndYear</th>";
		$html .= "<th>EndClass</th>";
		$html .= "<th>PersonId</th>";

		$html .= "</tr>";
		
            foreach ($arr_Person_educationlevelList as $obj_Person_educationlevel)
            {               

                    $html .= $obj_Person_educationlevel->drawTableViewPerson_educationlevel(); 
                
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

	public static function deletePerson_educationlevel($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$EducationLevelId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_EducationLevelId =0;
			
			$retResult = BL_managePerson_educationlevel::getPerson_educationlevelListByEducationLevelId($EducationLevelId);
			if($retResult->type ==1)
			{
			
			$obj_Person_educationlevel = $retResult->data[0];			
			$obj_result2 = DAL_managePerson_educationlevel::deletePerson_educationlevel($obj_Person_educationlevel->EducationLevelId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_EducationLevelId = $obj_Person_educationlevel->EducationLevelId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Person_educationlevel";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Person_educationlevel you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Person_educationlevel->EducationLevelId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_educationlevelListByPersonId($personId)
    {
        $obj_retResult = DAL_managePerson_educationlevel::getPerson_educationlevelListByPersonId($personId);
        return $obj_retResult;
    }
    //---------------------------------------------------------------------------------------------------------

    public static function getPerson_educationlevelListByEducationLevelId($EducationLevelId)
    {
        $obj_retResult = DAL_managePerson_educationlevel::getPerson_educationlevelListByEducationLevelId($EducationLevelId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildPerson_educationlevel($EducationLevelId,$ChildEducationLevelId)
    {
    	$ischild = false;
        $obj_retResult = DAL_managePerson_educationlevel::getPerson_educationlevelListByEducationLevelId($ChildEducationLevelId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_Person_educationlevelList = $obj_retResult->data;
				$obj_Person_educationlevel = $arr_Person_educationlevelList[0];
				
				$arrParentIds = explode(",",$obj_Person_educationlevel->Url);
				
				foreach($arrParentIds as $Person_educationlevelParentId)
				{
					if($Person_educationlevelParentId == $EducationLevelId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>