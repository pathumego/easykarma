//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Village_image_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addVillage_image(mainPacket);
			break;
		}
		case 201: {
			ACK_addVillage_image(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteVillage_image(mainPacket);
			break;
		}
		case 203: {
			ACK_updateVillage_image(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addVillage_image(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Village_image = new Village_image();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Village_image.PictureId= mainPacket[3];
		obj_Village_image.VillageId= mainPacket[4];
		obj_Village_image.PicturePath= mainPacket[5];
		obj_Village_image.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createVillage_imageRow(obj_Village_image, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteVillage_image(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_image = new Village_image();
		
		var resultStatus = mainPacket[0];
		var PictureId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("Village_imageListRow_"+PictureId);
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
				var rowElem = document.getElementById("Village_imageListRow_"+PictureId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateVillage_image(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Village_image = new Village_image();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Village_image.PictureId= mainPacket[2];
		obj_Village_image.VillageId= mainPacket[3];
		obj_Village_image.PicturePath= mainPacket[4];
		obj_Village_image.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createVillage_imageRow(obj_Village_image, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Village_image_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingVillage_imagePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Village_image; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteVillage_imagePacket(PictureId) {
	var deletePacketBody  = PictureId;

	var postpacket = createOutgoingVillage_imagePacket(202,deletePacketBody);
	Village_image_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateVillage_imagePacket(obj_Village_image) {
	var savePacketBody  = obj_Village_image.createVillage_imagePacket();

	var postpacket = createOutgoingVillage_imagePacket(203,savePacketBody);
	Village_image_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddVillage_imagePacket(dummyId,obj_Village_image) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Village_image.createVillage_imagePacket();

	var postpacket = createOutgoingVillage_imagePacket(201,savePacketBody);
	Village_image_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onVillage_imagePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onVillage_imagePageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addVillage_image = document.getElementById("btnaddVillage_image");
	if(addVillage_image){
	addVillage_image.addEventListener('mousedown', Event_mousedown_addVillage_image, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popVillage_imageform = document.getElementById("popVillage_imageform");
	var inputElems = popVillage_imageform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiVillage_imageList = document.getElementById("Village_imageList");
	var liElems = UiVillage_imageList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverVillage_imageRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutVillage_imageRow, false);
		
	}
	
	var UiVillage_imageListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiVillage_imageListDeletebtns.length; z++) {
			UiVillage_imageListDeletebtns[z].addEventListener('mousedown', Event_mouseDownVillage_imageRowBtn, false);			
		
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
	UI_search_Village_image(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownVillage_imageRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Village_image = Get_Village_imageByListRow(this.parentNode.parentNode);
			if(obj_Village_image != ""){
				deleteVillage_image(obj_Village_image.PictureId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Village_image = Get_Village_imageByListRow(this.parentNode.parentNode);
			if(obj_Village_image != ""){
				UI_showUpdateVillage_imageForm(obj_Village_image);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Village_image(searchText)
{

	//Village_imageList = 
	var Village_imageListElem = document.getElementById("Village_imageList");
	
	if(Village_imageListElem)
	{
		var Village_imageDataList = Village_imageListElem.getElementsByTagName("input");
		for(var y=0 in Village_imageDataList)
		{
			if(Village_imageDataList[y])
			{
				
				
				var displayType = "none";
				var Village_imageData = Village_imageDataList[y].value;
				if(!((Village_imageData == "") || (typeof Village_imageData=="undefined")))
				{
				if(search_Village_image(Village_imageData,searchText))
				{
					displayType = "block";
				}
				Village_imageDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Village_image(Village_imageData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	Village_imageData = decodeSpText(Village_imageData.toLowerCase());
	if(Village_imageData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Village_image)
{
	if (obj_Village_image.PictureId) {
		var fieldDataId = obj_Village_image.PictureId;
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

function deleteVillage_image(PictureId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Village_image");
	if(flag){
			DeleteVillage_imagePacket(PictureId);
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

function Get_Village_imageByListRow(listRowElem)
{
	
	var obj_Village_image ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var Village_imageData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				Village_imageData = elemlist[z].value;
			}		
		}
		
		if(Village_imageData != "")
		{
		var arrVillage_imageData = Village_imageData.split(";");	
		
		obj_Village_image = new Village_image();
		obj_Village_image.PictureId= arrVillage_imageData[0];
		obj_Village_image.VillageId= arrVillage_imageData[1];
		obj_Village_image.PicturePath= arrVillage_imageData[2];
		obj_Village_image.Description= arrVillage_imageData[3];

		
		
		}
		
	}
	
	return obj_Village_image;
	
	
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
	
var Elem = document.getElementById("Input_PicturePath");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Picture Path";
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
	
		var obj_Village_image = new Village_image();
		
		var PictureId= document.getElementById("Input_PictureId").value;
		var VillageId= document.getElementById("Input_VillageId").value;
		var PicturePath= document.getElementById("Input_PicturePath").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_PictureId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_PicturePath").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Village_image = new Village_image();
		obj_Village_image.PictureId= PictureId;
		obj_Village_image.VillageId= VillageId;
		obj_Village_image.PicturePath= PicturePath;
		obj_Village_image.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddVillage_imagePacket(dummyId,obj_Village_image);
		UI_createVillage_imageRow(obj_Village_image, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Village_image = new Village_image();

		obj_Village_image.PictureId= PictureId;
		obj_Village_image.VillageId= VillageId;
		obj_Village_image.PicturePath= PicturePath;
		obj_Village_image.Description= Description;

		
		UpdateVillage_imagePacket(obj_Village_image);
		UI_createVillage_imageRow(obj_Village_image, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addVillage_image() {
	
	UI_showAddVillage_imageForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddVillage_imageForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_imageAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_imageform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateVillage_imageForm(obj_Village_image) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareVillage_imageUpdateForm(obj_Village_image);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popVillage_imageform"));
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
function UI_prepareVillage_imageUpdateForm(obj_Village_image)
{
	var arr_hidelist = new Array("Input_PictureId","Input_VillageId");
	var arr_showlist = new Array("Input_PicturePath","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PictureId").value=obj_Village_image.PictureId;
		document.getElementById("Input_VillageId").value=obj_Village_image.VillageId;
		document.getElementById("Input_PicturePath").value=obj_Village_image.PicturePath;
		document.getElementById("Input_Description").value=obj_Village_image.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareVillage_imageAddForm()
{
	var arr_hidelist = new Array("Input_PictureId","Input_VillageId");
	var arr_showlist = new Array("Input_PicturePath","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PictureId").value="";
		document.getElementById("Input_VillageId").value="";
		document.getElementById("Input_PicturePath").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addVillage_imageToVillage_imageList() {
	var uiVillage_imageList = document.getElementById("Village_imageList");

	var rowElems = uiVillage_imageList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_imageRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownVillage_imageRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_imageRowHtmlElem(obj_Village_image,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "Village_imageImg_"+obj_Village_image.PictureId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Village_image/0_small.png";
	else ImgElem.src = "Village_image/"+obj_Village_image.PictureId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Village_image.PictureId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Village_image.VillageId;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Village_image.PicturePath;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Village_image.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Village_imagedata"+ElemId);
		ElementDataHidden.value = obj_Village_image.getVillage_imageData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createVillage_imageRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverVillage_imageRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutVillage_imageRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubVillage_imageHtmlElem(obj_Village_image)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subVillage_image");
		html ="<a href=\"?page=dashboard&PictureId="+obj_Village_image.PictureId+"\">"+obj_Village_image.PictureId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverVillage_imageRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutVillage_imageRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createVillage_imageRow(obj_Village_image, rowType,dummyId) {
	var html = "";
	
	var UiVillage_imageList = document.getElementById("Village_imageList");
	var ClassName = "ListRow";
	var ElemId = "Village_imageListRow_"+obj_Village_image.PictureId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyVillage_imageRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createVillage_imageRowHtmlElem(obj_Village_image,ElemId, ClassName);
			UiVillage_imageList.insertBefore(ElemLi, UiVillage_imageList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Village_image msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createVillage_imageRowHtmlElem(obj_Village_image,ElemId, ClassName);
			UiVillage_imageList.insertBefore(ElemLi, UiVillage_imageList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyVillage_imageRow_"+dummyId);
			var DummyData = document.getElementById("Village_imagedataDummyVillage_imageRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Village_imagedata"+ElemId);		
				DummyData.value = obj_Village_image.getVillage_imageData();		
				}
				UI_createTopbarSubVillage_imageHtmlElem(obj_Village_image);
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
				var ElemLi = UI_createVillage_imageRowHtmlElem(obj_Village_image,ElemId, ClassName);
				UiVillage_imageList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("Village_imageList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, PictureId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("Village_imageListRow_"+PictureId);
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


