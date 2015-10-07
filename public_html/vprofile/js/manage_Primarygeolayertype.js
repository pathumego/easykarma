//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Primarygeolayertype_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPrimarygeolayertype(mainPacket);
			break;
		}
		case 201: {
			ACK_addPrimarygeolayertype(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePrimarygeolayertype(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePrimarygeolayertype(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPrimarygeolayertype(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Primarygeolayertype = new Primarygeolayertype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Primarygeolayertype.PrimaryGeoLayerTypeId= mainPacket[3];
		obj_Primarygeolayertype.PrimaryGeoLayerName= mainPacket[4];
		obj_Primarygeolayertype.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createPrimarygeolayertypeRow(obj_Primarygeolayertype, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePrimarygeolayertype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Primarygeolayertype = new Primarygeolayertype();
		
		var resultStatus = mainPacket[0];
		var PrimaryGeoLayerTypeId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("PrimarygeolayertypeListRow_"+PrimaryGeoLayerTypeId);
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
				var rowElem = document.getElementById("PrimarygeolayertypeListRow_"+PrimaryGeoLayerTypeId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePrimarygeolayertype(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Primarygeolayertype = new Primarygeolayertype();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Primarygeolayertype.PrimaryGeoLayerTypeId= mainPacket[2];
		obj_Primarygeolayertype.PrimaryGeoLayerName= mainPacket[3];
		obj_Primarygeolayertype.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createPrimarygeolayertypeRow(obj_Primarygeolayertype, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Primarygeolayertype_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPrimarygeolayertypePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Primarygeolayertype; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePrimarygeolayertypePacket(PrimaryGeoLayerTypeId) {
	var deletePacketBody  = PrimaryGeoLayerTypeId;

	var postpacket = createOutgoingPrimarygeolayertypePacket(202,deletePacketBody);
	Primarygeolayertype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePrimarygeolayertypePacket(obj_Primarygeolayertype) {
	var savePacketBody  = obj_Primarygeolayertype.createPrimarygeolayertypePacket();

	var postpacket = createOutgoingPrimarygeolayertypePacket(203,savePacketBody);
	Primarygeolayertype_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPrimarygeolayertypePacket(dummyId,obj_Primarygeolayertype) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Primarygeolayertype.createPrimarygeolayertypePacket();

	var postpacket = createOutgoingPrimarygeolayertypePacket(201,savePacketBody);
	Primarygeolayertype_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPrimarygeolayertypePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPrimarygeolayertypePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPrimarygeolayertype = document.getElementById("btnaddPrimarygeolayertype");
	if(addPrimarygeolayertype){
	addPrimarygeolayertype.addEventListener('mousedown', Event_mousedown_addPrimarygeolayertype, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPrimarygeolayertypeform = document.getElementById("popPrimarygeolayertypeform");
	var inputElems = popPrimarygeolayertypeform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPrimarygeolayertypeList = document.getElementById("PrimarygeolayertypeList");
	var liElems = UiPrimarygeolayertypeList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPrimarygeolayertypeRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPrimarygeolayertypeRow, false);
		
	}
	
	var UiPrimarygeolayertypeListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPrimarygeolayertypeListDeletebtns.length; z++) {
			UiPrimarygeolayertypeListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPrimarygeolayertypeRowBtn, false);			
		
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
	UI_search_Primarygeolayertype(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPrimarygeolayertypeRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Primarygeolayertype = Get_PrimarygeolayertypeByListRow(this.parentNode.parentNode);
			if(obj_Primarygeolayertype != ""){
				deletePrimarygeolayertype(obj_Primarygeolayertype.PrimaryGeoLayerTypeId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Primarygeolayertype = Get_PrimarygeolayertypeByListRow(this.parentNode.parentNode);
			if(obj_Primarygeolayertype != ""){
				UI_showUpdatePrimarygeolayertypeForm(obj_Primarygeolayertype);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Primarygeolayertype(searchText)
{

	//PrimarygeolayertypeList = 
	var PrimarygeolayertypeListElem = document.getElementById("PrimarygeolayertypeList");
	
	if(PrimarygeolayertypeListElem)
	{
		var PrimarygeolayertypeDataList = PrimarygeolayertypeListElem.getElementsByTagName("input");
		for(var y=0 in PrimarygeolayertypeDataList)
		{
			if(PrimarygeolayertypeDataList[y])
			{
				
				
				var displayType = "none";
				var PrimarygeolayertypeData = PrimarygeolayertypeDataList[y].value;
				if(!((PrimarygeolayertypeData == "") || (typeof PrimarygeolayertypeData=="undefined")))
				{
				if(search_Primarygeolayertype(PrimarygeolayertypeData,searchText))
				{
					displayType = "block";
				}
				PrimarygeolayertypeDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Primarygeolayertype(PrimarygeolayertypeData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	PrimarygeolayertypeData = decodeSpText(PrimarygeolayertypeData.toLowerCase());
	if(PrimarygeolayertypeData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Primarygeolayertype)
{
	if (obj_Primarygeolayertype.PrimaryGeoLayerTypeId) {
		var fieldDataId = obj_Primarygeolayertype.PrimaryGeoLayerTypeId;
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

function deletePrimarygeolayertype(PrimaryGeoLayerTypeId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Primarygeolayertype");
	if(flag){
			DeletePrimarygeolayertypePacket(PrimaryGeoLayerTypeId);
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

function Get_PrimarygeolayertypeByListRow(listRowElem)
{
	
	var obj_Primarygeolayertype ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var PrimarygeolayertypeData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				PrimarygeolayertypeData = elemlist[z].value;
			}		
		}
		
		if(PrimarygeolayertypeData != "")
		{
		var arrPrimarygeolayertypeData = PrimarygeolayertypeData.split(";");	
		
		obj_Primarygeolayertype = new Primarygeolayertype();
		obj_Primarygeolayertype.PrimaryGeoLayerTypeId= arrPrimarygeolayertypeData[0];
		obj_Primarygeolayertype.PrimaryGeoLayerName= arrPrimarygeolayertypeData[1];
		obj_Primarygeolayertype.Description= arrPrimarygeolayertypeData[2];

		
		
		}
		
	}
	
	return obj_Primarygeolayertype;
	
	
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
	
			var Elem = document.getElementById("Input_PrimaryGeoLayerName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter Primary layer name";
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
	
		var obj_Primarygeolayertype = new Primarygeolayertype();
		
		var PrimaryGeoLayerTypeId= document.getElementById("Input_PrimaryGeoLayerTypeId").value;
		var PrimaryGeoLayerName= document.getElementById("Input_PrimaryGeoLayerName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_PrimaryGeoLayerTypeId").value="";
		document.getElementById("Input_PrimaryGeoLayerName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Primarygeolayertype = new Primarygeolayertype();
		obj_Primarygeolayertype.PrimaryGeoLayerTypeId= PrimaryGeoLayerTypeId;
		obj_Primarygeolayertype.PrimaryGeoLayerName= PrimaryGeoLayerName;
		obj_Primarygeolayertype.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddPrimarygeolayertypePacket(dummyId,obj_Primarygeolayertype);
		UI_createPrimarygeolayertypeRow(obj_Primarygeolayertype, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Primarygeolayertype = new Primarygeolayertype();

		obj_Primarygeolayertype.PrimaryGeoLayerTypeId= PrimaryGeoLayerTypeId;
		obj_Primarygeolayertype.PrimaryGeoLayerName= PrimaryGeoLayerName;
		obj_Primarygeolayertype.Description= Description;

		
		UpdatePrimarygeolayertypePacket(obj_Primarygeolayertype);
		UI_createPrimarygeolayertypeRow(obj_Primarygeolayertype, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPrimarygeolayertype() {
	
	UI_showAddPrimarygeolayertypeForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPrimarygeolayertypeForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePrimarygeolayertypeAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPrimarygeolayertypeform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePrimarygeolayertypeForm(obj_Primarygeolayertype) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePrimarygeolayertypeUpdateForm(obj_Primarygeolayertype);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPrimarygeolayertypeform"));
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
function UI_preparePrimarygeolayertypeUpdateForm(obj_Primarygeolayertype)
{
	var arr_hidelist = new Array("Input_PrimaryGeoLayerTypeId");
	var arr_showlist = new Array("Input_PrimaryGeoLayerName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PrimaryGeoLayerTypeId").value=obj_Primarygeolayertype.PrimaryGeoLayerTypeId;
		document.getElementById("Input_PrimaryGeoLayerName").value=obj_Primarygeolayertype.PrimaryGeoLayerName;
		document.getElementById("Input_Description").value=obj_Primarygeolayertype.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePrimarygeolayertypeAddForm()
{
	var arr_hidelist = new Array("Input_PrimaryGeoLayerTypeId");
	var arr_showlist = new Array("Input_PrimaryGeoLayerName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PrimaryGeoLayerTypeId").value="";
		document.getElementById("Input_PrimaryGeoLayerName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPrimarygeolayertypeToPrimarygeolayertypeList() {
	var uiPrimarygeolayertypeList = document.getElementById("PrimarygeolayertypeList");

	var rowElems = uiPrimarygeolayertypeList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPrimarygeolayertypeRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPrimarygeolayertypeRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPrimarygeolayertypeRowHtmlElem(obj_Primarygeolayertype,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "PrimarygeolayertypeImg_"+obj_Primarygeolayertype.PrimaryGeoLayerTypeId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Primarygeolayertype/0_small.png";
	else ImgElem.src = "Primarygeolayertype/"+obj_Primarygeolayertype.PrimaryGeoLayerTypeId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Primarygeolayertype.PrimaryGeoLayerTypeId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Primarygeolayertype.PrimaryGeoLayerName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Primarygeolayertype.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Primarygeolayertypedata"+ElemId);
		ElementDataHidden.value = obj_Primarygeolayertype.getPrimarygeolayertypeData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createPrimarygeolayertypeRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPrimarygeolayertypeRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPrimarygeolayertypeRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPrimarygeolayertypeHtmlElem(obj_Primarygeolayertype)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPrimarygeolayertype");
		html ="<a href=\"?page=dashboard&PrimaryGeoLayerTypeId="+obj_Primarygeolayertype.PrimaryGeoLayerTypeId+"\">"+obj_Primarygeolayertype.PrimaryGeoLayerTypeId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPrimarygeolayertypeRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPrimarygeolayertypeRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPrimarygeolayertypeRow(obj_Primarygeolayertype, rowType,dummyId) {
	var html = "";
	
	var UiPrimarygeolayertypeList = document.getElementById("PrimarygeolayertypeList");
	var ClassName = "ListRow";
	var ElemId = "PrimarygeolayertypeListRow_"+obj_Primarygeolayertype.PrimaryGeoLayerTypeId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPrimarygeolayertypeRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPrimarygeolayertypeRowHtmlElem(obj_Primarygeolayertype,ElemId, ClassName);
			UiPrimarygeolayertypeList.insertBefore(ElemLi, UiPrimarygeolayertypeList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Primarygeolayertype msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPrimarygeolayertypeRowHtmlElem(obj_Primarygeolayertype,ElemId, ClassName);
			UiPrimarygeolayertypeList.insertBefore(ElemLi, UiPrimarygeolayertypeList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPrimarygeolayertypeRow_"+dummyId);
			var DummyData = document.getElementById("PrimarygeolayertypedataDummyPrimarygeolayertypeRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Primarygeolayertypedata"+ElemId);		
				DummyData.value = obj_Primarygeolayertype.getPrimarygeolayertypeData();		
				}
				UI_createTopbarSubPrimarygeolayertypeHtmlElem(obj_Primarygeolayertype);
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
				var ElemLi = UI_createPrimarygeolayertypeRowHtmlElem(obj_Primarygeolayertype,ElemId, ClassName);
				UiPrimarygeolayertypeList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("PrimarygeolayertypeList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, PrimaryGeoLayerTypeId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("PrimarygeolayertypeListRow_"+PrimaryGeoLayerTypeId);
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


