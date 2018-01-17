<?php

  /* HackerOne report generator
   * @author Corben Douglas, Damian Ebelties
   * @url https://github.com/sxcurity/gen_report
   */

  session_start();

  foreach($_REQUEST as $request)
  {
    if(is_array($request))
    {
      die();
    }
  }

  $setpass  = "hackerone";
  $password = (isset($_REQUEST["pass"])) ? $_REQUEST["pass"] : "";
  $correct  = ($password == $setpass) ? 1 : 0;
  $php_self = htmlentities($_SERVER["PHP_SELF"], ENT_QUOTES, "UTF-8");

  if($password == $setpass)
  {
    $_SESSION["user"] = $password;
  }

?><!DOCTYPE html>
<html>

  <head>

    <title>HackerOne report generator</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <style>

      body
      {
        font-family: "Source Sans Pro";
        background-color: white;
      }
      a
      {
        color: black;
        text-decoration: none;
      }

    </style>

  </head>

  <?php if(isset($_SESSION["user"])) { ?>

  <body>
    <center>
      <h3>Report Generator</h3>
      <form action="<?=$php_self?>" method="POST">
        <input type="text"   name="title"    value="Report Title" /><br><br>
        <input type="text"   name="host"     value="Domain" /><br><br>
        <input type="text"   name="param"    value="Vulnerable parameter" /><br><br>
        <input type="text"   name="full_url" value="Full URL" /><br><br>
        <input type="submit" name="gen"      value="Generate" />
      </form>

      <br><br>

      <a href="<?=$php_self?>?logout">[ log out ]</a>
    </center>
  </body>
</html>
<?php

  }

  if(isset($_POST["gen"]))
  {
    $title = (isset($_POST["title"]))    ? htmlentities($_POST["title"])    : "";
    $host  = (isset($_POST["host"]))     ? htmlentities($_POST["host"])     : "";
    $param = (isset($_POST["param"]))    ? htmlentities($_POST["param"])    : "";
    $full  = (isset($_POST["full_url"])) ? htmlentities($_POST["full_url"]) : "";

?>

  <h3>Generated Report</h3>
  <pre>
  # <?=$title?>

  ### Summary
  A parameter on `<?=$host?>` does not properly sanitize user input, thus allowing an attacker to inject malicious javascript &amp; HTML.

  ### Description:
  The `?<?=$param?>` parameter in `<?=$full?>` does not properly sanitize input.

  ### Impact:
  This is a medium impact issue, as an attacker can bypass any CSRF protection, set cookies, steal passwords, etc.

  ### Reproduction:
  1.) Open Firefox
  2.) Visit `<?=$full?>`

  The XSS will fire in your browser.

  ### Suggested Mitigation/Remediation Actions:
  Sanitize user input!

  Regards,
  Corben Douglas [@sxcurity](https://twitter.com/sxcurity)
  </pre>

<?php

  }

  if(isset($_GET["logout"]))
  {
    foreach($_SESSION as $key => $value)
    {
      unset($_SESSION[$key]);
    }

    die(header("Location: $php_self"));
  }

  if(!isset($_SESSION["user"])) {

?><body>

    <form action="<?=$php_self?>" method="POST">

      <p>
        Password:
        <input type="password" name="pass" value=""/>
      </p>
      <input type="submit" name="login" value="Login">

    </form>

  </body>
</html>
<?php } ?>
