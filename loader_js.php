<script type="text/javascript">



function OnImageLoad(evt, sq) {


    var img = evt.currentTarget;


    // what's the size of this image and it's parent

    var w = img.width;

    var h = img.height;

    var tw = sq;

    var th = sq;


    // compute the new size and offsets

    var result = ScaleImage(w, h, tw, th, false);


    // adjust the image coordinates and size

    img.width = result.width;

    img.height = result.height;

    //alert(result.targetleft);

    img.style.marginLeft = result.targetleft + "px"

    img.style.marginTop = result.targettop + "px"

    // img.setStyle({left: result.targetleft});

    // img.setStyle({top: result.targettop});

}

function resizeAndJustify(id, sq) {


    var img = document.getElementById(id);


    // what's the size of this image and it's parent

    var w = img.width;

    var h = img.height;

    var tw = sq;

    var th = sq;


    // compute the new size and offsets

    var result = ScaleImage(w, h, tw, th, false);


    // adjust the image coordinates and size

    img.width = result.width;

    img.height = result.height;

    //alert(result.targetleft);

    img.style.marginLeft = result.targetleft + "px"

    img.style.marginTop = result.targettop + "px"

    // img.setStyle({left: result.targetleft});

    // img.setStyle({top: result.targettop});

}


function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {


    var result = {width: 0, height: 0, fScaleToTargetWidth: true};


    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {

        return result;

    }


    // scale to the target width

    var scaleX1 = targetwidth;

    var scaleY1 = (srcheight * targetwidth) / srcwidth;


    // scale to the target height

    var scaleX2 = (srcwidth * targetheight) / srcheight;

    var scaleY2 = targetheight;


    // now figure out which one we should use

    var fScaleOnWidth = (scaleX2 > targetwidth);

    if (fScaleOnWidth) {

        fScaleOnWidth = fLetterBox;

    }

    else {

        fScaleOnWidth = !fLetterBox;

    }


    if (fScaleOnWidth) {

        result.width = Math.floor(scaleX1);

        result.height = Math.floor(scaleY1);

        result.fScaleToTargetWidth = true;

    }

    else {

        result.width = Math.floor(scaleX2);

        result.height = Math.floor(scaleY2);

        result.fScaleToTargetWidth = false;

    }

    result.targetleft = Math.floor((targetwidth - result.width) / 2);

    result.targettop = Math.floor((targetheight - result.height) / 2);


    return result;

}

/*
 * pull content
 */
var w;
var anzahlInbox = 0;
var tstamp = 0;
var updateInbox = [];
var maxInboxID = [];

function pullContent2() {

    if (typeof(Worker) !== "undefined") {

        if (typeof(w) == "undefined") {

            w = new Worker("<?=_SPPATH;?>webworker.js");

        }
        // w.postMessage({'cmd': 'start', 'maxInboxID': maxInboxID});
        w.onmessage = function (event) {

            // var rres = event.data;
            var hasil = JSON.parse(event.data);
            var reload = 0;
            var mengecil = 0;
            console.log(hasil);

            var aa = parseInt(hasil.totalmsg);
            updateInbox = hasil.updateArr;
            var ts = parseInt(hasil.timestamp);
            if (tstamp != ts)reload = 1;
            tstamp = ts;

            //cek apakah mengurangi
            if (aa < anzahlInbox)mengecil = 1;
            anzahlInbox = aa;
            //$('oktop').fade().fade();

            //document.getElementById("content_utama").innerHTML = document.getElementById("content_utama").innerHTML+event.data;
            if (reload) {
                lwrefresh("Inbox");
                $('#jmlEnvBaru').html(aa);
                $("#envelopebaloon").html(aa);

                if (aa == 0) {
                    $("#envelopebaloon").hide();
                }
                else {
                    $("#envelopebaloon").fadeIn();
                }
                if (!mengecil) {
                    //update link diatas
                    $('#envelopeul').load('<?=_SPPATH;?>Inboxweb/fillEnvelope');
                    //update window chat..

                    var len = updateInbox.length;
                    for (key = 0; key < len; key++) {
                        var keyactual = "inboxView" + updateInbox[key];
                        //lwrefresh("inboxView"+updateInbox[key]);

                        // ambil id yang mungkin ada...
                        var len2 = all_lws.length;
                        for (key2 = 0; key2 < len2; key2++) {
                            if (keyactual == all_lws[key2].lid) {
                                // you got matched, no load needed
                                $('#chatInbox' + updateInbox[key]).load('<?=_SPPATH;?>Inboxweb/see?all=1&id=' + updateInbox[key]);
                                //all_lws[key].refreshe( all_lws[key].urls,all_lws[key].ani);
                                //return 1;
                            } else {
                                //hide all others
                                //all_lws[key].sendBack();
                            }
                        }
                    }

                }
            }


        };

    }

    else {
        console.log("Sorry, your browser does not support Web Workers...");
    }
}
/*
 * openMuridProfile
 */
