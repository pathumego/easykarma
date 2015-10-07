//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Olsubjects_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addOlsubjects(mainPacket);
			break;
		}
		case 201: {
			ACK_addOlsubjects(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteOlsubjects(mainPacket);
			break;
		}
		case 203: {
			ACK_updateOlsubjects(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addOlsubjects(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Olsubjects = new Olsubjects();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Olsubjects.SubjectId= mainPacket[3];
		obj_Olsubjects.SubjectName= mainPacket[4];
		obj_Olsubjects.SubjectNumber= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createOlsubjectsRow(obj_Olsubjects, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteOlsubjects(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Olsubjects = new Olsubjects();
		
		var resultStatus = mainPacket[0];
		var SubjectId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("OlsubjectsListRow_"+SubjectId);
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
				var rowElem = document.getElementById("OlsubjectsListRow_"+SubjectId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateOlsubjects(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Olsubjects = new Olsubjects();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Olsubjects.SubjectId= mainPacket[2];
		obj_Olsubjects.SubjectName= mainPacket[3];
		obj_Olsubjects.SubjectNumber= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createOlsubjectsRow(obj_Olsubjects, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Olsubjects_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingOlsubjectsPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Olsubjects; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteOlsubjectsPacket(SubjectId) {
	var deletePacketBody  = SubjectId;

	var postpacket = createOutgoingOlsubjectsPacket(202,deletePacketBody);
	Olsubjects_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateOlsubjectsPacket(obj_Olsubjects) {
	var savePacketBody  = obj_Olsubjects.createOlsubjectsPacket();

	var postpacket = createOutgoingOlsubjectsPacket(203,savePacketBody);
	Olsubjects_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddOlsubjectsPacket(dummyId,obj_Olsubjects) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Olsubjects.createOlsubjectsPacket();

	var postpacket = createOutgoingOlsubjectsPacket(201,savePacketBody);
	Olsubjects_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onOlsubjectsPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onOlsubjectsPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addOlsubjects = document.getElementById("btnaddOlsubjects");
	if(addOlsubjects){
	addOlsubjects.addEventListener('mousedown', Event_mousedown_addOlsubjects, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popOlsubjectsform = document.getElementById("popOlsubjectsform");
	var inputElems = popOlsubjectsform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiOlsubjectsList = document.getElementById("OlsubjectsList");
	var liElems = UiOlsubjectsList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverOlsubjectsRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutOlsubjectsRow, false);
		
	}
	
	var UiOlsubjectsListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiOlsubjectsListDeletebtns.length; z++) {
			UiOlsubjectsListDeletebtns[z].addEventListener('mousedown', Event_mouseDownOlsubjectsRowBtn, false);			
		
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
	UI_search_Olsubjects(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownOlsubjectsRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Olsubjects = Get_OlsubjectsByListRow(this.parentNode.parentNode);
			if(obj_Olsubjects != ""){
				deleteOlsubjects(obj_Olsubjects.SubjectId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Olsubjects = Get_OlsubjectsByListRow(this.parentNode.parentNode);
			if(obj_Olsubjects != ""){
				UI_showUpdateOlsubjectsForm(obj_Olsubjects);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Olsubjects(searchText)
{

	//OlsubjectsList = 
	var OlsubjectsListElem = document.getElementById("OlsubjectsList");
	
	if(OlsubjectsListElem)
	{
		var OlsubjectsDataList = OlsubjectsListElem.getElementsByTagName("input");
		for(var y=0 in OlsubjectsDataList)
		{
			if(OlsubjectsDataList[y])
			{
				
				
				var displayType = "none";
				var OlsubjectsData = OlsubjectsDataList[y].value;
				if(!((OlsubjectsData == "") || (typeof OlsubjectsData=="undefined")))
				{
				if(search_Olsubjects(OlsubjectsData,searchText))
				{
					displayType = "block";
				}
				OlsubjectsDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Olsubjects(OlsubjectsData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	OlsubjectsData = decodeSpText(OlsubjectsData.toLowerCase());
	if(OlsubjectsData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Olsubjects)
{
	if (obj_Olsubjects.SubjectId) {
		var fieldDataId = obj_Olsubjects.SubjectId;
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

function deleteOlsubjects(SubjectId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Olsubjects");
	if(flag){
			DeleteOlsubjectsPacket(SubjectId);
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

function Get_OlsubjectsByListRow(listRowElem)
{
	
	var obj_Olsubjects ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var OlsubjectsData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				OlsubjectsData = elemlist[z].value;
			}		
		}
		
		if(OlsubjectsData != "")
		{
		var arrOlsubjectsData = OlsubjectsData.split(";");	
		
		obj_Olsubjects = new Olsubjects();
		obj_Olsubjects.SubjectId= arrOlsubjectsData[0];
		obj_Olsubjects.SubjectName= arrOlsubjectsData[1];
		obj_Olsubjects.SubjectNumber= arrOlsubjectsData[2];

		
		
		}
		
	}
	
	return obj_Olsubjects;
	
	
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
	
				var Elem = document.getElementById("Input_SubjectName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Subject Name";
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
	
		var obj_Olsubjects = new Olsubjects();
		
		var SubjectId= document.getElementById("Input_SubjectId").value;
		var SubjectName= document.getElementById("Input_SubjectName").value;
		var SubjectNumber= document.getElementById("Input_SubjectNumber").value;

		
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SubjectName").value="";
		document.getElementById("Input_SubjectNumber").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Olsubjects = new Olsubjects();
		obj_Olsubjects.SubjectId= SubjectId;
		obj_Olsubjects.SubjectName= SubjectName;
		obj_Olsubjects.SubjectNumber= SubjectNumber;

		
		var dummyId = CreateDummyNumber();
		AddOlsubjectsPacket(dummyId,obj_Olsubjects);
		UI_createOlsubjectsRow(obj_Olsubjects, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Olsubjects = new Olsubjects();

		obj_Olsubjects.SubjectId= SubjectId;
		obj_Olsubjects.SubjectName= SubjectName;
		obj_Olsubjects.SubjectNumber= SubjectNumber;

		
		UpdateOlsubjectsPacket(obj_Olsubjects);
		UI_createOlsubjectsRow(obj_Olsubjects, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addOlsubjects() {
	
	UI_showAddOlsubjectsForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddOlsubjectsForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOlsubjectsAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOlsubjectsform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateOlsubjectsForm(obj_Olsubjects) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareOlsubjectsUpdateForm(obj_Olsubjects);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popOlsubjectsform"));
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
function UI_prepareOlsubjectsUpdateForm(obj_Olsubjects)
{
	var arr_hidelist = new Array("Input_SubjectId");
	var arr_showlist = new Array("Input_SubjectName","Input_SubjectNumber");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SubjectId").value=obj_Olsubjects.SubjectId;
		document.getElementById("Input_SubjectName").value=obj_Olsubjects.SubjectName;
		document.getElementById("Input_SubjectNumber").value=obj_Olsubjects.SubjectNumber;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareOlsubjectsAddForm()
{
	var arr_hidelist = new Array("Input_SubjectId");
	var arr_showlist = new Array("Input_SubjectName","Input_SubjectNumber");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SubjectName").value="";
		document.getElementById("Input_SubjectNumber").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addOlsubjectsToOlsubjectsList() {
	var uiOlsubjectsList = document.getElementById("OlsubjectsList");

	var rowElems = uiOlsubjectsList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createOlsubjectsRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownOlsubjectsRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOlsubjectsRowHtmlElem(obj_Olsubjects,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "OlsubjectsImg_"+obj_Olsubjects.SubjectId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Olsubjects/0_small.png";
	else ImgElem.src = "Olsubjects/"+obj_Olsubjects.SubjectId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Olsubjects.SubjectId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Olsubjects.SubjectName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Olsubjects.SubjectNumber;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Olsubjectsdata"+ElemId);
		ElementDataHidden.value = obj_Olsubjects.getOlsubjectsData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createOlsubjectsRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverOlsubjectsRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutOlsubjectsRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubOlsubjectsHtmlElem(obj_Olsubjects)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subOlsubjects");
		html ="<a href=\"?page=dashboard&SubjectId="+obj_Olsubjects.SubjectId+"\">"+obj_Olsubjects.SubjectId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverOlsubjectsRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutOlsubjectsRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createOlsubjectsRow(obj_Olsubjects, rowType,dummyId) {
	var html = "";
	
	var UiOlsubjectsList = document.getElementById("OlsubjectsList");
	var ClassName = "ListRow";
	var ElemId = "OlsubjectsListRow_"+obj_Olsubjects.SubjectId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyOlsubjectsRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createOlsubjectsRowHtmlElem(obj_Olsubjects,ElemId, ClassName);
			UiOlsubjectsList.insertBefore(ElemLi, UiOlsubjectsList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Olsubjects msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createOlsubjectsRowHtmlElem(obj_Olsubjects,ElemId, ClassName);
			UiOlsubjectsList.insertBefore(ElemLi, UiOlsubjectsList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyOlsubjectsRow_"+dummyId);
			var DummyData = document.getElementById("OlsubjectsdataDummyOlsubjectsRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Olsubjectsdata"+ElemId);		
				DummyData.value = obj_Olsubjects.getOlsubjectsData();		
				}
				UI_createTopbarSubOlsubjectsHtmlElem(obj_Olsubjects);
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
				var ElemLi = UI_createOlsubjectsRowHtmlElem(obj_Olsubjects,ElemId, ClassName);
				UiOlsubjectsList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("OlsubjectsList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, SubjectId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("OlsubjectsListRow_"+SubjectId);
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


