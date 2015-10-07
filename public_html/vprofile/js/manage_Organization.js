//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Organization_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addOrganization(mainPacket);
			break;
		}
		case 201: {
			ACK_addOrganization(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteOrganization(mainPacket);
			break;
		}
		case 203: {
			ACK_updateOrganization(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addOrganization(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Organization = new Organization();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Organization.OrganizationId= mainPacket[3];
		obj_Organization.Name= mainPacket[4];
		obj_Organization.Description= mainPacket[5];
		obj_Organization.Address= mainPacket[6];
		obj_Organization.telephone= mainPacket[7];
		obj_Organization.fax= mainPacket[8];
		obj_Organization.website= mainPacket[9];
		obj_Organization.email= mainPacket[10];
		obj_Organization.OrganizationTypeId= mainPacket[11];
		obj_Organization.OrganizationSubTypeId= mainPacket[12];



		if (resultStatus == 1) {	
			
			UI_createOrganizationRow(obj_Organization, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteOrganization(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Organization = new Organization();
		
		var resultStatus = mainPacket[0];
		var OrganizationId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("OrganizationListRow_"+OrganizationId);
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
				var rowElem = document.getElementById("OrganizationListRow_"+OrganizationId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateOrganization(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Organization = new Organization();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Organization.OrganizationId= mainPacket[2];
		obj_Organization.Name= mainPacket[3];
		obj_Organization.Description= mainPacket[4];
		obj_Organization.Address= mainPacket[5];
		obj_Organization.telephone= mainPacket[6];
		obj_Organization.fax= mainPacket[7];
		obj_Organization.website= mainPacket[8];
		obj_Organization.email= mainPacket[9];
		obj_Organization.OrganizationTypeId= mainPacket[10];
		obj_Organization.OrganizationSubTypeId= mainPacket[11];


		if (resultStatus == 1) {			
			UI_createOrganizationRow(obj_Organization, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Organization_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingOrganizationPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Organization; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteOrganizationPacket(OrganizationId) {
	var deletePacketBody  = OrganizationId;

	var postpacket = createOutgoingOrganizationPacket(202,deletePacketBody);
	Organization_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateOrganizationPacket(obj_Organization) {
	var savePacketBody  = obj_Organization.createOrganizationPacket();

	var postpacket = createOutgoingOrganizationPacket(203,savePacketBody);
	Organization_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddOrganizationPacket(dummyId,obj_Organization) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Organization.createOrganizationPacket();

	var postpacket = createOutgoingOrganizationPacket(201,savePacketBody);
	Organization_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onOrganizationPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onOrganizationPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addOrganization = document.getElementById("btnaddOrganization");
	if(addOrganization){
	addOrganization.addEventListener('mousedown', Event_mousedown_addOrganization, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popOrganizationform = document.getElementById("popOrganizationform");
	var inputElems = popOrganizationform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiOrganizationList = document.getElementById("OrganizationList");
	var liElems = UiOrganizationList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverOrganizationRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutOrganizationRow, false);
		
	}
	
	var UiOrganizationListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiOrganizationListDeletebtns.length; z++) {
			UiOrganizationListDeletebtns[z].addEventListener('mousedown', Event_mouseDownOrganizationRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }

	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_OrganizationTypeId","OrganizationTypeName",19); //organization type
		
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
	UI_search_Organization(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownOrganizationRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Organization = Get_OrganizationByListRow(this.parentNode.parentNode);
			if(obj_Organization != ""){
				deleteOrganization(obj_Organization.OrganizationId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Organization = Get_OrganizationByListRow(this.parentNode.parentNode);
			if(obj_Organization != ""){
				UI_showUpdateOrganizationForm(obj_Organization);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Organization(searchText)
{

	//OrganizationList = 
	var OrganizationListElem = document.getElementById("OrganizationList");
	
	if(OrganizationListElem)
	{
		var OrganizationDataList = OrganizationListElem.getElementsByTagName("input");
		for(var y=0 in OrganizationDataList)
		{
			if(OrganizationDataList[y])
			{
				
				
				var displayType = "none";
				var OrganizationData = OrganizationDataList[y].value;
				if(!((OrganizationData == "") || (typeof OrganizationData=="undefined")))
				{
				if(search_Organization(OrganizationData,searchText))
				{
					displayType = "block";
				}
				OrganizationDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Organization(OrganizationData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	OrganizationData = decodeSpText(OrganizationData.toLowerCase());
	if(OrganizationData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Organization)
{
	if (obj_Organization.OrganizationId) {
		var fieldDataId = obj_Organization.OrganizationId;
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

function deleteOrganization(OrganizationId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Organization");
	if(flag){
			DeleteOrganizationPacket(OrganizationId);
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

function Get_OrganizationByListRow(listRowElem)
{
	
	var obj_Organization ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var OrganizationData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				OrganizationData = elemlist[z].value;
			}		
		}
		
		if(OrganizationData != "")
		{
		var arrOrganizationData = OrganizationData.split(";");	
		
		obj_Organization = new Organization();
		obj_Organization.OrganizationId= arrOrganizationData[0];
		obj_Organization.Name= arrOrganizationData[1];
		obj_Organization.Description= arrOrganizationData[2];
		obj_Organization.Address= arrOrganizationData[3];
		obj_Organization.telephone= arrOrganizationData[4];
		obj_Organization.fax= arrOrganizationData[5];
		obj_Organization.website= arrOrganizationData[6];
		obj_Organization.email= arrOrganizationData[7];
		obj_Organization.OrganizationTypeId= arrOrganizationData[8];
		obj_Organization.OrganizationSubTypeId= arrOrganizationData[9];

		
		
		}
		
	}
	
	return obj_Organization;
	
	
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
	

		var Elem = document.getElementById("Input_Name");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter name";
					Elem.focus();
				}				
			
				}		
 Elem = document.getElementById("Input_telephone");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter phone number";
					Elem.focus();
				}				
				else if(isNaN(Elem.value))
				{
					
					iserror =true;
					error = "Invalid number";	
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
	
		var obj_Organization = new Organization();
		
		var OrganizationId= document.getElementById("Input_OrganizationId").value;
		var Name= document.getElementById("Input_Name").value;
		var Description= document.getElementById("Input_Description").value;
		var Address= document.getElementById("Input_Address").value;
		var telephone= document.getElementById("Input_telephone").value;
		var fax= document.getElementById("Input_fax").value;
		var website= document.getElementById("Input_website").value;
		var email= document.getElementById("Input_email").value;
		var OrganizationTypeId= document.getElementById("Input_OrganizationTypeId").value;
		var OrganizationSubTypeId= document.getElementById("Input_OrganizationSubTypeId").value;

		
		document.getElementById("Input_OrganizationId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_Address").value="";
		document.getElementById("Input_telephone").value="";
		document.getElementById("Input_fax").value="";
		document.getElementById("Input_website").value="";
		document.getElementById("Input_email").value="";
		document.getElementById("Input_OrganizationTypeId").value="";
		document.getElementById("Input_OrganizationSubTypeId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Organization = new Organization();
		obj_Organization.OrganizationId= OrganizationId;
		obj_Organization.Name= Name;
		obj_Organization.Description= Description;
		obj_Organization.Address= Address;
		obj_Organization.telephone= telephone;
		obj_Organization.fax= fax;
		obj_Organization.website= website;
		obj_Organization.email= email;
		obj_Organization.OrganizationTypeId= OrganizationTypeId;
		obj_Organization.OrganizationSubTypeId= OrganizationSubTypeId;

		
		var dummyId = CreateDummyNumber();
		AddOrganizationPacket(dummyId,obj_Organization);
		UI_createOrganizationRow(obj_Organization, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Organization = new Organization();

		obj_Organization.OrganizationId= OrganizationId;
		obj_Organization.Name= Name;
		obj_Organization.Description= Description;
		obj_Organization.Address= Address;
		obj_Organization.telephone= telephone;
		obj_Organization.fax= fax;
		obj_Organization.website= website;
		obj_Organization.email= email;
		obj_Organization.OrganizationTypeId= OrganizationTypeId;
		obj_Organization.OrganizationSubTypeId= OrganizationSubTypeId;

		
		UpdateOrganizationPacket(obj_Organization);
		UI_createOrganizationRow(obj_Organization, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addOrganization() {
	
	UI_showAddOrganizationForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddOrganizationForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOrganizationAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOrganizationform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateOrganizationForm(obj_Organization) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOrganizationUpdateForm(obj_Organization);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOrganizationform"));
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
function UI_prepareOrganizationUpdateForm(obj_Organization)
{
	var arr_hidelist = new Array("Input_OrganizationId","Input_OrganizationSubTypeId");
	var arr_showlist = new Array("Input_Name","Input_Description","Input_Address","Input_telephone","Input_fax","Input_website","Input_email","Input_OrganizationTypeId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationId").value=obj_Organization.OrganizationId;
		document.getElementById("Input_Name").value=obj_Organization.Name;
		document.getElementById("Input_Description").value=obj_Organization.Description;
		document.getElementById("Input_Address").value=obj_Organization.Address;
		document.getElementById("Input_telephone").value=obj_Organization.telephone;
		document.getElementById("Input_fax").value=obj_Organization.fax;
		document.getElementById("Input_website").value=obj_Organization.website;
		document.getElementById("Input_email").value=obj_Organization.email;
		document.getElementById("Input_OrganizationTypeId").value=obj_Organization.OrganizationTypeId;
		document.getElementById("Input_OrganizationSubTypeId").value=obj_Organization.OrganizationSubTypeId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareOrganizationAddForm()
{
	var arr_hidelist = new Array("Input_OrganizationId","Input_OrganizationSubTypeId");
	var arr_showlist = new Array("Input_Name","Input_Description","Input_Address","Input_telephone","Input_fax","Input_website","Input_email","Input_OrganizationTypeId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_Address").value="";
		document.getElementById("Input_telephone").value="";
		document.getElementById("Input_fax").value="";
		document.getElementById("Input_website").value="";
		document.getElementById("Input_email").value="";
		document.getElementById("Input_OrganizationTypeId").value="";
		document.getElementById("Input_OrganizationSubTypeId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addOrganizationToOrganizationList() {
	var uiOrganizationList = document.getElementById("OrganizationList");

	var rowElems = uiOrganizationList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganizationRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownOrganizationRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganizationRowHtmlElem(obj_Organization,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "OrganizationImg_"+obj_Organization.OrganizationId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Organization/0_small.png";
	else ImgElem.src = "Organization/"+obj_Organization.OrganizationId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Organization.OrganizationId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Organization.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Organization.Description;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Organization.Address;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Organization.telephone;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Organization.fax;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Organization.website;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow";
		ElemDataRow9.innerHTML = obj_Organization.email;
		var ElemDataRow10 = document.createElement("div");
		ElemDataRow10.className ="datarow";
		ElemDataRow10.innerHTML = obj_Organization.OrganizationTypeId;
		var ElemDataRow11 = document.createElement("div");
		ElemDataRow11.className ="datarow";
		ElemDataRow11.innerHTML = obj_Organization.OrganizationSubTypeId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Organizationdata"+ElemId);
		ElementDataHidden.value = obj_Organization.getOrganizationData();
		 
		 

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
		ElemLi.appendChild(ElemDataRow10);
		ElemLi.appendChild(ElemDataRow11);

		
		ElemLi= UI_createOrganizationRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverOrganizationRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutOrganizationRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubOrganizationHtmlElem(obj_Organization)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subOrganization");
		html ="<a href=\"?page=dashboard&OrganizationId="+obj_Organization.OrganizationId+"\">"+obj_Organization.OrganizationId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverOrganizationRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutOrganizationRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOrganizationRow(obj_Organization, rowType,dummyId) {
	var html = "";
	
	var UiOrganizationList = document.getElementById("OrganizationList");
	var ClassName = "ListRow";
	var ElemId = "OrganizationListRow_"+obj_Organization.OrganizationId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyOrganizationRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createOrganizationRowHtmlElem(obj_Organization,ElemId, ClassName);
			UiOrganizationList.insertBefore(ElemLi, UiOrganizationList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Organization msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createOrganizationRowHtmlElem(obj_Organization,ElemId, ClassName);
			UiOrganizationList.insertBefore(ElemLi, UiOrganizationList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyOrganizationRow_"+dummyId);
			var DummyData = document.getElementById("OrganizationdataDummyOrganizationRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Organizationdata"+ElemId);		
				DummyData.value = obj_Organization.getOrganizationData();		
				}
				UI_createTopbarSubOrganizationHtmlElem(obj_Organization);
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
				var ElemLi = UI_createOrganizationRowHtmlElem(obj_Organization,ElemId, ClassName);
				UiOrganizationList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("OrganizationList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, OrganizationId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("OrganizationListRow_"+OrganizationId);
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


