<?php

//----------------------------------------------------------------------------------------------

function loadHeader($arrFilesToLoad)
{
global $LANG;
$headerhtml = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
$headerhtml .= "<html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\">";
$headerhtml .= "<link rel=\"shortcut icon\" href=\"favicon.ico\" />";
$headerhtml .= "<link rel=\"icon\" type=\"image/gif\" href=\"\" />";
$headerhtml .= "<meta name=\"description\" content=\"\" />";
$headerhtml .= "<meta name=\"keywords\" content=\"virtual shopping\" /><head><title>:. V-Book .:</title>";
$obj_me = unserialize($_SESSION["user"]);
    foreach ($arrFilesToLoad as $arrfile)
    {

        if (count($arrfile) > 1)
        {

            switch($arrfile[0])
            {
                case "script":
                    {

                        $headerhtml .= loadScriptfiles($arrfile);
                        break;

                    }
                case "style":
                    {
                        $headerhtml .= loadStylefiles($arrfile);
                        break;

                    }

            }

        }

    }


    $headerhtml .= "</head><body>";
	$headerhtml .= "<div class=\"common_site_header clearfix\">";
	$headerhtml .= "<div class=\"site_title\">V&nbsp;&nbsp;i&nbsp;&nbsp;r&nbsp;&nbsp;t&nbsp;&nbsp;u&nbsp;&nbsp;a&nbsp;&nbsp;l&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;V&nbsp;&nbsp;i&nbsp;&nbsp;l&nbsp;&nbsp;l&nbsp;&nbsp;a&nbsp;&nbsp;g&nbsp;&nbsp;e&nbsp;&nbsp;-&nbsp;&nbsp;B&nbsp;&nbsp;o&nbsp;&nbsp;o&nbsp;&nbsp;k</div><img src=\"images/logo.png\"/>";
	$headerhtml .= "<div class=\"common_topright\" ><ul>";
	if ($_SESSION["login"] == 1){
//	$headerhtml .= "<li>".$_SESSION["user"]->userName."</li>";
	$headerhtml .= "<li><a class=\"logout2\" href=\"?page=logout\">Logout</a></li>";
	}
	$headerhtml .= "<li><a class=\"lang\" onclick=\"setLanguage('English');\" href=\"#\">English</a></li>";
	$headerhtml .= "<li><a class=\"lang\" onclick=\"setLanguage('Sinhala');\" href=\"#\">සිංහල</a></li>";
	$headerhtml .= "<li><a class=\"lang\" onclick=\"setLanguage('Tamil');\" href=\"#\">Tamil</a></li>";	
	$headerhtml .= "</ul></div></div>";
	$headerhtml .= "<div class=\"common_content\">";
	//$headerhtml .= "<div class=\"common_title\"><img src=\"images/title.png\"/></div>";


    echo $headerhtml;

}

//----------------------------------------------------------------------------------------------

function loadfooter()
{
  //  $footerhtml = "</div></div>";
    $footerhtml .= "</div><div class=\"common_site_footer\"><div class=\"copynote\">&copy; 2012 Virtual Village Book, All Rights Reserved.</div>";
    $footerhtml .= "</div>";
	$footerhtml .= "</body></html>";
    echo $footerhtml;

}

//----------------------------------------------------------------------------------------------

function loadScriptfiles($arrfile)
{
    $returnhtml = "";

    foreach ($arrfile as $index=>$scriptfile)
    {
        if ($index == 0)
            continue ;
        $returnhtml .= "<script type=\"text/javascript\" src=\"js/".$scriptfile."\"></script>";
}
return $returnhtml;

}

//----------------------------------------------------------------------------------------------

function loadStylefiles($arrfile)
{
    $returnhtml = "";
foreach ($arrfile as $index=>$stylefile)
{
    if ($index == 0)
        continue ;
		
		if("print.css" == $stylefile)
			{
				$returnhtml .= "<link media=\"print\" rel=\"stylesheet\" href=\"style/".$stylefile."\" type=\"text/css\" />";
			}
		else
			{
    			$returnhtml .= "<link rel=\"stylesheet\" href=\"style/".$stylefile."\" type=\"text/css\" />";
			}
}
return $returnhtml;

}

//----------------------------------------------------------------------------------------------

?>

