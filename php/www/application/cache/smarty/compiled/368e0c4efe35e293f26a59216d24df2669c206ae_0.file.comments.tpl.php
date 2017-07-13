<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:06:10
  from "/home/www/application/views/default/admin/zone/comments.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885c782b80ab2_23230071',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '368e0c4efe35e293f26a59216d24df2669c206ae' => 
    array (
      0 => '/home/www/application/views/default/admin/zone/comments.tpl',
      1 => 1485162366,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5885c782b80ab2_23230071 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4957090385885c782b68296_14376864', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7486284035885c782b6e902_28304585', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_4957090385885c782b68296_14376864 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_4957090385885c782b68296_14376864',
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
 $('input').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            })


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
            $('#deletes').on('click', function (event) {
                event.preventDefault();
                var t = $(this);
                parent.layer.confirm('你确定要删除已选择的吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    parent.layer.load();


                    $.post('<?php echo site_url('zone/deletescomments');?>
', $('#formdel').serializeArray(),
                            function (data) {
                                parent.layer.closeAll('loading');
                                if (data.status === 1) {
                                    parent.layer.msg(data.info, {
                                        icon: 1});
                                } else {
                                    parent.layer.msg(data.info, {
                                        icon: 2});
                                }
                                if (data.url !== '') {
                                    url = data.url;
                                    setTimeout("self.location=url", 1000);
                                } else {
                                    setTimeout("location.reload()", 1000);
                                }
                            }, "json").error(function () {
                        parent.layer.closeAll('loading');
                        parent.layer.msg('服务器出错', {
                            icon: 2});
                    });
                }, function () {
                });

            });


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
            $('#selected-all').on('ifChanged', function (event) {
                var $input = $('.site-table tbody tr td').find('input');
                $input.iCheck(event.currentTarget.checked ? 'check' : 'uncheck');
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
class Block_7486284035885c782b6e902_28304585 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_7486284035885c782b6e902_28304585',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="<?php echo site_url('zone/comments');?>
" method="get">
                <div>
                    <div class="layui-input-inline">
                        <input type="text" name="userId" value="<?php echo $_smarty_tpl->tpl_vars['userId']->value;?>
" autocomplete="off" class="layui-input" placeholder="环信ID">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="fxid" value="<?php echo $_smarty_tpl->tpl_vars['fxid']->value;?>
" autocomplete="off" class="layui-input" placeholder="凡信号">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="usernick" value="<?php echo $_smarty_tpl->tpl_vars['usernick']->value;?>
" autocomplete="off" class="layui-input" placeholder="昵称">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="keyword" value="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
" autocomplete="off" class="layui-input" placeholder="内容关键字">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="replyusernick" value="<?php echo $_smarty_tpl->tpl_vars['replyusernick']->value;?>
" autocomplete="off" class="layui-input" placeholder="回复人昵称">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="replykeyword" value="<?php echo $_smarty_tpl->tpl_vars['replykeyword']->value;?>
" autocomplete="off" class="layui-input" placeholder="回复内容关键字">
                    </div>

                    <div class="layui-inline">

                        <input type="text" name="date" id="date" value="<?php echo $_smarty_tpl->tpl_vars['date']->value;?>
" placeholder="发布时间" autocomplete="off" class="layui-input"  onclick="layui.laydate({elem: this})">

                    </div>
                    <div class="layui-inline">

                        <input type="text" name="replydate" id="date" value="<?php echo $_smarty_tpl->tpl_vars['replydate']->value;?>
" placeholder="回复时间" autocomplete="off" class="layui-input"  onclick="layui.laydate({elem: this})">

                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                    </div>
                    <div class="layui-inline">
                        <button type="button" class="layui-btn" id="deletes"><i class="fa fa-remove"></i> 批量删除</button>
                    </div>
                </div>
            </form>

        </blockquote>
        <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>

            <div class="layui-field-box">
                <form id="formdel">
                    <table class="site-table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selected-all"></th>
                                <th>环信ID/UID</th>
                                <th>凡信号</th>
                                <th>ID</th>
                                <th>昵称</th>
                                <th>内容</th>
                                <th>发布时间</th>
                                <th>回复</th>
                                <th>回复内容</th>
                                <th>回复时间</th>
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
                                    <tr>
                                    <td style="width: 23px;"><input type="checkbox" name="ids[]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"></td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['fxid'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['usernick'];?>
</td>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['row']->value['content'];?>

                                    </td>

                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['replyUsernick'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['replyContent'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['replyTime'];?>
</td>
                                    <td align="center">
                                        <a href="<?php echo site_url('zone/deletecomments/');
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
                </form>
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
