<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:24:54
  from "/home/www/application/views/default/admin/layouts/mainlayout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885cbe687ecb1_77583286',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4847fd36f3ea2ed802bc27410fab0c62757ed345' => 
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
function content_5885cbe687ecb1_77583286 (Smarty_Internal_Template $_smarty_tpl) {
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10463464075885cbe687ae44_68369034', 'head');
?>

</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2250109335885cbe687b941_61552341', 'body');
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16533948615885cbe687e402_77073390', 'javascript');
?>

</body>
</html><?php }
/* {block 'head'} */
class Block_10463464075885cbe687ae44_68369034 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_10463464075885cbe687ae44_68369034',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head'} */
/* {block 'body'} */
class Block_2250109335885cbe687b941_61552341 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_2250109335885cbe687b941_61552341',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'body'} */
/* {block 'javascript'} */
class Block_16533948615885cbe687e402_77073390 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_16533948615885cbe687e402_77073390',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'javascript'} */
}
