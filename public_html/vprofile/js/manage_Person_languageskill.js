//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_languageskill_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_languageskill(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_languageskill(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_languageskill(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_languageskill(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_languageskill(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_languageskill = new Person_languageskill();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_languageskill.LangSkillId= mainPacket[3];
		obj_Person_languageskill.PersonId= mainPacket[4];
		obj_Person_languageskill.Language= mainPacket[5];
		obj_Person_languageskill.SkillType= mainPacket[6];
		obj_Person_languageskill.Grade= mainPacket[7];



		if (resultStatus == 1) {	
			
			UI_createPerson_languageskillRow(obj_Person_languageskill, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_languageskill(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_languageskill = new Person_languageskill();
		
		var resultStatus = mainPacket[0];
		var LangSkillId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_languageskillListRow_"+LangSkillId);
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
				var rowElem = document.getElementById("Person_languageskillListRow_"+LangSkillId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_languageskill(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_languageskill = new Person_languageskill();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_languageskill.LangSkillId= mainPacket[2];
		obj_Person_languageskill.PersonId= mainPacket[3];
		obj_Person_languageskill.Language= mainPacket[4];
		obj_Person_languageskill.SkillType= mainPacket[5];
		obj_Person_languageskill.Grade= mainPacket[6];


		if (resultStatus == 1) {			
			UI_createPerson_languageskillRow(obj_Person_languageskill, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_languageskill_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_languageskillPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_languageskill; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_languageskillPacket(LangSkillId) {
	var deletePacketBody  = LangSkillId;

	var postpacket = createOutgoingPerson_languageskillPacket(202,deletePacketBody);
	Person_languageskill_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_languageskillPacket(obj_Person_languageskill) {
	var savePacketBody  = obj_Person_languageskill.createPerson_languageskillPacket();

	var postpacket = createOutgoingPerson_languageskillPacket(203,savePacketBody);
	Person_languageskill_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_languageskillPacket(dummyId,obj_Person_languageskill) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_languageskill.createPerson_languageskillPacket();

	var postpacket = createOutgoingPerson_languageskillPacket(201,savePacketBody);
	Person_languageskill_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_languageskillPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_languageskillPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_languageskill = document.getElementById("btnaddPerson_languageskill");
	if(addPerson_languageskill){
	addPerson_languageskill.addEventListener('mousedown', Event_mousedown_addPerson_languageskill, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_languageskillform = document.getElementById("popPerson_languageskillform");
	var inputElems = popPerson_languageskillform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_languageskillList = document.getElementById("Person_languageskillList");
	var liElems = UiPerson_languageskillList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_languageskillRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_languageskillRow, false);
		
	}
	
	var UiPerson_languageskillListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_languageskillListDeletebtns.length; z++) {
			UiPerson_languageskillListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_languageskillRowBtn, false);			
		
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
	UI_search_Person_languageskill(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_languageskillRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_languageskill = Get_Person_languageskillByListRow(this.parentNode.parentNode);
			if(obj_Person_languageskill != ""){
				deletePerson_languageskill(obj_Person_languageskill.LangSkillId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_languageskill = Get_Person_languageskillByListRow(this.parentNode.parentNode);
			if(obj_Person_languageskill != ""){
				UI_showUpdatePerson_languageskillForm(obj_Person_languageskill);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_languageskill(searchText)
{

	//Person_languageskillList = 
	var Person_languageskillListElem = document.getElementById("Person_languageskillList");
	
	if(Person_languageskillListElem)
	{
		var Person_languageskillDataList = Person_languageskillListElem.getElementsByTagName("input");
		for(var y=0 in Person_languageskillDataList)
		{
			if(Person_languageskillDataList[y])
			{
				
				
				var displayType = "none";
				var Person_languageskillData = Person_languageskillDataList[y].value;
				if(!((Person_languageskillData == "") || (typeof Person_languageskillData=="undefined")))
				{
				if(search_Person_languageskill(Person_languageskillData,searchText))
				{
					displayType = "block";
				}
				Person_languageskillDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_languageskill(Person_languageskillData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_languageskillData = decodeSpText(Person_languageskillData.toLowerCase());
	if(Person_languageskillData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_languageskill)
{
	if (obj_Person_languageskill.LangSkillId) {
		var fieldDataId = obj_Person_languageskill.LangSkillId;
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

function deletePerson_languageskill(LangSkillId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_languageskill");
	if(flag){
			DeletePerson_languageskillPacket(LangSkillId);
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

function Get_Person_languageskillByListRow(listRowElem)
{
	
	var obj_Person_languageskill ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_languageskillData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_languageskillData = elemlist[z].value;
			}		
		}
		
		if(Person_languageskillData != "")
		{
		var arrPerson_languageskillData = Person_languageskillData.split(";");	
		
		obj_Person_languageskill = new Person_languageskill();
		obj_Person_languageskill.LangSkillId= arrPerson_languageskillData[0];
		obj_Person_languageskill.PersonId= arrPerson_languageskillData[1];
		obj_Person_languageskill.Language= arrPerson_languageskillData[2];
		obj_Person_languageskill.SkillType= arrPerson_languageskillData[3];
		obj_Person_languageskill.Grade= arrPerson_languageskillData[4];

		
		
		}
		
	}
	
	return obj_Person_languageskill;
	
	
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
	
var Elem = document.getElementById("Input_Language");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Language";
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
	
		var obj_Person_languageskill = new Person_languageskill();
		
		var LangSkillId= document.getElementById("Input_LangSkillId").value;
		var PersonId= document.getElementById("Input_PersonId").value;
		var Language= document.getElementById("Input_Language").value;
		var SkillType= document.getElementById("Input_SkillType").value;
		var Grade= document.getElementById("Input_Grade").value;

		
		document.getElementById("Input_LangSkillId").value="";
	//	document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_Language").value="";
		document.getElementById("Input_SkillType").value="";
		document.getElementById("Input_Grade").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_languageskill = new Person_languageskill();
		obj_Person_languageskill.LangSkillId= LangSkillId;
		obj_Person_languageskill.PersonId= PersonId;
		obj_Person_languageskill.Language= Language;
		obj_Person_languageskill.SkillType= SkillType;
		obj_Person_languageskill.Grade= Grade;

		
		var dummyId = CreateDummyNumber();
		AddPerson_languageskillPacket(dummyId,obj_Person_languageskill);
		UI_createPerson_languageskillRow(obj_Person_languageskill, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_languageskill = new Person_languageskill();

		obj_Person_languageskill.LangSkillId= LangSkillId;
		obj_Person_languageskill.PersonId= PersonId;
		obj_Person_languageskill.Language= Language;
		obj_Person_languageskill.SkillType= SkillType;
		obj_Person_languageskill.Grade= Grade;

		
		UpdatePerson_languageskillPacket(obj_Person_languageskill);
		UI_createPerson_languageskillRow(obj_Person_languageskill, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_languageskill() {
	
	UI_showAddPerson_languageskillForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_languageskillForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_languageskillAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_languageskillform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_languageskillForm(obj_Person_languageskill) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_languageskillUpdateForm(obj_Person_languageskill);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_languageskillform"));
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
function UI_preparePerson_languageskillUpdateForm(obj_Person_languageskill)
{
	var arr_hidelist = new Array("Input_LangSkillId","Input_PersonId");
	var arr_showlist = new Array("Input_Language","Input_SkillType","Input_Grade");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_LangSkillId").value=obj_Person_languageskill.LangSkillId;
		document.getElementById("Input_PersonId").value=obj_Person_languageskill.PersonId;
		document.getElementById("Input_Language").value=obj_Person_languageskill.Language;
		document.getElementById("Input_SkillType").value=obj_Person_languageskill.SkillType;
		document.getElementById("Input_Grade").value=obj_Person_languageskill.Grade;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_languageskillAddForm()
{
	var arr_hidelist = new Array("Input_LangSkillId","Input_PersonId");
	var arr_showlist = new Array("Input_Language","Input_SkillType","Input_Grade");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_LangSkillId").value="";
		document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_Language").value="";
		document.getElementById("Input_SkillType").value="";
		document.getElementById("Input_Grade").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_languageskillToPerson_languageskillList() {
	var uiPerson_languageskillList = document.getElementById("Person_languageskillList");

	var rowElems = uiPerson_languageskillList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_languageskillRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_languageskillRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_languageskillRowHtmlElem(obj_Person_languageskill,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_languageskillImg_"+obj_Person_languageskill.LangSkillId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_languageskill/0_small.png";
	else ImgElem.src = "Person_languageskill/"+obj_Person_languageskill.LangSkillId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_languageskill.LangSkillId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_languageskill.PersonId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_languageskill.Language;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_languageskill.SkillType;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_languageskill.Grade;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_languageskilldata"+ElemId);
		ElementDataHidden.value = obj_Person_languageskill.getPerson_languageskillData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);

		
		ElemLi= UI_createPerson_languageskillRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_languageskillRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_languageskillRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_languageskillHtmlElem(obj_Person_languageskill)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_languageskill");
		html ="<a href=\"?page=dashboard&LangSkillId="+obj_Person_languageskill.LangSkillId+"\">"+obj_Person_languageskill.LangSkillId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_languageskillRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_languageskillRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_languageskillRow(obj_Person_languageskill, rowType,dummyId) {
	var html = "";
	
	var UiPerson_languageskillList = document.getElementById("Person_languageskillList");
	var ClassName = "ListRow";
	var ElemId = "Person_languageskillListRow_"+obj_Person_languageskill.LangSkillId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_languageskillRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_languageskillRowHtmlElem(obj_Person_languageskill,ElemId, ClassName);
			UiPerson_languageskillList.insertBefore(ElemLi, UiPerson_languageskillList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_languageskill msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_languageskillRowHtmlElem(obj_Person_languageskill,ElemId, ClassName);
			UiPerson_languageskillList.insertBefore(ElemLi, UiPerson_languageskillList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_languageskillRow_"+dummyId);
			var DummyData = document.getElementById("Person_languageskilldataDummyPerson_languageskillRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_languageskilldata"+ElemId);		
				DummyData.value = obj_Person_languageskill.getPerson_languageskillData();		
				}
				UI_createTopbarSubPerson_languageskillHtmlElem(obj_Person_languageskill);
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
				var ElemLi = UI_createPerson_languageskillRowHtmlElem(obj_Person_languageskill,ElemId, ClassName);
				UiPerson_languageskillList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_languageskillList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, LangSkillId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_languageskillListRow_"+LangSkillId);
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


