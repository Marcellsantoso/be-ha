<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crud
 *
 * @author User
 */
class Crud {
    public static function run ($obj, $webClass)
    {
        if ($obj instanceof Model) {

            $cmd = (isset($_GET['cmd']) ? addslashes($_GET['cmd']) : 'read');
            if ($cmd == "edit") {
                Crud::createForm($obj, $webClass);
                die();
            }
            if ($cmd == "add") {
                //Crud::createForm($obj,$webClass);
                $json = Crud::addPrecon($obj);
                die(json_encode($json));
            }
            if ($cmd == "delete") {
                $json['bool'] = 1;
                $id = (isset($_POST['id']) ? addslashes($_POST['id']) : '');
                $json['bool'] = $obj->delete($id);
                die(json_encode($json));
            }


            Crud::read($obj, $webClass);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    /*
     * add all preconditions and constraints
     */

    public static function createForm ($obj, $webClass)
    {
        //pr($obj);
        if ($obj instanceof Model) {
            $mps = $obj->createForm();
            //pr($obj);
            $mps['webClass'] = $webClass;
            $mps['action'] = $webClass . "/" . $mps['classname'] . "?cmd=add";
            $mps['formID'] = "editform_" . $mps['classname'] . "_" . time();
            $mps['obj'] = $obj;
            $mps['ajax'] = new Ajax($mps);
            //pr($mps);
            //echo $webClass;
            Mold::plugin("Crud","createForm", $mps);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }

    }

    public static function addPrecon ($obj)
    {

        if ($obj instanceof Model) {
            $json['bool'] = 1;
            $obj->insertPostDataToObject();
            //$json['post'] = $obj;
            $json['err'] = $obj->constraints();

            if (count($json['err']) > 0) {
                $json['bool'] = 0;
            } else {
                $json['bool'] = $obj->save();
                if ($json['bool']) {
                    $json['err'] = array ("all" => Lang::t('save failed'));
                }
            }

            return $json;
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    public static function read ($obj, $webClass)
    {
        if ($obj instanceof Model) {

            $mps = $obj->read();
            $mps['webClass'] = $webClass;
            $mps = $obj->overwriteRead($mps);

            Mold::plugin("Crud","read", $mps);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    public static function sortBy ($return, $webClass, $divID, $clmID)
    {
        $c = $return['classname'];

        $page = $return['page'];
        $sort = $return['sort'];
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $t = time() - 10000000;
        $colomlist = $return['colomslist'];
        $clms = $return['coloms'];
        $giliran = "ASC";
        if (isset($_SESSION[$webClass]['sort'][$clmID])) {
            $urutan = $_SESSION[$webClass]['sort'][$clmID];
            if ($urutan == "ASC") {
                $giliran = "DESC";
            } else {
                $giliran = "ASC";
            }
        } else {
            $giliran = "ASC";

        }
        $_SESSION[$webClass]['sort'][$clmID] = $giliran;
        $sort = $clmID . "%20" . $giliran;
        ?>
        <script type="text/javascript">
            $("#<?=$divID;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=strtolower($c);?>?page=1&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&clms=<?=$clms;?>', 'fade');
            });
        </script>
    <?

    }

    public static function searchBox ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        
        $exp = explode(",",$return['search']);
        $exp1 = implode(",",array_unique($exp));
        ?>
        <div class="col-md-4 col-xs-12">

            <div class="input-group">
                <input type="text" class="form-control" value="<?= $w; ?>" id="<?= $c; ?>searchpat"
                       placeholder="<?= $exp1; ?>">
      <span class="input-group-btn">
        <button class="btn btn-default" id="<?= $c; ?>searchpat<?= $t; ?>"
                type="button"><?= Lang::t('search'); ?></button>
      </span>
            </div>
            <!-- /input-group -->


            <script type="text/javascript">
                $("#<?=$c;?>searchpat<?=$t;?>").click(function () {
                    var slc = $('#<?=$c;?>searchpat').val();
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=1&word=' + slc, 'fade');
                });
                $("#<?=$c;?>searchpat").keyup(function (event) {
                    if (event.keyCode == 13) { //on enter
                        var slc = $('#<?=$c;?>searchpat').val();
                        openLw(selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=1&word=' + slc, 'fade');
                    }
                });
            </script>
        </div>
    <?
    }

    public static function viewAll ($return, $webClass)
    {
        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button class="btn btn-default" id="<?= $c; ?>viewall<?= $t; ?>"
                type="button"><?= Lang::t('viewall'); ?></button>

        <script type="text/javascript">
            $("#<?=$c;?>viewall<?=$t;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=all&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
            });
        </script>
    <?

    }

    public static function exportExcel ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button class="btn btn-default" id="<?= $c; ?>export<?= $t; ?>" type="button"><?= Lang::t('export'); ?></button>

        <script type="text/javascript">
            $("#<?=$c;?>export<?=$t;?>").click(function () {
                window.open('<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=all&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&export=1', "_blank ");
            });
        </script>
    <?
    }

    public static function AddButton ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button class="btn btn-default" id="<?= $c; ?>addpat<?= $t; ?>" type="button"><?= Lang::t('add'); ?></button>

        <script type="text/javascript">
            $("#<?=$c;?>addpat<?=$t;?>").click(function () {
                openLw('<?=$c;?>AddPage', '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?cmd=edit&t=' + $.now() + '&parent_page=' + window.selected_page, 'fade');
            });
        </script>
    <?
    }

    public static function filter ($return, $webClass)
    {
        $c = $return['classname'];
        ?>

        <button class="btn btn-default" id="<?= $c; ?>_FilterButton" type="button"
                onclick="$('#<?= $c; ?>Filter').fadeToggle();"><?= Lang::t('toggle filter'); ?></button>



    <?
    }

    public static function filterButton ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;

        $colomlist = $return['colomslist'];
        $actual_coloms = $return['coloms'];

        $exp = explode(",", $colomlist);
        $expAct = explode(",", $actual_coloms);
        ?>
        <div class="col-md-12 col-xs-12" id="<?= $c; ?>Filter" class="CrudViewFilter <?= $c; ?>_Filter"
             style="display:none; padding: 10px;">


            <style type="text/css">
                .selectable_clm {
                    margin: 5px;
                    padding: 5px;
                    background-color: #efefef;
                    border-radius: 5px;
                }

                .sslc {
                    background-color: #ccc;
                    font-weight: bold;
                }
            </style>
            <script type="text/javascript">
                tofilter = [];

                function RemoveFromfilter(id) {
                    var index = tofilter.indexOf(id);
                    if (index > -1) {
                        tofilter.splice(index, 1);
                        $('#' + id + "_<?=$t;?>").removeClass('sslc');
                    } else {
                        tofilter.push(id);
                        $('#' + id + "_<?=$t;?>").addClass('sslc');
                    }
                    $("#<?=$c;?>filterHide<?=$t;?>").val(tofilter.join());
                }
            </script>
            <?
            foreach ($exp as $clm) {
                $clm = trim(rtrim($clm));
                if (in_array($clm, $expAct)) {
                    $sel = "sslc";
                    $onclick = "RemoveFromfilter('{$clm}');";
                    ?>
                    <script type="text/javascript">tofilter.push('<?=$clm;?>');</script>
                <?
                } else {
                    $sel = "";
                    $onclick = "RemoveFromfilter('{$clm}');";
                }
                ?>
                <div id="<?= $clm; ?>_<?= $t; ?>" class="selectable_clm <?= $sel; ?> col-md-1 col-xs-3 col-sm-2"
                     onclick="<?= $onclick; ?>">
                    <?= Lang::t($clm); ?>
                </div>
            <? } ?>
            <input type="hidden" id="<?= $c; ?>filterHide<?= $t; ?>" value="<?= $actual_coloms; ?>">

            <div class="col-md-1 col-xs-3 col-sm-2">
                <button class="btn btn-default" id="<?= $c; ?>filterButton<?= $t; ?>"
                        type="button"><?= Lang::t('filter'); ?></button>
            </div>
            <script type="text/javascript">
                $("#<?=$c;?>filterButton<?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&clms=' + $('#<?=$c;?>filterHide<?=$t;?>').val(), 'fade');
                });
            </script>
        </div>
    <?
    }

