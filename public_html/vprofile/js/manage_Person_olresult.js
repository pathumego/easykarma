//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_olresult_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_olresult(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_olresult(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_olresult(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_olresult(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_olresult(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_olresult = new Person_olresult();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_olresult.OLResultId= mainPacket[3];
		obj_Person_olresult.SubjectId= mainPacket[4];
		obj_Person_olresult.SchoolId= mainPacket[5];
		obj_Person_olresult.Grade= mainPacket[6];
		obj_Person_olresult.Language= mainPacket[7];
		obj_Person_olresult.DateTime= mainPacket[8];
		obj_Person_olresult.PersonId= mainPacket[9];



		if (resultStatus == 1) {	
			
			UI_createPerson_olresultRow(obj_Person_olresult, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_olresult(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_olresult = new Person_olresult();
		
		var resultStatus = mainPacket[0];
		var OLResultId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_olresultListRow_"+OLResultId);
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
				var rowElem = document.getElementById("Person_olresultListRow_"+OLResultId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_olresult(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_olresult = new Person_olresult();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_olresult.OLResultId= mainPacket[2];
		obj_Person_olresult.SubjectId= mainPacket[3];
		obj_Person_olresult.SchoolId= mainPacket[4];
		obj_Person_olresult.Grade= mainPacket[5];
		obj_Person_olresult.Language= mainPacket[6];
		obj_Person_olresult.DateTime= mainPacket[7];
		obj_Person_olresult.PersonId= mainPacket[8];


		if (resultStatus == 1) {			
			UI_createPerson_olresultRow(obj_Person_olresult, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_olresult_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_olresultPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_olresult; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_olresultPacket(OLResultId) {
	var deletePacketBody  = OLResultId;

	var postpacket = createOutgoingPerson_olresultPacket(202,deletePacketBody);
	Person_olresult_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_olresultPacket(obj_Person_olresult) {
	var savePacketBody  = obj_Person_olresult.createPerson_olresultPacket();

	var postpacket = createOutgoingPerson_olresultPacket(203,savePacketBody);
	Person_olresult_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_olresultPacket(dummyId,obj_Person_olresult) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_olresult.createPerson_olresultPacket();

	var postpacket = createOutgoingPerson_olresultPacket(201,savePacketBody);
	Person_olresult_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_olresultPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_olresultPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_olresult = document.getElementById("btnaddPerson_olresult");
	if(addPerson_olresult){
	addPerson_olresult.addEventListener('mousedown', Event_mousedown_addPerson_olresult, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	if(form_addbtn){
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);
	}

	var popPerson_olresultform = document.getElementById("popPerson_olresultform");
	var inputElems = popPerson_olresultform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_olresultList = document.getElementById("Person_olresultList");
	var liElems = UiPerson_olresultList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_olresultRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_olresultRow, false);
		
	}
	
	var UiPerson_olresultListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_olresultListDeletebtns.length; z++) {
			UiPerson_olresultListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_olresultRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_SubjectId","SubjectName",16);
	
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
	UI_search_Person_olresult(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_olresultRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_olresult = Get_Person_olresultByListRow(this.parentNode.parentNode);
			if(obj_Person_olresult != ""){
				deletePerson_olresult(obj_Person_olresult.OLResultId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_olresult = Get_Person_olresultByListRow(this.parentNode.parentNode);
			if(obj_Person_olresult != ""){
				UI_showUpdatePerson_olresultForm(obj_Person_olresult);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_olresult(searchText)
{

	//Person_olresultList = 
	var Person_olresultListElem = document.getElementById("Person_olresultList");
	
	if(Person_olresultListElem)
	{
		var Person_olresultDataList = Person_olresultListElem.getElementsByTagName("input");
		for(var y=0 in Person_olresultDataList)
		{
			if(Person_olresultDataList[y])
			{
				
				
				var displayType = "none";
				var Person_olresultData = Person_olresultDataList[y].value;
				if(!((Person_olresultData == "") || (typeof Person_olresultData=="undefined")))
				{
				if(search_Person_olresult(Person_olresultData,searchText))
				{
					displayType = "block";
				}
				Person_olresultDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_olresult(Person_olresultData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_olresultData = decodeSpText(Person_olresultData.toLowerCase());
	if(Person_olresultData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_olresult)
{
	if (obj_Person_olresult.OLResultId) {
		var fieldDataId = obj_Person_olresult.OLResultId;
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

function deletePerson_olresult(OLResultId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_olresult");
	if(flag){
			DeletePerson_olresultPacket(OLResultId);
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

function Get_Person_olresultByListRow(listRowElem)
{
	
	var obj_Person_olresult ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_olresultData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_olresultData = elemlist[z].value;
			}		
		}
		
		if(Person_olresultData != "")
		{
		var arrPerson_olresultData = Person_olresultData.split(";");	
		
		obj_Person_olresult = new Person_olresult();
		obj_Person_olresult.OLResultId= arrPerson_olresultData[0];
		obj_Person_olresult.SubjectId= arrPerson_olresultData[1];
		obj_Person_olresult.SchoolId= arrPerson_olresultData[2];
		obj_Person_olresult.Grade= arrPerson_olresultData[3];
		obj_Person_olresult.Language= arrPerson_olresultData[4];
		obj_Person_olresult.DateTime= arrPerson_olresultData[5];
		obj_Person_olresult.PersonId= arrPerson_olresultData[6];

		
		
		}
		
	}
	
	return obj_Person_olresult;
	
	
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
	/*
	var iserror =false;
		var errorMsg = "";
	

		var Elem = document.getElementById("Input_Person_olresultPrice");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Person_olresult price";
					Elem.focus();
				}				
				else if(isNaN(Elem.value))
				{
					Elem.value="";
					iserror =true;
					error = "Invalid price";	
					Elem.focus();		
				}
	
			}
			
		    Elem = document.getElementById("Input_Person_olresultName");
			if(Elem)
			{
				if(Elem.value =="")
				{
				Elem.focus();
				iserror =true;
				error = "Please enter Person_olresult name";	
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
	*/
	
	return false;
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_form_addbtn(event) {
	

	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
	
		var obj_Person_olresult = new Person_olresult();
		
		var OLResultId= document.getElementById("Input_OLResultId").value;
		var SubjectId= document.getElementById("Input_SubjectId").value;
		var SchoolId= document.getElementById("Input_SchoolId").value;
		var Grade= document.getElementById("Input_Grade").value;
		var Language= document.getElementById("Input_Language").value;
		var DateTime= document.getElementById("Input_DateTime").value;
		var PersonId= document.getElementById("Input_PersonId").value;

		
		document.getElementById("Input_OLResultId").value="";
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SchoolId").value="";
		document.getElementById("Input_Grade").value="";
		document.getElementById("Input_Language").value="";
		document.getElementById("Input_DateTime").value="";
		document.getElementById("Input_PersonId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_olresult = new Person_olresult();
		obj_Person_olresult.OLResultId= OLResultId;
		obj_Person_olresult.SubjectId= SubjectId;
		obj_Person_olresult.SchoolId= SchoolId;
		obj_Person_olresult.Grade= Grade;
		obj_Person_olresult.Language= Language;
		obj_Person_olresult.DateTime= DateTime;
		obj_Person_olresult.PersonId= PersonId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_olresultPacket(dummyId,obj_Person_olresult);
		UI_createPerson_olresultRow(obj_Person_olresult, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_olresult = new Person_olresult();

		obj_Person_olresult.OLResultId= OLResultId;
		obj_Person_olresult.SubjectId= SubjectId;
		obj_Person_olresult.SchoolId= SchoolId;
		obj_Person_olresult.Grade= Grade;
		obj_Person_olresult.Language= Language;
		obj_Person_olresult.DateTime= DateTime;
		obj_Person_olresult.PersonId= PersonId;

		
		UpdatePerson_olresultPacket(obj_Person_olresult);
		UI_createPerson_olresultRow(obj_Person_olresult, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_olresult() {
	
	UI_showAddPerson_olresultForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_olresultForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_olresultAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_olresultform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_olresultForm(obj_Person_olresult) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_olresultUpdateForm(obj_Person_olresult);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_olresultform"));
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
function UI_preparePerson_olresultUpdateForm(obj_Person_olresult)
{
	var arr_hidelist = new Array("Input_OLResultId","Input_PersonId");
	var arr_showlist = new Array("Input_SubjectId","Input_SchoolId","Input_Grade","Input_Language","Input_DateTime");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OLResultId").value=obj_Person_olresult.OLResultId;
		document.getElementById("Input_SubjectId").value=obj_Person_olresult.SubjectId;
		document.getElementById("Input_SchoolId").value=obj_Person_olresult.SchoolId;
		document.getElementById("Input_Grade").value=obj_Person_olresult.Grade;
		document.getElementById("Input_Language").value=obj_Person_olresult.Language;
		document.getElementById("Input_DateTime").value=obj_Person_olresult.DateTime;
		document.getElementById("Input_PersonId").value=obj_Person_olresult.PersonId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_olresultAddForm()
{
	var arr_hidelist = new Array("Input_OLResultId","Input_PersonId");
	var arr_showlist = new Array("Input_SubjectId","Input_SchoolId","Input_Grade","Input_Language","Input_DateTime");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OLResultId").value="";
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

function UI_addPerson_olresultToPerson_olresultList() {
	var uiPerson_olresultList = document.getElementById("Person_olresultList");

	var rowElems = uiPerson_olresultList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_olresultRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_olresultRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_olresultRowHtmlElem(obj_Person_olresult,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_olresultImg_"+obj_Person_olresult.OLResultId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_olresult/0_small.png";
	else ImgElem.src = "Person_olresult/"+obj_Person_olresult.OLResultId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_olresult.OLResultId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_olresult.SubjectId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_olresult.SchoolId;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_olresult.Grade;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_olresult.Language;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Person_olresult.DateTime;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Person_olresult.PersonId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_olresultdata"+ElemId);
		ElementDataHidden.value = obj_Person_olresult.getPerson_olresultData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);
		ElemLi.appendChild(ElemDataRow8);

		
		ElemLi= UI_createPerson_olresultRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_olresultRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_olresultRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_olresultHtmlElem(obj_Person_olresult)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_olresult");
		html ="<a href=\"?page=dashboard&OLResultId="+obj_Person_olresult.OLResultId+"\">"+obj_Person_olresult.OLResultId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_olresultRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_olresultRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_olresultRow(obj_Person_olresult, rowType,dummyId) {
	var html = "";
	
	var UiPerson_olresultList = document.getElementById("Person_olresultList");
	var ClassName = "ListRow";
	var ElemId = "Person_olresultListRow_"+obj_Person_olresult.OLResultId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_olresultRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_olresultRowHtmlElem(obj_Person_olresult,ElemId, ClassName);
			UiPerson_olresultList.insertBefore(ElemLi, UiPerson_olresultList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_olresult msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_olresultRowHtmlElem(obj_Person_olresult,ElemId, ClassName);
			UiPerson_olresultList.insertBefore(ElemLi, UiPerson_olresultList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_olresultRow_"+dummyId);
			var DummyData = document.getElementById("Person_olresultdataDummyPerson_olresultRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_olresultdata"+ElemId);		
				DummyData.value = obj_Person_olresult.getPerson_olresultData();		
				}
				UI_createTopbarSubPerson_olresultHtmlElem(obj_Person_olresult);
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
				var ElemLi = UI_createPerson_olresultRowHtmlElem(obj_Person_olresult,ElemId, ClassName);
				UiPerson_olresultList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_olresultList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, OLResultId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_olresultListRow_"+OLResultId);
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


