//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Group_member_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addGroup_member(mainPacket);
			break;
		}
		case 201: {
			ACK_addGroup_member(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteGroup_member(mainPacket);
			break;
		}
		case 203: {
			ACK_updateGroup_member(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addGroup_member(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Group_member = new Group_member();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Group_member.GroupId= mainPacket[3];
		obj_Group_member.MemberId= mainPacket[4];
		obj_Group_member.MemberType= mainPacket[5];
		obj_Group_member.MemberDate= mainPacket[6];
		obj_Group_member.Description= mainPacket[7];



		if (resultStatus == 1) {	
			
			UI_createGroup_memberRow(obj_Group_member, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteGroup_member(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Group_member = new Group_member();
		
		var resultStatus = mainPacket[0];
		var MemberId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Group_memberListRow_"+MemberId);
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
				var rowElem = document.getElementById("Group_memberListRow_"+MemberId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateGroup_member(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Group_member = new Group_member();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Group_member.GroupId= mainPacket[2];
		obj_Group_member.MemberId= mainPacket[3];
		obj_Group_member.MemberType= mainPacket[4];
		obj_Group_member.MemberDate= mainPacket[5];
		obj_Group_member.Description= mainPacket[6];


		if (resultStatus == 1) {			
			UI_createGroup_memberRow(obj_Group_member, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Group_member_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingGroup_memberPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Group_member; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteGroup_memberPacket(MemberId) {
	var deletePacketBody  = MemberId;

	var postpacket = createOutgoingGroup_memberPacket(202,deletePacketBody);
	Group_member_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateGroup_memberPacket(obj_Group_member) {
	var savePacketBody  = obj_Group_member.createGroup_memberPacket();

	var postpacket = createOutgoingGroup_memberPacket(203,savePacketBody);
	Group_member_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddGroup_memberPacket(dummyId,obj_Group_member) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Group_member.createGroup_memberPacket();

	var postpacket = createOutgoingGroup_memberPacket(201,savePacketBody);
	Group_member_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onGroup_memberPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onGroup_memberPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addGroup_member = document.getElementById("btnaddGroup_member");
	if(addGroup_member){
	addGroup_member.addEventListener('mousedown', Event_mousedown_addGroup_member, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popGroup_memberform = document.getElementById("popGroup_memberform");
	var inputElems = popGroup_memberform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiGroup_memberList = document.getElementById("Group_memberList");
	var liElems = UiGroup_memberList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverGroup_memberRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutGroup_memberRow, false);
		
	}
	
	var UiGroup_memberListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiGroup_memberListDeletebtns.length; z++) {
			UiGroup_memberListDeletebtns[z].addEventListener('mousedown', Event_mouseDownGroup_memberRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }

	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_MemberId","FullName",20); //person
	
	
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
	UI_search_Group_member(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownGroup_memberRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Group_member = Get_Group_memberByListRow(this.parentNode.parentNode);
			if(obj_Group_member != ""){
				deleteGroup_member(obj_Group_member.MemberId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Group_member = Get_Group_memberByListRow(this.parentNode.parentNode);
			if(obj_Group_member != ""){
				UI_showUpdateGroup_memberForm(obj_Group_member);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Group_member(searchText)
{

	//Group_memberList = 
	var Group_memberListElem = document.getElementById("Group_memberList");
	
	if(Group_memberListElem)
	{
		var Group_memberDataList = Group_memberListElem.getElementsByTagName("input");
		for(var y=0 in Group_memberDataList)
		{
			if(Group_memberDataList[y])
			{
				
				
				var displayType = "none";
				var Group_memberData = Group_memberDataList[y].value;
				if(!((Group_memberData == "") || (typeof Group_memberData=="undefined")))
				{
				if(search_Group_member(Group_memberData,searchText))
				{
					displayType = "block";
				}
				Group_memberDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Group_member(Group_memberData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Group_memberData = decodeSpText(Group_memberData.toLowerCase());
	if(Group_memberData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Group_member)
{
	if (obj_Group_member.MemberId) {
		var fieldDataId = obj_Group_member.MemberId;
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

function deleteGroup_member(MemberId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Group_member");
	if(flag){
			DeleteGroup_memberPacket(MemberId);
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

function Get_Group_memberByListRow(listRowElem)
{
	
	var obj_Group_member ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Group_memberData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Group_memberData = elemlist[z].value;
			}		
		}
		
		if(Group_memberData != "")
		{
		var arrGroup_memberData = Group_memberData.split(";");	
		
		obj_Group_member = new Group_member();
		obj_Group_member.GroupId= arrGroup_memberData[0];
		obj_Group_member.MemberId= arrGroup_memberData[1];
		obj_Group_member.MemberType= arrGroup_memberData[2];
		obj_Group_member.MemberDate= arrGroup_memberData[3];
		obj_Group_member.Description= arrGroup_memberData[4];

		
		
		}
		
	}
	
	return obj_Group_member;
	
	
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
	

		var Elem = document.getElementById("Input_MemberType");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Member type";
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
	
		var obj_Group_member = new Group_member();
		
		var GroupId= document.getElementById("Input_GroupId").value;
		var MemberId= document.getElementById("Input_MemberId").value;
		var MemberType= document.getElementById("Input_MemberType").value;
		var MemberDate= document.getElementById("Input_MemberDate").value;
		var Description= document.getElementById("Input_Description").value;

		
		//document.getElementById("Input_GroupId").value="";
		document.getElementById("Input_MemberId").value="";
		document.getElementById("Input_MemberType").value="";
		document.getElementById("Input_MemberDate").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Group_member = new Group_member();
		obj_Group_member.GroupId= GroupId;
		obj_Group_member.MemberId= MemberId;
		obj_Group_member.MemberType= MemberType;
		obj_Group_member.MemberDate= MemberDate;
		obj_Group_member.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddGroup_memberPacket(dummyId,obj_Group_member);
		UI_createGroup_memberRow(obj_Group_member, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Group_member = new Group_member();

		obj_Group_member.GroupId= GroupId;
		obj_Group_member.MemberId= MemberId;
		obj_Group_member.MemberType= MemberType;
		obj_Group_member.MemberDate= MemberDate;
		obj_Group_member.Description= Description;

		
		UpdateGroup_memberPacket(obj_Group_member);
		UI_createGroup_memberRow(obj_Group_member, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addGroup_member() {
	
	UI_showAddGroup_memberForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddGroup_memberForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGroup_memberAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGroup_memberform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateGroup_memberForm(obj_Group_member) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGroup_memberUpdateForm(obj_Group_member);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGroup_memberform"));
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
function UI_prepareGroup_memberUpdateForm(obj_Group_member)
{
	var arr_hidelist = new Array("Input_GroupId");
	var arr_showlist = new Array("Input_MemberId","Input_MemberType","Input_MemberDate","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GroupId").value=obj_Group_member.GroupId;
		document.getElementById("Input_MemberId").value=obj_Group_member.MemberId;
		document.getElementById("Input_MemberType").value=obj_Group_member.MemberType;
		document.getElementById("Input_MemberDate").value=obj_Group_member.MemberDate;
		document.getElementById("Input_Description").value=obj_Group_member.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareGroup_memberAddForm()
{
	var arr_hidelist = new Array("Input_GroupId");
	var arr_showlist = new Array("Input_MemberId","Input_MemberType","Input_MemberDate","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
	//	document.getElementById("Input_GroupId").value="";
		document.getElementById("Input_MemberId").value="";
		document.getElementById("Input_MemberType").value="";
		document.getElementById("Input_MemberDate").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addGroup_memberToGroup_memberList() {
	var uiGroup_memberList = document.getElementById("Group_memberList");

	var rowElems = uiGroup_memberList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createGroup_memberRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownGroup_memberRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGroup_memberRowHtmlElem(obj_Group_member,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Group_memberImg_"+obj_Group_member.MemberId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Group_member/0_small.png";
	else ImgElem.src = "Group_member/"+obj_Group_member.MemberId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Group_member.GroupId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Group_member.MemberId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Group_member.MemberType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Group_member.MemberDate;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Group_member.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Group_memberdata"+ElemId);
		ElementDataHidden.value = obj_Group_member.getGroup_memberData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);

		
		ElemLi= UI_createGroup_memberRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverGroup_memberRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutGroup_memberRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubGroup_memberHtmlElem(obj_Group_member)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subGroup_member");
		html ="<a href=\"?page=dashboard&MemberId="+obj_Group_member.MemberId+"\">"+obj_Group_member.MemberId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverGroup_memberRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutGroup_memberRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGroup_memberRow(obj_Group_member, rowType,dummyId) {
	var html = "";
	
	var UiGroup_memberList = document.getElementById("Group_memberList");
	var ClassName = "ListRow";
	var ElemId = "Group_memberListRow_"+obj_Group_member.MemberId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyGroup_memberRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createGroup_memberRowHtmlElem(obj_Group_member,ElemId, ClassName);
			UiGroup_memberList.insertBefore(ElemLi, UiGroup_memberList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Group_member msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createGroup_memberRowHtmlElem(obj_Group_member,ElemId, ClassName);
			UiGroup_memberList.insertBefore(ElemLi, UiGroup_memberList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyGroup_memberRow_"+dummyId);
			var DummyData = document.getElementById("Group_memberdataDummyGroup_memberRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Group_memberdata"+ElemId);		
				DummyData.value = obj_Group_member.getGroup_memberData();		
				}
				UI_createTopbarSubGroup_memberHtmlElem(obj_Group_member);
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
				var ElemLi = UI_createGroup_memberRowHtmlElem(obj_Group_member,ElemId, ClassName);
				UiGroup_memberList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Group_memberList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, MemberId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Group_memberListRow_"+MemberId);
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


