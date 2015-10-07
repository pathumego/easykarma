//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_transport_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_transport(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_transport(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_transport(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_transport(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_transport(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_transport = new Village_transport();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_transport.TransportId= mainPacket[3];
		obj_Village_transport.VillageId= mainPacket[4];
		obj_Village_transport.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createVillage_transportRow(obj_Village_transport, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_transport(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_transport = new Village_transport();
		
		var resultStatus = mainPacket[0];
		var VillageId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_transportListRow_"+VillageId);
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
				var rowElem = document.getElementById("Village_transportListRow_"+VillageId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_transport(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_transport = new Village_transport();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_transport.TransportId= mainPacket[2];
		obj_Village_transport.VillageId= mainPacket[3];
		obj_Village_transport.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createVillage_transportRow(obj_Village_transport, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_transport_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_transportPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_transport; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_transportPacket(VillageId) {
	var deletePacketBody  = VillageId;

	var postpacket = createOutgoingVillage_transportPacket(202,deletePacketBody);
	Village_transport_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_transportPacket(obj_Village_transport) {
	var savePacketBody  = obj_Village_transport.createVillage_transportPacket();

	var postpacket = createOutgoingVillage_transportPacket(203,savePacketBody);
	Village_transport_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_transportPacket(dummyId,obj_Village_transport) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_transport.createVillage_transportPacket();

	var postpacket = createOutgoingVillage_transportPacket(201,savePacketBody);
	Village_transport_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_transportPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_transportPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_transport = document.getElementById("btnaddVillage_transport");
	if(addVillage_transport){
	addVillage_transport.addEventListener('mousedown', Event_mousedown_addVillage_transport, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_transportform = document.getElementById("popVillage_transportform");
	var inputElems = popVillage_transportform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_transportList = document.getElementById("Village_transportList");
	var liElems = UiVillage_transportList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_transportRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_transportRow, false);
		
	}
	
	var UiVillage_transportListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_transportListDeletebtns.length; z++) {
			UiVillage_transportListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_transportRowBtn, false);			
		
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
	UI_search_Village_transport(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_transportRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_transport = Get_Village_transportByListRow(this.parentNode.parentNode);
			if(obj_Village_transport != ""){
				deleteVillage_transport(obj_Village_transport.VillageId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_transport = Get_Village_transportByListRow(this.parentNode.parentNode);
			if(obj_Village_transport != ""){
				UI_showUpdateVillage_transportForm(obj_Village_transport);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_transport(searchText)
{

	//Village_transportList = 
	var Village_transportListElem = document.getElementById("Village_transportList");
	
	if(Village_transportListElem)
	{
		var Village_transportDataList = Village_transportListElem.getElementsByTagName("input");
		for(var y=0 in Village_transportDataList)
		{
			if(Village_transportDataList[y])
			{
				
				
				var displayType = "none";
				var Village_transportData = Village_transportDataList[y].value;
				if(!((Village_transportData == "") || (typeof Village_transportData=="undefined")))
				{
				if(search_Village_transport(Village_transportData,searchText))
				{
					displayType = "block";
				}
				Village_transportDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_transport(Village_transportData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_transportData = decodeSpText(Village_transportData.toLowerCase());
	if(Village_transportData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_transport)
{
	if (obj_Village_transport.VillageId) {
		var fieldDataId = obj_Village_transport.VillageId;
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

function deleteVillage_transport(VillageId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_transport");
	if(flag){
			DeleteVillage_transportPacket(VillageId);
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

function Get_Village_transportByListRow(listRowElem)
{
	
	var obj_Village_transport ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_transportData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_transportData = elemlist[z].value;
			}		
		}
		
		if(Village_transportData != "")
		{
		var arrVillage_transportData = Village_transportData.split(";");	
		
		obj_Village_transport = new Village_transport();
		obj_Village_transport.TransportId= arrVillage_transportData[0];
		obj_Village_transport.VillageId= arrVillage_transportData[1];
		obj_Village_transport.Description= arrVillage_transportData[2];

		
		
		}
		
	}
	
	return obj_Village_transport;
	
	
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
	
		var obj_Village_transport = new Village_transport();
		
		var TransportId= document.getElementById("Input_TransportId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_TransportId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_transport = new Village_transport();
		obj_Village_transport.TransportId= TransportId;
		obj_Village_transport.VillageId= VillageId;
		obj_Village_transport.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_transportPacket(dummyId,obj_Village_transport);
		UI_createVillage_transportRow(obj_Village_transport, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_transport = new Village_transport();

		obj_Village_transport.TransportId= TransportId;
		obj_Village_transport.VillageId= VillageId;
		obj_Village_transport.Description= Description;

		
		UpdateVillage_transportPacket(obj_Village_transport);
		UI_createVillage_transportRow(obj_Village_transport, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_transport() {
	
	UI_showAddVillage_transportForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_transportForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_transportAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_transportform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_transportForm(obj_Village_transport) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_transportUpdateForm(obj_Village_transport);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_transportform"));
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
function UI_prepareVillage_transportUpdateForm(obj_Village_transport)
{
	var arr_hidelist = new Array("Input_VillageId","Input_TransportId");
	var arr_showlist = new Array("Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TransportId").value=obj_Village_transport.TransportId;
		document.getElementById("Input_VillageId").value=obj_Village_transport.VillageId;
		document.getElementById("Input_Description").value=obj_Village_transport.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_transportAddForm()
{
	var arr_hidelist = new Array("Input_VillageId","Input_TransportId");
	var arr_showlist = new Array("Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TransportId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_transportToVillage_transportList() {
	var uiVillage_transportList = document.getElementById("Village_transportList");

	var rowElems = uiVillage_transportList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_transportRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_transportRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_transportRowHtmlElem(obj_Village_transport,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_transportImg_"+obj_Village_transport.VillageId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_transport/0_small.png";
	else ImgElem.src = "Village_transport/"+obj_Village_transport.VillageId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_transport.TransportId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_transport.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_transport.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_transportdata"+ElemId);
		ElementDataHidden.value = obj_Village_transport.getVillage_transportData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createVillage_transportRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_transportRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_transportRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_transportHtmlElem(obj_Village_transport)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_transport");
		html ="<a href=\"?page=dashboard&VillageId="+obj_Village_transport.VillageId+"\">"+obj_Village_transport.VillageId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_transportRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_transportRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_transportRow(obj_Village_transport, rowType,dummyId) {
	var html = "";
	
	var UiVillage_transportList = document.getElementById("Village_transportList");
	var ClassName = "ListRow";
	var ElemId = "Village_transportListRow_"+obj_Village_transport.VillageId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_transportRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_transportRowHtmlElem(obj_Village_transport,ElemId, ClassName);
			UiVillage_transportList.insertBefore(ElemLi, UiVillage_transportList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_transport msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_transportRowHtmlElem(obj_Village_transport,ElemId, ClassName);
			UiVillage_transportList.insertBefore(ElemLi, UiVillage_transportList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_transportRow_"+dummyId);
			var DummyData = document.getElementById("Village_transportdataDummyVillage_transportRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_transportdata"+ElemId);		
				DummyData.value = obj_Village_transport.getVillage_transportData();		
				}
				UI_createTopbarSubVillage_transportHtmlElem(obj_Village_transport);
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
				var ElemLi = UI_createVillage_transportRowHtmlElem(obj_Village_transport,ElemId, ClassName);
				UiVillage_transportList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_transportList");
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
		var profileAvatar = document.getElementById("Village_transportListRow_"+VillageId);
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


