//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Trading_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addTrading(mainPacket);
			break;
		}
		case 201: {
			ACK_addTrading(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteTrading(mainPacket);
			break;
		}
		case 203: {
			ACK_updateTrading(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addTrading(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Trading = new Trading();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Trading.tradingId= mainPacket[3];
		obj_Trading.tradingName= mainPacket[4];
		obj_Trading.tradingType= mainPacket[5];
		obj_Trading.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createTradingRow(obj_Trading, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteTrading(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Trading = new Trading();
		
		var resultStatus = mainPacket[0];
		var tradingId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("TradingListRow_"+tradingId);
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
				var rowElem = document.getElementById("TradingListRow_"+tradingId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateTrading(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Trading = new Trading();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Trading.tradingId= mainPacket[2];
		obj_Trading.tradingName= mainPacket[3];
		obj_Trading.tradingType= mainPacket[4];
		obj_Trading.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createTradingRow(obj_Trading, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Trading_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingTradingPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Trading; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteTradingPacket(tradingId) {
	var deletePacketBody  = tradingId;

	var postpacket = createOutgoingTradingPacket(202,deletePacketBody);
	Trading_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateTradingPacket(obj_Trading) {
	var savePacketBody  = obj_Trading.createTradingPacket();

	var postpacket = createOutgoingTradingPacket(203,savePacketBody);
	Trading_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddTradingPacket(dummyId,obj_Trading) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Trading.createTradingPacket();

	var postpacket = createOutgoingTradingPacket(201,savePacketBody);
	Trading_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onTradingPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onTradingPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addTrading = document.getElementById("btnaddTrading");
	if(addTrading){
	addTrading.addEventListener('mousedown', Event_mousedown_addTrading, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popTradingform = document.getElementById("popTradingform");
	var inputElems = popTradingform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiTradingList = document.getElementById("TradingList");
	var liElems = UiTradingList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverTradingRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutTradingRow, false);
		
	}
	
	var UiTradingListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiTradingListDeletebtns.length; z++) {
			UiTradingListDeletebtns[z].addEventListener('mousedown', Event_mouseDownTradingRowBtn, false);			
		
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
	UI_search_Trading(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownTradingRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Trading = Get_TradingByListRow(this.parentNode.parentNode);
			if(obj_Trading != ""){
				deleteTrading(obj_Trading.tradingId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Trading = Get_TradingByListRow(this.parentNode.parentNode);
			if(obj_Trading != ""){
				UI_showUpdateTradingForm(obj_Trading);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Trading(searchText)
{

	//TradingList = 
	var TradingListElem = document.getElementById("TradingList");
	
	if(TradingListElem)
	{
		var TradingDataList = TradingListElem.getElementsByTagName("input");
		for(var y=0 in TradingDataList)
		{
			if(TradingDataList[y])
			{
				
				
				var displayType = "none";
				var TradingData = TradingDataList[y].value;
				if(!((TradingData == "") || (typeof TradingData=="undefined")))
				{
				if(search_Trading(TradingData,searchText))
				{
					displayType = "block";
				}
				TradingDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Trading(TradingData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	TradingData = decodeSpText(TradingData.toLowerCase());
	if(TradingData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Trading)
{
	if (obj_Trading.tradingId) {
		var fieldDataId = obj_Trading.tradingId;
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

function deleteTrading(tradingId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Trading");
	if(flag){
			DeleteTradingPacket(tradingId);
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

function Get_TradingByListRow(listRowElem)
{
	
	var obj_Trading ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var TradingData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				TradingData = elemlist[z].value;
			}		
		}
		
		if(TradingData != "")
		{
		var arrTradingData = TradingData.split(";");	
		
		obj_Trading = new Trading();
		obj_Trading.tradingId= arrTradingData[0];
		obj_Trading.tradingName= arrTradingData[1];
		obj_Trading.tradingType= arrTradingData[2];
		obj_Trading.Description= arrTradingData[3];

		
		
		}
		
	}
	
	return obj_Trading;
	
	
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
	
var Elem = document.getElementById("Input_tradingName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the trade";
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
	
		var obj_Trading = new Trading();
		
		var tradingId= document.getElementById("Input_tradingId").value;
		var tradingName= document.getElementById("Input_tradingName").value;
		var tradingType= document.getElementById("Input_tradingType").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_tradingId").value="";
		document.getElementById("Input_tradingName").value="";
		document.getElementById("Input_tradingType").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Trading = new Trading();
		obj_Trading.tradingId= tradingId;
		obj_Trading.tradingName= tradingName;
		obj_Trading.tradingType= tradingType;
		obj_Trading.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddTradingPacket(dummyId,obj_Trading);
		UI_createTradingRow(obj_Trading, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Trading = new Trading();

		obj_Trading.tradingId= tradingId;
		obj_Trading.tradingName= tradingName;
		obj_Trading.tradingType= tradingType;
		obj_Trading.Description= Description;

		
		UpdateTradingPacket(obj_Trading);
		UI_createTradingRow(obj_Trading, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addTrading() {
	
	UI_showAddTradingForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddTradingForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTradingAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTradingform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateTradingForm(obj_Trading) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTradingUpdateForm(obj_Trading);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTradingform"));
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
function UI_prepareTradingUpdateForm(obj_Trading)
{
	var arr_hidelist = new Array("Input_tradingId");
	var arr_showlist = new Array("Input_tradingName","Input_tradingType","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_tradingId").value=obj_Trading.tradingId;
		document.getElementById("Input_tradingName").value=obj_Trading.tradingName;
		document.getElementById("Input_tradingType").value=obj_Trading.tradingType;
		document.getElementById("Input_Description").value=obj_Trading.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareTradingAddForm()
{
	var arr_hidelist = new Array("Input_tradingId");
	var arr_showlist = new Array("Input_tradingName","Input_tradingType","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_tradingId").value="";
		document.getElementById("Input_tradingName").value="";
		document.getElementById("Input_tradingType").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addTradingToTradingList() {
	var uiTradingList = document.getElementById("TradingList");

	var rowElems = uiTradingList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createTradingRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownTradingRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTradingRowHtmlElem(obj_Trading,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "TradingImg_"+obj_Trading.tradingId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Trading/0_small.png";
	else ImgElem.src = "Trading/"+obj_Trading.tradingId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Trading.tradingId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Trading.tradingName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Trading.tradingType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Trading.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Tradingdata"+ElemId);
		ElementDataHidden.value = obj_Trading.getTradingData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createTradingRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverTradingRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutTradingRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubTradingHtmlElem(obj_Trading)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subTrading");
		html ="<a href=\"?page=dashboard&tradingId="+obj_Trading.tradingId+"\">"+obj_Trading.tradingId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverTradingRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutTradingRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTradingRow(obj_Trading, rowType,dummyId) {
	var html = "";
	
	var UiTradingList = document.getElementById("TradingList");
	var ClassName = "ListRow";
	var ElemId = "TradingListRow_"+obj_Trading.tradingId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyTradingRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createTradingRowHtmlElem(obj_Trading,ElemId, ClassName);
			UiTradingList.insertBefore(ElemLi, UiTradingList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Trading msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createTradingRowHtmlElem(obj_Trading,ElemId, ClassName);
			UiTradingList.insertBefore(ElemLi, UiTradingList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyTradingRow_"+dummyId);
			var DummyData = document.getElementById("TradingdataDummyTradingRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Tradingdata"+ElemId);		
				DummyData.value = obj_Trading.getTradingData();		
				}
				UI_createTopbarSubTradingHtmlElem(obj_Trading);
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
				var ElemLi = UI_createTradingRowHtmlElem(obj_Trading,ElemId, ClassName);
				UiTradingList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("TradingList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, tradingId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("TradingListRow_"+tradingId);
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


