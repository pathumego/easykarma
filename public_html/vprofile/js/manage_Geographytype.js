//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Geographytype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addGeographytype(mainPacket);
			break;
		}
		case 201: {
			ACK_addGeographytype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteGeographytype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateGeographytype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addGeographytype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Geographytype = new Geographytype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Geographytype.GeogrophyTypeId= mainPacket[3];
		obj_Geographytype.Name= mainPacket[4];
		obj_Geographytype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createGeographytypeRow(obj_Geographytype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteGeographytype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Geographytype = new Geographytype();
		
		var resultStatus = mainPacket[0];
		var GeogrophyTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("GeographytypeListRow_"+GeogrophyTypeId);
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
				var rowElem = document.getElementById("GeographytypeListRow_"+GeogrophyTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateGeographytype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Geographytype = new Geographytype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Geographytype.GeogrophyTypeId= mainPacket[2];
		obj_Geographytype.Name= mainPacket[3];
		obj_Geographytype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createGeographytypeRow(obj_Geographytype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Geographytype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingGeographytypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Geographytype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteGeographytypePacket(GeogrophyTypeId) {
	var deletePacketBody  = GeogrophyTypeId;

	var postpacket = createOutgoingGeographytypePacket(202,deletePacketBody);
	Geographytype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateGeographytypePacket(obj_Geographytype) {
	var savePacketBody  = obj_Geographytype.createGeographytypePacket();

	var postpacket = createOutgoingGeographytypePacket(203,savePacketBody);
	Geographytype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddGeographytypePacket(dummyId,obj_Geographytype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Geographytype.createGeographytypePacket();

	var postpacket = createOutgoingGeographytypePacket(201,savePacketBody);
	Geographytype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onGeographytypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onGeographytypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addGeographytype = document.getElementById("btnaddGeographytype");
	if(addGeographytype){
	addGeographytype.addEventListener('mousedown', Event_mousedown_addGeographytype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popGeographytypeform = document.getElementById("popGeographytypeform");
	var inputElems = popGeographytypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiGeographytypeList = document.getElementById("GeographytypeList");
	var liElems = UiGeographytypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverGeographytypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutGeographytypeRow, false);
		
	}
	
	var UiGeographytypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiGeographytypeListDeletebtns.length; z++) {
			UiGeographytypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownGeographytypeRowBtn, false);			
		
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
	UI_search_Geographytype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownGeographytypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Geographytype = Get_GeographytypeByListRow(this.parentNode.parentNode);
			if(obj_Geographytype != ""){
				deleteGeographytype(obj_Geographytype.GeogrophyTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Geographytype = Get_GeographytypeByListRow(this.parentNode.parentNode);
			if(obj_Geographytype != ""){
				UI_showUpdateGeographytypeForm(obj_Geographytype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Geographytype(searchText)
{

	//GeographytypeList = 
	var GeographytypeListElem = document.getElementById("GeographytypeList");
	
	if(GeographytypeListElem)
	{
		var GeographytypeDataList = GeographytypeListElem.getElementsByTagName("input");
		for(var y=0 in GeographytypeDataList)
		{
			if(GeographytypeDataList[y])
			{
				
				
				var displayType = "none";
				var GeographytypeData = GeographytypeDataList[y].value;
				if(!((GeographytypeData == "") || (typeof GeographytypeData=="undefined")))
				{
				if(search_Geographytype(GeographytypeData,searchText))
				{
					displayType = "block";
				}
				GeographytypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Geographytype(GeographytypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	GeographytypeData = decodeSpText(GeographytypeData.toLowerCase());
	if(GeographytypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Geographytype)
{
	if (obj_Geographytype.GeogrophyTypeId) {
		var fieldDataId = obj_Geographytype.GeogrophyTypeId;
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

function deleteGeographytype(GeogrophyTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Geographytype");
	if(flag){
			DeleteGeographytypePacket(GeogrophyTypeId);
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

function Get_GeographytypeByListRow(listRowElem)
{
	
	var obj_Geographytype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var GeographytypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				GeographytypeData = elemlist[z].value;
			}		
		}
		
		if(GeographytypeData != "")
		{
		var arrGeographytypeData = GeographytypeData.split(";");	
		
		obj_Geographytype = new Geographytype();
		obj_Geographytype.GeogrophyTypeId= arrGeographytypeData[0];
		obj_Geographytype.Name= arrGeographytypeData[1];
		obj_Geographytype.Description= arrGeographytypeData[2];

		
		
		}
		
	}
	
	return obj_Geographytype;
	
	
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
	
var Elem = document.getElementById("Input_Name");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter the name";
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
	
		var obj_Geographytype = new Geographytype();
		
		var GeogrophyTypeId= document.getElementById("Input_GeogrophyTypeId").value;
		var Name= document.getElementById("Input_Name").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_GeogrophyTypeId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Geographytype = new Geographytype();
		obj_Geographytype.GeogrophyTypeId= GeogrophyTypeId;
		obj_Geographytype.Name= Name;
		obj_Geographytype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddGeographytypePacket(dummyId,obj_Geographytype);
		UI_createGeographytypeRow(obj_Geographytype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Geographytype = new Geographytype();

		obj_Geographytype.GeogrophyTypeId= GeogrophyTypeId;
		obj_Geographytype.Name= Name;
		obj_Geographytype.Description= Description;

		
		UpdateGeographytypePacket(obj_Geographytype);
		UI_createGeographytypeRow(obj_Geographytype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addGeographytype() {
	
	UI_showAddGeographytypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddGeographytypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGeographytypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGeographytypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateGeographytypeForm(obj_Geographytype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareGeographytypeUpdateForm(obj_Geographytype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popGeographytypeform"));
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
function UI_prepareGeographytypeUpdateForm(obj_Geographytype)
{
	var arr_hidelist = new Array("Input_GeogrophyTypeId");
	var arr_showlist = new Array("Input_Name","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GeogrophyTypeId").value=obj_Geographytype.GeogrophyTypeId;
		document.getElementById("Input_Name").value=obj_Geographytype.Name;
		document.getElementById("Input_Description").value=obj_Geographytype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareGeographytypeAddForm()
{
	var arr_hidelist = new Array("Input_GeogrophyTypeId");
	var arr_showlist = new Array("Input_Name","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_GeogrophyTypeId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addGeographytypeToGeographytypeList() {
	var uiGeographytypeList = document.getElementById("GeographytypeList");

	var rowElems = uiGeographytypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createGeographytypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownGeographytypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGeographytypeRowHtmlElem(obj_Geographytype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "GeographytypeImg_"+obj_Geographytype.GeogrophyTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Geographytype/0_small.png";
	else ImgElem.src = "Geographytype/"+obj_Geographytype.GeogrophyTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Geographytype.GeogrophyTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Geographytype.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Geographytype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Geographytypedata"+ElemId);
		ElementDataHidden.value = obj_Geographytype.getGeographytypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createGeographytypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverGeographytypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutGeographytypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubGeographytypeHtmlElem(obj_Geographytype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subGeographytype");
		html ="<a href=\"?page=dashboard&GeogrophyTypeId="+obj_Geographytype.GeogrophyTypeId+"\">"+obj_Geographytype.GeogrophyTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverGeographytypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutGeographytypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createGeographytypeRow(obj_Geographytype, rowType,dummyId) {
	var html = "";
	
	var UiGeographytypeList = document.getElementById("GeographytypeList");
	var ClassName = "ListRow";
	var ElemId = "GeographytypeListRow_"+obj_Geographytype.GeogrophyTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyGeographytypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createGeographytypeRowHtmlElem(obj_Geographytype,ElemId, ClassName);
			UiGeographytypeList.insertBefore(ElemLi, UiGeographytypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Geographytype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createGeographytypeRowHtmlElem(obj_Geographytype,ElemId, ClassName);
			UiGeographytypeList.insertBefore(ElemLi, UiGeographytypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyGeographytypeRow_"+dummyId);
			var DummyData = document.getElementById("GeographytypedataDummyGeographytypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Geographytypedata"+ElemId);		
				DummyData.value = obj_Geographytype.getGeographytypeData();		
				}
				UI_createTopbarSubGeographytypeHtmlElem(obj_Geographytype);
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
				var ElemLi = UI_createGeographytypeRowHtmlElem(obj_Geographytype,ElemId, ClassName);
				UiGeographytypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("GeographytypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, GeogrophyTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("GeographytypeListRow_"+GeogrophyTypeId);
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


