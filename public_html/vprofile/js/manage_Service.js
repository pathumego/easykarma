//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Service_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addService(mainPacket);
			break;
		}
		case 201: {
			ACK_addService(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteService(mainPacket);
			break;
		}
		case 203: {
			ACK_updateService(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addService(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Service = new Service();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Service.ServiceId= mainPacket[3];
		obj_Service.ServiceName= mainPacket[4];
		obj_Service.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createServiceRow(obj_Service, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteService(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Service = new Service();
		
		var resultStatus = mainPacket[0];
		var ServiceId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("ServiceListRow_"+ServiceId);
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
				var rowElem = document.getElementById("ServiceListRow_"+ServiceId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateService(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Service = new Service();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Service.ServiceId= mainPacket[2];
		obj_Service.ServiceName= mainPacket[3];
		obj_Service.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createServiceRow(obj_Service, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Service_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingServicePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Service; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteServicePacket(ServiceId) {
	var deletePacketBody  = ServiceId;

	var postpacket = createOutgoingServicePacket(202,deletePacketBody);
	Service_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateServicePacket(obj_Service) {
	var savePacketBody  = obj_Service.createServicePacket();

	var postpacket = createOutgoingServicePacket(203,savePacketBody);
	Service_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddServicePacket(dummyId,obj_Service) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Service.createServicePacket();

	var postpacket = createOutgoingServicePacket(201,savePacketBody);
	Service_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onServicePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onServicePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addService = document.getElementById("btnaddService");
	if(addService){
	addService.addEventListener('mousedown', Event_mousedown_addService, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popServiceform = document.getElementById("popServiceform");
	var inputElems = popServiceform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiServiceList = document.getElementById("ServiceList");
	var liElems = UiServiceList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverServiceRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutServiceRow, false);
		
	}
	
	var UiServiceListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiServiceListDeletebtns.length; z++) {
			UiServiceListDeletebtns[z].addEventListener('mousedown', Event_mouseDownServiceRowBtn, false);			
		
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
	UI_search_Service(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownServiceRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Service = Get_ServiceByListRow(this.parentNode.parentNode);
			if(obj_Service != ""){
				deleteService(obj_Service.ServiceId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Service = Get_ServiceByListRow(this.parentNode.parentNode);
			if(obj_Service != ""){
				UI_showUpdateServiceForm(obj_Service);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Service(searchText)
{

	//ServiceList = 
	var ServiceListElem = document.getElementById("ServiceList");
	
	if(ServiceListElem)
	{
		var ServiceDataList = ServiceListElem.getElementsByTagName("input");
		for(var y=0 in ServiceDataList)
		{
			if(ServiceDataList[y])
			{
				
				
				var displayType = "none";
				var ServiceData = ServiceDataList[y].value;
				if(!((ServiceData == "") || (typeof ServiceData=="undefined")))
				{
				if(search_Service(ServiceData,searchText))
				{
					displayType = "block";
				}
				ServiceDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Service(ServiceData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	ServiceData = decodeSpText(ServiceData.toLowerCase());
	if(ServiceData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Service)
{
	if (obj_Service.ServiceId) {
		var fieldDataId = obj_Service.ServiceId;
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

function deleteService(ServiceId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Service");
	if(flag){
			DeleteServicePacket(ServiceId);
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

function Get_ServiceByListRow(listRowElem)
{
	
	var obj_Service ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var ServiceData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				ServiceData = elemlist[z].value;
			}		
		}
		
		if(ServiceData != "")
		{
		var arrServiceData = ServiceData.split(";");	
		
		obj_Service = new Service();
		obj_Service.ServiceId= arrServiceData[0];
		obj_Service.ServiceName= arrServiceData[1];
		obj_Service.Description= arrServiceData[2];

		
		
		}
		
	}
	
	return obj_Service;
	
	
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
	
var Elem = document.getElementById("Input_ServiceName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter service";
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
	
		var obj_Service = new Service();
		
		var ServiceId= document.getElementById("Input_ServiceId").value;
		var ServiceName= document.getElementById("Input_ServiceName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_ServiceId").value="";
		document.getElementById("Input_ServiceName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Service = new Service();
		obj_Service.ServiceId= ServiceId;
		obj_Service.ServiceName= ServiceName;
		obj_Service.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddServicePacket(dummyId,obj_Service);
		UI_createServiceRow(obj_Service, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Service = new Service();

		obj_Service.ServiceId= ServiceId;
		obj_Service.ServiceName= ServiceName;
		obj_Service.Description= Description;

		
		UpdateServicePacket(obj_Service);
		UI_createServiceRow(obj_Service, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addService() {
	
	UI_showAddServiceForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddServiceForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareServiceAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popServiceform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateServiceForm(obj_Service) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareServiceUpdateForm(obj_Service);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popServiceform"));
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
function UI_prepareServiceUpdateForm(obj_Service)
{
	var arr_hidelist = new Array("Input_ServiceId");
	var arr_showlist = new Array("Input_ServiceName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ServiceId").value=obj_Service.ServiceId;
		document.getElementById("Input_ServiceName").value=obj_Service.ServiceName;
		document.getElementById("Input_Description").value=obj_Service.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareServiceAddForm()
{
	var arr_hidelist = new Array("Input_ServiceId");
	var arr_showlist = new Array("Input_ServiceName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ServiceId").value="";
		document.getElementById("Input_ServiceName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addServiceToServiceList() {
	var uiServiceList = document.getElementById("ServiceList");

	var rowElems = uiServiceList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createServiceRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownServiceRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createServiceRowHtmlElem(obj_Service,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "ServiceImg_"+obj_Service.ServiceId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Service/0_small.png";
	else ImgElem.src = "Service/"+obj_Service.ServiceId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Service.ServiceId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Service.ServiceName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Service.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Servicedata"+ElemId);
		ElementDataHidden.value = obj_Service.getServiceData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createServiceRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverServiceRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutServiceRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubServiceHtmlElem(obj_Service)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subService");
		html ="<a href=\"?page=dashboard&ServiceId="+obj_Service.ServiceId+"\">"+obj_Service.ServiceId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverServiceRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutServiceRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createServiceRow(obj_Service, rowType,dummyId) {
	var html = "";
	
	var UiServiceList = document.getElementById("ServiceList");
	var ClassName = "ListRow";
	var ElemId = "ServiceListRow_"+obj_Service.ServiceId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyServiceRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createServiceRowHtmlElem(obj_Service,ElemId, ClassName);
			UiServiceList.insertBefore(ElemLi, UiServiceList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Service msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createServiceRowHtmlElem(obj_Service,ElemId, ClassName);
			UiServiceList.insertBefore(ElemLi, UiServiceList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyServiceRow_"+dummyId);
			var DummyData = document.getElementById("ServicedataDummyServiceRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Servicedata"+ElemId);		
				DummyData.value = obj_Service.getServiceData();		
				}
				UI_createTopbarSubServiceHtmlElem(obj_Service);
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
				var ElemLi = UI_createServiceRowHtmlElem(obj_Service,ElemId, ClassName);
				UiServiceList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("ServiceList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, ServiceId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("ServiceListRow_"+ServiceId);
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