    public static function pagination ($return, $webClass)
    {
        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>
    <div class="CrudViewPagination <?= $c; ?>_Pagination" id="<?= $c; ?>_Pagination">
        <? if (!($page <= 1)) { ?>
        <span class="CrudViewPagebutton"
              id="<?= $webClass; ?>firstpagepat_<?= $page; ?><?= $t; ?>"><?= Lang::t('first'); ?></span>
        <span class="CrudViewPagebutton"
              id="<?= $webClass; ?>prevpat_<?= $page; ?><?= $t; ?>"><?= Lang::t('prev'); ?></span>
        <script type="text/javascript">
            $("#<?=$webClass;?>firstpagepat_<?=$page;?><?=$t;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
            });
            $("#<?=$webClass;?>prevpat_<?=$page;?><?=$t;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=($page-1);?>&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
            });
        </script>
    <?
    }
        //handle next pages
        $showpagination = 2;
        if ($page > ($totalpage - $showpagination)) {

            $endpage = $totalpage;
        } else {
            $endpage = $page + $showpagination;
        }

        if ($page >= $showpagination) {
            $beginpage = $page - $showpagination;
        } else {
            $beginpage = 1;
        }
        if ($beginpage < 1) {
            $beginpage = 1;
        }
        if ($endpage > $totalpage) {
            $endpage = $totalpage;
        }
        for ($x = $beginpage; $x <= $endpage; $x++) {
            if ($x == $page) {
                $selected = "selpage";
            } else {
                $selected = "";
            }
            ?>
            <span class="CrudViewPagebutton <?= $selected; ?>"
                  id="<?= $webClass; ?>mppage_<?= $x; ?><?= $t; ?>"><?= $x; ?></span>
            <script type="text/javascript">
                $("#<?=$webClass;?>mppage_<?=$x;?><?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=$x;?>&sort=<?=$sort;?>&clms=<?=$clms;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
                });
            </script>
        <?
        }
        if (!($page >= $totalpage)) {
            ?><span class="CrudViewPagebutton"
                    id="<?= $webClass; ?>nextpat_<?= $page; ?><?= $t; ?>"><?= Lang::t('next'); ?></span>
            <span class="CrudViewPagebutton"
                  id="<?= $webClass; ?>lastpagepat_<?= $page; ?><?= $t; ?>"><?= Lang::t('last'); ?></span>
            <script type="text/javascript">
                $("#<?=$webClass;?>lastpagepat_<?=$page;?><?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=$totalpage;?>&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
                });
                $("#<?=$webClass;?>nextpat_<?=$page;?><?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=($page+1);?>&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
                });
            </script><?

        }
        ?></div><?

    }
}
