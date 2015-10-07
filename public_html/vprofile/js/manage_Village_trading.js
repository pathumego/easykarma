//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_trading_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_trading(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_trading(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_trading(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_trading(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_trading(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_trading = new Village_trading();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_trading.TradingId= mainPacket[3];
		obj_Village_trading.VillageId= mainPacket[4];
		obj_Village_trading.BusinessId= mainPacket[5];
		obj_Village_trading.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_tradingRow(obj_Village_trading, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_trading(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_trading = new Village_trading();
		
		var resultStatus = mainPacket[0];
		var BusinessId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_tradingListRow_"+BusinessId);
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
				var rowElem = document.getElementById("Village_tradingListRow_"+BusinessId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_trading(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_trading = new Village_trading();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_trading.TradingId= mainPacket[2];
		obj_Village_trading.VillageId= mainPacket[3];
		obj_Village_trading.BusinessId= mainPacket[4];
		obj_Village_trading.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_tradingRow(obj_Village_trading, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_trading_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_tradingPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_trading; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_tradingPacket(BusinessId) {
	var deletePacketBody  = BusinessId;

	var postpacket = createOutgoingVillage_tradingPacket(202,deletePacketBody);
	Village_trading_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_tradingPacket(obj_Village_trading) {
	var savePacketBody  = obj_Village_trading.createVillage_tradingPacket();

	var postpacket = createOutgoingVillage_tradingPacket(203,savePacketBody);
	Village_trading_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_tradingPacket(dummyId,obj_Village_trading) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_trading.createVillage_tradingPacket();

	var postpacket = createOutgoingVillage_tradingPacket(201,savePacketBody);
	Village_trading_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_tradingPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_tradingPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_trading = document.getElementById("btnaddVillage_trading");
	if(addVillage_trading){
	addVillage_trading.addEventListener('mousedown', Event_mousedown_addVillage_trading, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_tradingform = document.getElementById("popVillage_tradingform");
	var inputElems = popVillage_tradingform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_tradingList = document.getElementById("Village_tradingList");
	var liElems = UiVillage_tradingList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_tradingRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_tradingRow, false);
		
	}
	
	var UiVillage_tradingListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_tradingListDeletebtns.length; z++) {
			UiVillage_tradingListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_tradingRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
		global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_BusinessId","Name",4); //business
	
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
	UI_search_Village_trading(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_tradingRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_trading = Get_Village_tradingByListRow(this.parentNode.parentNode);
			if(obj_Village_trading != ""){
				deleteVillage_trading(obj_Village_trading.BusinessId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_trading = Get_Village_tradingByListRow(this.parentNode.parentNode);
			if(obj_Village_trading != ""){
				UI_showUpdateVillage_tradingForm(obj_Village_trading);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_trading(searchText)
{

	//Village_tradingList = 
	var Village_tradingListElem = document.getElementById("Village_tradingList");
	
	if(Village_tradingListElem)
	{
		var Village_tradingDataList = Village_tradingListElem.getElementsByTagName("input");
		for(var y=0 in Village_tradingDataList)
		{
			if(Village_tradingDataList[y])
			{
				
				
				var displayType = "none";
				var Village_tradingData = Village_tradingDataList[y].value;
				if(!((Village_tradingData == "") || (typeof Village_tradingData=="undefined")))
				{
				if(search_Village_trading(Village_tradingData,searchText))
				{
					displayType = "block";
				}
				Village_tradingDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_trading(Village_tradingData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_tradingData = decodeSpText(Village_tradingData.toLowerCase());
	if(Village_tradingData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_trading)
{
	if (obj_Village_trading.BusinessId) {
		var fieldDataId = obj_Village_trading.BusinessId;
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

function deleteVillage_trading(BusinessId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_trading");
	if(flag){
			DeleteVillage_tradingPacket(BusinessId);
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

function Get_Village_tradingByListRow(listRowElem)
{
	
	var obj_Village_trading ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_tradingData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_tradingData = elemlist[z].value;
			}		
		}
		
		if(Village_tradingData != "")
		{
		var arrVillage_tradingData = Village_tradingData.split(";");	
		
		obj_Village_trading = new Village_trading();
		obj_Village_trading.TradingId= arrVillage_tradingData[0];
		obj_Village_trading.VillageId= arrVillage_tradingData[1];
		obj_Village_trading.BusinessId= arrVillage_tradingData[2];
		obj_Village_trading.Description= arrVillage_tradingData[3];

		
		
		}
		
	}
	
	return obj_Village_trading;
	
	
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
	
		var obj_Village_trading = new Village_trading();
		
		var TradingId= document.getElementById("Input_TradingId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var BusinessId= document.getElementById("Input_BusinessId").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_TradingId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_trading = new Village_trading();
		obj_Village_trading.TradingId= TradingId;
		obj_Village_trading.VillageId= VillageId;
		obj_Village_trading.BusinessId= BusinessId;
		obj_Village_trading.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_tradingPacket(dummyId,obj_Village_trading);
		UI_createVillage_tradingRow(obj_Village_trading, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_trading = new Village_trading();

		obj_Village_trading.TradingId= TradingId;
		obj_Village_trading.VillageId= VillageId;
		obj_Village_trading.BusinessId= BusinessId;
		obj_Village_trading.Description= Description;

		
		UpdateVillage_tradingPacket(obj_Village_trading);
		UI_createVillage_tradingRow(obj_Village_trading, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_trading() {
	
	UI_showAddVillage_tradingForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_tradingForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_tradingAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_tradingform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_tradingForm(obj_Village_trading) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_tradingUpdateForm(obj_Village_trading);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_tradingform"));
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
function UI_prepareVillage_tradingUpdateForm(obj_Village_trading)
{
	var arr_hidelist = new Array("Input_BusinessId","Input_TradingId","Input_VillageId");
	var arr_showlist = new Array("Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TradingId").value=obj_Village_trading.TradingId;
		document.getElementById("Input_VillageId").value=obj_Village_trading.VillageId;
		document.getElementById("Input_BusinessId").value=obj_Village_trading.BusinessId;
		document.getElementById("Input_Description").value=obj_Village_trading.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_tradingAddForm()
{
	var arr_hidelist = new Array("Input_BusinessId","Input_TradingId","Input_VillageId");
	var arr_showlist = new Array("Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TradingId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_tradingToVillage_tradingList() {
	var uiVillage_tradingList = document.getElementById("Village_tradingList");

	var rowElems = uiVillage_tradingList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_tradingRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_tradingRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_tradingRowHtmlElem(obj_Village_trading,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_tradingImg_"+obj_Village_trading.BusinessId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_trading/0_small.png";
	else ImgElem.src = "Village_trading/"+obj_Village_trading.BusinessId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_trading.TradingId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_trading.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_trading.BusinessId;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_trading.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_tradingdata"+ElemId);
		ElementDataHidden.value = obj_Village_trading.getVillage_tradingData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_tradingRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_tradingRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_tradingRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_tradingHtmlElem(obj_Village_trading)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_trading");
		html ="<a href=\"?page=dashboard&BusinessId="+obj_Village_trading.BusinessId+"\">"+obj_Village_trading.BusinessId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_tradingRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_tradingRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_tradingRow(obj_Village_trading, rowType,dummyId) {
	var html = "";
	
	var UiVillage_tradingList = document.getElementById("Village_tradingList");
	var ClassName = "ListRow";
	var ElemId = "Village_tradingListRow_"+obj_Village_trading.BusinessId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_tradingRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_tradingRowHtmlElem(obj_Village_trading,ElemId, ClassName);
			UiVillage_tradingList.insertBefore(ElemLi, UiVillage_tradingList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_trading msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_tradingRowHtmlElem(obj_Village_trading,ElemId, ClassName);
			UiVillage_tradingList.insertBefore(ElemLi, UiVillage_tradingList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_tradingRow_"+dummyId);
			var DummyData = document.getElementById("Village_tradingdataDummyVillage_tradingRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_tradingdata"+ElemId);		
				DummyData.value = obj_Village_trading.getVillage_tradingData();		
				}
				UI_createTopbarSubVillage_tradingHtmlElem(obj_Village_trading);
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
				var ElemLi = UI_createVillage_tradingRowHtmlElem(obj_Village_trading,ElemId, ClassName);
				UiVillage_tradingList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_tradingList");
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
		var profileAvatar = document.getElementById("Village_tradingListRow_"+BusinessId);
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


