<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Business.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageBusiness.php");


class BL_manageBusiness
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageBusiness::addBusiness($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageBusiness::deleteBusiness($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageBusiness::updateBusiness($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addBusiness($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newBusiness = new Business();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newBusiness->BusinessId = $packet[1];
		$obj_newBusiness->Name = $packet[2];
		$obj_newBusiness->Description = $packet[3];
		$obj_newBusiness->Address = $packet[4];
		$obj_newBusiness->telephone = $packet[5];
		$obj_newBusiness->fax = $packet[6];
		$obj_newBusiness->website = $packet[7];
		$obj_newBusiness->email = $packet[8];
		$obj_newBusiness->BusinessTypeId = $packet[9];
		$obj_newBusiness->BusinessSubTypeId = $packet[10];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Business = DAL_manageBusiness::addBusiness($obj_newBusiness);
            if ($obj_retResult_Business->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Business->data->wsGetBusinessData();
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

    public static function addBusiness2($BusinessId,$Name,$Description,$Address,$telephone,$fax,$website,$email,$BusinessTypeId,$BusinessSubTypeId)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newBusiness = new Business();
		
		$obj_newuser->setBusiness($BusinessId,$Name,$Description,$Address,$telephone,$fax,$website,$email,$BusinessTypeId,$BusinessSubTypeId);
       // $isExist = BL_manageBusiness::isExist($obj_newBusiness->id);

        if (!$isExist)
        {
            $obj_retResult_Business = DAL_manageBusiness::addBusiness($obj_newBusiness);
            if ($obj_retResult_Business->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Business->data;
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
            $obj_retResult->msg = "Sorry! Business already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateBusiness($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Business = new Business();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Business->BusinessId = $packet[0];
		$obj_Business->Name = $packet[1];
		$obj_Business->Description = $packet[2];
		$obj_Business->Address = $packet[3];
		$obj_Business->telephone = $packet[4];
		$obj_Business->fax = $packet[5];
		$obj_Business->website = $packet[6];
		$obj_Business->email = $packet[7];
		$obj_Business->BusinessTypeId = $packet[8];
		$obj_Business->BusinessSubTypeId = $packet[9];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Business = DAL_manageBusiness::update($obj_Business);

        if ($obj_retResult_Business->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Business updation is Success";
			$retrunUserpacket = $obj_retResult_Business->data->wsGetBusinessData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Business updation is Failed";
			$result_Business = DAL_manageBusiness::getBusinessByBusinessId($obj_Business->BusinessId);
			if($result_Business->type ==1)
			{
			$retrunUserpacket = $result_Business->data->wsGetBusinessData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateBusiness2($BusinessId,$Name,$Description,$Address,$telephone,$fax,$website,$email,$BusinessTypeId,$BusinessSubTypeId)
    {
        $obj_retResult = new returnResult();
        $obj_newBusiness = new Business();
	
		$obj_newBusiness->BusinessId=$BusinessId;
		$obj_newBusiness->Name=$Name;
		$obj_newBusiness->Description=$Description;
		$obj_newBusiness->Address=$Address;
		$obj_newBusiness->telephone=$telephone;
		$obj_newBusiness->fax=$fax;
		$obj_newBusiness->website=$website;
		$obj_newBusiness->email=$email;
		$obj_newBusiness->BusinessTypeId=$BusinessTypeId;
		$obj_newBusiness->BusinessSubTypeId=$BusinessSubTypeId;

	   
        $issuccess = DAL_manageBusiness::updateBusiness($obj_newBusiness);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageBusiness::getBusinessByBusinessId($obj_newBusiness->BusinessId);
            $obj_retResult->msg = "Business updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Business updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getBusinessList()
    {
        $obj_retResult = DAL_manageBusiness::getBusinessList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getBusinessList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageBusiness::getAllBusiness($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageBusiness::searchBusinessByBusinessId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Business List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>BusinessId</th>";
		$html .= "<th>Name</th>";
		$html .= "<th>Description</th>";
		$html .= "<th>Address</th>";
		$html .= "<th>telephone</th>";
		$html .= "<th>fax</th>";
		$html .= "<th>website</th>";
		$html .= "<th>email</th>";
		$html .= "<th>BusinessTypeId</th>";
		$html .= "<th>BusinessSubTypeId</th>";

		$html .= "</tr>";
		
            foreach ($arr_BusinessList as $obj_Business)
            {               

                    $html .= $obj_Business->drawTableViewBusiness(); 
                
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

	public static function deleteBusiness($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$BusinessId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_BusinessId =0;
			
			$retResult = BL_manageBusiness::getBusinessListByBusinessId($BusinessId);
			if($retResult->type ==1)
			{
			
			$obj_Business = $retResult->data[0];			
			$obj_result2 = DAL_manageBusiness::deleteBusiness($obj_Business->BusinessId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_BusinessId = $obj_Business->BusinessId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Business";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Business you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Business->BusinessId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getBusinessListByBusinessId($BusinessId)
    {
        $obj_retResult = DAL_manageBusiness::getBusinessListByBusinessId($BusinessId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildBusiness($BusinessId,$ChildBusinessId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageBusiness::getBusinessListByBusinessId($ChildBusinessId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_BusinessList = $obj_retResult->data;
				$obj_Business = $arr_BusinessList[0];
				
				$arrParentIds = explode(",",$obj_Business->Url);
				
				foreach($arrParentIds as $BusinessParentId)
				{
					if($BusinessParentId == $BusinessId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>