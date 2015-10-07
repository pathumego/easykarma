//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Business_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addBusiness(mainPacket);
			break;
		}
		case 201: {
			ACK_addBusiness(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteBusiness(mainPacket);
			break;
		}
		case 203: {
			ACK_updateBusiness(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addBusiness(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Business = new Business();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Business.BusinessId= mainPacket[3];
		obj_Business.Name= mainPacket[4];
		obj_Business.Description= mainPacket[5];
		obj_Business.Address= mainPacket[6];
		obj_Business.telephone= mainPacket[7];
		obj_Business.fax= mainPacket[8];
		obj_Business.website= mainPacket[9];
		obj_Business.email= mainPacket[10];
		obj_Business.BusinessTypeId= mainPacket[11];
		obj_Business.BusinessSubTypeId= mainPacket[12];



		if (resultStatus == 1) {	
			
			UI_createBusinessRow(obj_Business, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteBusiness(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Business = new Business();
		
		var resultStatus = mainPacket[0];
		var BusinessId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("BusinessListRow_"+BusinessId);
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
				var rowElem = document.getElementById("BusinessListRow_"+BusinessId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateBusiness(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Business = new Business();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Business.BusinessId= mainPacket[2];
		obj_Business.Name= mainPacket[3];
		obj_Business.Description= mainPacket[4];
		obj_Business.Address= mainPacket[5];
		obj_Business.telephone= mainPacket[6];
		obj_Business.fax= mainPacket[7];
		obj_Business.website= mainPacket[8];
		obj_Business.email= mainPacket[9];
		obj_Business.BusinessTypeId= mainPacket[10];
		obj_Business.BusinessSubTypeId= mainPacket[11];


		if (resultStatus == 1) {			
			UI_createBusinessRow(obj_Business, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Business_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingBusinessPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Business; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteBusinessPacket(BusinessId) {
	var deletePacketBody  = BusinessId;

	var postpacket = createOutgoingBusinessPacket(202,deletePacketBody);
	Business_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateBusinessPacket(obj_Business) {
	var savePacketBody  = obj_Business.createBusinessPacket();

	var postpacket = createOutgoingBusinessPacket(203,savePacketBody);
	Business_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddBusinessPacket(dummyId,obj_Business) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Business.createBusinessPacket();

	var postpacket = createOutgoingBusinessPacket(201,savePacketBody);
	Business_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onBusinessPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onBusinessPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addBusiness = document.getElementById("btnaddBusiness");
	if(addBusiness){
	addBusiness.addEventListener('mousedown', Event_mousedown_addBusiness, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popBusinessform = document.getElementById("popBusinessform");
	var inputElems = popBusinessform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiBusinessList = document.getElementById("BusinessList");
	var liElems = UiBusinessList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverBusinessRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutBusinessRow, false);
		
	}
	
	var UiBusinessListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiBusinessListDeletebtns.length; z++) {
			UiBusinessListDeletebtns[z].addEventListener('mousedown', Event_mouseDownBusinessRowBtn, false);
	}

	var searchBox = document.getElementById("searchtextbox");
	 if(searchBox){
	 searchBox.addEventListener('focus', Event_focusSearchBox, false);
     searchBox.addEventListener('blur', Event_blurSearchBox, false);
     searchBox.addEventListener('keyup', Event_keyupSearchBox, false);
    }
	
	global_autocomplete_elem[0] = new AutoComplete();
	global_autocomplete_elem[0].Open(0,"Input_BusinessTypeId","BusinessTypeName",6);
	
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
	UI_search_Business(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownBusinessRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Business = Get_BusinessByListRow(this.parentNode.parentNode);
			if(obj_Business != ""){
				deleteBusiness(obj_Business.BusinessId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Business = Get_BusinessByListRow(this.parentNode.parentNode);
			if(obj_Business != ""){
				UI_showUpdateBusinessForm(obj_Business);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Business(searchText)
{

	//BusinessList = 
	var BusinessListElem = document.getElementById("BusinessList");
	
	if(BusinessListElem)
	{
		var BusinessDataList = BusinessListElem.getElementsByTagName("input");
		for(var y=0 in BusinessDataList)
		{
			if(BusinessDataList[y])
			{
				
				
				var displayType = "none";
				var BusinessData = BusinessDataList[y].value;
				if(!((BusinessData == "") || (typeof BusinessData=="undefined")))
				{
				if(search_Business(BusinessData,searchText))
				{
					displayType = "block";
				}
				BusinessDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Business(BusinessData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	BusinessData = decodeSpText(BusinessData.toLowerCase());
	if(BusinessData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Business)
{
	if (obj_Business.BusinessId) {
		var fieldDataId = obj_Business.BusinessId;
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

function deleteBusiness(BusinessId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Business");
	if(flag){
			DeleteBusinessPacket(BusinessId);
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

function Get_BusinessByListRow(listRowElem)
{
	
	var obj_Business ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var BusinessData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				BusinessData = elemlist[z].value;
			}		
		}
		
		if(BusinessData != "")
		{
		var arrBusinessData = BusinessData.split(";");	
		
		obj_Business = new Business();
		obj_Business.BusinessId= arrBusinessData[0];
		obj_Business.Name= arrBusinessData[1];
		obj_Business.Description= arrBusinessData[2];
		obj_Business.Address= arrBusinessData[3];
		obj_Business.telephone= arrBusinessData[4];
		obj_Business.fax= arrBusinessData[5];
		obj_Business.website= arrBusinessData[6];
		obj_Business.email= arrBusinessData[7];
		obj_Business.BusinessTypeId= arrBusinessData[8];
		obj_Business.BusinessSubTypeId= arrBusinessData[9];

		
		
		}
		
	}
	
	return obj_Business;
	
	
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
					error = "Please enter Business Name";
					Elem.focus();
				}		
	
			}
			
			var Elem = document.getElementById("Input_Description");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Business Name";
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
	
		var obj_Business = new Business();
		
		var BusinessId= document.getElementById("Input_BusinessId").value;
		var Name= document.getElementById("Input_Name").value;
		var Description= document.getElementById("Input_Description").value;
		var Address= document.getElementById("Input_Address").value;
		var telephone= document.getElementById("Input_telephone").value;
		var fax= document.getElementById("Input_fax").value;
		var website= document.getElementById("Input_website").value;
		var email= document.getElementById("Input_email").value;
		var BusinessTypeId= document.getElementById("Input_BusinessTypeId").value;
		var BusinessSubTypeId= document.getElementById("Input_BusinessSubTypeId").value;

		
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_Address").value="";
		document.getElementById("Input_telephone").value="";
		document.getElementById("Input_fax").value="";
		document.getElementById("Input_website").value="";
		document.getElementById("Input_email").value="";
		document.getElementById("Input_BusinessTypeId").value="";
		document.getElementById("Input_BusinessSubTypeId").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Business = new Business();
		obj_Business.BusinessId= BusinessId;
		obj_Business.Name= Name;
		obj_Business.Description= Description;
		obj_Business.Address= Address;
		obj_Business.telephone= telephone;
		obj_Business.fax= fax;
		obj_Business.website= website;
		obj_Business.email= email;
		obj_Business.BusinessTypeId= BusinessTypeId;
		obj_Business.BusinessSubTypeId= BusinessSubTypeId;

		
		var dummyId = CreateDummyNumber();
		AddBusinessPacket(dummyId,obj_Business);
		UI_createBusinessRow(obj_Business, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Business = new Business();

		obj_Business.BusinessId= BusinessId;
		obj_Business.Name= Name;
		obj_Business.Description= Description;
		obj_Business.Address= Address;
		obj_Business.telephone= telephone;
		obj_Business.fax= fax;
		obj_Business.website= website;
		obj_Business.email= email;
		obj_Business.BusinessTypeId= BusinessTypeId;
		obj_Business.BusinessSubTypeId= BusinessSubTypeId;

		
		UpdateBusinessPacket(obj_Business);
		UI_createBusinessRow(obj_Business, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addBusiness() {
	
	UI_showAddBusinessForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddBusinessForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareBusinessAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popBusinessform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateBusinessForm(obj_Business) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareBusinessUpdateForm(obj_Business);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popBusinessform"));
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
function UI_prepareBusinessUpdateForm(obj_Business)
{
	var arr_hidelist = new Array("Input_BusinessId");
	var arr_showlist = new Array("Input_BusinessTypeId","Input_Name","Input_Description","Input_Address","Input_telephone","Input_fax","Input_website","Input_email","Input_BusinessSubTypeId");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_BusinessId").value=obj_Business.BusinessId;
		document.getElementById("Input_Name").value=obj_Business.Name;
		document.getElementById("Input_Description").value=obj_Business.Description;
		document.getElementById("Input_Address").value=obj_Business.Address;
		document.getElementById("Input_telephone").value=obj_Business.telephone;
		document.getElementById("Input_fax").value=obj_Business.fax;
		document.getElementById("Input_website").value=obj_Business.website;
		document.getElementById("Input_email").value=obj_Business.email;
		document.getElementById("Input_BusinessTypeId").value=obj_Business.BusinessTypeId;
		document.getElementById("Input_BusinessSubTypeId").value=obj_Business.BusinessSubTypeId;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareBusinessAddForm()
{
	var arr_hidelist = new Array("Input_BusinessId");
	var arr_showlist = new Array("Input_BusinessTypeId","Input_Name","Input_Description","Input_Address","Input_telephone","Input_fax","Input_website","Input_email","Input_BusinessSubTypeId");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_BusinessId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_Address").value="";
		document.getElementById("Input_telephone").value="";
		document.getElementById("Input_fax").value="";
		document.getElementById("Input_website").value="";
		document.getElementById("Input_email").value="";
		document.getElementById("Input_BusinessTypeId").value="";
		document.getElementById("Input_BusinessSubTypeId").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addBusinessToBusinessList() {
	var uiBusinessList = document.getElementById("BusinessList");

	var rowElems = uiBusinessList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createBusinessRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownBusinessRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createBusinessRowHtmlElem(obj_Business,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "BusinessImg_"+obj_Business.BusinessId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Business/0_small.png";
	else ImgElem.src = "Business/"+obj_Business.BusinessId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Business.BusinessId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Business.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Business.Description;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Business.Address;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Business.telephone;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Business.fax;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Business.website;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow";
		ElemDataRow9.innerHTML = obj_Business.email;
		var ElemDataRow10 = document.createElement("div");
		ElemDataRow10.className ="datarow";
		ElemDataRow10.innerHTML = obj_Business.BusinessTypeId;
		var ElemDataRow11 = document.createElement("div");
		ElemDataRow11.className ="datarow";
		ElemDataRow11.innerHTML = obj_Business.BusinessSubTypeId;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Businessdata"+ElemId);
		ElementDataHidden.value = obj_Business.getBusinessData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);
		ElemLi.appendChild(ElemDataRow7);
		ElemLi.appendChild(ElemDataRow8);
		ElemLi.appendChild(ElemDataRow9);
		ElemLi.appendChild(ElemDataRow10);
		ElemLi.appendChild(ElemDataRow11);

		
		ElemLi= UI_createBusinessRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverBusinessRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutBusinessRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubBusinessHtmlElem(obj_Business)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subBusiness");
		html ="<a href=\"?page=dashboard&BusinessId="+obj_Business.BusinessId+"\">"+obj_Business.BusinessId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverBusinessRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutBusinessRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createBusinessRow(obj_Business, rowType,dummyId) {
	var html = "";
	
	var UiBusinessList = document.getElementById("BusinessList");
	var ClassName = "ListRow";
	var ElemId = "BusinessListRow_"+obj_Business.BusinessId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyBusinessRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createBusinessRowHtmlElem(obj_Business,ElemId, ClassName);
			UiBusinessList.insertBefore(ElemLi, UiBusinessList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Business msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createBusinessRowHtmlElem(obj_Business,ElemId, ClassName);
			UiBusinessList.insertBefore(ElemLi, UiBusinessList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyBusinessRow_"+dummyId);
			var DummyData = document.getElementById("BusinessdataDummyBusinessRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Businessdata"+ElemId);		
				DummyData.value = obj_Business.getBusinessData();		
				}
				UI_createTopbarSubBusinessHtmlElem(obj_Business);
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
				var ElemLi = UI_createBusinessRowHtmlElem(obj_Business,ElemId, ClassName);
				UiBusinessList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("BusinessList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, BusinessId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("BusinessListRow_"+BusinessId);
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


