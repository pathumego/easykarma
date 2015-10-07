//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_group_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_group(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_group(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_group(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_group(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_group(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_group = new Village_group();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_group.GroupId= mainPacket[3];
		obj_Village_group.VillageId= mainPacket[4];



		if (resultStatus == 1) {	
			
			UI_createVillage_groupRow(obj_Village_group, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_group(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_group = new Village_group();
		
		var resultStatus = mainPacket[0];
		var VillageId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_groupListRow_"+VillageId);
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
				var rowElem = document.getElementById("Village_groupListRow_"+VillageId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_group(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_group = new Village_group();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_group.GroupId= mainPacket[2];
		obj_Village_group.VillageId= mainPacket[3];


		if (resultStatus == 1) {			
			UI_createVillage_groupRow(obj_Village_group, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_group_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_groupPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_group; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_groupPacket(VillageId) {
	var deletePacketBody  = VillageId;

	var postpacket = createOutgoingVillage_groupPacket(202,deletePacketBody);
	Village_group_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_groupPacket(obj_Village_group) {
	var savePacketBody  = obj_Village_group.createVillage_groupPacket();

	var postpacket = createOutgoingVillage_groupPacket(203,savePacketBody);
	Village_group_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_groupPacket(dummyId,obj_Village_group) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_group.createVillage_groupPacket();

	var postpacket = createOutgoingVillage_groupPacket(201,savePacketBody);
	Village_group_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_groupPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_groupPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_group = document.getElementById("btnaddVillage_group");
	if(addVillage_group){
	addVillage_group.addEventListener('mousedown', Event_mousedown_addVillage_group, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_groupform = document.getElementById("popVillage_groupform");
	var inputElems = popVillage_groupform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_groupList = document.getElementById("Village_groupList");
	var liElems = UiVillage_groupList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_groupRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_groupRow, false);
		
	}
	
	var UiVillage_groupListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_groupListDeletebtns.length; z++) {
			UiVillage_groupListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_groupRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_GroupId","GroupName",9); //group
	
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
	UI_search_Village_group(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_groupRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_group = Get_Village_groupByListRow(this.parentNode.parentNode);
			if(obj_Village_group != ""){
				deleteVillage_group(obj_Village_group.VillageId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_group = Get_Village_groupByListRow(this.parentNode.parentNode);
			if(obj_Village_group != ""){
				UI_showUpdateVillage_groupForm(obj_Village_group);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_group(searchText)
{

	//Village_groupList = 
	var Village_groupListElem = document.getElementById("Village_groupList");
	
	if(Village_groupListElem)
	{
		var Village_groupDataList = Village_groupListElem.getElementsByTagName("input");
		for(var y=0 in Village_groupDataList)
		{
			if(Village_groupDataList[y])
			{
				
				
				var displayType = "none";
				var Village_groupData = Village_groupDataList[y].value;
				if(!((Village_groupData == "") || (typeof Village_groupData=="undefined")))
				{
				if(search_Village_group(Village_groupData,searchText))
				{
					displayType = "block";
				}
				Village_groupDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_group(Village_groupData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_groupData = decodeSpText(Village_groupData.toLowerCase());
	if(Village_groupData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_group)
{
	if (obj_Village_group.VillageId) {
		var fieldDataId = obj_Village_group.VillageId;
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

function deleteVillage_group(VillageId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_group");
	if(flag){
			DeleteVillage_groupPacket(VillageId);
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

function Get_Village_groupByListRow(listRowElem)
{
	
	var obj_Village_group ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_groupData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_groupData = elemlist[z].value;
			}		
		}
		
		if(Village_groupData != "")
		{
		var arrVillage_groupData = Village_groupData.split(";");	
		
		obj_Village_group = new Village_group();
		obj_Village_group.GroupId= arrVillage_groupData[0];
		obj_Village_group.VillageId= arrVillage_groupData[1];

		
		
		}
		
	}
	
	return obj_Village_group;
	
	
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
	

		var Elem = document.getElementById("Input_Village_groupPrice");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Village_group price";
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
			
		    Elem = document.getElementById("Input_Village_groupName");
			if(Elem)
			{
				if(Elem.value =="")
				{
				Elem.focus();
				iserror =true;
				error = "Please enter Village_group name";	
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
	
		var obj_Village_group = new Village_group();
		
		var GroupId= document.getElementById("Input_GroupId").value;
		var VillageId= document.getElementById("Input_VillageId").value;

		
		document.getElementById("Input_GroupId").value="";
		document.getElementById("Input_VillageId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_group = new Village_group();
		obj_Village_group.GroupId= GroupId;
		obj_Village_group.VillageId= VillageId;

		
		var dummyId = CreateDummyNumber();
		AddVillage_groupPacket(dummyId,obj_Village_group);
		UI_createVillage_groupRow(obj_Village_group, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_group = new Village_group();

		obj_Village_group.GroupId= GroupId;
		obj_Village_group.VillageId= VillageId;

		
		UpdateVillage_groupPacket(obj_Village_group);
		UI_createVillage_groupRow(obj_Village_group, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_group() {
	
	UI_showAddVillage_groupForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_groupForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_groupAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_groupform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_groupForm(obj_Village_group) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_groupUpdateForm(obj_Village_group);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_groupform"));
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
function UI_prepareVillage_groupUpdateForm(obj_Village_group)
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_GroupId","Input_VillageId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GroupId").value=obj_Village_group.GroupId;
		document.getElementById("Input_VillageId").value=obj_Village_group.VillageId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_groupAddForm()
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_GroupId","Input_VillageId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GroupId").value="";
		document.getElementById("Input_VillageId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_groupToVillage_groupList() {
	var uiVillage_groupList = document.getElementById("Village_groupList");

	var rowElems = uiVillage_groupList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_groupRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_groupRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_groupRowHtmlElem(obj_Village_group,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_groupImg_"+obj_Village_group.VillageId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_group/0_small.png";
	else ImgElem.src = "Village_group/"+obj_Village_group.VillageId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_group.GroupId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_group.VillageId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_groupdata"+ElemId);
		ElementDataHidden.value = obj_Village_group.getVillage_groupData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);

		
		ElemLi= UI_createVillage_groupRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_groupRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_groupRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_groupHtmlElem(obj_Village_group)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_group");
		html ="<a href=\"?page=dashboard&VillageId="+obj_Village_group.VillageId+"\">"+obj_Village_group.VillageId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_groupRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_groupRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_groupRow(obj_Village_group, rowType,dummyId) {
	var html = "";
	
	var UiVillage_groupList = document.getElementById("Village_groupList");
	var ClassName = "ListRow";
	var ElemId = "Village_groupListRow_"+obj_Village_group.VillageId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_groupRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_groupRowHtmlElem(obj_Village_group,ElemId, ClassName);
			UiVillage_groupList.insertBefore(ElemLi, UiVillage_groupList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_group msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_groupRowHtmlElem(obj_Village_group,ElemId, ClassName);
			UiVillage_groupList.insertBefore(ElemLi, UiVillage_groupList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_groupRow_"+dummyId);
			var DummyData = document.getElementById("Village_groupdataDummyVillage_groupRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_groupdata"+ElemId);		
				DummyData.value = obj_Village_group.getVillage_groupData();		
				}
				UI_createTopbarSubVillage_groupHtmlElem(obj_Village_group);
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
				var ElemLi = UI_createVillage_groupRowHtmlElem(obj_Village_group,ElemId, ClassName);
				UiVillage_groupList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_groupList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, VillageId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_groupListRow_"+VillageId);
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


