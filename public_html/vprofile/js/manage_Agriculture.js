//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Agriculture_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addAgriculture(mainPacket);
			break;
		}
		case 201: {
			ACK_addAgriculture(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteAgriculture(mainPacket);
			break;
		}
		case 203: {
			ACK_updateAgriculture(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addAgriculture(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Agriculture = new Agriculture();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Agriculture.AgricultureId= mainPacket[3];
		obj_Agriculture.AgricultureName= mainPacket[4];
		obj_Agriculture.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createAgricultureRow(obj_Agriculture, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteAgriculture(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Agriculture = new Agriculture();
		
		var resultStatus = mainPacket[0];
		var AgricultureId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("AgricultureListRow_"+AgricultureId);
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
				var rowElem = document.getElementById("AgricultureListRow_"+AgricultureId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateAgriculture(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Agriculture = new Agriculture();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Agriculture.AgricultureId= mainPacket[2];
		obj_Agriculture.AgricultureName= mainPacket[3];
		obj_Agriculture.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createAgricultureRow(obj_Agriculture, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Agriculture_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingAgriculturePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Agriculture; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteAgriculturePacket(AgricultureId) {
	var deletePacketBody  = AgricultureId;

	var postpacket = createOutgoingAgriculturePacket(202,deletePacketBody);
	Agriculture_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateAgriculturePacket(obj_Agriculture) {
	var savePacketBody  = obj_Agriculture.createAgriculturePacket();

	var postpacket = createOutgoingAgriculturePacket(203,savePacketBody);
	Agriculture_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddAgriculturePacket(dummyId,obj_Agriculture) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Agriculture.createAgriculturePacket();

	var postpacket = createOutgoingAgriculturePacket(201,savePacketBody);
	Agriculture_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onAgriculturePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onAgriculturePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addAgriculture = document.getElementById("btnaddAgriculture");
	if(addAgriculture){
	addAgriculture.addEventListener('mousedown', Event_mousedown_addAgriculture, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popAgricultureform = document.getElementById("popAgricultureform");
	var inputElems = popAgricultureform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiAgricultureList = document.getElementById("AgricultureList");
	var liElems = UiAgricultureList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverAgricultureRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutAgricultureRow, false);
		
	}
	
	var UiAgricultureListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiAgricultureListDeletebtns.length; z++) {
			UiAgricultureListDeletebtns[z].addEventListener('mousedown', Event_mouseDownAgricultureRowBtn, false);			
		
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
	UI_search_Agriculture(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownAgricultureRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Agriculture = Get_AgricultureByListRow(this.parentNode.parentNode);
			if(obj_Agriculture != ""){
				deleteAgriculture(obj_Agriculture.AgricultureId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Agriculture = Get_AgricultureByListRow(this.parentNode.parentNode);
			if(obj_Agriculture != ""){
				UI_showUpdateAgricultureForm(obj_Agriculture);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Agriculture(searchText)
{

	//AgricultureList = 
	var AgricultureListElem = document.getElementById("AgricultureList");
	
	if(AgricultureListElem)
	{
		var AgricultureDataList = AgricultureListElem.getElementsByTagName("input");
		for(var y=0 in AgricultureDataList)
		{
			if(AgricultureDataList[y])
			{
				
				
				var displayType = "none";
				var AgricultureData = AgricultureDataList[y].value;
				if(!((AgricultureData == "") || (typeof AgricultureData=="undefined")))
				{
				if(search_Agriculture(AgricultureData,searchText))
				{
					displayType = "block";
				}
				AgricultureDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Agriculture(AgricultureData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	AgricultureData = decodeSpText(AgricultureData.toLowerCase());
	if(AgricultureData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Agriculture)
{
	if (obj_Agriculture.AgricultureId) {
		var fieldDataId = obj_Agriculture.AgricultureId;
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

function deleteAgriculture(AgricultureId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Agriculture");
	if(flag){
			DeleteAgriculturePacket(AgricultureId);
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

function Get_AgricultureByListRow(listRowElem)
{
	
	var obj_Agriculture ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var AgricultureData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				AgricultureData = elemlist[z].value;
			}		
		}
		
		if(AgricultureData != "")
		{
		var arrAgricultureData = AgricultureData.split(";");	
		
		obj_Agriculture = new Agriculture();
		obj_Agriculture.AgricultureId= arrAgricultureData[0];
		obj_Agriculture.AgricultureName= arrAgricultureData[1];
		obj_Agriculture.Description= arrAgricultureData[2];

		
		
		}
		
	}
	
	return obj_Agriculture;
	
	
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
	

		var Elem = document.getElementById("Input_AgricultureName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Agriculture Name";
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
	
		var obj_Agriculture = new Agriculture();
		
		var AgricultureId= document.getElementById("Input_AgricultureId").value;
		var AgricultureName= document.getElementById("Input_AgricultureName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_AgricultureId").value="";
		document.getElementById("Input_AgricultureName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Agriculture = new Agriculture();
		obj_Agriculture.AgricultureId= AgricultureId;
		obj_Agriculture.AgricultureName= AgricultureName;
		obj_Agriculture.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddAgriculturePacket(dummyId,obj_Agriculture);
		UI_createAgricultureRow(obj_Agriculture, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Agriculture = new Agriculture();

		obj_Agriculture.AgricultureId= AgricultureId;
		obj_Agriculture.AgricultureName= AgricultureName;
		obj_Agriculture.Description= Description;

		
		UpdateAgriculturePacket(obj_Agriculture);
		UI_createAgricultureRow(obj_Agriculture, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addAgriculture() {
	
	UI_showAddAgricultureForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddAgricultureForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareAgricultureAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popAgricultureform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateAgricultureForm(obj_Agriculture) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareAgricultureUpdateForm(obj_Agriculture);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popAgricultureform"));
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
function UI_prepareAgricultureUpdateForm(obj_Agriculture)
{
	var arr_hidelist = new Array("Input_AgricultureId");
	var arr_showlist = new Array("Input_AgricultureName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_AgricultureId").value=obj_Agriculture.AgricultureId;
		document.getElementById("Input_AgricultureName").value=obj_Agriculture.AgricultureName;
		document.getElementById("Input_Description").value=obj_Agriculture.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareAgricultureAddForm()
{
	var arr_hidelist = new Array("Input_AgricultureId");
	var arr_showlist = new Array("Input_AgricultureName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_AgricultureId").value="";
		document.getElementById("Input_AgricultureName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addAgricultureToAgricultureList() {
	var uiAgricultureList = document.getElementById("AgricultureList");

	var rowElems = uiAgricultureList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createAgricultureRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownAgricultureRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createAgricultureRowHtmlElem(obj_Agriculture,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "AgricultureImg_"+obj_Agriculture.AgricultureId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Agriculture/0_small.png";
	else ImgElem.src = "Agriculture/"+obj_Agriculture.AgricultureId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Agriculture.AgricultureId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Agriculture.AgricultureName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Agriculture.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Agriculturedata"+ElemId);
		ElementDataHidden.value = obj_Agriculture.getAgricultureData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createAgricultureRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverAgricultureRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutAgricultureRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubAgricultureHtmlElem(obj_Agriculture)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subAgriculture");
		html ="<a href=\"?page=dashboard&AgricultureId="+obj_Agriculture.AgricultureId+"\">"+obj_Agriculture.AgricultureId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverAgricultureRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutAgricultureRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createAgricultureRow(obj_Agriculture, rowType,dummyId) {
	var html = "";
	
	var UiAgricultureList = document.getElementById("AgricultureList");
	var ClassName = "ListRow";
	var ElemId = "AgricultureListRow_"+obj_Agriculture.AgricultureId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyAgricultureRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createAgricultureRowHtmlElem(obj_Agriculture,ElemId, ClassName);
			UiAgricultureList.insertBefore(ElemLi, UiAgricultureList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Agriculture msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createAgricultureRowHtmlElem(obj_Agriculture,ElemId, ClassName);
			UiAgricultureList.insertBefore(ElemLi, UiAgricultureList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyAgricultureRow_"+dummyId);
			var DummyData = document.getElementById("AgriculturedataDummyAgricultureRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Agriculturedata"+ElemId);		
				DummyData.value = obj_Agriculture.getAgricultureData();		
				}
				UI_createTopbarSubAgricultureHtmlElem(obj_Agriculture);
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
				var ElemLi = UI_createAgricultureRowHtmlElem(obj_Agriculture,ElemId, ClassName);
				UiAgricultureList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("AgricultureList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, AgricultureId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("AgricultureListRow_"+AgricultureId);
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