function openProfile(mid) {
    //openLw('AccountProfile' + mid, '<?=_SPPATH;?>AccountLoginWeb/profile?acc_id=' + mid, 'fade');
    document.location='<?=_SPPATH."profile?id="; ?>'+mid;
}

function js_yyyy_mm_dd_hh_mm_ss() {
    now = new Date();
    year = "" + now.getFullYear();
    month = "" + (now.getMonth() + 1);
    if (month.length == 1) {
        month = "0" + month;
    }
    day = "" + now.getDate();
    if (day.length == 1) {
        day = "0" + day;
    }
    hour = "" + now.getHours();
    if (hour.length == 1) {
        hour = "0" + hour;
    }
    minute = "" + now.getMinutes();
    if (minute.length == 1) {
        minute = "0" + minute;
    }
    second = "" + now.getSeconds();
    if (second.length == 1) {
        second = "0" + second;
    }
    return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
}

function carousel_delete(pid) {
    $.get("<?=_SPPATH;?>CarouselWeb/carouselDelete?pid=" + pid, function (data) {
        lwrefresh("Carousel");
    });
}
function carousel_activate(pid) {
    $.get("<?=_SPPATH;?>CarouselWeb/carouselActivate?pid=" + pid, function (data) {
        lwrefresh("Carousel");
    });
}
function carousel_moveUp(pid) {
    $.get("<?=_SPPATH;?>CarouselWeb/carouselMoveUp?pid=" + pid, function (data) {
        lwrefresh("Carousel");
    });
}

function gallery_open(gid) {
    openLw("GalleryOpen", "<?=_SPPATH;?>GalleryWeb/galleryOpen?gid=" + gid, "fade");
}
function gallery_delete(gid) {
    $.get("<?=_SPPATH;?>GalleryWeb/galleryDelete?gid=" + gid, function (data) {
        lwrefresh("GalleryMenu");
    });
}
function gallery_deletephoto(pid) {
    $.get("<?=_SPPATH;?>GalleryWeb/pictureDelete?pid=" + pid, function (data) {
        lwrefresh("GalleryOpen");
    });
}

function gallery_setmainpic(pid, gid) {
    $.get("<?=_SPPATH;?>GalleryWeb/pictureSetMainPic?pid=" + pid + "&gid=" + gid, function (data) {
        lwrefresh("GalleryOpen");
        lwrefresh("GalleryMenu");

    });
}
function galleryUpdateName(gid) {
    var newname = $("#h1_" + gid).html();
    if (newname == "") {
        alert("<?=Lang::t("Please fill name");?>");
    } else {
        $.post("<?=_SPPATH;?>GalleryWeb/galleryUpdateName", {gid: gid, newname: newname}, function (data) {
            lwrefresh("GalleryMenu");
        });
    }
}
function galleryUpdateDes(gid) {
    var newname = $("#galdesc_" + gid).html();
    if (newname == "") {
        alert("<?=Lang::t("Please fill description");?>");
    } else {
        if (newname != "Click here to enter description") {
            $.post("<?=_SPPATH;?>GalleryWeb/galleryUpdateDes", {gid: gid, newname: newname}, function (data) {
                lwrefresh("GalleryMenu");
            });
        }
    }
}

function gallery_openpicture(pid, gid) {
    openLw("PictureOpen", "<?=_SPPATH;?>GalleryWeb/pictureOpen?gid=" + gid + "&pid=" + pid, "fade");
}

function galleryUpdateDesPic(pid) {
    var newname = $("#picdesc_" + pid).html();
    if (newname == "") {
        alert("<?=Lang::t("Please fill description");?>");
    } else {
        if (newname != "Click here to enter description") {
            $.post("<?=_SPPATH;?>GalleryWeb/galleryUpdateDesPic", {pid: pid, newname: newname}, function (data) {
                //lwrefresh("GalleryMenu");
            });
        }
    }
}

function files_delete(pid) {
    $.get("<?=_SPPATH;?>FilesWeb/filesDelete?pid=" + pid, function (data) {
        lwrefresh("Files");
    });
}


function ads_delete(pid) {
    $.get("<?=_SPPATH;?>AdsWeb/adsDelete?pid=" + pid, function (data) {
        lwrefresh("Ads");
    });
}
function ads_activate(pid) {
    $.get("<?=_SPPATH;?>AdsWeb/adsActivate?pid=" + pid, function (data) {
        lwrefresh("Ads");
    });
}
function ads_moveUp(pid) {
    $.get("<?=_SPPATH;?>AdsWeb/adsMoveUp?pid=" + pid, function (data) {
        lwrefresh("Ads");
    });
}
</script><?php

/* 
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

