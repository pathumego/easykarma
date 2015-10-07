//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_history_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_history(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_history(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_history(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_history(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_history(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_history = new Village_history();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_history.TblId= mainPacket[3];
		obj_Village_history.VillageId= mainPacket[4];
		obj_Village_history.DescriptionType= mainPacket[5];
		obj_Village_history.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_historyRow(obj_Village_history, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_history(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_history = new Village_history();
		
		var resultStatus = mainPacket[0];
		var TblId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_historyListRow_"+TblId);
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
				var rowElem = document.getElementById("Village_historyListRow_"+TblId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_history(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_history = new Village_history();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_history.TblId= mainPacket[2];
		obj_Village_history.VillageId= mainPacket[3];
		obj_Village_history.DescriptionType= mainPacket[4];
		obj_Village_history.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_historyRow(obj_Village_history, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_history_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_historyPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_history; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_historyPacket(TblId) {
	var deletePacketBody  = TblId;

	var postpacket = createOutgoingVillage_historyPacket(202,deletePacketBody);
	Village_history_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_historyPacket(obj_Village_history) {
	var savePacketBody  = obj_Village_history.createVillage_historyPacket();

	var postpacket = createOutgoingVillage_historyPacket(203,savePacketBody);
	Village_history_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_historyPacket(dummyId,obj_Village_history) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_history.createVillage_historyPacket();

	var postpacket = createOutgoingVillage_historyPacket(201,savePacketBody);
	Village_history_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_historyPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_historyPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_history = document.getElementById("btnaddVillage_history");
	if(addVillage_history){
	addVillage_history.addEventListener('mousedown', Event_mousedown_addVillage_history, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_historyform = document.getElementById("popVillage_historyform");
	var inputElems = popVillage_historyform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_historyList = document.getElementById("Village_historyList");
	var liElems = UiVillage_historyList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_historyRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_historyRow, false);
		
	}
	
	var UiVillage_historyListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_historyListDeletebtns.length; z++) {
			UiVillage_historyListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_historyRowBtn, false);			
		
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
	UI_search_Village_history(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_historyRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_history = Get_Village_historyByListRow(this.parentNode.parentNode);
			if(obj_Village_history != ""){
				deleteVillage_history(obj_Village_history.TblId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_history = Get_Village_historyByListRow(this.parentNode.parentNode);
			if(obj_Village_history != ""){
				UI_showUpdateVillage_historyForm(obj_Village_history);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_history(searchText)
{

	//Village_historyList = 
	var Village_historyListElem = document.getElementById("Village_historyList");
	
	if(Village_historyListElem)
	{
		var Village_historyDataList = Village_historyListElem.getElementsByTagName("input");
		for(var y=0 in Village_historyDataList)
		{
			if(Village_historyDataList[y])
			{
				
				
				var displayType = "none";
				var Village_historyData = Village_historyDataList[y].value;
				if(!((Village_historyData == "") || (typeof Village_historyData=="undefined")))
				{
				if(search_Village_history(Village_historyData,searchText))
				{
					displayType = "block";
				}
				Village_historyDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_history(Village_historyData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_historyData = decodeSpText(Village_historyData.toLowerCase());
	if(Village_historyData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_history)
{
	if (obj_Village_history.TblId) {
		var fieldDataId = obj_Village_history.TblId;
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

function deleteVillage_history(TblId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_history");
	if(flag){
			DeleteVillage_historyPacket(TblId);
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

function Get_Village_historyByListRow(listRowElem)
{
	
	var obj_Village_history ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_historyData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_historyData = elemlist[z].value;
			}		
		}
		
		if(Village_historyData != "")
		{
		var arrVillage_historyData = Village_historyData.split(";");	
		
		obj_Village_history = new Village_history();
		obj_Village_history.TblId= arrVillage_historyData[0];
		obj_Village_history.VillageId= arrVillage_historyData[1];
		obj_Village_history.DescriptionType= arrVillage_historyData[2];
		obj_Village_history.Description= arrVillage_historyData[3];

		
		
		}
		
	}
	
	return obj_Village_history;
	
	
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
					error = "please Enter the Description";
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
	
		var obj_Village_history = new Village_history();
		
		var TblId= document.getElementById("Input_TblId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var DescriptionType= document.getElementById("Input_DescriptionType").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_DescriptionType").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_history = new Village_history();
		obj_Village_history.TblId= TblId;
		obj_Village_history.VillageId= VillageId;
		obj_Village_history.DescriptionType= DescriptionType;
		obj_Village_history.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_historyPacket(dummyId,obj_Village_history);
		UI_createVillage_historyRow(obj_Village_history, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_history = new Village_history();

		obj_Village_history.TblId= TblId;
		obj_Village_history.VillageId= VillageId;
		obj_Village_history.DescriptionType= DescriptionType;
		obj_Village_history.Description= Description;

		
		UpdateVillage_historyPacket(obj_Village_history);
		UI_createVillage_historyRow(obj_Village_history, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_history() {
	
	UI_showAddVillage_historyForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_historyForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_historyAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_historyform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_historyForm(obj_Village_history) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_historyUpdateForm(obj_Village_history);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_historyform"));
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
function UI_prepareVillage_historyUpdateForm(obj_Village_history)
{
	var arr_hidelist = new Array("Input_TblId","Input_VillageId");
	var arr_showlist = new Array("Input_DescriptionType","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value=obj_Village_history.TblId;
		document.getElementById("Input_VillageId").value=obj_Village_history.VillageId;
		document.getElementById("Input_DescriptionType").value=obj_Village_history.DescriptionType;
		document.getElementById("Input_Description").value=obj_Village_history.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_historyAddForm()
{
	var arr_hidelist = new Array("Input_TblId","Input_VillageId");
	var arr_showlist = new Array("Input_DescriptionType","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_DescriptionType").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_historyToVillage_historyList() {
	var uiVillage_historyList = document.getElementById("Village_historyList");

	var rowElems = uiVillage_historyList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_historyRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_historyRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_historyRowHtmlElem(obj_Village_history,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_historyImg_"+obj_Village_history.TblId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_history/0_small.png";
	else ImgElem.src = "Village_history/"+obj_Village_history.TblId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_history.TblId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_history.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_history.DescriptionType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_history.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_historydata"+ElemId);
		ElementDataHidden.value = obj_Village_history.getVillage_historyData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_historyRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_historyRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_historyRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_historyHtmlElem(obj_Village_history)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_history");
		html ="<a href=\"?page=dashboard&TblId="+obj_Village_history.TblId+"\">"+obj_Village_history.TblId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_historyRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_historyRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_historyRow(obj_Village_history, rowType,dummyId) {
	var html = "";
	
	var UiVillage_historyList = document.getElementById("Village_historyList");
	var ClassName = "ListRow";
	var ElemId = "Village_historyListRow_"+obj_Village_history.TblId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_historyRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_historyRowHtmlElem(obj_Village_history,ElemId, ClassName);
			UiVillage_historyList.insertBefore(ElemLi, UiVillage_historyList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_history msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_historyRowHtmlElem(obj_Village_history,ElemId, ClassName);
			UiVillage_historyList.insertBefore(ElemLi, UiVillage_historyList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_historyRow_"+dummyId);
			var DummyData = document.getElementById("Village_historydataDummyVillage_historyRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_historydata"+ElemId);		
				DummyData.value = obj_Village_history.getVillage_historyData();		
				}
				UI_createTopbarSubVillage_historyHtmlElem(obj_Village_history);
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
				var ElemLi = UI_createVillage_historyRowHtmlElem(obj_Village_history,ElemId, ClassName);
				UiVillage_historyList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_historyList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, TblId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_historyListRow_"+TblId);
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


