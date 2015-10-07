//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_vocationaltraining_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_vocationaltraining(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_vocationaltraining(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_vocationaltraining(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_vocationaltraining(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_vocationaltraining(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_vocationaltraining = new Person_vocationaltraining();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_vocationaltraining.VocationalTrainId= mainPacket[3];
		obj_Person_vocationaltraining.FieldName= mainPacket[4];
		obj_Person_vocationaltraining.CourseName= mainPacket[5];
		obj_Person_vocationaltraining.InstituteId= mainPacket[6];
		obj_Person_vocationaltraining.StartDate= mainPacket[7];
		obj_Person_vocationaltraining.EndDate= mainPacket[8];
		obj_Person_vocationaltraining.CertificateType= mainPacket[9];
		obj_Person_vocationaltraining.PersonId= mainPacket[10];



		if (resultStatus == 1) {	
			
			UI_createPerson_vocationaltrainingRow(obj_Person_vocationaltraining, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_vocationaltraining(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_vocationaltraining = new Person_vocationaltraining();
		
		var resultStatus = mainPacket[0];
		var VocationalTrainId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_vocationaltrainingListRow_"+VocationalTrainId);
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
				var rowElem = document.getElementById("Person_vocationaltrainingListRow_"+VocationalTrainId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_vocationaltraining(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_vocationaltraining = new Person_vocationaltraining();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_vocationaltraining.VocationalTrainId= mainPacket[2];
		obj_Person_vocationaltraining.FieldName= mainPacket[3];
		obj_Person_vocationaltraining.CourseName= mainPacket[4];
		obj_Person_vocationaltraining.InstituteId= mainPacket[5];
		obj_Person_vocationaltraining.StartDate= mainPacket[6];
		obj_Person_vocationaltraining.EndDate= mainPacket[7];
		obj_Person_vocationaltraining.CertificateType= mainPacket[8];
		obj_Person_vocationaltraining.PersonId= mainPacket[9];


		if (resultStatus == 1) {			
			UI_createPerson_vocationaltrainingRow(obj_Person_vocationaltraining, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_vocationaltraining_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_vocationaltrainingPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_vocationaltraining; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_vocationaltrainingPacket(VocationalTrainId) {
	var deletePacketBody  = VocationalTrainId;

	var postpacket = createOutgoingPerson_vocationaltrainingPacket(202,deletePacketBody);
	Person_vocationaltraining_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_vocationaltrainingPacket(obj_Person_vocationaltraining) {
	var savePacketBody  = obj_Person_vocationaltraining.createPerson_vocationaltrainingPacket();

	var postpacket = createOutgoingPerson_vocationaltrainingPacket(203,savePacketBody);
	Person_vocationaltraining_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_vocationaltrainingPacket(dummyId,obj_Person_vocationaltraining) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_vocationaltraining.createPerson_vocationaltrainingPacket();

	var postpacket = createOutgoingPerson_vocationaltrainingPacket(201,savePacketBody);
	Person_vocationaltraining_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_vocationaltrainingPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_vocationaltrainingPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_vocationaltraining = document.getElementById("btnaddPerson_vocationaltraining");
	if(addPerson_vocationaltraining){
	addPerson_vocationaltraining.addEventListener('mousedown', Event_mousedown_addPerson_vocationaltraining, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_vocationaltrainingform = document.getElementById("popPerson_vocationaltrainingform");
	var inputElems = popPerson_vocationaltrainingform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_vocationaltrainingList = document.getElementById("Person_vocationaltrainingList");
	var liElems = UiPerson_vocationaltrainingList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_vocationaltrainingRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_vocationaltrainingRow, false);
		
	}
	
	var UiPerson_vocationaltrainingListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_vocationaltrainingListDeletebtns.length; z++) {
			UiPerson_vocationaltrainingListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_vocationaltrainingRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_InstituteId","Name",17);	//organization
	
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
	UI_search_Person_vocationaltraining(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_vocationaltrainingRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_vocationaltraining = Get_Person_vocationaltrainingByListRow(this.parentNode.parentNode);
			if(obj_Person_vocationaltraining != ""){
				deletePerson_vocationaltraining(obj_Person_vocationaltraining.VocationalTrainId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_vocationaltraining = Get_Person_vocationaltrainingByListRow(this.parentNode.parentNode);
			if(obj_Person_vocationaltraining != ""){
				UI_showUpdatePerson_vocationaltrainingForm(obj_Person_vocationaltraining);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_vocationaltraining(searchText)
{

	//Person_vocationaltrainingList = 
	var Person_vocationaltrainingListElem = document.getElementById("Person_vocationaltrainingList");
	
	if(Person_vocationaltrainingListElem)
	{
		var Person_vocationaltrainingDataList = Person_vocationaltrainingListElem.getElementsByTagName("input");
		for(var y=0 in Person_vocationaltrainingDataList)
		{
			if(Person_vocationaltrainingDataList[y])
			{
				
				
				var displayType = "none";
				var Person_vocationaltrainingData = Person_vocationaltrainingDataList[y].value;
				if(!((Person_vocationaltrainingData == "") || (typeof Person_vocationaltrainingData=="undefined")))
				{
				if(search_Person_vocationaltraining(Person_vocationaltrainingData,searchText))
				{
					displayType = "block";
				}
				Person_vocationaltrainingDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_vocationaltraining(Person_vocationaltrainingData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_vocationaltrainingData = decodeSpText(Person_vocationaltrainingData.toLowerCase());
	if(Person_vocationaltrainingData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_vocationaltraining)
{
	if (obj_Person_vocationaltraining.VocationalTrainId) {
		var fieldDataId = obj_Person_vocationaltraining.VocationalTrainId;
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

function deletePerson_vocationaltraining(VocationalTrainId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_vocationaltraining");
	if(flag){
			DeletePerson_vocationaltrainingPacket(VocationalTrainId);
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

function Get_Person_vocationaltrainingByListRow(listRowElem)
{
	
	var obj_Person_vocationaltraining ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_vocationaltrainingData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_vocationaltrainingData = elemlist[z].value;
			}		
		}
		
		if(Person_vocationaltrainingData != "")
		{
		var arrPerson_vocationaltrainingData = Person_vocationaltrainingData.split(";");	
		
		obj_Person_vocationaltraining = new Person_vocationaltraining();
		obj_Person_vocationaltraining.VocationalTrainId= arrPerson_vocationaltrainingData[0];
		obj_Person_vocationaltraining.FieldName= arrPerson_vocationaltrainingData[1];
		obj_Person_vocationaltraining.CourseName= arrPerson_vocationaltrainingData[2];
		obj_Person_vocationaltraining.InstituteId= arrPerson_vocationaltrainingData[3];
		obj_Person_vocationaltraining.StartDate= arrPerson_vocationaltrainingData[4];
		obj_Person_vocationaltraining.EndDate= arrPerson_vocationaltrainingData[5];
		obj_Person_vocationaltraining.CertificateType= arrPerson_vocationaltrainingData[6];
		obj_Person_vocationaltraining.PersonId= arrPerson_vocationaltrainingData[7];

		
		
		}
		
	}
	
	return obj_Person_vocationaltraining;
	
	
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
	
		var Elem = document.getElementById("Input_FieldName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Field name";
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
	
		var obj_Person_vocationaltraining = new Person_vocationaltraining();
		
		var VocationalTrainId= document.getElementById("Input_VocationalTrainId").value;
		var FieldName= document.getElementById("Input_FieldName").value;
		var CourseName= document.getElementById("Input_CourseName").value;
		var InstituteId= document.getElementById("Input_InstituteId").value;
		var StartDate= document.getElementById("Input_StartDate").value;
		var EndDate= document.getElementById("Input_EndDate").value;
		var CertificateType= document.getElementById("Input_CertificateType").value;
		var PersonId= document.getElementById("Input_PersonId").value;

		
		document.getElementById("Input_VocationalTrainId").value="";
		document.getElementById("Input_FieldName").value="";
		document.getElementById("Input_CourseName").value="";
		document.getElementById("Input_InstituteId").value="";
		document.getElementById("Input_StartDate").value="";
		document.getElementById("Input_EndDate").value="";
		document.getElementById("Input_CertificateType").value="";
		document.getElementById("Input_PersonId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_vocationaltraining = new Person_vocationaltraining();
		obj_Person_vocationaltraining.VocationalTrainId= VocationalTrainId;
		obj_Person_vocationaltraining.FieldName= FieldName;
		obj_Person_vocationaltraining.CourseName= CourseName;
		obj_Person_vocationaltraining.InstituteId= InstituteId;
		obj_Person_vocationaltraining.StartDate= StartDate;
		obj_Person_vocationaltraining.EndDate= EndDate;
		obj_Person_vocationaltraining.CertificateType= CertificateType;
		obj_Person_vocationaltraining.PersonId= PersonId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_vocationaltrainingPacket(dummyId,obj_Person_vocationaltraining);
		UI_createPerson_vocationaltrainingRow(obj_Person_vocationaltraining, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_vocationaltraining = new Person_vocationaltraining();

		obj_Person_vocationaltraining.VocationalTrainId= VocationalTrainId;
		obj_Person_vocationaltraining.FieldName= FieldName;
		obj_Person_vocationaltraining.CourseName= CourseName;
		obj_Person_vocationaltraining.InstituteId= InstituteId;
		obj_Person_vocationaltraining.StartDate= StartDate;
		obj_Person_vocationaltraining.EndDate= EndDate;
		obj_Person_vocationaltraining.CertificateType= CertificateType;
		obj_Person_vocationaltraining.PersonId= PersonId;

		
		UpdatePerson_vocationaltrainingPacket(obj_Person_vocationaltraining);
		UI_createPerson_vocationaltrainingRow(obj_Person_vocationaltraining, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_vocationaltraining() {
	
	UI_showAddPerson_vocationaltrainingForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_vocationaltrainingForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_vocationaltrainingAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_vocationaltrainingform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_vocationaltrainingForm(obj_Person_vocationaltraining) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_vocationaltrainingUpdateForm(obj_Person_vocationaltraining);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_vocationaltrainingform"));
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
function UI_preparePerson_vocationaltrainingUpdateForm(obj_Person_vocationaltraining)
{
	var arr_hidelist = new Array("Input_VocationalTrainId");
	var arr_showlist = new Array("Input_FieldName","Input_CourseName","Input_StartDate","Input_EndDate","Input_CertificateType","Input_InstituteId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VocationalTrainId").value=obj_Person_vocationaltraining.VocationalTrainId;
		document.getElementById("Input_FieldName").value=obj_Person_vocationaltraining.FieldName;
		document.getElementById("Input_CourseName").value=obj_Person_vocationaltraining.CourseName;
		document.getElementById("Input_InstituteId").value=obj_Person_vocationaltraining.InstituteId;
		document.getElementById("Input_StartDate").value=obj_Person_vocationaltraining.StartDate;
		document.getElementById("Input_EndDate").value=obj_Person_vocationaltraining.EndDate;
		document.getElementById("Input_CertificateType").value=obj_Person_vocationaltraining.CertificateType;
		document.getElementById("Input_PersonId").value=obj_Person_vocationaltraining.PersonId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_vocationaltrainingAddForm()
{
	var arr_hidelist = new Array("Input_VocationalTrainId","Input_PersonId","Input_InstituteId");
	var arr_showlist = new Array("Input_FieldName","Input_CourseName","Input_StartDate","Input_EndDate","Input_CertificateType");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VocationalTrainId").value="";
		document.getElementById("Input_FieldName").value="";
		document.getElementById("Input_CourseName").value="";
		document.getElementById("Input_InstituteId").value="";
		document.getElementById("Input_StartDate").value="";
		document.getElementById("Input_EndDate").value="";
		document.getElementById("Input_CertificateType").value="";
		document.getElementById("Input_PersonId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_vocationaltrainingToPerson_vocationaltrainingList() {
	var uiPerson_vocationaltrainingList = document.getElementById("Person_vocationaltrainingList");

	var rowElems = uiPerson_vocationaltrainingList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_vocationaltrainingRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_vocationaltrainingRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_vocationaltrainingRowHtmlElem(obj_Person_vocationaltraining,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_vocationaltrainingImg_"+obj_Person_vocationaltraining.VocationalTrainId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_vocationaltraining/0_small.png";
	else ImgElem.src = "Person_vocationaltraining/"+obj_Person_vocationaltraining.VocationalTrainId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_vocationaltraining.VocationalTrainId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_vocationaltraining.FieldName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_vocationaltraining.CourseName;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_vocationaltraining.InstituteId;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_vocationaltraining.StartDate;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Person_vocationaltraining.EndDate;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Person_vocationaltraining.CertificateType;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow";
		ElemDataRow9.innerHTML = obj_Person_vocationaltraining.PersonId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_vocationaltrainingdata"+ElemId);
		ElementDataHidden.value = obj_Person_vocationaltraining.getPerson_vocationaltrainingData();
		 
		 

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

		
		ElemLi= UI_createPerson_vocationaltrainingRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_vocationaltrainingRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_vocationaltrainingRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_vocationaltrainingHtmlElem(obj_Person_vocationaltraining)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_vocationaltraining");
		html ="<a href=\"?page=dashboard&VocationalTrainId="+obj_Person_vocationaltraining.VocationalTrainId+"\">"+obj_Person_vocationaltraining.VocationalTrainId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_vocationaltrainingRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_vocationaltrainingRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_vocationaltrainingRow(obj_Person_vocationaltraining, rowType,dummyId) {
	var html = "";
	
	var UiPerson_vocationaltrainingList = document.getElementById("Person_vocationaltrainingList");
	var ClassName = "ListRow";
	var ElemId = "Person_vocationaltrainingListRow_"+obj_Person_vocationaltraining.VocationalTrainId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_vocationaltrainingRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_vocationaltrainingRowHtmlElem(obj_Person_vocationaltraining,ElemId, ClassName);
			UiPerson_vocationaltrainingList.insertBefore(ElemLi, UiPerson_vocationaltrainingList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_vocationaltraining msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_vocationaltrainingRowHtmlElem(obj_Person_vocationaltraining,ElemId, ClassName);
			UiPerson_vocationaltrainingList.insertBefore(ElemLi, UiPerson_vocationaltrainingList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_vocationaltrainingRow_"+dummyId);
			var DummyData = document.getElementById("Person_vocationaltrainingdataDummyPerson_vocationaltrainingRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_vocationaltrainingdata"+ElemId);		
				DummyData.value = obj_Person_vocationaltraining.getPerson_vocationaltrainingData();		
				}
				UI_createTopbarSubPerson_vocationaltrainingHtmlElem(obj_Person_vocationaltraining);
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
				var ElemLi = UI_createPerson_vocationaltrainingRowHtmlElem(obj_Person_vocationaltraining,ElemId, ClassName);
				UiPerson_vocationaltrainingList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_vocationaltrainingList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, VocationalTrainId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_vocationaltrainingListRow_"+VocationalTrainId);
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


