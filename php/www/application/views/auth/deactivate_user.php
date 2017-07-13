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
                <legend><?php echo lang('deactivate_heading'); ?></legend>
                <div class="layui-field-box">
                    <p><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?></p>

                    <?php echo form_open("auth/deactivate/" . $user->id); ?>

                    <p>
                        <?php echo lang('deactivate_confirm_y_label', 'confirm'); ?>
                        <input type="radio" name="confirm" value="yes" checked="checked" />
                        <?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
                        <input type="radio" name="confirm" value="no" />
                    </p>

                    <?php echo form_hidden($csrf); ?>
                    <?php echo form_hidden(array('id' => $user->id)); ?>

                    <p><?php echo form_submit('submit', lang('deactivate_submit_btn')); ?></p>

                    <?php echo form_close(); ?>
                </div>
            </fieldset>
        </div>
    </body>
</html>