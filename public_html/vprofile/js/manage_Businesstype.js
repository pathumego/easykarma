//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Businesstype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addBusinesstype(mainPacket);
			break;
		}
		case 201: {
			ACK_addBusinesstype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteBusinesstype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateBusinesstype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addBusinesstype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Businesstype = new Businesstype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Businesstype.BusinessTypeId= mainPacket[3];
		obj_Businesstype.BusinessTypeName= mainPacket[4];
		obj_Businesstype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createBusinesstypeRow(obj_Businesstype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteBusinesstype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Businesstype = new Businesstype();
		
		var resultStatus = mainPacket[0];
		var BusinessTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("BusinesstypeListRow_"+BusinessTypeId);
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
				var rowElem = document.getElementById("BusinesstypeListRow_"+BusinessTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateBusinesstype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Businesstype = new Businesstype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Businesstype.BusinessTypeId= mainPacket[2];
		obj_Businesstype.BusinessTypeName= mainPacket[3];
		obj_Businesstype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createBusinesstypeRow(obj_Businesstype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Businesstype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingBusinesstypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Businesstype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteBusinesstypePacket(BusinessTypeId) {
	var deletePacketBody  = BusinessTypeId;

	var postpacket = createOutgoingBusinesstypePacket(202,deletePacketBody);
	Businesstype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateBusinesstypePacket(obj_Businesstype) {
	var savePacketBody  = obj_Businesstype.createBusinesstypePacket();

	var postpacket = createOutgoingBusinesstypePacket(203,savePacketBody);
	Businesstype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddBusinesstypePacket(dummyId,obj_Businesstype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Businesstype.createBusinesstypePacket();

	var postpacket = createOutgoingBusinesstypePacket(201,savePacketBody);
	Businesstype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onBusinesstypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onBusinesstypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addBusinesstype = document.getElementById("btnaddBusinesstype");
	if(addBusinesstype){
	addBusinesstype.addEventListener('mousedown', Event_mousedown_addBusinesstype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popBusinesstypeform = document.getElementById("popBusinesstypeform");
	var inputElems = popBusinesstypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiBusinesstypeList = document.getElementById("BusinesstypeList");
	var liElems = UiBusinesstypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverBusinesstypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutBusinesstypeRow, false);
		
	}
	
	var UiBusinesstypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiBusinesstypeListDeletebtns.length; z++) {
			UiBusinesstypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownBusinesstypeRowBtn, false);			
		
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
	UI_search_Businesstype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownBusinesstypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Businesstype = Get_BusinesstypeByListRow(this.parentNode.parentNode);
			if(obj_Businesstype != ""){
				deleteBusinesstype(obj_Businesstype.BusinessTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Businesstype = Get_BusinesstypeByListRow(this.parentNode.parentNode);
			if(obj_Businesstype != ""){
				UI_showUpdateBusinesstypeForm(obj_Businesstype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Businesstype(searchText)
{

	//BusinesstypeList = 
	var BusinesstypeListElem = document.getElementById("BusinesstypeList");
	
	if(BusinesstypeListElem)
	{
		var BusinesstypeDataList = BusinesstypeListElem.getElementsByTagName("input");
		for(var y=0 in BusinesstypeDataList)
		{
			if(BusinesstypeDataList[y])
			{
				
				
				var displayType = "none";
				var BusinesstypeData = BusinesstypeDataList[y].value;
				if(!((BusinesstypeData == "") || (typeof BusinesstypeData=="undefined")))
				{
				if(search_Businesstype(BusinesstypeData,searchText))
				{
					displayType = "block";
				}
				BusinesstypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Businesstype(BusinesstypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	BusinesstypeData = decodeSpText(BusinesstypeData.toLowerCase());
	if(BusinesstypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Businesstype)
{
	if (obj_Businesstype.BusinessTypeId) {
		var fieldDataId = obj_Businesstype.BusinessTypeId;
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

function deleteBusinesstype(BusinessTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Businesstype");
	if(flag){
			DeleteBusinesstypePacket(BusinessTypeId);
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

function Get_BusinesstypeByListRow(listRowElem)
{
	
	var obj_Businesstype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var BusinesstypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				BusinesstypeData = elemlist[z].value;
			}		
		}
		
		if(BusinesstypeData != "")
		{
		var arrBusinesstypeData = BusinesstypeData.split(";");	
		
		obj_Businesstype = new Businesstype();
		obj_Businesstype.BusinessTypeId= arrBusinesstypeData[0];
		obj_Businesstype.BusinessTypeName= arrBusinesstypeData[1];
		obj_Businesstype.Description= arrBusinesstypeData[2];

		
		
		}
		
	}
	
	return obj_Businesstype;
	
	
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
	

		var Elem = document.getElementById("Input_BusinessTypeName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Business type";
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
	
		var obj_Businesstype = new Businesstype();
		
		var BusinessTypeId= document.getElementById("Input_BusinessTypeId").value;
		var BusinessTypeName= document.getElementById("Input_BusinessTypeName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_BusinessTypeId").value="";
		document.getElementById("Input_BusinessTypeName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Businesstype = new Businesstype();
		obj_Businesstype.BusinessTypeId= BusinessTypeId;
		obj_Businesstype.BusinessTypeName= BusinessTypeName;
		obj_Businesstype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddBusinesstypePacket(dummyId,obj_Businesstype);
		UI_createBusinesstypeRow(obj_Businesstype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Businesstype = new Businesstype();

		obj_Businesstype.BusinessTypeId= BusinessTypeId;
		obj_Businesstype.BusinessTypeName= BusinessTypeName;
		obj_Businesstype.Description= Description;

		
		UpdateBusinesstypePacket(obj_Businesstype);
		UI_createBusinesstypeRow(obj_Businesstype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addBusinesstype() {
	
	UI_showAddBusinesstypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddBusinesstypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareBusinesstypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popBusinesstypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateBusinesstypeForm(obj_Businesstype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareBusinesstypeUpdateForm(obj_Businesstype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popBusinesstypeform"));
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
function UI_prepareBusinesstypeUpdateForm(obj_Businesstype)
{
	var arr_hidelist = new Array("Input_BusinessTypeId");
	var arr_showlist = new Array("Input_BusinessTypeName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_BusinessTypeId").value=obj_Businesstype.BusinessTypeId;
		document.getElementById("Input_BusinessTypeName").value=obj_Businesstype.BusinessTypeName;
		document.getElementById("Input_Description").value=obj_Businesstype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareBusinesstypeAddForm()
{
	var arr_hidelist = new Array("Input_BusinessTypeId");
	var arr_showlist = new Array("Input_BusinessTypeName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_BusinessTypeId").value="";
		document.getElementById("Input_BusinessTypeName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addBusinesstypeToBusinesstypeList() {
	var uiBusinesstypeList = document.getElementById("BusinesstypeList");

	var rowElems = uiBusinesstypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createBusinesstypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownBusinesstypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createBusinesstypeRowHtmlElem(obj_Businesstype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "BusinesstypeImg_"+obj_Businesstype.BusinessTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Businesstype/0_small.png";
	else ImgElem.src = "Businesstype/"+obj_Businesstype.BusinessTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Businesstype.BusinessTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Businesstype.BusinessTypeName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Businesstype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Businesstypedata"+ElemId);
		ElementDataHidden.value = obj_Businesstype.getBusinesstypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createBusinesstypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverBusinesstypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutBusinesstypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubBusinesstypeHtmlElem(obj_Businesstype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subBusinesstype");
		html ="<a href=\"?page=dashboard&BusinessTypeId="+obj_Businesstype.BusinessTypeId+"\">"+obj_Businesstype.BusinessTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverBusinesstypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutBusinesstypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createBusinesstypeRow(obj_Businesstype, rowType,dummyId) {
	var html = "";
	
	var UiBusinesstypeList = document.getElementById("BusinesstypeList");
	var ClassName = "ListRow";
	var ElemId = "BusinesstypeListRow_"+obj_Businesstype.BusinessTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyBusinesstypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createBusinesstypeRowHtmlElem(obj_Businesstype,ElemId, ClassName);
			UiBusinesstypeList.insertBefore(ElemLi, UiBusinesstypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Businesstype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createBusinesstypeRowHtmlElem(obj_Businesstype,ElemId, ClassName);
			UiBusinesstypeList.insertBefore(ElemLi, UiBusinesstypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyBusinesstypeRow_"+dummyId);
			var DummyData = document.getElementById("BusinesstypedataDummyBusinesstypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Businesstypedata"+ElemId);		
				DummyData.value = obj_Businesstype.getBusinesstypeData();		
				}
				UI_createTopbarSubBusinesstypeHtmlElem(obj_Businesstype);
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
				var ElemLi = UI_createBusinesstypeRowHtmlElem(obj_Businesstype,ElemId, ClassName);
				UiBusinesstypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("BusinesstypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, BusinessTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("BusinesstypeListRow_"+BusinessTypeId);
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


