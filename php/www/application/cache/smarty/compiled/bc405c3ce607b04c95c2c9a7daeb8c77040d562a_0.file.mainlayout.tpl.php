<?php
/* Smarty version 3.1.31, created on 2017-01-23 17:33:25
  from "/home/www/application/views/default/admin/layouts/mainlayout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5885cde53a7e45_93412086',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc405c3ce607b04c95c2c9a7daeb8c77040d562a' => 
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
function content_5885cde53a7e45_93412086 (Smarty_Internal_Template $_smarty_tpl) {
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19999522905885cde53a3ef5_65235633', 'head');
?>

</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2023032935885cde53a4a69_00220092', 'body');
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13789236615885cde53a7520_01687538', 'javascript');
?>

</body>
</html><?php }
/* {block 'head'} */
class Block_19999522905885cde53a3ef5_65235633 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_19999522905885cde53a3ef5_65235633',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head'} */
/* {block 'body'} */
class Block_2023032935885cde53a4a69_00220092 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_2023032935885cde53a4a69_00220092',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'body'} */
/* {block 'javascript'} */
class Block_13789236615885cde53a7520_01687538 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_13789236615885cde53a7520_01687538',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'javascript'} */
}
