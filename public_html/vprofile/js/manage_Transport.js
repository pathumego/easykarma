

//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Transport_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addTransport(mainPacket);
			break;
		}
		case 201: {
			ACK_addTransport(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteTransport(mainPacket);
			break;
		}
		case 203: {
			ACK_updateTransport(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addTransport(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Transport = new Transport();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Transport.TransportId= mainPacket[3];
		obj_Transport.TransportName= mainPacket[4];
		obj_Transport.TransportType= mainPacket[5];
		obj_Transport.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createTransportRow(obj_Transport, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteTransport(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Transport = new Transport();
		
		var resultStatus = mainPacket[0];
		var TransportId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("TransportListRow_"+TransportId);
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
				var rowElem = document.getElementById("TransportListRow_"+TransportId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateTransport(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Transport = new Transport();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Transport.TransportId= mainPacket[2];
		obj_Transport.TransportName= mainPacket[3];
		obj_Transport.TransportType= mainPacket[4];
		obj_Transport.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createTransportRow(obj_Transport, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Transport_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingTransportPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Transport; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteTransportPacket(TransportId) {
	var deletePacketBody  = TransportId;

	var postpacket = createOutgoingTransportPacket(202,deletePacketBody);
	Transport_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateTransportPacket(obj_Transport) {
	var savePacketBody  = obj_Transport.createTransportPacket();

	var postpacket = createOutgoingTransportPacket(203,savePacketBody);
	Transport_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddTransportPacket(dummyId,obj_Transport) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Transport.createTransportPacket();

	var postpacket = createOutgoingTransportPacket(201,savePacketBody);
	Transport_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onTransportPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onTransportPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addTransport = document.getElementById("btnaddTransport");
	if(addTransport){
	addTransport.addEventListener('mousedown', Event_mousedown_addTransport, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popTransportform = document.getElementById("popTransportform");
	var inputElems = popTransportform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiTransportList = document.getElementById("TransportList");
	var liElems = UiTransportList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverTransportRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutTransportRow, false);
		
	}
	
	var UiTransportListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiTransportListDeletebtns.length; z++) {
			UiTransportListDeletebtns[z].addEventListener('mousedown', Event_mouseDownTransportRowBtn, false);			
		
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
	UI_search_Transport(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownTransportRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Transport = Get_TransportByListRow(this.parentNode.parentNode);
			if(obj_Transport != ""){
				deleteTransport(obj_Transport.TransportId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Transport = Get_TransportByListRow(this.parentNode.parentNode);
			if(obj_Transport != ""){
				UI_showUpdateTransportForm(obj_Transport);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Transport(searchText)
{

	//TransportList = 
	var TransportListElem = document.getElementById("TransportList");
	
	if(TransportListElem)
	{
		var TransportDataList = TransportListElem.getElementsByTagName("input");
		for(var y=0 in TransportDataList)
		{
			if(TransportDataList[y])
			{
				
				
				var displayType = "none";
				var TransportData = TransportDataList[y].value;
				if(!((TransportData == "") || (typeof TransportData=="undefined")))
				{
				if(search_Transport(TransportData,searchText))
				{
					displayType = "block";
				}
				TransportDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Transport(TransportData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	TransportData = decodeSpText(TransportData.toLowerCase());
	if(TransportData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Transport)
{
	if (obj_Transport.TransportId) {
		var fieldDataId = obj_Transport.TransportId;
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

function deleteTransport(TransportId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Transport");
	if(flag){
			DeleteTransportPacket(TransportId);
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

function Get_TransportByListRow(listRowElem)
{
	
	var obj_Transport ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var TransportData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				TransportData = elemlist[z].value;
			}		
		}
		
		if(TransportData != "")
		{
		var arrTransportData = TransportData.split(";");	
		
		obj_Transport = new Transport();
		obj_Transport.TransportId= arrTransportData[0];
		obj_Transport.TransportName= arrTransportData[1];
		obj_Transport.TransportType= arrTransportData[2];
		obj_Transport.Description= arrTransportData[3];

		
		
		}
		
	}
	
	return obj_Transport;
	
	
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
	
var Elem = document.getElementById("Input_TransportName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter transpotation type";
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
	
		var obj_Transport = new Transport();
		
		var TransportId= document.getElementById("Input_TransportId").value;
		var TransportName= document.getElementById("Input_TransportName").value;
		var TransportType= document.getElementById("Input_TransportType").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_TransportId").value="";
		document.getElementById("Input_TransportName").value="";
		document.getElementById("Input_TransportType").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Transport = new Transport();
		obj_Transport.TransportId= TransportId;
		obj_Transport.TransportName= TransportName;
		obj_Transport.TransportType= TransportType;
		obj_Transport.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddTransportPacket(dummyId,obj_Transport);
		UI_createTransportRow(obj_Transport, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Transport = new Transport();

		obj_Transport.TransportId= TransportId;
		obj_Transport.TransportName= TransportName;
		obj_Transport.TransportType= TransportType;
		obj_Transport.Description= Description;

		
		UpdateTransportPacket(obj_Transport);
		UI_createTransportRow(obj_Transport, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addTransport() {
	
	UI_showAddTransportForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddTransportForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTransportAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTransportform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateTransportForm(obj_Transport) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTransportUpdateForm(obj_Transport);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTransportform"));
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
function UI_prepareTransportUpdateForm(obj_Transport)
{
	var arr_hidelist = new Array("Input_TransportId");
	var arr_showlist = new Array("Input_TransportName","Input_TransportType","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TransportId").value=obj_Transport.TransportId;
		document.getElementById("Input_TransportName").value=obj_Transport.TransportName;
		document.getElementById("Input_TransportType").value=obj_Transport.TransportType;
		document.getElementById("Input_Description").value=obj_Transport.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareTransportAddForm()
{
	var arr_hidelist = new Array("Input_TransportId");
	var arr_showlist = new Array("Input_TransportName","Input_TransportType","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TransportId").value="";
		document.getElementById("Input_TransportName").value="";
		document.getElementById("Input_TransportType").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addTransportToTransportList() {
	var uiTransportList = document.getElementById("TransportList");

	var rowElems = uiTransportList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createTransportRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownTransportRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTransportRowHtmlElem(obj_Transport,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "TransportImg_"+obj_Transport.TransportId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Transport/0_small.png";
	else ImgElem.src = "Transport/"+obj_Transport.TransportId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Transport.TransportId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Transport.TransportName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Transport.TransportType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Transport.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Transportdata"+ElemId);
		ElementDataHidden.value = obj_Transport.getTransportData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createTransportRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverTransportRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutTransportRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubTransportHtmlElem(obj_Transport)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subTransport");
		html ="<a href=\"?page=dashboard&TransportId="+obj_Transport.TransportId+"\">"+obj_Transport.TransportId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverTransportRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutTransportRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTransportRow(obj_Transport, rowType,dummyId) {
	var html = "";
	
	var UiTransportList = document.getElementById("TransportList");
	var ClassName = "ListRow";
	var ElemId = "TransportListRow_"+obj_Transport.TransportId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyTransportRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createTransportRowHtmlElem(obj_Transport,ElemId, ClassName);
			UiTransportList.insertBefore(ElemLi, UiTransportList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Transport msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createTransportRowHtmlElem(obj_Transport,ElemId, ClassName);
			UiTransportList.insertBefore(ElemLi, UiTransportList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyTransportRow_"+dummyId);
			var DummyData = document.getElementById("TransportdataDummyTransportRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Transportdata"+ElemId);		
				DummyData.value = obj_Transport.getTransportData();		
				}
				UI_createTopbarSubTransportHtmlElem(obj_Transport);
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
				var ElemLi = UI_createTransportRowHtmlElem(obj_Transport,ElemId, ClassName);
				UiTransportList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("TransportList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, TransportId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("TransportListRow_"+TransportId);
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


