<?php
session_start();
$session_id = session_id();
//
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $myip = $_SERVER['HTTP_CLIENT_IP'];
} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $myip = $_SERVER['REMOTE_ADDR'];
}
/////// 限IP /////
/*
if($myip!='220.132.77.246'){
	die;
}
*/
/////// end 限IP /////
if (!isset($_GET['kanpo']) || $_GET['kanpo'] == NULL) {
    $kanpo = "home";
} else {
    $kanpo = $_GET['kanpo'];
}
if (!isset($_GET['do']) || $_GET['do'] == NULL) {
    $do = "index";
} else {
    $do = $_GET['do'];
}
if (isset($_GET['param'])) {
    $param = $_GET['param'];
}
if (isset($_GET['param1'])) {
    $param1 = $_GET['param1'];
}



if (!file_exists($do . ".php")) {
    //header('Location: index.php');
}

$kantent = $basedir . "kanpo/" . $kanpo . "/" . $do . ".php";
$current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


$parts = parse_url($current_url);
parse_str($parts['query'], $q);
$s = trim($q['s']);
$type = trim($q['type']);
$curpage = trim($q['curpage']);
$page = trim($q['page']);
$q_cat = trim($q['cat']);
$sd = trim($q['sd']);
$ed = trim($q['ed']);

//lgn
$uid = $_SESSION['uid'];
$sql_lgn = "select * from user where id='$uid' limit 1";
$res_lgn = $conn->prepare($sql_lgn);
$res_lgn->execute();
$lgn = $res_lgn->fetch();

//admin(未來捨棄)
$sql_admin = "select * from user where id=:id and trash=0 and status=1 and (level='super' or level='manager') limit 1";
$res_admin = $conn->prepare($sql_admin);
$res_admin->execute(array(
    "id" => "$_SESSION[admin]"
));
$admin = $res_admin->fetch();
//algn
$sql_algn = "select * from user where id=:id and trash=0 and status=1 and (level='super' or level='manager') limit 1";
$res_algn = $conn->prepare($sql_algn);
$res_algn->execute(array(
    "id" => "$_SESSION[admin]"
));
$algn = $res_algn->fetch();
//


//status_value
if (!isset($q['status']) || $q['cat'] == NULL) {
    $status_value = "status";
} else {
    $status_value = $q['status'];
}
//pagination
$pagedata = 10;
if (!isset($q['page']) || $q['page'] == NULL) {
    $currentpage = 1;
    $page = 1;
    $start = $page - 1;
} else {
    $currentpage = $q['page'];
    $page = $q['page'];
    $start = ($page - 1) * $pagedata;
};
//
//date and time
$today = date('Y-m-d');
$now = date('Y-m-d H:i:s');
function weekday_tw($weekday)
{
    if ($weekday == 0) {
        echo '日';
    }
    if ($weekday == 1) {
        echo '一';
    }
    if ($weekday == 2) {
        echo '二';
    }
    if ($weekday == 3) {
        echo '三';
    }
    if ($weekday == 4) {
        echo '四';
    }
    if ($weekday == 5) {
        echo '五';
    }
    if ($weekday == 6) {
        echo '六';
    }
}
