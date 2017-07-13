<?php
/* Smarty version 3.1.31, created on 2017-04-14 14:03:09
  from "/home/www/application/views/default/admin/file/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_58f0661d181953_22320094',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8da45143e70f282438d4d1c22113f5aa1ffc657d' => 
    array (
      0 => '/home/www/application/views/default/admin/file/index.tpl',
      1 => 1485162365,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f0661d181953_22320094 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_102149700358f0661d17e7a4_89893982', 'javascript');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_136379918958f0661d180df2_16172865', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "mainlayout.tpl");
}
/* {block 'javascript'} */
class Block_102149700358f0661d17e7a4_89893982 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript' => 
  array (
    0 => 'Block_102149700358f0661d17e7a4_89893982',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php echo js('ckfinder/ckfinder.js');?>

    <?php echo js('js/ckfinder.js');?>

<?php
}
}
/* {/block 'javascript'} */
/* {block 'body'} */
class Block_136379918958f0661d180df2_16172865 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_136379918958f0661d180df2_16172865',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="admin-main">
        <div class="ckfinder" id="ckfinder-widget"></div>
    </div>
<?php
}
}
/* {/block 'body'} */
}
