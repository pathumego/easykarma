//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_address_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_address(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_address(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_address(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_address(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_address(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_address = new Person_address();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_address.AddressId= mainPacket[3];
		obj_Person_address.Address= mainPacket[4];
		obj_Person_address.AddressType= mainPacket[5];
		obj_Person_address.VillageId= mainPacket[6];
		obj_Person_address.PersonId= mainPacket[7];



		if (resultStatus == 1) {	
			
			UI_createPerson_addressRow(obj_Person_address, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_address(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_address = new Person_address();
		
		var resultStatus = mainPacket[0];
		var AddressId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_addressListRow_"+AddressId);
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
				var rowElem = document.getElementById("Person_addressListRow_"+AddressId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_address(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_address = new Person_address();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_address.AddressId= mainPacket[2];
		obj_Person_address.Address= mainPacket[3];
		obj_Person_address.AddressType= mainPacket[4];
		obj_Person_address.VillageId= mainPacket[5];
		obj_Person_address.PersonId= mainPacket[6];


		if (resultStatus == 1) {			
			UI_createPerson_addressRow(obj_Person_address, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_address_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_addressPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_address; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_addressPacket(AddressId) {
	var deletePacketBody  = AddressId;

	var postpacket = createOutgoingPerson_addressPacket(202,deletePacketBody);
	Person_address_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_addressPacket(obj_Person_address) {
	var savePacketBody  = obj_Person_address.createPerson_addressPacket();

	var postpacket = createOutgoingPerson_addressPacket(203,savePacketBody);
	Person_address_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_addressPacket(dummyId,obj_Person_address) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_address.createPerson_addressPacket();

	var postpacket = createOutgoingPerson_addressPacket(201,savePacketBody);
	Person_address_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_addressPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_addressPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_address = document.getElementById("btnaddPerson_address");
	if(addPerson_address){
	addPerson_address.addEventListener('mousedown', Event_mousedown_addPerson_address, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_addressform = document.getElementById("popPerson_addressform");
	var inputElems = popPerson_addressform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_addressList = document.getElementById("Person_addressList");
	var liElems = UiPerson_addressList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_addressRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_addressRow, false);
		
	}
	
	var UiPerson_addressListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_addressListDeletebtns.length; z++) {
			UiPerson_addressListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_addressRowBtn, false);			
		
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
	UI_search_Person_address(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_addressRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_address = Get_Person_addressByListRow(this.parentNode.parentNode);
			if(obj_Person_address != ""){
				deletePerson_address(obj_Person_address.AddressId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_address = Get_Person_addressByListRow(this.parentNode.parentNode);
			if(obj_Person_address != ""){
				UI_showUpdatePerson_addressForm(obj_Person_address);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_address(searchText)
{

	//Person_addressList = 
	var Person_addressListElem = document.getElementById("Person_addressList");
	
	if(Person_addressListElem)
	{
		var Person_addressDataList = Person_addressListElem.getElementsByTagName("input");
		for(var y=0 in Person_addressDataList)
		{
			if(Person_addressDataList[y])
			{
				
				
				var displayType = "none";
				var Person_addressData = Person_addressDataList[y].value;
				if(!((Person_addressData == "") || (typeof Person_addressData=="undefined")))
				{
				if(search_Person_address(Person_addressData,searchText))
				{
					displayType = "block";
				}
				Person_addressDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_address(Person_addressData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_addressData = decodeSpText(Person_addressData.toLowerCase());
	if(Person_addressData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_address)
{
	if (obj_Person_address.AddressId) {
		var fieldDataId = obj_Person_address.AddressId;
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

function deletePerson_address(AddressId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_address");
	if(flag){
			DeletePerson_addressPacket(AddressId);
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

function Get_Person_addressByListRow(listRowElem)
{
	
	var obj_Person_address ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_addressData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_addressData = elemlist[z].value;
			}		
		}
		
		if(Person_addressData != "")
		{
		var arrPerson_addressData = Person_addressData.split(";");	
		
		obj_Person_address = new Person_address();
		obj_Person_address.AddressId= arrPerson_addressData[0];
		obj_Person_address.Address= arrPerson_addressData[1];
		obj_Person_address.AddressType= arrPerson_addressData[2];
		obj_Person_address.VillageId= arrPerson_addressData[3];
		obj_Person_address.PersonId= arrPerson_addressData[4];

		
		
		}
		
	}
	
	return obj_Person_address;
	
	
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
	
var Elem = document.getElementById("Input_Address");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Adress";
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
	
		var obj_Person_address = new Person_address();
		
		var AddressId= document.getElementById("Input_AddressId").value;
		var Address= document.getElementById("Input_Address").value;
		var AddressType= document.getElementById("Input_AddressType").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var PersonId= document.getElementById("Input_PersonId").value;

		
		document.getElementById("Input_AddressId").value="";
		document.getElementById("Input_Address").value="";
		document.getElementById("Input_AddressType").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_PersonId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_address = new Person_address();
		obj_Person_address.AddressId= AddressId;
		obj_Person_address.Address= Address;
		obj_Person_address.AddressType= AddressType;
		obj_Person_address.VillageId= VillageId;
		obj_Person_address.PersonId= PersonId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_addressPacket(dummyId,obj_Person_address);
		UI_createPerson_addressRow(obj_Person_address, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_address = new Person_address();

		obj_Person_address.AddressId= AddressId;
		obj_Person_address.Address= Address;
		obj_Person_address.AddressType= AddressType;
		obj_Person_address.VillageId= VillageId;
		obj_Person_address.PersonId= PersonId;

		
		UpdatePerson_addressPacket(obj_Person_address);
		UI_createPerson_addressRow(obj_Person_address, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_address() {
	
	UI_showAddPerson_addressForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_addressForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_addressAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_addressform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_addressForm(obj_Person_address) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_addressUpdateForm(obj_Person_address);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_addressform"));
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
function UI_preparePerson_addressUpdateForm(obj_Person_address)
{
	var arr_hidelist = new Array("Input_AddressId","Input_PersonId");
	var arr_showlist = new Array("Input_Address","Input_AddressType","Input_VillageId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_AddressId").value=obj_Person_address.AddressId;
		document.getElementById("Input_Address").value=obj_Person_address.Address;
		document.getElementById("Input_AddressType").value=obj_Person_address.AddressType;
		document.getElementById("Input_VillageId").value=obj_Person_address.VillageId;
		document.getElementById("Input_PersonId").value=obj_Person_address.PersonId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_addressAddForm()
{
	var arr_hidelist = new Array("Input_AddressId","Input_VillageId","Input_PersonId");
	var arr_showlist = new Array("Input_Address","Input_AddressType");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_AddressId").value="";
		document.getElementById("Input_Address").value="";
		document.getElementById("Input_AddressType").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_PersonId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_addressToPerson_addressList() {
	var uiPerson_addressList = document.getElementById("Person_addressList");

	var rowElems = uiPerson_addressList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_addressRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_addressRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_addressRowHtmlElem(obj_Person_address,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_addressImg_"+obj_Person_address.AddressId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_address/0_small.png";
	else ImgElem.src = "Person_address/"+obj_Person_address.AddressId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_address.AddressId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_address.Address;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_address.AddressType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_address.VillageId;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_address.PersonId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_addressdata"+ElemId);
		ElementDataHidden.value = obj_Person_address.getPerson_addressData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);

		
		ElemLi= UI_createPerson_addressRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_addressRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_addressRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_addressHtmlElem(obj_Person_address)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_address");
		html ="<a href=\"?page=dashboard&AddressId="+obj_Person_address.AddressId+"\">"+obj_Person_address.AddressId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_addressRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_addressRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_addressRow(obj_Person_address, rowType,dummyId) {
	var html = "";
	
	var UiPerson_addressList = document.getElementById("Person_addressList");
	var ClassName = "ListRow";
	var ElemId = "Person_addressListRow_"+obj_Person_address.AddressId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_addressRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_addressRowHtmlElem(obj_Person_address,ElemId, ClassName);
			UiPerson_addressList.insertBefore(ElemLi, UiPerson_addressList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_address msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_addressRowHtmlElem(obj_Person_address,ElemId, ClassName);
			UiPerson_addressList.insertBefore(ElemLi, UiPerson_addressList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_addressRow_"+dummyId);
			var DummyData = document.getElementById("Person_addressdataDummyPerson_addressRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_addressdata"+ElemId);		
				DummyData.value = obj_Person_address.getPerson_addressData();		
				}
				UI_createTopbarSubPerson_addressHtmlElem(obj_Person_address);
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
				var ElemLi = UI_createPerson_addressRowHtmlElem(obj_Person_address,ElemId, ClassName);
				UiPerson_addressList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_addressList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, AddressId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_addressListRow_"+AddressId);
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


