//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_organization_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_organization(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_organization(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_organization(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_organization(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_organization(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_organization = new Village_organization();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_organization.OrganizationId= mainPacket[3];
		obj_Village_organization.VillageId= mainPacket[4];



		if (resultStatus == 1) {	
			
			UI_createVillage_organizationRow(obj_Village_organization, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_organization(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_organization = new Village_organization();
		
		var resultStatus = mainPacket[0];
		var VillageId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_organizationListRow_"+VillageId);
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
				var rowElem = document.getElementById("Village_organizationListRow_"+VillageId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_organization(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_organization = new Village_organization();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_organization.OrganizationId= mainPacket[2];
		obj_Village_organization.VillageId= mainPacket[3];


		if (resultStatus == 1) {			
			UI_createVillage_organizationRow(obj_Village_organization, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_organization_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_organizationPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_organization; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_organizationPacket(VillageId) {
	var deletePacketBody  = VillageId;

	var postpacket = createOutgoingVillage_organizationPacket(202,deletePacketBody);
	Village_organization_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_organizationPacket(obj_Village_organization) {
	var savePacketBody  = obj_Village_organization.createVillage_organizationPacket();

	var postpacket = createOutgoingVillage_organizationPacket(203,savePacketBody);
	Village_organization_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_organizationPacket(dummyId,obj_Village_organization) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_organization.createVillage_organizationPacket();

	var postpacket = createOutgoingVillage_organizationPacket(201,savePacketBody);
	Village_organization_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_organizationPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_organizationPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_organization = document.getElementById("btnaddVillage_organization");
	if(addVillage_organization){
	addVillage_organization.addEventListener('mousedown', Event_mousedown_addVillage_organization, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_organizationform = document.getElementById("popVillage_organizationform");
	var inputElems = popVillage_organizationform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_organizationList = document.getElementById("Village_organizationList");
	var liElems = UiVillage_organizationList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_organizationRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_organizationRow, false);
		
	}
	
	var UiVillage_organizationListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_organizationListDeletebtns.length; z++) {
			UiVillage_organizationListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_organizationRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
		global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_OrganizationId","Name",17); //organization
	
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
	UI_search_Village_organization(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_organizationRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_organization = Get_Village_organizationByListRow(this.parentNode.parentNode);
			if(obj_Village_organization != ""){
				deleteVillage_organization(obj_Village_organization.VillageId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_organization = Get_Village_organizationByListRow(this.parentNode.parentNode);
			if(obj_Village_organization != ""){
				UI_showUpdateVillage_organizationForm(obj_Village_organization);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_organization(searchText)
{

	//Village_organizationList = 
	var Village_organizationListElem = document.getElementById("Village_organizationList");
	
	if(Village_organizationListElem)
	{
		var Village_organizationDataList = Village_organizationListElem.getElementsByTagName("input");
		for(var y=0 in Village_organizationDataList)
		{
			if(Village_organizationDataList[y])
			{
				
				
				var displayType = "none";
				var Village_organizationData = Village_organizationDataList[y].value;
				if(!((Village_organizationData == "") || (typeof Village_organizationData=="undefined")))
				{
				if(search_Village_organization(Village_organizationData,searchText))
				{
					displayType = "block";
				}
				Village_organizationDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_organization(Village_organizationData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_organizationData = decodeSpText(Village_organizationData.toLowerCase());
	if(Village_organizationData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_organization)
{
	if (obj_Village_organization.VillageId) {
		var fieldDataId = obj_Village_organization.VillageId;
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

function deleteVillage_organization(VillageId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_organization");
	if(flag){
			DeleteVillage_organizationPacket(VillageId);
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

function Get_Village_organizationByListRow(listRowElem)
{
	
	var obj_Village_organization ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_organizationData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_organizationData = elemlist[z].value;
			}		
		}
		
		if(Village_organizationData != "")
		{
		var arrVillage_organizationData = Village_organizationData.split(";");	
		
		obj_Village_organization = new Village_organization();
		obj_Village_organization.OrganizationId= arrVillage_organizationData[0];
		obj_Village_organization.VillageId= arrVillage_organizationData[1];

		
		
		}
		
	}
	
	return obj_Village_organization;
	
	
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
	

		var Elem = document.getElementById("Input_Village_organizationPrice");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Village_organization price";
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
			
		    Elem = document.getElementById("Input_Village_organizationName");
			if(Elem)
			{
				if(Elem.value =="")
				{
				Elem.focus();
				iserror =true;
				error = "Please enter Village_organization name";	
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
	
		var obj_Village_organization = new Village_organization();
		
		var OrganizationId= document.getElementById("Input_OrganizationId").value;
		var VillageId= document.getElementById("Input_VillageId").value;

		
		document.getElementById("Input_OrganizationId").value="";
		document.getElementById("Input_VillageId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_organization = new Village_organization();
		obj_Village_organization.OrganizationId= OrganizationId;
		obj_Village_organization.VillageId= VillageId;

		
		var dummyId = CreateDummyNumber();
		AddVillage_organizationPacket(dummyId,obj_Village_organization);
		UI_createVillage_organizationRow(obj_Village_organization, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_organization = new Village_organization();

		obj_Village_organization.OrganizationId= OrganizationId;
		obj_Village_organization.VillageId= VillageId;

		
		UpdateVillage_organizationPacket(obj_Village_organization);
		UI_createVillage_organizationRow(obj_Village_organization, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_organization() {
	
	UI_showAddVillage_organizationForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_organizationForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_organizationAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_organizationform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_organizationForm(obj_Village_organization) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_organizationUpdateForm(obj_Village_organization);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_organizationform"));
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
function UI_prepareVillage_organizationUpdateForm(obj_Village_organization)
{
	var arr_hidelist = new Array("Input_VillageId","Input_OrganizationId");
	var arr_showlist = new Array("Input_VillageId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationId").value=obj_Village_organization.OrganizationId;
		document.getElementById("Input_VillageId").value=obj_Village_organization.VillageId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_organizationAddForm()
{
	var arr_hidelist = new Array("Input_VillageId","Input_OrganizationId");
	var arr_showlist = new Array("Input_VillageId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_OrganizationId").value="";
		document.getElementById("Input_VillageId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_organizationToVillage_organizationList() {
	var uiVillage_organizationList = document.getElementById("Village_organizationList");

	var rowElems = uiVillage_organizationList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_organizationRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_organizationRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_organizationRowHtmlElem(obj_Village_organization,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_organizationImg_"+obj_Village_organization.VillageId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_organization/0_small.png";
	else ImgElem.src = "Village_organization/"+obj_Village_organization.VillageId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_organization.OrganizationId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_organization.VillageId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_organizationdata"+ElemId);
		ElementDataHidden.value = obj_Village_organization.getVillage_organizationData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);

		
		ElemLi= UI_createVillage_organizationRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_organizationRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_organizationRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_organizationHtmlElem(obj_Village_organization)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_organization");
		html ="<a href=\"?page=dashboard&VillageId="+obj_Village_organization.VillageId+"\">"+obj_Village_organization.VillageId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_organizationRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_organizationRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_organizationRow(obj_Village_organization, rowType,dummyId) {
	var html = "";
	
	var UiVillage_organizationList = document.getElementById("Village_organizationList");
	var ClassName = "ListRow";
	var ElemId = "Village_organizationListRow_"+obj_Village_organization.VillageId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_organizationRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_organizationRowHtmlElem(obj_Village_organization,ElemId, ClassName);
			UiVillage_organizationList.insertBefore(ElemLi, UiVillage_organizationList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_organization msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_organizationRowHtmlElem(obj_Village_organization,ElemId, ClassName);
			UiVillage_organizationList.insertBefore(ElemLi, UiVillage_organizationList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_organizationRow_"+dummyId);
			var DummyData = document.getElementById("Village_organizationdataDummyVillage_organizationRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_organizationdata"+ElemId);		
				DummyData.value = obj_Village_organization.getVillage_organizationData();		
				}
				UI_createTopbarSubVillage_organizationHtmlElem(obj_Village_organization);
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
				var ElemLi = UI_createVillage_organizationRowHtmlElem(obj_Village_organization,ElemId, ClassName);
				UiVillage_organizationList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_organizationList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, VillageId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_organizationListRow_"+VillageId);
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


