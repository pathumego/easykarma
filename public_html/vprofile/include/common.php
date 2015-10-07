<?php
//require_once("BL/BL_manageUser_role.php");
//require_once("BL/BL_manageUser_station.php");
class common
{
/*
public static function checkPermission($ActionId, $StationId)
{
	
	//temp fix
	if(($_SESSION["stationid"] != 1)&&(($ActionId == ROLEMANAGE_ACTIONID_VIEW)||($ActionId == PERMISSION_ACTIONID_VIEW)||($ActionId == LOAN_ACTIONID_VIEW)))
	{
		
		return false;
	}
	
	
	
	
	
	
	
	return true;
	$obj_me = unserialize($_SESSION["user"]);
	if(BL_manageUser_role::hasUserPermission($obj_me->UserId,$ActionId))
	{
		
		//check station view permission
		$stationPermission = false;
		$obj_result = BL_manageUser_station::getUser_stationListByUserId($obj_me->UserId);
		if($obj_result->type ==1)
		{
			$arr_stationList = $obj_result->data;
			foreach($arr_stationList as $obj_Station)
			{
				if($obj_Station->StationId == $StationId)
				{					
					$stationPermission = true;
				}
							
			}
			
			if(!$stationPermission)
			{
				//check if this is a child node
				foreach($arr_stationList as $obj_Station)
				{
					if(isChildStation($obj_Station->StationId,$StationId))
					{					
						$stationPermission = true;	
					}
				}
				
			}
			
		}

		return $stationPermission;
		
		
	}
	
	
	
}

*/
//-----------------------------------------------------------------

public static function noSqlInject($text)
{
	return str_replace("'", "''",$text);
}

//-----------------------------------------------------------------

    public static function readFile($fileName_)
    {
        try
        {
            $handle = @fopen($fileName_, "r");
            $filestr = "";

            if ($handle)
            {
                while (!feof($handle))
                {
                    $filestr .= fgets($handle);
                }
            }
            fclose($handle);
        }
        catch(Exception $ex)
        {

        }
        return $filestr;

    }
	
	public static function encodeSpText($MessageText)
	{
			   $MessageText =  str_replace(",","&coma",$MessageText);
		return $MessageText =  str_replace(";","&colan",$MessageText);
	}
	
	public static function decodeSpText($MessageText)
	{
			   $MessageText =  str_replace("&coma",",",$MessageText);
		return $MessageText =  str_replace("&colan",";",$MessageText);
	}
	
	public static function sqlescapequote($MessageText)
	{	
		return $MessageText =  str_replace("'","''",$MessageText);
	}
	
	public static function get_user_browser()
	{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if(preg_match('/MSIE/i',$u_agent))
    {
        $ub = "ie";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $ub = "firefox";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $ub = "safari";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $ub = "chrome";
    }
    elseif(preg_match('/Flock/i',$u_agent))
    {
        $ub = "flock";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $ub = "opera";
    }
   
    return $ub;
} 

}
?>