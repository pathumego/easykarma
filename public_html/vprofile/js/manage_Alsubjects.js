//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Alsubjects_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addAlsubjects(mainPacket);
			break;
		}
		case 201: {
			ACK_addAlsubjects(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteAlsubjects(mainPacket);
			break;
		}
		case 203: {
			ACK_updateAlsubjects(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addAlsubjects(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Alsubjects = new Alsubjects();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Alsubjects.SubjectId= mainPacket[3];
		obj_Alsubjects.SubjectName= mainPacket[4];
		obj_Alsubjects.SubjectNumber= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createAlsubjectsRow(obj_Alsubjects, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteAlsubjects(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Alsubjects = new Alsubjects();
		
		var resultStatus = mainPacket[0];
		var SubjectId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("AlsubjectsListRow_"+SubjectId);
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
				var rowElem = document.getElementById("AlsubjectsListRow_"+SubjectId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateAlsubjects(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Alsubjects = new Alsubjects();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Alsubjects.SubjectId= mainPacket[2];
		obj_Alsubjects.SubjectName= mainPacket[3];
		obj_Alsubjects.SubjectNumber= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createAlsubjectsRow(obj_Alsubjects, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Alsubjects_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingAlsubjectsPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Alsubjects; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteAlsubjectsPacket(SubjectId) {
	var deletePacketBody  = SubjectId;

	var postpacket = createOutgoingAlsubjectsPacket(202,deletePacketBody);
	Alsubjects_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateAlsubjectsPacket(obj_Alsubjects) {
	var savePacketBody  = obj_Alsubjects.createAlsubjectsPacket();

	var postpacket = createOutgoingAlsubjectsPacket(203,savePacketBody);
	Alsubjects_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddAlsubjectsPacket(dummyId,obj_Alsubjects) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Alsubjects.createAlsubjectsPacket();

	var postpacket = createOutgoingAlsubjectsPacket(201,savePacketBody);
	Alsubjects_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onAlsubjectsPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onAlsubjectsPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addAlsubjects = document.getElementById("btnaddAlsubjects");
	if(addAlsubjects){
	addAlsubjects.addEventListener('mousedown', Event_mousedown_addAlsubjects, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popAlsubjectsform = document.getElementById("popAlsubjectsform");
	var inputElems = popAlsubjectsform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiAlsubjectsList = document.getElementById("AlsubjectsList");
	var liElems = UiAlsubjectsList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverAlsubjectsRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutAlsubjectsRow, false);
		
	}
	
	var UiAlsubjectsListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiAlsubjectsListDeletebtns.length; z++) {
			UiAlsubjectsListDeletebtns[z].addEventListener('mousedown', Event_mouseDownAlsubjectsRowBtn, false);			
		
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
	UI_search_Alsubjects(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownAlsubjectsRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Alsubjects = Get_AlsubjectsByListRow(this.parentNode.parentNode);
			if(obj_Alsubjects != ""){
				deleteAlsubjects(obj_Alsubjects.SubjectId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Alsubjects = Get_AlsubjectsByListRow(this.parentNode.parentNode);
			if(obj_Alsubjects != ""){
				UI_showUpdateAlsubjectsForm(obj_Alsubjects);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Alsubjects(searchText)
{

	//AlsubjectsList = 
	var AlsubjectsListElem = document.getElementById("AlsubjectsList");
	
	if(AlsubjectsListElem)
	{
		var AlsubjectsDataList = AlsubjectsListElem.getElementsByTagName("input");
		for(var y=0 in AlsubjectsDataList)
		{
			if(AlsubjectsDataList[y])
			{
				
				
				var displayType = "none";
				var AlsubjectsData = AlsubjectsDataList[y].value;
				if(!((AlsubjectsData == "") || (typeof AlsubjectsData=="undefined")))
				{
				if(search_Alsubjects(AlsubjectsData,searchText))
				{
					displayType = "block";
				}
				AlsubjectsDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Alsubjects(AlsubjectsData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	AlsubjectsData = decodeSpText(AlsubjectsData.toLowerCase());
	if(AlsubjectsData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Alsubjects)
{
	if (obj_Alsubjects.SubjectId) {
		var fieldDataId = obj_Alsubjects.SubjectId;
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

function deleteAlsubjects(SubjectId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Alsubjects");
	if(flag){
			DeleteAlsubjectsPacket(SubjectId);
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

function Get_AlsubjectsByListRow(listRowElem)
{
	
	var obj_Alsubjects ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var AlsubjectsData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				AlsubjectsData = elemlist[z].value;
			}		
		}
		
		if(AlsubjectsData != "")
		{
		var arrAlsubjectsData = AlsubjectsData.split(";");	
		
		obj_Alsubjects = new Alsubjects();
		obj_Alsubjects.SubjectId= arrAlsubjectsData[0];
		obj_Alsubjects.SubjectName= arrAlsubjectsData[1];
		obj_Alsubjects.SubjectNumber= arrAlsubjectsData[2];

		
		
		}
		
	}
	
	return obj_Alsubjects;
	
	
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
					error = "please Enter Subject";
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
	
		var obj_Alsubjects = new Alsubjects();
		
		var SubjectId= document.getElementById("Input_SubjectId").value;
		var SubjectName= document.getElementById("Input_SubjectName").value;
		var SubjectNumber= document.getElementById("Input_SubjectNumber").value;

		
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SubjectName").value="";
		document.getElementById("Input_SubjectNumber").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Alsubjects = new Alsubjects();
		obj_Alsubjects.SubjectId= SubjectId;
		obj_Alsubjects.SubjectName= SubjectName;
		obj_Alsubjects.SubjectNumber= SubjectNumber;

		
		var dummyId = CreateDummyNumber();
		AddAlsubjectsPacket(dummyId,obj_Alsubjects);
		UI_createAlsubjectsRow(obj_Alsubjects, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Alsubjects = new Alsubjects();

		obj_Alsubjects.SubjectId= SubjectId;
		obj_Alsubjects.SubjectName= SubjectName;
		obj_Alsubjects.SubjectNumber= SubjectNumber;

		
		UpdateAlsubjectsPacket(obj_Alsubjects);
		UI_createAlsubjectsRow(obj_Alsubjects, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addAlsubjects() {
	
	UI_showAddAlsubjectsForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddAlsubjectsForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareAlsubjectsAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popAlsubjectsform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateAlsubjectsForm(obj_Alsubjects) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareAlsubjectsUpdateForm(obj_Alsubjects);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popAlsubjectsform"));
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
function UI_prepareAlsubjectsUpdateForm(obj_Alsubjects)
{
	var arr_hidelist = new Array("Input_SubjectId");
	var arr_showlist = new Array("Input_SubjectName","Input_SubjectNumber");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SubjectId").value=obj_Alsubjects.SubjectId;
		document.getElementById("Input_SubjectName").value=obj_Alsubjects.SubjectName;
		document.getElementById("Input_SubjectNumber").value=obj_Alsubjects.SubjectNumber;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareAlsubjectsAddForm()
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

function UI_addAlsubjectsToAlsubjectsList() {
	var uiAlsubjectsList = document.getElementById("AlsubjectsList");

	var rowElems = uiAlsubjectsList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createAlsubjectsRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownAlsubjectsRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createAlsubjectsRowHtmlElem(obj_Alsubjects,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "AlsubjectsImg_"+obj_Alsubjects.SubjectId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Alsubjects/0_small.png";
	else ImgElem.src = "Alsubjects/"+obj_Alsubjects.SubjectId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Alsubjects.SubjectId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Alsubjects.SubjectName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Alsubjects.SubjectNumber;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Alsubjectsdata"+ElemId);
		ElementDataHidden.value = obj_Alsubjects.getAlsubjectsData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createAlsubjectsRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverAlsubjectsRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutAlsubjectsRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubAlsubjectsHtmlElem(obj_Alsubjects)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subAlsubjects");
		html ="<a href=\"?page=dashboard&SubjectId="+obj_Alsubjects.SubjectId+"\">"+obj_Alsubjects.SubjectId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverAlsubjectsRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutAlsubjectsRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createAlsubjectsRow(obj_Alsubjects, rowType,dummyId) {
	var html = "";
	
	var UiAlsubjectsList = document.getElementById("AlsubjectsList");
	var ClassName = "ListRow";
	var ElemId = "AlsubjectsListRow_"+obj_Alsubjects.SubjectId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyAlsubjectsRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createAlsubjectsRowHtmlElem(obj_Alsubjects,ElemId, ClassName);
			UiAlsubjectsList.insertBefore(ElemLi, UiAlsubjectsList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Alsubjects msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createAlsubjectsRowHtmlElem(obj_Alsubjects,ElemId, ClassName);
			UiAlsubjectsList.insertBefore(ElemLi, UiAlsubjectsList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyAlsubjectsRow_"+dummyId);
			var DummyData = document.getElementById("AlsubjectsdataDummyAlsubjectsRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Alsubjectsdata"+ElemId);		
				DummyData.value = obj_Alsubjects.getAlsubjectsData();		
				}
				UI_createTopbarSubAlsubjectsHtmlElem(obj_Alsubjects);
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
				var ElemLi = UI_createAlsubjectsRowHtmlElem(obj_Alsubjects,ElemId, ClassName);
				UiAlsubjectsList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("AlsubjectsList");
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
		var profileAvatar = document.getElementById("AlsubjectsListRow_"+SubjectId);
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


