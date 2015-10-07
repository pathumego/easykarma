//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_talent_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_talent(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_talent(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_talent(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_talent(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_talent(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_talent = new Person_talent();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_talent.TblId= mainPacket[3];
		obj_Person_talent.PersonId= mainPacket[4];
		obj_Person_talent.TalentId= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createPerson_talentRow(obj_Person_talent, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_talent(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_talent = new Person_talent();
		
		var resultStatus = mainPacket[0];
		var TblId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_talentListRow_"+TblId);
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
				var rowElem = document.getElementById("Person_talentListRow_"+TblId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_talent(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_talent = new Person_talent();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_talent.TblId= mainPacket[2];
		obj_Person_talent.PersonId= mainPacket[3];
		obj_Person_talent.TalentId= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createPerson_talentRow(obj_Person_talent, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_talent_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_talentPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_talent; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_talentPacket(TblId) {
	var deletePacketBody  = TblId;

	var postpacket = createOutgoingPerson_talentPacket(202,deletePacketBody);
	Person_talent_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_talentPacket(obj_Person_talent) {
	var savePacketBody  = obj_Person_talent.createPerson_talentPacket();

	var postpacket = createOutgoingPerson_talentPacket(203,savePacketBody);
	Person_talent_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_talentPacket(dummyId,obj_Person_talent) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_talent.createPerson_talentPacket();

	var postpacket = createOutgoingPerson_talentPacket(201,savePacketBody);
	Person_talent_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_talentPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_talentPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_talent = document.getElementById("btnaddPerson_talent");
	if(addPerson_talent){
	addPerson_talent.addEventListener('mousedown', Event_mousedown_addPerson_talent, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_talentform = document.getElementById("popPerson_talentform");
	var inputElems = popPerson_talentform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_talentList = document.getElementById("Person_talentList");
	var liElems = UiPerson_talentList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_talentRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_talentRow, false);
		
	}
	
	var UiPerson_talentListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_talentListDeletebtns.length; z++) {
			UiPerson_talentListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_talentRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_TalentId","TalentName",40);	//talent
	
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
	UI_search_Person_talent(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_talentRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_talent = Get_Person_talentByListRow(this.parentNode.parentNode);
			if(obj_Person_talent != ""){
				deletePerson_talent(obj_Person_talent.TblId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_talent = Get_Person_talentByListRow(this.parentNode.parentNode);
			if(obj_Person_talent != ""){
				UI_showUpdatePerson_talentForm(obj_Person_talent);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_talent(searchText)
{

	//Person_talentList = 
	var Person_talentListElem = document.getElementById("Person_talentList");
	
	if(Person_talentListElem)
	{
		var Person_talentDataList = Person_talentListElem.getElementsByTagName("input");
		for(var y=0 in Person_talentDataList)
		{
			if(Person_talentDataList[y])
			{
				
				
				var displayType = "none";
				var Person_talentData = Person_talentDataList[y].value;
				if(!((Person_talentData == "") || (typeof Person_talentData=="undefined")))
				{
				if(search_Person_talent(Person_talentData,searchText))
				{
					displayType = "block";
				}
				Person_talentDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_talent(Person_talentData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_talentData = decodeSpText(Person_talentData.toLowerCase());
	if(Person_talentData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_talent)
{
	if (obj_Person_talent.TblId) {
		var fieldDataId = obj_Person_talent.TblId;
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

function deletePerson_talent(TblId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_talent");
	if(flag){
			DeletePerson_talentPacket(TblId);
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

function Get_Person_talentByListRow(listRowElem)
{
	
	var obj_Person_talent ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_talentData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_talentData = elemlist[z].value;
			}		
		}
		
		if(Person_talentData != "")
		{
		var arrPerson_talentData = Person_talentData.split(";");	
		
		obj_Person_talent = new Person_talent();
		obj_Person_talent.TblId= arrPerson_talentData[0];
		obj_Person_talent.PersonId= arrPerson_talentData[1];
		obj_Person_talent.TalentId= arrPerson_talentData[2];

		
		
		}
		
	}
	
	return obj_Person_talent;
	
	
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
	
			var Elem = document.getElementById("Input_TalentId");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Talents";
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
	
		var obj_Person_talent = new Person_talent();
		
		var TblId= document.getElementById("Input_TblId").value;
		var PersonId= document.getElementById("Input_PersonId").value;
		var TalentId= document.getElementById("Input_TalentId").value;

		
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_TalentId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_talent = new Person_talent();
		obj_Person_talent.TblId= TblId;
		obj_Person_talent.PersonId= PersonId;
		obj_Person_talent.TalentId= TalentId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_talentPacket(dummyId,obj_Person_talent);
		UI_createPerson_talentRow(obj_Person_talent, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_talent = new Person_talent();

		obj_Person_talent.TblId= TblId;
		obj_Person_talent.PersonId= PersonId;
		obj_Person_talent.TalentId= TalentId;

		
		UpdatePerson_talentPacket(obj_Person_talent);
		UI_createPerson_talentRow(obj_Person_talent, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_talent() {
	
	UI_showAddPerson_talentForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_talentForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_talentAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_talentform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_talentForm(obj_Person_talent) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_talentUpdateForm(obj_Person_talent);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_talentform"));
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
function UI_preparePerson_talentUpdateForm(obj_Person_talent)
{
	var arr_hidelist = new Array("Input_TblId","Input_PersonId");
	var arr_showlist = new Array("Input_TalentId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value=obj_Person_talent.TblId;
		document.getElementById("Input_PersonId").value=obj_Person_talent.PersonId;
		document.getElementById("Input_TalentId").value=obj_Person_talent.TalentId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_talentAddForm()
{
	var arr_hidelist = new Array("Input_TblId","Input_PersonId");
	var arr_showlist = new Array("Input_TalentId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_TalentId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_talentToPerson_talentList() {
	var uiPerson_talentList = document.getElementById("Person_talentList");

	var rowElems = uiPerson_talentList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_talentRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_talentRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_talentRowHtmlElem(obj_Person_talent,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_talentImg_"+obj_Person_talent.TblId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_talent/0_small.png";
	else ImgElem.src = "Person_talent/"+obj_Person_talent.TblId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_talent.TblId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_talent.PersonId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_talent.TalentId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_talentdata"+ElemId);
		ElementDataHidden.value = obj_Person_talent.getPerson_talentData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createPerson_talentRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_talentRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_talentRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_talentHtmlElem(obj_Person_talent)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_talent");
		html ="<a href=\"?page=dashboard&TblId="+obj_Person_talent.TblId+"\">"+obj_Person_talent.TblId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_talentRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_talentRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_talentRow(obj_Person_talent, rowType,dummyId) {
	var html = "";
	
	var UiPerson_talentList = document.getElementById("Person_talentList");
	var ClassName = "ListRow";
	var ElemId = "Person_talentListRow_"+obj_Person_talent.TblId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_talentRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_talentRowHtmlElem(obj_Person_talent,ElemId, ClassName);
			UiPerson_talentList.insertBefore(ElemLi, UiPerson_talentList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_talent msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_talentRowHtmlElem(obj_Person_talent,ElemId, ClassName);
			UiPerson_talentList.insertBefore(ElemLi, UiPerson_talentList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_talentRow_"+dummyId);
			var DummyData = document.getElementById("Person_talentdataDummyPerson_talentRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_talentdata"+ElemId);		
				DummyData.value = obj_Person_talent.getPerson_talentData();		
				}
				UI_createTopbarSubPerson_talentHtmlElem(obj_Person_talent);
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
				var ElemLi = UI_createPerson_talentRowHtmlElem(obj_Person_talent,ElemId, ClassName);
				UiPerson_talentList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_talentList");
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
		var profileAvatar = document.getElementById("Person_talentListRow_"+TblId);
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


