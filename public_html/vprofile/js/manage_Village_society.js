﻿//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_society_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_society(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_society(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_society(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_society(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_society(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_society = new Village_society();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_society.SocietyId= mainPacket[3];
		obj_Village_society.VillageId= mainPacket[4];
		obj_Village_society.VillageSocietyId= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createVillage_societyRow(obj_Village_society, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_society(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_society = new Village_society();
		
		var resultStatus = mainPacket[0];
		var VillageSocietyId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_societyListRow_"+VillageSocietyId);
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
				var rowElem = document.getElementById("Village_societyListRow_"+VillageSocietyId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_society(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_society = new Village_society();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_society.SocietyId= mainPacket[2];
		obj_Village_society.VillageId= mainPacket[3];
		obj_Village_society.VillageSocietyId= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createVillage_societyRow(obj_Village_society, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_society_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_societyPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_society; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_societyPacket(VillageSocietyId) {
	var deletePacketBody  = VillageSocietyId;

	var postpacket = createOutgoingVillage_societyPacket(202,deletePacketBody);
	Village_society_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_societyPacket(obj_Village_society) {
	var savePacketBody  = obj_Village_society.createVillage_societyPacket();

	var postpacket = createOutgoingVillage_societyPacket(203,savePacketBody);
	Village_society_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_societyPacket(dummyId,obj_Village_society) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_society.createVillage_societyPacket();

	var postpacket = createOutgoingVillage_societyPacket(201,savePacketBody);
	Village_society_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_societyPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_societyPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_society = document.getElementById("btnaddVillage_society");
	if(addVillage_society){
	addVillage_society.addEventListener('mousedown', Event_mousedown_addVillage_society, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_societyform = document.getElementById("popVillage_societyform");
	var inputElems = popVillage_societyform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_societyList = document.getElementById("Village_societyList");
	var liElems = UiVillage_societyList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_societyRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_societyRow, false);
		
	}
	
	var UiVillage_societyListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_societyListDeletebtns.length; z++) {
			UiVillage_societyListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_societyRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
		global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_SocietyId","Name",37); //society
	
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
	UI_search_Village_society(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_societyRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_society = Get_Village_societyByListRow(this.parentNode.parentNode);
			if(obj_Village_society != ""){
				deleteVillage_society(obj_Village_society.VillageSocietyId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_society = Get_Village_societyByListRow(this.parentNode.parentNode);
			if(obj_Village_society != ""){
				UI_showUpdateVillage_societyForm(obj_Village_society);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_society(searchText)
{

	//Village_societyList = 
	var Village_societyListElem = document.getElementById("Village_societyList");
	
	if(Village_societyListElem)
	{
		var Village_societyDataList = Village_societyListElem.getElementsByTagName("input");
		for(var y=0 in Village_societyDataList)
		{
			if(Village_societyDataList[y])
			{
				
				
				var displayType = "none";
				var Village_societyData = Village_societyDataList[y].value;
				if(!((Village_societyData == "") || (typeof Village_societyData=="undefined")))
				{
				if(search_Village_society(Village_societyData,searchText))
				{
					displayType = "block";
				}
				Village_societyDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_society(Village_societyData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_societyData = decodeSpText(Village_societyData.toLowerCase());
	if(Village_societyData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_society)
{
	if (obj_Village_society.VillageSocietyId) {
		var fieldDataId = obj_Village_society.VillageSocietyId;
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

function deleteVillage_society(VillageSocietyId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_society");
	if(flag){
			DeleteVillage_societyPacket(VillageSocietyId);
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

function Get_Village_societyByListRow(listRowElem)
{
	
	var obj_Village_society ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_societyData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_societyData = elemlist[z].value;
			}		
		}
		
		if(Village_societyData != "")
		{
		var arrVillage_societyData = Village_societyData.split(";");	
		
		obj_Village_society = new Village_society();
		obj_Village_society.SocietyId= arrVillage_societyData[0];
		obj_Village_society.VillageId= arrVillage_societyData[1];
		obj_Village_society.VillageSocietyId= arrVillage_societyData[2];

		
		
		}
		
	}
	
	return obj_Village_society;
	
	
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
	/*
	var iserror =false;
		var errorMsg = "";
	

		var Elem = document.getElementById("Input_Village_societyPrice");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Village_society price";
					Elem.focus();
				}				
				else if(isNaN(Elem.value))
				{
					Elem.value="";
					iserror =true;
					error = "Invalid price";	
					Elem.focus();		
				}
	
			}
			
		    Elem = document.getElementById("Input_Village_societyName");
			if(Elem)
			{
				if(Elem.value =="")
				{
				Elem.focus();
				iserror =true;
				error = "Please enter Village_society name";	
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
	*/
	
	return false;
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_form_addbtn(event) {
	

	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
	
		var obj_Village_society = new Village_society();
		
		var SocietyId= document.getElementById("Input_SocietyId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var VillageSocietyId= document.getElementById("Input_VillageSocietyId").value;

		
		document.getElementById("Input_SocietyId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_VillageSocietyId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_society = new Village_society();
		obj_Village_society.SocietyId= SocietyId;
		obj_Village_society.VillageId= VillageId;
		obj_Village_society.VillageSocietyId= VillageSocietyId;

		
		var dummyId = CreateDummyNumber();
		AddVillage_societyPacket(dummyId,obj_Village_society);
		UI_createVillage_societyRow(obj_Village_society, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_society = new Village_society();

		obj_Village_society.SocietyId= SocietyId;
		obj_Village_society.VillageId= VillageId;
		obj_Village_society.VillageSocietyId= VillageSocietyId;

		
		UpdateVillage_societyPacket(obj_Village_society);
		UI_createVillage_societyRow(obj_Village_society, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_society() {
	
	UI_showAddVillage_societyForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_societyForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_societyAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_societyform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_societyForm(obj_Village_society) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_societyUpdateForm(obj_Village_society);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_societyform"));
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
function UI_prepareVillage_societyUpdateForm(obj_Village_society)
{
	var arr_hidelist = new Array("Input_VillageSocietyId");
	var arr_showlist = new Array("Input_SocietyId","Input_VillageId","Input_VillageSocietyId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SocietyId").value=obj_Village_society.SocietyId;
		document.getElementById("Input_VillageId").value=obj_Village_society.VillageId;
		document.getElementById("Input_VillageSocietyId").value=obj_Village_society.VillageSocietyId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_societyAddForm()
{
	var arr_hidelist = new Array("Input_VillageSocietyId");
	var arr_showlist = new Array("Input_SocietyId","Input_VillageId","Input_VillageSocietyId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SocietyId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_VillageSocietyId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_societyToVillage_societyList() {
	var uiVillage_societyList = document.getElementById("Village_societyList");

	var rowElems = uiVillage_societyList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_societyRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_societyRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_societyRowHtmlElem(obj_Village_society,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_societyImg_"+obj_Village_society.VillageSocietyId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_society/0_small.png";
	else ImgElem.src = "Village_society/"+obj_Village_society.VillageSocietyId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_society.SocietyId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_society.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_society.VillageSocietyId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_societydata"+ElemId);
		ElementDataHidden.value = obj_Village_society.getVillage_societyData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createVillage_societyRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_societyRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_societyRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_societyHtmlElem(obj_Village_society)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_society");
		html ="<a href=\"?page=dashboard&VillageSocietyId="+obj_Village_society.VillageSocietyId+"\">"+obj_Village_society.VillageSocietyId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_societyRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_societyRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_societyRow(obj_Village_society, rowType,dummyId) {
	var html = "";
	
	var UiVillage_societyList = document.getElementById("Village_societyList");
	var ClassName = "ListRow";
	var ElemId = "Village_societyListRow_"+obj_Village_society.VillageSocietyId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_societyRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_societyRowHtmlElem(obj_Village_society,ElemId, ClassName);
			UiVillage_societyList.insertBefore(ElemLi, UiVillage_societyList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_society msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_societyRowHtmlElem(obj_Village_society,ElemId, ClassName);
			UiVillage_societyList.insertBefore(ElemLi, UiVillage_societyList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_societyRow_"+dummyId);
			var DummyData = document.getElementById("Village_societydataDummyVillage_societyRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_societydata"+ElemId);		
				DummyData.value = obj_Village_society.getVillage_societyData();		
				}
				UI_createTopbarSubVillage_societyHtmlElem(obj_Village_society);
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
				var ElemLi = UI_createVillage_societyRowHtmlElem(obj_Village_society,ElemId, ClassName);
				UiVillage_societyList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_societyList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, VillageSocietyId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_societyListRow_"+VillageSocietyId);
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


