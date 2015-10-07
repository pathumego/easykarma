function getBroserName(){
    var agt = navigator.userAgent.toLowerCase();
    
    if (agt.indexOf("opera") != -1) 
        return 'Opera';
    if (agt.indexOf("staroffice") != -1) 
        return 'Star Office';
    if (agt.indexOf("webtv") != -1) 
        return 'WebTV';
    if (agt.indexOf("beonex") != -1) 
        return 'Beonex';
    if (agt.indexOf("chimera") != -1) 
        return 'Chimera';
    if (agt.indexOf("netpositive") != -1) 
        return 'NetPositive';
    if (agt.indexOf("phoenix") != -1) 
        return 'Phoenix';
    if (agt.indexOf("firefox") != -1) 
        return 'Firefox';
    //if ((agt.indexOf("safari") != -1)&&(agt.indexOf("version/3") != -1)) return 'Safari3';
    if (agt.indexOf("safari") != -1) 
        return 'Safari';
    if (agt.indexOf("skipstone") != -1) 
        return 'SkipStone';
    if (agt.indexOf("msie") != -1) 
        return 'Internet Explorer';
    if (agt.indexOf("netscape") != -1) 
        return 'Netscape';
    if (agt.indexOf("mozilla/5.0") != -1) 
        return 'Mozilla';
    
    if (agt.indexOf('\/') != -1) {
        if (agt.substr(0, agt.indexOf('\/')) != 'mozilla') {
            return navigator.userAgent.substr(0, agt.indexOf('\/'));
        }
        else 
            return 'Netscape';
    }
    
    else 
        if (agt.indexOf(' ') != -1) 
            return navigator.userAgent.substr(0, agt.indexOf(' '));
        else 
            return navigator.userAgent;
}

//==========================================================================================

function createCookie(name, value, hour){

    /* tempfix => all cookie will auto expired*/
    var expires = "";
    
    if (hour) {
        var date = new Date();
        date.setTime(date.getTime() + (1 * hour * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else 
        expires = "";
    
 
        document.cookie = name + "=" + value + expires + ";path=/";
}


//==========================================================================================


function readCookie(name){
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') 
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) 
            return c.substring(nameEQ.length, c.length);
    }
    return null;
}

//==========================================================================================

function removeCookie(name){
    var cookiepath = (document.location.pathname).match(/^\/\w+\/?/).toString();

    if (name == "sessioncookie") {
        if (getBroserName() == "Safari") 
            document.cookie = name + '="";expires=Thu, 01-Jan-1970 00:00:01 GMT; path='+cookiepath.substring(0,cookiepath.length-1);
        
        else 
            document.cookie = name + '="";expires=Thu, 01-Jan-1970 00:00:01 GMT; path='+cookiepath;
    }
       
    else {
        if (getBroserName() == "Safari") 
            document.cookie = name + '="";expires=Thu, 01-Jan-1970 00:00:01 GMT; path=/input';
        
        else 
            document.cookie = name + '="";expires=Thu, 01-Jan-1970 00:00:01 GMT;path=/input/';
    }
    
    
}


