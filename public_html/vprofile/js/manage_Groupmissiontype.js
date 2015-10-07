//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Groupmissiontype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addGroupmissiontype(mainPacket);
			break;
		}
		case 201: {
			ACK_addGroupmissiontype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteGroupmissiontype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateGroupmissiontype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addGroupmissiontype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Groupmissiontype = new Groupmissiontype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Groupmissiontype.GroupMissionTypeId= mainPacket[3];
		obj_Groupmissiontype.GroupMissionTypeName= mainPacket[4];
		obj_Groupmissiontype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createGroupmissiontypeRow(obj_Groupmissiontype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteGroupmissiontype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Groupmissiontype = new Groupmissiontype();
		
		var resultStatus = mainPacket[0];
		var GroupMissionTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("GroupmissiontypeListRow_"+GroupMissionTypeId);
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
				var rowElem = document.getElementById("GroupmissiontypeListRow_"+GroupMissionTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateGroupmissiontype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Groupmissiontype = new Groupmissiontype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Groupmissiontype.GroupMissionTypeId= mainPacket[2];
		obj_Groupmissiontype.GroupMissionTypeName= mainPacket[3];
		obj_Groupmissiontype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createGroupmissiontypeRow(obj_Groupmissiontype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Groupmissiontype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingGroupmissiontypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Groupmissiontype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteGroupmissiontypePacket(GroupMissionTypeId) {
	var deletePacketBody  = GroupMissionTypeId;

	var postpacket = createOutgoingGroupmissiontypePacket(202,deletePacketBody);
	Groupmissiontype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateGroupmissiontypePacket(obj_Groupmissiontype) {
	var savePacketBody  = obj_Groupmissiontype.createGroupmissiontypePacket();

	var postpacket = createOutgoingGroupmissiontypePacket(203,savePacketBody);
	Groupmissiontype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddGroupmissiontypePacket(dummyId,obj_Groupmissiontype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Groupmissiontype.createGroupmissiontypePacket();

	var postpacket = createOutgoingGroupmissiontypePacket(201,savePacketBody);
	Groupmissiontype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onGroupmissiontypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onGroupmissiontypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addGroupmissiontype = document.getElementById("btnaddGroupmissiontype");
	if(addGroupmissiontype){
	addGroupmissiontype.addEventListener('mousedown', Event_mousedown_addGroupmissiontype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popGroupmissiontypeform = document.getElementById("popGroupmissiontypeform");
	var inputElems = popGroupmissiontypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiGroupmissiontypeList = document.getElementById("GroupmissiontypeList");
	var liElems = UiGroupmissiontypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverGroupmissiontypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutGroupmissiontypeRow, false);
		
	}
	
	var UiGroupmissiontypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiGroupmissiontypeListDeletebtns.length; z++) {
			UiGroupmissiontypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownGroupmissiontypeRowBtn, false);			
		
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
	UI_search_Groupmissiontype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownGroupmissiontypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Groupmissiontype = Get_GroupmissiontypeByListRow(this.parentNode.parentNode);
			if(obj_Groupmissiontype != ""){
				deleteGroupmissiontype(obj_Groupmissiontype.GroupMissionTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Groupmissiontype = Get_GroupmissiontypeByListRow(this.parentNode.parentNode);
			if(obj_Groupmissiontype != ""){
				UI_showUpdateGroupmissiontypeForm(obj_Groupmissiontype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Groupmissiontype(searchText)
{

	//GroupmissiontypeList = 
	var GroupmissiontypeListElem = document.getElementById("GroupmissiontypeList");
	
	if(GroupmissiontypeListElem)
	{
		var GroupmissiontypeDataList = GroupmissiontypeListElem.getElementsByTagName("input");
		for(var y=0 in GroupmissiontypeDataList)
		{
			if(GroupmissiontypeDataList[y])
			{
				
				
				var displayType = "none";
				var GroupmissiontypeData = GroupmissiontypeDataList[y].value;
				if(!((GroupmissiontypeData == "") || (typeof GroupmissiontypeData=="undefined")))
				{
				if(search_Groupmissiontype(GroupmissiontypeData,searchText))
				{
					displayType = "block";
				}
				GroupmissiontypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Groupmissiontype(GroupmissiontypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	GroupmissiontypeData = decodeSpText(GroupmissiontypeData.toLowerCase());
	if(GroupmissiontypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Groupmissiontype)
{
	if (obj_Groupmissiontype.GroupMissionTypeId) {
		var fieldDataId = obj_Groupmissiontype.GroupMissionTypeId;
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

function deleteGroupmissiontype(GroupMissionTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Groupmissiontype");
	if(flag){
			DeleteGroupmissiontypePacket(GroupMissionTypeId);
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

function Get_GroupmissiontypeByListRow(listRowElem)
{
	
	var obj_Groupmissiontype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var GroupmissiontypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				GroupmissiontypeData = elemlist[z].value;
			}		
		}
		
		if(GroupmissiontypeData != "")
		{
		var arrGroupmissiontypeData = GroupmissiontypeData.split(";");	
		
		obj_Groupmissiontype = new Groupmissiontype();
		obj_Groupmissiontype.GroupMissionTypeId= arrGroupmissiontypeData[0];
		obj_Groupmissiontype.GroupMissionTypeName= arrGroupmissiontypeData[1];
		obj_Groupmissiontype.Description= arrGroupmissiontypeData[2];

		
		
		}
		
	}
	
	return obj_Groupmissiontype;
	
	
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
	

					var Elem = document.getElementById("Input_GroupMissionTypeName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter group mission name";
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
	
		var obj_Groupmissiontype = new Groupmissiontype();
		
		var GroupMissionTypeId= document.getElementById("Input_GroupMissionTypeId").value;
		var GroupMissionTypeName= document.getElementById("Input_GroupMissionTypeName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_GroupMissionTypeId").value="";
		document.getElementById("Input_GroupMissionTypeName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Groupmissiontype = new Groupmissiontype();
		obj_Groupmissiontype.GroupMissionTypeId= GroupMissionTypeId;
		obj_Groupmissiontype.GroupMissionTypeName= GroupMissionTypeName;
		obj_Groupmissiontype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddGroupmissiontypePacket(dummyId,obj_Groupmissiontype);
		UI_createGroupmissiontypeRow(obj_Groupmissiontype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Groupmissiontype = new Groupmissiontype();

		obj_Groupmissiontype.GroupMissionTypeId= GroupMissionTypeId;
		obj_Groupmissiontype.GroupMissionTypeName= GroupMissionTypeName;
		obj_Groupmissiontype.Description= Description;

		
		UpdateGroupmissiontypePacket(obj_Groupmissiontype);
		UI_createGroupmissiontypeRow(obj_Groupmissiontype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addGroupmissiontype() {
	
	UI_showAddGroupmissiontypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddGroupmissiontypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGroupmissiontypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGroupmissiontypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateGroupmissiontypeForm(obj_Groupmissiontype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGroupmissiontypeUpdateForm(obj_Groupmissiontype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGroupmissiontypeform"));
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
function UI_prepareGroupmissiontypeUpdateForm(obj_Groupmissiontype)
{
	var arr_hidelist = new Array("Input_GroupMissionTypeId");
	var arr_showlist = new Array("Input_GroupMissionTypeName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GroupMissionTypeId").value=obj_Groupmissiontype.GroupMissionTypeId;
		document.getElementById("Input_GroupMissionTypeName").value=obj_Groupmissiontype.GroupMissionTypeName;
		document.getElementById("Input_Description").value=obj_Groupmissiontype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareGroupmissiontypeAddForm()
{
	var arr_hidelist = new Array("Input_GroupMissionTypeId");
	var arr_showlist = new Array("Input_GroupMissionTypeName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GroupMissionTypeId").value="";
		document.getElementById("Input_GroupMissionTypeName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addGroupmissiontypeToGroupmissiontypeList() {
	var uiGroupmissiontypeList = document.getElementById("GroupmissiontypeList");

	var rowElems = uiGroupmissiontypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createGroupmissiontypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownGroupmissiontypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGroupmissiontypeRowHtmlElem(obj_Groupmissiontype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "GroupmissiontypeImg_"+obj_Groupmissiontype.GroupMissionTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Groupmissiontype/0_small.png";
	else ImgElem.src = "Groupmissiontype/"+obj_Groupmissiontype.GroupMissionTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Groupmissiontype.GroupMissionTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Groupmissiontype.GroupMissionTypeName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Groupmissiontype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Groupmissiontypedata"+ElemId);
		ElementDataHidden.value = obj_Groupmissiontype.getGroupmissiontypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createGroupmissiontypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverGroupmissiontypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutGroupmissiontypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubGroupmissiontypeHtmlElem(obj_Groupmissiontype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subGroupmissiontype");
		html ="<a href=\"?page=dashboard&GroupMissionTypeId="+obj_Groupmissiontype.GroupMissionTypeId+"\">"+obj_Groupmissiontype.GroupMissionTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverGroupmissiontypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutGroupmissiontypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGroupmissiontypeRow(obj_Groupmissiontype, rowType,dummyId) {
	var html = "";
	
	var UiGroupmissiontypeList = document.getElementById("GroupmissiontypeList");
	var ClassName = "ListRow";
	var ElemId = "GroupmissiontypeListRow_"+obj_Groupmissiontype.GroupMissionTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyGroupmissiontypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createGroupmissiontypeRowHtmlElem(obj_Groupmissiontype,ElemId, ClassName);
			UiGroupmissiontypeList.insertBefore(ElemLi, UiGroupmissiontypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Groupmissiontype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createGroupmissiontypeRowHtmlElem(obj_Groupmissiontype,ElemId, ClassName);
			UiGroupmissiontypeList.insertBefore(ElemLi, UiGroupmissiontypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyGroupmissiontypeRow_"+dummyId);
			var DummyData = document.getElementById("GroupmissiontypedataDummyGroupmissiontypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Groupmissiontypedata"+ElemId);		
				DummyData.value = obj_Groupmissiontype.getGroupmissiontypeData();		
				}
				UI_createTopbarSubGroupmissiontypeHtmlElem(obj_Groupmissiontype);
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
				var ElemLi = UI_createGroupmissiontypeRowHtmlElem(obj_Groupmissiontype,ElemId, ClassName);
				UiGroupmissiontypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("GroupmissiontypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, GroupMissionTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("GroupmissiontypeListRow_"+GroupMissionTypeId);
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


