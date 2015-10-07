//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Plants_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addPlants(mainPacket);
			break;
		}
		case 201: {
			ACK_addPlants(mainPacket);
			break;
		}
		case 202: {
			ACK_deletePlants(mainPacket);
			break;
		}
		case 203: {
			ACK_updatePlants(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addPlants(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Plants = new Plants();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Plants.PlantId= mainPacket[3];
		obj_Plants.Name= mainPacket[4];
		obj_Plants.Description= mainPacket[5];
		obj_Plants.BioName= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createPlantsRow(obj_Plants, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deletePlants(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Plants = new Plants();
		
		var resultStatus = mainPacket[0];
		var PlantId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("PlantsListRow_"+PlantId);
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
				var rowElem = document.getElementById("PlantsListRow_"+PlantId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updatePlants(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Plants = new Plants();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Plants.PlantId= mainPacket[2];
		obj_Plants.Name= mainPacket[3];
		obj_Plants.Description= mainPacket[4];
		obj_Plants.BioName= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createPlantsRow(obj_Plants, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Plants_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingPlantsPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Plants; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeletePlantsPacket(PlantId) {
	var deletePacketBody  = PlantId;

	var postpacket = createOutgoingPlantsPacket(202,deletePacketBody);
	Plants_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdatePlantsPacket(obj_Plants) {
	var savePacketBody  = obj_Plants.createPlantsPacket();

	var postpacket = createOutgoingPlantsPacket(203,savePacketBody);
	Plants_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddPlantsPacket(dummyId,obj_Plants) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Plants.createPlantsPacket();

	var postpacket = createOutgoingPlantsPacket(201,savePacketBody);
	Plants_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onPlantsPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onPlantsPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addPlants = document.getElementById("btnaddPlants");
	if(addPlants){
	addPlants.addEventListener('mousedown', Event_mousedown_addPlants, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popPlantsform = document.getElementById("popPlantsform");
	var inputElems = popPlantsform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiPlantsList = document.getElementById("PlantsList");
	var liElems = UiPlantsList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverPlantsRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutPlantsRow, false);
		
	}
	
	var UiPlantsListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiPlantsListDeletebtns.length; z++) {
			UiPlantsListDeletebtns[z].addEventListener('mousedown', Event_mouseDownPlantsRowBtn, false);			
		
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
	UI_search_Plants(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownPlantsRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Plants = Get_PlantsByListRow(this.parentNode.parentNode);
			if(obj_Plants != ""){
				deletePlants(obj_Plants.PlantId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Plants = Get_PlantsByListRow(this.parentNode.parentNode);
			if(obj_Plants != ""){
				UI_showUpdatePlantsForm(obj_Plants);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Plants(searchText)
{

	//PlantsList = 
	var PlantsListElem = document.getElementById("PlantsList");
	
	if(PlantsListElem)
	{
		var PlantsDataList = PlantsListElem.getElementsByTagName("input");
		for(var y=0 in PlantsDataList)
		{
			if(PlantsDataList[y])
			{
				
				
				var displayType = "none";
				var PlantsData = PlantsDataList[y].value;
				if(!((PlantsData == "") || (typeof PlantsData=="undefined")))
				{
				if(search_Plants(PlantsData,searchText))
				{
					displayType = "block";
				}
				PlantsDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Plants(PlantsData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	PlantsData = decodeSpText(PlantsData.toLowerCase());
	if(PlantsData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Plants)
{
	if (obj_Plants.PlantId) {
		var fieldDataId = obj_Plants.PlantId;
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

function deletePlants(PlantId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Plants");
	if(flag){
			DeletePlantsPacket(PlantId);
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

function Get_PlantsByListRow(listRowElem)
{
	
	var obj_Plants ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var PlantsData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				PlantsData = elemlist[z].value;
			}		
		}
		
		if(PlantsData != "")
		{
		var arrPlantsData = PlantsData.split(";");	
		
		obj_Plants = new Plants();
		obj_Plants.PlantId= arrPlantsData[0];
		obj_Plants.Name= arrPlantsData[1];
		obj_Plants.Description= arrPlantsData[2];
		obj_Plants.BioName= arrPlantsData[3];

		
		
		}
		
	}
	
	return obj_Plants;
	
	
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
					error = "Please enter plant name";
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
	
		var obj_Plants = new Plants();
		
		var PlantId= document.getElementById("Input_PlantId").value;
		var Name= document.getElementById("Input_Name").value;
		var Description= document.getElementById("Input_Description").value;
		var BioName= document.getElementById("Input_BioName").value;

		
		document.getElementById("Input_PlantId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_BioName").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Plants = new Plants();
		obj_Plants.PlantId= PlantId;
		obj_Plants.Name= Name;
		obj_Plants.Description= Description;
		obj_Plants.BioName= BioName;

		
		var dummyId = CreateDummyNumber();
		AddPlantsPacket(dummyId,obj_Plants);
		UI_createPlantsRow(obj_Plants, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Plants = new Plants();

		obj_Plants.PlantId= PlantId;
		obj_Plants.Name= Name;
		obj_Plants.Description= Description;
		obj_Plants.BioName= BioName;

		
		UpdatePlantsPacket(obj_Plants);
		UI_createPlantsRow(obj_Plants, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addPlants() {
	
	UI_showAddPlantsForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddPlantsForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePlantsAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPlantsform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdatePlantsForm(obj_Plants) {
	document.getElementById("formerror").innerHTML = "";
	UI_preparePlantsUpdateForm(obj_Plants);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popPlantsform"));
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
function UI_preparePlantsUpdateForm(obj_Plants)
{
	var arr_hidelist = new Array("Input_PlantId");
	var arr_showlist = new Array("Input_Name","Input_Description","Input_BioName");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PlantId").value=obj_Plants.PlantId;
		document.getElementById("Input_Name").value=obj_Plants.Name;
		document.getElementById("Input_Description").value=obj_Plants.Description;
		document.getElementById("Input_BioName").value=obj_Plants.BioName;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_preparePlantsAddForm()
{
	var arr_hidelist = new Array("Input_PlantId");
	var arr_showlist = new Array("Input_Name","Input_Description","Input_BioName");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_PlantId").value="";
		document.getElementById("Input_Name").value="";
		document.getElementById("Input_Description").value="";
		document.getElementById("Input_BioName").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addPlantsToPlantsList() {
	var uiPlantsList = document.getElementById("PlantsList");

	var rowElems = uiPlantsList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createPlantsRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownPlantsRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPlantsRowHtmlElem(obj_Plants,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "PlantsImg_"+obj_Plants.PlantId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Plants/0_small.png";
	else ImgElem.src = "Plants/"+obj_Plants.PlantId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Plants.PlantId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Plants.Name;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Plants.Description;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Plants.BioName;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Plantsdata"+ElemId);
		ElementDataHidden.value = obj_Plants.getPlantsData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createPlantsRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverPlantsRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutPlantsRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubPlantsHtmlElem(obj_Plants)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subPlants");
		html ="<a href=\"?page=dashboard&PlantId="+obj_Plants.PlantId+"\">"+obj_Plants.PlantId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverPlantsRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutPlantsRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createPlantsRow(obj_Plants, rowType,dummyId) {
	var html = "";
	
	var UiPlantsList = document.getElementById("PlantsList");
	var ClassName = "ListRow";
	var ElemId = "PlantsListRow_"+obj_Plants.PlantId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyPlantsRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createPlantsRowHtmlElem(obj_Plants,ElemId, ClassName);
			UiPlantsList.insertBefore(ElemLi, UiPlantsList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Plants msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createPlantsRowHtmlElem(obj_Plants,ElemId, ClassName);
			UiPlantsList.insertBefore(ElemLi, UiPlantsList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyPlantsRow_"+dummyId);
			var DummyData = document.getElementById("PlantsdataDummyPlantsRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Plantsdata"+ElemId);		
				DummyData.value = obj_Plants.getPlantsData();		
				}
				UI_createTopbarSubPlantsHtmlElem(obj_Plants);
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
				var ElemLi = UI_createPlantsRowHtmlElem(obj_Plants,ElemId, ClassName);
				UiPlantsList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("PlantsList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, PlantId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("PlantsListRow_"+PlantId);
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


