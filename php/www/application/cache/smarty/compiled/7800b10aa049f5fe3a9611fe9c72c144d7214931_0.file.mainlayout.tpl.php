<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:06:08
  from "/home/www/application/views/default/admin/layouts/mainlayout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885c7802754d3_76976820',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7800b10aa049f5fe3a9611fe9c72c144d7214931' => 
    array (
      0 => '/home/www/application/views/default/admin/layouts/mainlayout.tpl',
      1 => 1485162366,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5885c7802754d3_76976820 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>后台管理模板</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <?php echo css('css/global.css');?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_587888995885c780271600_82908238', 'head');
?>

</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17725964305885c780272102_52712225', 'body');
?>

<?php echo '<script'; ?>
 type="text/javascript">
    var theme_url = '<?php echo theme_url();?>
',uploadJson='<?php echo site_url('file/upload');?>
',fileManagerJson='<?php echo site_url('file/manager');?>
';
<?php echo '</script'; ?>
>
<?php echo js('plugins/layui/layui.js');?>

<?php echo js('js/layer.js');?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8681891535885c780274c01_53291949', 'javascript');
?>

</body>
</html><?php }
/* {block 'head'} */
class Block_587888995885c780271600_82908238 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_587888995885c780271600_82908238',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head'} */
/* {block 'body'} */
class Block_17725964305885c780272102_52712225 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_17725964305885c780272102_52712225',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'body'} */
/* {block 'javascript'} */
class Block_8681891535885c780274c01_53291949 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_8681891535885c780274c01_53291949',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'javascript'} */
}
