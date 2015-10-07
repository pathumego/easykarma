<?php

require_once("BL/BL_manageUser.php");

function login($_POST,$_GET)
{
    $Username;
    $Password;
    $errorCode = 0;

    if ( isset ($_POST['login']))
    {

        if ( isset ($_POST["Username"]) && !is_null($_POST["Username"]))
        {
            $Username = $_POST["Username"];
        }
        else
        {
            $errorCode = 1;
            $errormsg = "<span class=\"error\">please enter Username<span><br/>";
        }

        if ( isset ($_POST["Password"]) && !is_null($_POST["Password"]))
        {
            $Password = $_POST["Password"];
        }
        else
        {
            $errorCode = 2;
            $errormsg .= "<span class=\"error\">Please enter Password<span><br/>";
        }

        if ($errorCode > 0)
        {
            $_SESSION["loginerror"] = $errormsg;
        }
        else
        {

            $obj_result = BL_manageUser::authenticateUser($Username, $Password);

            if ($obj_result->type == 0)
            {

                $_SESSION["login"] = 0;
                $_SESSION["loginerror"] = $obj_result->msg;
            }
            else
            {
            	$obj_User = $obj_result->data;
print_r($obj_User);
				if($obj_User->userStatus ==1)
				{
                $_SESSION["login"] = 1;				
                $_SESSION["user"] = serialize($obj_User);
				}
				else if($obj_User->userStatus ==0)
				{
				$_SESSION["login"] = 0;
                $_SESSION["loginerror"] = "Sorry, your account is not verified yet.";
				}
				
			
            }
        }

    }
	else
	{
		$errorCode = 0;
		$optCode;
		$userId;
		if ( isset ($_GET["optcode"]) && !is_null($_GET["optcode"]))
        {
            $optCode = $_GET["optcode"];
        }
        else
        {
            $errorCode = 1;
          //  $errormsg = "<span class=\"error\">Error in opt-code<span><br/>";
        }

        if ( isset ($_GET["userid"]) && !is_null($_GET["userid"]))
        {
            $userId = $_GET["userid"];
        }
		else
        {
            $errorCode = 2;
           // $errormsg = "<span class=\"error\">Error in email verification<span><br/>";
        }
		
		 if ($errorCode > 0)
        {
        	if($errorCode != 1)
			{
            $_SESSION["loginerror"] = $errormsg;
			}
        }
        else
        {
        	
		$obj_result = BL_manageUser::authOptCode($userId, $optCode);
		
		if ($obj_result->type == 1)
            {
            	$obj_user = $obj_result->data;
				
				if($obj_user->userStatus == 0)
				{
				$_SESSION["login"] = 1;				
                $_SESSION["user"] = serialize($obj_user);	
				}
				else
				{
				$_SESSION["login"] = 0;
                $_SESSION["loginerror"] = "Your account is already verified"; 
				}
               
            }
            else
            {
            	$_SESSION["login"] = 0;
                $_SESSION["loginerror"] = $obj_result->msg;               			
			
            }
			
		}
	}

}

function logout()
{
    unset ($_SESSION["login"]);
    unset ($_SESSION["user"]);
	unset ($_SESSION["loginerror"]);
	unset ($_COOKIE['mfi123']);
	unset ($_COOKIE['stationid']);
}
?>
