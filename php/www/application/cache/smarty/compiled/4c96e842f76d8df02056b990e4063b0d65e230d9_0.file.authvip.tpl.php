<?php
/* Smarty version 3.1.31, created on 2017-04-14 20:32:14
  from "/home/www/application/views/default/admin/users/authvip.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_58f0c14ea280b4_62018795',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c96e842f76d8df02056b990e4063b0d65e230d9' => 
    array (
      0 => '/home/www/application/views/default/admin/users/authvip.tpl',
      1 => 1492173123,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f0c14ea280b4_62018795 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_192019779958f0c14ea18c25_52651137', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_156541058858f0c14ea1ccb4_52192282', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_192019779958f0c14ea18c25_52651137 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_192019779958f0c14ea18c25_52651137',
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
            layer.msg('没有任何数据');
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
class Block_156541058858f0c14ea1ccb4_52192282 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_156541058858f0c14ea1ccb4_52192282',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="" method="get">
                <div>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" autocomplete="off" class="layui-input" placeholder="用户姓名">
                        <input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
" autocomplete="off" class="layui-input" placeholder="">
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 提交</button>
                    </div>
                </div>
            </form>

        </blockquote>

        <div class="layui-field-box">
            <ul class="layui-tab-title">
                <li onclick="window.location.href = '<?php echo site_url('users/authvip');?>
?status=0';" <?php if ($_smarty_tpl->tpl_vars['status']->value == 0) {?>class="layui-this"<?php }?>>待审核</li>
                <li onclick="window.location.href = '<?php echo site_url('users/authvip');?>
?status=1';" <?php if ($_smarty_tpl->tpl_vars['status']->value == 1) {?>class="layui-this"<?php }?>>已审核</li>
                <li onclick="window.location.href = '<?php echo site_url('users/authvip');?>
?status=2';" <?php if ($_smarty_tpl->tpl_vars['status']->value == 2) {?>class="layui-this"<?php }?>>已驳回</li>
            </ul>
            <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>手机号</th>
                            <th>申请时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['userTel'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
</td>
                                <td><?php if ((int)$_smarty_tpl->tpl_vars['row']->value['status'] === 1) {?>已审核<?php } elseif ((int)$_smarty_tpl->tpl_vars['row']->value['status'] === 2) {?>已驳回<?php } else { ?>待审核<?php }?></td>
                                <td align="center">
                                    <a href="<?php echo site_url('users/getAuthvipInfo');?>
?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" class="layui-btn layui-btn-mini "><i class="fa fa-edit" aria-hidden="true"></i> 查看详情并审核</a>
                                </td>
                            </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </tbody>
                </table>
            <?php }?>
        </div>


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
