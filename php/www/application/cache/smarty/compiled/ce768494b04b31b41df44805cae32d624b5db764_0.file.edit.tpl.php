<?php
/* Smarty version 3.1.31, created on 2017-06-02 17:14:41
  from "/home/www/application/views/default/admin/users/edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59312c81b9ec74_86801615',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ce768494b04b31b41df44805cae32d624b5db764' => 
    array (
      0 => '/home/www/application/views/default/admin/users/edit.tpl',
      1 => 1496394294,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59312c81b9ec74_86801615 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12917431759312c81b8e1c7_96477412', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'body'} */
class Block_12917431759312c81b8e1c7_96477412 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_12917431759312c81b8e1c7_96477412',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <form class="layui-form" action="" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">慈济号</label>
                <div class="layui-input-block">
                    <input type="text" name="fxid" required  lay-verify="required"  value='<?php echo $_smarty_tpl->tpl_vars['list']->value['fxid'];?>
' placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-block">
                    <input type="text" name="usernick" required value='<?php echo $_smarty_tpl->tpl_vars['list']->value['usernick'];?>
' lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="tel" required value='<?php echo $_smarty_tpl->tpl_vars['list']->value['tel'];?>
' lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">部门</label>
                <div class="layui-input-block">
                    <select name="area_id" lay-verify="required" class="select" style="display:block">
                        <option value="">请选择部门</option>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['area']->value, 'g');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['g']->value) {
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['g']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['g']->value['id'] == $_smarty_tpl->tpl_vars['list']->value['area_id']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['g']->value['name'];?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">省份</label>
                <div class="layui-input-block">
                    <input type="text" name="province" required value='<?php echo $_smarty_tpl->tpl_vars['list']->value['province'];?>
'  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">城市</label>
                <div class="layui-input-block">
                    <input type="text" name="city" required value='<?php echo $_smarty_tpl->tpl_vars['list']->value['city'];?>
' lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">职位</label>
                <div class="layui-input-block">
                    <select name="role" lay-verify="required"  class="select" style="display:block">
                        <option value="">请选择身份</option>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roles']->value, 'g');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['g']->value) {
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['g']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['g']->value['id'] == $_smarty_tpl->tpl_vars['list']->value['role']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['g']->value['name'];?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">小组</label>
                <div class="layui-input-block">
                    <select name="group_id" lay-verify="required"  class="select" style="display:block">
                        <option value="">请选择分组</option>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value, 'g');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['g']->value) {
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['g']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['g']->value['id'] == $_smarty_tpl->tpl_vars['list']->value['group_id']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['g']->value['name'];?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">签名</label>
                <div class="layui-input-block">
                    <textarea name="sign" placeholder="签名" class="layui-textarea"><?php echo $_smarty_tpl->tpl_vars['list']->value['sign'];?>
</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    <a href="<?php echo site_url('users/index');?>
" class="layui-btn layui-btn-primary">取消</a>
                </div>
            </div>
        </form>
                
    </div>
    <style>
        .select{
            width: 100%;
            line-height: 38px;
            height: 38px;
            border: 1px solid #e6e6e6;
        }
    </style>
<?php
}
}
/* {/block 'body'} */
}
