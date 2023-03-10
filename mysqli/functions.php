<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL&~E_NOTICE&~E_STRICT);
function sendmail($from, $to, $cc, $subject, $body, $debug = false)
{
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
    $mail->isSMTP(); //Send using SMTP
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = 'sarjanpatel20@gnu.ac.in'; //SMTP username
    $mail->Password = 'guni@123$$'; //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SetFrom($from);
    $mail->AddAddress($to);
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body = $body;
    if ($cc != "") {$mail->AddCC($cc);}
    if (!$mail->Send() && $debug) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
function get($_param)
{
    $_rq = $_REQUEST;

    if ($_param == "brandid" && $_GET["id"] != "") {
        $_rq["brandid"] = $_GET["id"];
    }
    if ($_param == "brandid" && $_GET["brand"] != "") {
        $_rq["brandid"] = $_GET["brand"];
    }
    $ret = trim(@$_rq[$_param]);

    return queryclean($ret, $_param);
}
function queryclean($var, $param = '')
{

    $acceptable_string_values = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 -_?!.,|@:/=&$");

    if (is_array($var)) {
        foreach ($var as $i => $v) {
            $var[queryclean($i)] = queryclean($v);
        }
    } else {
        if (is_numeric($var)) {
            return $var;
        } elseif (is_string($var)) {

            $aux = str_split($var);

            return implode(array_intersect($aux, $acceptable_string_values));
        }
    }
}

function mysql_fetch_full_result_array($result)
{
    $table_result = array();
    $r = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $arr_row = array();
        $c = 0;
        foreach ($row as $k => $v) {
            $arr_row[$k] = $v;
        }
        $table_result[$r] = $arr_row;
        $r++;
    }
    return $table_result;

}
function sql($sql, $con = "")
{
    global $dbh;
    if (!$con) {$con = $dbh;}
    if ($con && $sql != "") {
        $result = mysqli_query($con, $sql) or print($sql . "<br>" . mysqli_error($con));
    }
    if (is_object($result)) {
        $arr_table_result = mysql_fetch_full_result_array($result);
        mysqli_free_result($result);
    }
    return $arr_table_result;
}

// function mysql_query_custom($dbh,$q){
//     global $dbh;
//     echo $q;
//         if (mysqli_query($dbh,$q)) {
//             header("Location: loginform.php");
//           } else {
//             echo "Error: " . $q . "<br>" . mysqli_error($dbh);
//           }
//         }
function mysql_query_custom($q, $con = "")
{
    global $dbh;
    if (!$con) {$con = $dbh;}
    return mysqli_query($dbh, $q) or die("Error: " . $q . "<br>" . $dbh->error);
}
function insert($table, $col, $data)
{
    global $dbh;
    $q = "INSERT INTO " . $table . " (" . implode(", ", $col) . ") VALUES (\"" . implode("\",\"", $data) . "\");";
    return mysql_query_custom($q);
}

function function_alert($message)
{
    echo "<script>alert('$message');</script>";
}

function update($table, $where, $data, $cols)
{
    global $dbh;
    $sets = array();
    foreach ($data as $k => $v) {
        $sets[$k] = $cols[$k] . "='" . $v . "'";
    }
    $q = "UPDATE `" . $table . "` SET " . implode(", ", $sets) . " WHERE $where";
    $data = "";
    return mysql_query_custom($q);
}


function insertorupdate($table, $data, $where, $asIs = "")
{
    global $dbh;
    $sets = array();

    $count = array_shift(sql("select count(*) as counts from `{$table}` where {$where}"));
    if ($count['counts'] == 0) {
        $action = "INSERT INTO ";
    } else {
        $action = "UPDATE ";
    }

    foreach ($data as $k => $v) {
        if ($asIs) {
            $sets[] = "`$k`=" . $v . "";
        } else {
            $sets[] = "`$k`=\"" . mysqli_real_escape_string($dbh, $v) . "\"";
        }
    }

    $q = $action . "`" . $table . "` SET " . implode(", ", $sets);
    if ($action == "UPDATE ") {
        $q .= " WHERE $where";
    }
    return mysql_query_custom($q);

}

function delete($table, $whr)
{
    global $dbh;
    $q = "delete from {$table} where $whr";
    return mysql_query_custom($q);
}

function flush_buffers()
{
    @ob_end_flush();
    @ob_flush();
    @flush();
    @ob_start();
}

function getPageName()
{

}

