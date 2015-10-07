//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function User_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addUser(mainPacket);
			break;
		}
		case 201: {
			ACK_addUser(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteUser(mainPacket);
			break;
		}
		case 203: {
			ACK_updateUser(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addUser(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_User = new User();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_User.userId= mainPacket[3];
		obj_User.userName= mainPacket[4];
		obj_User.password= mainPacket[5];
		obj_User.personId= mainPacket[6];
		obj_User.userType= mainPacket[7];
		obj_User.userOptCode= mainPacket[8];
		obj_User.userMetadata= mainPacket[9];
		obj_User.userStatus= mainPacket[10];



		if (resultStatus == 1) {	
			
			UI_createUserRow(obj_User, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteUser(mainPacket) {
if (mainPacket.length > 1) {
		var obj_User = new User();
		
		var resultStatus = mainPacket[0];
		var userId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("UserListRow_"+userId);
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
				var rowElem = document.getElementById("UserListRow_"+userId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateUser(mainPacket) {
if (mainPacket.length > 1) {
		var obj_User = new User();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_User.userId= mainPacket[2];
		obj_User.userName= mainPacket[3];
		obj_User.password= mainPacket[4];
		obj_User.personId= mainPacket[5];
		obj_User.userType= mainPacket[6];
		obj_User.userOptCode= mainPacket[7];
		obj_User.userMetadata= mainPacket[8];
		obj_User.userStatus= mainPacket[9];


		if (resultStatus == 1) {			
			UI_createUserRow(obj_User, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function User_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingUserPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_User; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteUserPacket(userId) {
	var deletePacketBody  = userId;

	var postpacket = createOutgoingUserPacket(202,deletePacketBody);
	User_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateUserPacket(obj_User) {
	var savePacketBody  = obj_User.createUserPacket();

	var postpacket = createOutgoingUserPacket(203,savePacketBody);
	User_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddUserPacket(dummyId,obj_User) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_User.createUserPacket();

	var postpacket = createOutgoingUserPacket(201,savePacketBody);
	User_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onUserPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onUserPageLoad() {
	Init_User_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_User_eventbind() {

	var addUser = document.getElementById("btnaddUser");
	if(addUser){
	addUser.addEventListener('mousedown', Event_mousedown_addUser, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popUserform = document.getElementById("popUserform");
	var inputElems = popUserform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiUserList = document.getElementById("UserList");
	var liElems = UiUserList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverUserRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutUserRow, false);
		
	}
	
	var UiUserListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiUserListDeletebtns.length; z++) {
			UiUserListDeletebtns[z].addEventListener('mousedown', Event_mouseDownUserRowBtn, false);			
		
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
	UI_search_User(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownUserRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_User = Get_UserByListRow(this.parentNode.parentNode);
			if(obj_User != ""){
				deleteUser(obj_User.userId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_User = Get_UserByListRow(this.parentNode.parentNode);
			if(obj_User != ""){
				UI_showUpdateUserForm(obj_User);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_User(searchText)
{

	//UserList = 
	var UserListElem = document.getElementById("UserList");
	
	if(UserListElem)
	{
		var UserDataList = UserListElem.getElementsByTagName("input");
		for(var y=0 in UserDataList)
		{
			if(UserDataList[y])
			{
				
				
				var displayType = "none";
				var UserData = UserDataList[y].value;
				if(!((UserData == "") || (typeof UserData=="undefined")))
				{
				if(search_User(UserData,searchText))
				{
					displayType = "block";
				}
				UserDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_User(UserData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	UserData = decodeSpText(UserData.toLowerCase());
	if(UserData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_User)
{
	if (obj_User.userId) {
		var fieldDataId = obj_User.userId;
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

function deleteUser(userId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this User");
	if(flag){
			DeleteUserPacket(userId);
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

function Get_UserByListRow(listRowElem)
{
	
	var obj_User ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var UserData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				UserData = elemlist[z].value;
			}		
		}
		
		if(UserData != "")
		{
		var arrUserData = UserData.split(";");	
		
		obj_User = new User();
		obj_User.userId= arrUserData[0];
		obj_User.userName= arrUserData[1];
		obj_User.password= arrUserData[2];
		obj_User.personId= arrUserData[3];
		obj_User.userType= arrUserData[4];
		obj_User.userOptCode= arrUserData[5];
		obj_User.userMetadata= arrUserData[6];
		obj_User.userStatus= arrUserData[7];

		
		
		}
		
	}
	
	return obj_User;
	
	
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
	

		var Elem = document.getElementById("Input_UserPrice");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "Please enter User price";
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
			
		    Elem = document.getElementById("Input_UserName");
			if(Elem)
			{
				if(Elem.value =="")
				{
				Elem.focus();
				iserror =true;
				error = "Please enter User name";	
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
	
		var obj_User = new User();
		
		var userId= document.getElementById("Input_userId").value;
		var userName= document.getElementById("Input_userName").value;
		var password= document.getElementById("Input_password").value;
		var personId= document.getElementById("Input_personId").value;
		var userType= document.getElementById("Input_userType").value;
		var userOptCode= document.getElementById("Input_userOptCode").value;
		var userMetadata= document.getElementById("Input_userMetadata").value;
		var userStatus= document.getElementById("Input_userStatus").value;

		
		document.getElementById("Input_userId").value="";
		document.getElementById("Input_userName").value="";
		document.getElementById("Input_password").value="";
		document.getElementById("Input_personId").value="";
		document.getElementById("Input_userType").value="";
		document.getElementById("Input_userOptCode").value="";
		document.getElementById("Input_userMetadata").value="";
		document.getElementById("Input_userStatus").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_User = new User();
		obj_User.userId= userId;
		obj_User.userName= userName;
		obj_User.password= password;
		obj_User.personId= personId;
		obj_User.userType= userType;
		obj_User.userOptCode= userOptCode;
		obj_User.userMetadata= userMetadata;
		obj_User.userStatus= userStatus;

		
		var dummyId = CreateDummyNumber();
		AddUserPacket(dummyId,obj_User);
		UI_createUserRow(obj_User, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_User = new User();

		obj_User.userId= userId;
		obj_User.userName= userName;
		obj_User.password= password;
		obj_User.personId= personId;
		obj_User.userType= userType;
		obj_User.userOptCode= userOptCode;
		obj_User.userMetadata= userMetadata;
		obj_User.userStatus= userStatus;

		
		UpdateUserPacket(obj_User);
		UI_createUserRow(obj_User, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addUser() {
	
	UI_showAddUserForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddUserForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareUserAddForm();
	if(elemformPopup != null)
	{
	elemformPopup.hide();	
	}
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popUserform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateUserForm(obj_User) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareUserUpdateForm(obj_User);
	if(elemformPopup != null)
	{
	elemformPopup.hide();	
	}
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popUserform"));
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
function UI_prepareUserUpdateForm(obj_User)
{
	var arr_hidelist = new Array("Input_userId");
	var arr_showlist = new Array("Input_userId","Input_userName","Input_password","Input_personId","Input_userType","Input_userOptCode","Input_userMetadata","Input_userStatus");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_userId").value=obj_User.userId;
		document.getElementById("Input_userName").value=obj_User.userName;
		document.getElementById("Input_password").value=obj_User.password;
		document.getElementById("Input_personId").value=obj_User.personId;
		document.getElementById("Input_userType").value=obj_User.userType;
		document.getElementById("Input_userOptCode").value=obj_User.userOptCode;
		document.getElementById("Input_userMetadata").value=obj_User.userMetadata;
		document.getElementById("Input_userStatus").value=obj_User.userStatus;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareUserAddForm()
{
	var arr_hidelist = new Array("Input_userId");
	var arr_showlist = new Array("Input_userId","Input_userName","Input_password","Input_personId","Input_userType","Input_userOptCode","Input_userMetadata","Input_userStatus");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_userId").value="";
		document.getElementById("Input_userName").value="";
		document.getElementById("Input_password").value="";
		document.getElementById("Input_personId").value="";
		document.getElementById("Input_userType").value="";
		document.getElementById("Input_userOptCode").value="";
		document.getElementById("Input_userMetadata").value="";
		document.getElementById("Input_userStatus").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addUserToUserList() {
	var uiUserList = document.getElementById("UserList");

	var rowElems = uiUserList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createUserRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownUserRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createUserRowHtmlElem(obj_User,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "UserImg_"+obj_User.userId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "User/0_small.png";
	else ImgElem.src = "User/"+obj_User.userId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_User.userId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_User.userName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_User.password;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_User.personId;
		var ElemDataRow6 = document.createElement("div");
		ElemDataRow6.className ="datarow";
		ElemDataRow6.innerHTML = obj_User.userType;
		var ElemDataRow7 = document.createElement("div");
		ElemDataRow7.className ="datarow";
		ElemDataRow7.innerHTML = obj_User.userOptCode;
		var ElemDataRow8 = document.createElement("div");
		ElemDataRow8.className ="datarow";
		ElemDataRow8.innerHTML = obj_User.userMetadata;
		var ElemDataRow9 = document.createElement("div");
		ElemDataRow9.className ="datarow";
		ElemDataRow9.innerHTML = obj_User.userStatus;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Userdata"+ElemId);
		ElementDataHidden.value = obj_User.getUserData();
		 
		 

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

		
		ElemLi= UI_createUserRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverUserRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutUserRow, false);

		
		return ElemLi;
}


//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverUserRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutUserRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createUserRow(obj_User, rowType,dummyId) {
	var html = "";
	
	var UiUserList = document.getElementById("UserList");
	var ClassName = "ListRow";
	var ElemId = "UserListRow_"+obj_User.userId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyUserRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createUserRowHtmlElem(obj_User,ElemId, ClassName);
			UiUserList.insertBefore(ElemLi, UiUserList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no User msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createUserRowHtmlElem(obj_User,ElemId, ClassName);
			UiUserList.insertBefore(ElemLi, UiUserList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyUserRow_"+dummyId);
			var DummyData = document.getElementById("UserdataDummyUserRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Userdata"+ElemId);		
				DummyData.value = obj_User.getUserData();		
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
				var ElemLi = UI_createUserRowHtmlElem(obj_User,ElemId, ClassName);
				UiUserList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("UserList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, userId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("UserListRow_"+userId);
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
