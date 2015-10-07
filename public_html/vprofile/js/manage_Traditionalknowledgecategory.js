//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Traditionalknowledgecategory_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addTraditionalknowledgecategory(mainPacket);
			break;
		}
		case 201: {
			ACK_addTraditionalknowledgecategory(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteTraditionalknowledgecategory(mainPacket);
			break;
		}
		case 203: {
			ACK_updateTraditionalknowledgecategory(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addTraditionalknowledgecategory(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Traditionalknowledgecategory.CategoryId= mainPacket[3];
		obj_Traditionalknowledgecategory.CategoryName= mainPacket[4];
		obj_Traditionalknowledgecategory.Description= mainPacket[5];



		if (resultStatus == 1) {	
			
			UI_createTraditionalknowledgecategoryRow(obj_Traditionalknowledgecategory, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteTraditionalknowledgecategory(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		
		var resultStatus = mainPacket[0];
		var CategoryId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("TraditionalknowledgecategoryListRow_"+CategoryId);
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
				var rowElem = document.getElementById("TraditionalknowledgecategoryListRow_"+CategoryId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateTraditionalknowledgecategory(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Traditionalknowledgecategory.CategoryId= mainPacket[2];
		obj_Traditionalknowledgecategory.CategoryName= mainPacket[3];
		obj_Traditionalknowledgecategory.Description= mainPacket[4];


		if (resultStatus == 1) {			
			UI_createTraditionalknowledgecategoryRow(obj_Traditionalknowledgecategory, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Traditionalknowledgecategory_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingTraditionalknowledgecategoryPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Traditionalknowledgecategory; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteTraditionalknowledgecategoryPacket(CategoryId) {
	var deletePacketBody  = CategoryId;

	var postpacket = createOutgoingTraditionalknowledgecategoryPacket(202,deletePacketBody);
	Traditionalknowledgecategory_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateTraditionalknowledgecategoryPacket(obj_Traditionalknowledgecategory) {
	var savePacketBody  = obj_Traditionalknowledgecategory.createTraditionalknowledgecategoryPacket();

	var postpacket = createOutgoingTraditionalknowledgecategoryPacket(203,savePacketBody);
	Traditionalknowledgecategory_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddTraditionalknowledgecategoryPacket(dummyId,obj_Traditionalknowledgecategory) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Traditionalknowledgecategory.createTraditionalknowledgecategoryPacket();

	var postpacket = createOutgoingTraditionalknowledgecategoryPacket(201,savePacketBody);
	Traditionalknowledgecategory_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onTraditionalknowledgecategoryPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onTraditionalknowledgecategoryPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addTraditionalknowledgecategory = document.getElementById("btnaddTraditionalknowledgecategory");
	if(addTraditionalknowledgecategory){
	addTraditionalknowledgecategory.addEventListener('mousedown', Event_mousedown_addTraditionalknowledgecategory, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popTraditionalknowledgecategoryform = document.getElementById("popTraditionalknowledgecategoryform");
	var inputElems = popTraditionalknowledgecategoryform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiTraditionalknowledgecategoryList = document.getElementById("TraditionalknowledgecategoryList");
	var liElems = UiTraditionalknowledgecategoryList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverTraditionalknowledgecategoryRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutTraditionalknowledgecategoryRow, false);
		
	}
	
	var UiTraditionalknowledgecategoryListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiTraditionalknowledgecategoryListDeletebtns.length; z++) {
			UiTraditionalknowledgecategoryListDeletebtns[z].addEventListener('mousedown', Event_mouseDownTraditionalknowledgecategoryRowBtn, false);			
		
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
	UI_search_Traditionalknowledgecategory(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownTraditionalknowledgecategoryRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Traditionalknowledgecategory = Get_TraditionalknowledgecategoryByListRow(this.parentNode.parentNode);
			if(obj_Traditionalknowledgecategory != ""){
				deleteTraditionalknowledgecategory(obj_Traditionalknowledgecategory.CategoryId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Traditionalknowledgecategory = Get_TraditionalknowledgecategoryByListRow(this.parentNode.parentNode);
			if(obj_Traditionalknowledgecategory != ""){
				UI_showUpdateTraditionalknowledgecategoryForm(obj_Traditionalknowledgecategory);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Traditionalknowledgecategory(searchText)
{

	//TraditionalknowledgecategoryList = 
	var TraditionalknowledgecategoryListElem = document.getElementById("TraditionalknowledgecategoryList");
	
	if(TraditionalknowledgecategoryListElem)
	{
		var TraditionalknowledgecategoryDataList = TraditionalknowledgecategoryListElem.getElementsByTagName("input");
		for(var y=0 in TraditionalknowledgecategoryDataList)
		{
			if(TraditionalknowledgecategoryDataList[y])
			{
				
				
				var displayType = "none";
				var TraditionalknowledgecategoryData = TraditionalknowledgecategoryDataList[y].value;
				if(!((TraditionalknowledgecategoryData == "") || (typeof TraditionalknowledgecategoryData=="undefined")))
				{
				if(search_Traditionalknowledgecategory(TraditionalknowledgecategoryData,searchText))
				{
					displayType = "block";
				}
				TraditionalknowledgecategoryDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Traditionalknowledgecategory(TraditionalknowledgecategoryData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	TraditionalknowledgecategoryData = decodeSpText(TraditionalknowledgecategoryData.toLowerCase());
	if(TraditionalknowledgecategoryData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Traditionalknowledgecategory)
{
	if (obj_Traditionalknowledgecategory.CategoryId) {
		var fieldDataId = obj_Traditionalknowledgecategory.CategoryId;
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

function deleteTraditionalknowledgecategory(CategoryId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Traditionalknowledgecategory");
	if(flag){
			DeleteTraditionalknowledgecategoryPacket(CategoryId);
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

function Get_TraditionalknowledgecategoryByListRow(listRowElem)
{
	
	var obj_Traditionalknowledgecategory ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var TraditionalknowledgecategoryData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				TraditionalknowledgecategoryData = elemlist[z].value;
			}		
		}
		
		if(TraditionalknowledgecategoryData != "")
		{
		var arrTraditionalknowledgecategoryData = TraditionalknowledgecategoryData.split(";");	
		
		obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		obj_Traditionalknowledgecategory.CategoryId= arrTraditionalknowledgecategoryData[0];
		obj_Traditionalknowledgecategory.CategoryName= arrTraditionalknowledgecategoryData[1];
		obj_Traditionalknowledgecategory.Description= arrTraditionalknowledgecategoryData[2];

		
		
		}
		
	}
	
	return obj_Traditionalknowledgecategory;
	
	
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
	
			var Elem = document.getElementById("Input_CategoryName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Catagory Name";
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
	
		var obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		
		var CategoryId= document.getElementById("Input_CategoryId").value;
		var CategoryName= document.getElementById("Input_CategoryName").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_CategoryId").value="";
		document.getElementById("Input_CategoryName").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();
		obj_Traditionalknowledgecategory.CategoryId= CategoryId;
		obj_Traditionalknowledgecategory.CategoryName= CategoryName;
		obj_Traditionalknowledgecategory.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddTraditionalknowledgecategoryPacket(dummyId,obj_Traditionalknowledgecategory);
		UI_createTraditionalknowledgecategoryRow(obj_Traditionalknowledgecategory, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Traditionalknowledgecategory = new Traditionalknowledgecategory();

		obj_Traditionalknowledgecategory.CategoryId= CategoryId;
		obj_Traditionalknowledgecategory.CategoryName= CategoryName;
		obj_Traditionalknowledgecategory.Description= Description;

		
		UpdateTraditionalknowledgecategoryPacket(obj_Traditionalknowledgecategory);
		UI_createTraditionalknowledgecategoryRow(obj_Traditionalknowledgecategory, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addTraditionalknowledgecategory() {
	
	UI_showAddTraditionalknowledgecategoryForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddTraditionalknowledgecategoryForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTraditionalknowledgecategoryAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTraditionalknowledgecategoryform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateTraditionalknowledgecategoryForm(obj_Traditionalknowledgecategory) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareTraditionalknowledgecategoryUpdateForm(obj_Traditionalknowledgecategory);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popTraditionalknowledgecategoryform"));
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
function UI_prepareTraditionalknowledgecategoryUpdateForm(obj_Traditionalknowledgecategory)
{
	var arr_hidelist = new Array("Input_CategoryId");
	var arr_showlist = new Array("Input_CategoryName","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_CategoryId").value=obj_Traditionalknowledgecategory.CategoryId;
		document.getElementById("Input_CategoryName").value=obj_Traditionalknowledgecategory.CategoryName;
		document.getElementById("Input_Description").value=obj_Traditionalknowledgecategory.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareTraditionalknowledgecategoryAddForm()
{
	var arr_hidelist = new Array("Input_CategoryId");
	var arr_showlist = new Array("Input_CategoryName","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_CategoryId").value="";
		document.getElementById("Input_CategoryName").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addTraditionalknowledgecategoryToTraditionalknowledgecategoryList() {
	var uiTraditionalknowledgecategoryList = document.getElementById("TraditionalknowledgecategoryList");

	var rowElems = uiTraditionalknowledgecategoryList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createTraditionalknowledgecategoryRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownTraditionalknowledgecategoryRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTraditionalknowledgecategoryRowHtmlElem(obj_Traditionalknowledgecategory,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "TraditionalknowledgecategoryImg_"+obj_Traditionalknowledgecategory.CategoryId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Traditionalknowledgecategory/0_small.png";
	else ImgElem.src = "Traditionalknowledgecategory/"+obj_Traditionalknowledgecategory.CategoryId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Traditionalknowledgecategory.CategoryId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Traditionalknowledgecategory.CategoryName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Traditionalknowledgecategory.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Traditionalknowledgecategorydata"+ElemId);
		ElementDataHidden.value = obj_Traditionalknowledgecategory.getTraditionalknowledgecategoryData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);

		
		ElemLi= UI_createTraditionalknowledgecategoryRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverTraditionalknowledgecategoryRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutTraditionalknowledgecategoryRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubTraditionalknowledgecategoryHtmlElem(obj_Traditionalknowledgecategory)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subTraditionalknowledgecategory");
		html ="<a href=\"?page=dashboard&CategoryId="+obj_Traditionalknowledgecategory.CategoryId+"\">"+obj_Traditionalknowledgecategory.CategoryId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverTraditionalknowledgecategoryRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutTraditionalknowledgecategoryRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTraditionalknowledgecategoryRow(obj_Traditionalknowledgecategory, rowType,dummyId) {
	var html = "";
	
	var UiTraditionalknowledgecategoryList = document.getElementById("TraditionalknowledgecategoryList");
	var ClassName = "ListRow";
	var ElemId = "TraditionalknowledgecategoryListRow_"+obj_Traditionalknowledgecategory.CategoryId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyTraditionalknowledgecategoryRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createTraditionalknowledgecategoryRowHtmlElem(obj_Traditionalknowledgecategory,ElemId, ClassName);
			UiTraditionalknowledgecategoryList.insertBefore(ElemLi, UiTraditionalknowledgecategoryList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Traditionalknowledgecategory msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createTraditionalknowledgecategoryRowHtmlElem(obj_Traditionalknowledgecategory,ElemId, ClassName);
			UiTraditionalknowledgecategoryList.insertBefore(ElemLi, UiTraditionalknowledgecategoryList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyTraditionalknowledgecategoryRow_"+dummyId);
			var DummyData = document.getElementById("TraditionalknowledgecategorydataDummyTraditionalknowledgecategoryRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Traditionalknowledgecategorydata"+ElemId);		
				DummyData.value = obj_Traditionalknowledgecategory.getTraditionalknowledgecategoryData();		
				}
				UI_createTopbarSubTraditionalknowledgecategoryHtmlElem(obj_Traditionalknowledgecategory);
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
				var ElemLi = UI_createTraditionalknowledgecategoryRowHtmlElem(obj_Traditionalknowledgecategory,ElemId, ClassName);
				UiTraditionalknowledgecategoryList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("TraditionalknowledgecategoryList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, CategoryId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("TraditionalknowledgecategoryListRow_"+CategoryId);
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


