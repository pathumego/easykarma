
var Msg_que = new Array();
var lastSent_packet = new Array();
var MaxPackagePackets = 5;
var issending = false;
var req;
var server_url = "request_handler.php";
var retryattempt = 5;

var glb_moduleId_Agriculture = 2;
var glb_moduleId_Alsubjects = 3;
var glb_moduleId_Business = 4;
var glb_moduleId_Business_product = 5;
var glb_moduleId_Businesstype = 6;
var glb_moduleId_Foresttype = 7;
var glb_moduleId_Geographytype = 8;
var glb_moduleId_Group = 9;
var glb_moduleId_Group_member = 10;
var glb_moduleId_Groupmissiontype = 11;
var glb_moduleId_Higherstudysubjects = 12;
var glb_moduleId_Industrial = 13;
var glb_moduleId_Location = 14;
var glb_moduleId_Location_resources = 15;
var glb_moduleId_Olsubjects = 16;
var glb_moduleId_Organization = 17;
var glb_moduleId_Organization_subtype = 18;
var glb_moduleId_Organizationtype = 19;
var glb_moduleId_Person = 20;
var glb_moduleId_Person_address = 21;
var glb_moduleId_Person_alresult = 22;
var glb_moduleId_Person_educationlevel = 23;
var glb_moduleId_Person_highereducation = 24;
var glb_moduleId_Person_languageskill = 25;
var glb_moduleId_Person_olresult = 26;
var glb_moduleId_Person_property = 27;
var glb_moduleId_Person_talent = 28;
var glb_moduleId_Person_telephone = 29;
var glb_moduleId_Person_vocationaltraining = 30;
var glb_moduleId_Person_workingexperiance = 31;
var glb_moduleId_Plants = 32;
var glb_moduleId_Primarygeolayertype = 33;
var glb_moduleId_Product = 34;
var glb_moduleId_Service = 35;
var glb_moduleId_Socierytype = 36;
var glb_moduleId_Society = 37;
var glb_moduleId_Society_member = 38;
var glb_moduleId_Soiltype = 39;
var glb_moduleId_Talent = 40;
var glb_moduleId_Town = 41;
var glb_moduleId_Trading = 42;
var glb_moduleId_Traditionalknowledgecategory = 43;
var glb_moduleId_Transport = 44;
var glb_moduleId_User = 45;
var glb_moduleId_Village = 46;
var glb_moduleId_Village_agriculture = 47;
var glb_moduleId_Village_climate = 48;
var glb_moduleId_Village_enterance = 49;
var glb_moduleId_Village_geologicalvariation = 50;
var glb_moduleId_Village_group = 51;
var glb_moduleId_Village_history = 52;
var glb_moduleId_Village_image = 53;
var glb_moduleId_Village_industrial = 54;
var glb_moduleId_Village_neartowns = 55;
var glb_moduleId_Village_organization = 56;
var glb_moduleId_Village_othernames = 57;
var glb_moduleId_Village_plant = 58;
var glb_moduleId_Village_service = 59;
var glb_moduleId_Village_society = 60;
var glb_moduleId_Village_trading = 61;
var glb_moduleId_Village_traditionalknowledge = 62;
var glb_moduleId_Village_transport = 63;
var glb_moduleId_Language = 64;


var global_autocomplete_elem = new Array();

function message_queue(postpacket, id) {


    var temp_que_set = new Array();

    temp_que_set['id'] = id;
    if ((postpacket == "") || (postpacket == null)) {
        temp_que_set['msgPostPacket'] = 0;
    }
    else {
        temp_que_set['msgPostPacket'] = postpacket;
    }

    Msg_que[Msg_que.length] = temp_que_set;
    if (Msg_que.length > 50) {
        disconnectMessagePush();
        issending = false;


    }
    send_queue_message();
}

function send_queue_message() {
    if (!issending) {
        if ((Msg_que.length > 0) || (lastSent_packet.length > 0)) {
            var url = server_url;
            issending = true;
            var packetData = CreatePackagePacket();
            send_http_request(url, packetData, inncomingMessage);
        }
    }
}

//---------------------------------------------------------------------------

function CreatePackagePacket() {
    var packagePacket = "";
    var templastSent_packet = new Array();
    if (lastSent_packet.length == 0) {
        var packagemsgcount = 0;
        lastSent_packet = new Array();
        while (Msg_que.length > 0) {
            packagemsgcount++;
            templastSent_packet = Msg_que.shift();
            lastSent_packet[lastSent_packet.length] = templastSent_packet;
            packagePacket += "|" + templastSent_packet['msgPostPacket'];
            if (packagemsgcount >= MaxPackagePackets)
                break;
        }
    }
    else {
        for (var x = 0 in lastSent_packet) {
            templastSent_packet = lastSent_packet[x];
            packagePacket += templastSent_packet['msgPostPacket'];
        }
    }
    return packagePacket;
}

