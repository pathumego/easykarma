<?php

class config
{
	
	
    public static function dbconfig()
    {
        $database = 'easykarm_vprofile';
        $user = 'easykarm_vpuser';
        $pass = 'vp#098';
        $server = 'localhost';
        

        $conn = mysql_connect($server,$user, $pass) or die ('Could not connect to mysql server.');
        mysql_select_db($database, $conn) or die ('Could not select database.');
        return $conn;
    }
	
	
	
	public static function avatarPath()
	{
		$avatarPath = "Item/";
		return $avatarPath;
	}
	
	public static function defaultAvatarPath()
	{		
		$defualAvatarPath = config::avatarPath();
		$defualAvatarPath .= "default.png";
		return $defualAvatarPath;
	}
	
	public static function emailTemplatePath()
	{
		$templatePath = "email/emailTemplate/";
		return $templatePath;
	}
	

		
	public static function mailConfiguration()
	{
		$arr_mainconfiguration = array(
		"mailer"=>"smtp",
		"host"=>"smtp.gmail.com",
		"port"=>465,
		"smtpsecure"=>"ssl",
		"smtpauth"=>true,
		"smtpkeepalive"=>true,
		"username"=>"wijeey@gmail.com",
		"password"=>"jj",
		"from"=>"wijeey@gmail.com",
		"fromName"=>"tozzcard.com"
		);
		
		return $arr_mainconfiguration;
	}
	
	public static function isAnimationEnabled()
	{
		$isEnabled = true;
		return $isEnabled;
	}

	public static function dropdown_person_gender()
	{
	return array(0=> "Male",1=> "Female");
	
	}
	
	public static function dropdown_person_bloodtype()
	{
	return array(
	"A"=> "A",
	"B"=> "B",
	"AB"=> "AB",
	"O"=> "O"
	);
	}
	
	public static function dropdown_person_addresstype()
	{
	return array(
	0=> "Primary",
	1=> "Optional"
	);
	}

}
?>