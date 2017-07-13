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
                <legend><?php echo lang('create_group_subheading'); ?></legend>
                <div class="layui-field-box">
                    <div id="infoMessage"><?php echo $message; ?></div>

                    <?php echo form_open("auth/create_group"); ?>

                    <p>
                        <?php echo lang('create_group_name_label', 'group_name'); ?> <br />
                        <?php echo form_input($group_name); ?>
                    </p>

                    <p>
                        <?php echo lang('create_group_desc_label', 'description'); ?> <br />
                        <?php echo form_input($description); ?>
                    </p>

                    <p><?php echo form_submit('submit', lang('create_group_submit_btn')); ?></p>

                    <?php echo form_close(); ?>
                </div>
            </fieldset>
        </div>
    </body>
</html>