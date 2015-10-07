//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Town_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addTown(mainPacket);
			break;
		}
		case 201: {
			ACK_addTown(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteTown(mainPacket);
			break;
		}
		case 203: {
			ACK_updateTown(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addTown(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Town = new Town();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Town.TownId= mainPacket[3];
		obj_Town.TownName= mainPacket[4];
		obj_Town.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createTownRow(obj_Town, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteTown(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Town = new Town();
		
		var resultStatus = mainPacket[0];
		var TownId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("TownListRow_"+TownId);
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
				var rowElem = document.getElementById("TownListRow_"+TownId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateTown(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Town = new Town();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Town.TownId= mainPacket[2];
		obj_Town.TownName= mainPacket[3];
		obj_Town.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createTownRow(obj_Town, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Town_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingTownPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Town; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteTownPacket(TownId) {
	var deletePacketBody  = TownId;

	var postpacket = createOutgoingTownPacket(202,deletePacketBody);
	Town_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateTownPacket(obj_Town) {
	var savePacketBody  = obj_Town.createTownPacket();

	var postpacket = createOutgoingTownPacket(203,savePacketBody);
	Town_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddTownPacket(dummyId,obj_Town) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Town.createTownPacket();

	var postpacket = createOutgoingTownPacket(201,savePacketBody);
	Town_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onTownPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onTownPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addTown = document.getElementById("btnaddTown");
	if(addTown){
	addTown.addEventListener('mousedown', Event_mousedown_addTown, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popTownform = document.getElementById("popTownform");
	var inputElems = popTownform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiTownList = document.getElementById("TownList");
	var liElems = UiTownList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverTownRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutTownRow, false);
		
	}
	
	var UiTownListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiTownListDeletebtns.length; z++) {
			UiTownListDeletebtns[z].addEventListener('mousedown', Event_mouseDownTownRowBtn, false);			
		
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
	UI_search_Town(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownTownRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Town = Get_TownByListRow(this.parentNode.parentNode);
			if(obj_Town != ""){
				deleteTown(obj_Town.TownId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Town = Get_TownByListRow(this.parentNode.parentNode);
			if(obj_Town != ""){
				UI_showUpdateTownForm(obj_Town);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Town(searchText)
{

	//TownList = 
	var TownListElem = document.getElementById("TownList");
	
	if(TownListElem)
	{
		var TownDataList = TownListElem.getElementsByTagName("input");
		for(var y=0 in TownDataList)
		{
			if(TownDataList[y])
			{
				
				
				var displayType = "none";
				var TownData = TownDataList[y].value;
				if(!((TownData == "") || (typeof TownData=="undefined")))
				{
				if(search_Town(TownData,searchText))
				{
					displayType = "block";
				}
				TownDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Town(TownData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	TownData = decodeSpText(TownData.toLowerCase());
	if(TownData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Town)
{
	if (obj_Town.TownId) {
		var fieldDataId = obj_Town.TownId;
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

function deleteTown(TownId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Town");
	if(flag){
			DeleteTownPacket(TownId);
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

function Get_TownByListRow(listRowElem)
{
	
	var obj_Town ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var TownData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				TownData = elemlist[z].value;
			}		
		}
		
		if(TownData != "")
		{
		var arrTownData = TownData.split(";");	
		
		obj_Town = new Town();
		obj_Town.TownId= arrTownData[0];
		obj_Town.TownName= arrTownData[1];
		obj_Town.Description= arrTownData[2];

		
		
		}
		
	}
	
	return obj_Town;
	
	
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
	

		var Elem = document.getElementById("Input_TownName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter town name";
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
	
		var obj_Town = new Town();
		
		var TownId= document.getElementById("Input_TownId").value;
		var TownName= document.getElementById("Input_TownName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_TownId").value="";
		document.getElementById("Input_TownName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Town = new Town();
		obj_Town.TownId= TownId;
		obj_Town.TownName= TownName;
		obj_Town.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddTownPacket(dummyId,obj_Town);
		UI_createTownRow(obj_Town, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Town = new Town();

		obj_Town.TownId= TownId;
		obj_Town.TownName= TownName;
		obj_Town.Description= Description;

		
		UpdateTownPacket(obj_Town);
		UI_createTownRow(obj_Town, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addTown() {
	
	UI_showAddTownForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddTownForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTownAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTownform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateTownForm(obj_Town) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTownUpdateForm(obj_Town);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTownform"));
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
function UI_prepareTownUpdateForm(obj_Town)
{
	var arr_hidelist = new Array("Input_TownId");
	var arr_showlist = new Array("Input_TownName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TownId").value=obj_Town.TownId;
		document.getElementById("Input_TownName").value=obj_Town.TownName;
		document.getElementById("Input_Description").value=obj_Town.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareTownAddForm()
{
	var arr_hidelist = new Array("Input_TownId");
	var arr_showlist = new Array("Input_TownName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TownId").value="";
		document.getElementById("Input_TownName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addTownToTownList() {
	var uiTownList = document.getElementById("TownList");

	var rowElems = uiTownList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createTownRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownTownRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTownRowHtmlElem(obj_Town,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "TownImg_"+obj_Town.TownId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Town/0_small.png";
	else ImgElem.src = "Town/"+obj_Town.TownId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Town.TownId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Town.TownName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Town.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Towndata"+ElemId);
		ElementDataHidden.value = obj_Town.getTownData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createTownRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverTownRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutTownRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubTownHtmlElem(obj_Town)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subTown");
		html ="<a href=\"?page=dashboard&TownId="+obj_Town.TownId+"\">"+obj_Town.TownId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverTownRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutTownRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTownRow(obj_Town, rowType,dummyId) {
	var html = "";
	
	var UiTownList = document.getElementById("TownList");
	var ClassName = "ListRow";
	var ElemId = "TownListRow_"+obj_Town.TownId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyTownRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createTownRowHtmlElem(obj_Town,ElemId, ClassName);
			UiTownList.insertBefore(ElemLi, UiTownList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Town msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createTownRowHtmlElem(obj_Town,ElemId, ClassName);
			UiTownList.insertBefore(ElemLi, UiTownList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyTownRow_"+dummyId);
			var DummyData = document.getElementById("TowndataDummyTownRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Towndata"+ElemId);		
				DummyData.value = obj_Town.getTownData();		
				}
				UI_createTopbarSubTownHtmlElem(obj_Town);
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
				var ElemLi = UI_createTownRowHtmlElem(obj_Town,ElemId, ClassName);
				UiTownList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("TownList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, TownId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("TownListRow_"+TownId);
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


