<?php
/* Smarty version 3.1.31, created on 2017-06-02 17:04:59
  from "/home/www/application/views/default/admin/users/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59312a3b2ba5d8_57373683',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '17611475bb0e9e1b1d808ca014f67a020188984a' => 
    array (
      0 => '/home/www/application/views/default/admin/users/index.tpl',
      1 => 1496394295,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59312a3b2ba5d8_57373683 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_24882896059312a3b288819_34564717', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_178850964159312a3b28de65_90882648', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_24882896059312a3b288819_34564717 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_24882896059312a3b288819_34564717',
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


            $(".friends").on('click', function (event) {
                event.preventDefault();
                //$('.rowtable').hide();
                $('#' + $(this).data('userid')).fadeToggle();
            });




        });
    <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'javascript'} */
/* {block 'body'} */
class Block_178850964159312a3b28de65_90882648 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_178850964159312a3b28de65_90882648',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="<?php echo site_url('users/index');?>
" method="get">
                <div>
                    <div class="layui-input-inline">
                        <input type="text" name="userId" value="<?php echo $_smarty_tpl->tpl_vars['userId']->value;?>
" autocomplete="off" class="layui-input" placeholder="用户ID">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="fxid" value="<?php echo $_smarty_tpl->tpl_vars['fxid']->value;?>
" autocomplete="off" class="layui-input" placeholder="慈济号">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="usernick" value="<?php echo $_smarty_tpl->tpl_vars['usernick']->value;?>
" autocomplete="off" class="layui-input" placeholder="昵称">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="tel" value="<?php echo $_smarty_tpl->tpl_vars['tel']->value;?>
" autocomplete="off" class="layui-input" placeholder="手机号">
                    </div>

                    <div class="layui-inline">

                        <input type="text" name="date" id="date" value="<?php echo $_smarty_tpl->tpl_vars['date']->value;?>
" placeholder="注册时间" autocomplete="off" class="layui-input"  onclick="layui.laydate({elem: this})">

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
                            <th>用户ID</th>
                            <th>慈济号</th>
                            <th>视频权限</th>
                            <th>活动权限</th>
                            <th>昵称</th>
                            <th>部门</th>
                            <th>手机号</th>
                            <th>职位</th>
                            <th>绑定</th>
                            <th>性别</th>
                            <th>注册时间</th>
                            <th>小组</th>
                            <th>省份</th>
                            <th>城市</th>
                            <th>上级</th>
                            <th>签名</th>
                            <th>黑名单/好友</th>
                            <th width="200px">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['fxid'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['row']->value['meetingAuth']) {?>有<?php } else { ?>无<?php }?></td>
                                <td><?php if ($_smarty_tpl->tpl_vars['row']->value['activityAuth']) {?>有<?php } else { ?>无<?php }?></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['usernick'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['areaName'];?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['tel'];?>

                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['roleName'];?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['type'];?>

                                </td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['sex'];?>


                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['groupName'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['province'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['city'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['fatherName'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['sign'];?>
</td>
                                <td style="line-height:27px">
                                    <a href="#" data-userid="blacks<?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" class="layui-btn layui-btn-primary layui-btn-mini friends">查看黑名单 <?php if (is_array($_smarty_tpl->tpl_vars['row']->value['blacks'])) {
echo count($_smarty_tpl->tpl_vars['row']->value['blacks']);
} else { ?>0<?php }?></a>
                                    <a href="#" data-userid="friends<?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" class="layui-btn layui-btn-primary layui-btn-mini friends">查看好友 <?php if (is_array($_smarty_tpl->tpl_vars['row']->value['friends'])) {
echo count($_smarty_tpl->tpl_vars['row']->value['friends']);
} else { ?>0<?php }?></a>
                                </td>
                                <td align="center" style="line-height:27px">
                                    <a href="<?php echo site_url('users/edit/');
echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" class="layui-btn layui-btn-mini"><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                    <a href="<?php echo site_url('users/deleteusers/');
echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" data-confirm="你确定要删除吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 删除</a>
                                    <br>
                                    <?php if (!$_smarty_tpl->tpl_vars['row']->value['meetingAuth']) {?>
                                        <a href="<?php echo site_url('users/meeting/');
echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" data-confirm="你确定要给TA视频权限吗？" class="layui-btn  layui-btn-mini"><i class="fa fa-check" aria-hidden="true"></i> 视频权限</a>
                                    <?php }?>
                                    <?php if (!$_smarty_tpl->tpl_vars['row']->value['activityAuth']) {?>
                                        <a href="<?php echo site_url('users/activity/');
echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" data-confirm="你确定要给TA活动权限吗？" class="layui-btn  layui-btn-mini"><i class="fa fa-check" aria-hidden="true"></i> 活动权限</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="18">
                                    <?php if (is_array($_smarty_tpl->tpl_vars['row']->value['friends'])) {?>
                                        <table class="layui-table rowtable" id="friends<?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" lay-even lay-skin="nob" style="display:none">
                                            <thead>
                                                <tr>
                                                    <th>环信ID/UID</th>
                                                    <th>凡信号</th>
                                                    <th>昵称</th>
                                                    <th>手机号</th>
                                                    <th>绑定</th>
                                                    <th>性别</th>
                                                    <th>注册时间</th>
                                                    <th>城市</th>
                                                    <th>签名</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value['friends'], 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
                                                    <tr>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['userId'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['fxid'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['nick'];?>
</td>
                                                        <td>
                                                            <?php echo $_smarty_tpl->tpl_vars['vo']->value['tel'];?>

                                                        </td>
                                                        <td>
                                                            <?php echo $_smarty_tpl->tpl_vars['vo']->value['type'];?>

                                                        </td>
                                                        <td>
                                                            <?php echo $_smarty_tpl->tpl_vars['vo']->value['sex'];?>


                                                        </td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['time'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['province'];
echo $_smarty_tpl->tpl_vars['vo']->value['city'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['sign'];?>
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
                                    <?php if (is_array($_smarty_tpl->tpl_vars['row']->value['blacks'])) {?>
                                        <table class="layui-table rowtable" id="blacks<?php echo $_smarty_tpl->tpl_vars['row']->value['userId'];?>
" lay-even lay-skin="nob" style="display:none">
                                            <thead>
                                                <tr>
                                                    <th>环信ID/UID</th>
                                                    <th>凡信号</th>
                                                    <th>昵称</th>
                                                    <th>手机号</th>
                                                    <th>绑定</th>
                                                    <th>性别</th>
                                                    <th>注册时间</th>
                                                    <th>城市</th>
                                                    <th>签名</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value['blacks'], 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
                                                    <tr>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['userId'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['fxid'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['nick'];?>
</td>
                                                        <td>
                                                            <?php echo $_smarty_tpl->tpl_vars['vo']->value['tel'];?>

                                                        </td>
                                                        <td>
                                                            <?php echo $_smarty_tpl->tpl_vars['vo']->value['type'];?>

                                                        </td>
                                                        <td>
                                                            <?php echo $_smarty_tpl->tpl_vars['vo']->value['sex'];?>


                                                        </td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['time'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['province'];
echo $_smarty_tpl->tpl_vars['vo']->value['city'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['sign'];?>
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
