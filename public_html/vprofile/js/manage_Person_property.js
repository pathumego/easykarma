//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Person_property_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPerson_property(mainPacket);
			break;
		}
		case 201: {
			ACK_addPerson_property(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePerson_property(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePerson_property(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPerson_property(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Person_property = new Person_property();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Person_property.PropertyId= mainPacket[3];
		obj_Person_property.PropertyName= mainPacket[4];
		obj_Person_property.PropertyType= mainPacket[5];
		obj_Person_property.AssessValue= mainPacket[6];
		obj_Person_property.Description= mainPacket[7];



		if (resultStatus == 1) {	
			
			UI_createPerson_propertyRow(obj_Person_property, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePerson_property(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_property = new Person_property();
		
		var resultStatus = mainPacket[0];
		var PropertyId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Person_propertyListRow_"+PropertyId);
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
				var rowElem = document.getElementById("Person_propertyListRow_"+PropertyId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePerson_property(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Person_property = new Person_property();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Person_property.PropertyId= mainPacket[2];
		obj_Person_property.PropertyName= mainPacket[3];
		obj_Person_property.PropertyType= mainPacket[4];
		obj_Person_property.AssessValue= mainPacket[5];
		obj_Person_property.Description= mainPacket[6];


		if (resultStatus == 1) {			
			UI_createPerson_propertyRow(obj_Person_property, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Person_property_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPerson_propertyPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Person_property; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePerson_propertyPacket(PropertyId) {
	var deletePacketBody  = PropertyId;

	var postpacket = createOutgoingPerson_propertyPacket(202,deletePacketBody);
	Person_property_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePerson_propertyPacket(obj_Person_property) {
	var savePacketBody  = obj_Person_property.createPerson_propertyPacket();

	var postpacket = createOutgoingPerson_propertyPacket(203,savePacketBody);
	Person_property_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPerson_propertyPacket(dummyId,obj_Person_property) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Person_property.createPerson_propertyPacket();

	var postpacket = createOutgoingPerson_propertyPacket(201,savePacketBody);
	Person_property_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPerson_propertyPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPerson_propertyPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPerson_property = document.getElementById("btnaddPerson_property");
	if(addPerson_property){
	addPerson_property.addEventListener('mousedown', Event_mousedown_addPerson_property, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPerson_propertyform = document.getElementById("popPerson_propertyform");
	var inputElems = popPerson_propertyform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPerson_propertyList = document.getElementById("Person_propertyList");
	var liElems = UiPerson_propertyList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPerson_propertyRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPerson_propertyRow, false);
		
	}
	
	var UiPerson_propertyListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPerson_propertyListDeletebtns.length; z++) {
			UiPerson_propertyListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPerson_propertyRowBtn, false);			
		
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
	UI_search_Person_property(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPerson_propertyRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Person_property = Get_Person_propertyByListRow(this.parentNode.parentNode);
			if(obj_Person_property != ""){
				deletePerson_property(obj_Person_property.PropertyId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Person_property = Get_Person_propertyByListRow(this.parentNode.parentNode);
			if(obj_Person_property != ""){
				UI_showUpdatePerson_propertyForm(obj_Person_property);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Person_property(searchText)
{

	//Person_propertyList = 
	var Person_propertyListElem = document.getElementById("Person_propertyList");
	
	if(Person_propertyListElem)
	{
		var Person_propertyDataList = Person_propertyListElem.getElementsByTagName("input");
		for(var y=0 in Person_propertyDataList)
		{
			if(Person_propertyDataList[y])
			{
				
				
				var displayType = "none";
				var Person_propertyData = Person_propertyDataList[y].value;
				if(!((Person_propertyData == "") || (typeof Person_propertyData=="undefined")))
				{
				if(search_Person_property(Person_propertyData,searchText))
				{
					displayType = "block";
				}
				Person_propertyDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Person_property(Person_propertyData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Person_propertyData = decodeSpText(Person_propertyData.toLowerCase());
	if(Person_propertyData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Person_property)
{
	if (obj_Person_property.PropertyId) {
		var fieldDataId = obj_Person_property.PropertyId;
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

function deletePerson_property(PropertyId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Person_property");
	if(flag){
			DeletePerson_propertyPacket(PropertyId);
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

function Get_Person_propertyByListRow(listRowElem)
{
	
	var obj_Person_property ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Person_propertyData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Person_propertyData = elemlist[z].value;
			}		
		}
		
		if(Person_propertyData != "")
		{
		var arrPerson_propertyData = Person_propertyData.split(";");	
		
		obj_Person_property = new Person_property();
		obj_Person_property.PropertyId= arrPerson_propertyData[0];
		obj_Person_property.PropertyName= arrPerson_propertyData[1];
		obj_Person_property.PropertyType= arrPerson_propertyData[2];
		obj_Person_property.AssessValue= arrPerson_propertyData[3];
		obj_Person_property.Description= arrPerson_propertyData[4];

		
		
		}
		
	}
	
	return obj_Person_property;
	
	
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
	

			var Elem = document.getElementById("Input_PropertyName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the property name";
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
	
		var obj_Person_property = new Person_property();
		
		var PropertyId= document.getElementById("Input_PropertyId").value;
		var PropertyName= document.getElementById("Input_PropertyName").value;
		var PropertyType= document.getElementById("Input_PropertyType").value;
		var AssessValue= document.getElementById("Input_AssessValue").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_PropertyId").value="";
		document.getElementById("Input_PropertyName").value="";
		document.getElementById("Input_PropertyType").value="";
		document.getElementById("Input_AssessValue").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Person_property = new Person_property();
		obj_Person_property.PropertyId= PropertyId;
		obj_Person_property.PropertyName= PropertyName;
		obj_Person_property.PropertyType= PropertyType;
		obj_Person_property.AssessValue= AssessValue;
		obj_Person_property.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddPerson_propertyPacket(dummyId,obj_Person_property);
		UI_createPerson_propertyRow(obj_Person_property, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Person_property = new Person_property();

		obj_Person_property.PropertyId= PropertyId;
		obj_Person_property.PropertyName= PropertyName;
		obj_Person_property.PropertyType= PropertyType;
		obj_Person_property.AssessValue= AssessValue;
		obj_Person_property.Description= Description;

		
		UpdatePerson_propertyPacket(obj_Person_property);
		UI_createPerson_propertyRow(obj_Person_property, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPerson_property() {
	
	UI_showAddPerson_propertyForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPerson_propertyForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_propertyAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_propertyform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePerson_propertyForm(obj_Person_property) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePerson_propertyUpdateForm(obj_Person_property);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPerson_propertyform"));
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
function UI_preparePerson_propertyUpdateForm(obj_Person_property)
{
	var arr_hidelist = new Array("Input_PropertyId");
	var arr_showlist = new Array("Input_PropertyName","Input_PropertyType","Input_AssessValue","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PropertyId").value=obj_Person_property.PropertyId;
		document.getElementById("Input_PropertyName").value=obj_Person_property.PropertyName;
		document.getElementById("Input_PropertyType").value=obj_Person_property.PropertyType;
		document.getElementById("Input_AssessValue").value=obj_Person_property.AssessValue;
		document.getElementById("Input_Description").value=obj_Person_property.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePerson_propertyAddForm()
{
	var arr_hidelist = new Array("Input_PropertyId");
	var arr_showlist = new Array("Input_PropertyName","Input_PropertyType","Input_AssessValue","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PropertyId").value="";
		document.getElementById("Input_PropertyName").value="";
		document.getElementById("Input_PropertyType").value="";
		document.getElementById("Input_AssessValue").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPerson_propertyToPerson_propertyList() {
	var uiPerson_propertyList = document.getElementById("Person_propertyList");

	var rowElems = uiPerson_propertyList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_propertyRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPerson_propertyRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_propertyRowHtmlElem(obj_Person_property,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Person_propertyImg_"+obj_Person_property.PropertyId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Person_property/0_small.png";
	else ImgElem.src = "Person_property/"+obj_Person_property.PropertyId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Person_property.PropertyId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Person_property.PropertyName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Person_property.PropertyType;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Person_property.AssessValue;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Person_property.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Person_propertydata"+ElemId);
		ElementDataHidden.value = obj_Person_property.getPerson_propertyData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);

		
		ElemLi= UI_createPerson_propertyRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPerson_propertyRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPerson_propertyRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPerson_propertyHtmlElem(obj_Person_property)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPerson_property");
		html ="<a href=\"?page=dashboard&PropertyId="+obj_Person_property.PropertyId+"\">"+obj_Person_property.PropertyId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPerson_propertyRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPerson_propertyRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPerson_propertyRow(obj_Person_property, rowType,dummyId) {
	var html = "";
	
	var UiPerson_propertyList = document.getElementById("Person_propertyList");
	var ClassName = "ListRow";
	var ElemId = "Person_propertyListRow_"+obj_Person_property.PropertyId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPerson_propertyRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPerson_propertyRowHtmlElem(obj_Person_property,ElemId, ClassName);
			UiPerson_propertyList.insertBefore(ElemLi, UiPerson_propertyList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Person_property msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPerson_propertyRowHtmlElem(obj_Person_property,ElemId, ClassName);
			UiPerson_propertyList.insertBefore(ElemLi, UiPerson_propertyList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPerson_propertyRow_"+dummyId);
			var DummyData = document.getElementById("Person_propertydataDummyPerson_propertyRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Person_propertydata"+ElemId);		
				DummyData.value = obj_Person_property.getPerson_propertyData();		
				}
				UI_createTopbarSubPerson_propertyHtmlElem(obj_Person_property);
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
				var ElemLi = UI_createPerson_propertyRowHtmlElem(obj_Person_property,ElemId, ClassName);
				UiPerson_propertyList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Person_propertyList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, PropertyId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Person_propertyListRow_"+PropertyId);
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


