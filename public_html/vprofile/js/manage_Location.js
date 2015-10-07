//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Location_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addLocation(mainPacket);
			break;
		}
		case 201: {
			ACK_addLocation(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteLocation(mainPacket);
			break;
		}
		case 203: {
			ACK_updateLocation(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addLocation(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Location = new Location();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Location.LocationId= mainPacket[3];
		obj_Location.Name= mainPacket[4];
		obj_Location.LocationType= mainPacket[5];
		obj_Location.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createLocationRow(obj_Location, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteLocation(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Location = new Location();
		
		var resultStatus = mainPacket[0];
		var LocationId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("LocationListRow_"+LocationId);
		if(resultStatus ==1)
		{
			rowElem.parentNode.removeChild(rowElem);
			
		}
		else
		{
			rowElem.className = "ListRow_error";
			rowElem.style.display = "block";
			window.alert(resultMsg);
			setTimeout(function(){
				var rowElem = document.getElementById("LocationListRow_"+LocationId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateLocation(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Location = new Location();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Location.LocationId= mainPacket[2];
		obj_Location.Name= mainPacket[3];
		obj_Location.LocationType= mainPacket[4];
		obj_Location.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createLocationRow(obj_Location, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Location_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingLocationPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Location; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteLocationPacket(LocationId) {
	var deletePacketBody  = LocationId;

	var postpacket = createOutgoingLocationPacket(202,deletePacketBody);
	Location_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateLocationPacket(obj_Location) {
	var savePacketBody  = obj_Location.createLocationPacket();

	var postpacket = createOutgoingLocationPacket(203,savePacketBody);
	Location_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddLocationPacket(dummyId,obj_Location) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Location.createLocationPacket();

	var postpacket = createOutgoingLocationPacket(201,savePacketBody);
	Location_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onLocationPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onLocationPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addLocation = document.getElementById("btnaddLocation");
	if(addLocation){
	addLocation.addEventListener('mousedown', Event_mousedown_addLocation, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popLocationform = document.getElementById("popLocationform");
	var inputElems = popLocationform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiLocationList = document.getElementById("LocationList");
	var liElems = UiLocationList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverLocationRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutLocationRow, false);
		
	}
	
	var UiLocationListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiLocationListDeletebtns.length; z++) {
			UiLocationListDeletebtns[z].addEventListener('mousedown', Event_mouseDownLocationRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
}
//-------------------------------------------------------------------------------------------------------------------


function Event_focusSearchBox()
{
	if (this.className == "searchtextbox") {
        this.className = "searchtextbox_focus";        
        
    }
	if(this.value == "Search here..."){
		this.value ="";    
	}
}
//-------------------------------------------------------------------------------------------------------------------
function Event_blurSearchBox()
{
	if (this.className == "searchtextbox_focus") {
        this.className = "searchtextbox";        
        
    }
	if(this.value == ""){
		this.value ="Search here...";    
	}
}

//-------------------------------------------------------------------------------------------------------------------
function Event_keyupSearchBox()
{
	var searchText = this.value;
	UI_search_Location(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownLocationRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Location = Get_LocationByListRow(this.parentNode.parentNode);
			if(obj_Location != ""){
				deleteLocation(obj_Location.LocationId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Location = Get_LocationByListRow(this.parentNode.parentNode);
			if(obj_Location != ""){
				UI_showUpdateLocationForm(obj_Location);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Location(searchText)
{

	//LocationList = 
	var LocationListElem = document.getElementById("LocationList");
	
	if(LocationListElem)
	{
		var LocationDataList = LocationListElem.getElementsByTagName("input");
		for(var y=0 in LocationDataList)
		{
			if(LocationDataList[y])
			{
				
				
				var displayType = "none";
				var LocationData = LocationDataList[y].value;
				if(!((LocationData == "") || (typeof LocationData=="undefined")))
				{
				if(search_Location(LocationData,searchText))
				{
					displayType = "block";
				}
				LocationDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Location(LocationData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	LocationData = decodeSpText(LocationData.toLowerCase());
	if(LocationData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Location)
{
	if (obj_Location.LocationId) {
		var fieldDataId = obj_Location.LocationId;
		msgPopupwin = new msgPopup();
		var popwidth = 400;
		var popheight = 50;
		var popinnerHTML = "<iframe height=\"";
		popinnerHTML += popheight;
		popinnerHTML += "px\" frameborder=\"0\" width=\"";
		popinnerHTML += popwidth;
		popinnerHTML += "px\" border=\"0\" id=\"uploadframe\" name=\"uploadframe\" style=\"border: medium none;\" src=\"";
		popinnerHTML += "upload_uploadAvatarIndex.php?fielddataid="
		popinnerHTML += fieldDataId;
		popinnerHTML += "\">";
		popinnerHTML += "</iframe>";
		
		msgPopupwin.init(popwidth, popheight, popinnerHTML);		
		msgPopupwin.show();
	}
}
//-------------------------------------------------------------------------------------------------------------------

function deleteLocation(LocationId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Location");
	if(flag){
			DeleteLocationPacket(LocationId);
			UI_hideListRow(listRow);	
		}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_deleteListRow(rowElem)
{
if(rowElem)
{
rowElem.parentNode.removeChild(rowElem);
	
}	
	
}

//-------------------------------------------------------------------------------------------------------------------

function UI_hideListRow(rowElem)
{
if(rowElem)
{
rowElem.style.display = "none";
	
}	
	
}
//-------------------------------------------------------------------------------------------------------------------

function Get_LocationByListRow(listRowElem)
{
	
	var obj_Location ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var LocationData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				LocationData = elemlist[z].value;
			}		
		}
		
		if(LocationData != "")
		{
		var arrLocationData = LocationData.split(";");	
		
		obj_Location = new Location();
		obj_Location.LocationId= arrLocationData[0];
		obj_Location.Name= arrLocationData[1];
		obj_Location.LocationType= arrLocationData[2];
		obj_Location.Description= arrLocationData[3];

		
		
		}
		
	}
	
	return obj_Location;
	
	
}
//-------------------------------------------------------------------------------------------------------------------

function Event_focusFormAreaField(event) {

if (this.className == "form_area_textbox") {
		this.className = "form_area_textbox_focus";
	}
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_blurFormAreaField(event) {

	if (this.className == "form_area_textbox_focus") {
		this.className = "form_area_textbox";
	}
	
	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
		

}

//-------------------------------------------------------------------------------------------------------------------

function validate_form()
{
	
	var iserror =false;
		var errorMsg = "";
	

				var Elem = document.getElementById("Input_Name");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter name";
					Elem.focus();
				}				
			
				}	
		
		if(iserror ==true)
		{
						
			document.getElementById("formerror").innerHTML = error;
		}
		else
		{
			document.getElementById("formerror").innerHTML = "";
		}	
		
		return iserror;
	
	
	return false;
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_form_addbtn(event) {
	

	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
	
		var obj_Location = new Location();
		
		var LocationId= document.getElementById("Input_LocationId").value;
		var Name= document.getElementById("Input_Name").value;
		var LocationType= document.getElementById("Input_LocationType").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_LocationId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_LocationType").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Location = new Location();
		obj_Location.LocationId= LocationId;
		obj_Location.Name= Name;
		obj_Location.LocationType= LocationType;
		obj_Location.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddLocationPacket(dummyId,obj_Location);
		UI_createLocationRow(obj_Location, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Location = new Location();

		obj_Location.LocationId= LocationId;
		obj_Location.Name= Name;
		obj_Location.LocationType= LocationType;
		obj_Location.Description= Description;

		
		UpdateLocationPacket(obj_Location);
		UI_createLocationRow(obj_Location, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addLocation() {
	
	UI_showAddLocationForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddLocationForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareLocationAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popLocationform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateLocationForm(obj_Location) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareLocationUpdateForm(obj_Location);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popLocationform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------
function UI_showhideFormElements(arr_childelemlist, flag)
{
	for(var x =0 in arr_childelemlist)
	{
		if(elem = document.getElementById(arr_childelemlist[x]))
		{
			elem.parentNode.parentNode.style.display = flag ==1 ? "block" : "none";			
		}		
	}	
}
//-------------------------------------------------------------------------------------------------------------------
function UI_prepareLocationUpdateForm(obj_Location)
{
	var arr_hidelist = new Array("Input_LocationId");
	var arr_showlist = new Array("Input_Name","Input_LocationType","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_LocationId").value=obj_Location.LocationId;
		document.getElementById("Input_Name").value=obj_Location.Name;
		document.getElementById("Input_LocationType").value=obj_Location.LocationType;
		document.getElementById("Input_Description").value=obj_Location.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareLocationAddForm()
{
	var arr_hidelist = new Array("Input_LocationId");
	var arr_showlist = new Array("Input_Name","Input_LocationType","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_LocationId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_LocationType").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addLocationToLocationList() {
	var uiLocationList = document.getElementById("LocationList");

	var rowElems = uiLocationList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createLocationRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownLocationRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createLocationRowHtmlElem(obj_Location,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "LocationImg_"+obj_Location.LocationId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Location/0_small.png";
	else ImgElem.src = "Location/"+obj_Location.LocationId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Location.LocationId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Location.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Location.LocationType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Location.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Locationdata"+ElemId);
		ElementDataHidden.value = obj_Location.getLocationData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createLocationRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverLocationRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutLocationRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubLocationHtmlElem(obj_Location)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subLocation");
		html ="<a href=\"?page=dashboard&LocationId="+obj_Location.LocationId+"\">"+obj_Location.LocationId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverLocationRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutLocationRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createLocationRow(obj_Location, rowType,dummyId) {
	var html = "";
	
	var UiLocationList = document.getElementById("LocationList");
	var ClassName = "ListRow";
	var ElemId = "LocationListRow_"+obj_Location.LocationId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyLocationRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createLocationRowHtmlElem(obj_Location,ElemId, ClassName);
			UiLocationList.insertBefore(ElemLi, UiLocationList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Location msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createLocationRowHtmlElem(obj_Location,ElemId, ClassName);
			UiLocationList.insertBefore(ElemLi, UiLocationList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyLocationRow_"+dummyId);
			var DummyData = document.getElementById("LocationdataDummyLocationRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Locationdata"+ElemId);		
				DummyData.value = obj_Location.getLocationData();		
				}
				UI_createTopbarSubLocationHtmlElem(obj_Location);
				UI_hidecontentError(checkNodeCount =true);
			}
			
		break;
		}
		case "replace":
		{
			if(dummyId == 1)ClassName = "ListRow_Dummy"; //use dummyId as flag

			var currentElem = document.getElementById(ElemId);
			if(currentElem)
			{
				var ElemLi = UI_createLocationRowHtmlElem(obj_Location,ElemId, ClassName);
				UiLocationList.insertBefore(ElemLi, currentElem);
				currentElem.parentNode.removeChild(currentElem);	
			}
			break;
		}
		}

}
//-------------------------------------------------------------------------------------------------------------------

function UI_hidecontentError(flag)
{
	var errorElem = document.getElementById("contentError");
	if(errorElem)
	{
	
	if(flag)
	{
		var listnode = document.getElementById("LocationList");
		if(listnode.getElementsByClassName("ListRow").length >0)
		{
			errorElem.style.display = "none";
		}
		else
		{
			errorElem.style.display = "block";
		}
	}
	else
	{
		errorElem.style.display = "none";
	}
	
			
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function CreateDummyNumber() {
	return	Math.floor(Math.random()*99999);
}
//-------------------------------------------------------------------------------------------------------------------

function avatarUploadResult(status, uploadFileName, errorMsg, LocationId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("LocationListRow_"+LocationId);
		var avatarimgs = profileAvatar.getElementsByTagName("img");
		if(avatarimgs.length >0)
		{
			avatarimgs[0].src = uploadFileName+"?"+Math.random();
		}
		
	}
	else
	{
 
		var errorMessage = "";
		switch(errorMsg)
		{
			case "A000":
			{
			errorMessage = "Sorry you dont have permission to upload file";
			break;	
			}
			case "A003":
			{
			errorMessage = "Sorry, The file type does not valid for upload";
			break;	
			}
			case "A004":
			{
			errorMessage = "Sorry, The file size is too large to upload";
			break;	
			}
			default:
			{
			errorMessage = "sorry, problem occured while uploading a file";
			break;	
			}
		}
		var html = "<div style=\"width:";
		html +=msgPopupwin.width;
		html +="px;height:";
		html +=msgPopupwin.height;
		html += "px\">"
		html +=errorMessage;
		html += "</div>";
		msgPopupwin.innerHTML = html;
		msgPopupwin.show();
	}
}
//-------------------------------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------------------------------

/*
 function getElementPosition(elem){
 var left = 0;
 var top = 0;

 while (elem.offsetParent) {
 left += elem.offsetLeft;
 top += elem.offsetTop;
 elem = elem.offsetParent;
 }

 left += elem.offsetLeft;
 top += elem.offsetTop;

 return {
 x: left,
 y: top
 };
 }
 */


