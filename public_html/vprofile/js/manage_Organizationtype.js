//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Organizationtype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addOrganizationtype(mainPacket);
			break;
		}
		case 201: {
			ACK_addOrganizationtype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteOrganizationtype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateOrganizationtype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addOrganizationtype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Organizationtype = new Organizationtype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Organizationtype.OrganizationTypeId= mainPacket[3];
		obj_Organizationtype.OrganizationTypeName= mainPacket[4];
		obj_Organizationtype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createOrganizationtypeRow(obj_Organizationtype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteOrganizationtype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Organizationtype = new Organizationtype();
		
		var resultStatus = mainPacket[0];
		var OrganizationTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("OrganizationtypeListRow_"+OrganizationTypeId);
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
				var rowElem = document.getElementById("OrganizationtypeListRow_"+OrganizationTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateOrganizationtype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Organizationtype = new Organizationtype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Organizationtype.OrganizationTypeId= mainPacket[2];
		obj_Organizationtype.OrganizationTypeName= mainPacket[3];
		obj_Organizationtype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createOrganizationtypeRow(obj_Organizationtype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Organizationtype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingOrganizationtypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Organizationtype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteOrganizationtypePacket(OrganizationTypeId) {
	var deletePacketBody  = OrganizationTypeId;

	var postpacket = createOutgoingOrganizationtypePacket(202,deletePacketBody);
	Organizationtype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateOrganizationtypePacket(obj_Organizationtype) {
	var savePacketBody  = obj_Organizationtype.createOrganizationtypePacket();

	var postpacket = createOutgoingOrganizationtypePacket(203,savePacketBody);
	Organizationtype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddOrganizationtypePacket(dummyId,obj_Organizationtype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Organizationtype.createOrganizationtypePacket();

	var postpacket = createOutgoingOrganizationtypePacket(201,savePacketBody);
	Organizationtype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onOrganizationtypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onOrganizationtypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addOrganizationtype = document.getElementById("btnaddOrganizationtype");
	if(addOrganizationtype){
	addOrganizationtype.addEventListener('mousedown', Event_mousedown_addOrganizationtype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popOrganizationtypeform = document.getElementById("popOrganizationtypeform");
	var inputElems = popOrganizationtypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiOrganizationtypeList = document.getElementById("OrganizationtypeList");
	var liElems = UiOrganizationtypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverOrganizationtypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutOrganizationtypeRow, false);
		
	}
	
	var UiOrganizationtypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiOrganizationtypeListDeletebtns.length; z++) {
			UiOrganizationtypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownOrganizationtypeRowBtn, false);			
		
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
	UI_search_Organizationtype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownOrganizationtypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Organizationtype = Get_OrganizationtypeByListRow(this.parentNode.parentNode);
			if(obj_Organizationtype != ""){
				deleteOrganizationtype(obj_Organizationtype.OrganizationTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Organizationtype = Get_OrganizationtypeByListRow(this.parentNode.parentNode);
			if(obj_Organizationtype != ""){
				UI_showUpdateOrganizationtypeForm(obj_Organizationtype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Organizationtype(searchText)
{

	//OrganizationtypeList = 
	var OrganizationtypeListElem = document.getElementById("OrganizationtypeList");
	
	if(OrganizationtypeListElem)
	{
		var OrganizationtypeDataList = OrganizationtypeListElem.getElementsByTagName("input");
		for(var y=0 in OrganizationtypeDataList)
		{
			if(OrganizationtypeDataList[y])
			{
				
				
				var displayType = "none";
				var OrganizationtypeData = OrganizationtypeDataList[y].value;
				if(!((OrganizationtypeData == "") || (typeof OrganizationtypeData=="undefined")))
				{
				if(search_Organizationtype(OrganizationtypeData,searchText))
				{
					displayType = "block";
				}
				OrganizationtypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Organizationtype(OrganizationtypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	OrganizationtypeData = decodeSpText(OrganizationtypeData.toLowerCase());
	if(OrganizationtypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Organizationtype)
{
	if (obj_Organizationtype.OrganizationTypeId) {
		var fieldDataId = obj_Organizationtype.OrganizationTypeId;
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

function deleteOrganizationtype(OrganizationTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Organizationtype");
	if(flag){
			DeleteOrganizationtypePacket(OrganizationTypeId);
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

function Get_OrganizationtypeByListRow(listRowElem)
{
	
	var obj_Organizationtype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var OrganizationtypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				OrganizationtypeData = elemlist[z].value;
			}		
		}
		
		if(OrganizationtypeData != "")
		{
		var arrOrganizationtypeData = OrganizationtypeData.split(";");	
		
		obj_Organizationtype = new Organizationtype();
		obj_Organizationtype.OrganizationTypeId= arrOrganizationtypeData[0];
		obj_Organizationtype.OrganizationTypeName= arrOrganizationtypeData[1];
		obj_Organizationtype.Description= arrOrganizationtypeData[2];

		
		
		}
		
	}
	
	return obj_Organizationtype;
	
	
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
	

	
			var Elem = document.getElementById("Input_OrganizationTypeName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Organisational Type";
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
	
		var obj_Organizationtype = new Organizationtype();
		
		var OrganizationTypeId= document.getElementById("Input_OrganizationTypeId").value;
		var OrganizationTypeName= document.getElementById("Input_OrganizationTypeName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_OrganizationTypeId").value="";
		document.getElementById("Input_OrganizationTypeName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Organizationtype = new Organizationtype();
		obj_Organizationtype.OrganizationTypeId= OrganizationTypeId;
		obj_Organizationtype.OrganizationTypeName= OrganizationTypeName;
		obj_Organizationtype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddOrganizationtypePacket(dummyId,obj_Organizationtype);
		UI_createOrganizationtypeRow(obj_Organizationtype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Organizationtype = new Organizationtype();

		obj_Organizationtype.OrganizationTypeId= OrganizationTypeId;
		obj_Organizationtype.OrganizationTypeName= OrganizationTypeName;
		obj_Organizationtype.Description= Description;

		
		UpdateOrganizationtypePacket(obj_Organizationtype);
		UI_createOrganizationtypeRow(obj_Organizationtype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addOrganizationtype() {
	
	UI_showAddOrganizationtypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddOrganizationtypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOrganizationtypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOrganizationtypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateOrganizationtypeForm(obj_Organizationtype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOrganizationtypeUpdateForm(obj_Organizationtype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOrganizationtypeform"));
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
function UI_prepareOrganizationtypeUpdateForm(obj_Organizationtype)
{
	var arr_hidelist = new Array("Input_OrganizationTypeId");
	var arr_showlist = new Array("Input_OrganizationTypeId","Input_OrganizationTypeName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationTypeId").value=obj_Organizationtype.OrganizationTypeId;
		document.getElementById("Input_OrganizationTypeName").value=obj_Organizationtype.OrganizationTypeName;
		document.getElementById("Input_Description").value=obj_Organizationtype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareOrganizationtypeAddForm()
{
	var arr_hidelist = new Array("Input_OrganizationTypeId");
	var arr_showlist = new Array("Input_OrganizationTypeId","Input_OrganizationTypeName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationTypeId").value="";
		document.getElementById("Input_OrganizationTypeName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addOrganizationtypeToOrganizationtypeList() {
	var uiOrganizationtypeList = document.getElementById("OrganizationtypeList");

	var rowElems = uiOrganizationtypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganizationtypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownOrganizationtypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganizationtypeRowHtmlElem(obj_Organizationtype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "OrganizationtypeImg_"+obj_Organizationtype.OrganizationTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Organizationtype/0_small.png";
	else ImgElem.src = "Organizationtype/"+obj_Organizationtype.OrganizationTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Organizationtype.OrganizationTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Organizationtype.OrganizationTypeName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Organizationtype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Organizationtypedata"+ElemId);
		ElementDataHidden.value = obj_Organizationtype.getOrganizationtypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createOrganizationtypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverOrganizationtypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutOrganizationtypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubOrganizationtypeHtmlElem(obj_Organizationtype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subOrganizationtype");
		html ="<a href=\"?page=dashboard&OrganizationTypeId="+obj_Organizationtype.OrganizationTypeId+"\">"+obj_Organizationtype.OrganizationTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverOrganizationtypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutOrganizationtypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganizationtypeRow(obj_Organizationtype, rowType,dummyId) {
	var html = "";
	
	var UiOrganizationtypeList = document.getElementById("OrganizationtypeList");
	var ClassName = "ListRow";
	var ElemId = "OrganizationtypeListRow_"+obj_Organizationtype.OrganizationTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyOrganizationtypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createOrganizationtypeRowHtmlElem(obj_Organizationtype,ElemId, ClassName);
			UiOrganizationtypeList.insertBefore(ElemLi, UiOrganizationtypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Organizationtype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createOrganizationtypeRowHtmlElem(obj_Organizationtype,ElemId, ClassName);
			UiOrganizationtypeList.insertBefore(ElemLi, UiOrganizationtypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyOrganizationtypeRow_"+dummyId);
			var DummyData = document.getElementById("OrganizationtypedataDummyOrganizationtypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Organizationtypedata"+ElemId);		
				DummyData.value = obj_Organizationtype.getOrganizationtypeData();		
				}
				UI_createTopbarSubOrganizationtypeHtmlElem(obj_Organizationtype);
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
				var ElemLi = UI_createOrganizationtypeRowHtmlElem(obj_Organizationtype,ElemId, ClassName);
				UiOrganizationtypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("OrganizationtypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, OrganizationTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("OrganizationtypeListRow_"+OrganizationTypeId);
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


