//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_neartowns_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_neartowns(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_neartowns(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_neartowns(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_neartowns(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_neartowns(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_neartowns = new Village_neartowns();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_neartowns.VillageId= mainPacket[3];
		obj_Village_neartowns.TownId= mainPacket[4];
		obj_Village_neartowns.Distance= mainPacket[5];
		obj_Village_neartowns.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_neartownsRow(obj_Village_neartowns, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_neartowns(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_neartowns = new Village_neartowns();
		
		var resultStatus = mainPacket[0];
		var TownId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_neartownsListRow_"+TownId);
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
				var rowElem = document.getElementById("Village_neartownsListRow_"+TownId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_neartowns(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_neartowns = new Village_neartowns();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_neartowns.VillageId= mainPacket[2];
		obj_Village_neartowns.TownId= mainPacket[3];
		obj_Village_neartowns.Distance= mainPacket[4];
		obj_Village_neartowns.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_neartownsRow(obj_Village_neartowns, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_neartowns_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_neartownsPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_neartowns; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_neartownsPacket(TownId) {
	var deletePacketBody  = TownId;

	var postpacket = createOutgoingVillage_neartownsPacket(202,deletePacketBody);
	Village_neartowns_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_neartownsPacket(obj_Village_neartowns) {
	var savePacketBody  = obj_Village_neartowns.createVillage_neartownsPacket();

	var postpacket = createOutgoingVillage_neartownsPacket(203,savePacketBody);
	Village_neartowns_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_neartownsPacket(dummyId,obj_Village_neartowns) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_neartowns.createVillage_neartownsPacket();

	var postpacket = createOutgoingVillage_neartownsPacket(201,savePacketBody);
	Village_neartowns_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_neartownsPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_neartownsPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_neartowns = document.getElementById("btnaddVillage_neartowns");
	if(addVillage_neartowns){
	addVillage_neartowns.addEventListener('mousedown', Event_mousedown_addVillage_neartowns, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_neartownsform = document.getElementById("popVillage_neartownsform");
	var inputElems = popVillage_neartownsform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_neartownsList = document.getElementById("Village_neartownsList");
	var liElems = UiVillage_neartownsList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_neartownsRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_neartownsRow, false);
		
	}
	
	var UiVillage_neartownsListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_neartownsListDeletebtns.length; z++) {
			UiVillage_neartownsListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_neartownsRowBtn, false);			
		
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
		global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_TownId","TownName",41); //town
	
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
	UI_search_Village_neartowns(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_neartownsRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_neartowns = Get_Village_neartownsByListRow(this.parentNode.parentNode);
			if(obj_Village_neartowns != ""){
				deleteVillage_neartowns(obj_Village_neartowns.TownId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_neartowns = Get_Village_neartownsByListRow(this.parentNode.parentNode);
			if(obj_Village_neartowns != ""){
				UI_showUpdateVillage_neartownsForm(obj_Village_neartowns);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_neartowns(searchText)
{

	//Village_neartownsList = 
	var Village_neartownsListElem = document.getElementById("Village_neartownsList");
	
	if(Village_neartownsListElem)
	{
		var Village_neartownsDataList = Village_neartownsListElem.getElementsByTagName("input");
		for(var y=0 in Village_neartownsDataList)
		{
			if(Village_neartownsDataList[y])
			{
				
				
				var displayType = "none";
				var Village_neartownsData = Village_neartownsDataList[y].value;
				if(!((Village_neartownsData == "") || (typeof Village_neartownsData=="undefined")))
				{
				if(search_Village_neartowns(Village_neartownsData,searchText))
				{
					displayType = "block";
				}
				Village_neartownsDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_neartowns(Village_neartownsData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_neartownsData = decodeSpText(Village_neartownsData.toLowerCase());
	if(Village_neartownsData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_neartowns)
{
	if (obj_Village_neartowns.TownId) {
		var fieldDataId = obj_Village_neartowns.TownId;
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

function deleteVillage_neartowns(TownId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_neartowns");
	if(flag){
			DeleteVillage_neartownsPacket(TownId);
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

function Get_Village_neartownsByListRow(listRowElem)
{
	
	var obj_Village_neartowns ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_neartownsData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_neartownsData = elemlist[z].value;
			}		
		}
		
		if(Village_neartownsData != "")
		{
		var arrVillage_neartownsData = Village_neartownsData.split(";");	
		
		obj_Village_neartowns = new Village_neartowns();
		obj_Village_neartowns.VillageId= arrVillage_neartownsData[0];
		obj_Village_neartowns.TownId= arrVillage_neartownsData[1];
		obj_Village_neartowns.Distance= arrVillage_neartownsData[2];
		obj_Village_neartowns.Description= arrVillage_neartownsData[3];

		
		
		}
		
	}
	
	return obj_Village_neartowns;
	
	
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
	
			var Elem = document.getElementById("Input_Description");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Description";
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
	
		var obj_Village_neartowns = new Village_neartowns();
		
		var VillageId= document.getElementById("Input_VillageId").value;
		var TownId= document.getElementById("Input_TownId").value;
		var Distance= document.getElementById("Input_Distance").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_TownId").value="";
		document.getElementById("Input_Distance").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_neartowns = new Village_neartowns();
		obj_Village_neartowns.VillageId= VillageId;
		obj_Village_neartowns.TownId= TownId;
		obj_Village_neartowns.Distance= Distance;
		obj_Village_neartowns.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_neartownsPacket(dummyId,obj_Village_neartowns);
		UI_createVillage_neartownsRow(obj_Village_neartowns, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_neartowns = new Village_neartowns();

		obj_Village_neartowns.VillageId= VillageId;
		obj_Village_neartowns.TownId= TownId;
		obj_Village_neartowns.Distance= Distance;
		obj_Village_neartowns.Description= Description;

		
		UpdateVillage_neartownsPacket(obj_Village_neartowns);
		UI_createVillage_neartownsRow(obj_Village_neartowns, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_neartowns() {
	
	UI_showAddVillage_neartownsForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_neartownsForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_neartownsAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_neartownsform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_neartownsForm(obj_Village_neartowns) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_neartownsUpdateForm(obj_Village_neartowns);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_neartownsform"));
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
function UI_prepareVillage_neartownsUpdateForm(obj_Village_neartowns)
{
	var arr_hidelist = new Array("Input_TownId","Input_VillageId");
	var arr_showlist = new Array("Input_Distance","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VillageId").value=obj_Village_neartowns.VillageId;
		document.getElementById("Input_TownId").value=obj_Village_neartowns.TownId;
		document.getElementById("Input_Distance").value=obj_Village_neartowns.Distance;
		document.getElementById("Input_Description").value=obj_Village_neartowns.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_neartownsAddForm()
{
	var arr_hidelist = new Array("Input_TownId","Input_VillageId");
	var arr_showlist = new Array("Input_Distance","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_TownId").value="";
		document.getElementById("Input_Distance").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_neartownsToVillage_neartownsList() {
	var uiVillage_neartownsList = document.getElementById("Village_neartownsList");

	var rowElems = uiVillage_neartownsList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_neartownsRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_neartownsRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_neartownsRowHtmlElem(obj_Village_neartowns,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_neartownsImg_"+obj_Village_neartowns.TownId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_neartowns/0_small.png";
	else ImgElem.src = "Village_neartowns/"+obj_Village_neartowns.TownId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_neartowns.VillageId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_neartowns.TownId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_neartowns.Distance;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_neartowns.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_neartownsdata"+ElemId);
		ElementDataHidden.value = obj_Village_neartowns.getVillage_neartownsData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_neartownsRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_neartownsRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_neartownsRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_neartownsHtmlElem(obj_Village_neartowns)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_neartowns");
		html ="<a href=\"?page=dashboard&TownId="+obj_Village_neartowns.TownId+"\">"+obj_Village_neartowns.TownId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_neartownsRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_neartownsRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_neartownsRow(obj_Village_neartowns, rowType,dummyId) {
	var html = "";
	
	var UiVillage_neartownsList = document.getElementById("Village_neartownsList");
	var ClassName = "ListRow";
	var ElemId = "Village_neartownsListRow_"+obj_Village_neartowns.TownId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_neartownsRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_neartownsRowHtmlElem(obj_Village_neartowns,ElemId, ClassName);
			UiVillage_neartownsList.insertBefore(ElemLi, UiVillage_neartownsList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_neartowns msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_neartownsRowHtmlElem(obj_Village_neartowns,ElemId, ClassName);
			UiVillage_neartownsList.insertBefore(ElemLi, UiVillage_neartownsList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_neartownsRow_"+dummyId);
			var DummyData = document.getElementById("Village_neartownsdataDummyVillage_neartownsRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_neartownsdata"+ElemId);		
				DummyData.value = obj_Village_neartowns.getVillage_neartownsData();		
				}
				UI_createTopbarSubVillage_neartownsHtmlElem(obj_Village_neartowns);
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
				var ElemLi = UI_createVillage_neartownsRowHtmlElem(obj_Village_neartowns,ElemId, ClassName);
				UiVillage_neartownsList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_neartownsList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, TownId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_neartownsListRow_"+TownId);
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


