<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/Language.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageLanguage.php");


class BL_manageLanguage
{

//---------------------------------------------------------------------------------------------------------

public static function onIncommingMessage($obj_mainpacket)
{
switch($obj_mainpacket->actionId)
    {

        case 201:
            {
                BL_manageLanguage::addLanguage($obj_mainpacket);
                break;
            }
        case 202:
            {
                BL_manageLanguage::deleteLanguage($obj_mainpacket);
                break;
            }
        case 203:
            {
                BL_manageLanguage::updateLanguage($obj_mainpacket);
                break;
            }


    }
	
}
	
//---------------------------------------------------------------------------------------------------------

    public static function addLanguage($obj_mainpacket)
    {
    	$result = 0;
        $fieldDataId = -1;
		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_newLanguage = new Language();
		if (count($packet) >= 2)//check packet length
        {
		$dummyId =$packet[0];
		$obj_newLanguage->LangId = $packet[1];
		$obj_newLanguage->LangTag = $packet[2];
		$obj_newLanguage->English = $packet[3];
		$obj_newLanguage->Sinhala = $packet[4];
		$obj_newLanguage->Tamil = $packet[5];
		$obj_newLanguage->Bangla = $packet[6];
		$obj_newLanguage->Nepali = $packet[7];
		$obj_newLanguage->Lang1 = $packet[8];
		$obj_newLanguage->Lang2 = $packet[9];
		$obj_newLanguage->Lang3 = $packet[10];

  

		 // $isExist = BL_manageUser::isExist($obj_newUser->id);

       // if (!$isExist)
       // {
            $obj_retResult_Language = DAL_manageLanguage::addLanguage($obj_newLanguage);
            if ($obj_retResult_Language->type ==1)
            {
  	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$retrunUserpacket = $obj_retResult_Language->data->wsGetLanguageData();
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

    public static function addLanguage2($LangId,$LangTag,$English,$Sinhala,$Tamil,$Bangla,$Nepali,$Lang1,$Lang2,$Lang3)
    {
    	
		
        $obj_retResult = new returnResult();
        $obj_newLanguage = new Language();
		
		$obj_newLanguage->setLanguage($LangId,$LangTag,$English,$Sinhala,$Tamil,$Bangla,$Nepali,$Lang1,$Lang2,$Lang3);
       // $isExist = BL_manageLanguage::isExist($obj_newLanguage->id);

        if (!$isExist)
        {
            $obj_retResult_Language = DAL_manageLanguage::addLanguage($obj_newLanguage);
            if ($obj_retResult_Language->type ==1)
            {
            	
	            $obj_retResult->type = 1;
                $obj_retResult->msg = "Success";
				$obj_retResult->data = $obj_retResult_Language->data;
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
            $obj_retResult->msg = "Sorry! Language already exist";
        }

        return $obj_retResult;

    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateLanguage($obj_mainpacket)
    {

		$retrunUserpacket = array();
        $packet = $obj_mainpacket->packet;
		$obj_Language = new Language();
		if (count($packet) >= 2)//check packet length
        {
		$obj_Language->LangId = $packet[0];
		$obj_Language->LangTag = $packet[1];
		$obj_Language->English = $packet[2];
		$obj_Language->Sinhala = $packet[3];
		$obj_Language->Tamil = $packet[4];
		$obj_Language->Bangla = $packet[5];
		$obj_Language->Nepali = $packet[6];
		$obj_Language->Lang1 = $packet[7];
		$obj_Language->Lang2 = $packet[8];
		$obj_Language->Lang3 = $packet[9];

        $obj_retResult = new returnResult();
       

       
        $obj_retResult_Language = DAL_manageLanguage::update($obj_Language);

        if ($obj_retResult_Language->type ==1)
        {
            $obj_retResult->type = 1;
            $obj_retResult->msg = "Language updation is Success";
			$retrunUserpacket = $obj_retResult_Language->data->wsGetLanguageData();
        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Language updation is Failed";
			$result_Language = DAL_manageLanguage::getLanguageByLangId($obj_Language->LangId);
			if($result_Language->type ==1)
			{
			$retrunUserpacket = $result_Language->data->wsGetLanguageData();
			}
        }

       	$returnPacket = array ($obj_retResult->type,$obj_retResult->msg);
		$returnPacket = array_merge($returnPacket, $retrunUserpacket);
		$obj_mainpacket->returnValues = $returnPacket;
        $obj_mainpacket->main_setPacket();
    	}
    }

    //---------------------------------------------------------------------------------------------------------

    public static function updateLanguage2($LangId,$LangTag,$English,$Sinhala,$Tamil,$Bangla,$Nepali,$Lang1,$Lang2,$Lang3)
    {
        $obj_retResult = new returnResult();
        $obj_newLanguage = new Language();
	
		$obj_newLanguage->LangId=$LangId;
		$obj_newLanguage->LangTag=$LangTag;
		$obj_newLanguage->English=$English;
		$obj_newLanguage->Sinhala=$Sinhala;
		$obj_newLanguage->Tamil=$Tamil;
		$obj_newLanguage->Bangla=$Bangla;
		$obj_newLanguage->Nepali=$Nepali;
		$obj_newLanguage->Lang1=$Lang1;
		$obj_newLanguage->Lang2=$Lang2;
		$obj_newLanguage->Lang3=$Lang3;

	   
        $issuccess = DAL_manageLanguage::update($obj_newLanguage);

        if ($issuccess)
        {
            $obj_retResult->type = 1;
		//	$obj_retResult->data = BL_manageLanguage::getLanguageByLangId($obj_newLanguage->LangId);
            $obj_retResult->msg = "Language updation is Success";

        }
        else
        {
            $obj_retResult->type = 0;
            $obj_retResult->msg = "Language updation is Failed";
        }

        return $obj_retResult;
    }
	
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getLanguageList()
    {
        $obj_retResult = DAL_manageLanguage::getLanguageList();
        return $obj_retResult;
    }
	
	//---------------------------------------------------------------------------------------------------------  
       public static function getLanguageListByName($lang)
    {
        $obj_retResult = DAL_manageLanguage::getLanguageListByName($lang);
        return $obj_retResult->data;
    }
	
	//---------------------------------------------------------------------------------------------------------  
	
	public static function getLanguageList2($searchtext,$page)
    {
    	
		$pagestart = $page ==0 ? 0 : ($page-1) * 5;
		$pageEnd = $page * 5;
    	if((strtolower($searchtext) == "search")||($searchtext == ""))
		{
			$obj_retResult =DAL_manageLanguage::getAllLanguage($pagestart,$pageEnd);
		}
		else
		{
//*			$obj_retResult = BL_manageLanguage::searchLanguageByLangId($searchtext);
		}
        
        $html = "<div class=\"subheader\" >Language List</div>";
        if ($obj_retResult->type == 1)
        {
            $arr_userList = $obj_retResult->data;


		$html .= "<div ><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
		$html .= "<th></th>";
		
		$html .= "<th>LangId</th>";
		$html .= "<th>LangTag</th>";
		$html .= "<th>English</th>";
		$html .= "<th>Sinhala</th>";
		$html .= "<th>Tamil</th>";
		$html .= "<th>Bangla</th>";
		$html .= "<th>Nepali</th>";
		$html .= "<th>Lang1</th>";
		$html .= "<th>Lang2</th>";
		$html .= "<th>Lang3</th>";

		$html .= "</tr>";
		
            foreach ($arr_LanguageList as $obj_Language)
            {               

                    $html .= $obj_Language->drawTableViewLanguage(); 
                
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

	public static function deleteLanguage($obj_mainpacket)
		{
					
			$packet = $obj_mainpacket->packet;
			$LangId = $packet[0];
			$msg = "failed";
			$result = 0;
			$result_LangId =0;
			
			$retResult = DAL_manageLanguage::getLanguageListByLangId($LangId);
			if($retResult->type ==1)
			{
			
			$obj_Language = $retResult->data[0];			
			$obj_result2 = DAL_manageLanguage::deleteLanguage($obj_Language->LangId);
			
				if($obj_result2->type ==1)
				{					
					$result = 1;
					$result_LangId = $obj_Language->LangId;
					$msg = "success";
				}
				else
				{							
					$msg = "Sorry!!! Problem occured while deleting this Language";
				}
					
			}
			else
				{
					$msg = "Sorry!!! The Language you are tring to delete is not found";
					
				}					

		$obj_mainpacket->returnValues = array($result,$obj_Language->LangId,$msg);
        $obj_mainpacket->main_setPacket();
		
	
		}

    //---------------------------------------------------------------------------------------------------------

    public static function getLanguageListByLangId($LangId)
    {
        $obj_retResult = DAL_manageLanguage::getLanguageListByLangId($LangId);
        return $obj_retResult;
    }

    //---------------------------------------------------------------------------------------------------------

    public static function isChildLanguage($LangId,$ChildLangId)
    {
    	$ischild = false;
        $obj_retResult = DAL_manageLanguage::getLanguageListByLangId($ChildLangId); //get child node
		if($obj_retResult->type ==1)
		{
				$arr_LanguageList = $obj_retResult->data;
				$obj_Language = $arr_LanguageList[0];
				
				$arrParentIds = explode(",",$obj_Language->Url);
				
				foreach($arrParentIds as $LanguageParentId)
				{
					if($LanguageParentId == $LangId)
					{
						
						$ischild = true;
					}
				}			
				
		}
			
		
		
        return $ischild;
    }
	
}
?>