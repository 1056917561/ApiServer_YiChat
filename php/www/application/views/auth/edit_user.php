<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>后台管理模板</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" type="text/css" href="/assets/default/admin/css/global.css" media="screen">
    </head>
    <body>
        <div class="admin-main">


            <fieldset class="layui-elem-field">
                <legend><?php echo lang('edit_user_heading'); ?></legend>
                <div class="layui-field-box">
                    <p><?php echo lang('edit_user_subheading'); ?></p>

                    <div id="infoMessage"><?php echo $message; ?></div>

                    <?php echo form_open(uri_string()); ?>

                    <p>
                        <?php echo lang('edit_user_fname_label', 'first_name'); ?> <br />
                        <?php echo form_input($first_name); ?>
                    </p>

                    <p>
                        <?php echo lang('edit_user_lname_label', 'last_name'); ?> <br />
                        <?php echo form_input($last_name); ?>
                    </p>

                    <p>
                        <?php echo lang('edit_user_company_label', 'company'); ?> <br />
                        <?php echo form_input($company); ?>
                    </p>

                    <p>
                        <?php echo lang('edit_user_phone_label', 'phone'); ?> <br />
                        <?php echo form_input($phone); ?>
                    </p>

                    <p>
                        <?php echo lang('edit_user_password_label', 'password'); ?> <br />
                        <?php echo form_input($password); ?>
                    </p>

                    <p>
                        <?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?><br />
                        <?php echo form_input($password_confirm); ?>
                    </p>

                    <?php if ($this->ion_auth->is_admin()): ?>

                        <h3><?php echo lang('edit_user_groups_heading'); ?></h3>
                        <?php foreach ($groups as $group): ?>
                            <label class="checkbox">
                                <?php
                                $gID = $group['id'];
                                $checked = null;
                                $item = null;
                                foreach ($currentGroups as $grp) {
                                    if ($gID == $grp->id) {
                                        $checked = ' checked="checked"';
                                        break;
                                    }
                                }
                                ?>
                                <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                                <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        <?php endforeach ?>

                    <?php endif ?>

                    <?php echo form_hidden('id', $user->id); ?>
                    <?php echo form_hidden($csrf); ?>

                    <p><?php echo form_submit('submit', lang('edit_user_submit_btn')); ?></p>

                    <?php echo form_close(); ?>
                </div>
            </fieldset>
        </div>
    </body>
</html>