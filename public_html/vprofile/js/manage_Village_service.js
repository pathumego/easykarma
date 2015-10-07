//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_service_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_service(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_service(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_service(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_service(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_service(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_service = new Village_service();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_service.ServiceId= mainPacket[3];
		obj_Village_service.VillageId= mainPacket[4];
		obj_Village_service.BusinessId= mainPacket[5];
		obj_Village_service.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_serviceRow(obj_Village_service, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_service(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_service = new Village_service();
		
		var resultStatus = mainPacket[0];
		var BusinessId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_serviceListRow_"+BusinessId);
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
				var rowElem = document.getElementById("Village_serviceListRow_"+BusinessId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_service(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_service = new Village_service();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_service.ServiceId= mainPacket[2];
		obj_Village_service.VillageId= mainPacket[3];
		obj_Village_service.BusinessId= mainPacket[4];
		obj_Village_service.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_serviceRow(obj_Village_service, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_service_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_servicePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_service; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_servicePacket(BusinessId) {
	var deletePacketBody  = BusinessId;

	var postpacket = createOutgoingVillage_servicePacket(202,deletePacketBody);
	Village_service_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_servicePacket(obj_Village_service) {
	var savePacketBody  = obj_Village_service.createVillage_servicePacket();

	var postpacket = createOutgoingVillage_servicePacket(203,savePacketBody);
	Village_service_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_servicePacket(dummyId,obj_Village_service) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_service.createVillage_servicePacket();

	var postpacket = createOutgoingVillage_servicePacket(201,savePacketBody);
	Village_service_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_servicePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_servicePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_service = document.getElementById("btnaddVillage_service");
	if(addVillage_service){
	addVillage_service.addEventListener('mousedown', Event_mousedown_addVillage_service, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_serviceform = document.getElementById("popVillage_serviceform");
	var inputElems = popVillage_serviceform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_serviceList = document.getElementById("Village_serviceList");
	var liElems = UiVillage_serviceList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_serviceRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_serviceRow, false);
		
	}
	
	var UiVillage_serviceListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_serviceListDeletebtns.length; z++) {
			UiVillage_serviceListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_serviceRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_BusinessId","Name",4); //group
	
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
	UI_search_Village_service(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_serviceRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_service = Get_Village_serviceByListRow(this.parentNode.parentNode);
			if(obj_Village_service != ""){
				deleteVillage_service(obj_Village_service.BusinessId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_service = Get_Village_serviceByListRow(this.parentNode.parentNode);
			if(obj_Village_service != ""){
				UI_showUpdateVillage_serviceForm(obj_Village_service);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_service(searchText)
{

	//Village_serviceList = 
	var Village_serviceListElem = document.getElementById("Village_serviceList");
	
	if(Village_serviceListElem)
	{
		var Village_serviceDataList = Village_serviceListElem.getElementsByTagName("input");
		for(var y=0 in Village_serviceDataList)
		{
			if(Village_serviceDataList[y])
			{
				
				
				var displayType = "none";
				var Village_serviceData = Village_serviceDataList[y].value;
				if(!((Village_serviceData == "") || (typeof Village_serviceData=="undefined")))
				{
				if(search_Village_service(Village_serviceData,searchText))
				{
					displayType = "block";
				}
				Village_serviceDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_service(Village_serviceData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_serviceData = decodeSpText(Village_serviceData.toLowerCase());
	if(Village_serviceData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_service)
{
	if (obj_Village_service.BusinessId) {
		var fieldDataId = obj_Village_service.BusinessId;
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

function deleteVillage_service(BusinessId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_service");
	if(flag){
			DeleteVillage_servicePacket(BusinessId);
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

function Get_Village_serviceByListRow(listRowElem)
{
	
	var obj_Village_service ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_serviceData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_serviceData = elemlist[z].value;
			}		
		}
		
		if(Village_serviceData != "")
		{
		var arrVillage_serviceData = Village_serviceData.split(";");	
		
		obj_Village_service = new Village_service();
		obj_Village_service.ServiceId= arrVillage_serviceData[0];
		obj_Village_service.VillageId= arrVillage_serviceData[1];
		obj_Village_service.BusinessId= arrVillage_serviceData[2];
		obj_Village_service.Description= arrVillage_serviceData[3];

		
		
		}
		
	}
	
	return obj_Village_service;
	
	
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
	

	var Elem = document.getElementById("Input_Description");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please describe";
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
	
		var obj_Village_service = new Village_service();
		
		var ServiceId= document.getElementById("Input_ServiceId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var BusinessId= document.getElementById("Input_BusinessId").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_ServiceId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_service = new Village_service();
		obj_Village_service.ServiceId= ServiceId;
		obj_Village_service.VillageId= VillageId;
		obj_Village_service.BusinessId= BusinessId;
		obj_Village_service.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_servicePacket(dummyId,obj_Village_service);
		UI_createVillage_serviceRow(obj_Village_service, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_service = new Village_service();

		obj_Village_service.ServiceId= ServiceId;
		obj_Village_service.VillageId= VillageId;
		obj_Village_service.BusinessId= BusinessId;
		obj_Village_service.Description= Description;

		
		UpdateVillage_servicePacket(obj_Village_service);
		UI_createVillage_serviceRow(obj_Village_service, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_service() {
	
	UI_showAddVillage_serviceForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_serviceForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_serviceAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_serviceform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_serviceForm(obj_Village_service) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_serviceUpdateForm(obj_Village_service);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_serviceform"));
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
function UI_prepareVillage_serviceUpdateForm(obj_Village_service)
{
	var arr_hidelist = new Array("Input_BusinessId","Input_ServiceId","Input_VillageId");
	var arr_showlist = new Array("Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ServiceId").value=obj_Village_service.ServiceId;
		document.getElementById("Input_VillageId").value=obj_Village_service.VillageId;
		document.getElementById("Input_BusinessId").value=obj_Village_service.BusinessId;
		document.getElementById("Input_Description").value=obj_Village_service.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_serviceAddForm()
{
	var arr_hidelist = new Array("Input_BusinessId","Input_ServiceId","Input_VillageId");
	var arr_showlist = new Array("Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ServiceId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_serviceToVillage_serviceList() {
	var uiVillage_serviceList = document.getElementById("Village_serviceList");

	var rowElems = uiVillage_serviceList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_serviceRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_serviceRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_serviceRowHtmlElem(obj_Village_service,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_serviceImg_"+obj_Village_service.BusinessId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_service/0_small.png";
	else ImgElem.src = "Village_service/"+obj_Village_service.BusinessId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_service.ServiceId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_service.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_service.BusinessId;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_service.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_servicedata"+ElemId);
		ElementDataHidden.value = obj_Village_service.getVillage_serviceData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_serviceRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_serviceRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_serviceRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_serviceHtmlElem(obj_Village_service)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_service");
		html ="<a href=\"?page=dashboard&BusinessId="+obj_Village_service.BusinessId+"\">"+obj_Village_service.BusinessId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_serviceRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_serviceRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_serviceRow(obj_Village_service, rowType,dummyId) {
	var html = "";
	
	var UiVillage_serviceList = document.getElementById("Village_serviceList");
	var ClassName = "ListRow";
	var ElemId = "Village_serviceListRow_"+obj_Village_service.BusinessId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_serviceRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_serviceRowHtmlElem(obj_Village_service,ElemId, ClassName);
			UiVillage_serviceList.insertBefore(ElemLi, UiVillage_serviceList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_service msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_serviceRowHtmlElem(obj_Village_service,ElemId, ClassName);
			UiVillage_serviceList.insertBefore(ElemLi, UiVillage_serviceList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_serviceRow_"+dummyId);
			var DummyData = document.getElementById("Village_servicedataDummyVillage_serviceRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_servicedata"+ElemId);		
				DummyData.value = obj_Village_service.getVillage_serviceData();		
				}
				UI_createTopbarSubVillage_serviceHtmlElem(obj_Village_service);
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
				var ElemLi = UI_createVillage_serviceRowHtmlElem(obj_Village_service,ElemId, ClassName);
				UiVillage_serviceList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_serviceList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, BusinessId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_serviceListRow_"+BusinessId);
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


