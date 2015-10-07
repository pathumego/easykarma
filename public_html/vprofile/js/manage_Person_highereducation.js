//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_highereducation_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_highereducation(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_highereducation(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_highereducation(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_highereducation(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_highereducation(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_highereducation = new Person_highereducation();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_highereducation.ResultId= mainPacket[3];
		obj_Person_highereducation.SubjectId= mainPacket[4];
		obj_Person_highereducation.InstituteId= mainPacket[5];
		obj_Person_highereducation.Grade= mainPacket[6];
		obj_Person_highereducation.Language= mainPacket[7];
		obj_Person_highereducation.DateTime= mainPacket[8];
		obj_Person_highereducation.PersonId= mainPacket[9];
		obj_Person_highereducation.Level= mainPacket[10];



		if (resultStatus == 1) {	
			
			UI_createPerson_highereducationRow(obj_Person_highereducation, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_highereducation(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_highereducation = new Person_highereducation();
		
		var resultStatus = mainPacket[0];
		var ResultId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_highereducationListRow_"+ResultId);
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
				var rowElem = document.getElementById("Person_highereducationListRow_"+ResultId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_highereducation(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_highereducation = new Person_highereducation();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_highereducation.ResultId= mainPacket[2];
		obj_Person_highereducation.SubjectId= mainPacket[3];
		obj_Person_highereducation.InstituteId= mainPacket[4];
		obj_Person_highereducation.Grade= mainPacket[5];
		obj_Person_highereducation.Language= mainPacket[6];
		obj_Person_highereducation.DateTime= mainPacket[7];
		obj_Person_highereducation.PersonId= mainPacket[8];
		obj_Person_highereducation.Level= mainPacket[9];


		if (resultStatus == 1) {			
			UI_createPerson_highereducationRow(obj_Person_highereducation, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_highereducation_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_highereducationPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_highereducation; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_highereducationPacket(ResultId) {
	var deletePacketBody  = ResultId;

	var postpacket = createOutgoingPerson_highereducationPacket(202,deletePacketBody);
	Person_highereducation_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_highereducationPacket(obj_Person_highereducation) {
	var savePacketBody  = obj_Person_highereducation.createPerson_highereducationPacket();

	var postpacket = createOutgoingPerson_highereducationPacket(203,savePacketBody);
	Person_highereducation_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_highereducationPacket(dummyId,obj_Person_highereducation) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_highereducation.createPerson_highereducationPacket();

	var postpacket = createOutgoingPerson_highereducationPacket(201,savePacketBody);
	Person_highereducation_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_highereducationPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_highereducationPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_highereducation = document.getElementById("btnaddPerson_highereducation");
	if(addPerson_highereducation){
	addPerson_highereducation.addEventListener('mousedown', Event_mousedown_addPerson_highereducation, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_highereducationform = document.getElementById("popPerson_highereducationform");
	var inputElems = popPerson_highereducationform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_highereducationList = document.getElementById("Person_highereducationList");
	var liElems = UiPerson_highereducationList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_highereducationRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_highereducationRow, false);
		
	}
	
	var UiPerson_highereducationListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_highereducationListDeletebtns.length; z++) {
			UiPerson_highereducationListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_highereducationRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_SubjectId","SubjectName",12);

	global_autocomplete_elem[1] = new AutoComplete();
	global_autocomplete_elem[1].Open(1,"Input_InstituteId","Name",17);	
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
	UI_search_Person_highereducation(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_highereducationRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_highereducation = Get_Person_highereducationByListRow(this.parentNode.parentNode);
			if(obj_Person_highereducation != ""){
				deletePerson_highereducation(obj_Person_highereducation.ResultId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_highereducation = Get_Person_highereducationByListRow(this.parentNode.parentNode);
			if(obj_Person_highereducation != ""){
				UI_showUpdatePerson_highereducationForm(obj_Person_highereducation);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_highereducation(searchText)
{

	//Person_highereducationList = 
	var Person_highereducationListElem = document.getElementById("Person_highereducationList");
	
	if(Person_highereducationListElem)
	{
		var Person_highereducationDataList = Person_highereducationListElem.getElementsByTagName("input");
		for(var y=0 in Person_highereducationDataList)
		{
			if(Person_highereducationDataList[y])
			{
				
				
				var displayType = "none";
				var Person_highereducationData = Person_highereducationDataList[y].value;
				if(!((Person_highereducationData == "") || (typeof Person_highereducationData=="undefined")))
				{
				if(search_Person_highereducation(Person_highereducationData,searchText))
				{
					displayType = "block";
				}
				Person_highereducationDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_highereducation(Person_highereducationData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_highereducationData = decodeSpText(Person_highereducationData.toLowerCase());
	if(Person_highereducationData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_highereducation)
{
	if (obj_Person_highereducation.ResultId) {
		var fieldDataId = obj_Person_highereducation.ResultId;
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

function deletePerson_highereducation(ResultId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_highereducation");
	if(flag){
			DeletePerson_highereducationPacket(ResultId);
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

function Get_Person_highereducationByListRow(listRowElem)
{
	
	var obj_Person_highereducation ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_highereducationData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_highereducationData = elemlist[z].value;
			}		
		}
		
		if(Person_highereducationData != "")
		{
		var arrPerson_highereducationData = Person_highereducationData.split(";");	
		
		obj_Person_highereducation = new Person_highereducation();
		obj_Person_highereducation.ResultId= arrPerson_highereducationData[0];
		obj_Person_highereducation.SubjectId= arrPerson_highereducationData[1];
		obj_Person_highereducation.InstituteId= arrPerson_highereducationData[2];
		obj_Person_highereducation.Grade= arrPerson_highereducationData[3];
		obj_Person_highereducation.Language= arrPerson_highereducationData[4];
		obj_Person_highereducation.DateTime= arrPerson_highereducationData[5];
		obj_Person_highereducation.PersonId= arrPerson_highereducationData[6];
		obj_Person_highereducation.Level= arrPerson_highereducationData[7];

		
		
		}
		
	}
	
	return obj_Person_highereducation;
	
	
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
					error = "please Enter the Grade";
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
	
		var obj_Person_highereducation = new Person_highereducation();
		
		var ResultId= document.getElementById("Input_ResultId").value;
		var SubjectId= document.getElementById("Input_SubjectId").value;
		var InstituteId= document.getElementById("Input_InstituteId").value;
		var Grade= document.getElementById("Input_Grade").value;
		var Language= document.getElementById("Input_Language").value;
		var DateTime= document.getElementById("Input_DateTime").value;
		var PersonId= document.getElementById("Input_PersonId").value;
		var Level= document.getElementById("Input_Level").value;

		
		document.getElementById("Input_ResultId").value="";
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_InstituteId").value="";
		document.getElementById("Input_Grade").value="";
		document.getElementById("Input_Language").value="";
		document.getElementById("Input_DateTime").value="";
		document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_Level").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_highereducation = new Person_highereducation();
		obj_Person_highereducation.ResultId= ResultId;
		obj_Person_highereducation.SubjectId= SubjectId;
		obj_Person_highereducation.InstituteId= InstituteId;
		obj_Person_highereducation.Grade= Grade;
		obj_Person_highereducation.Language= Language;
		obj_Person_highereducation.DateTime= DateTime;
		obj_Person_highereducation.PersonId= PersonId;
		obj_Person_highereducation.Level= Level;

		
		var dummyId = CreateDummyNumber();
		AddPerson_highereducationPacket(dummyId,obj_Person_highereducation);
		UI_createPerson_highereducationRow(obj_Person_highereducation, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_highereducation = new Person_highereducation();

		obj_Person_highereducation.ResultId= ResultId;
		obj_Person_highereducation.SubjectId= SubjectId;
		obj_Person_highereducation.InstituteId= InstituteId;
		obj_Person_highereducation.Grade= Grade;
		obj_Person_highereducation.Language= Language;
		obj_Person_highereducation.DateTime= DateTime;
		obj_Person_highereducation.PersonId= PersonId;
		obj_Person_highereducation.Level= Level;

		
		UpdatePerson_highereducationPacket(obj_Person_highereducation);
		UI_createPerson_highereducationRow(obj_Person_highereducation, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_highereducation() {
	
	UI_showAddPerson_highereducationForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_highereducationForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_highereducationAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_highereducationform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_highereducationForm(obj_Person_highereducation) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_highereducationUpdateForm(obj_Person_highereducation);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_highereducationform"));
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
function UI_preparePerson_highereducationUpdateForm(obj_Person_highereducation)
{
	var arr_hidelist = new Array("Input_ResultId","Input_PersonId");
	var arr_showlist = new Array("Input_Grade","Input_Language","Input_DateTime","Input_Level","Input_SubjectId","Input_InstituteId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ResultId").value=obj_Person_highereducation.ResultId;
		document.getElementById("Input_SubjectId").value=obj_Person_highereducation.SubjectId;
		document.getElementById("Input_InstituteId").value=obj_Person_highereducation.InstituteId;
		document.getElementById("Input_Grade").value=obj_Person_highereducation.Grade;
		document.getElementById("Input_Language").value=obj_Person_highereducation.Language;
		document.getElementById("Input_DateTime").value=obj_Person_highereducation.DateTime;
		document.getElementById("Input_PersonId").value=obj_Person_highereducation.PersonId;
		document.getElementById("Input_Level").value=obj_Person_highereducation.Level;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_highereducationAddForm()
{
	var arr_hidelist = new Array("Input_ResultId","Input_PersonId");
	var arr_showlist = new Array("Input_Grade","Input_Language","Input_DateTime","Input_Level","Input_SubjectId","Input_InstituteId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ResultId").value="";
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_InstituteId").value="";
		document.getElementById("Input_Grade").value="";
		document.getElementById("Input_Language").value="";
		document.getElementById("Input_DateTime").value="";
		document.getElementById("Input_PersonId").value="";
		document.getElementById("Input_Level").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_highereducationToPerson_highereducationList() {
	var uiPerson_highereducationList = document.getElementById("Person_highereducationList");

	var rowElems = uiPerson_highereducationList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_highereducationRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_highereducationRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_highereducationRowHtmlElem(obj_Person_highereducation,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_highereducationImg_"+obj_Person_highereducation.ResultId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_highereducation/0_small.png";
	else ImgElem.src = "Person_highereducation/"+obj_Person_highereducation.ResultId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_highereducation.ResultId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_highereducation.SubjectId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_highereducation.InstituteId;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_highereducation.Grade;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_highereducation.Language;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Person_highereducation.DateTime;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Person_highereducation.PersonId;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow";
		ElemDataRow9.innerHTML = obj_Person_highereducation.Level;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_highereducationdata"+ElemId);
		ElementDataHidden.value = obj_Person_highereducation.getPerson_highereducationData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);
		ElemLi.appendChild(ElemDataRow8);
		ElemLi.appendChild(ElemDataRow9);

		
		ElemLi= UI_createPerson_highereducationRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_highereducationRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_highereducationRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_highereducationHtmlElem(obj_Person_highereducation)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_highereducation");
		html ="<a href=\"?page=dashboard&ResultId="+obj_Person_highereducation.ResultId+"\">"+obj_Person_highereducation.ResultId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_highereducationRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_highereducationRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_highereducationRow(obj_Person_highereducation, rowType,dummyId) {
	var html = "";
	
	var UiPerson_highereducationList = document.getElementById("Person_highereducationList");
	var ClassName = "ListRow";
	var ElemId = "Person_highereducationListRow_"+obj_Person_highereducation.ResultId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_highereducationRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_highereducationRowHtmlElem(obj_Person_highereducation,ElemId, ClassName);
			UiPerson_highereducationList.insertBefore(ElemLi, UiPerson_highereducationList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_highereducation msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_highereducationRowHtmlElem(obj_Person_highereducation,ElemId, ClassName);
			UiPerson_highereducationList.insertBefore(ElemLi, UiPerson_highereducationList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_highereducationRow_"+dummyId);
			var DummyData = document.getElementById("Person_highereducationdataDummyPerson_highereducationRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_highereducationdata"+ElemId);		
				DummyData.value = obj_Person_highereducation.getPerson_highereducationData();		
				}
				UI_createTopbarSubPerson_highereducationHtmlElem(obj_Person_highereducation);
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
				var ElemLi = UI_createPerson_highereducationRowHtmlElem(obj_Person_highereducation,ElemId, ClassName);
				UiPerson_highereducationList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_highereducationList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, ResultId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_highereducationListRow_"+ResultId);
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


