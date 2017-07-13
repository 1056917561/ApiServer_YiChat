<?php
/* Smarty version 3.1.31, created on 2017-06-02 16:15:56
  from "/home/www/application/views/default/admin/welcome/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59311ebc48ed63_22989536',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f1b01eb14ceb17eaec594a78cd65ba85d6528808' => 
    array (
      0 => '/home/www/application/views/default/admin/welcome/index.tpl',
      1 => 1496391346,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59311ebc48ed63_22989536 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_114906597659311ebc480ae7_24392172', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_184160345859311ebc483e09_35403073', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_114906597659311ebc480ae7_24392172 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_114906597659311ebc480ae7_24392172',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo site_url('welcome/navs');?>
"><?php echo '</script'; ?>
>
    <?php echo js('js/index.js');?>

<?php
}
}
/* {/block 'javascript'} */
/* {block 'body'} */
class Block_184160345859311ebc483e09_35403073 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_184160345859311ebc483e09_35403073',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="layui-layout layui-layout-admin">
        <div class="layui-header header header-demo">
            <div class="layui-main">
                <div class="admin-login-box">
                    <a class="logo" style="left: 0;" href="http://www.fanxinmsg.com">
                        <span style="font-size: 22px;">
                            <?php echo image('images/login.png');?>

                        </span>
                    </a>
                    <div class="admin-side-toggle">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                </div>
                <ul class="layui-nav admin-header-item">
                    <li class="layui-nav-item">
                        <a href="<?php echo site_url('plugin/index');?>
" data-tab="true" data-icon="fa-cubes">
                            <i class="fa fa-cubes" aria-hidden="true"></i>
                            <cite>应用中心</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" class="admin-header-user">
                            <?php echo image('images/0.jpg');?>

                            <span><?php if (!empty($_smarty_tpl->tpl_vars['user']->value['username'])) {
echo $_smarty_tpl->tpl_vars['user']->value['username'];
} else {
echo $_smarty_tpl->tpl_vars['user']->value['email'];
}?></span>
                        </a>
                        <dl class="layui-nav-child">
                            <?php if (!$_smarty_tpl->tpl_vars['user']->value['region']) {?>
                            <dd>
                                <a href="<?php echo site_url('auth/index');?>
" data-tab="true"><i class="fa fa-users" aria-hidden="true"></i> <cite>管理账号</cite></a>
                            </dd>
                            <?php }?>
                            <dd>
                                <a href="<?php echo site_url('auth/logout');?>
"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
                            </dd>
                        </dl>
                    </li>
                </ul>
                <ul class="layui-nav admin-header-item-mobile">
                    <li class="layui-nav-item">
                        <a href="<?php echo site_url('auth/logout');?>
"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="layui-side layui-bg-black" id="admin-side">
            <div class="layui-side-scroll" id="admin-navbar-side" lay-filter="side"></div>
        </div>
        <div class="layui-body" style="bottom: 0;border-left: solid 2px #1AA094;" id="admin-body">
            <div class="layui-tab admin-nav-card layui-tab-brief" lay-filter="admin-tab">
                <ul class="layui-tab-title" >
                    <li class="layui-this">
                        <i class="fa fa-dashboard" aria-hidden="true"></i>
                        <cite>控制面板</cite>
                    </li>
                </ul>
                <div class="layui-tab-content" style="min-height: 150px; padding: 5px 0 0 0;">
                    <div class="layui-tab-item layui-show">
                        <iframe src="<?php echo site_url('welcome/main');?>
"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-footer footer footer-demo" id="admin-footer">
            <div class="layui-main">
                <p><?php echo date('Y');?>
 &copy;
                   合肥掌峰科技有限公司
                </p>
            </div>
        </div>
        <div class="site-tree-mobile layui-hide">
            <i class="layui-icon">&#xe602;</i>
        </div>
        <div class="site-mobile-shade"></div>

        <!--锁屏模板 start-->
        <?php echo '<script'; ?>
 type="text/html" id="lock-temp">
            <div class="admin-header-lock" id="lock-box">
                <div class="admin-header-lock-img">
                    <?php echo image('images/0.jpg');?>

                </div>
                <div class="admin-header-lock-name" id="lockUserName">beginner</div>
                <input type="text" class="admin-header-lock-input" value="输入密码解锁.." name="lockPwd" id="lockPwd" />
                <button class="layui-btn layui-btn-small" id="unlock">解锁</button>
            </div>
        <?php echo '</script'; ?>
>
        <!--锁屏模板 end -->
    </div>
<?php
}
}
/* {/block 'body'} */
}
