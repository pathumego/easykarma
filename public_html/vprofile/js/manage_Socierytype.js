//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Socierytype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addSocierytype(mainPacket);
			break;
		}
		case 201: {
			ACK_addSocierytype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteSocierytype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateSocierytype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addSocierytype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Socierytype = new Socierytype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Socierytype.SocieryTypeId= mainPacket[3];
		obj_Socierytype.SocieryTypeName= mainPacket[4];
		obj_Socierytype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createSocierytypeRow(obj_Socierytype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteSocierytype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Socierytype = new Socierytype();
		
		var resultStatus = mainPacket[0];
		var SocieryTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("SocierytypeListRow_"+SocieryTypeId);
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
				var rowElem = document.getElementById("SocierytypeListRow_"+SocieryTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateSocierytype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Socierytype = new Socierytype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Socierytype.SocieryTypeId= mainPacket[2];
		obj_Socierytype.SocieryTypeName= mainPacket[3];
		obj_Socierytype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createSocierytypeRow(obj_Socierytype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Socierytype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingSocierytypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Socierytype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteSocierytypePacket(SocieryTypeId) {
	var deletePacketBody  = SocieryTypeId;

	var postpacket = createOutgoingSocierytypePacket(202,deletePacketBody);
	Socierytype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateSocierytypePacket(obj_Socierytype) {
	var savePacketBody  = obj_Socierytype.createSocierytypePacket();

	var postpacket = createOutgoingSocierytypePacket(203,savePacketBody);
	Socierytype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddSocierytypePacket(dummyId,obj_Socierytype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Socierytype.createSocierytypePacket();

	var postpacket = createOutgoingSocierytypePacket(201,savePacketBody);
	Socierytype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onSocierytypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onSocierytypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addSocierytype = document.getElementById("btnaddSocierytype");
	if(addSocierytype){
	addSocierytype.addEventListener('mousedown', Event_mousedown_addSocierytype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popSocierytypeform = document.getElementById("popSocierytypeform");
	var inputElems = popSocierytypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiSocierytypeList = document.getElementById("SocierytypeList");
	var liElems = UiSocierytypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverSocierytypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutSocierytypeRow, false);
		
	}
	
	var UiSocierytypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiSocierytypeListDeletebtns.length; z++) {
			UiSocierytypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownSocierytypeRowBtn, false);			
		
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
	UI_search_Socierytype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownSocierytypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Socierytype = Get_SocierytypeByListRow(this.parentNode.parentNode);
			if(obj_Socierytype != ""){
				deleteSocierytype(obj_Socierytype.SocieryTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Socierytype = Get_SocierytypeByListRow(this.parentNode.parentNode);
			if(obj_Socierytype != ""){
				UI_showUpdateSocierytypeForm(obj_Socierytype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Socierytype(searchText)
{

	//SocierytypeList = 
	var SocierytypeListElem = document.getElementById("SocierytypeList");
	
	if(SocierytypeListElem)
	{
		var SocierytypeDataList = SocierytypeListElem.getElementsByTagName("input");
		for(var y=0 in SocierytypeDataList)
		{
			if(SocierytypeDataList[y])
			{
				
				
				var displayType = "none";
				var SocierytypeData = SocierytypeDataList[y].value;
				if(!((SocierytypeData == "") || (typeof SocierytypeData=="undefined")))
				{
				if(search_Socierytype(SocierytypeData,searchText))
				{
					displayType = "block";
				}
				SocierytypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Socierytype(SocierytypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	SocierytypeData = decodeSpText(SocierytypeData.toLowerCase());
	if(SocierytypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Socierytype)
{
	if (obj_Socierytype.SocieryTypeId) {
		var fieldDataId = obj_Socierytype.SocieryTypeId;
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

function deleteSocierytype(SocieryTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Socierytype");
	if(flag){
			DeleteSocierytypePacket(SocieryTypeId);
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

function Get_SocierytypeByListRow(listRowElem)
{
	
	var obj_Socierytype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var SocierytypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				SocierytypeData = elemlist[z].value;
			}		
		}
		
		if(SocierytypeData != "")
		{
		var arrSocierytypeData = SocierytypeData.split(";");	
		
		obj_Socierytype = new Socierytype();
		obj_Socierytype.SocieryTypeId= arrSocierytypeData[0];
		obj_Socierytype.SocieryTypeName= arrSocierytypeData[1];
		obj_Socierytype.Description= arrSocierytypeData[2];

		
		
		}
		
	}
	
	return obj_Socierytype;
	
	
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
	
			var Elem = document.getElementById("Input_SocieryTypeName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Society type name";
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
	
		var obj_Socierytype = new Socierytype();
		
		var SocieryTypeId= document.getElementById("Input_SocieryTypeId").value;
		var SocieryTypeName= document.getElementById("Input_SocieryTypeName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_SocieryTypeId").value="";
		document.getElementById("Input_SocieryTypeName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Socierytype = new Socierytype();
		obj_Socierytype.SocieryTypeId= SocieryTypeId;
		obj_Socierytype.SocieryTypeName= SocieryTypeName;
		obj_Socierytype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddSocierytypePacket(dummyId,obj_Socierytype);
		UI_createSocierytypeRow(obj_Socierytype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Socierytype = new Socierytype();

		obj_Socierytype.SocieryTypeId= SocieryTypeId;
		obj_Socierytype.SocieryTypeName= SocieryTypeName;
		obj_Socierytype.Description= Description;

		
		UpdateSocierytypePacket(obj_Socierytype);
		UI_createSocierytypeRow(obj_Socierytype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addSocierytype() {
	
	UI_showAddSocierytypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddSocierytypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareSocierytypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popSocierytypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateSocierytypeForm(obj_Socierytype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareSocierytypeUpdateForm(obj_Socierytype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popSocierytypeform"));
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
function UI_prepareSocierytypeUpdateForm(obj_Socierytype)
{
	var arr_hidelist = new Array("Input_SocieryTypeId");
	var arr_showlist = new Array("Input_SocieryTypeName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SocieryTypeId").value=obj_Socierytype.SocieryTypeId;
		document.getElementById("Input_SocieryTypeName").value=obj_Socierytype.SocieryTypeName;
		document.getElementById("Input_Description").value=obj_Socierytype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareSocierytypeAddForm()
{
	var arr_hidelist = new Array("Input_SocieryTypeId");
	var arr_showlist = new Array("Input_SocieryTypeName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SocieryTypeId").value="";
		document.getElementById("Input_SocieryTypeName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addSocierytypeToSocierytypeList() {
	var uiSocierytypeList = document.getElementById("SocierytypeList");

	var rowElems = uiSocierytypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createSocierytypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownSocierytypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createSocierytypeRowHtmlElem(obj_Socierytype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "SocierytypeImg_"+obj_Socierytype.SocieryTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Socierytype/0_small.png";
	else ImgElem.src = "Socierytype/"+obj_Socierytype.SocieryTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Socierytype.SocieryTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Socierytype.SocieryTypeName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Socierytype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Socierytypedata"+ElemId);
		ElementDataHidden.value = obj_Socierytype.getSocierytypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createSocierytypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverSocierytypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutSocierytypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubSocierytypeHtmlElem(obj_Socierytype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subSocierytype");
		html ="<a href=\"?page=dashboard&SocieryTypeId="+obj_Socierytype.SocieryTypeId+"\">"+obj_Socierytype.SocieryTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverSocierytypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutSocierytypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createSocierytypeRow(obj_Socierytype, rowType,dummyId) {
	var html = "";
	
	var UiSocierytypeList = document.getElementById("SocierytypeList");
	var ClassName = "ListRow";
	var ElemId = "SocierytypeListRow_"+obj_Socierytype.SocieryTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummySocierytypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createSocierytypeRowHtmlElem(obj_Socierytype,ElemId, ClassName);
			UiSocierytypeList.insertBefore(ElemLi, UiSocierytypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Socierytype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createSocierytypeRowHtmlElem(obj_Socierytype,ElemId, ClassName);
			UiSocierytypeList.insertBefore(ElemLi, UiSocierytypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummySocierytypeRow_"+dummyId);
			var DummyData = document.getElementById("SocierytypedataDummySocierytypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Socierytypedata"+ElemId);		
				DummyData.value = obj_Socierytype.getSocierytypeData();		
				}
				UI_createTopbarSubSocierytypeHtmlElem(obj_Socierytype);
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
				var ElemLi = UI_createSocierytypeRowHtmlElem(obj_Socierytype,ElemId, ClassName);
				UiSocierytypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("SocierytypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, SocieryTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("SocierytypeListRow_"+SocieryTypeId);
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


