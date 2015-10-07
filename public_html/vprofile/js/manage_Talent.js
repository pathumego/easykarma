//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Talent_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addTalent(mainPacket);
			break;
		}
		case 201: {
			ACK_addTalent(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteTalent(mainPacket);
			break;
		}
		case 203: {
			ACK_updateTalent(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addTalent(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Talent = new Talent();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Talent.TalentId= mainPacket[3];
		obj_Talent.TalentType= mainPacket[4];
		obj_Talent.TalentField= mainPacket[5];
		obj_Talent.Description= mainPacket[6];
		obj_Talent.TalentName= mainPacket[7];



		if (resultStatus == 1) {	
			
			UI_createTalentRow(obj_Talent, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteTalent(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Talent = new Talent();
		
		var resultStatus = mainPacket[0];
		var TalentId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("TalentListRow_"+TalentId);
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
				var rowElem = document.getElementById("TalentListRow_"+TalentId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateTalent(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Talent = new Talent();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Talent.TalentId= mainPacket[2];
		obj_Talent.TalentType= mainPacket[3];
		obj_Talent.TalentField= mainPacket[4];
		obj_Talent.Description= mainPacket[5];
		obj_Talent.TalentName= mainPacket[6];


		if (resultStatus == 1) {			
			UI_createTalentRow(obj_Talent, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Talent_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingTalentPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Talent; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteTalentPacket(TalentId) {
	var deletePacketBody  = TalentId;

	var postpacket = createOutgoingTalentPacket(202,deletePacketBody);
	Talent_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateTalentPacket(obj_Talent) {
	var savePacketBody  = obj_Talent.createTalentPacket();

	var postpacket = createOutgoingTalentPacket(203,savePacketBody);
	Talent_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddTalentPacket(dummyId,obj_Talent) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Talent.createTalentPacket();

	var postpacket = createOutgoingTalentPacket(201,savePacketBody);
	Talent_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onTalentPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onTalentPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addTalent = document.getElementById("btnaddTalent");
	if(addTalent){
	addTalent.addEventListener('mousedown', Event_mousedown_addTalent, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popTalentform = document.getElementById("popTalentform");
	var inputElems = popTalentform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiTalentList = document.getElementById("TalentList");
	var liElems = UiTalentList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverTalentRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutTalentRow, false);
		
	}
	
	var UiTalentListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiTalentListDeletebtns.length; z++) {
			UiTalentListDeletebtns[z].addEventListener('mousedown', Event_mouseDownTalentRowBtn, false);			
		
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
	UI_search_Talent(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownTalentRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Talent = Get_TalentByListRow(this.parentNode.parentNode);
			if(obj_Talent != ""){
				deleteTalent(obj_Talent.TalentId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Talent = Get_TalentByListRow(this.parentNode.parentNode);
			if(obj_Talent != ""){
				UI_showUpdateTalentForm(obj_Talent);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Talent(searchText)
{

	//TalentList = 
	var TalentListElem = document.getElementById("TalentList");
	
	if(TalentListElem)
	{
		var TalentDataList = TalentListElem.getElementsByTagName("input");
		for(var y=0 in TalentDataList)
		{
			if(TalentDataList[y])
			{
				
				
				var displayType = "none";
				var TalentData = TalentDataList[y].value;
				if(!((TalentData == "") || (typeof TalentData=="undefined")))
				{
				if(search_Talent(TalentData,searchText))
				{
					displayType = "block";
				}
				TalentDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Talent(TalentData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	TalentData = decodeSpText(TalentData.toLowerCase());
	if(TalentData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Talent)
{
	if (obj_Talent.TalentId) {
		var fieldDataId = obj_Talent.TalentId;
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

function deleteTalent(TalentId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Talent");
	if(flag){
			DeleteTalentPacket(TalentId);
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

function Get_TalentByListRow(listRowElem)
{
	
	var obj_Talent ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var TalentData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				TalentData = elemlist[z].value;
			}		
		}
		
		if(TalentData != "")
		{
		var arrTalentData = TalentData.split(";");	
		
		obj_Talent = new Talent();
		obj_Talent.TalentId= arrTalentData[0];
		obj_Talent.TalentType= arrTalentData[1];
		obj_Talent.TalentField= arrTalentData[2];
		obj_Talent.Description= arrTalentData[3];
		obj_Talent.TalentName= arrTalentData[4];

		
		
		}
		
	}
	
	return obj_Talent;
	
	
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
	
				var Elem = document.getElementById("Input_TalentType");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Talent Type";
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
	
		var obj_Talent = new Talent();
		
		var TalentId= document.getElementById("Input_TalentId").value;
		var TalentType= document.getElementById("Input_TalentType").value;
		var TalentField= document.getElementById("Input_TalentField").value;
		var Description= document.getElementById("Input_Description").value;
		var TalentName= document.getElementById("Input_TalentName").value;

		
		document.getElementById("Input_TalentId").value="";
		document.getElementById("Input_TalentType").value="";
		document.getElementById("Input_TalentField").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_TalentName").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Talent = new Talent();
		obj_Talent.TalentId= TalentId;
		obj_Talent.TalentType= TalentType;
		obj_Talent.TalentField= TalentField;
		obj_Talent.Description= Description;
		obj_Talent.TalentName= TalentName;

		
		var dummyId = CreateDummyNumber();
		AddTalentPacket(dummyId,obj_Talent);
		UI_createTalentRow(obj_Talent, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Talent = new Talent();

		obj_Talent.TalentId= TalentId;
		obj_Talent.TalentType= TalentType;
		obj_Talent.TalentField= TalentField;
		obj_Talent.Description= Description;
		obj_Talent.TalentName= TalentName;

		
		UpdateTalentPacket(obj_Talent);
		UI_createTalentRow(obj_Talent, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addTalent() {
	
	UI_showAddTalentForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddTalentForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTalentAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTalentform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateTalentForm(obj_Talent) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTalentUpdateForm(obj_Talent);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTalentform"));
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
function UI_prepareTalentUpdateForm(obj_Talent)
{
	var arr_hidelist = new Array("Input_TalentType","Input_TalentId");
	var arr_showlist = new Array("Input_TalentField","Input_Description","Input_TalentName");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TalentId").value=obj_Talent.TalentId;
		document.getElementById("Input_TalentType").value=obj_Talent.TalentType;
		document.getElementById("Input_TalentField").value=obj_Talent.TalentField;
		document.getElementById("Input_Description").value=obj_Talent.Description;
		document.getElementById("Input_TalentName").value=obj_Talent.TalentName;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareTalentAddForm()
{
	var arr_hidelist = new Array("Input_TalentType","Input_TalentId");
	var arr_showlist = new Array("Input_TalentField","Input_Description","Input_TalentName");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TalentId").value="";
		document.getElementById("Input_TalentType").value="";
		document.getElementById("Input_TalentField").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_TalentName").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addTalentToTalentList() {
	var uiTalentList = document.getElementById("TalentList");

	var rowElems = uiTalentList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createTalentRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownTalentRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTalentRowHtmlElem(obj_Talent,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "TalentImg_"+obj_Talent.TalentId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Talent/0_small.png";
	else ImgElem.src = "Talent/"+obj_Talent.TalentId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Talent.TalentId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Talent.TalentType;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Talent.TalentField;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Talent.Description;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Talent.TalentName;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Talentdata"+ElemId);
		ElementDataHidden.value = obj_Talent.getTalentData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);

		
		ElemLi= UI_createTalentRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverTalentRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutTalentRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubTalentHtmlElem(obj_Talent)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subTalent");
		html ="<a href=\"?page=dashboard&TalentId="+obj_Talent.TalentId+"\">"+obj_Talent.TalentId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverTalentRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutTalentRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTalentRow(obj_Talent, rowType,dummyId) {
	var html = "";
	
	var UiTalentList = document.getElementById("TalentList");
	var ClassName = "ListRow";
	var ElemId = "TalentListRow_"+obj_Talent.TalentId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyTalentRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createTalentRowHtmlElem(obj_Talent,ElemId, ClassName);
			UiTalentList.insertBefore(ElemLi, UiTalentList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Talent msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createTalentRowHtmlElem(obj_Talent,ElemId, ClassName);
			UiTalentList.insertBefore(ElemLi, UiTalentList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyTalentRow_"+dummyId);
			var DummyData = document.getElementById("TalentdataDummyTalentRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Talentdata"+ElemId);		
				DummyData.value = obj_Talent.getTalentData();		
				}
				UI_createTopbarSubTalentHtmlElem(obj_Talent);
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
				var ElemLi = UI_createTalentRowHtmlElem(obj_Talent,ElemId, ClassName);
				UiTalentList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("TalentList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, TalentId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("TalentListRow_"+TalentId);
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


