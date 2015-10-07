<?php
require_once ("include/common.php");
function loadLogin()
{
global $LANG;
	define("LOGIN_EMAIL", "User name");
	define("LOGIN_PASSWORD", "Password");
	define("LOGIN_RECOVERPASSWORD", "Recover password");

?>
<div class="common_body_content clearfix" >
<div class="subheader">Login</div>
<div >
	<div class="site_login_area2"></div>
		<div class="site_login_area">
    			<form id="loginform" name="loginform" action="?page=login" method="post" onsubmit="return validate_login(this);">
       				 <div id="loginerror" class="error_msg">
            		<?php echo $_SESSION["loginerror"];?>
        			</div>
					
					
        			<input type="text" id="Username" name="Username" value="<?php echo LOGIN_EMAIL ?>" class="login_area_textbox" onkeydown="this.value = this.value == '<?php echo LOGIN_EMAIL ?>'?this.value='':this.value;" onmousedown="this.value = this.value == '<?php echo LOGIN_EMAIL ?>'?this.value='':this.value;this.focus();" onblur="this.value =this.value == ''?this.value='<?php echo LOGIN_EMAIL ?>':this.value ;">
					<input
        				<?php
        				$browser = common::get_user_browser();
        				if ($browser == "firefox" || $browser == "safari")
       						{
            				echo "type=\"text\"";
        					}
        					else
        					{
           					 echo "type=\"password\"";
        					}
        					?>
 					id="Password" name="Password" value="<?php echo LOGIN_PASSWORD ?>" class="login_area_textbox" onkeydown="this.value = this.value == '<?php echo LOGIN_PASSWORD ?>'?this.value='':this.value;this.type='<?php echo LOGIN_PASSWORD ?>';this.focus();" onmousedown="this.value = this.value == '<?php echo LOGIN_PASSWORD ?>'?this.value='':this.value;this.focus();this.type='<?php echo LOGIN_PASSWORD ?>';" onfocus="this.value =this.value == '<?php echo LOGIN_PASSWORD ?>'?this.value='':this.value ;" onblur="this.value =this.value == ''?this.value='<?php echo LOGIN_PASSWORD ?>':this.value ;">
 					
				
 					<input type="submit" id="login" name="login" value="Login" class="common_button">

 				</form>
 				<!--<div class="logout" ><a href="?page=passwordrecover" ><?php echo LOGIN_RECOVERPASSWORD ?></a></div>-->
  		</div>
  		
</div>

</div>
		
		
		
        <?php
        
        unset ($_SESSION["loginerror"]);
        }
?>
