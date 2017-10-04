<?php
// HackerOne Report Generator by Corben Douglas (@sxcurity)
// https://github.com/sxcurity/gen_report

session_start();
// change the password
$setpass = "hackerone";
echo '
<html>
<head>
<title>H1 Report Generator</title>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
<style>
body {background-color:white;}
h3,p,input {font-family:"Source Sans Pro";}
a {font-family: "Source Sans Pro";color:black;text-decoration:none;}
</style>
</head>
';
if(isset($_POST['login']))
{
     $pass = $_POST['pass'];

      if($pass == $setpass)
         {

          $_SESSION['user']=$pass;
        }
        else
        {
        }
}
;
if($_SESSION['user']) {
echo '
<body>
<center>
<h3>Report Generator</h3>
<form action="'.htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'utf-8').'" method="POST">
  <input type="hidden" name="gen"/>
  <input type="text" name="title" value="Report Title" /><br><br>
  <input type="text" name="host" value="Domain" /><br><br>
  <input type="text" name="param" value="Vulnerable parameter" /><br><br>
  <input type="text" name="full_url" value="Full URL" /><br><br>
  <input type="submit" value="Generate" />
</form>
<br><br><a href='.htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'utf-8').'?logout>[ log out ]</a>
</center>
</body>
</html>
';
if(isset($_POST['gen'])) {
	$title = htmlentities($_POST['title']);
	$host = htmlentities($_POST['host']);
	$param = htmlentities($_POST['param']);
	$full = htmlentities($_POST['full_url']);
	echo '

<h3>Generated Report</h3>
<pre>
# '.$title.'
### Summary
A parameter on `'.$host.'` does not properly sanitize user input, thus allowing an attacker to inject malicious javascript & HTML.

### Description:
The `?'.$param.'` parameter in `'.$full.'` does not properly sanitize input.

### Impact:
This is a medium impact issue, as an attacker can bypass any csrf protection, set cookies, steal passwords, etc.

### Reproduction:
1.) Open Firefox
2.) Visit `'.$full.'`

The XSS will fire in your browser.

### Suggested Mitigation/Remediation Actions:
Sanitize user input!

Regards,
Corben Douglas [@sxcurity](https://twitter.com/sxcurity)</pre>';

}
if(isset($_GET['logout'])) {
session_destroy();
header('Location: '.htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'utf-8'));
}
} else {
echo '
<form action="'.htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'utf-8').'" method="POST">
<input type="hidden" name="login">
<p>Password: <input type="password" name="pass" value=""/></p>
<input type="submit" value="Login">
</body>
</html>
';
}

