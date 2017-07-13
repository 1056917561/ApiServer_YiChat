<?php
/* Smarty version 3.1.31, created on 2017-01-24 10:02:56
  from "/home/www/application/views/default/admin/auth/login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5886b5d0861063_88701145',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9421794a2da41448a5756b722d85308b3c044515' => 
    array (
      0 => '/home/www/application/views/default/admin/auth/login.tpl',
      1 => 1485162365,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5886b5d0861063_88701145 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title><?php echo lang('login_heading');?>
</title>
        <?php echo css('plugins/layui/css/layui.css');?>

        <?php echo css('css/login.css');?>

    </head>

    <body class="beg-login-bg">
        <div class="container">
            <div id="large-header" class="large-header">
                <canvas id="demo-canvas"></canvas>
                <div class="beg-login-box">
                    <header>
                        <h1><?php echo lang('login_heading');?>
</h1>
                    </header>
                    <div class="beg-login-main">
                        <?php echo form_open("auth/login",array('class'=>'layui-form'));?>

                        <div class="layui-form-item">
                            <label class="beg-login-icon">
                                <i class="layui-icon">&#xe612;</i>
                            </label>
                            <?php echo form_input($_smarty_tpl->tpl_vars['identity']->value);?>

                        </div>
                        <div class="layui-form-item">
                            <label class="beg-login-icon">
                                <i class="layui-icon">&#xe642;</i>
                            </label>
                            <?php echo form_input($_smarty_tpl->tpl_vars['password']->value);?>

                        </div>
                        <div class="layui-form-item">
                            <div class="beg-pull-left beg-login-remember">
                                <label><?php echo lang('login_remember_label');?>
</label>
                                <input type="checkbox" name="remember" value="true" lay-skin="switch" checked title="<?php echo lang('login_remember_label');?>
">
                            </div>
                            <div class="beg-pull-right">
                                <button class="layui-btn layui-btn-primary" lay-submit lay-filter="login">
                                    <i class="layui-icon">&#xe650;</i> <?php echo lang('login_submit_btn');?>

                                </button>
                            </div>
                            <div class="beg-clear"></div>
                        </div>
                        </form>
                    </div>
                    <footer>
                        合肥掌峰科技有限公司
                    </footer>
                </div>
            </div>
        </div>
        <?php echo js('plugins/layui/layui.js');?>

        <?php echo js('js/layer.js');?>

        <?php echo js('js/TweenLite.min.js');?>

        <?php echo js('js/EasePack.min.js');?>

        <?php echo js('js/rAF.js');?>

        <?php echo js('js/login.js');?>

        <?php echo '<script'; ?>
>

            layui.use('form', function () {
                var form = layui.form();

            });
        <?php echo '</script'; ?>
>
    </body>

</html><?php }
}
