<?php
/* Smarty version 3.1.31, created on 2017-04-14 16:41:04
  from "/home/www/application/views/default/admin/users/getauthvipinfo.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_58f08b206ad6a0_56374970',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ae9c07f839a29d7ad31ad7ab5c9597f41bbc6cdb' => 
    array (
      0 => '/home/www/application/views/default/admin/users/getauthvipinfo.tpl',
      1 => 1492159258,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f08b206ad6a0_56374970 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_207834307058f08b206a0bb8_97900271', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_181652961658f08b206a4f42_92154022', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_207834307058f08b206a0bb8_97900271 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_207834307058f08b206a0bb8_97900271',
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
class Block_181652961658f08b206a4f42_92154022 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_181652961658f08b206a4f42_92154022',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <style>
        .layui-input-block {
            line-height: 36px;
        }
        .layui-form-label {
            width: 120px;
            font-weight: 500;
            font-size: 15px;
        }
    </style>
    <div class="admin-main">
        <fieldset class="layui-elem-field">
            <legend>身份审核</legend>
            <div class="layui-field-box">
                <form class="layui-form" action="" method="get">
                    <div class="layui-form-item">
                        <label class="layui-form-label">姓名：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['username'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">性别：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['sex'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">手机号：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['userTel'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">身份证号：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['cardId'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">身份属性：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['roleName'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属区域：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['areaName'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属省份：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['province'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属城市：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['city'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">所属小组：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['groupName'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">母鸡：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['fatherName'];?>
</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">母鸡手机号：</label>
                        <div class="layui-input-block"><?php echo $_smarty_tpl->tpl_vars['list']->value['fatherTel'];?>
</div>
                    </div>
                    <?php if (!$_smarty_tpl->tpl_vars['list']->value['status']) {?>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <a href="<?php echo site_url('users/getAuthvipInfo');?>
?action=audit&id=<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
" data-confirm="你确定要审核当前认证申请吗？" class="layui-btn"><i class="fa fa-check" aria-hidden="true"></i> 审核</a>
                                <a href="<?php echo site_url('users/authvip');?>
" class="layui-btn"><i class="fa fa-remove" aria-hidden="true"></i> 取消</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <a href="<?php echo site_url('users/authvip');?>
" class="layui-btn"><i class="fa fa-history" aria-hidden="true"></i> 返回</a>
                            </div>
                        </div>
                    <?php }?>
                </form>                
            </div>
        </fieldset>
    </div>
<?php
}
}
/* {/block 'body'} */
}
