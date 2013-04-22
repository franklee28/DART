<?php
session_start();
include_once 'include/conn.php';

//verify that only manager can access this feature
$role = $_SESSION['authority'];
if ($role != "manager"){
	echo "<script language='javascript'>alert('Sorry but you have to be a manager to edit stakeholders.');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";
}


function nameSelect($str) {
	global $conn;
	$project = $_SESSION['project'];
	
	if($str == "regular") {
		$sql = "select * from RegularUser, ProjMem where RegularUser.name = ProjMem.member and ProjMem.project = '$project'";
		
		$rst = $conn->execute($sql);
		echo "<select name=\"name\" size=\"2\">";
		while (!$rst->EOF) {
			echo "<option value=\"".$rst->fields['name']."\">".$rst->fields['name']."</option>";
			$rst->movenext();
		}
		echo "</select>";
	}
}
?>

<script language="javascript">
/*Function:focus on the blank and alert the user to input the necessaries.
*/
function check_selection(form)
{
	if(form.name.value=="")
	{
		alert("Please select a stakeholder to delete!");
		form.name.focus();
		return false;
	}
	
	form.submit();
}

function check(form)
{
	if(form.name.value=="")
	{
		alert("Please select a stakeholder to change info!");
		form.name.focus();
		return false;
	}
	if(form.pwd.value=="")
	{
		alert("Please input a new password for the stakeholder");
		form.pwd.focus();
		return false;
	}
	form.submit();
}
</script>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Stakeholder</title>
<link rel="shortcut icon" href="favicon.ico" />
<!-- Load CSS -->
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!-- Load Fonts -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic" type="text/css" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" type="text/css" />
<!-- Load jQuery library -->
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<!-- Load custom js -->
<script type="text/javascript" src="scripts/panelslide.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
<!-- Load topcontrol js -->
<script type="text/javascript" src="scripts/scrolltopcontrol.js"></script>
<!-- Load NIVO Slider -->
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-theme.css" type="text/css" media="screen" />
<script src="scripts/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script src="scripts/nivo-options.js" type="text/javascript"></script>
<!-- Load fancybox -->
<script type="text/javascript" src="scripts/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="scripts/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="scripts/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!-- Load contact check -->
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('We are sorry, but there is an error:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
</head>
<body>
<!--This is the START of the header-->
<div id="topcontrol" style="position: fixed; bottom: 5px; left: 960px; opacity: 1; cursor: pointer;" title="Go to Top"></div>
<div id="header-wrapper">
  <div id="header">
    <div id="logo"><img src="images/usc.png" width="140" alt="logo" /></div>
    <div id="header-text">
      <h3 style="font-family:Georgia, Times, serif; color: white">Distributed Assessment of Risks Tool(DART)</h3>
    </div>
  </div>
</div>
<!--END of header-->
<!--This is the START of the menu-->
<div id="menu-wrapper">
  <div id="main-menu">
    <ul>
      <li><a class="selected" href="about.html">About</a></li>
      <li><a href="jumpProject.php">Project</a></li>
      <li><a href="jumpRiskAssessment.php">Risk Assessment</a></li>
      <li><a href="jumpCloseVotingPeriod.php">Close Voting Period</a></li>
      <li><a href="jumpViewResults.php">View Results</a></li>
    </ul>
  </div>
</div>
<!--END of menu-->
<!--This is the START of the content-->
<div id="content">
  
  
  
  
<!--This is the START of the contact section-->
<div id="contact">
	<h5 style="margin-top:0px;">Edit Stakeholder</h5>
	
    <form method="post" action="deletestakeholder.php" name="delete_stakeholder_form" id="contactform">
		<div class="boxes">
            
			<h5>&diams; Select a stakeholder to delete.</h5><br></br>
        
			<div>
				<h6>Stakeholder:&nbsp </h6>
				<?php
					nameSelect("regular");
				?>

				<div class="submitbtn">
				<input type="submit" name='Delete Stakeholder' class="styled-button" onclick="return check_selection(delete_stakeholder_form);" value="Delete Stakeholder" />
				</div>
			</div>
		</div>
	</form>
	
	<form method="post" action="editstakeholderinfo.php" name="edit_stakeholder_form" id="contactform">
        <div class="spacer">
		
			<h5>&diams; Change stakeholder info below.</h5><br></br>
        
			<div>
				<h6>Name:&nbsp </h6>
				<?php
					nameSelect("regular");
				?>
				<br></br>
			
				<h6>New Password:&nbsp  </h6> <div class="box">
				<input name="pwd" type="password"  class="input" id="sender_pw" title="Pw" value="" maxlength="2048"/></div>

				<div class="submitbtn">
				<input type="submit" name='Edit Stakeholder' class="styled-button" onclick="return check(edit_stakeholder_form);" value="Edit Stakeholder" />
				</div>
			</div>
		</div>
        
    </form>
</div>
<!--END of contact section-->
  
  
</div>
<!--END of content-->
<p class="slide"><a href="#" class="btn-slide"></a></p>
<div id="slide-panel">
	<!--This is the START of the follow section-->
	<div id="follow">
		<a href="adminSignUp.html">
		<div id="follow-setup"><img src="images/setup.jpg" />
			<h4>TA Signup</h4>
		</div>
		</a>
		<a href="login.html">	
		<div id="follow-login"><img src="images/login.png" />
			<h4>Login</h4>
		</div>
		</a>
		<form method="post" action="logout.php">
		<div id="follow-mail"><input type="image" src="images/logout.png" alt="Submit" name='Logout' value='Logout' />
		<!--<div id="follow-mail"><img src="images/logout.png" /> -->
			<h4>Logout</h4>
		</div>
		</form>
		<h1>Thanks for that!</h1>
	</div>
	<!--END of follow section-->
</div>
</body>
</html>