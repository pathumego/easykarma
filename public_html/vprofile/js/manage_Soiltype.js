//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Soiltype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addSoiltype(mainPacket);
			break;
		}
		case 201: {
			ACK_addSoiltype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteSoiltype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateSoiltype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addSoiltype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Soiltype = new Soiltype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Soiltype.TblId= mainPacket[3];
		obj_Soiltype.SoilTypeId= mainPacket[4];
		obj_Soiltype.SoilTypeName= mainPacket[5];
		obj_Soiltype.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createSoiltypeRow(obj_Soiltype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteSoiltype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Soiltype = new Soiltype();
		
		var resultStatus = mainPacket[0];
		var TblId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("SoiltypeListRow_"+TblId);
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
				var rowElem = document.getElementById("SoiltypeListRow_"+TblId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateSoiltype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Soiltype = new Soiltype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Soiltype.TblId= mainPacket[2];
		obj_Soiltype.SoilTypeId= mainPacket[3];
		obj_Soiltype.SoilTypeName= mainPacket[4];
		obj_Soiltype.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createSoiltypeRow(obj_Soiltype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Soiltype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingSoiltypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Soiltype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteSoiltypePacket(TblId) {
	var deletePacketBody  = TblId;

	var postpacket = createOutgoingSoiltypePacket(202,deletePacketBody);
	Soiltype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateSoiltypePacket(obj_Soiltype) {
	var savePacketBody  = obj_Soiltype.createSoiltypePacket();

	var postpacket = createOutgoingSoiltypePacket(203,savePacketBody);
	Soiltype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddSoiltypePacket(dummyId,obj_Soiltype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Soiltype.createSoiltypePacket();

	var postpacket = createOutgoingSoiltypePacket(201,savePacketBody);
	Soiltype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onSoiltypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onSoiltypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addSoiltype = document.getElementById("btnaddSoiltype");
	if(addSoiltype){
	addSoiltype.addEventListener('mousedown', Event_mousedown_addSoiltype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popSoiltypeform = document.getElementById("popSoiltypeform");
	var inputElems = popSoiltypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiSoiltypeList = document.getElementById("SoiltypeList");
	var liElems = UiSoiltypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverSoiltypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutSoiltypeRow, false);
		
	}
	
	var UiSoiltypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiSoiltypeListDeletebtns.length; z++) {
			UiSoiltypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownSoiltypeRowBtn, false);			
		
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
	UI_search_Soiltype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownSoiltypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Soiltype = Get_SoiltypeByListRow(this.parentNode.parentNode);
			if(obj_Soiltype != ""){
				deleteSoiltype(obj_Soiltype.TblId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Soiltype = Get_SoiltypeByListRow(this.parentNode.parentNode);
			if(obj_Soiltype != ""){
				UI_showUpdateSoiltypeForm(obj_Soiltype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Soiltype(searchText)
{

	//SoiltypeList = 
	var SoiltypeListElem = document.getElementById("SoiltypeList");
	
	if(SoiltypeListElem)
	{
		var SoiltypeDataList = SoiltypeListElem.getElementsByTagName("input");
		for(var y=0 in SoiltypeDataList)
		{
			if(SoiltypeDataList[y])
			{
				
				
				var displayType = "none";
				var SoiltypeData = SoiltypeDataList[y].value;
				if(!((SoiltypeData == "") || (typeof SoiltypeData=="undefined")))
				{
				if(search_Soiltype(SoiltypeData,searchText))
				{
					displayType = "block";
				}
				SoiltypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Soiltype(SoiltypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	SoiltypeData = decodeSpText(SoiltypeData.toLowerCase());
	if(SoiltypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Soiltype)
{
	if (obj_Soiltype.TblId) {
		var fieldDataId = obj_Soiltype.TblId;
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

function deleteSoiltype(TblId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Soiltype");
	if(flag){
			DeleteSoiltypePacket(TblId);
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

function Get_SoiltypeByListRow(listRowElem)
{
	
	var obj_Soiltype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var SoiltypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				SoiltypeData = elemlist[z].value;
			}		
		}
		
		if(SoiltypeData != "")
		{
		var arrSoiltypeData = SoiltypeData.split(";");	
		
		obj_Soiltype = new Soiltype();
		obj_Soiltype.TblId= arrSoiltypeData[0];
		obj_Soiltype.SoilTypeId= arrSoiltypeData[1];
		obj_Soiltype.SoilTypeName= arrSoiltypeData[2];
		obj_Soiltype.Description= arrSoiltypeData[3];

		
		
		}
		
	}
	
	return obj_Soiltype;
	
	
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
	

		var Elem = document.getElementById("Input_SoilTypeName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Soil Type";
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
	
		var obj_Soiltype = new Soiltype();
		
		var TblId= document.getElementById("Input_TblId").value;
		var SoilTypeId= document.getElementById("Input_SoilTypeId").value;
		var SoilTypeName= document.getElementById("Input_SoilTypeName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_SoilTypeId").value="";
		document.getElementById("Input_SoilTypeName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Soiltype = new Soiltype();
		obj_Soiltype.TblId= TblId;
		obj_Soiltype.SoilTypeId= SoilTypeId;
		obj_Soiltype.SoilTypeName= SoilTypeName;
		obj_Soiltype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddSoiltypePacket(dummyId,obj_Soiltype);
		UI_createSoiltypeRow(obj_Soiltype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Soiltype = new Soiltype();

		obj_Soiltype.TblId= TblId;
		obj_Soiltype.SoilTypeId= SoilTypeId;
		obj_Soiltype.SoilTypeName= SoilTypeName;
		obj_Soiltype.Description= Description;

		
		UpdateSoiltypePacket(obj_Soiltype);
		UI_createSoiltypeRow(obj_Soiltype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addSoiltype() {
	
	UI_showAddSoiltypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddSoiltypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareSoiltypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popSoiltypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateSoiltypeForm(obj_Soiltype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareSoiltypeUpdateForm(obj_Soiltype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popSoiltypeform"));
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
function UI_prepareSoiltypeUpdateForm(obj_Soiltype)
{
	var arr_hidelist = new Array("Input_TblId","Input_SoilTypeId");
	var arr_showlist = new Array("Input_SoilTypeName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value=obj_Soiltype.TblId;
		document.getElementById("Input_SoilTypeId").value=obj_Soiltype.SoilTypeId;
		document.getElementById("Input_SoilTypeName").value=obj_Soiltype.SoilTypeName;
		document.getElementById("Input_Description").value=obj_Soiltype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareSoiltypeAddForm()
{
	var arr_hidelist = new Array("Input_TblId","Input_SoilTypeId");
	var arr_showlist = new Array("Input_SoilTypeName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_TblId").value="";
		document.getElementById("Input_SoilTypeId").value="";
		document.getElementById("Input_SoilTypeName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addSoiltypeToSoiltypeList() {
	var uiSoiltypeList = document.getElementById("SoiltypeList");

	var rowElems = uiSoiltypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createSoiltypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownSoiltypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createSoiltypeRowHtmlElem(obj_Soiltype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "SoiltypeImg_"+obj_Soiltype.TblId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Soiltype/0_small.png";
	else ImgElem.src = "Soiltype/"+obj_Soiltype.TblId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Soiltype.TblId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Soiltype.SoilTypeId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Soiltype.SoilTypeName;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Soiltype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Soiltypedata"+ElemId);
		ElementDataHidden.value = obj_Soiltype.getSoiltypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createSoiltypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverSoiltypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutSoiltypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubSoiltypeHtmlElem(obj_Soiltype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subSoiltype");
		html ="<a href=\"?page=dashboard&TblId="+obj_Soiltype.TblId+"\">"+obj_Soiltype.TblId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverSoiltypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutSoiltypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createSoiltypeRow(obj_Soiltype, rowType,dummyId) {
	var html = "";
	
	var UiSoiltypeList = document.getElementById("SoiltypeList");
	var ClassName = "ListRow";
	var ElemId = "SoiltypeListRow_"+obj_Soiltype.TblId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummySoiltypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createSoiltypeRowHtmlElem(obj_Soiltype,ElemId, ClassName);
			UiSoiltypeList.insertBefore(ElemLi, UiSoiltypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Soiltype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createSoiltypeRowHtmlElem(obj_Soiltype,ElemId, ClassName);
			UiSoiltypeList.insertBefore(ElemLi, UiSoiltypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummySoiltypeRow_"+dummyId);
			var DummyData = document.getElementById("SoiltypedataDummySoiltypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Soiltypedata"+ElemId);		
				DummyData.value = obj_Soiltype.getSoiltypeData();		
				}
				UI_createTopbarSubSoiltypeHtmlElem(obj_Soiltype);
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
				var ElemLi = UI_createSoiltypeRowHtmlElem(obj_Soiltype,ElemId, ClassName);
				UiSoiltypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("SoiltypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, TblId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("SoiltypeListRow_"+TblId);
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


