<?php
/* Smarty version 3.1.31, created on 2017-04-14 18:30:27
  from "/home/www/application/views/default/admin/activity/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_58f0a4c3da0716_07226241',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3167a3adc963863961fb04cd9c4a9bbdd00db9cc' => 
    array (
      0 => '/home/www/application/views/default/admin/activity/index.tpl',
      1 => 1492165824,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f0a4c3da0716_07226241 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4495080558f0a4c3d8be60_95390672', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_54226879558f0a4c3d90b16_20981891', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_4495080558f0a4c3d8be60_95390672 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_4495080558f0a4c3d8be60_95390672',
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
class Block_54226879558f0a4c3d90b16_20981891 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_54226879558f0a4c3d90b16_20981891',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="<?php echo site_url('activity/index');?>
" method="get">
                <div>

                    <div class="layui-input-inline">
                        <input type="text" name="usernick" value="<?php echo $_smarty_tpl->tpl_vars['usernick']->value;?>
" autocomplete="off" class="layui-input" placeholder="发起人">
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
                            <th>发起人</th>
                            <th>活动主题</th>
                            <th>活动时间</th>
                            <th>报名截止时间</th>
                            <th>活动地点</th>
                            <th>活动描述</th>
                            <th>发布时间</th>
                            <th>报名人数</th>
                            <th>打卡人数</th>
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
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['usernick'];?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>

                                </td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['startTime'];?>

                                </td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['endTime'];?>

                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['activityPlace'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['activityDesc'];?>
</td>

                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['population'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['clock'];?>
</td>
                                <td align="center">
                                    <a href="<?php echo site_url('Activity/punchCard');?>
?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
&act=join"  class="layui-btn layui-btn-mini"><i class="fa fa-user-plus" aria-hidden="true"></i> 已报名</a>
                                    <a href="<?php echo site_url('Activity/punchCard');?>
?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
&act=clock"  class="layui-btn layui-btn-mini"><i class="fa fa-clock-o" aria-hidden="true"></i> 已打卡</a>
                                    <a href="<?php echo site_url('Activity/delete/');
echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" data-confirm="你确定要删除吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 删除</a>
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
