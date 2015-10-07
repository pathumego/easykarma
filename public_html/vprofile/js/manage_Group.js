//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Group_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addGroup(mainPacket);
			break;
		}
		case 201: {
			ACK_addGroup(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteGroup(mainPacket);
			break;
		}
		case 203: {
			ACK_updateGroup(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addGroup(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Group = new Group();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Group.GroupId= mainPacket[3];
		obj_Group.GroupName= mainPacket[4];
		obj_Group.GroupPrimaryType= mainPacket[5];
		obj_Group.GroupMissionTypeId= mainPacket[6];
		obj_Group.GroupAddress= mainPacket[7];



		if (resultStatus == 1) {	
			
			UI_createGroupRow(obj_Group, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteGroup(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Group = new Group();
		
		var resultStatus = mainPacket[0];
		var GroupId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("GroupListRow_"+GroupId);
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
				var rowElem = document.getElementById("GroupListRow_"+GroupId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateGroup(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Group = new Group();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Group.GroupId= mainPacket[2];
		obj_Group.GroupName= mainPacket[3];
		obj_Group.GroupPrimaryType= mainPacket[4];
		obj_Group.GroupMissionTypeId= mainPacket[5];
		obj_Group.GroupAddress= mainPacket[6];


		if (resultStatus == 1) {			
			UI_createGroupRow(obj_Group, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Group_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingGroupPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Group; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteGroupPacket(GroupId) {
	var deletePacketBody  = GroupId;

	var postpacket = createOutgoingGroupPacket(202,deletePacketBody);
	Group_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateGroupPacket(obj_Group) {
	var savePacketBody  = obj_Group.createGroupPacket();

	var postpacket = createOutgoingGroupPacket(203,savePacketBody);
	Group_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddGroupPacket(dummyId,obj_Group) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Group.createGroupPacket();

	var postpacket = createOutgoingGroupPacket(201,savePacketBody);
	Group_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onGroupPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onGroupPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addGroup = document.getElementById("btnaddGroup");
	if(addGroup){
	addGroup.addEventListener('mousedown', Event_mousedown_addGroup, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popGroupform = document.getElementById("popGroupform");
	var inputElems = popGroupform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiGroupList = document.getElementById("GroupList");
	var liElems = UiGroupList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverGroupRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutGroupRow, false);
		
	}
	
	var UiGroupListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiGroupListDeletebtns.length; z++) {
			UiGroupListDeletebtns[z].addEventListener('mousedown', Event_mouseDownGroupRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_GroupMissionTypeId","GroupMissionTypeName",11); //group mission type
	
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
	UI_search_Group(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownGroupRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Group = Get_GroupByListRow(this.parentNode.parentNode);
			if(obj_Group != ""){
				deleteGroup(obj_Group.GroupId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Group = Get_GroupByListRow(this.parentNode.parentNode);
			if(obj_Group != ""){
				UI_showUpdateGroupForm(obj_Group);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Group(searchText)
{

	//GroupList = 
	var GroupListElem = document.getElementById("GroupList");
	
	if(GroupListElem)
	{
		var GroupDataList = GroupListElem.getElementsByTagName("input");
		for(var y=0 in GroupDataList)
		{
			if(GroupDataList[y])
			{
				
				
				var displayType = "none";
				var GroupData = GroupDataList[y].value;
				if(!((GroupData == "") || (typeof GroupData=="undefined")))
				{
				if(search_Group(GroupData,searchText))
				{
					displayType = "block";
				}
				GroupDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Group(GroupData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	GroupData = decodeSpText(GroupData.toLowerCase());
	if(GroupData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Group)
{
	if (obj_Group.GroupId) {
		var fieldDataId = obj_Group.GroupId;
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

function deleteGroup(GroupId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Group");
	if(flag){
			DeleteGroupPacket(GroupId);
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

function Get_GroupByListRow(listRowElem)
{
	
	var obj_Group ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var GroupData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				GroupData = elemlist[z].value;
			}		
		}
		
		if(GroupData != "")
		{
		var arrGroupData = GroupData.split(";");	
		
		obj_Group = new Group();
		obj_Group.GroupId= arrGroupData[0];
		obj_Group.GroupName= arrGroupData[1];
		obj_Group.GroupPrimaryType= arrGroupData[2];
		obj_Group.GroupMissionTypeId= arrGroupData[3];
		obj_Group.GroupAddress= arrGroupData[4];

		
		
		}
		
	}
	
	return obj_Group;
	
	
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
	

		var Elem = document.getElementById("Input_GroupName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Group Name";
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
	
		var obj_Group = new Group();
		
		var GroupId= document.getElementById("Input_GroupId").value;
		var GroupName= document.getElementById("Input_GroupName").value;
		var GroupPrimaryType= document.getElementById("Input_GroupPrimaryType").value;
		var GroupMissionTypeId= document.getElementById("Input_GroupMissionTypeId").value;
		var GroupAddress= document.getElementById("Input_GroupAddress").value;

		
		document.getElementById("Input_GroupId").value="";
		document.getElementById("Input_GroupName").value="";
		document.getElementById("Input_GroupPrimaryType").value="";
		document.getElementById("Input_GroupMissionTypeId").value="";
		document.getElementById("Input_GroupAddress").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Group = new Group();
		obj_Group.GroupId= GroupId;
		obj_Group.GroupName= GroupName;
		obj_Group.GroupPrimaryType= GroupPrimaryType;
		obj_Group.GroupMissionTypeId= GroupMissionTypeId;
		obj_Group.GroupAddress= GroupAddress;

		
		var dummyId = CreateDummyNumber();
		AddGroupPacket(dummyId,obj_Group);
		UI_createGroupRow(obj_Group, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Group = new Group();

		obj_Group.GroupId= GroupId;
		obj_Group.GroupName= GroupName;
		obj_Group.GroupPrimaryType= GroupPrimaryType;
		obj_Group.GroupMissionTypeId= GroupMissionTypeId;
		obj_Group.GroupAddress= GroupAddress;

		
		UpdateGroupPacket(obj_Group);
		UI_createGroupRow(obj_Group, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addGroup() {
	
	UI_showAddGroupForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddGroupForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGroupAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGroupform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateGroupForm(obj_Group) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGroupUpdateForm(obj_Group);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGroupform"));
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
function UI_prepareGroupUpdateForm(obj_Group)
{
	var arr_hidelist = new Array("Input_GroupId","Input_GroupPrimaryType");
	var arr_showlist = new Array("Input_GroupName","Input_GroupPrimaryType","Input_GroupAddress","Input_GroupMissionTypeId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GroupId").value=obj_Group.GroupId;
		document.getElementById("Input_GroupName").value=obj_Group.GroupName;
		document.getElementById("Input_GroupPrimaryType").value=obj_Group.GroupPrimaryType;
		document.getElementById("Input_GroupMissionTypeId").value=obj_Group.GroupMissionTypeId;
		document.getElementById("Input_GroupAddress").value=obj_Group.GroupAddress;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareGroupAddForm()
{
	var arr_hidelist = new Array("Input_GroupId","Input_GroupPrimaryType");
	var arr_showlist = new Array("Input_GroupName","Input_GroupAddress","Input_GroupMissionTypeId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GroupId").value="";
		document.getElementById("Input_GroupName").value="";
		document.getElementById("Input_GroupPrimaryType").value="";
		document.getElementById("Input_GroupMissionTypeId").value="";
		document.getElementById("Input_GroupAddress").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addGroupToGroupList() {
	var uiGroupList = document.getElementById("GroupList");

	var rowElems = uiGroupList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createGroupRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownGroupRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGroupRowHtmlElem(obj_Group,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "GroupImg_"+obj_Group.GroupId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Group/0_small.png";
	else ImgElem.src = "Group/"+obj_Group.GroupId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Group.GroupId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Group.GroupName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Group.GroupPrimaryType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Group.GroupMissionTypeId;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Group.GroupAddress;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Groupdata"+ElemId);
		ElementDataHidden.value = obj_Group.getGroupData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);

		
		ElemLi= UI_createGroupRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverGroupRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutGroupRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubGroupHtmlElem(obj_Group)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subGroup");
		html ="<a href=\"?page=dashboard&GroupId="+obj_Group.GroupId+"\">"+obj_Group.GroupId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverGroupRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutGroupRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGroupRow(obj_Group, rowType,dummyId) {
	var html = "";
	
	var UiGroupList = document.getElementById("GroupList");
	var ClassName = "ListRow";
	var ElemId = "GroupListRow_"+obj_Group.GroupId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyGroupRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createGroupRowHtmlElem(obj_Group,ElemId, ClassName);
			UiGroupList.insertBefore(ElemLi, UiGroupList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Group msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createGroupRowHtmlElem(obj_Group,ElemId, ClassName);
			UiGroupList.insertBefore(ElemLi, UiGroupList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyGroupRow_"+dummyId);
			var DummyData = document.getElementById("GroupdataDummyGroupRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Groupdata"+ElemId);		
				DummyData.value = obj_Group.getGroupData();		
				}
				UI_createTopbarSubGroupHtmlElem(obj_Group);
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
				var ElemLi = UI_createGroupRowHtmlElem(obj_Group,ElemId, ClassName);
				UiGroupList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("GroupList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, GroupId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("GroupListRow_"+GroupId);
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


