<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:33:25
  from "/home/www/application/views/default/admin/activity/comments.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885cde5c9c7c9_28546469',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61c6835f1d618c9022f85dc1c82afeb9796a23f8' => 
    array (
      0 => '/home/www/application/views/default/admin/activity/comments.tpl',
      1 => 1485162365,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5885cde5c9c7c9_28546469 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21160081945885cde5c90b49_19010225', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2241104095885cde5c95784_24327987', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_21160081945885cde5c90b49_19010225 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_21160081945885cde5c90b49_19010225',
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


            $('.site-table tbody tr').on('click', function (event) {
                var $this = $(this);
                var $input = $this.children('td').eq(0).find('input');
                $input.on('ifChecked', function (e) {
                    $this.css('background-color', '#EEEEEE');
                });
                $input.on('ifUnchecked', function (e) {
                    $this.removeAttr('style');
                });
                $input.iCheck('toggle');
            }).find('input').each(function () {
                var $this = $(this);
                $this.on('ifChecked', function (e) {
                    $this.parents('tr').css('background-color', '#EEEEEE');
                });
                $this.on('ifUnchecked', function (e) {
                    $this.parents('tr').removeAttr('style');
                });
            });


            $("[name='shelves']").each(function () {
                var $this = $(this);
                $this.on('ifChecked', function (e) {
                    $this.parents('tr').css('background-color', '#EEEEEE');
                });
                $this.on('ifUnchecked', function (e) {
                    $this.parents('tr').removeAttr('style');
                });
            });

        });
    <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'javascript'} */
/* {block 'body'} */
class Block_2241104095885cde5c95784_24327987 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_2241104095885cde5c95784_24327987',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="<?php echo site_url('activity/comments');?>
" method="get">
                <div>

                    <div class="layui-input-inline">
                        <input type="text" name="usernick" value="<?php echo $_smarty_tpl->tpl_vars['usernick']->value;?>
" autocomplete="off" class="layui-input" placeholder="昵称">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="keyword" value="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
" autocomplete="off" class="layui-input" placeholder="内容关键字">
                    </div>
                    
                   

                    <div class="layui-inline">

                        <input type="text" name="date" id="date" value="<?php echo $_smarty_tpl->tpl_vars['date']->value;?>
" placeholder="发布时间" autocomplete="off" class="layui-input"  onclick="layui.laydate({elem: this})">

                    </div>
                       

                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                    </div>
                </div>
            </form>

        </blockquote>
        <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>

            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>昵称</th>
                            <th>内容</th>
                            <th>发布时间</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['usernick'];?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['content'];?>

                                </td>
                                
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
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