//---------------------------------------------------------------------------

function connction_init() {
    if (window.XMLHttpRequest) {
        if (req == null)
            req = new XMLHttpRequest();
    }
    else
    if (window.ActiveXObject) {
        if (req == null)
            req = new ActiveXObject("Microsoft.XMLHTTP");
    }
}
connction_init();
//---------------------------------------------------------------------------

function send_http_request(url, msgPostPacket, responsefunction) {
    try {
        issending = true;
        if ((msgPostPacket == "") || (msgPostPacket == null)) {
        }
        else {
            if (window.ActiveXObject) {
                req = new ActiveXObject("Microsoft.XMLHTTP");
                if (req) {
                    req.open("POST", url, true);
                    req.onreadystatechange = responsefunction;
                    req.setRequestHeader("Content-Type", "text/html; charset=UTF-8");
                    req.send(msgPostPacket);
                }
            }
            else
            if (window.XMLHttpRequest) {
                req.open("POST", url, true);
                req.onreadystatechange = responsefunction;
                req.setRequestHeader("Content-Type", "text/html; charset=UTF-8");
                req.send(msgPostPacket);
            }
        }
    }
    catch (ex) {
    }
}

//---------------------------------------------------------------------------

function inncomingMessage() {
    try {
        if (req.readyState == 4) {
            if (req.status == 200) {
                issending = false;
                var packagePacket = req.responseText;

                // message_income_que(dpacket);
                // message_income_send();
                processData(packagePacket);

                lastSent_packet.splice(0, lastSent_packet.length);
                lastSent_packet = new Array();
                issending = false;

                send_queue_message();
                $retryattempt = 5
            }
        }
    }
    catch (e) {
        if (retryattempt == 0)
            return;
        retryattempt--;
        issending = false;
        send_queue_message();
    }
}

//---------------------------------------------------------------------------

