<?php


function pr ($var, $return = 0)
{
    if ($return) {
        $str .= '<pre>' . print_r($var, true) . '</pre>';

        return $str;
    } else {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}


function sp_get_title ()
{
    global $template;
    global $WebSetting;
    if ($template->title == "") {
        echo $WebSetting["title"];
    } else {
        echo $template->title;
    }
}

function sp_get_meta_key ()
{
    global $WebSetting;
    global $template;
    if ($template->metakey == "") {
        echo "<meta name=\"Keywords\" content=\"" . $WebSetting["metakey"] . "\" />";
    } else {
        echo "<meta name=\"Keywords\" content=\"" . $template->metakey . "\" />";
    }
}

function sp_get_meta_description ()
{
    global $WebSetting;
    global $template;
    if ($template->metades == "") {
        echo "<meta name=\"Description\" content=\"" . $WebSetting["metadescription"] . "\" />
<meta http-equiv=\"pragma\" content=\"no-cache\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\" />";
    } else {
        echo "<meta name=\"Description\" content=\"" . $template->metades . "\" />
<meta http-equiv=\"pragma\" content=\"no-cache\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\" />";
    }

}

//fungsi templating dari scalarPHP supaya themes wiederverwendbar
function sp_get_content ()
{
    global $template;
    foreach ($template->content as $c) {
        echo $c;
    }
}

function sp_get_bodyload ()
{
    global $template;
    echo $template->onload;
}

function sp_get_bodyfirst ()
{
    global $template;
    foreach ($template->bodyphpfilesfirst as $j1) {
        @include "$j1";
    }
    foreach ($template->bodyfirst as $bf) {
        echo $bf;
    }
}

function sp_get_bodylast ()
{
    global $template;
    foreach ($template->bodylast as $be) {
        echo $be;
    }
    foreach ($template->bodyphpfileslast as $j2) {
        @include "$j2";
    }
}

function toRow ($obj)
{
    $row = array ();

    foreach ($obj as $key => $value) {
        $row[$key] = $value;
    }

    return $row;
}

function defineJump ()
{
    if ($_SESSION["roles"][0] == "admin") {
        global $c__Adminonly;
        $_SESSION["tabselected"] = $c__Adminonly->name;
        header("Location:" . _BPATH . $c__Adminonly->mainurl);
        exit();
    } elseif ($_SESSION["roles"][0] == "supervisor") {

        global $c__Supervisorhome;
        $_SESSION["tabselected"] = $c__Supervisorhome->name;
        header("Location:" . _BPATH . $c__Supervisorhome->mainurl);
        exit();
    } else {
        if ($_SESSION["roles"][0] == "murid") {
            global $c__Mobile;
            if ($_SESSION['isMobile']) {
                header("Location:" . _BPATH . $c__Mobile->mainurl);
                exit();
            }
        }

        $rol = ucfirst($_SESSION["roles"][0]);
        //echo $rol;
        eval ("global \$c__{$rol};");
        eval ("\$drol = \$c__{$rol};");
        // pr($drol); exit();

        $_SESSION["tabselected"] = $drol->name;
        header("Location:" . _BPATH . $drol->mainurl);
        exit();
    }
}


function ago ($timestamp)
{
    // echo "t = ".time();
    //  echo " ts ".$timestamp;
    $difference = time() - $timestamp;
    // echo " diff ".$difference;
    if ($difference < 0) {
        return "0 second ago";
    }
    if ($difference > 100000000) {
        return "long time ago";
    }
    $periods = array ("second", "minute", "hour", "day", "week", "month", "years", "decade");
    $lengths = array ("60", "60", "24", "7", "4.35", "12", "10");
    for ($j = 0; $difference >= $lengths[$j]; $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if ($difference != 1) {
        $periods[$j] .= "s";
    }
    $text = "$difference $periods[$j] ago";

    return $text;
}

function getNamaPendek ($name)
{
    $exp = explode(" ", $name);

    return $exp[0];
}

function indonesian_date ($mysqldate)
{
    $time = strtotime($mysqldate);

    return date("d/m/Y H:i ", $time);
}

function leap_mysqldate ()
{
    return date("Y-m-d H:i:s");
}

function leap_mysqldate_isi ($isi)
{
    $time = strtotime($isi);

    return date("Y-m-d H:i:s", $time);
}