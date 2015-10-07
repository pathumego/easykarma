<?php
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/retResult.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../BL/BL_manageUser.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../include/serviceSession.php");
require_once(str_replace('//','/',dirname(__FILE__).'/') ."../DAL/DAL_manageWebService.php");
class BL_manageWebService
{

//---------------------------------------------------------------------------------------------------------

public function webservice_authentication($email, $password)
{
$obj_fnlResult = new returnResult();

$obj_userResult = BL_manageUser::authenticateUser($email, $password);
$sessionkey = "";
$isValid = 0;
$msg = "";
            if ($obj_userResult->type == 0)
            {
				$obj_fnlResult->type =0;
                $obj_fnlResult->msg = $obj_userResult->msg;
								
            }
            else
            {
			
            	$obj_user = $obj_userResult->data;

				if($obj_user->userStatus ==1)
				{

					$isValid = 1;
                	$errorMsg =$obj_userResult->msg;
					$sess_result = BL_manageWebService::validateSessionByUserId($obj_user->userId);
					$obj_fnlResult->type =1;
					
					
					if($sess_result->type ==1)
					{
						$isValid = 1;
						$sessionkey = $sess_result->data->sessionKey;
						$msg = "Successfuly joined to session which already created";						
						$obj_fnlResult->data = array('validstatus' => $isValid,'sessionkey' =>$sessionkey,'message' =>$msg);
					}
					else
						{
							$obj_newsessResult = DAL_manageWebService::addNewSessionKey($obj_user->email, $obj_user->userId, BL_manageWebService::generateSessionKey());
							if($obj_newsessResult->type ==1)
							{
								$isValid = 1;
								$sessionkey = $obj_newsessResult->data;
								$msg = "New session successfuly created";
								$obj_fnlResult->data = array('validstatus' => $isValid,'sessionkey' =>$sessionkey,'message' =>$msg);
							}
							else
								{
								$isValid = 0;
								$msg = "Problem occured while creating new session";
								$obj_fnlResult->data = array('validstatus' => $isValid,'sessionkey' =>$sessionkey,'message' =>$msg);
								}
														
						}					
								
				}
				else if($obj_user->userStatus ==0)
				{
					$isValid = 0;
					$errorMsg ="Sorry, your account is not verified yet.";				
					$obj_fnlResult->type =1;
				}
				
			
            }

			return $obj_fnlResult;
			
			 
}

//---------------------------------------------------------------------------------------------------------

public function validateSessionByUserId($userId)
{	

  $obj_retResult = new returnResult();
  $obj_retResult->type = 0;
  
  $obj_result = DAL_manageWebService::getSessionKeyByUserId($userId);

  if($obj_result->type ==1)
  {
  	$obj_wsCall = $obj_result->data;
	$nowTime = time(); 	
	$lastUpdateTime = strtotime($obj_wsCall->lastUpdateTime);
	$lastUpdateTime = $lastUpdateTime+(1*60*60); //1 hour	
	
	if($lastUpdateTime < $nowTime)
	{
		$obj_retResult->error ="Your session has expired";		
	}
	else
  	{
  		$obj_retResult->type = 1;
		$obj_retResult->data = $obj_wsCall;
  		$obj_retResult->msg ="Valid session";		
		DAL_manageWebService::updateSessionLastUpdateTimeById($obj_wsCall->id);
  	}
	
  }
 
	return $obj_retResult;		
	
}

//---------------------------------------------------------------------------------------------------------

public function validateSession($sessionKey)
{	

  $obj_retResult = new returnResult();
  $obj_retResult->type = 0;
  
  $obj_result = DAL_manageWebService::getSessionKey($sessionKey);
  
  if($obj_result->type ==1)
  {
  	$obj_serviceSession = $obj_result->data;
	$nowTime = time(); 	
	$lastUpdateTime = strtotime($obj_serviceSession->lastUpdateTime);
	$lastUpdateTime = $lastUpdateTime+(1*60*60); //1 hour
	
	if($lastUpdateTime < $nowTime)
	{
		$obj_retResult->msg ="Your session has expired";		
	}
	else
  	{
  		$obj_retResult->type = 1;
		$obj_retResult->data = $obj_serviceSession;
  		$obj_retResult->msg ="Valid session";	
			
		DAL_manageWebService::updateSessionTime($sessionKey);
  	}
	
  }
	return $obj_retResult;		
	
}

//---------------------------------------------------------------------------------------------------------

private function generateSessionKey()
{
	$newSessionKey = uniqid();
	return md5($newSessionKey);
}

}
?>