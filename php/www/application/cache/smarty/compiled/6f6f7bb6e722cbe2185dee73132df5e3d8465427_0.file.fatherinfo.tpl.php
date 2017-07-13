<?php
/* Smarty version 3.1.31, created on 2017-06-02 10:08:30
  from "/home/www/application/views/default/admin/users/fatherinfo.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5930c89e606f29_16150171',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6f6f7bb6e722cbe2185dee73132df5e3d8465427' => 
    array (
      0 => '/home/www/application/views/default/admin/users/fatherinfo.tpl',
      1 => 1496369305,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5930c89e606f29_16150171 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19508081845930c89e5f7525_39492889', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17783240455930c89e5fd2e3_90463253', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_19508081845930c89e5f7525_39492889 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_19508081845930c89e5f7525_39492889',
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
class Block_17783240455930c89e5fd2e3_90463253 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_17783240455930c89e5fd2e3_90463253',
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
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 提交</button>
                    </div>
                </div>
            </form>

        </blockquote>
        <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>

            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>				    
                            <th>姓名</th>
                            <th>手机号</th>
                            <th>申请时间</th>                         
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
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['usernick'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['tel'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
</td>                               
                                <td align="center">
                                    <a href="<?php echo site_url('users/father');?>
?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
&faid=<?php echo $_smarty_tpl->tpl_vars['row']->value['fatherId'];?>
" class="layui-btn layui-btn-mini "><i class="fa fa-edit" aria-hidden="true"></i> 查看&nbsp;上下级</a>
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


            <?php if ($_smarty_tpl->tpl_vars['pages']->value > 1) {?>
                <div class="admin-table-page">
                    <div id="page" class="page">
                    </div>
                </div>
            <?php }?>
        <?php }?>
    </div>
<?php
}
}
/* {/block 'body'} */
}
