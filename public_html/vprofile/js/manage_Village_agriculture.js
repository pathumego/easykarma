//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_agriculture_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_agriculture(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_agriculture(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_agriculture(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_agriculture(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_agriculture(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_agriculture = new Village_agriculture();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_agriculture.AgricultureId= mainPacket[3];
		obj_Village_agriculture.VillageId= mainPacket[4];
		obj_Village_agriculture.BusinessId= mainPacket[5];
		obj_Village_agriculture.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_agricultureRow(obj_Village_agriculture, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_agriculture(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_agriculture = new Village_agriculture();
		
		var resultStatus = mainPacket[0];
		var BusinessId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_agricultureListRow_"+BusinessId);
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
				var rowElem = document.getElementById("Village_agricultureListRow_"+BusinessId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_agriculture(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_agriculture = new Village_agriculture();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_agriculture.AgricultureId= mainPacket[2];
		obj_Village_agriculture.VillageId= mainPacket[3];
		obj_Village_agriculture.BusinessId= mainPacket[4];
		obj_Village_agriculture.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_agricultureRow(obj_Village_agriculture, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_agriculture_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_agriculturePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_agriculture; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_agriculturePacket(BusinessId) {
	var deletePacketBody  = BusinessId;

	var postpacket = createOutgoingVillage_agriculturePacket(202,deletePacketBody);
	Village_agriculture_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_agriculturePacket(obj_Village_agriculture) {
	var savePacketBody  = obj_Village_agriculture.createVillage_agriculturePacket();

	var postpacket = createOutgoingVillage_agriculturePacket(203,savePacketBody);
	Village_agriculture_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_agriculturePacket(dummyId,obj_Village_agriculture) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_agriculture.createVillage_agriculturePacket();

	var postpacket = createOutgoingVillage_agriculturePacket(201,savePacketBody);
	Village_agriculture_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_agriculturePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_agriculturePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_agriculture = document.getElementById("btnaddVillage_agriculture");
	if(addVillage_agriculture){
	addVillage_agriculture.addEventListener('mousedown', Event_mousedown_addVillage_agriculture, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_agricultureform = document.getElementById("popVillage_agricultureform");
	var inputElems = popVillage_agricultureform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_agricultureList = document.getElementById("Village_agricultureList");
	var liElems = UiVillage_agricultureList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_agricultureRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_agricultureRow, false);
		
	}
	
	var UiVillage_agricultureListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_agricultureListDeletebtns.length; z++) {
			UiVillage_agricultureListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_agricultureRowBtn, false);			
		
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
	UI_search_Village_agriculture(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_agricultureRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_agriculture = Get_Village_agricultureByListRow(this.parentNode.parentNode);
			if(obj_Village_agriculture != ""){
				deleteVillage_agriculture(obj_Village_agriculture.BusinessId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_agriculture = Get_Village_agricultureByListRow(this.parentNode.parentNode);
			if(obj_Village_agriculture != ""){
				UI_showUpdateVillage_agricultureForm(obj_Village_agriculture);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_agriculture(searchText)
{

	//Village_agricultureList = 
	var Village_agricultureListElem = document.getElementById("Village_agricultureList");
	
	if(Village_agricultureListElem)
	{
		var Village_agricultureDataList = Village_agricultureListElem.getElementsByTagName("input");
		for(var y=0 in Village_agricultureDataList)
		{
			if(Village_agricultureDataList[y])
			{
				
				
				var displayType = "none";
				var Village_agricultureData = Village_agricultureDataList[y].value;
				if(!((Village_agricultureData == "") || (typeof Village_agricultureData=="undefined")))
				{
				if(search_Village_agriculture(Village_agricultureData,searchText))
				{
					displayType = "block";
				}
				Village_agricultureDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_agriculture(Village_agricultureData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_agricultureData = decodeSpText(Village_agricultureData.toLowerCase());
	if(Village_agricultureData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_agriculture)
{
	if (obj_Village_agriculture.BusinessId) {
		var fieldDataId = obj_Village_agriculture.BusinessId;
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

function deleteVillage_agriculture(BusinessId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_agriculture");
	if(flag){
			DeleteVillage_agriculturePacket(BusinessId);
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

function Get_Village_agricultureByListRow(listRowElem)
{
	
	var obj_Village_agriculture ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_agricultureData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_agricultureData = elemlist[z].value;
			}		
		}
		
		if(Village_agricultureData != "")
		{
		var arrVillage_agricultureData = Village_agricultureData.split(";");	
		
		obj_Village_agriculture = new Village_agriculture();
		obj_Village_agriculture.AgricultureId= arrVillage_agricultureData[0];
		obj_Village_agriculture.VillageId= arrVillage_agricultureData[1];
		obj_Village_agriculture.BusinessId= arrVillage_agricultureData[2];
		obj_Village_agriculture.Description= arrVillage_agricultureData[3];

		
		
		}
		
	}
	
	return obj_Village_agriculture;
	
	
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
					error = "Please enter description";
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
	
		var obj_Village_agriculture = new Village_agriculture();
		
		var AgricultureId= document.getElementById("Input_AgricultureId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var BusinessId= document.getElementById("Input_BusinessId").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_AgricultureId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_agriculture = new Village_agriculture();
		obj_Village_agriculture.AgricultureId= AgricultureId;
		obj_Village_agriculture.VillageId= VillageId;
		obj_Village_agriculture.BusinessId= BusinessId;
		obj_Village_agriculture.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_agriculturePacket(dummyId,obj_Village_agriculture);
		UI_createVillage_agricultureRow(obj_Village_agriculture, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_agriculture = new Village_agriculture();

		obj_Village_agriculture.AgricultureId= AgricultureId;
		obj_Village_agriculture.VillageId= VillageId;
		obj_Village_agriculture.BusinessId= BusinessId;
		obj_Village_agriculture.Description= Description;

		
		UpdateVillage_agriculturePacket(obj_Village_agriculture);
		UI_createVillage_agricultureRow(obj_Village_agriculture, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_agriculture() {
	
	UI_showAddVillage_agricultureForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_agricultureForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_agricultureAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_agricultureform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_agricultureForm(obj_Village_agriculture) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_agricultureUpdateForm(obj_Village_agriculture);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_agricultureform"));
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
function UI_prepareVillage_agricultureUpdateForm(obj_Village_agriculture)
{
	var arr_hidelist = new Array("Input_AgricultureId","Input_VillageId");
	var arr_showlist = new Array("Input_Description","Input_BusinessId","Input_BusinessId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_AgricultureId").value=obj_Village_agriculture.AgricultureId;
		document.getElementById("Input_VillageId").value=obj_Village_agriculture.VillageId;
		document.getElementById("Input_BusinessId").value=obj_Village_agriculture.BusinessId;
		document.getElementById("Input_Description").value=obj_Village_agriculture.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_agricultureAddForm()
{
	var arr_hidelist = new Array("Input_BusinessId","Input_AgricultureId","Input_VillageId","Input_BusinessId");
	var arr_showlist = new Array("Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_AgricultureId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_agricultureToVillage_agricultureList() {
	var uiVillage_agricultureList = document.getElementById("Village_agricultureList");

	var rowElems = uiVillage_agricultureList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_agricultureRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_agricultureRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_agricultureRowHtmlElem(obj_Village_agriculture,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_agricultureImg_"+obj_Village_agriculture.BusinessId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_agriculture/0_small.png";
	else ImgElem.src = "Village_agriculture/"+obj_Village_agriculture.BusinessId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_agriculture.AgricultureId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_agriculture.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_agriculture.BusinessId;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_agriculture.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_agriculturedata"+ElemId);
		ElementDataHidden.value = obj_Village_agriculture.getVillage_agricultureData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_agricultureRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_agricultureRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_agricultureRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_agricultureHtmlElem(obj_Village_agriculture)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_agriculture");
		html ="<a href=\"?page=dashboard&BusinessId="+obj_Village_agriculture.BusinessId+"\">"+obj_Village_agriculture.BusinessId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_agricultureRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_agricultureRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_agricultureRow(obj_Village_agriculture, rowType,dummyId) {
	var html = "";
	
	var UiVillage_agricultureList = document.getElementById("Village_agricultureList");
	var ClassName = "ListRow";
	var ElemId = "Village_agricultureListRow_"+obj_Village_agriculture.BusinessId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_agricultureRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_agricultureRowHtmlElem(obj_Village_agriculture,ElemId, ClassName);
			UiVillage_agricultureList.insertBefore(ElemLi, UiVillage_agricultureList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_agriculture msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_agricultureRowHtmlElem(obj_Village_agriculture,ElemId, ClassName);
			UiVillage_agricultureList.insertBefore(ElemLi, UiVillage_agricultureList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_agricultureRow_"+dummyId);
			var DummyData = document.getElementById("Village_agriculturedataDummyVillage_agricultureRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_agriculturedata"+ElemId);		
				DummyData.value = obj_Village_agriculture.getVillage_agricultureData();		
				}
				UI_createTopbarSubVillage_agricultureHtmlElem(obj_Village_agriculture);
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
				var ElemLi = UI_createVillage_agricultureRowHtmlElem(obj_Village_agriculture,ElemId, ClassName);
				UiVillage_agricultureList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_agricultureList");
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
		var profileAvatar = document.getElementById("Village_agricultureListRow_"+BusinessId);
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


