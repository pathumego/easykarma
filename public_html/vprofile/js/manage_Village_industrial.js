//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_industrial_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_industrial(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_industrial(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_industrial(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_industrial(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_industrial(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_industrial = new Village_industrial();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_industrial.IndustrialId= mainPacket[3];
		obj_Village_industrial.VillageId= mainPacket[4];
		obj_Village_industrial.BusinessId= mainPacket[5];
		obj_Village_industrial.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_industrialRow(obj_Village_industrial, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_industrial(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_industrial = new Village_industrial();
		
		var resultStatus = mainPacket[0];
		var BusinessId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_industrialListRow_"+BusinessId);
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
				var rowElem = document.getElementById("Village_industrialListRow_"+BusinessId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_industrial(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_industrial = new Village_industrial();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_industrial.IndustrialId= mainPacket[2];
		obj_Village_industrial.VillageId= mainPacket[3];
		obj_Village_industrial.BusinessId= mainPacket[4];
		obj_Village_industrial.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_industrialRow(obj_Village_industrial, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_industrial_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_industrialPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_industrial; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_industrialPacket(BusinessId) {
	var deletePacketBody  = BusinessId;

	var postpacket = createOutgoingVillage_industrialPacket(202,deletePacketBody);
	Village_industrial_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_industrialPacket(obj_Village_industrial) {
	var savePacketBody  = obj_Village_industrial.createVillage_industrialPacket();

	var postpacket = createOutgoingVillage_industrialPacket(203,savePacketBody);
	Village_industrial_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_industrialPacket(dummyId,obj_Village_industrial) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_industrial.createVillage_industrialPacket();

	var postpacket = createOutgoingVillage_industrialPacket(201,savePacketBody);
	Village_industrial_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_industrialPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_industrialPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_industrial = document.getElementById("btnaddVillage_industrial");
	if(addVillage_industrial){
	addVillage_industrial.addEventListener('mousedown', Event_mousedown_addVillage_industrial, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_industrialform = document.getElementById("popVillage_industrialform");
	var inputElems = popVillage_industrialform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_industrialList = document.getElementById("Village_industrialList");
	var liElems = UiVillage_industrialList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_industrialRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_industrialRow, false);
		
	}
	
	var UiVillage_industrialListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_industrialListDeletebtns.length; z++) {
			UiVillage_industrialListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_industrialRowBtn, false);			
		
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
	UI_search_Village_industrial(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_industrialRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_industrial = Get_Village_industrialByListRow(this.parentNode.parentNode);
			if(obj_Village_industrial != ""){
				deleteVillage_industrial(obj_Village_industrial.BusinessId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_industrial = Get_Village_industrialByListRow(this.parentNode.parentNode);
			if(obj_Village_industrial != ""){
				UI_showUpdateVillage_industrialForm(obj_Village_industrial);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_industrial(searchText)
{

	//Village_industrialList = 
	var Village_industrialListElem = document.getElementById("Village_industrialList");
	
	if(Village_industrialListElem)
	{
		var Village_industrialDataList = Village_industrialListElem.getElementsByTagName("input");
		for(var y=0 in Village_industrialDataList)
		{
			if(Village_industrialDataList[y])
			{
				
				
				var displayType = "none";
				var Village_industrialData = Village_industrialDataList[y].value;
				if(!((Village_industrialData == "") || (typeof Village_industrialData=="undefined")))
				{
				if(search_Village_industrial(Village_industrialData,searchText))
				{
					displayType = "block";
				}
				Village_industrialDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_industrial(Village_industrialData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_industrialData = decodeSpText(Village_industrialData.toLowerCase());
	if(Village_industrialData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_industrial)
{
	if (obj_Village_industrial.BusinessId) {
		var fieldDataId = obj_Village_industrial.BusinessId;
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

function deleteVillage_industrial(BusinessId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_industrial");
	if(flag){
			DeleteVillage_industrialPacket(BusinessId);
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

function Get_Village_industrialByListRow(listRowElem)
{
	
	var obj_Village_industrial ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_industrialData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_industrialData = elemlist[z].value;
			}		
		}
		
		if(Village_industrialData != "")
		{
		var arrVillage_industrialData = Village_industrialData.split(";");	
		
		obj_Village_industrial = new Village_industrial();
		obj_Village_industrial.IndustrialId= arrVillage_industrialData[0];
		obj_Village_industrial.VillageId= arrVillage_industrialData[1];
		obj_Village_industrial.BusinessId= arrVillage_industrialData[2];
		obj_Village_industrial.Description= arrVillage_industrialData[3];

		
		
		}
		
	}
	
	return obj_Village_industrial;
	
	
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
					error = "please Enter Description";
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
	
		var obj_Village_industrial = new Village_industrial();
		
		var IndustrialId= document.getElementById("Input_IndustrialId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var BusinessId= document.getElementById("Input_BusinessId").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_IndustrialId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_industrial = new Village_industrial();
		obj_Village_industrial.IndustrialId= IndustrialId;
		obj_Village_industrial.VillageId= VillageId;
		obj_Village_industrial.BusinessId= BusinessId;
		obj_Village_industrial.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_industrialPacket(dummyId,obj_Village_industrial);
		UI_createVillage_industrialRow(obj_Village_industrial, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_industrial = new Village_industrial();

		obj_Village_industrial.IndustrialId= IndustrialId;
		obj_Village_industrial.VillageId= VillageId;
		obj_Village_industrial.BusinessId= BusinessId;
		obj_Village_industrial.Description= Description;

		
		UpdateVillage_industrialPacket(obj_Village_industrial);
		UI_createVillage_industrialRow(obj_Village_industrial, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_industrial() {
	
	UI_showAddVillage_industrialForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_industrialForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_industrialAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_industrialform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_industrialForm(obj_Village_industrial) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_industrialUpdateForm(obj_Village_industrial);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_industrialform"));
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
function UI_prepareVillage_industrialUpdateForm(obj_Village_industrial)
{
	var arr_hidelist = new Array("Input_BusinessId","Input_IndustrialId","Input_VillageId");
	var arr_showlist = new Array("Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_IndustrialId").value=obj_Village_industrial.IndustrialId;
		document.getElementById("Input_VillageId").value=obj_Village_industrial.VillageId;
		document.getElementById("Input_BusinessId").value=obj_Village_industrial.BusinessId;
		document.getElementById("Input_Description").value=obj_Village_industrial.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_industrialAddForm()
{
	var arr_hidelist = new Array("Input_BusinessId","Input_IndustrialId","Input_VillageId");
	var arr_showlist = new Array("Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_IndustrialId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_industrialToVillage_industrialList() {
	var uiVillage_industrialList = document.getElementById("Village_industrialList");

	var rowElems = uiVillage_industrialList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_industrialRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_industrialRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_industrialRowHtmlElem(obj_Village_industrial,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_industrialImg_"+obj_Village_industrial.BusinessId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_industrial/0_small.png";
	else ImgElem.src = "Village_industrial/"+obj_Village_industrial.BusinessId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_industrial.IndustrialId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_industrial.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_industrial.BusinessId;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_industrial.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_industrialdata"+ElemId);
		ElementDataHidden.value = obj_Village_industrial.getVillage_industrialData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_industrialRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_industrialRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_industrialRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_industrialHtmlElem(obj_Village_industrial)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_industrial");
		html ="<a href=\"?page=dashboard&BusinessId="+obj_Village_industrial.BusinessId+"\">"+obj_Village_industrial.BusinessId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_industrialRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_industrialRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_industrialRow(obj_Village_industrial, rowType,dummyId) {
	var html = "";
	
	var UiVillage_industrialList = document.getElementById("Village_industrialList");
	var ClassName = "ListRow";
	var ElemId = "Village_industrialListRow_"+obj_Village_industrial.BusinessId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_industrialRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_industrialRowHtmlElem(obj_Village_industrial,ElemId, ClassName);
			UiVillage_industrialList.insertBefore(ElemLi, UiVillage_industrialList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_industrial msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_industrialRowHtmlElem(obj_Village_industrial,ElemId, ClassName);
			UiVillage_industrialList.insertBefore(ElemLi, UiVillage_industrialList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_industrialRow_"+dummyId);
			var DummyData = document.getElementById("Village_industrialdataDummyVillage_industrialRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_industrialdata"+ElemId);		
				DummyData.value = obj_Village_industrial.getVillage_industrialData();		
				}
				UI_createTopbarSubVillage_industrialHtmlElem(obj_Village_industrial);
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
				var ElemLi = UI_createVillage_industrialRowHtmlElem(obj_Village_industrial,ElemId, ClassName);
				UiVillage_industrialList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_industrialList");
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
		var profileAvatar = document.getElementById("Village_industrialListRow_"+BusinessId);
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


