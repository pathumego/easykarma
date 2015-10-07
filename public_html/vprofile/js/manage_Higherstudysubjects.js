//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Higherstudysubjects_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addHigherstudysubjects(mainPacket);
			break;
		}
		case 201: {
			ACK_addHigherstudysubjects(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteHigherstudysubjects(mainPacket);
			break;
		}
		case 203: {
			ACK_updateHigherstudysubjects(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addHigherstudysubjects(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Higherstudysubjects = new Higherstudysubjects();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Higherstudysubjects.SubjectId= mainPacket[3];
		obj_Higherstudysubjects.SubjectName= mainPacket[4];
		obj_Higherstudysubjects.SubjectNumber= mainPacket[5];
		obj_Higherstudysubjects.SubjectField= mainPacket[6];
		obj_Higherstudysubjects.Level= mainPacket[7];



		if (resultStatus == 1) {	
			
			UI_createHigherstudysubjectsRow(obj_Higherstudysubjects, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteHigherstudysubjects(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Higherstudysubjects = new Higherstudysubjects();
		
		var resultStatus = mainPacket[0];
		var SubjectId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("HigherstudysubjectsListRow_"+SubjectId);
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
				var rowElem = document.getElementById("HigherstudysubjectsListRow_"+SubjectId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateHigherstudysubjects(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Higherstudysubjects = new Higherstudysubjects();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Higherstudysubjects.SubjectId= mainPacket[2];
		obj_Higherstudysubjects.SubjectName= mainPacket[3];
		obj_Higherstudysubjects.SubjectNumber= mainPacket[4];
		obj_Higherstudysubjects.SubjectField= mainPacket[5];
		obj_Higherstudysubjects.Level= mainPacket[6];


		if (resultStatus == 1) {			
			UI_createHigherstudysubjectsRow(obj_Higherstudysubjects, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Higherstudysubjects_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingHigherstudysubjectsPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Higherstudysubjects; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteHigherstudysubjectsPacket(SubjectId) {
	var deletePacketBody  = SubjectId;

	var postpacket = createOutgoingHigherstudysubjectsPacket(202,deletePacketBody);
	Higherstudysubjects_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateHigherstudysubjectsPacket(obj_Higherstudysubjects) {
	var savePacketBody  = obj_Higherstudysubjects.createHigherstudysubjectsPacket();

	var postpacket = createOutgoingHigherstudysubjectsPacket(203,savePacketBody);
	Higherstudysubjects_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddHigherstudysubjectsPacket(dummyId,obj_Higherstudysubjects) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Higherstudysubjects.createHigherstudysubjectsPacket();

	var postpacket = createOutgoingHigherstudysubjectsPacket(201,savePacketBody);
	Higherstudysubjects_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onHigherstudysubjectsPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onHigherstudysubjectsPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addHigherstudysubjects = document.getElementById("btnaddHigherstudysubjects");
	if(addHigherstudysubjects){
	addHigherstudysubjects.addEventListener('mousedown', Event_mousedown_addHigherstudysubjects, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popHigherstudysubjectsform = document.getElementById("popHigherstudysubjectsform");
	var inputElems = popHigherstudysubjectsform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiHigherstudysubjectsList = document.getElementById("HigherstudysubjectsList");
	var liElems = UiHigherstudysubjectsList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverHigherstudysubjectsRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutHigherstudysubjectsRow, false);
		
	}
	
	var UiHigherstudysubjectsListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiHigherstudysubjectsListDeletebtns.length; z++) {
			UiHigherstudysubjectsListDeletebtns[z].addEventListener('mousedown', Event_mouseDownHigherstudysubjectsRowBtn, false);			
		
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
	UI_search_Higherstudysubjects(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownHigherstudysubjectsRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Higherstudysubjects = Get_HigherstudysubjectsByListRow(this.parentNode.parentNode);
			if(obj_Higherstudysubjects != ""){
				deleteHigherstudysubjects(obj_Higherstudysubjects.SubjectId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Higherstudysubjects = Get_HigherstudysubjectsByListRow(this.parentNode.parentNode);
			if(obj_Higherstudysubjects != ""){
				UI_showUpdateHigherstudysubjectsForm(obj_Higherstudysubjects);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Higherstudysubjects(searchText)
{

	//HigherstudysubjectsList = 
	var HigherstudysubjectsListElem = document.getElementById("HigherstudysubjectsList");
	
	if(HigherstudysubjectsListElem)
	{
		var HigherstudysubjectsDataList = HigherstudysubjectsListElem.getElementsByTagName("input");
		for(var y=0 in HigherstudysubjectsDataList)
		{
			if(HigherstudysubjectsDataList[y])
			{
				
				
				var displayType = "none";
				var HigherstudysubjectsData = HigherstudysubjectsDataList[y].value;
				if(!((HigherstudysubjectsData == "") || (typeof HigherstudysubjectsData=="undefined")))
				{
				if(search_Higherstudysubjects(HigherstudysubjectsData,searchText))
				{
					displayType = "block";
				}
				HigherstudysubjectsDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Higherstudysubjects(HigherstudysubjectsData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	HigherstudysubjectsData = decodeSpText(HigherstudysubjectsData.toLowerCase());
	if(HigherstudysubjectsData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Higherstudysubjects)
{
	if (obj_Higherstudysubjects.SubjectId) {
		var fieldDataId = obj_Higherstudysubjects.SubjectId;
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

function deleteHigherstudysubjects(SubjectId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Higherstudysubjects");
	if(flag){
			DeleteHigherstudysubjectsPacket(SubjectId);
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

function Get_HigherstudysubjectsByListRow(listRowElem)
{
	
	var obj_Higherstudysubjects ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var HigherstudysubjectsData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				HigherstudysubjectsData = elemlist[z].value;
			}		
		}
		
		if(HigherstudysubjectsData != "")
		{
		var arrHigherstudysubjectsData = HigherstudysubjectsData.split(";");	
		
		obj_Higherstudysubjects = new Higherstudysubjects();
		obj_Higherstudysubjects.SubjectId= arrHigherstudysubjectsData[0];
		obj_Higherstudysubjects.SubjectName= arrHigherstudysubjectsData[1];
		obj_Higherstudysubjects.SubjectNumber= arrHigherstudysubjectsData[2];
		obj_Higherstudysubjects.SubjectField= arrHigherstudysubjectsData[3];
		obj_Higherstudysubjects.Level= arrHigherstudysubjectsData[4];

		
		
		}
		
	}
	
	return obj_Higherstudysubjects;
	
	
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
					error = "please Enter Subject Name";
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
	
		var obj_Higherstudysubjects = new Higherstudysubjects();
		
		var SubjectId= document.getElementById("Input_SubjectId").value;
		var SubjectName= document.getElementById("Input_SubjectName").value;
		var SubjectNumber= document.getElementById("Input_SubjectNumber").value;
		var SubjectField= document.getElementById("Input_SubjectField").value;
		var Level= document.getElementById("Input_Level").value;

		
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SubjectName").value="";
		document.getElementById("Input_SubjectNumber").value="";
		document.getElementById("Input_SubjectField").value="";
		document.getElementById("Input_Level").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Higherstudysubjects = new Higherstudysubjects();
		obj_Higherstudysubjects.SubjectId= SubjectId;
		obj_Higherstudysubjects.SubjectName= SubjectName;
		obj_Higherstudysubjects.SubjectNumber= SubjectNumber;
		obj_Higherstudysubjects.SubjectField= SubjectField;
		obj_Higherstudysubjects.Level= Level;

		
		var dummyId = CreateDummyNumber();
		AddHigherstudysubjectsPacket(dummyId,obj_Higherstudysubjects);
		UI_createHigherstudysubjectsRow(obj_Higherstudysubjects, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Higherstudysubjects = new Higherstudysubjects();

		obj_Higherstudysubjects.SubjectId= SubjectId;
		obj_Higherstudysubjects.SubjectName= SubjectName;
		obj_Higherstudysubjects.SubjectNumber= SubjectNumber;
		obj_Higherstudysubjects.SubjectField= SubjectField;
		obj_Higherstudysubjects.Level= Level;

		
		UpdateHigherstudysubjectsPacket(obj_Higherstudysubjects);
		UI_createHigherstudysubjectsRow(obj_Higherstudysubjects, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addHigherstudysubjects() {
	
	UI_showAddHigherstudysubjectsForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddHigherstudysubjectsForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareHigherstudysubjectsAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popHigherstudysubjectsform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateHigherstudysubjectsForm(obj_Higherstudysubjects) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareHigherstudysubjectsUpdateForm(obj_Higherstudysubjects);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popHigherstudysubjectsform"));
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
function UI_prepareHigherstudysubjectsUpdateForm(obj_Higherstudysubjects)
{
	var arr_hidelist = new Array("Input_SubjectId");
	var arr_showlist = new Array("Input_SubjectName","Input_SubjectNumber","Input_SubjectField","Input_Level");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SubjectId").value=obj_Higherstudysubjects.SubjectId;
		document.getElementById("Input_SubjectName").value=obj_Higherstudysubjects.SubjectName;
		document.getElementById("Input_SubjectNumber").value=obj_Higherstudysubjects.SubjectNumber;
		document.getElementById("Input_SubjectField").value=obj_Higherstudysubjects.SubjectField;
		document.getElementById("Input_Level").value=obj_Higherstudysubjects.Level;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareHigherstudysubjectsAddForm()
{
	var arr_hidelist = new Array("Input_SubjectId");
	var arr_showlist = new Array("Input_SubjectName","Input_SubjectNumber","Input_SubjectField","Input_Level");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_SubjectId").value="";
		document.getElementById("Input_SubjectName").value="";
		document.getElementById("Input_SubjectNumber").value="";
		document.getElementById("Input_SubjectField").value="";
		document.getElementById("Input_Level").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addHigherstudysubjectsToHigherstudysubjectsList() {
	var uiHigherstudysubjectsList = document.getElementById("HigherstudysubjectsList");

	var rowElems = uiHigherstudysubjectsList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createHigherstudysubjectsRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownHigherstudysubjectsRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createHigherstudysubjectsRowHtmlElem(obj_Higherstudysubjects,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "HigherstudysubjectsImg_"+obj_Higherstudysubjects.SubjectId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Higherstudysubjects/0_small.png";
	else ImgElem.src = "Higherstudysubjects/"+obj_Higherstudysubjects.SubjectId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Higherstudysubjects.SubjectId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Higherstudysubjects.SubjectName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Higherstudysubjects.SubjectNumber;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Higherstudysubjects.SubjectField;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Higherstudysubjects.Level;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Higherstudysubjectsdata"+ElemId);
		ElementDataHidden.value = obj_Higherstudysubjects.getHigherstudysubjectsData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);
		ElemLi.appendChild(ElemDataRow6);

		
		ElemLi= UI_createHigherstudysubjectsRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverHigherstudysubjectsRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutHigherstudysubjectsRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubHigherstudysubjectsHtmlElem(obj_Higherstudysubjects)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subHigherstudysubjects");
		html ="<a href=\"?page=dashboard&SubjectId="+obj_Higherstudysubjects.SubjectId+"\">"+obj_Higherstudysubjects.SubjectId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverHigherstudysubjectsRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutHigherstudysubjectsRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createHigherstudysubjectsRow(obj_Higherstudysubjects, rowType,dummyId) {
	var html = "";
	
	var UiHigherstudysubjectsList = document.getElementById("HigherstudysubjectsList");
	var ClassName = "ListRow";
	var ElemId = "HigherstudysubjectsListRow_"+obj_Higherstudysubjects.SubjectId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyHigherstudysubjectsRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createHigherstudysubjectsRowHtmlElem(obj_Higherstudysubjects,ElemId, ClassName);
			UiHigherstudysubjectsList.insertBefore(ElemLi, UiHigherstudysubjectsList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Higherstudysubjects msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createHigherstudysubjectsRowHtmlElem(obj_Higherstudysubjects,ElemId, ClassName);
			UiHigherstudysubjectsList.insertBefore(ElemLi, UiHigherstudysubjectsList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyHigherstudysubjectsRow_"+dummyId);
			var DummyData = document.getElementById("HigherstudysubjectsdataDummyHigherstudysubjectsRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Higherstudysubjectsdata"+ElemId);		
				DummyData.value = obj_Higherstudysubjects.getHigherstudysubjectsData();		
				}
				UI_createTopbarSubHigherstudysubjectsHtmlElem(obj_Higherstudysubjects);
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
				var ElemLi = UI_createHigherstudysubjectsRowHtmlElem(obj_Higherstudysubjects,ElemId, ClassName);
				UiHigherstudysubjectsList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("HigherstudysubjectsList");
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
		var profileAvatar = document.getElementById("HigherstudysubjectsListRow_"+SubjectId);
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


