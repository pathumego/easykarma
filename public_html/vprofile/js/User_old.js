function User()
{
this.userId="";
this.userName="";
this.password="";
this.personId="";
this.userType="";

}

User.prototype.setUser = function(userId_,userName_,password_,personId_,userType_)
{
this.userId=userId_;
this.userName=userName_;
this.password=password_;
this.personId=personId_;
this.userType=userType_;

},

User.prototype.createUserPacket = function()
{
	var packet = "";	
	packet += this.userId+";";
	packet += this.userName+";";
	packet += this.password+";";
	packet += this.personId+";";
	packet += this.userType;

	return packet;
}


User.prototype.getUserData = function()
{
	var packet = "";	
	packet += this.userId+";";
	packet += this.userName+";";
	packet += this.password+";";
	packet += this.personId+";";
	packet += this.userType;

	return packet;
}

