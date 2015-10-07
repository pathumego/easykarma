<?php

require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Businesstype.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageBusinesstype.php");


class BL_manageBusinesstype
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageBusinesstype::addBusinesstype($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageBusinesstype::deleteBusinesstype($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageBusinesstype::updateBusinesstype($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addBusinesstype($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newBusinesstype = new Businesstype();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newBusinesstype->BusinessTypeId = $packet[1];
		$obj_newBusinesstype->BusinessTypeName = $packet[2];
		$obj_newBusinesstype->Description = $packet[3];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Businesstype = DAL_manageBusinesstype::addBusinesstype($obj_newBusinesstype);
            if ($obj_retResult_Businesstype->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Businesstype->data->wsGetBusinesstypeData();
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

    public static function addBusinesstype2($BusinessTypeId,$BusinessTypeName,$Description)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newBusinesstype = new Businesstype();
		
		$obj_newuser->setBusinesstype($BusinessTypeId,$BusinessTypeName,$Description);
       // $isExist = BL_manageBusinesstype::isExist($obj_newBusinesstype->id);

        if (!$isExist)
        {
            $obj_retResult_Businesstype = DAL_manageBusinesstype::addBusinesstype($obj_newBusinesstype);
            if ($obj_retResult_Businesstype->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Businesstype->data;
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
            $obj_retResult->msg = "Sorry! Businesstype already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateBusinesstype($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Businesstype = new Businesstype();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Businesstype->BusinessTypeId = $packet[0];
		$obj_Businesstype->BusinessTypeName = $packet[1];
		$obj_Businesstype->Description = $packet[2];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Businesstype = DAL_manageBusinesstype::update($obj_Businesstype);

        if ($obj_retResult_Businesstype->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Businesstype updation is Success";
			$retrunUserpacket = $obj_retResult_Businesstype->data->wsGetBusinesstypeData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Businesstype updation is Failed";
			$result_Businesstype = DAL_manageBusinesstype::getBusinesstypeByBusinessTypeId($obj_Businesstype->BusinessTypeId);
			if($result_Businesstype->type ==1)
			{
			$retrunUserpacket = $result_Businesstype->data->wsGetBusinesstypeData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateBusinesstype2($BusinessTypeId,$BusinessTypeName,$Description)
    {
        $obj_retResult = new returnResult();
        $obj_newBusinesstype = new Businesstype();
	
		$obj_newBusinesstype->BusinessTypeId=$BusinessTypeId;
		$obj_newBusinesstype->BusinessTypeName=$BusinessTypeName;
		$obj_newBusinesstype->Description=$Description;

	   
        $issuccess = DAL_manageBusinesstype::updateBusinesstype($obj_newBusinesstype);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageBusinesstype::getBusinesstypeByBusinessTypeId($obj_newBusinesstype->BusinessTypeId);
            $obj_retResult->msg = "Businesstype updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Businesstype updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getBusinesstypeList()
    {
        $obj_retResult = DAL_manageBusinesstype::getBusinesstypeList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getBusinesstypeList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageBusinesstype::getAllBusinesstype($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageBusinesstype::searchBusinesstypeByBusinessTypeId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Businesstype List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>BusinessTypeId</th>";
		$html .= "<th>BusinessTypeName</th>";
		$html .= "<th>Description</th>";

		$html .= "</tr>";
		
            foreach ($arr_BusinesstypeList as $obj_Businesstype)
            {               

                    $html .= $obj_Businesstype->drawTableViewBusinesstype(); 
                
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

	public static function deleteBusinesstype($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$BusinessTypeId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_BusinessTypeId =0;
			
			$retResult = BL_manageBusinesstype::getBusinesstypeListByBusinessTypeId($BusinessTypeId);
			if($retResult->type ==1)
			{
			
			$obj_Businesstype = $retResult->data[0];			
			$obj_result2 = DAL_manageBusinesstype::deleteBusinesstype($obj_Businesstype->BusinessTypeId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_BusinessTypeId = $obj_Businesstype->BusinessTypeId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Businesstype";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Businesstype you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Businesstype->BusinessTypeId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getBusinesstypeListByBusinessTypeId($BusinessTypeId)
    {
        $obj_retResult = DAL_manageBusinesstype::getBusinesstypeListByBusinessTypeId($BusinessTypeId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildBusinesstype($BusinessTypeId,$ChildBusinessTypeId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageBusinesstype::getBusinesstypeListByBusinessTypeId($ChildBusinessTypeId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_BusinesstypeList = $obj_retResult->data;
				$obj_Businesstype = $arr_BusinesstypeList[0];
				
				$arrParentIds = explode(",",$obj_Businesstype->Url);
				
				foreach($arrParentIds as $BusinesstypeParentId)
				{
					if($BusinesstypeParentId == $BusinessTypeId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}

?>