//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_othernames_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_othernames(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_othernames(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_othernames(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_othernames(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_othernames(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_othernames = new Village_othernames();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_othernames.VillageId= mainPacket[3];
		obj_Village_othernames.VillageNames= mainPacket[4];



		if (resultStatus == 1) {	
			
			UI_createVillage_othernamesRow(obj_Village_othernames, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_othernames(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_othernames = new Village_othernames();
		
		var resultStatus = mainPacket[0];
		var VillageId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_othernamesListRow_"+VillageId);
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
				var rowElem = document.getElementById("Village_othernamesListRow_"+VillageId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_othernames(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_othernames = new Village_othernames();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_othernames.VillageId= mainPacket[2];
		obj_Village_othernames.VillageNames= mainPacket[3];


		if (resultStatus == 1) {			
			UI_createVillage_othernamesRow(obj_Village_othernames, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_othernames_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_othernamesPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_othernames; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_othernamesPacket(VillageId) {
	var deletePacketBody  = VillageId;

	var postpacket = createOutgoingVillage_othernamesPacket(202,deletePacketBody);
	Village_othernames_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_othernamesPacket(obj_Village_othernames) {
	var savePacketBody  = obj_Village_othernames.createVillage_othernamesPacket();

	var postpacket = createOutgoingVillage_othernamesPacket(203,savePacketBody);
	Village_othernames_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_othernamesPacket(dummyId,obj_Village_othernames) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_othernames.createVillage_othernamesPacket();

	var postpacket = createOutgoingVillage_othernamesPacket(201,savePacketBody);
	Village_othernames_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_othernamesPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_othernamesPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_othernames = document.getElementById("btnaddVillage_othernames");
	if(addVillage_othernames){
	addVillage_othernames.addEventListener('mousedown', Event_mousedown_addVillage_othernames, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_othernamesform = document.getElementById("popVillage_othernamesform");
	var inputElems = popVillage_othernamesform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_othernamesList = document.getElementById("Village_othernamesList");
	var liElems = UiVillage_othernamesList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_othernamesRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_othernamesRow, false);
		
	}
	
	var UiVillage_othernamesListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_othernamesListDeletebtns.length; z++) {
			UiVillage_othernamesListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_othernamesRowBtn, false);			
		
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
	UI_search_Village_othernames(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_othernamesRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_othernames = Get_Village_othernamesByListRow(this.parentNode.parentNode);
			if(obj_Village_othernames != ""){
				deleteVillage_othernames(obj_Village_othernames.VillageId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_othernames = Get_Village_othernamesByListRow(this.parentNode.parentNode);
			if(obj_Village_othernames != ""){
				UI_showUpdateVillage_othernamesForm(obj_Village_othernames);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_othernames(searchText)
{

	//Village_othernamesList = 
	var Village_othernamesListElem = document.getElementById("Village_othernamesList");
	
	if(Village_othernamesListElem)
	{
		var Village_othernamesDataList = Village_othernamesListElem.getElementsByTagName("input");
		for(var y=0 in Village_othernamesDataList)
		{
			if(Village_othernamesDataList[y])
			{
				
				
				var displayType = "none";
				var Village_othernamesData = Village_othernamesDataList[y].value;
				if(!((Village_othernamesData == "") || (typeof Village_othernamesData=="undefined")))
				{
				if(search_Village_othernames(Village_othernamesData,searchText))
				{
					displayType = "block";
				}
				Village_othernamesDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_othernames(Village_othernamesData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_othernamesData = decodeSpText(Village_othernamesData.toLowerCase());
	if(Village_othernamesData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_othernames)
{
	if (obj_Village_othernames.VillageId) {
		var fieldDataId = obj_Village_othernames.VillageId;
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

function deleteVillage_othernames(VillageId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_othernames");
	if(flag){
			DeleteVillage_othernamesPacket(VillageId);
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

function Get_Village_othernamesByListRow(listRowElem)
{
	
	var obj_Village_othernames ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_othernamesData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_othernamesData = elemlist[z].value;
			}		
		}
		
		if(Village_othernamesData != "")
		{
		var arrVillage_othernamesData = Village_othernamesData.split(";");	
		
		obj_Village_othernames = new Village_othernames();
		obj_Village_othernames.VillageId= arrVillage_othernamesData[0];
		obj_Village_othernames.VillageNames= arrVillage_othernamesData[1];

		
		
		}
		
	}
	
	return obj_Village_othernames;
	
	
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
	
			var Elem = document.getElementById("Input_VillageNames");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Other Names";
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
	
		var obj_Village_othernames = new Village_othernames();
		
		var VillageId= document.getElementById("Input_VillageId").value;
		var VillageNames= document.getElementById("Input_VillageNames").value;

		
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_VillageNames").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_othernames = new Village_othernames();
		obj_Village_othernames.VillageId= VillageId;
		obj_Village_othernames.VillageNames= VillageNames;

		
		var dummyId = CreateDummyNumber();
		AddVillage_othernamesPacket(dummyId,obj_Village_othernames);
		UI_createVillage_othernamesRow(obj_Village_othernames, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_othernames = new Village_othernames();

		obj_Village_othernames.VillageId= VillageId;
		obj_Village_othernames.VillageNames= VillageNames;

		
		UpdateVillage_othernamesPacket(obj_Village_othernames);
		UI_createVillage_othernamesRow(obj_Village_othernames, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_othernames() {
	
	UI_showAddVillage_othernamesForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_othernamesForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_othernamesAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_othernamesform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_othernamesForm(obj_Village_othernames) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_othernamesUpdateForm(obj_Village_othernames);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_othernamesform"));
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
function UI_prepareVillage_othernamesUpdateForm(obj_Village_othernames)
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_VillageNames");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VillageId").value=obj_Village_othernames.VillageId;
		document.getElementById("Input_VillageNames").value=obj_Village_othernames.VillageNames;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_othernamesAddForm()
{
	var arr_hidelist = new Array("Input_VillageId");
	var arr_showlist = new Array("Input_VillageNames");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_VillageNames").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_othernamesToVillage_othernamesList() {
	var uiVillage_othernamesList = document.getElementById("Village_othernamesList");

	var rowElems = uiVillage_othernamesList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_othernamesRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_othernamesRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_othernamesRowHtmlElem(obj_Village_othernames,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_othernamesImg_"+obj_Village_othernames.VillageId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_othernames/0_small.png";
	else ImgElem.src = "Village_othernames/"+obj_Village_othernames.VillageId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_othernames.VillageId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_othernames.VillageNames;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_othernamesdata"+ElemId);
		ElementDataHidden.value = obj_Village_othernames.getVillage_othernamesData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);

		
		ElemLi= UI_createVillage_othernamesRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_othernamesRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_othernamesRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_othernamesHtmlElem(obj_Village_othernames)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_othernames");
		html ="<a href=\"?page=dashboard&VillageId="+obj_Village_othernames.VillageId+"\">"+obj_Village_othernames.VillageId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_othernamesRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_othernamesRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_othernamesRow(obj_Village_othernames, rowType,dummyId) {
	var html = "";
	
	var UiVillage_othernamesList = document.getElementById("Village_othernamesList");
	var ClassName = "ListRow";
	var ElemId = "Village_othernamesListRow_"+obj_Village_othernames.VillageId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_othernamesRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_othernamesRowHtmlElem(obj_Village_othernames,ElemId, ClassName);
			UiVillage_othernamesList.insertBefore(ElemLi, UiVillage_othernamesList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_othernames msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_othernamesRowHtmlElem(obj_Village_othernames,ElemId, ClassName);
			UiVillage_othernamesList.insertBefore(ElemLi, UiVillage_othernamesList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_othernamesRow_"+dummyId);
			var DummyData = document.getElementById("Village_othernamesdataDummyVillage_othernamesRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_othernamesdata"+ElemId);		
				DummyData.value = obj_Village_othernames.getVillage_othernamesData();		
				}
				UI_createTopbarSubVillage_othernamesHtmlElem(obj_Village_othernames);
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
				var ElemLi = UI_createVillage_othernamesRowHtmlElem(obj_Village_othernames,ElemId, ClassName);
				UiVillage_othernamesList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_othernamesList");
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
		var profileAvatar = document.getElementById("Village_othernamesListRow_"+VillageId);
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


