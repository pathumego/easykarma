//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_alresult_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_alresult(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_alresult(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_alresult(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_alresult(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_alresult(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_alresult = new Person_alresult();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_alresult.ALResultId= mainPacket[3];
		obj_Person_alresult.SubjectId= mainPacket[4];
		obj_Person_alresult.SchoolId= mainPacket[5];
		obj_Person_alresult.Grade= mainPacket[6];
		obj_Person_alresult.Language= mainPacket[7];
		obj_Person_alresult.DateTime= mainPacket[8];
		obj_Person_alresult.PersonId= mainPacket[9];



		if (resultStatus == 1) {	
			
			UI_createPerson_alresultRow(obj_Person_alresult, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_alresult(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_alresult = new Person_alresult();
		
		var resultStatus = mainPacket[0];
		var ALResultId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_alresultListRow_"+ALResultId);
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
				var rowElem = document.getElementById("Person_alresultListRow_"+ALResultId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_alresult(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_alresult = new Person_alresult();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_alresult.ALResultId= mainPacket[2];
		obj_Person_alresult.SubjectId= mainPacket[3];
		obj_Person_alresult.SchoolId= mainPacket[4];
		obj_Person_alresult.Grade= mainPacket[5];
		obj_Person_alresult.Language= mainPacket[6];
		obj_Person_alresult.DateTime= mainPacket[7];
		obj_Person_alresult.PersonId= mainPacket[8];


		if (resultStatus == 1) {			
			UI_createPerson_alresultRow(obj_Person_alresult, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_alresult_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_alresultPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_alresult; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_alresultPacket(ALResultId) {
	var deletePacketBody  = ALResultId;

	var postpacket = createOutgoingPerson_alresultPacket(202,deletePacketBody);
	Person_alresult_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_alresultPacket(obj_Person_alresult) {
	var savePacketBody  = obj_Person_alresult.createPerson_alresultPacket();

	var postpacket = createOutgoingPerson_alresultPacket(203,savePacketBody);
	Person_alresult_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_alresultPacket(dummyId,obj_Person_alresult) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_alresult.createPerson_alresultPacket();

	var postpacket = createOutgoingPerson_alresultPacket(201,savePacketBody);
	Person_alresult_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_alresultPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_alresultPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_alresult = document.getElementById("btnaddPerson_alresult");
	if(addPerson_alresult){
	addPerson_alresult.addEventListener('mousedown', Event_mousedown_addPerson_alresult, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_alresultform = document.getElementById("popPerson_alresultform");
	var inputElems = popPerson_alresultform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_alresultList = document.getElementById("Person_alresultList");
	var liElems = UiPerson_alresultList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_alresultRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_alresultRow, false);
		
	}
	
	var UiPerson_alresultListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_alresultListDeletebtns.length; z++) {
			UiPerson_alresultListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_alresultRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_SubjectId","SubjectName",3);
	
	global_autocomplete_elem[1] = new AutoComplete();
	global_autocomplete_elem[1].Open(1,"Input_SchoolId","Name",17); //tbl_organization
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
	UI_search_Person_alresult(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_alresultRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_alresult = Get_Person_alresultByListRow(this.parentNode.parentNode);
			if(obj_Person_alresult != ""){
				deletePerson_alresult(obj_Person_alresult.ALResultId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_alresult = Get_Person_alresultByListRow(this.parentNode.parentNode);
			if(obj_Person_alresult != ""){
				UI_showUpdatePerson_alresultForm(obj_Person_alresult);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_alresult(searchText)
{

	//Person_alresultList = 
	var Person_alresultListElem = document.getElementById("Person_alresultList");
	
	if(Person_alresultListElem)
	{
		var Person_alresultDataList = Person_alresultListElem.getElementsByTagName("input");
		for(var y=0 in Person_alresultDataList)
		{
			if(Person_alresultDataList[y])
			{
				
				
				var displayType = "none";
				var Person_alresultData = Person_alresultDataList[y].value;
				if(!((Person_alresultData == "") || (typeof Person_alresultData=="undefined")))
				{
				if(search_Person_alresult(Person_alresultData,searchText))
				{
					displayType = "block";
				}
				Person_alresultDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_alresult(Person_alresultData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_alresultData = decodeSpText(Person_alresultData.toLowerCase());
	if(Person_alresultData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_alresult)
{
	if (obj_Person_alresult.ALResultId) {
		var fieldDataId = obj_Person_alresult.ALResultId;
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

function deletePerson_alresult(ALResultId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_alresult");
	if(flag){
			DeletePerson_alresultPacket(ALResultId);
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

function Get_Person_alresultByListRow(listRowElem)
{
	
	var obj_Person_alresult ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_alresultData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_alresultData = elemlist[z].value;
			}		
		}
		
		if(Person_alresultData != "")
		{
		var arrPerson_alresultData = Person_alresultData.split(";");	
		
		obj_Person_alresult = new Person_alresult();
		obj_Person_alresult.ALResultId= arrPerson_alresultData[0];
		obj_Person_alresult.SubjectId= arrPerson_alresultData[1];
		obj_Person_alresult.SchoolId= arrPerson_alresultData[2];
		obj_Person_alresult.Grade= arrPerson_alresultData[3];
		obj_Person_alresult.Language= arrPerson_alresultData[4];
		obj_Person_alresult.DateTime= arrPerson_alresultData[5];
		obj_Person_alresult.PersonId= arrPerson_alresultData[6];

		
		
		}
		
	}
	
	return obj_Person_alresult;
	
	
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
	
				var Elem = document.getElementById("Input_Grade");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the grade";
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
	
		var obj_Person_alresult = new Person_alresult();
		
		var ALResultId= document.getElementById("Input_ALResultId").value;
		var SubjectId= document.getElementById("Input_SubjectId").value;
		var SchoolId= document.getElementById("Input_SchoolId").value;
		var Grade= document.getElementById("Input_Grade").value;
		var Language= document.getElementById("Input_Language").value;
		var DateTime= document.getElementById("Input_DateTime").value;
		var PersonId= document.getElementById("Input_PersonId").value;

		
		document.getElementById("Input_ALResultId").value="";
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SchoolId").value="";
		document.getElementById("Input_Grade").value="";
		document.getElementById("Input_Language").value="";
		document.getElementById("Input_DateTime").value="";
		document.getElementById("Input_PersonId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_alresult = new Person_alresult();
		obj_Person_alresult.ALResultId= ALResultId;
		obj_Person_alresult.SubjectId= SubjectId;
		obj_Person_alresult.SchoolId= SchoolId;
		obj_Person_alresult.Grade= Grade;
		obj_Person_alresult.Language= Language;
		obj_Person_alresult.DateTime= DateTime;
		obj_Person_alresult.PersonId= PersonId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_alresultPacket(dummyId,obj_Person_alresult);
		UI_createPerson_alresultRow(obj_Person_alresult, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_alresult = new Person_alresult();

		obj_Person_alresult.ALResultId= ALResultId;
		obj_Person_alresult.SubjectId= SubjectId;
		obj_Person_alresult.SchoolId= SchoolId;
		obj_Person_alresult.Grade= Grade;
		obj_Person_alresult.Language= Language;
		obj_Person_alresult.DateTime= DateTime;
		obj_Person_alresult.PersonId= PersonId;

		
		UpdatePerson_alresultPacket(obj_Person_alresult);
		UI_createPerson_alresultRow(obj_Person_alresult, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_alresult() {
	
	UI_showAddPerson_alresultForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_alresultForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_alresultAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_alresultform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_alresultForm(obj_Person_alresult) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_alresultUpdateForm(obj_Person_alresult);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_alresultform"));
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
function UI_preparePerson_alresultUpdateForm(obj_Person_alresult)
{
	var arr_hidelist = new Array("Input_ALResultId","Input_PersonId");
	var arr_showlist = new Array("Input_Grade","Input_Language","Input_DateTime","Input_SubjectId","Input_SchoolId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ALResultId").value=obj_Person_alresult.ALResultId;
		document.getElementById("Input_SubjectId").value=obj_Person_alresult.SubjectId;
		
		var drp_subjects = document.getElementById("Input_SubjectId");
		for (var i=0; i < drp_subjects.options.length; i++) {
		if (drp_subjects.options[i].value == obj_Person_alresult.SubjectId) {
			drp_subjects.options[i].selected = true;
			}
		}
		
		
		document.getElementById("Input_SchoolId").value=obj_Person_alresult.SchoolId;
		document.getElementById("Input_Grade").value=obj_Person_alresult.Grade;
		document.getElementById("Input_Language").value=obj_Person_alresult.Language;
		document.getElementById("Input_DateTime").value=obj_Person_alresult.DateTime;
		document.getElementById("Input_PersonId").value=obj_Person_alresult.PersonId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_alresultAddForm()
{
	var arr_hidelist = new Array("Input_ALResultId","Input_PersonId","Input_SchoolId");
	var arr_showlist = new Array("Input_Grade","Input_Language","Input_DateTime","Input_SubjectId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ALResultId").value="";
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SchoolId").value="";
		document.getElementById("Input_Grade").value="";
		document.getElementById("Input_Language").value="";
		document.getElementById("Input_DateTime").value="";
		document.getElementById("Input_PersonId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_alresultToPerson_alresultList() {
	var uiPerson_alresultList = document.getElementById("Person_alresultList");

	var rowElems = uiPerson_alresultList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_alresultRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_alresultRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_alresultRowHtmlElem(obj_Person_alresult,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_alresultImg_"+obj_Person_alresult.ALResultId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_alresult/0_small.png";
	else ImgElem.src = "Person_alresult/"+obj_Person_alresult.ALResultId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_alresult.ALResultId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_alresult.SubjectId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_alresult.SchoolId;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_alresult.Grade;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_alresult.Language;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Person_alresult.DateTime;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Person_alresult.PersonId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_alresultdata"+ElemId);
		ElementDataHidden.value = obj_Person_alresult.getPerson_alresultData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);
		ElemLi.appendChild(ElemDataRow8);

		
		ElemLi= UI_createPerson_alresultRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_alresultRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_alresultRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_alresultHtmlElem(obj_Person_alresult)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_alresult");
		html ="<a href=\"?page=dashboard&ALResultId="+obj_Person_alresult.ALResultId+"\">"+obj_Person_alresult.ALResultId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_alresultRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_alresultRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_alresultRow(obj_Person_alresult, rowType,dummyId) {
	var html = "";
	
	var UiPerson_alresultList = document.getElementById("Person_alresultList");
	var ClassName = "ListRow";
	var ElemId = "Person_alresultListRow_"+obj_Person_alresult.ALResultId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_alresultRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_alresultRowHtmlElem(obj_Person_alresult,ElemId, ClassName);
			UiPerson_alresultList.insertBefore(ElemLi, UiPerson_alresultList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_alresult msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_alresultRowHtmlElem(obj_Person_alresult,ElemId, ClassName);
			UiPerson_alresultList.insertBefore(ElemLi, UiPerson_alresultList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_alresultRow_"+dummyId);
			var DummyData = document.getElementById("Person_alresultdataDummyPerson_alresultRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_alresultdata"+ElemId);		
				DummyData.value = obj_Person_alresult.getPerson_alresultData();		
				}
				UI_createTopbarSubPerson_alresultHtmlElem(obj_Person_alresult);
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
				var ElemLi = UI_createPerson_alresultRowHtmlElem(obj_Person_alresult,ElemId, ClassName);
				UiPerson_alresultList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_alresultList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, ALResultId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_alresultListRow_"+ALResultId);
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


