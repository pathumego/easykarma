//-------------------------------------------------------------------------------------------------------------------
var msgPopupwin;
function Product_IncommingData(mainPacket) {
	var actionId = mainPacket[0];
	mainPacket.shift();
	switch(parseInt(actionId)) {
		case 200: {
			addProduct(mainPacket);
			break;
		}
		case 201: {
			ACK_addProduct(mainPacket);
			break;
		}
		case 202: {
			ACK_deleteProduct(mainPacket);
			break;
		}
		case 203: {
			ACK_updateProduct(mainPacket);
			break;
		}

	}

}

//-------------------------------------------------------------------------------------------------------------------
function ACK_addProduct(mainPacket) {
	if (mainPacket.length > 1) {
		var obj_Product = new Product();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		var dummyId = mainPacket[2];
		
		obj_Product.ProductId= mainPacket[3];
		obj_Product.ProductName= mainPacket[4];
		obj_Product.ExpireDuration= mainPacket[5];
		obj_Product.Description= mainPacket[6];



		if (resultStatus == 1) {	
			
			UI_createProductRow(obj_Product, "update",dummyId);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_deleteProduct(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Product = new Product();
		
		var resultStatus = mainPacket[0];
		var ProductId = mainPacket[1];
		var resultMsg = mainPacket[2];
		var rowElem = document.getElementById("ProductListRow_"+ProductId);
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
				var rowElem = document.getElementById("ProductListRow_"+ProductId);
				rowElem.className = "ListRow";
				
				},1000);			
		}
		UI_hidecontentError(checkNodeCount =true);
		
	}
}

