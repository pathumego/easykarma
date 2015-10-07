//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_telephone_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_telephone(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_telephone(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_telephone(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_telephone(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_telephone(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_telephone = new Person_telephone();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_telephone.PhoneId= mainPacket[3];
		obj_Person_telephone.PhoneNumber= mainPacket[4];
		obj_Person_telephone.Type= mainPacket[5];
		obj_Person_telephone.PersonId= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createPerson_telephoneRow(obj_Person_telephone, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_telephone(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_telephone = new Person_telephone();
		
		var resultStatus = mainPacket[0];
		var PhoneId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_telephoneListRow_"+PhoneId);
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
				var rowElem = document.getElementById("Person_telephoneListRow_"+PhoneId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_telephone(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_telephone = new Person_telephone();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_telephone.PhoneId= mainPacket[2];
		obj_Person_telephone.PhoneNumber= mainPacket[3];
		obj_Person_telephone.Type= mainPacket[4];
		obj_Person_telephone.PersonId= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createPerson_telephoneRow(obj_Person_telephone, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_telephone_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_telephonePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_telephone; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_telephonePacket(PhoneId) {
	var deletePacketBody  = PhoneId;

	var postpacket = createOutgoingPerson_telephonePacket(202,deletePacketBody);
	Person_telephone_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_telephonePacket(obj_Person_telephone) {
	var savePacketBody  = obj_Person_telephone.createPerson_telephonePacket();

	var postpacket = createOutgoingPerson_telephonePacket(203,savePacketBody);
	Person_telephone_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_telephonePacket(dummyId,obj_Person_telephone) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_telephone.createPerson_telephonePacket();

	var postpacket = createOutgoingPerson_telephonePacket(201,savePacketBody);
	Person_telephone_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_telephonePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_telephonePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_telephone = document.getElementById("btnaddPerson_telephone");
	if(addPerson_telephone){
	addPerson_telephone.addEventListener('mousedown', Event_mousedown_addPerson_telephone, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_telephoneform = document.getElementById("popPerson_telephoneform");
	var inputElems = popPerson_telephoneform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_telephoneList = document.getElementById("Person_telephoneList");
	var liElems = UiPerson_telephoneList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_telephoneRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_telephoneRow, false);
		
	}
	
	var UiPerson_telephoneListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_telephoneListDeletebtns.length; z++) {
			UiPerson_telephoneListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_telephoneRowBtn, false);			
		
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
	UI_search_Person_telephone(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_telephoneRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_telephone = Get_Person_telephoneByListRow(this.parentNode.parentNode);
			if(obj_Person_telephone != ""){
				deletePerson_telephone(obj_Person_telephone.PhoneId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_telephone = Get_Person_telephoneByListRow(this.parentNode.parentNode);
			if(obj_Person_telephone != ""){
				UI_showUpdatePerson_telephoneForm(obj_Person_telephone);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_telephone(searchText)
{

	//Person_telephoneList = 
	var Person_telephoneListElem = document.getElementById("Person_telephoneList");
	
	if(Person_telephoneListElem)
	{
		var Person_telephoneDataList = Person_telephoneListElem.getElementsByTagName("input");
		for(var y=0 in Person_telephoneDataList)
		{
			if(Person_telephoneDataList[y])
			{
				
				
				var displayType = "none";
				var Person_telephoneData = Person_telephoneDataList[y].value;
				if(!((Person_telephoneData == "") || (typeof Person_telephoneData=="undefined")))
				{
				if(search_Person_telephone(Person_telephoneData,searchText))
				{
					displayType = "block";
				}
				Person_telephoneDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_telephone(Person_telephoneData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_telephoneData = decodeSpText(Person_telephoneData.toLowerCase());
	if(Person_telephoneData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_telephone)
{
	if (obj_Person_telephone.PhoneId) {
		var fieldDataId = obj_Person_telephone.PhoneId;
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

function deletePerson_telephone(PhoneId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_telephone");
	if(flag){
			DeletePerson_telephonePacket(PhoneId);
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

function Get_Person_telephoneByListRow(listRowElem)
{
	
	var obj_Person_telephone ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_telephoneData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_telephoneData = elemlist[z].value;
			}		
		}
		
		if(Person_telephoneData != "")
		{
		var arrPerson_telephoneData = Person_telephoneData.split(";");	
		
		obj_Person_telephone = new Person_telephone();
		obj_Person_telephone.PhoneId= arrPerson_telephoneData[0];
		obj_Person_telephone.PhoneNumber= arrPerson_telephoneData[1];
		obj_Person_telephone.Type= arrPerson_telephoneData[2];
		obj_Person_telephone.PersonId= arrPerson_telephoneData[3];

		
		
		}
		
	}
	
	return obj_Person_telephone;
	
	
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
	
var Elem = document.getElementById("Input_PhoneNumber");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter your phone number";
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
	
		var obj_Person_telephone = new Person_telephone();
		
		var PhoneId= document.getElementById("Input_PhoneId").value;
		var PhoneNumber= document.getElementById("Input_PhoneNumber").value;
		var Type= document.getElementById("Input_Type").value;
		var PersonId= document.getElementById("Input_PersonId").value;

		
		document.getElementById("Input_PhoneId").value="";
		document.getElementById("Input_PhoneNumber").value="";
		document.getElementById("Input_Type").value="";
		document.getElementById("Input_PersonId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_telephone = new Person_telephone();
		obj_Person_telephone.PhoneId= PhoneId;
		obj_Person_telephone.PhoneNumber= PhoneNumber;
		obj_Person_telephone.Type= Type;
		obj_Person_telephone.PersonId= PersonId;

		
		var dummyId = CreateDummyNumber();
		AddPerson_telephonePacket(dummyId,obj_Person_telephone);
		UI_createPerson_telephoneRow(obj_Person_telephone, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_telephone = new Person_telephone();

		obj_Person_telephone.PhoneId= PhoneId;
		obj_Person_telephone.PhoneNumber= PhoneNumber;
		obj_Person_telephone.Type= Type;
		obj_Person_telephone.PersonId= PersonId;

		
		UpdatePerson_telephonePacket(obj_Person_telephone);
		UI_createPerson_telephoneRow(obj_Person_telephone, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_telephone() {
	
	UI_showAddPerson_telephoneForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_telephoneForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_telephoneAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_telephoneform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_telephoneForm(obj_Person_telephone) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_telephoneUpdateForm(obj_Person_telephone);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_telephoneform"));
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
function UI_preparePerson_telephoneUpdateForm(obj_Person_telephone)
{
	var arr_hidelist = new Array("Input_PhoneId","Input_PersonId");
	var arr_showlist = new Array("Input_PhoneNumber","Input_Type");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PhoneId").value=obj_Person_telephone.PhoneId;
		document.getElementById("Input_PhoneNumber").value=obj_Person_telephone.PhoneNumber;
		document.getElementById("Input_Type").value=obj_Person_telephone.Type;
		document.getElementById("Input_PersonId").value=obj_Person_telephone.PersonId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_telephoneAddForm()
{
	var arr_hidelist = new Array("Input_PhoneId","Input_PersonId");
	var arr_showlist = new Array("Input_PhoneNumber","Input_Type");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PhoneId").value="";
		document.getElementById("Input_PhoneNumber").value="";
		document.getElementById("Input_Type").value="";
		document.getElementById("Input_PersonId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_telephoneToPerson_telephoneList() {
	var uiPerson_telephoneList = document.getElementById("Person_telephoneList");

	var rowElems = uiPerson_telephoneList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_telephoneRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_telephoneRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_telephoneRowHtmlElem(obj_Person_telephone,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_telephoneImg_"+obj_Person_telephone.PhoneId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_telephone/0_small.png";
	else ImgElem.src = "Person_telephone/"+obj_Person_telephone.PhoneId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_telephone.PhoneId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_telephone.PhoneNumber;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_telephone.Type;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_telephone.PersonId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_telephonedata"+ElemId);
		ElementDataHidden.value = obj_Person_telephone.getPerson_telephoneData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createPerson_telephoneRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_telephoneRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_telephoneRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_telephoneHtmlElem(obj_Person_telephone)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_telephone");
		html ="<a href=\"?page=dashboard&PhoneId="+obj_Person_telephone.PhoneId+"\">"+obj_Person_telephone.PhoneId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_telephoneRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_telephoneRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_telephoneRow(obj_Person_telephone, rowType,dummyId) {
	var html = "";
	
	var UiPerson_telephoneList = document.getElementById("Person_telephoneList");
	var ClassName = "ListRow";
	var ElemId = "Person_telephoneListRow_"+obj_Person_telephone.PhoneId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_telephoneRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_telephoneRowHtmlElem(obj_Person_telephone,ElemId, ClassName);
			UiPerson_telephoneList.insertBefore(ElemLi, UiPerson_telephoneList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_telephone msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_telephoneRowHtmlElem(obj_Person_telephone,ElemId, ClassName);
			UiPerson_telephoneList.insertBefore(ElemLi, UiPerson_telephoneList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_telephoneRow_"+dummyId);
			var DummyData = document.getElementById("Person_telephonedataDummyPerson_telephoneRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_telephonedata"+ElemId);		
				DummyData.value = obj_Person_telephone.getPerson_telephoneData();		
				}
				UI_createTopbarSubPerson_telephoneHtmlElem(obj_Person_telephone);
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
				var ElemLi = UI_createPerson_telephoneRowHtmlElem(obj_Person_telephone,ElemId, ClassName);
				UiPerson_telephoneList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_telephoneList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, PhoneId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_telephoneListRow_"+PhoneId);
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


