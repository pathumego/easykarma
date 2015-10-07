//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Foresttype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addForesttype(mainPacket);
			break;
		}
		case 201: {
			ACK_addForesttype(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteForesttype(mainPacket);
			break;
		}
		case 203: {
			ACK_updateForesttype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addForesttype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Foresttype = new Foresttype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Foresttype.ForestTypeId= mainPacket[3];
		obj_Foresttype.Name= mainPacket[4];
		obj_Foresttype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createForesttypeRow(obj_Foresttype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteForesttype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Foresttype = new Foresttype();
		
		var resultStatus = mainPacket[0];
		var ForestTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("ForesttypeListRow_"+ForestTypeId);
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
				var rowElem = document.getElementById("ForesttypeListRow_"+ForestTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateForesttype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Foresttype = new Foresttype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Foresttype.ForestTypeId= mainPacket[2];
		obj_Foresttype.Name= mainPacket[3];
		obj_Foresttype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createForesttypeRow(obj_Foresttype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Foresttype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingForesttypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Foresttype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteForesttypePacket(ForestTypeId) {
	var deletePacketBody  = ForestTypeId;

	var postpacket = createOutgoingForesttypePacket(202,deletePacketBody);
	Foresttype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateForesttypePacket(obj_Foresttype) {
	var savePacketBody  = obj_Foresttype.createForesttypePacket();

	var postpacket = createOutgoingForesttypePacket(203,savePacketBody);
	Foresttype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddForesttypePacket(dummyId,obj_Foresttype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Foresttype.createForesttypePacket();

	var postpacket = createOutgoingForesttypePacket(201,savePacketBody);
	Foresttype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onForesttypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onForesttypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addForesttype = document.getElementById("btnaddForesttype");
	if(addForesttype){
	addForesttype.addEventListener('mousedown', Event_mousedown_addForesttype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popForesttypeform = document.getElementById("popForesttypeform");
	var inputElems = popForesttypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiForesttypeList = document.getElementById("ForesttypeList");
	var liElems = UiForesttypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverForesttypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutForesttypeRow, false);
		
	}
	
	var UiForesttypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiForesttypeListDeletebtns.length; z++) {
			UiForesttypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownForesttypeRowBtn, false);			
		
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
	UI_search_Foresttype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownForesttypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Foresttype = Get_ForesttypeByListRow(this.parentNode.parentNode);
			if(obj_Foresttype != ""){
				deleteForesttype(obj_Foresttype.ForestTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Foresttype = Get_ForesttypeByListRow(this.parentNode.parentNode);
			if(obj_Foresttype != ""){
				UI_showUpdateForesttypeForm(obj_Foresttype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Foresttype(searchText)
{

	//ForesttypeList = 
	var ForesttypeListElem = document.getElementById("ForesttypeList");
	
	if(ForesttypeListElem)
	{
		var ForesttypeDataList = ForesttypeListElem.getElementsByTagName("input");
		for(var y=0 in ForesttypeDataList)
		{
			if(ForesttypeDataList[y])
			{
				
				
				var displayType = "none";
				var ForesttypeData = ForesttypeDataList[y].value;
				if(!((ForesttypeData == "") || (typeof ForesttypeData=="undefined")))
				{
				if(search_Foresttype(ForesttypeData,searchText))
				{
					displayType = "block";
				}
				ForesttypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Foresttype(ForesttypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	ForesttypeData = decodeSpText(ForesttypeData.toLowerCase());
	if(ForesttypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Foresttype)
{
	if (obj_Foresttype.ForestTypeId) {
		var fieldDataId = obj_Foresttype.ForestTypeId;
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

function deleteForesttype(ForestTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Foresttype");
	if(flag){
			DeleteForesttypePacket(ForestTypeId);
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

function Get_ForesttypeByListRow(listRowElem)
{
	
	var obj_Foresttype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var ForesttypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				ForesttypeData = elemlist[z].value;
			}		
		}
		
		if(ForesttypeData != "")
		{
		var arrForesttypeData = ForesttypeData.split(";");	
		
		obj_Foresttype = new Foresttype();
		obj_Foresttype.ForestTypeId= arrForesttypeData[0];
		obj_Foresttype.Name= arrForesttypeData[1];
		obj_Foresttype.Description= arrForesttypeData[2];

		
		
		}
		
	}
	
	return obj_Foresttype;
	
	
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
					error = "please Enter Forest Name";
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
	
		var obj_Foresttype = new Foresttype();
		
		var ForestTypeId= document.getElementById("Input_ForestTypeId").value;
		var Name= document.getElementById("Input_Name").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_ForestTypeId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Foresttype = new Foresttype();
		obj_Foresttype.ForestTypeId= ForestTypeId;
		obj_Foresttype.Name= Name;
		obj_Foresttype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddForesttypePacket(dummyId,obj_Foresttype);
		UI_createForesttypeRow(obj_Foresttype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Foresttype = new Foresttype();

		obj_Foresttype.ForestTypeId= ForestTypeId;
		obj_Foresttype.Name= Name;
		obj_Foresttype.Description= Description;

		
		UpdateForesttypePacket(obj_Foresttype);
		UI_createForesttypeRow(obj_Foresttype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addForesttype() {
	
	UI_showAddForesttypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddForesttypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareForesttypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popForesttypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateForesttypeForm(obj_Foresttype) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareForesttypeUpdateForm(obj_Foresttype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popForesttypeform"));
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
function UI_prepareForesttypeUpdateForm(obj_Foresttype)
{
	var arr_hidelist = new Array("Input_ForestTypeId");
	var arr_showlist = new Array("Input_Name","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ForestTypeId").value=obj_Foresttype.ForestTypeId;
		document.getElementById("Input_Name").value=obj_Foresttype.Name;
		document.getElementById("Input_Description").value=obj_Foresttype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareForesttypeAddForm()
{
	var arr_hidelist = new Array("Input_ForestTypeId");
	var arr_showlist = new Array("Input_Name","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ForestTypeId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addForesttypeToForesttypeList() {
	var uiForesttypeList = document.getElementById("ForesttypeList");

	var rowElems = uiForesttypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createForesttypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownForesttypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createForesttypeRowHtmlElem(obj_Foresttype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "ForesttypeImg_"+obj_Foresttype.ForestTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Foresttype/0_small.png";
	else ImgElem.src = "Foresttype/"+obj_Foresttype.ForestTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Foresttype.ForestTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Foresttype.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Foresttype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Foresttypedata"+ElemId);
		ElementDataHidden.value = obj_Foresttype.getForesttypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createForesttypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverForesttypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutForesttypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubForesttypeHtmlElem(obj_Foresttype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subForesttype");
		html ="<a href=\"?page=dashboard&ForestTypeId="+obj_Foresttype.ForestTypeId+"\">"+obj_Foresttype.ForestTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverForesttypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutForesttypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createForesttypeRow(obj_Foresttype, rowType,dummyId) {
	var html = "";
	
	var UiForesttypeList = document.getElementById("ForesttypeList");
	var ClassName = "ListRow";
	var ElemId = "ForesttypeListRow_"+obj_Foresttype.ForestTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyForesttypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createForesttypeRowHtmlElem(obj_Foresttype,ElemId, ClassName);
			UiForesttypeList.insertBefore(ElemLi, UiForesttypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Foresttype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createForesttypeRowHtmlElem(obj_Foresttype,ElemId, ClassName);
			UiForesttypeList.insertBefore(ElemLi, UiForesttypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyForesttypeRow_"+dummyId);
			var DummyData = document.getElementById("ForesttypedataDummyForesttypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Foresttypedata"+ElemId);		
				DummyData.value = obj_Foresttype.getForesttypeData();		
				}
				UI_createTopbarSubForesttypeHtmlElem(obj_Foresttype);
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
				var ElemLi = UI_createForesttypeRowHtmlElem(obj_Foresttype,ElemId, ClassName);
				UiForesttypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("ForesttypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, ForestTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("ForesttypeListRow_"+ForestTypeId);
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


