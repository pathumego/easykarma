//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_workingexperiance_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_workingexperiance(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_workingexperiance(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_workingexperiance(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_workingexperiance(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_workingexperiance(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_workingexperiance = new Person_workingexperiance();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_workingexperiance.WorkExpId= mainPacket[3];
		obj_Person_workingexperiance.CompanyId= mainPacket[4];
		obj_Person_workingexperiance.StartDate= mainPacket[5];
		obj_Person_workingexperiance.EndDate= mainPacket[6];
		obj_Person_workingexperiance.Position= mainPacket[7];
		obj_Person_workingexperiance.PersonId= mainPacket[8];



		if (resultStatus == 1) {	
			
			UI_createPerson_workingexperianceRow(obj_Person_workingexperiance, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_workingexperiance(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_workingexperiance = new Person_workingexperiance();
		
		var resultStatus = mainPacket[0];
		var WorkExpId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_workingexperianceListRow_"+WorkExpId);
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
				var rowElem = document.getElementById("Person_workingexperianceListRow_"+WorkExpId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_workingexperiance(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_workingexperiance = new Person_workingexperiance();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_workingexperiance.WorkExpId= mainPacket[2];
		obj_Person_workingexperiance.CompanyId= mainPacket[3];
		obj_Person_workingexperiance.StartDate= mainPacket[4];
		obj_Person_workingexperiance.EndDate= mainPacket[5];
		obj_Person_workingexperiance.Position= mainPacket[6];
		obj_Person_workingexperiance.PersonId= mainPacket[7];


		if (resultStatus == 1) {			
			UI_createPerson_workingexperianceRow(obj_Person_workingexperiance, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_workingexperiance_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_workingexperiancePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_workingexperiance; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_workingexperiancePacket(WorkExpId) {
	var deletePacketBody  = WorkExpId;

	var postpacket = createOutgoingPerson_workingexperiancePacket(202,deletePacketBody);
	Person_workingexperiance_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_workingexperiancePacket(obj_Person_workingexperiance) {
	var savePacketBody  = obj_Person_workingexperiance.createPerson_workingexperiancePacket();

	var postpacket = createOutgoingPerson_workingexperiancePacket(203,savePacketBody);
	Person_workingexperiance_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_workingexperiancePacket(dummyId,obj_Person_workingexperiance) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_workingexperiance.createPerson_workingexperiancePacket();

	var postpacket = createOutgoingPerson_workingexperiancePacket(201,savePacketBody);
	Person_workingexperiance_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_workingexperiancePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_workingexperiancePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_workingexperiance = document.getElementById("btnaddPerson_workingexperiance");
	if(addPerson_workingexperiance){
	addPerson_workingexperiance.addEventListener('mousedown', Event_mousedown_addPerson_workingexperiance, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_workingexperianceform = document.getElementById("popPerson_workingexperianceform");
	var inputElems = popPerson_workingexperianceform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_workingexperianceList = document.getElementById("Person_workingexperianceList");
	var liElems = UiPerson_workingexperianceList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_workingexperianceRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_workingexperianceRow, false);
		
	}
	
	var UiPerson_workingexperianceListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_workingexperianceListDeletebtns.length; z++) {
			UiPerson_workingexperianceListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_workingexperianceRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_CompanyId","Name",4);	//business
	
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
	UI_search_Person_workingexperiance(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_workingexperianceRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_workingexperiance = Get_Person_workingexperianceByListRow(this.parentNode.parentNode);
			if(obj_Person_workingexperiance != ""){
				deletePerson_workingexperiance(obj_Person_workingexperiance.WorkExpId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_workingexperiance = Get_Person_workingexperianceByListRow(this.parentNode.parentNode);
			if(obj_Person_workingexperiance != ""){
				UI_showUpdatePerson_workingexperianceForm(obj_Person_workingexperiance);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_workingexperiance(searchText)
{

	//Person_workingexperianceList = 
	var Person_workingexperianceListElem = document.getElementById("Person_workingexperianceList");
	
	if(Person_workingexperianceListElem)
	{
		var Person_workingexperianceDataList = Person_workingexperianceListElem.getElementsByTagName("input");
		for(var y=0 in Person_workingexperianceDataList)
		{
			if(Person_workingexperianceDataList[y])
			{
				
				
				var displayType = "none";
				var Person_workingexperianceData = Person_workingexperianceDataList[y].value;
				if(!((Person_workingexperianceData == "") || (typeof Person_workingexperianceData=="undefined")))
				{
				if(search_Person_workingexperiance(Person_workingexperianceData,searchText))
				{
					displayType = "block";
				}
				Person_workingexperianceDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_workingexperiance(Person_workingexperianceData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_workingexperianceData = decodeSpText(Person_workingexperianceData.toLowerCase());
	if(Person_workingexperianceData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_workingexperiance)
{
	if (obj_Person_workingexperiance.WorkExpId) {
		var fieldDataId = obj_Person_workingexperiance.WorkExpId;
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

function deletePerson_workingexperiance(WorkExpId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_workingexperiance");
	if(flag){
			DeletePerson_workingexperiancePacket(WorkExpId);
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

function Get_Person_workingexperianceByListRow(listRowElem)
{
	
	var obj_Person_workingexperiance ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_workingexperianceData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_workingexperianceData = elemlist[z].value;
			}		
		}
		
		if(Person_workingexperianceData != "")
		{
		var arrPerson_workingexperianceData = Person_workingexperianceData.split(";");	
		
		obj_Person_workingexperiance = new Person_workingexperiance();
		obj_Person_workingexperiance.WorkExpId= arrPerson_workingexperianceData[0];
		obj_Person_workingexperiance.CompanyId= arrPerson_workingexperianceData[1];
		obj_Person_workingexperiance.StartDate= arrPerson_workingexperianceData[2];
		obj_Person_workingexperiance.EndDate= arrPerson_workingexperianceData[3];
		obj_Person_workingexperiance.Position= arrPerson_workingexperianceData[4];
		obj_Person_workingexperiance.PersonId= arrPerson_workingexperianceData[5];

		
		
		}
		
	}
	
	return obj_Person_workingexperiance;
	
	
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
	

			var Elem = document.getElementById("Input_Position");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Position";
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
	
		var obj_Person_workingexperiance = new Person_workingexperiance();
		
		var WorkExpId= document.getElementById("Input_WorkExpId").value;
		var CompanyId= document.getElementById("Input_CompanyId").value;
		var StartDate= document.getElementById("Input_StartDate").value;
		var EndDate= document.getElementById("Input_EndDate").value;
		var Position= document.getElementById("Input_Position").value;
		var PersonId= document.getElementById("Input_PersonId").value;

		
		document.getElementById("Input_WorkExpId").value="";
		document.getElementById("Input_CompanyId").value="";
		document.getElementById("Input_StartDate").value="";
		document.getElementById("Input_EndDate").value="";
		document.getElementById("Input_Position").value="";
		document.getElementById("Input_PersonId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_workingexperiance = new Person_workingexperiance();
		obj_Person_workingexperiance.WorkExpId= WorkExpId;
		obj_Person_workingexperiance.CompanyId= CompanyId;
		obj_Person_workingexperiance.StartDate= StartDate;
		obj_Person_workingexperiance.EndDate= EndDate;
		obj_Person_workingexperiance.Position= Position;
		obj_Person_workingexperiance.PersonId= PersonId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_workingexperiancePacket(dummyId,obj_Person_workingexperiance);
		UI_createPerson_workingexperianceRow(obj_Person_workingexperiance, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_workingexperiance = new Person_workingexperiance();

		obj_Person_workingexperiance.WorkExpId= WorkExpId;
		obj_Person_workingexperiance.CompanyId= CompanyId;
		obj_Person_workingexperiance.StartDate= StartDate;
		obj_Person_workingexperiance.EndDate= EndDate;
		obj_Person_workingexperiance.Position= Position;
		obj_Person_workingexperiance.PersonId= PersonId;

		
		UpdatePerson_workingexperiancePacket(obj_Person_workingexperiance);
		UI_createPerson_workingexperianceRow(obj_Person_workingexperiance, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_workingexperiance() {
	
	UI_showAddPerson_workingexperianceForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_workingexperianceForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_workingexperianceAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_workingexperianceform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_workingexperianceForm(obj_Person_workingexperiance) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_workingexperianceUpdateForm(obj_Person_workingexperiance);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_workingexperianceform"));
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
function UI_preparePerson_workingexperianceUpdateForm(obj_Person_workingexperiance)
{
	var arr_hidelist = new Array("Input_WorkExpId","Input_PersonId");
	var arr_showlist = new Array("Input_CompanyId","Input_StartDate","Input_EndDate","Input_Position");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_WorkExpId").value=obj_Person_workingexperiance.WorkExpId;
		document.getElementById("Input_CompanyId").value=obj_Person_workingexperiance.CompanyId;
		document.getElementById("Input_StartDate").value=obj_Person_workingexperiance.StartDate;
		document.getElementById("Input_EndDate").value=obj_Person_workingexperiance.EndDate;
		document.getElementById("Input_Position").value=obj_Person_workingexperiance.Position;
		document.getElementById("Input_PersonId").value=obj_Person_workingexperiance.PersonId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_workingexperianceAddForm()
{
	var arr_hidelist = new Array("Input_WorkExpId","Input_PersonId","Input_CompanyId");
	var arr_showlist = new Array("Input_StartDate","Input_EndDate","Input_Position");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_WorkExpId").value="";
		document.getElementById("Input_CompanyId").value="";
		document.getElementById("Input_StartDate").value="";
		document.getElementById("Input_EndDate").value="";
		document.getElementById("Input_Position").value="";
		document.getElementById("Input_PersonId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_workingexperianceToPerson_workingexperianceList() {
	var uiPerson_workingexperianceList = document.getElementById("Person_workingexperianceList");

	var rowElems = uiPerson_workingexperianceList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_workingexperianceRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_workingexperianceRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_workingexperianceRowHtmlElem(obj_Person_workingexperiance,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_workingexperianceImg_"+obj_Person_workingexperiance.WorkExpId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_workingexperiance/0_small.png";
	else ImgElem.src = "Person_workingexperiance/"+obj_Person_workingexperiance.WorkExpId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_workingexperiance.WorkExpId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_workingexperiance.CompanyId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_workingexperiance.StartDate;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_workingexperiance.EndDate;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_workingexperiance.Position;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Person_workingexperiance.PersonId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_workingexperiancedata"+ElemId);
		ElementDataHidden.value = obj_Person_workingexperiance.getPerson_workingexperianceData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);

		
		ElemLi= UI_createPerson_workingexperianceRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_workingexperianceRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_workingexperianceRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_workingexperianceHtmlElem(obj_Person_workingexperiance)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_workingexperiance");
		html ="<a href=\"?page=dashboard&WorkExpId="+obj_Person_workingexperiance.WorkExpId+"\">"+obj_Person_workingexperiance.WorkExpId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_workingexperianceRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_workingexperianceRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_workingexperianceRow(obj_Person_workingexperiance, rowType,dummyId) {
	var html = "";
	
	var UiPerson_workingexperianceList = document.getElementById("Person_workingexperianceList");
	var ClassName = "ListRow";
	var ElemId = "Person_workingexperianceListRow_"+obj_Person_workingexperiance.WorkExpId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_workingexperianceRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_workingexperianceRowHtmlElem(obj_Person_workingexperiance,ElemId, ClassName);
			UiPerson_workingexperianceList.insertBefore(ElemLi, UiPerson_workingexperianceList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_workingexperiance msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_workingexperianceRowHtmlElem(obj_Person_workingexperiance,ElemId, ClassName);
			UiPerson_workingexperianceList.insertBefore(ElemLi, UiPerson_workingexperianceList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_workingexperianceRow_"+dummyId);
			var DummyData = document.getElementById("Person_workingexperiancedataDummyPerson_workingexperianceRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_workingexperiancedata"+ElemId);		
				DummyData.value = obj_Person_workingexperiance.getPerson_workingexperianceData();		
				}
				UI_createTopbarSubPerson_workingexperianceHtmlElem(obj_Person_workingexperiance);
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
				var ElemLi = UI_createPerson_workingexperianceRowHtmlElem(obj_Person_workingexperiance,ElemId, ClassName);
				UiPerson_workingexperianceList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_workingexperianceList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, WorkExpId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_workingexperianceListRow_"+WorkExpId);
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


