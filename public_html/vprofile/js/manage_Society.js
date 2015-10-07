//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Society_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addSociety(mainPacket);
			break;
		}
		case 201: {
			ACK_addSociety(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteSociety(mainPacket);
			break;
		}
		case 203: {
			ACK_updateSociety(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addSociety(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Society = new Society();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Society.SocietyId= mainPacket[3];
		obj_Society.Name= mainPacket[4];
		obj_Society.Description= mainPacket[5];
		obj_Society.Mission= mainPacket[6];
		obj_Society.SocietyTypeId= mainPacket[7];
		obj_Society.SocietyAddress= mainPacket[8];



		if (resultStatus == 1) {	
			
			UI_createSocietyRow(obj_Society, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteSociety(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Society = new Society();
		
		var resultStatus = mainPacket[0];
		var SocietyId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("SocietyListRow_"+SocietyId);
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
				var rowElem = document.getElementById("SocietyListRow_"+SocietyId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateSociety(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Society = new Society();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Society.SocietyId= mainPacket[2];
		obj_Society.Name= mainPacket[3];
		obj_Society.Description= mainPacket[4];
		obj_Society.Mission= mainPacket[5];
		obj_Society.SocietyTypeId= mainPacket[6];
		obj_Society.SocietyAddress= mainPacket[7];


		if (resultStatus == 1) {			
			UI_createSocietyRow(obj_Society, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Society_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingSocietyPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Society; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteSocietyPacket(SocietyId) {
	var deletePacketBody  = SocietyId;

	var postpacket = createOutgoingSocietyPacket(202,deletePacketBody);
	Society_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateSocietyPacket(obj_Society) {
	var savePacketBody  = obj_Society.createSocietyPacket();

	var postpacket = createOutgoingSocietyPacket(203,savePacketBody);
	Society_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddSocietyPacket(dummyId,obj_Society) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Society.createSocietyPacket();

	var postpacket = createOutgoingSocietyPacket(201,savePacketBody);
	Society_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onSocietyPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onSocietyPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addSociety = document.getElementById("btnaddSociety");
	if(addSociety){
	addSociety.addEventListener('mousedown', Event_mousedown_addSociety, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popSocietyform = document.getElementById("popSocietyform");
	var inputElems = popSocietyform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiSocietyList = document.getElementById("SocietyList");
	var liElems = UiSocietyList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverSocietyRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutSocietyRow, false);
		
	}
	
	var UiSocietyListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiSocietyListDeletebtns.length; z++) {
			UiSocietyListDeletebtns[z].addEventListener('mousedown', Event_mouseDownSocietyRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_SocietyTypeId","SocieryTypeName",36); //society type
	
	
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
	UI_search_Society(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownSocietyRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Society = Get_SocietyByListRow(this.parentNode.parentNode);
			if(obj_Society != ""){
				deleteSociety(obj_Society.SocietyId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Society = Get_SocietyByListRow(this.parentNode.parentNode);
			if(obj_Society != ""){
				UI_showUpdateSocietyForm(obj_Society);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Society(searchText)
{

	//SocietyList = 
	var SocietyListElem = document.getElementById("SocietyList");
	
	if(SocietyListElem)
	{
		var SocietyDataList = SocietyListElem.getElementsByTagName("input");
		for(var y=0 in SocietyDataList)
		{
			if(SocietyDataList[y])
			{
				
				
				var displayType = "none";
				var SocietyData = SocietyDataList[y].value;
				if(!((SocietyData == "") || (typeof SocietyData=="undefined")))
				{
				if(search_Society(SocietyData,searchText))
				{
					displayType = "block";
				}
				SocietyDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Society(SocietyData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	SocietyData = decodeSpText(SocietyData.toLowerCase());
	if(SocietyData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Society)
{
	if (obj_Society.SocietyId) {
		var fieldDataId = obj_Society.SocietyId;
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

function deleteSociety(SocietyId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Society");
	if(flag){
			DeleteSocietyPacket(SocietyId);
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

function Get_SocietyByListRow(listRowElem)
{
	
	var obj_Society ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var SocietyData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				SocietyData = elemlist[z].value;
			}		
		}
		
		if(SocietyData != "")
		{
		var arrSocietyData = SocietyData.split(";");	
		
		obj_Society = new Society();
		obj_Society.SocietyId= arrSocietyData[0];
		obj_Society.Name= arrSocietyData[1];
		obj_Society.Description= arrSocietyData[2];
		obj_Society.Mission= arrSocietyData[3];
		obj_Society.SocietyTypeId= arrSocietyData[4];
		obj_Society.SocietyAddress= arrSocietyData[5];

		
		
		}
		
	}
	
	return obj_Society;
	
	
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
	

			var Elem = document.getElementById("Input_Name");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Society Name";
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
	
		var obj_Society = new Society();
		
		var SocietyId= document.getElementById("Input_SocietyId").value;
		var Name= document.getElementById("Input_Name").value;
		var Description= document.getElementById("Input_Description").value;
		var Mission= document.getElementById("Input_Mission").value;
		var SocietyTypeId= document.getElementById("Input_SocietyTypeId").value;
		var SocietyAddress= document.getElementById("Input_SocietyAddress").value;

		
		document.getElementById("Input_SocietyId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_Mission").value="";
		document.getElementById("Input_SocietyTypeId").value="";
		document.getElementById("Input_SocietyAddress").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Society = new Society();
		obj_Society.SocietyId= SocietyId;
		obj_Society.Name= Name;
		obj_Society.Description= Description;
		obj_Society.Mission= Mission;
		obj_Society.SocietyTypeId= SocietyTypeId;
		obj_Society.SocietyAddress= SocietyAddress;

		
		var dummyId = CreateDummyNumber();
		AddSocietyPacket(dummyId,obj_Society);
		UI_createSocietyRow(obj_Society, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Society = new Society();

		obj_Society.SocietyId= SocietyId;
		obj_Society.Name= Name;
		obj_Society.Description= Description;
		obj_Society.Mission= Mission;
		obj_Society.SocietyTypeId= SocietyTypeId;
		obj_Society.SocietyAddress= SocietyAddress;

		
		UpdateSocietyPacket(obj_Society);
		UI_createSocietyRow(obj_Society, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addSociety() {
	
	UI_showAddSocietyForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddSocietyForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareSocietyAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popSocietyform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateSocietyForm(obj_Society) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareSocietyUpdateForm(obj_Society);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popSocietyform"));
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
function UI_prepareSocietyUpdateForm(obj_Society)
{
	var arr_hidelist = new Array("Input_SocietyId");
	var arr_showlist = new Array("Input_Name","Input_Description","Input_Mission","Input_SocietyAddress","Input_SocietyTypeId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SocietyId").value=obj_Society.SocietyId;
		document.getElementById("Input_Name").value=obj_Society.Name;
		document.getElementById("Input_Description").value=obj_Society.Description;
		document.getElementById("Input_Mission").value=obj_Society.Mission;
		document.getElementById("Input_SocietyTypeId").value=obj_Society.SocietyTypeId;
		document.getElementById("Input_SocietyAddress").value=obj_Society.SocietyAddress;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareSocietyAddForm()
{
	var arr_hidelist = new Array("Input_SocietyId");
	var arr_showlist = new Array("Input_Name","Input_Description","Input_Mission","Input_SocietyAddress","Input_SocietyTypeId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SocietyId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_Mission").value="";
		document.getElementById("Input_SocietyTypeId").value="";
		document.getElementById("Input_SocietyAddress").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addSocietyToSocietyList() {
	var uiSocietyList = document.getElementById("SocietyList");

	var rowElems = uiSocietyList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createSocietyRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownSocietyRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createSocietyRowHtmlElem(obj_Society,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "SocietyImg_"+obj_Society.SocietyId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Society/0_small.png";
	else ImgElem.src = "Society/"+obj_Society.SocietyId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Society.SocietyId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Society.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Society.Description;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Society.Mission;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Society.SocietyTypeId;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Society.SocietyAddress;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Societydata"+ElemId);
		ElementDataHidden.value = obj_Society.getSocietyData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);

		
		ElemLi= UI_createSocietyRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverSocietyRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutSocietyRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubSocietyHtmlElem(obj_Society)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subSociety");
		html ="<a href=\"?page=dashboard&SocietyId="+obj_Society.SocietyId+"\">"+obj_Society.SocietyId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverSocietyRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutSocietyRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createSocietyRow(obj_Society, rowType,dummyId) {
	var html = "";
	
	var UiSocietyList = document.getElementById("SocietyList");
	var ClassName = "ListRow";
	var ElemId = "SocietyListRow_"+obj_Society.SocietyId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummySocietyRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createSocietyRowHtmlElem(obj_Society,ElemId, ClassName);
			UiSocietyList.insertBefore(ElemLi, UiSocietyList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Society msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createSocietyRowHtmlElem(obj_Society,ElemId, ClassName);
			UiSocietyList.insertBefore(ElemLi, UiSocietyList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummySocietyRow_"+dummyId);
			var DummyData = document.getElementById("SocietydataDummySocietyRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Societydata"+ElemId);		
				DummyData.value = obj_Society.getSocietyData();		
				}
				UI_createTopbarSubSocietyHtmlElem(obj_Society);
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
				var ElemLi = UI_createSocietyRowHtmlElem(obj_Society,ElemId, ClassName);
				UiSocietyList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("SocietyList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, SocietyId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("SocietyListRow_"+SocietyId);
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


