<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:24:54
  from "/home/www/application/views/default/admin/plugin/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885cbe6874d10_10321189',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '131811b8bd3b664ce3d825da08364e1669579e0f' => 
    array (
      0 => '/home/www/application/views/default/admin/plugin/index.tpl',
      1 => 1485162366,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5885cbe6874d10_10321189 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14404557225885cbe6869356_94246559', 'body');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'body'} */
class Block_14404557225885cbe6869356_94246559 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_14404557225885cbe6869356_94246559',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <fieldset class="layui-elem-field">
            <legend>应用列表</legend>
            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <!--<th>插件</th>-->
                            <th>应用</th>
                            <th>说明</th>
                            <th>作者</th>
                            <th>版本</th>
                            <th>作者主页</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['plugin']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                            <tr>
                                <!--<td><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>-->
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['desc'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['example'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['author'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['version'];?>
</td>
                                <td>
                                    <?php if (!empty($_smarty_tpl->tpl_vars['row']->value['link'])) {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['row']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['row']->value['link'];?>
</a>
                                    <?php }?>
                                </td>

                                <td>
                                    <?php if (!empty($_smarty_tpl->tpl_vars['row']->value['plugin'])) {?>
                                        <a href="<?php echo site_url('plugin/delete/');
echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" data-confirm="你确定要卸载<?php echo $_smarty_tpl->tpl_vars['row']->value['desc'];?>
吗？" data-id="1" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">卸载</a>
                                        <?php if (!empty($_smarty_tpl->tpl_vars['row']->value['setting'])) {?>
                                            <a href="<?php echo site_url($_smarty_tpl->tpl_vars['row']->value['name']);?>
/setting" class="layui-btn layui-btn-normal layui-btn-mini">设置</a>
                                        <?php }?>
                                    <?php } else { ?>
                                        <a href="<?php echo site_url('plugin/install/');
echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" data-confirm="你确定要安装<?php echo $_smarty_tpl->tpl_vars['row']->value['desc'];?>
吗？" class="layui-btn layui-btn-mini">安装</a>
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
        </fieldset>
    </div>
<?php
}
}
/* {/block 'body'} */
}