function decode($string, $key)
{
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i += 2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {$j = 0;}
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}
function encode($string, $key)
{
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {$j = 0;}
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function formatcurrency($_amount, $curr = "INR")
{
    return $curr . " " . number_format($_amount, 2);
}

function doReferesh($url = "", $secure = "false")
{
    global $siteurl, $ssl_siteurl;
    if ($secure) {
        echo '<meta http-equiv="refresh" content="0;url=' . $ssl_siteurl . $url . '">';die;
    } else {
        echo '<meta http-equiv="refresh" content="0;url=' . $siteurl . $url . '">';die;
    }
    exit;
}

function setSession($key, $val)
{
    $_SESSION[$key] = $val;
    return;
}

function getSession($key)
{
    return @$_SESSION[$key];
}

function setMessage($_msg)
{
    setSession('msg', $_msg);
    return;
}

function getMessage()
{
    $ret = "<center><b><font color='red'>" . getSession('msg') . "</font></b></center>";
    setSession('msg', '');
    return $ret;
}

function oops($msg = '')
{
    global $_debug, $_report, $mantis_project, $_show_msg;

    //////////////////////////////////////////////
    //                 Config variable starts        //
    //////////////////////////////////////////////
    $bt = array_reverse(debug_backtrace());
    $_error = $bt[0]['file'] . " (function: " . $bt[0]['function'] . ")";
    $errno = "Line: " . $bt[0]['line'];
    $error = ("<br /><br />Backtrace (most recent call last):<br /><br />\n");
    $page = curPageURL();

    for ($i = 0; $i <= count($bt) - 1; $i++) {
        if (!isset($bt[$i]["file"])) {
            $error .= ("[PHP core called function]<br />");
        } else {
            $error .= ("File: " . $bt[$i]["file"] . "<br />");
        }

        if (isset($bt[$i]["line"])) {
            $error .= ("&nbsp;&nbsp;&nbsp;&nbsp;line " . $bt[$i]["line"] . "<br />");
        }
        $error .= ("&nbsp;&nbsp;&nbsp;&nbsp;function called: " . $bt[$i]["function"]);

        if ($bt[$i]["args"]) {
            $error .= ("<br />&nbsp;&nbsp;&nbsp;&nbsp;args: ");
            for ($j = 0; $j <= count($bt[$i]["args"]) - 1; $j++) {
                if (is_array($bt[$i]["args"][$j])) {
                    //print_r($bt[$i]["args"][$j]);
                } else {
                    $error .= ($bt[$i]["args"][$j]);
                }

                if ($j != count($bt[$i]["args"]) - 1) {
                    $error .= (", ");
                }

            }
        }
        $error .= ("<br /><br />");
    }
    $data['username'] = "sawan";
    $data['password'] = "saswan123";
    $data['return'] = "index.php";
    $data['submit'] = "Login";
    $project['project_id'] = $mantis_project;
    $bug['m_id'] = "0";
    $bug['project_id'] = $mantis_project;
    $bug['max_file_size'] = "5000000";
    $bug['category_id'] = "2";
    $bug['summary'] = $errno . ": " . $_error;
    $bug['description'] = "URL: " . $page . $error;

    $_errorhtml = "";
    $_errorhtml .= '	<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">';
    $_errorhtml .= '	<tr><th colspan=2>Database Error</th></tr>';
    $_errorhtml .= '	<tr><td align="right" valign="top">Message:</td><td>' . $bug['summary'] . '</td></tr>';
    if (strlen($error) > 0) {
        $_errorhtml .= '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>' . $bug['description'] . '</td></tr>';
    }
    $_errorhtml .= '	<tr><td align="right">Date:</td><td>' . date("l, F j, Y \a\\t g:i:s A") . '</td></tr>';
    $_errorhtml .= '	<tr><td align="right">Script:</td><td><a href="' . @$_SERVER['REQUEST_URI'] . '">' . @$_SERVER['REQUEST_URI'] . '</a></td></tr>';
    if (strlen(@$_SERVER['HTTP_REFERER']) > 0) {
        $_errorhtml .= '<tr><td align="right">Referer:</td><td><a href="' . @$_SERVER['HTTP_REFERER'] . '">' . @$_SERVER['HTTP_REFERER'] . '</a></td></tr>';
    }
    $_errorhtml .= '	</table>';
    if ($_debug) {
        echo $_errorhtml;
    }
    if ($_report) {
        if ($_show_msg) {
            echo "<div id='_error_'><center><h1>Sorry! There was an error, please wait while system is reporting the error to us...";
        }
        flush();

        //////////////////////////////////////////////
        //                 Config variable ends        //
        //////////////////////////////////////////////

        curl("http://bugs.thirdeyeinc.co.in/login.php", $data);
        curl("http://bugs.thirdeyeinc.co.in/set_project.php", $project);

        $get_token = curl("http://bugs.thirdeyeinc.co.in/bug_report_page.php");
        $token = explode("bug_report_token", $get_token);
        $token = explode("\"", $token[1]);
        $token = trim($token[2]);

        $bug['bug_report_token'] = $token;
        curl("http://bugs.thirdeyeinc.co.in/bug_report.php", $bug);

        if ($_show_msg) {
            echo "Done</h1></center></div>";
        }

    }
    die;
}

function curPageURL()
{
    $pageURL = 'http';
    if (@$_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function sentenceNormalizer($sentence_split)
{
    $sentence_split = preg_replace(array('/[!]+/', '/[?]+/', '/[.]+/'),
        array('!', '?', '.'), $sentence_split);

    $textbad = preg_split("/(\!|\.|\?|\n)/", $sentence_split, -1, PREG_SPLIT_DELIM_CAPTURE);
    $newtext = array();
    $count = sizeof($textbad);

    foreach ($textbad as $key => $string) {
        if (!empty($string)) {
            $text = trim($string, ' ');
            $size = strlen($text);

            if ($size > 1) {
                $newtext[] = ucfirst(strtolower($text));
            } elseif ($size == 1) {
                $newtext[] = ($text == "\n") ? $text : $text . ' ';
            }
        }
    }

    return implode($newtext);
}

function backup_tables($tables = '*')
{
    global $dbh;

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysqli_query($dbh, "SHOW TABLES,'$dbh'");
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }
    //cycle through
    foreach ($tables as $table) {
        $result = mysqli_query($dbh, "SELECT * FROM .'$table','$dbh'");
        $num_fields = mysqli_num_fields($result);

        $return = 'DROP TABLE ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($dbh, "SHOW CREATE TABLE .'$table','$dbh'"));
        $return .= $row2[1] . ";";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $return .= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {$return .= '"' . $row[$j] . '"';} else { $return .= '""';}
                    if ($j < ($num_fields - 1)) {$return .= ',';}
                }
                $return .= ");";
            }
        }
        $return .= "\n\n\n";
    }

    //save file
    $filename = 'db-backup-' . time() . '-' . (md5(implode(',', $tables))) . '.sql';
    $handle = fopen($filename, 'w+');
    fwrite($handle, $return);
    fclose($handle);
    return $filename;
}

