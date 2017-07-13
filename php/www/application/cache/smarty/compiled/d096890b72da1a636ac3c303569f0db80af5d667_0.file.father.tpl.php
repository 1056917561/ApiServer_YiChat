<?php
/* Smarty version 3.1.31, created on 2017-06-02 10:08:33
  from "/home/www/application/views/default/admin/users/father.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5930c8a1469ae1_82075720',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd096890b72da1a636ac3c303569f0db80af5d667' => 
    array (
      0 => '/home/www/application/views/default/admin/users/father.tpl',
      1 => 1496369308,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5930c8a1469ae1_82075720 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19178444335930c8a145fb20_82699935', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'body'} */
class Block_19178444335930c8a145fb20_82699935 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_19178444335930c8a145fb20_82699935',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="" method="get">
                <div>
                    <div class="layui-input-inline">用户：<?php echo $_smarty_tpl->tpl_vars['userdata']->value['usernick'];?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;职位：<?php echo $_smarty_tpl->tpl_vars['userdata']->value['roleName'];?>
</div>
                    <div class="layui-inline" style="margin-left:30px;">
                        <a onclick="javascript:history.back();"  href="javascript:;" class="layui-btn layui-btn-small"><i class="fa fa-history" aria-hidden="true"></i>&nbsp;返回</a>
                    </div>
                </div>
            </form>

        </blockquote>
        <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>

            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th></th>						    
                            <th>姓名</th>
                            <th>手机号</th>
                            <th>职位</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($_smarty_tpl->tpl_vars['fatherdata']->value) {?>
                            <tr>
                                <td style="color:red">上级</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['fatherdata']->value['usernick'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['fatherdata']->value['tel'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['fatherdata']->value['roleName'];?>
</td>                               
                            </tr>
                        <?php }?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                            <tr>
                                <td style="color:red">下级</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['usernick'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['tel'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['roleName'];?>
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
