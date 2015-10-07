//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Language_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addLanguage(mainPacket);
			break;
		}
		case 201: {
			ACK_addLanguage(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteLanguage(mainPacket);
			break;
		}
		case 203: {
			ACK_updateLanguage(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addLanguage(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Language = new Language();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Language.LangId= mainPacket[3];
		obj_Language.LangTag= mainPacket[4];
		obj_Language.English= mainPacket[5];
		obj_Language.Sinhala= mainPacket[6];
		obj_Language.Tamil= mainPacket[7];
		obj_Language.Bangla= mainPacket[8];
		obj_Language.Nepali= mainPacket[9];
		obj_Language.Lang1= mainPacket[10];
		obj_Language.Lang2= mainPacket[11];
		obj_Language.Lang3= mainPacket[12];



		if (resultStatus == 1) {	
			
			UI_createLanguageRow(obj_Language, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteLanguage(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Language = new Language();
		
		var resultStatus = mainPacket[0];
		var LangId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("LanguageListRow_"+LangId);
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
				var rowElem = document.getElementById("LanguageListRow_"+LangId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateLanguage(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Language = new Language();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Language.LangId= mainPacket[2];
		obj_Language.LangTag= mainPacket[3];
		obj_Language.English= mainPacket[4];
		obj_Language.Sinhala= mainPacket[5];
		obj_Language.Tamil= mainPacket[6];
		obj_Language.Bangla= mainPacket[7];
		obj_Language.Nepali= mainPacket[8];
		obj_Language.Lang1= mainPacket[9];
		obj_Language.Lang2= mainPacket[10];
		obj_Language.Lang3= mainPacket[11];


		if (resultStatus == 1) {			
			UI_createLanguageRow(obj_Language, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Language_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingLanguagePacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Language; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteLanguagePacket(LangId) {
	var deletePacketBody  = LangId;

	var postpacket = createOutgoingLanguagePacket(202,deletePacketBody);
	Language_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateLanguagePacket(obj_Language) {
	var savePacketBody  = obj_Language.createLanguagePacket();

	var postpacket = createOutgoingLanguagePacket(203,savePacketBody);
	Language_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddLanguagePacket(dummyId,obj_Language) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Language.createLanguagePacket();

	var postpacket = createOutgoingLanguagePacket(201,savePacketBody);
	Language_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onLanguagePageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onLanguagePageLoad() {
	Init_Language_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_Language_eventbind() {

	var addLanguage = document.getElementById("btnaddLanguage");
	if(addLanguage){
	addLanguage.addEventListener('mousedown', Event_mousedown_addLanguage, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popLanguageform = document.getElementById("popLanguageform");
	var inputElems = popLanguageform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiLanguageList = document.getElementById("LanguageList");
	var liElems = UiLanguageList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverLanguageRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutLanguageRow, false);
		
	}
	
	var UiLanguageListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiLanguageListDeletebtns.length; z++) {
			UiLanguageListDeletebtns[z].addEventListener('mousedown', Event_mouseDownLanguageRowBtn, false);			
		
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
	UI_search_Language(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownLanguageRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Language = Get_LanguageByListRow(this.parentNode.parentNode);
			if(obj_Language != ""){
				deleteLanguage(obj_Language.LangId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Language = Get_LanguageByListRow(this.parentNode.parentNode);
			if(obj_Language != ""){
				UI_showUpdateLanguageForm(obj_Language);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Language(searchText)
{

	//LanguageList = 
	var LanguageListElem = document.getElementById("LanguageList");
	
	if(LanguageListElem)
	{
		var LanguageDataList = LanguageListElem.getElementsByTagName("input");
		for(var y=0 in LanguageDataList)
		{
			if(LanguageDataList[y])
			{
				
				
				var displayType = "none";
				var LanguageData = LanguageDataList[y].value;
				if(!((LanguageData == "") || (typeof LanguageData=="undefined")))
				{
				if(search_Language(LanguageData,searchText))
				{
					displayType = "block";
				}
				LanguageDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Language(LanguageData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	LanguageData = decodeSpText(LanguageData.toLowerCase());
	if(LanguageData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Language)
{
	if (obj_Language.LangId) {
		var fieldDataId = obj_Language.LangId;
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

function deleteLanguage(LangId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Language");
	if(flag){
			DeleteLanguagePacket(LangId);
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

function Get_LanguageByListRow(listRowElem)
{
	
	var obj_Language ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var LanguageData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				LanguageData = elemlist[z].value;
			}		
		}
		
		if(LanguageData != "")
		{
		var arrLanguageData = LanguageData.split(";");	
		
		obj_Language = new Language();
		obj_Language.LangId= arrLanguageData[0];
		obj_Language.LangTag= arrLanguageData[1];
		obj_Language.English= arrLanguageData[2];
		obj_Language.Sinhala= arrLanguageData[3];
		obj_Language.Tamil= arrLanguageData[4];
		obj_Language.Bangla= arrLanguageData[5];
		obj_Language.Nepali= arrLanguageData[6];
		obj_Language.Lang1= arrLanguageData[7];
		obj_Language.Lang2= arrLanguageData[8];
		obj_Language.Lang3= arrLanguageData[9];

		
		
		}
		
	}
	
	return obj_Language;
	
	
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
	/*
	var iserror =false;
		var errorMsg = "";
	

		var Elem = document.getElementById("Input_LanguagePrice");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter Language price";
					Elem.focus();
				}				
				else if(isNaN(Elem.value))
				{
					Elem.value="";
					iserror =true;
					error = "Invalid price";	
					Elem.focus();		
				}
	
			}
			
		    Elem = document.getElementById("Input_LanguageName");
			if(Elem)
			{
				if(Elem.value =="")
				{
				Elem.focus();
				iserror =true;
				error = "Please enter Language name";	
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
	*/
	
	return false;
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_form_addbtn(event) {
	

	if(validate_form())
	{
	event.preventDefault();
	return false;
	}
	
		var obj_Language = new Language();
		
		var LangId= document.getElementById("Input_LangId").value;
		var LangTag= document.getElementById("Input_LangTag").value;
		var English= document.getElementById("Input_English").value;
		var Sinhala= document.getElementById("Input_Sinhala").value;
		var Tamil= document.getElementById("Input_Tamil").value;
		var Bangla= document.getElementById("Input_Bangla").value;
		var Nepali= document.getElementById("Input_Nepali").value;
		var Lang1= document.getElementById("Input_Lang1").value;
		var Lang2= document.getElementById("Input_Lang2").value;
		var Lang3= document.getElementById("Input_Lang3").value;

		
		document.getElementById("Input_LangId").value="";
		document.getElementById("Input_LangTag").value="";
		document.getElementById("Input_English").value="";
		document.getElementById("Input_Sinhala").value="";
		document.getElementById("Input_Tamil").value="";
		document.getElementById("Input_Bangla").value="";
		document.getElementById("Input_Nepali").value="";
		document.getElementById("Input_Lang1").value="";
		document.getElementById("Input_Lang2").value="";
		document.getElementById("Input_Lang3").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Language = new Language();
		obj_Language.LangId= LangId;
		obj_Language.LangTag= LangTag;
		obj_Language.English= English;
		obj_Language.Sinhala= Sinhala;
		obj_Language.Tamil= Tamil;
		obj_Language.Bangla= Bangla;
		obj_Language.Nepali= Nepali;
		obj_Language.Lang1= Lang1;
		obj_Language.Lang2= Lang2;
		obj_Language.Lang3= Lang3;

		
		var dummyId = CreateDummyNumber();
		AddLanguagePacket(dummyId,obj_Language);
		UI_createLanguageRow(obj_Language, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Language = new Language();

		obj_Language.LangId= LangId;
		obj_Language.LangTag= LangTag;
		obj_Language.English= English;
		obj_Language.Sinhala= Sinhala;
		obj_Language.Tamil= Tamil;
		obj_Language.Bangla= Bangla;
		obj_Language.Nepali= Nepali;
		obj_Language.Lang1= Lang1;
		obj_Language.Lang2= Lang2;
		obj_Language.Lang3= Lang3;

		
		UpdateLanguagePacket(obj_Language);
		UI_createLanguageRow(obj_Language, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addLanguage() {
	
	UI_showAddLanguageForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddLanguageForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareLanguageAddForm();
	if(elemformPopup != null)
	{
	elemformPopup.hide();	
	}
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popLanguageform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateLanguageForm(obj_Language) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareLanguageUpdateForm(obj_Language);
	if(elemformPopup != null)
	{
	elemformPopup.hide();	
	}
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popLanguageform"));
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
function UI_prepareLanguageUpdateForm(obj_Language)
{
	var arr_hidelist = new Array("Input_LangId");
	var arr_showlist = new Array("Input_LangTag","Input_English","Input_Sinhala","Input_Tamil","Input_Bangla","Input_Nepali","Input_Lang1","Input_Lang2","Input_Lang3");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_LangId").value=obj_Language.LangId;
		document.getElementById("Input_LangTag").value=obj_Language.LangTag;
		document.getElementById("Input_English").value=obj_Language.English;
		document.getElementById("Input_Sinhala").value=obj_Language.Sinhala;
		document.getElementById("Input_Tamil").value=obj_Language.Tamil;
		document.getElementById("Input_Bangla").value=obj_Language.Bangla;
		document.getElementById("Input_Nepali").value=obj_Language.Nepali;
		document.getElementById("Input_Lang1").value=obj_Language.Lang1;
		document.getElementById("Input_Lang2").value=obj_Language.Lang2;
		document.getElementById("Input_Lang3").value=obj_Language.Lang3;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareLanguageAddForm()
{
	var arr_hidelist = new Array("Input_LangId");
	var arr_showlist = new Array("Input_LangTag","Input_English","Input_Sinhala","Input_Tamil","Input_Bangla","Input_Nepali","Input_Lang1","Input_Lang2","Input_Lang3");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_LangId").value="";
		document.getElementById("Input_LangTag").value="";
		document.getElementById("Input_English").value="";
		document.getElementById("Input_Sinhala").value="";
		document.getElementById("Input_Tamil").value="";
		document.getElementById("Input_Bangla").value="";
		document.getElementById("Input_Nepali").value="";
		document.getElementById("Input_Lang1").value="";
		document.getElementById("Input_Lang2").value="";
		document.getElementById("Input_Lang3").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addLanguageToLanguageList() {
	var uiLanguageList = document.getElementById("LanguageList");

	var rowElems = uiLanguageList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createLanguageRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownLanguageRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createLanguageRowHtmlElem(obj_Language,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "LanguageImg_"+obj_Language.LangId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Language/0_small.png";
	else ImgElem.src = "Language/"+obj_Language.LangId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Language.LangId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Language.LangTag;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Language.English;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Language.Sinhala;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_Language.Tamil;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_Language.Bangla;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_Language.Nepali;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow";
		ElemDataRow9.innerHTML = obj_Language.Lang1;
		var ElemDataRow10 = document.createElement("div");
		ElemDataRow10.className ="datarow";
		ElemDataRow10.innerHTML = obj_Language.Lang2;
		var ElemDataRow11 = document.createElement("div");
		ElemDataRow11.className ="datarow";
		ElemDataRow11.innerHTML = obj_Language.Lang3;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Languagedata"+ElemId);
		ElementDataHidden.value = obj_Language.getLanguageData();
		 
		 

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

		
		ElemLi= UI_createLanguageRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverLanguageRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutLanguageRow, false);

		
		return ElemLi;
}


//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverLanguageRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutLanguageRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createLanguageRow(obj_Language, rowType,dummyId) {
	var html = "";
	
	var UiLanguageList = document.getElementById("LanguageList");
	var ClassName = "ListRow";
	var ElemId = "LanguageListRow_"+obj_Language.LangId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyLanguageRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createLanguageRowHtmlElem(obj_Language,ElemId, ClassName);
			UiLanguageList.insertBefore(ElemLi, UiLanguageList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Language msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createLanguageRowHtmlElem(obj_Language,ElemId, ClassName);
			UiLanguageList.insertBefore(ElemLi, UiLanguageList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyLanguageRow_"+dummyId);
			var DummyData = document.getElementById("LanguagedataDummyLanguageRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Languagedata"+ElemId);		
				DummyData.value = obj_Language.getLanguageData();		
				}
				
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
				var ElemLi = UI_createLanguageRowHtmlElem(obj_Language,ElemId, ClassName);
				UiLanguageList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("LanguageList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, LangId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("LanguageListRow_"+LangId);
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


