<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:09:37
  from "/home/www/application/views/default/admin/layouts/mainlayout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885c851559e37_82135621',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b0ed2bfee497f5538bc6a15796eababf4f82d1d' => 
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
function content_5885c851559e37_82135621 (Smarty_Internal_Template $_smarty_tpl) {
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10178917955885c851555cd6_90664625', 'head');
?>

</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10697766965885c851556916_19188735', 'body');
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14951268735885c851559530_48309777', 'javascript');
?>

</body>
</html><?php }
/* {block 'head'} */
class Block_10178917955885c851555cd6_90664625 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_10178917955885c851555cd6_90664625',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head'} */
/* {block 'body'} */
class Block_10697766965885c851556916_19188735 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_10697766965885c851556916_19188735',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'body'} */
/* {block 'javascript'} */
class Block_14951268735885c851559530_48309777 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_14951268735885c851559530_48309777',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'javascript'} */
}