//-------------------------------------------------------------------------------------------------------------------
function ACK_updateProduct(mainPacket) {
if (mainPacket.length > 1) {
		var obj_Product = new Product();
		
		var resultStatus = mainPacket[0];
		var resultMsg = mainPacket[1];
		
		obj_Product.ProductId= mainPacket[2];
		obj_Product.ProductName= mainPacket[3];
		obj_Product.ExpireDuration= mainPacket[4];
		obj_Product.Description= mainPacket[5];


		if (resultStatus == 1) {			
			UI_createProductRow(obj_Product, "replace",0);	
		}
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Product_OutgoingData(postpacket) {

	var messageId = CreateDummyNumber();
	message_queue(postpacket,messageId);

}

//-------------------------------------------------------------------------------------------------------------------

function createOutgoingProductPacket(actionId,packetBody) {
	var moduleId = glb_moduleId_Product; //manage profile module Id
	var SystemId = 0;

	
	var packet = SystemId+";";
	packet += moduleId+";";
	packet += actionId+";";
	packet += packetBody;
	return packet;
}

//-------------------------------------------------------------------------------------------------------------------
function DeleteProductPacket(ProductId) {
	var deletePacketBody  = ProductId;

	var postpacket = createOutgoingProductPacket(202,deletePacketBody);
	Product_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function UpdateProductPacket(obj_Product) {
	var savePacketBody  = obj_Product.createProductPacket();

	var postpacket = createOutgoingProductPacket(203,savePacketBody);
	Product_OutgoingData(postpacket);
}

//-------------------------------------------------------------------------------------------------------------------

function AddProductPacket(dummyId,obj_Product) {

	var savePacketBody  = dummyId+";";
	savePacketBody  += obj_Product.createProductPacket();

	var postpacket = createOutgoingProductPacket(201,savePacketBody);
	Product_OutgoingData(postpacket);
}

// ===============================================================================================================================================================
// ***************************************************************************************************************************************************************
// ===============================================================================================================================================================

window.onload = Event_onProductPageLoad;
var elemformPopup;

//-------------------------------------------------------------------------------------------------------------------

function Event_onProductPageLoad() {
	Init_profile_eventbind();
	//requestInitMessage();

}

//-------------------------------------------------------------------------------------------------------------------

function Init_profile_eventbind() {

	var addProduct = document.getElementById("btnaddProduct");
	if(addProduct){
	addProduct.addEventListener('mousedown', Event_mousedown_addProduct, false);
	}
	
	var form_addbtn = document.getElementById("form_addbtn");
	form_addbtn.addEventListener('mousedown', Event_mousedown_form_addbtn, false);

	var popProductform = document.getElementById("popProductform");
	var inputElems = popProductform.getElementsByTagName("input");
	for (var z = 0; z < inputElems.length; z++) {
		if ((inputElems[z].type.toLowerCase() == "text") && (inputElems[z].className == "form_area_textbox")) {
			inputElems[z].addEventListener('focus', Event_focusFormAreaField, false);
			inputElems[z].addEventListener('blur', Event_blurFormAreaField, false);
		}
	}
	
	var UiProductList = document.getElementById("ProductList");
	var liElems = UiProductList.getElementsByTagName("li");
	for (var z = 0; z < liElems.length; z++) {
			liElems[z].addEventListener('mouseover', Event_MouseOverProductRow, false);
			liElems[z].addEventListener('mouseout', Event_MouseOutProductRow, false);
		
	}
	
	var UiProductListDeletebtns = document.getElementsByClassName("rowbtn");
	for (var z = 0; z < UiProductListDeletebtns.length; z++) {
			UiProductListDeletebtns[z].addEventListener('mousedown', Event_mouseDownProductRowBtn, false);			
		
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
	UI_search_Product(searchText);
	
	
	
}

//-------------------------------------------------------------------------------------------------------------------


function Event_mouseDownProductRowBtn()
{
	switch(this.innerHTML.toLowerCase())
	{
		case "delete":
		{
			var obj_Product = Get_ProductByListRow(this.parentNode.parentNode);
			if(obj_Product != ""){
				deleteProduct(obj_Product.ProductId,this.parentNode.parentNode);
			}
			break;
		}
		case "edit":
		{
			var obj_Product = Get_ProductByListRow(this.parentNode.parentNode);
			if(obj_Product != ""){
				UI_showUpdateProductForm(obj_Product);
				
			}		
			
			break;
		}

		
	}
}

//-------------------------------------------------------------------------------------------------------------------

function UI_search_Product(searchText)
{

	//ProductList = 
	var ProductListElem = document.getElementById("ProductList");
	
	if(ProductListElem)
	{
		var ProductDataList = ProductListElem.getElementsByTagName("input");
		for(var y=0 in ProductDataList)
		{
			if(ProductDataList[y])
			{
				
				
				var displayType = "none";
				var ProductData = ProductDataList[y].value;
				if(!((ProductData == "") || (typeof ProductData=="undefined")))
				{
				if(search_Product(ProductData,searchText))
				{
					displayType = "block";
				}
				ProductDataList[y].parentNode.style.display = displayType;
				}
				
			}
		}
	}		

}


//-------------------------------------------------------------------------------------------------------------------

function search_Product(ProductData,searchText)
{
	var result = false;
	searchText = searchText.toLowerCase();
	ProductData = decodeSpText(ProductData.toLowerCase());
	if(ProductData.indexOf(searchText) > -1)
	{
		result = true;
	}
	return result;
}


//-------------------------------------------------------------------------------------------------------------------

function showUploader(obj_Product)
{
	if (obj_Product.ProductId) {
		var fieldDataId = obj_Product.ProductId;
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

function deleteProduct(ProductId,listRow)
{
	var flag = confirm("Are you sure, you want to delete this Product");
	if(flag){
			DeleteProductPacket(ProductId);
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

function Get_ProductByListRow(listRowElem)
{
	
	var obj_Product ="";
	if(listRowElem)
	{
		var elemlist = listRowElem.getElementsByTagName("input");
		var ProductData = "";
		for (var z = 0; z < elemlist.length; z++) {
			
			if(elemlist[z].type	== "hidden"){				
				ProductData = elemlist[z].value;
			}		
		}
		
		if(ProductData != "")
		{
		var arrProductData = ProductData.split(";");	
		
		obj_Product = new Product();
		obj_Product.ProductId= arrProductData[0];
		obj_Product.ProductName= arrProductData[1];
		obj_Product.ExpireDuration= arrProductData[2];
		obj_Product.Description= arrProductData[3];

		
		
		}
		
	}
	
	return obj_Product;
	
	
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
	
		var Elem = document.getElementById("Input_ProductName");
			if(Elem)
			{
				if(Elem.value =="")
				{
					iserror =true;
					error = "please Enter the Product Name";
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
	
		var obj_Product = new Product();
		
		var ProductId= document.getElementById("Input_ProductId").value;
		var ProductName= document.getElementById("Input_ProductName").value;
		var ExpireDuration= document.getElementById("Input_ExpireDuration").value;
		var Description= document.getElementById("Input_Description").value;

		
		document.getElementById("Input_ProductId").value="";
		document.getElementById("Input_ProductName").value="";
		document.getElementById("Input_ExpireDuration").value="";
		document.getElementById("Input_Description").value="";

		

	
	var formMode = document.getElementById("FormMode").value;
	if(formMode == "add")
	{
		var obj_Product = new Product();
		obj_Product.ProductId= ProductId;
		obj_Product.ProductName= ProductName;
		obj_Product.ExpireDuration= ExpireDuration;
		obj_Product.Description= Description;

		
		var dummyId = CreateDummyNumber();
		AddProductPacket(dummyId,obj_Product);
		UI_createProductRow(obj_Product, "new",dummyId);
	}
	else if(formMode == "update")
	{
		var obj_Product = new Product();

		obj_Product.ProductId= ProductId;
		obj_Product.ProductName= ProductName;
		obj_Product.ExpireDuration= ExpireDuration;
		obj_Product.Description= Description;

		
		UpdateProductPacket(obj_Product);
		UI_createProductRow(obj_Product, "replace",1);
		elemformPopup.hide();
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_mousedown_addProduct() {
	
	UI_showAddProductForm();
}

//-------------------------------------------------------------------------------------------------------------------

function UI_showAddProductForm() {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareProductAddForm();
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popProductform"));
	elemformPopup.show();
}
//-------------------------------------------------------------------------------------------------------------------

function UI_showUpdateProductForm(obj_Product) {
	document.getElementById("formerror").innerHTML = "";
	UI_prepareProductUpdateForm(obj_Product);
	elemformPopup = new formPopup();
	var popwidth = 800;
	var popheight = 0;
	elemformPopup.init(popwidth, popheight, document.getElementById("popProductform"));
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
function UI_prepareProductUpdateForm(obj_Product)
{
	var arr_hidelist = new Array("Input_ProductId");
	var arr_showlist = new Array("Input_ProductName","Input_ExpireDuration","Input_Description");
	
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ProductId").value=obj_Product.ProductId;
		document.getElementById("Input_ProductName").value=obj_Product.ProductName;
		document.getElementById("Input_ExpireDuration").value=obj_Product.ExpireDuration;
		document.getElementById("Input_Description").value=obj_Product.Description;

	
	document.getElementById("FormMode").value = "update";
	document.getElementById("form_addbtn").value = "Update";

}

//-------------------------------------------------------------------------------------------------------------------
function UI_prepareProductAddForm()
{
	var arr_hidelist = new Array("Input_ProductId");
	var arr_showlist = new Array("Input_ProductName","Input_ExpireDuration","Input_Description");
	UI_showhideFormElements(arr_hidelist,0);
	UI_showhideFormElements(arr_showlist,1);
	
		document.getElementById("Input_ProductId").value="";
		document.getElementById("Input_ProductName").value="";
		document.getElementById("Input_ExpireDuration").value="";
		document.getElementById("Input_Description").value="";

	
	document.getElementById("FormMode").value = "add";
	document.getElementById("form_addbtn").value = "Add";
}
//-------------------------------------------------------------------------------------------------------------------

function UI_addProductToProductList() {
	var uiProductList = document.getElementById("ProductList");

	var rowElems = uiProductList.getElementsByTagName("li");
	for (var z = 0; z < rowElems.length; z++) {

	}
}


//-------------------------------------------------------------------------------------------------------------------

function UI_createProductRowHtmlButtonRow(ElemBtnRow, arr_btnName)
{
	
	for(var x =0 in arr_btnName)
	{
		ElemBtn = document.createElement("div");
		ElemBtn.className = "databtncell";
		
		ElemBtnAnchor = document.createElement("a");
		ElemBtnAnchor.className = "rowbtn";
		ElemBtnAnchor.href = "#";
		ElemBtnAnchor.innerHTML = arr_btnName[x];
		ElemBtnAnchor.addEventListener('mousedown', Event_mouseDownProductRowBtn, false);
		
		ElemBtn.appendChild(ElemBtnAnchor);
		ElemBtnRow.appendChild(ElemBtn);
	}
	
	return ElemBtnRow;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createProductRowHtmlElem(obj_Product,ElemId, ClassName)
{

		
		var ElemLi = document.createElement("li");
		ElemLi.setAttribute("id", ElemId);
		var html = "";

	var ImgElem = document.createElement("img");
	ImgElem.id = "ProductImg_"+obj_Product.ProductId;
	if(ClassName =="ListRow_Dummy")ImgElem.src = "Product/0_small.png";
	else ImgElem.src = "Product/"+obj_Product.ProductId+"_small.png";	
		
	//var ElemDataRow1 = document.createElement("div");
	//	ElemDataRow1.className ="datarow";
	//	ElemDataRow1.appendChild(ImgElem);
		

		var ElemDataRow2 = document.createElement("div");
		ElemDataRow2.className ="datarow";
		ElemDataRow2.innerHTML = obj_Product.ProductId;
		var ElemDataRow3 = document.createElement("div");
		ElemDataRow3.className ="datarow";
		ElemDataRow3.innerHTML = obj_Product.ProductName;
		var ElemDataRow4 = document.createElement("div");
		ElemDataRow4.className ="datarow";
		ElemDataRow4.innerHTML = obj_Product.ExpireDuration;
		var ElemDataRow5 = document.createElement("div");
		ElemDataRow5.className ="datarow";
		ElemDataRow5.innerHTML = obj_Product.Description;

		
		var ElementDataHidden = document.createElement("input");
		ElementDataHidden.setAttribute("type", "hidden");
		ElementDataHidden.setAttribute("id", "Productdata"+ElemId);
		ElementDataHidden.value = obj_Product.getProductData();
		 
		 

	//	ElemLi.appendChild(ElemDataRow1);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow2);
		ElemLi.appendChild(ElemDataRow3);
		ElemLi.appendChild(ElemDataRow4);
		ElemLi.appendChild(ElemDataRow5);

		
		ElemLi= UI_createProductRowHtmlButtonRow(ElemLi,new Array("Edit","Delete"));
		ElemLi.appendChild(ElementDataHidden);
		ElemLi.className = ClassName;
		ElemLi.addEventListener('mouseover', Event_MouseOverProductRow, false);
		ElemLi.addEventListener('mouseout', Event_MouseOutProductRow, false);

		
		return ElemLi;
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createTopbarSubProductHtmlElem(obj_Product)
{
	var topsubbar = document.getElementById("topbarsublist");
	if(topsubbar)
	{
	var html = "";
	var ElemLi = document.createElement("li");
		ElemLi.setAttribute("class", "topbar_subProduct");
		html ="<a href=\"?page=dashboard&ProductId="+obj_Product.ProductId+"\">"+obj_Product.ProductId+"</a>";
		ElemLi.innerHTML = html;
		topsubbar.appendChild(ElemLi);
		topsubbar.parentNode.className = "common_site_subheader";
	}
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOverProductRow()
{
	if(this.className =="ListRow")
	this.className = "ListRow_over";
	
}

//-------------------------------------------------------------------------------------------------------------------

function Event_MouseOutProductRow()
{
	if(this.className =="ListRow_over")
	this.className = "ListRow";
}

//-------------------------------------------------------------------------------------------------------------------

function UI_createProductRow(obj_Product, rowType,dummyId) {
	var html = "";
	
	var UiProductList = document.getElementById("ProductList");
	var ClassName = "ListRow";
	var ElemId = "ProductListRow_"+obj_Product.ProductId;
		

		switch(rowType) {
		case "new":
		{
			ElemId = "DummyProductRow_"+dummyId;
			ClassName = "ListRow_Dummy";
			var ElemLi = UI_createProductRowHtmlElem(obj_Product,ElemId, ClassName);
			UiProductList.insertBefore(ElemLi, UiProductList.firstChild);
			UI_hidecontentError(checkNodeCount =false);	//"hide no Product msg"		
		break;
		}
		case "current": {
			var ElemLi = UI_createProductRowHtmlElem(obj_Product,ElemId, ClassName);
			UiProductList.insertBefore(ElemLi, UiProductList.firstChild);	
		break;
		}
		case "update": {
			var DummyRow = document.getElementById("DummyProductRow_"+dummyId);
			var DummyData = document.getElementById("ProductdataDummyProductRow_"+dummyId);
			if(DummyRow) {
				DummyRow.className = ClassName;
				DummyRow.setAttribute("id", ElemId);
			
				if(DummyData)
				{
				DummyData.setAttribute("id", "Productdata"+ElemId);		
				DummyData.value = obj_Product.getProductData();		
				}
				UI_createTopbarSubProductHtmlElem(obj_Product);
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
				var ElemLi = UI_createProductRowHtmlElem(obj_Product,ElemId, ClassName);
				UiProductList.insertBefore(ElemLi, currentElem);
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
		var listnode = document.getElementById("ProductList");
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

function avatarUploadResult(status, uploadFileName, errorMsg, ProductId)
{
	if(status == 1)
	{
		msgPopupwin.hide();
		var profileAvatar = document.getElementById("ProductListRow_"+ProductId);
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


