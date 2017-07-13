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
                <legend><?php echo lang('index_heading'); ?></legend>
               

                <div id="infoMessage"><?php echo $message; ?></div>
                <div class="layui-field-box">
                    <table class="site-table table-hover">
                        <tr>
                            <th><?php echo lang('index_fname_th'); ?></th>
                            <th><?php echo lang('index_lname_th'); ?></th>
                            <th><?php echo lang('index_email_th'); ?></th>
                            <th><?php echo lang('index_groups_th'); ?></th>
                            <th><?php echo lang('index_status_th'); ?></th>
                            <th><?php echo lang('index_action_th'); ?></th>
                        </tr>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php foreach ($user->groups as $group): ?>
                                        <?php echo anchor("auth/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'),'class="layui-btn layui-btn-mini"'); ?>
                                    <?php endforeach ?>
                                </td>
                                <td><?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link'),'class="layui-btn layui-btn-mini layui-btn-warm"') : anchor("auth/activate/" . $user->id, lang('index_inactive_link'),'class="layui-btn layui-btn-mini layui-btn-danger"'); ?></td>
                                <td><?php echo anchor("auth/edit_user/" . $user->id, '更新','class="layui-btn layui-btn-mini layui-btn-normal"'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <p><?php echo anchor('auth/create_user', lang('index_create_user_link'),'class="layui-btn layui-btn-small"') ?><?php echo anchor('auth/create_group', lang('index_create_group_link'),'class="layui-btn layui-btn-small"') ?></p>
            </fieldset>
        </div>
    </body>
</html>