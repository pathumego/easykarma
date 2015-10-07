//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Location_resources_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addLocation_resources(mainPacket);
			break;
		}
		case 201: {
			ACK_addLocation_resources(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteLocation_resources(mainPacket);
			break;
		}
		case 203: {
			ACK_updateLocation_resources(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addLocation_resources(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Location_resources = new Location_resources();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Location_resources.ResourceId= mainPacket[3];
		obj_Location_resources.LocationId= mainPacket[4];
		obj_Location_resources.ResourceType= mainPacket[5];
		obj_Location_resources.ResourcePath= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createLocation_resourcesRow(obj_Location_resources, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteLocation_resources(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Location_resources = new Location_resources();
		
		var resultStatus = mainPacket[0];
		var ResourceId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Location_resourcesListRow_"+ResourceId);
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
				var rowElem = document.getElementById("Location_resourcesListRow_"+ResourceId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateLocation_resources(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Location_resources = new Location_resources();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Location_resources.ResourceId= mainPacket[2];
		obj_Location_resources.LocationId= mainPacket[3];
		obj_Location_resources.ResourceType= mainPacket[4];
		obj_Location_resources.ResourcePath= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createLocation_resourcesRow(obj_Location_resources, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Location_resources_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingLocation_resourcesPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Location_resources; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteLocation_resourcesPacket(ResourceId) {
	var deletePacketBody  = ResourceId;

	var postpacket = createOutgoingLocation_resourcesPacket(202,deletePacketBody);
	Location_resources_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateLocation_resourcesPacket(obj_Location_resources) {
	var savePacketBody  = obj_Location_resources.createLocation_resourcesPacket();

	var postpacket = createOutgoingLocation_resourcesPacket(203,savePacketBody);
	Location_resources_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddLocation_resourcesPacket(dummyId,obj_Location_resources) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Location_resources.createLocation_resourcesPacket();

	var postpacket = createOutgoingLocation_resourcesPacket(201,savePacketBody);
	Location_resources_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onLocation_resourcesPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onLocation_resourcesPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addLocation_resources = document.getElementById("btnaddLocation_resources");
	if(addLocation_resources){
	addLocation_resources.addEventListener('mousedown', Event_mousedown_addLocation_resources, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popLocation_resourcesform = document.getElementById("popLocation_resourcesform");
	var inputElems = popLocation_resourcesform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiLocation_resourcesList = document.getElementById("Location_resourcesList");
	var liElems = UiLocation_resourcesList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverLocation_resourcesRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutLocation_resourcesRow, false);
		
	}
	
	var UiLocation_resourcesListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiLocation_resourcesListDeletebtns.length; z++) {
			UiLocation_resourcesListDeletebtns[z].addEventListener('mousedown', Event_mouseDownLocation_resourcesRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_LocationId","Name",14); //location
	
	
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
	UI_search_Location_resources(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownLocation_resourcesRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Location_resources = Get_Location_resourcesByListRow(this.parentNode.parentNode);
			if(obj_Location_resources != ""){
				deleteLocation_resources(obj_Location_resources.ResourceId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Location_resources = Get_Location_resourcesByListRow(this.parentNode.parentNode);
			if(obj_Location_resources != ""){
				UI_showUpdateLocation_resourcesForm(obj_Location_resources);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Location_resources(searchText)
{

	//Location_resourcesList = 
	var Location_resourcesListElem = document.getElementById("Location_resourcesList");
	
	if(Location_resourcesListElem)
	{
		var Location_resourcesDataList = Location_resourcesListElem.getElementsByTagName("input");
		for(var y=0 in Location_resourcesDataList)
		{
			if(Location_resourcesDataList[y])
			{
				
				
				var displayType = "none";
				var Location_resourcesData = Location_resourcesDataList[y].value;
				if(!((Location_resourcesData == "") || (typeof Location_resourcesData=="undefined")))
				{
				if(search_Location_resources(Location_resourcesData,searchText))
				{
					displayType = "block";
				}
				Location_resourcesDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Location_resources(Location_resourcesData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Location_resourcesData = decodeSpText(Location_resourcesData.toLowerCase());
	if(Location_resourcesData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Location_resources)
{
	if (obj_Location_resources.ResourceId) {
		var fieldDataId = obj_Location_resources.ResourceId;
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

function deleteLocation_resources(ResourceId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Location_resources");
	if(flag){
			DeleteLocation_resourcesPacket(ResourceId);
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

function Get_Location_resourcesByListRow(listRowElem)
{
	
	var obj_Location_resources ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Location_resourcesData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Location_resourcesData = elemlist[z].value;
			}		
		}
		
		if(Location_resourcesData != "")
		{
		var arrLocation_resourcesData = Location_resourcesData.split(";");	
		
		obj_Location_resources = new Location_resources();
		obj_Location_resources.ResourceId= arrLocation_resourcesData[0];
		obj_Location_resources.LocationId= arrLocation_resourcesData[1];
		obj_Location_resources.ResourceType= arrLocation_resourcesData[2];
		obj_Location_resources.ResourcePath= arrLocation_resourcesData[3];

		
		
		}
		
	}
	
	return obj_Location_resources;
	
	
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
	
var Elem = document.getElementById("Input_ResourceType");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Resource type";
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
	
		var obj_Location_resources = new Location_resources();
		
		var ResourceId= document.getElementById("Input_ResourceId").value;
		var LocationId= document.getElementById("Input_LocationId").value;
		var ResourceType= document.getElementById("Input_ResourceType").value;
		var ResourcePath= document.getElementById("Input_ResourcePath").value;

		
		document.getElementById("Input_ResourceId").value="";
		document.getElementById("Input_LocationId").value="";
		document.getElementById("Input_ResourceType").value="";
		document.getElementById("Input_ResourcePath").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Location_resources = new Location_resources();
		obj_Location_resources.ResourceId= ResourceId;
		obj_Location_resources.LocationId= LocationId;
		obj_Location_resources.ResourceType= ResourceType;
		obj_Location_resources.ResourcePath= ResourcePath;

		
		var dummyId = CreateDummyNumber();
		AddLocation_resourcesPacket(dummyId,obj_Location_resources);
		UI_createLocation_resourcesRow(obj_Location_resources, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Location_resources = new Location_resources();

		obj_Location_resources.ResourceId= ResourceId;
		obj_Location_resources.LocationId= LocationId;
		obj_Location_resources.ResourceType= ResourceType;
		obj_Location_resources.ResourcePath= ResourcePath;

		
		UpdateLocation_resourcesPacket(obj_Location_resources);
		UI_createLocation_resourcesRow(obj_Location_resources, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addLocation_resources() {
	
	UI_showAddLocation_resourcesForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddLocation_resourcesForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareLocation_resourcesAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popLocation_resourcesform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateLocation_resourcesForm(obj_Location_resources) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareLocation_resourcesUpdateForm(obj_Location_resources);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popLocation_resourcesform"));
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
function UI_prepareLocation_resourcesUpdateForm(obj_Location_resources)
{
	var arr_hidelist = new Array("Input_ResourceId","Input_LocationId");
	var arr_showlist = new Array("Input_ResourceType","Input_ResourcePath");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ResourceId").value=obj_Location_resources.ResourceId;
		document.getElementById("Input_LocationId").value=obj_Location_resources.LocationId;
		document.getElementById("Input_ResourceType").value=obj_Location_resources.ResourceType;
		document.getElementById("Input_ResourcePath").value=obj_Location_resources.ResourcePath;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareLocation_resourcesAddForm()
{
	var arr_hidelist = new Array("Input_ResourceId","Input_LocationId");
	var arr_showlist = new Array("Input_ResourceType","Input_ResourcePath");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ResourceId").value="";
		document.getElementById("Input_LocationId").value="";
		document.getElementById("Input_ResourceType").value="";
		document.getElementById("Input_ResourcePath").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addLocation_resourcesToLocation_resourcesList() {
	var uiLocation_resourcesList = document.getElementById("Location_resourcesList");

	var rowElems = uiLocation_resourcesList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createLocation_resourcesRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownLocation_resourcesRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createLocation_resourcesRowHtmlElem(obj_Location_resources,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Location_resourcesImg_"+obj_Location_resources.ResourceId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Location_resources/0_small.png";
	else ImgElem.src = "Location_resources/"+obj_Location_resources.ResourceId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Location_resources.ResourceId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Location_resources.LocationId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Location_resources.ResourceType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Location_resources.ResourcePath;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Location_resourcesdata"+ElemId);
		ElementDataHidden.value = obj_Location_resources.getLocation_resourcesData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createLocation_resourcesRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverLocation_resourcesRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutLocation_resourcesRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubLocation_resourcesHtmlElem(obj_Location_resources)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subLocation_resources");
		html ="<a href=\"?page=dashboard&ResourceId="+obj_Location_resources.ResourceId+"\">"+obj_Location_resources.ResourceId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverLocation_resourcesRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutLocation_resourcesRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createLocation_resourcesRow(obj_Location_resources, rowType,dummyId) {
	var html = "";
	
	var UiLocation_resourcesList = document.getElementById("Location_resourcesList");
	var ClassName = "ListRow";
	var ElemId = "Location_resourcesListRow_"+obj_Location_resources.ResourceId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyLocation_resourcesRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createLocation_resourcesRowHtmlElem(obj_Location_resources,ElemId, ClassName);
			UiLocation_resourcesList.insertBefore(ElemLi, UiLocation_resourcesList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Location_resources msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createLocation_resourcesRowHtmlElem(obj_Location_resources,ElemId, ClassName);
			UiLocation_resourcesList.insertBefore(ElemLi, UiLocation_resourcesList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyLocation_resourcesRow_"+dummyId);
			var DummyData = document.getElementById("Location_resourcesdataDummyLocation_resourcesRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Location_resourcesdata"+ElemId);		
				DummyData.value = obj_Location_resources.getLocation_resourcesData();		
				}
				UI_createTopbarSubLocation_resourcesHtmlElem(obj_Location_resources);
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
				var ElemLi = UI_createLocation_resourcesRowHtmlElem(obj_Location_resources,ElemId, ClassName);
				UiLocation_resourcesList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Location_resourcesList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, ResourceId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Location_resourcesListRow_"+ResourceId);
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


