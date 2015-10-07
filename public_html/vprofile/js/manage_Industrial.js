//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Industrial_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addIndustrial(mainPacket);
			break;
		}
		case 201: {
			ACK_addIndustrial(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteIndustrial(mainPacket);
			break;
		}
		case 203: {
			ACK_updateIndustrial(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addIndustrial(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Industrial = new Industrial();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Industrial.IndustrialId= mainPacket[3];
		obj_Industrial.IndustrialName= mainPacket[4];
		obj_Industrial.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createIndustrialRow(obj_Industrial, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteIndustrial(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Industrial = new Industrial();
		
		var resultStatus = mainPacket[0];
		var IndustrialId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("IndustrialListRow_"+IndustrialId);
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
				var rowElem = document.getElementById("IndustrialListRow_"+IndustrialId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateIndustrial(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Industrial = new Industrial();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Industrial.IndustrialId= mainPacket[2];
		obj_Industrial.IndustrialName= mainPacket[3];
		obj_Industrial.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createIndustrialRow(obj_Industrial, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Industrial_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingIndustrialPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Industrial; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteIndustrialPacket(IndustrialId) {
	var deletePacketBody  = IndustrialId;

	var postpacket = createOutgoingIndustrialPacket(202,deletePacketBody);
	Industrial_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateIndustrialPacket(obj_Industrial) {
	var savePacketBody  = obj_Industrial.createIndustrialPacket();

	var postpacket = createOutgoingIndustrialPacket(203,savePacketBody);
	Industrial_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddIndustrialPacket(dummyId,obj_Industrial) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Industrial.createIndustrialPacket();

	var postpacket = createOutgoingIndustrialPacket(201,savePacketBody);
	Industrial_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onIndustrialPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onIndustrialPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addIndustrial = document.getElementById("btnaddIndustrial");
	if(addIndustrial){
	addIndustrial.addEventListener('mousedown', Event_mousedown_addIndustrial, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popIndustrialform = document.getElementById("popIndustrialform");
	var inputElems = popIndustrialform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiIndustrialList = document.getElementById("IndustrialList");
	var liElems = UiIndustrialList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverIndustrialRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutIndustrialRow, false);
		
	}
	
	var UiIndustrialListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiIndustrialListDeletebtns.length; z++) {
			UiIndustrialListDeletebtns[z].addEventListener('mousedown', Event_mouseDownIndustrialRowBtn, false);			
		
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
	UI_search_Industrial(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownIndustrialRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Industrial = Get_IndustrialByListRow(this.parentNode.parentNode);
			if(obj_Industrial != ""){
				deleteIndustrial(obj_Industrial.IndustrialId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Industrial = Get_IndustrialByListRow(this.parentNode.parentNode);
			if(obj_Industrial != ""){
				UI_showUpdateIndustrialForm(obj_Industrial);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Industrial(searchText)
{

	//IndustrialList = 
	var IndustrialListElem = document.getElementById("IndustrialList");
	
	if(IndustrialListElem)
	{
		var IndustrialDataList = IndustrialListElem.getElementsByTagName("input");
		for(var y=0 in IndustrialDataList)
		{
			if(IndustrialDataList[y])
			{
				
				
				var displayType = "none";
				var IndustrialData = IndustrialDataList[y].value;
				if(!((IndustrialData == "") || (typeof IndustrialData=="undefined")))
				{
				if(search_Industrial(IndustrialData,searchText))
				{
					displayType = "block";
				}
				IndustrialDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Industrial(IndustrialData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	IndustrialData = decodeSpText(IndustrialData.toLowerCase());
	if(IndustrialData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Industrial)
{
	if (obj_Industrial.IndustrialId) {
		var fieldDataId = obj_Industrial.IndustrialId;
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

function deleteIndustrial(IndustrialId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Industrial");
	if(flag){
			DeleteIndustrialPacket(IndustrialId);
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

function Get_IndustrialByListRow(listRowElem)
{
	
	var obj_Industrial ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var IndustrialData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				IndustrialData = elemlist[z].value;
			}		
		}
		
		if(IndustrialData != "")
		{
		var arrIndustrialData = IndustrialData.split(";");	
		
		obj_Industrial = new Industrial();
		obj_Industrial.IndustrialId= arrIndustrialData[0];
		obj_Industrial.IndustrialName= arrIndustrialData[1];
		obj_Industrial.Description= arrIndustrialData[2];

		
		
		}
		
	}
	
	return obj_Industrial;
	
	
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
	
var Elem = document.getElementById("Input_IndustrialName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Industrial Name";
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
	
		var obj_Industrial = new Industrial();
		
		var IndustrialId= document.getElementById("Input_IndustrialId").value;
		var IndustrialName= document.getElementById("Input_IndustrialName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_IndustrialId").value="";
		document.getElementById("Input_IndustrialName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Industrial = new Industrial();
		obj_Industrial.IndustrialId= IndustrialId;
		obj_Industrial.IndustrialName= IndustrialName;
		obj_Industrial.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddIndustrialPacket(dummyId,obj_Industrial);
		UI_createIndustrialRow(obj_Industrial, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Industrial = new Industrial();

		obj_Industrial.IndustrialId= IndustrialId;
		obj_Industrial.IndustrialName= IndustrialName;
		obj_Industrial.Description= Description;

		
		UpdateIndustrialPacket(obj_Industrial);
		UI_createIndustrialRow(obj_Industrial, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addIndustrial() {
	
	UI_showAddIndustrialForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddIndustrialForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareIndustrialAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popIndustrialform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateIndustrialForm(obj_Industrial) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareIndustrialUpdateForm(obj_Industrial);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popIndustrialform"));
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
function UI_prepareIndustrialUpdateForm(obj_Industrial)
{
	var arr_hidelist = new Array("Input_IndustrialId");
	var arr_showlist = new Array("Input_IndustrialName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_IndustrialId").value=obj_Industrial.IndustrialId;
		document.getElementById("Input_IndustrialName").value=obj_Industrial.IndustrialName;
		document.getElementById("Input_Description").value=obj_Industrial.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareIndustrialAddForm()
{
	var arr_hidelist = new Array("Input_IndustrialId");
	var arr_showlist = new Array("Input_IndustrialName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_IndustrialId").value="";
		document.getElementById("Input_IndustrialName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addIndustrialToIndustrialList() {
	var uiIndustrialList = document.getElementById("IndustrialList");

	var rowElems = uiIndustrialList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createIndustrialRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownIndustrialRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createIndustrialRowHtmlElem(obj_Industrial,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "IndustrialImg_"+obj_Industrial.IndustrialId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Industrial/0_small.png";
	else ImgElem.src = "Industrial/"+obj_Industrial.IndustrialId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Industrial.IndustrialId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Industrial.IndustrialName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Industrial.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Industrialdata"+ElemId);
		ElementDataHidden.value = obj_Industrial.getIndustrialData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createIndustrialRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverIndustrialRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutIndustrialRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubIndustrialHtmlElem(obj_Industrial)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subIndustrial");
		html ="<a href=\"?page=dashboard&IndustrialId="+obj_Industrial.IndustrialId+"\">"+obj_Industrial.IndustrialId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverIndustrialRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutIndustrialRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createIndustrialRow(obj_Industrial, rowType,dummyId) {
	var html = "";
	
	var UiIndustrialList = document.getElementById("IndustrialList");
	var ClassName = "ListRow";
	var ElemId = "IndustrialListRow_"+obj_Industrial.IndustrialId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyIndustrialRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createIndustrialRowHtmlElem(obj_Industrial,ElemId, ClassName);
			UiIndustrialList.insertBefore(ElemLi, UiIndustrialList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Industrial msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createIndustrialRowHtmlElem(obj_Industrial,ElemId, ClassName);
			UiIndustrialList.insertBefore(ElemLi, UiIndustrialList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyIndustrialRow_"+dummyId);
			var DummyData = document.getElementById("IndustrialdataDummyIndustrialRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Industrialdata"+ElemId);		
				DummyData.value = obj_Industrial.getIndustrialData();		
				}
				UI_createTopbarSubIndustrialHtmlElem(obj_Industrial);
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
				var ElemLi = UI_createIndustrialRowHtmlElem(obj_Industrial,ElemId, ClassName);
				UiIndustrialList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("IndustrialList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, IndustrialId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("IndustrialListRow_"+IndustrialId);
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


