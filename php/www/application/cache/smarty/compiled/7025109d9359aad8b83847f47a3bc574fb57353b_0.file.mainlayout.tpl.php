<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:06:09
  from "/home/www/application/views/default/admin/layouts/mainlayout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885c7813e30b9_48108023',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7025109d9359aad8b83847f47a3bc574fb57353b' => 
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
function content_5885c7813e30b9_48108023 (Smarty_Internal_Template $_smarty_tpl) {
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5825730985885c7813de838_55000638', 'head');
?>

</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17085933765885c7813df856_33869555', 'body');
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17927363415885c7813e26d8_29667494', 'javascript');
?>

</body>
</html><?php }
/* {block 'head'} */
class Block_5825730985885c7813de838_55000638 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_5825730985885c7813de838_55000638',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head'} */
/* {block 'body'} */
class Block_17085933765885c7813df856_33869555 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_17085933765885c7813df856_33869555',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'body'} */
/* {block 'javascript'} */
class Block_17927363415885c7813e26d8_29667494 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_17927363415885c7813e26d8_29667494',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'javascript'} */
}
