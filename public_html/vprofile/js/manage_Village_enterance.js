//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_enterance_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_enterance(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_enterance(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_enterance(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_enterance(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_enterance(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_enterance = new Village_enterance();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_enterance.TblId= mainPacket[3];
		obj_Village_enterance.VillageId= mainPacket[4];
		obj_Village_enterance.Direction= mainPacket[5];
		obj_Village_enterance.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_enteranceRow(obj_Village_enterance, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_enterance(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_enterance = new Village_enterance();
		
		var resultStatus = mainPacket[0];
		var TblId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_enteranceListRow_"+TblId);
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
				var rowElem = document.getElementById("Village_enteranceListRow_"+TblId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_enterance(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_enterance = new Village_enterance();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_enterance.TblId= mainPacket[2];
		obj_Village_enterance.VillageId= mainPacket[3];
		obj_Village_enterance.Direction= mainPacket[4];
		obj_Village_enterance.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_enteranceRow(obj_Village_enterance, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_enterance_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_enterancePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_enterance; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_enterancePacket(TblId) {
	var deletePacketBody  = TblId;

	var postpacket = createOutgoingVillage_enterancePacket(202,deletePacketBody);
	Village_enterance_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_enterancePacket(obj_Village_enterance) {
	var savePacketBody  = obj_Village_enterance.createVillage_enterancePacket();

	var postpacket = createOutgoingVillage_enterancePacket(203,savePacketBody);
	Village_enterance_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_enterancePacket(dummyId,obj_Village_enterance) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_enterance.createVillage_enterancePacket();

	var postpacket = createOutgoingVillage_enterancePacket(201,savePacketBody);
	Village_enterance_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_enterancePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_enterancePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_enterance = document.getElementById("btnaddVillage_enterance");
	if(addVillage_enterance){
	addVillage_enterance.addEventListener('mousedown', Event_mousedown_addVillage_enterance, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_enteranceform = document.getElementById("popVillage_enteranceform");
	var inputElems = popVillage_enteranceform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_enteranceList = document.getElementById("Village_enteranceList");
	var liElems = UiVillage_enteranceList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_enteranceRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_enteranceRow, false);
		
	}
	
	var UiVillage_enteranceListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_enteranceListDeletebtns.length; z++) {
			UiVillage_enteranceListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_enteranceRowBtn, false);			
		
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
	UI_search_Village_enterance(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_enteranceRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_enterance = Get_Village_enteranceByListRow(this.parentNode.parentNode);
			if(obj_Village_enterance != ""){
				deleteVillage_enterance(obj_Village_enterance.TblId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_enterance = Get_Village_enteranceByListRow(this.parentNode.parentNode);
			if(obj_Village_enterance != ""){
				UI_showUpdateVillage_enteranceForm(obj_Village_enterance);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_enterance(searchText)
{

	//Village_enteranceList = 
	var Village_enteranceListElem = document.getElementById("Village_enteranceList");
	
	if(Village_enteranceListElem)
	{
		var Village_enteranceDataList = Village_enteranceListElem.getElementsByTagName("input");
		for(var y=0 in Village_enteranceDataList)
		{
			if(Village_enteranceDataList[y])
			{
				
				
				var displayType = "none";
				var Village_enteranceData = Village_enteranceDataList[y].value;
				if(!((Village_enteranceData == "") || (typeof Village_enteranceData=="undefined")))
				{
				if(search_Village_enterance(Village_enteranceData,searchText))
				{
					displayType = "block";
				}
				Village_enteranceDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_enterance(Village_enteranceData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_enteranceData = decodeSpText(Village_enteranceData.toLowerCase());
	if(Village_enteranceData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_enterance)
{
	if (obj_Village_enterance.TblId) {
		var fieldDataId = obj_Village_enterance.TblId;
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

function deleteVillage_enterance(TblId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_enterance");
	if(flag){
			DeleteVillage_enterancePacket(TblId);
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

function Get_Village_enteranceByListRow(listRowElem)
{
	
	var obj_Village_enterance ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_enteranceData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_enteranceData = elemlist[z].value;
			}		
		}
		
		if(Village_enteranceData != "")
		{
		var arrVillage_enteranceData = Village_enteranceData.split(";");	
		
		obj_Village_enterance = new Village_enterance();
		obj_Village_enterance.TblId= arrVillage_enteranceData[0];
		obj_Village_enterance.VillageId= arrVillage_enteranceData[1];
		obj_Village_enterance.Direction= arrVillage_enteranceData[2];
		obj_Village_enterance.Description= arrVillage_enteranceData[3];

		
		
		}
		
	}
	
	return obj_Village_enterance;
	
	
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
	
		var obj_Village_enterance = new Village_enterance();
		
		var TblId= document.getElementById("Input_TblId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var Direction= document.getElementById("Input_Direction").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Direction").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_enterance = new Village_enterance();
		obj_Village_enterance.TblId= TblId;
		obj_Village_enterance.VillageId= VillageId;
		obj_Village_enterance.Direction= Direction;
		obj_Village_enterance.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_enterancePacket(dummyId,obj_Village_enterance);
		UI_createVillage_enteranceRow(obj_Village_enterance, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_enterance = new Village_enterance();

		obj_Village_enterance.TblId= TblId;
		obj_Village_enterance.VillageId= VillageId;
		obj_Village_enterance.Direction= Direction;
		obj_Village_enterance.Description= Description;

		
		UpdateVillage_enterancePacket(obj_Village_enterance);
		UI_createVillage_enteranceRow(obj_Village_enterance, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_enterance() {
	
	UI_showAddVillage_enteranceForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_enteranceForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_enteranceAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_enteranceform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_enteranceForm(obj_Village_enterance) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_enteranceUpdateForm(obj_Village_enterance);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_enteranceform"));
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
function UI_prepareVillage_enteranceUpdateForm(obj_Village_enterance)
{
	var arr_hidelist = new Array("Input_TblId","Input_VillageId");
	var arr_showlist = new Array("Input_Direction","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value=obj_Village_enterance.TblId;
		document.getElementById("Input_VillageId").value=obj_Village_enterance.VillageId;
		document.getElementById("Input_Direction").value=obj_Village_enterance.Direction;
		document.getElementById("Input_Description").value=obj_Village_enterance.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_enteranceAddForm()
{
	var arr_hidelist = new Array("Input_TblId","Input_VillageId");
	var arr_showlist = new Array("Input_Direction","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_Direction").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_enteranceToVillage_enteranceList() {
	var uiVillage_enteranceList = document.getElementById("Village_enteranceList");

	var rowElems = uiVillage_enteranceList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_enteranceRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_enteranceRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_enteranceRowHtmlElem(obj_Village_enterance,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_enteranceImg_"+obj_Village_enterance.TblId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_enterance/0_small.png";
	else ImgElem.src = "Village_enterance/"+obj_Village_enterance.TblId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_enterance.TblId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_enterance.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_enterance.Direction;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_enterance.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_enterancedata"+ElemId);
		ElementDataHidden.value = obj_Village_enterance.getVillage_enteranceData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_enteranceRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_enteranceRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_enteranceRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_enteranceHtmlElem(obj_Village_enterance)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_enterance");
		html ="<a href=\"?page=dashboard&TblId="+obj_Village_enterance.TblId+"\">"+obj_Village_enterance.TblId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_enteranceRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_enteranceRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_enteranceRow(obj_Village_enterance, rowType,dummyId) {
	var html = "";
	
	var UiVillage_enteranceList = document.getElementById("Village_enteranceList");
	var ClassName = "ListRow";
	var ElemId = "Village_enteranceListRow_"+obj_Village_enterance.TblId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_enteranceRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_enteranceRowHtmlElem(obj_Village_enterance,ElemId, ClassName);
			UiVillage_enteranceList.insertBefore(ElemLi, UiVillage_enteranceList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_enterance msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_enteranceRowHtmlElem(obj_Village_enterance,ElemId, ClassName);
			UiVillage_enteranceList.insertBefore(ElemLi, UiVillage_enteranceList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_enteranceRow_"+dummyId);
			var DummyData = document.getElementById("Village_enterancedataDummyVillage_enteranceRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_enterancedata"+ElemId);		
				DummyData.value = obj_Village_enterance.getVillage_enteranceData();		
				}
				UI_createTopbarSubVillage_enteranceHtmlElem(obj_Village_enterance);
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
				var ElemLi = UI_createVillage_enteranceRowHtmlElem(obj_Village_enterance,ElemId, ClassName);
				UiVillage_enteranceList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_enteranceList");
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
		var profileAvatar = document.getElementById("Village_enteranceListRow_"+TblId);
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