function handleIncommingdata(mainPacket)
{
    try {
        var stationId = mainPacket[0];
        var moduleId = mainPacket[1];
        mainPacket.shift();
        mainPacket.shift();

        switch (parseInt(moduleId)) {
            case 1:
                {
                    global_IncommingData(mainPacket);
                    break;
                }
            case 2:
                {
                    Agriculture_IncommingData(mainPacket);
                    break;
                }
            case 3:
                {
                    Alsubjects_IncommingData(mainPacket);
                    break;
                }
            case 4:
                {
                    Business_IncommingData(mainPacket);
                    break;
                }
            case 5:
                {
                    Business_product_IncommingData(mainPacket);
                    break;
                }
            case 6:
                {
                    Businesstype_IncommingData(mainPacket);
                    break;
                }
            case 7:
                {
                    Foresttype_IncommingData(mainPacket);
                    break;
                }
            case 8:
                {
                    Geographytype_IncommingData(mainPacket);
                    break;
                }
            case 9:
                {
                    Group_IncommingData(mainPacket);
                    break;
                }
            case 10:
                {
                    Group_member_IncommingData(mainPacket);
                    break;
                }
            case 11:
                {
                    Groupmissiontype_IncommingData(mainPacket);
                    break;
                }
            case 12:
                {
                    Higherstudysubjects_IncommingData(mainPacket);
                    break;
                }
            case 13:
                {
                    Industrial_IncommingData(mainPacket);
                    break;
                }
            case 14:
                {
                    Location_IncommingData(mainPacket);
                    break;
                }
            case 15:
                {
                    Location_resources_IncommingData(mainPacket);
                    break;
                }
            case 16:
                {
                    Olsubjects_IncommingData(mainPacket);
                    break;
                }
            case 17:
                {
                    Organization_IncommingData(mainPacket);
                    break;
                }
            case 18:
                {
                    Organization_subtype_IncommingData(mainPacket);
                    break;
                }
            case 19:
                {
                    Organizationtype_IncommingData(mainPacket);
                    break;
                }
            case 20:
                {
                    Person_IncommingData(mainPacket);
                    break;
                }
            case 21:
                {
                    Person_address_IncommingData(mainPacket);
                    break;
                }
            case 22:
                {
                    Person_alresult_IncommingData(mainPacket);
                    break;
                }
            case 23:
                {
                    Person_educationlevel_IncommingData(mainPacket);
                    break;
                }
            case 24:
                {
                    Person_highereducation_IncommingData(mainPacket);
                    break;
                }
            case 25:
                {
                    Person_languageskill_IncommingData(mainPacket);
                    break;
                }
            case 26:
                {
                    Person_olresult_IncommingData(mainPacket);
                    break;
                }
            case 27:
                {
                    Person_property_IncommingData(mainPacket);
                    break;
                }
            case 28:
                {
                    Person_talent_IncommingData(mainPacket);
                    break;
                }
            case 29:
                {
                    Person_telephone_IncommingData(mainPacket);
                    break;
                }
            case 30:
                {
                    Person_vocationaltraining_IncommingData(mainPacket);
                    break;
                }
            case 31:
                {
                    Person_workingexperiance_IncommingData(mainPacket);
                    break;
                }
            case 32:
                {
                    Plants_IncommingData(mainPacket);
                    break;
                }
            case 33:
                {
                    Primarygeolayertype_IncommingData(mainPacket);
                    break;
                }
            case 34:
                {
                    Product_IncommingData(mainPacket);
                    break;
                }
            case 35:
                {
                    Service_IncommingData(mainPacket);
                    break;
                }
            case 36:
                {
                    Socierytype_IncommingData(mainPacket);
                    break;
                }
            case 37:
                {
                    Society_IncommingData(mainPacket);
                    break;
                }
            case 38:
                {
                    Society_member_IncommingData(mainPacket);
                    break;
                }
            case 39:
                {
                    Soiltype_IncommingData(mainPacket);
                    break;
                }
            case 40:
                {
                    Talent_IncommingData(mainPacket);
                    break;
                }
            case 41:
                {
                    Town_IncommingData(mainPacket);
                    break;
                }
            case 42:
                {
                    Trading_IncommingData(mainPacket);
                    break;
                }
            case 43:
                {
                    Traditionalknowledgecategory_IncommingData(mainPacket);
                    break;
                }
            case 44:
                {
                    Transport_IncommingData(mainPacket);
                    break;
                }
            case 45:
                {
                    User_IncommingData(mainPacket);
                    break;
                }
            case 46:
                {
                    Village_IncommingData(mainPacket);
                    break;
                }
            case 47:
                {
                    Village_agriculture_IncommingData(mainPacket);
                    break;
                }
            case 48:
                {
                    Village_climate_IncommingData(mainPacket);
                    break;
                }
            case 49:
                {
                    Village_enterance_IncommingData(mainPacket);
                    break;
                }
            case 50:
                {
                    Village_geologicalvariation_IncommingData(mainPacket);
                    break;
                }
            case 51:
                {
                    Village_group_IncommingData(mainPacket);
                    break;
                }
            case 52:
                {
                    Village_history_IncommingData(mainPacket);
                    break;
                }
            case 53:
                {
                    Village_image_IncommingData(mainPacket);
                    break;
                }
            case 54:
                {
                    Village_industrial_IncommingData(mainPacket);
                    break;
                }
            case 55:
                {
                    Village_neartowns_IncommingData(mainPacket);
                    break;
                }
            case 56:
                {
                    Village_organization_IncommingData(mainPacket);
                    break;
                }
            case 57:
                {
                    Village_othernames_IncommingData(mainPacket);
                    break;
                }
            case 58:
                {
                    Village_plant_IncommingData(mainPacket);
                    break;
                }
            case 59:
                {
                    Village_service_IncommingData(mainPacket);
                    break;
                }
            case 60:
                {
                    Village_society_IncommingData(mainPacket);
                    break;
                }
            case 61:
                {
                    Village_trading_IncommingData(mainPacket);
                    break;
                }
            case 62:
                {
                    Village_traditionalknowledge_IncommingData(mainPacket);
                    break;
                }
            case 63:
                {
                    Village_transport_IncommingData(mainPacket);
                    break;
                }
            case 64:
                {
                    Language_IncommingData(mainPacket);
                    break;
                }

        }
    }
    catch (e)
    {

    }



}

//---------------------------------------------------------------------------

function processData(packagePacket)
{
    try {
        var arrpacket;
        arrpacket = packagePacket.split("|");

        for (var x = 0 in arrpacket)
        {
            $dataPacket = arrpacket[x].split(";");
            //$dataPacket = decodePacketDatqa($dataPacket);
            handleIncommingdata($dataPacket);

        }
    }
    catch (e)
    {

    }
}

//---------------------------------------------------------------------------
function decodePacketDatqa($dataPacket)
{
    for (var x = 0 in $dataPacket)
    {
        if ($dataPacket.length > 0) {
            $dataPacket[x] = decodeSpText($dataPacket[x]);
        }
    }

    return $dataPacket;
}

