<?php
/* Smarty version 3.1.31, created on 2017-06-02 10:06:16
  from "/home/www/application/views/default/admin/users/setarea.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5930c8184a40c8_26020028',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ccc996cc105283e085151a9254b2e6296a4aea98' => 
    array (
      0 => '/home/www/application/views/default/admin/users/setarea.tpl',
      1 => 1496369173,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5930c8184a40c8_26020028 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21332849985930c8184873c9_54294365', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16298129925930c81848d956_18964980', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_21332849985930c8184873c9_54294365 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_21332849985930c8184873c9_54294365',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php echo '<script'; ?>
 type="text/javascript">
        layui.config({
            base: theme_url + 'plugins/layui/modules/'
        });
        layui.use(['jquery', 'form', 'icheck', 'laypage', 'layer', 'laydate', 'query'], function () {
            var $ = layui.jquery,
                    form = layui.form(),
                    laypage = layui.laypage,
                    layer = parent.layer === undefined ? layui.layer : parent.layer,
                    laydate = layui.laydate;



            $("[data-tab]").on('click', function () {
                var t = $(this);
                parent.tab.tabAdd({
                    title: t.data('title'),
                    icon: t.data('icon'),
                    href: t.attr('href')
                });
                return false;
            });
        <?php if (empty($_smarty_tpl->tpl_vars['list']->value)) {?>
            layer.msg('没有可操作用户数据');
        <?php } elseif ($_smarty_tpl->tpl_vars['pages']->value > 1) {?>
            laypage({
                cont: 'page',
                pages: <?php echo $_smarty_tpl->tpl_vars['pages']->value;?>
,
                curr:<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
,
                groups: 5,
                jump: function (obj, first) {

                    var curr = obj.curr;
                    if (!first) {
                        self.location = $.query.set("page", obj.curr);
                    }
                }
            });
        <?php }?>
        });
    <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'javascript'} */
/* {block 'body'} */
class Block_16298129925930c81848d956_18964980 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_16298129925930c81848d956_18964980',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <?php if (!$_smarty_tpl->tpl_vars['user']->value['region']) {?>
            <blockquote id='searchform' class="layui-elem-quote">
                <form class="layui-form" action="" method="get">
                    <div>
                        <div class="layui-input-inline">
                            <select name="region" lay-verify="required">
                                <option value="">请选择部门</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['area']->value, 'g');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['g']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['g']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['g']->value['id'] == $_smarty_tpl->tpl_vars['region']->value) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['g']->value['name'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                            </select>
                        </div> 
                        <div class="layui-input-inline">
                            <input type="text" name="tel" value="<?php echo $_smarty_tpl->tpl_vars['tel']->value;?>
" autocomplete="off" class="layui-input" placeholder="手机号">
                        </div>    
                        <div class="layui-inline">
                            <!--<button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe62a;</i> 确定</button>-->
                            <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                        </div>
                    </div>
                </form>
            </blockquote>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['data']->value) {?>
            <?php if ($_smarty_tpl->tpl_vars['regionName']->value) {?><div style="line-height:37px;padding-left:20px">当前部门：<?php echo $_smarty_tpl->tpl_vars['regionName']->value;?>
</div><?php }?>
            <div style="line-height:37px;padding-left:20px"><?php if ($_smarty_tpl->tpl_vars['regionName']->value) {?>当前<?php }?>部门管理员名单：</div>
            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>登录账号</th>
                            <th>姓名</th>
                            <th>身份</th>
                            <th>手机号</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['first_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['roleName'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['phone'];?>
</td>
                                <td>
                                    <a href="<?php echo site_url('users/removeadmin');?>
?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
&uid=<?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" data-confirm="你确定要取消该管理员权限吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 取消权限</a>
                                </td>
                            </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </tbody>
                </table>
            </div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['list']->value) {?>

            <div style="line-height:37px;padding-left:20px">用户列表：</div>
            <?php if ($_smarty_tpl->tpl_vars['user']->value['region']) {?>
                <blockquote id='searchform' class="layui-elem-quote">
                    <form class="layui-form" action="" method="get">
                        <div>
                            <div class="layui-input-inline">
                                <input type="text" name="tel" value="<?php echo $_smarty_tpl->tpl_vars['tel']->value;?>
" autocomplete="off" class="layui-input" placeholder="手机号">
                            </div>    
                            <div class="layui-inline">
                                <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                            </div>
                        </div>
                    </form>
                </blockquote>
            <?php }?>
            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>职位</th>
                            <th>手机号</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['usernick'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['roleName'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['tel'];?>
</td>
                                <td>
                                    <a href="<?php echo site_url('users/addadmin/');
echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" data-confirm="你确定给予该用户管理员权限吗？" class="layui-btn layui-btn-mini"><i class="fa fa-check" aria-hidden="true"></i> 管理员权限</a>
                                </td>
                            </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </tbody>
                </table>
            </div>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['pages']->value > 1) {?>
            <div class="admin-table-page">
                <div id="page" class="page">
                </div>
            </div>
        <?php }?>
    </div>
<?php
}
}
/* {/block 'body'} */
}