// audit fields functions

function _insert(array $data)
{

    if (is_array($data)) {
        if (!array_key_exists('audit_created_by', $data)) {
            $data['audit_created_by'] = getSession('username');
        }
        if (!array_key_exists('audit_created_date', $data)) {
            $data['audit_created_date'] = date('Y-m-d H:i:s');
        }
        if (!array_key_exists('audit_ip', $data)) {
            $data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
        }
    }

    return $data;
}

function _update(array $data)
{

    if (is_array($data)) {
        if (!array_key_exists('audit_update_by', $data)) {
            $data['audit_created_by'] = getSession('username');
        }
        if (!array_key_exists('audit_updated_date', $data)) {
            $data['audit_created_date'] = date('Y-m-d H:i:s');
        }
        if (!array_key_exists('audit_ip', $data)) {
            $data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
        }
    }

    return $data;
}

function email($doseto, $dosefrom, $dosesubject, $dosebody, $dosereplyto)
{
    $smtphost = "192.168.0.11";
    $smtpusername = "";
    $smtppassword = "";
    $smtpport = "25";
    $smtpauth = "0";

    $htmlemails = true;
    $debugmode = 0;
    /*if(!isset($_SESSION["dosentmails"])) {
    $_SESSION["dosentmails"] = array();
    }
    if(!in_array(md5($doseto.$dosesubject.$dosebody),$_SESSION["dosentmails"])) {*/

    if (file_exists('./class.phpmailer.php')) {

        include_once './class.phpmailer.php';
        require 'vendor/autoload.php';

        $mail = new PHPMailer();
        //$mail->SetLanguage('en', './includes/');
        $mail->IsSMTP();
        if (@$debugmode) {
            $mail->SMTPDebug = 2;
        }

        $mail->Host = $smtphost;
        $mail->SMTPAuth = $smtpauth;
        $mail->Username = $smtpusername;
        $mail->Password = $smtppassword;
        $mail->Port = $smtpport;
        $mail->From = $dosefrom;
        $mail->FromName = $dosefrom;
        $doseto = explode(",", $doseto);
        foreach ($doseto as $doto) {
            $mail->AddAddress($doto);
        }
        if ($dosereplyto != '') {
            $mail->AddReplyTo($dosereplyto);
        } else {
            $mail->AddReplyTo($dosefrom);
        }
        // $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Subject = $dosesubject;
        $mail->Body = $dosebody;
        // $mail->AltBody = "Plain Text";
        if (!$mail->Send() && @$debugmode) {
            echo 'Failed to send mail: ' . $mail->ErrorInfo;
        }

    } else {
        if (@$customheaders == '') {
            $headers = "MIME-Version: 1.0\n";
            $headers .= "From: %from% <%from%>\n";
            if ($dosereplyto != '') {
                $headers .= "Reply-To: %replyto% <%replyto%>\n";
            }

            if (@$htmlemails == true) {
                $headers .= 'Content-type: text/html; charset=utf-8\n';
            } else {
                $headers .= 'Content-type: text/plain; charset=utf-8';
            }

        } else {
            $headers = $customheaders;
        }

        $headers = str_replace('%from%', $dosefrom, $headers);
        $headers = str_replace('%to%', $doseto, $headers);
        if ($dosereplyto) {
            $headers = str_replace('%replyto%', $dosereplyto, $headers);
        } else {
            $headers = str_replace('%replyto%', $dosefrom, $headers);
        }
        $emailflags = str_replace('%from%', $dosefrom, @$emailflags);
        if (@$debugmode == true) {
            mail($doseto, $dosesubject, $dosebody, $headers, $emailflags);
        } else {
            @mail($doseto, $dosesubject, $dosebody, $headers, $emailflags);
        }

    }

    //    $_SESSION["dosentmails"][] = md5($doseto.$dosebody);
    //}
}

