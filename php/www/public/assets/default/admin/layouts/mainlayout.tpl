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
        {css('css/global.css')}
    {block name=head}{/block}
</head>
<body>
{block name=body}{/block}
<script type="text/javascript">
    var theme_url = '{theme_url()}',uploadJson='{site_url('file/upload')}',fileManagerJson='{site_url('file/manager')}';
</script>
{js('plugins/layui/layui.js')}
{js('js/layer.js')}
{block name=javascript}{/block}
</body>
</html>