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
                <legend><?php echo lang('create_user_heading'); ?></legend>
                <div class="layui-field-box">
                    <p><?php echo lang('create_user_subheading'); ?></p>

                    <div id="infoMessage"><?php echo $message; ?></div>

                    <?php echo form_open("auth/create_user"); ?>

                    <p>
                        <?php echo lang('create_user_fname_label', 'first_name'); ?> <br />
                        <?php echo form_input($first_name); ?>
                    </p>

                    <p>
                        <?php echo lang('create_user_lname_label', 'last_name'); ?> <br />
                        <?php echo form_input($last_name); ?>
                    </p>

                    <?php
                    if ($identity_column !== 'email') {
                        echo '<p>';
                        echo lang('create_user_identity_label', 'identity');
                        echo '<br />';
                        echo form_error('identity');
                        echo form_input($identity);
                        echo '</p>';
                    }
                    ?>

                    <p>
                        <?php echo lang('create_user_company_label', 'company'); ?> <br />
                        <?php echo form_input($company); ?>
                    </p>

                    <p>
                        <?php echo lang('create_user_email_label', 'email'); ?> <br />
                        <?php echo form_input($email); ?>
                    </p>

                    <p>
                        <?php echo lang('create_user_phone_label', 'phone'); ?> <br />
                        <?php echo form_input($phone); ?>
                    </p>

                    <p>
                        <?php echo lang('create_user_password_label', 'password'); ?> <br />
                        <?php echo form_input($password); ?>
                    </p>

                    <p>
                        <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?> <br />
                        <?php echo form_input($password_confirm); ?>
                    </p>


                    <p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>

                    <?php echo form_close(); ?>
                </div>
            </fieldset>
        </div>
    </body>
</html>