function print_a($data)
{
    $_head = "";
    $_data = "";
    if ($data) {
        $cols = array_keys($data[0]);
        foreach ($cols as $c) {
            $_head .= "<td><b>" . $c . "</b></td>";
        }

        foreach ($data as $d) {
            $_data .= "<tr>";
            foreach ($cols as $_c) {
                $_data .= "<td>" . $d[$_c] . "</td>";
            }
            $_data .= "</tr>";
        }
        echo "Total records found " . count($data) . "<table border=1><tr>" . $_head . "</tr>" . $_data . "</table>";

    }
}

function explodem($delimiters, $string)
{

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}

function curl($url, $pData = "")
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cj.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cj.txt");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pData);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

/*
1. just call ajaxinit(); anywhere on the page so that jquery can be loaded and ajax function can be written
2. example usage:

<input type="button" onclick="ajax('ajax2.php','ajaxresultt','key1=value1&key2=value2')" value="press meeeee">
<div id="ajaxresultt"></div>

 */
function ajaxinit()
{
    global $jquery;
    if ($jquery) {
        return false;
    }
    $jquery = file_get_contents("http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
    $function = 'function ajax(e,n,r){if(r){t="POST"}else{t="GET"}_request="request"+Math.floor(Math.random()*999+1);_request=$.ajax({url:e,type:t,crossDomain:"true",dataType:"html",data:r,timeout:5e3,beforeSend:function(e){$("#"+n).html("loading")}});_request.done(function(e){$("#"+n).html(e)});_request.fail(function(e,t){$("#"+n).html("<pre>Request failed: "+t+"</pre>")})}';

    $functions = '
	function ajax(u,divid,params) {
    	if(params){ t = "POST";	}else{ t = "GET"; }
    	_request = "request"+Math.floor((Math.random()*999)+1);


        _request = $.ajax({
            url: u,
            type: t,
            crossDomain: "true",
            dataType: "html",
            data : params,
            timeout: 5000,
            beforeSend: function( xhr ) {
    			$("#"+divid).html("loading");
  			}
        });

        _request.done(function(msg) {
            $("#"+divid).html(msg);
        });

        _request.fail(function(jqXHR, textStatus) {
	        $("#"+divid).html("<pre>Request failed: " + textStatus + "</pre>");
        });
    }';

    echo '<script type="text/javascript">' . $jquery . $function . '</script>';
}

function d($d)
{
    echo '<pre>';
    print_r($d);
    echo '</pre>';
}
