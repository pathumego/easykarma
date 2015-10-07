//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Organization_subtype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addOrganization_subtype(mainPacket);
			break;
		}
		case 201: {
			ACK_addOrganization_subtype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteOrganization_subtype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateOrganization_subtype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addOrganization_subtype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Organization_subtype = new Organization_subtype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Organization_subtype.OrganizationSubTypeId= mainPacket[3];
		obj_Organization_subtype.OrganizationSubTypeName= mainPacket[4];
		obj_Organization_subtype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createOrganization_subtypeRow(obj_Organization_subtype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteOrganization_subtype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Organization_subtype = new Organization_subtype();
		
		var resultStatus = mainPacket[0];
		var OrganizationSubTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Organization_subtypeListRow_"+OrganizationSubTypeId);
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
				var rowElem = document.getElementById("Organization_subtypeListRow_"+OrganizationSubTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateOrganization_subtype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Organization_subtype = new Organization_subtype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Organization_subtype.OrganizationSubTypeId= mainPacket[2];
		obj_Organization_subtype.OrganizationSubTypeName= mainPacket[3];
		obj_Organization_subtype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createOrganization_subtypeRow(obj_Organization_subtype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Organization_subtype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingOrganization_subtypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Organization_subtype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteOrganization_subtypePacket(OrganizationSubTypeId) {
	var deletePacketBody  = OrganizationSubTypeId;

	var postpacket = createOutgoingOrganization_subtypePacket(202,deletePacketBody);
	Organization_subtype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateOrganization_subtypePacket(obj_Organization_subtype) {
	var savePacketBody  = obj_Organization_subtype.createOrganization_subtypePacket();

	var postpacket = createOutgoingOrganization_subtypePacket(203,savePacketBody);
	Organization_subtype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddOrganization_subtypePacket(dummyId,obj_Organization_subtype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Organization_subtype.createOrganization_subtypePacket();

	var postpacket = createOutgoingOrganization_subtypePacket(201,savePacketBody);
	Organization_subtype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onOrganization_subtypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onOrganization_subtypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addOrganization_subtype = document.getElementById("btnaddOrganization_subtype");
	if(addOrganization_subtype){
	addOrganization_subtype.addEventListener('mousedown', Event_mousedown_addOrganization_subtype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popOrganization_subtypeform = document.getElementById("popOrganization_subtypeform");
	var inputElems = popOrganization_subtypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiOrganization_subtypeList = document.getElementById("Organization_subtypeList");
	var liElems = UiOrganization_subtypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverOrganization_subtypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutOrganization_subtypeRow, false);
		
	}
	
	var UiOrganization_subtypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiOrganization_subtypeListDeletebtns.length; z++) {
			UiOrganization_subtypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownOrganization_subtypeRowBtn, false);			
		
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
	UI_search_Organization_subtype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownOrganization_subtypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Organization_subtype = Get_Organization_subtypeByListRow(this.parentNode.parentNode);
			if(obj_Organization_subtype != ""){
				deleteOrganization_subtype(obj_Organization_subtype.OrganizationSubTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Organization_subtype = Get_Organization_subtypeByListRow(this.parentNode.parentNode);
			if(obj_Organization_subtype != ""){
				UI_showUpdateOrganization_subtypeForm(obj_Organization_subtype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Organization_subtype(searchText)
{

	//Organization_subtypeList = 
	var Organization_subtypeListElem = document.getElementById("Organization_subtypeList");
	
	if(Organization_subtypeListElem)
	{
		var Organization_subtypeDataList = Organization_subtypeListElem.getElementsByTagName("input");
		for(var y=0 in Organization_subtypeDataList)
		{
			if(Organization_subtypeDataList[y])
			{
				
				
				var displayType = "none";
				var Organization_subtypeData = Organization_subtypeDataList[y].value;
				if(!((Organization_subtypeData == "") || (typeof Organization_subtypeData=="undefined")))
				{
				if(search_Organization_subtype(Organization_subtypeData,searchText))
				{
					displayType = "block";
				}
				Organization_subtypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Organization_subtype(Organization_subtypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Organization_subtypeData = decodeSpText(Organization_subtypeData.toLowerCase());
	if(Organization_subtypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Organization_subtype)
{
	if (obj_Organization_subtype.OrganizationSubTypeId) {
		var fieldDataId = obj_Organization_subtype.OrganizationSubTypeId;
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

function deleteOrganization_subtype(OrganizationSubTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Organization_subtype");
	if(flag){
			DeleteOrganization_subtypePacket(OrganizationSubTypeId);
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

function Get_Organization_subtypeByListRow(listRowElem)
{
	
	var obj_Organization_subtype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Organization_subtypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Organization_subtypeData = elemlist[z].value;
			}		
		}
		
		if(Organization_subtypeData != "")
		{
		var arrOrganization_subtypeData = Organization_subtypeData.split(";");	
		
		obj_Organization_subtype = new Organization_subtype();
		obj_Organization_subtype.OrganizationSubTypeId= arrOrganization_subtypeData[0];
		obj_Organization_subtype.OrganizationSubTypeName= arrOrganization_subtypeData[1];
		obj_Organization_subtype.Description= arrOrganization_subtypeData[2];

		
		
		}
		
	}
	
	return obj_Organization_subtype;
	
	
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
	
				var Elem = document.getElementById("Input_OrganizationSubTypeName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the type";
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
	
		var obj_Organization_subtype = new Organization_subtype();
		
		var OrganizationSubTypeId= document.getElementById("Input_OrganizationSubTypeId").value;
		var OrganizationSubTypeName= document.getElementById("Input_OrganizationSubTypeName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_OrganizationSubTypeId").value="";
		document.getElementById("Input_OrganizationSubTypeName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Organization_subtype = new Organization_subtype();
		obj_Organization_subtype.OrganizationSubTypeId= OrganizationSubTypeId;
		obj_Organization_subtype.OrganizationSubTypeName= OrganizationSubTypeName;
		obj_Organization_subtype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddOrganization_subtypePacket(dummyId,obj_Organization_subtype);
		UI_createOrganization_subtypeRow(obj_Organization_subtype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Organization_subtype = new Organization_subtype();

		obj_Organization_subtype.OrganizationSubTypeId= OrganizationSubTypeId;
		obj_Organization_subtype.OrganizationSubTypeName= OrganizationSubTypeName;
		obj_Organization_subtype.Description= Description;

		
		UpdateOrganization_subtypePacket(obj_Organization_subtype);
		UI_createOrganization_subtypeRow(obj_Organization_subtype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addOrganization_subtype() {
	
	UI_showAddOrganization_subtypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddOrganization_subtypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOrganization_subtypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOrganization_subtypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateOrganization_subtypeForm(obj_Organization_subtype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOrganization_subtypeUpdateForm(obj_Organization_subtype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOrganization_subtypeform"));
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
function UI_prepareOrganization_subtypeUpdateForm(obj_Organization_subtype)
{
	var arr_hidelist = new Array("Input_OrganizationSubTypeId");
	var arr_showlist = new Array("Input_OrganizationSubTypeName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationSubTypeId").value=obj_Organization_subtype.OrganizationSubTypeId;
		document.getElementById("Input_OrganizationSubTypeName").value=obj_Organization_subtype.OrganizationSubTypeName;
		document.getElementById("Input_Description").value=obj_Organization_subtype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareOrganization_subtypeAddForm()
{
	var arr_hidelist = new Array("Input_OrganizationSubTypeId");
	var arr_showlist = new Array("Input_OrganizationSubTypeName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationSubTypeId").value="";
		document.getElementById("Input_OrganizationSubTypeName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addOrganization_subtypeToOrganization_subtypeList() {
	var uiOrganization_subtypeList = document.getElementById("Organization_subtypeList");

	var rowElems = uiOrganization_subtypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganization_subtypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownOrganization_subtypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganization_subtypeRowHtmlElem(obj_Organization_subtype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Organization_subtypeImg_"+obj_Organization_subtype.OrganizationSubTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Organization_subtype/0_small.png";
	else ImgElem.src = "Organization_subtype/"+obj_Organization_subtype.OrganizationSubTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Organization_subtype.OrganizationSubTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Organization_subtype.OrganizationSubTypeName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Organization_subtype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Organization_subtypedata"+ElemId);
		ElementDataHidden.value = obj_Organization_subtype.getOrganization_subtypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createOrganization_subtypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverOrganization_subtypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutOrganization_subtypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubOrganization_subtypeHtmlElem(obj_Organization_subtype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subOrganization_subtype");
		html ="<a href=\"?page=dashboard&OrganizationSubTypeId="+obj_Organization_subtype.OrganizationSubTypeId+"\">"+obj_Organization_subtype.OrganizationSubTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverOrganization_subtypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutOrganization_subtypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganization_subtypeRow(obj_Organization_subtype, rowType,dummyId) {
	var html = "";
	
	var UiOrganization_subtypeList = document.getElementById("Organization_subtypeList");
	var ClassName = "ListRow";
	var ElemId = "Organization_subtypeListRow_"+obj_Organization_subtype.OrganizationSubTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyOrganization_subtypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createOrganization_subtypeRowHtmlElem(obj_Organization_subtype,ElemId, ClassName);
			UiOrganization_subtypeList.insertBefore(ElemLi, UiOrganization_subtypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Organization_subtype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createOrganization_subtypeRowHtmlElem(obj_Organization_subtype,ElemId, ClassName);
			UiOrganization_subtypeList.insertBefore(ElemLi, UiOrganization_subtypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyOrganization_subtypeRow_"+dummyId);
			var DummyData = document.getElementById("Organization_subtypedataDummyOrganization_subtypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Organization_subtypedata"+ElemId);		
				DummyData.value = obj_Organization_subtype.getOrganization_subtypeData();		
				}
				UI_createTopbarSubOrganization_subtypeHtmlElem(obj_Organization_subtype);
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
				var ElemLi = UI_createOrganization_subtypeRowHtmlElem(obj_Organization_subtype,ElemId, ClassName);
				UiOrganization_subtypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Organization_subtypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, OrganizationSubTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Organization_subtypeListRow_"+OrganizationSubTypeId);
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