//---------------------------------------------------------------------------

function Global_setStation(stationId)
{
    createCookie("mfistation", stationId, 1000);
}

//---------------------------------------------------------------------------

function Global_getStation()
{
    return readCookie("mfistation");
}

//---------------------------------------------------------------------------

function global_IncommingData(dataPacket)
{
    var actionId = dataPacket[0];
    var status = dataPacket[1];
    var statusmessage = dataPacket[2];
    var globalautoelem = parseInt(dataPacket[3]);
    var retdataval;

    switch (parseInt(actionId))
    {
        case 100:
            {
                if (dataPacket.length > 0)
                {
                    if (global_autocomplete_elem[globalautoelem] != null)
                    {
                        retdataval = dataPacket[4].split(",");
                        if (status == 0)
                        {
                            retdataval = new Array();
                        }
                        global_autocomplete_elem[globalautoelem].LoadItems(retdataval);
                    }
                }
                break;
            }
        case 101:
            {
                if (global_autocomplete_elem[globalautoelem] != null)
                {
                    retdataval = dataPacket[4];
                    global_autocomplete_elem[globalautoelem].LoadInitTextValue(retdataval);
                }
                break;
            }

    }


}

function getDummyId() {
    return Math.floor(Math.random() * 100000);
}


//---------------------------------------------------------------------------
function encodeSpText(text)
{
    text = text.replace(/,/g, "&coma");
    text = text.replace(/;/g, "&colan");
    return text;
}

//---------------------------------------------------------------------------
function decodeSpText(text)
{
    text = text.replace(/&coma/g, ",");
    text = text.replace(/&colan/g, ";");
    return text;
}
//---------------------------------------------------------------------------
/*
 var queprocessing = true;
 function message_income_que(packet){
 
 queprocessing = false;
 
 var InterviewId = packet.InterviewId;
 var arrtempincomeque2 = new Array();
 
 if (Incomming_que.length == 0) {
 var temppacketarr = new Array();
 temppacketarr[0] = packet;
 arrtempincomeque2[0] = InterviewId;
 arrtempincomeque2[1] = temppacketarr;
 Incomming_que[Incomming_que.length] = arrtempincomeque2;
 }
 else {
 var result = search_interveiw_incomeque(InterviewId);
 
 if (result != -1) {
 var temppacketarr1 = new Array();
 
 arrtempincomeque2 = Incomming_que[result];
 temppacketarr1 = arrtempincomeque2[1];
 temppacketarr1.push(packet);
 arrtempincomeque2[1] = temppacketarr1;
 Incomming_que[result] = arrtempincomeque2;
 }
 else {
 var temppacketarr2 = new Array();
 temppacketarr2[0] = packet;
 arrtempincomeque2[0] = InterviewId;
 arrtempincomeque2[1] = temppacketarr2;
 Incomming_que[Incomming_que.length] = arrtempincomeque2;
 }
 
 }
 queprocessing = true;
 
 }
 
 
 var dequeing = true;
 
 //---------------------------------------------------------------------------
 
 function message_income_send(){
 
 
 
 if ((Incomming_que.length > 0) && (dequeing) && (queprocessing)) {
 for (x in Incomming_que) {
 try {
 var arrtempincomeque1 = new Array();
 arrtempincomeque1 = Incomming_que[x];
 if ((arrtempincomeque1[0] == currentInterveiwID) && (arrtempincomeque1.length > 1)) {
 dequeing = false;
 
 var temppacketarr = new Array()
 temppacketarr = arrtempincomeque1[1];
 
 while (temppacketarr.length > 0) {
 message_broker(temppacketarr.shift());
 
 }
 dequeing = true;
 break;
 }
 } 
 catch (ex) {
 alert("error:message_income_send()" + ex);
 dequeing = true;
 }
 }
 }
 
 }
 */
//---------------------------------------------------------------------------

function setLanguage(lang)
{
    var url = document.URL;
    if (url.indexOf("#") > -1)
    {
        url = url.substring(0, url.indexOf("#"));
    }


    if (url.indexOf("lang=") > 0)
    {
        var url_1 = url.substring(url.indexOf("lang="));
        if (url_1.indexOf("&") > -1) {
            url_1 = url_1.substring(url_1.indexOf("&"));

        }
        else
        {
            url_1 = "";
        }
        url = url.substring(0, url.indexOf("&lang=")) + url_1

    }
    location.href = url + "&lang=" + lang;

}
