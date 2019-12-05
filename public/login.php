<?php
$mysqli = new mysqli("localhost", "spotimyapp_user1", "chiefonion212", "spotimyapp_db");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

print("<head>
    <title>Spotimy</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/loginstyle.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
    <link rel=\"icon\" href=\"assets/images/logo1.png\">
</head>");

print("<body>");
print("<a href = \"index.html\"><button style=\"float: right;\" class=\"btn\"><i class=\"fa fa-home\"></i> Home</button></a>");

print("<br/><br/><br/><br/><table width=\"50%\" border=\"0\" cellpadding=\"20\">
        <tr><td  align=\"center\"><h1>Login Page</h1></td></tr>");
print("<tr><td align=\"center\"> ");

print(
"<form action=\"temp.php\" method=\"post\">
    Username:
    <input type=\"text\" name=\"userid\"/> <br/>
    Password:&nbsp
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
            name="password" value="{{request.form.password}}">
    <input class = \"submit\" onclick=\"return check(this.form)\" type=\"submit\" name = \"Login\" value=\"Login\" /><br/> <br/>
</form>
<div class=\"container\">
<p class=\"text-muted\">For testing purposes, you can use username: aly5321, password: alypw123 <br> or username: suhirtha99, password: louis99</p> </div>");

/*<input type=\"submit\" onclick=\"return check(this.form)\" 
    value=\"Login\" id=\"login_button\">*/

print("</td></tr></table> 
<script language=\"javascript\">
function check(form){
    if(form.userid.value == encrypt.user && form.pwd.value == encrypt.password){
        return true;
    }else{
    	alert(\"Error: Wrong username and/or password\")
    	return false;
    }
}
</script>");
print("</body>");
$mysqli->close();
