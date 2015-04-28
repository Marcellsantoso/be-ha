<?php
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];

}
global $backEndClass;
?>

    <form class="form-signin" role="form" action="<?= _SPPATH.$backEndClass; ?>/login" method="post" id="loginform" name="loginform">

        
        <? if (isset($msg)) { ?>
            <div class="row" style="margin-bottom: 20px;">
        <span class="col-md-12" style="text-align: center;">
            <div class="alert alert-danger" role="alert">
                <?= $msg; ?>
            </div>
        </span>
            </div>
        <? } ?>

        <input id="user_login" type="text" name="admin_username" class="form-control" placeholder="Username" required
               autofocus>
        <input id="user_pass" type="password" name="admin_password" class="form-control" placeholder="Password"
               required>
        <label class="checkbox">
            <input type="checkbox" value="1" id="rememberme" name="rememberme"> <span
                class="checkboxspan"><?= Lang::t('remember'); ?></span>
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?= Lang::t("submit"); ?></button>
    </form>
<?

