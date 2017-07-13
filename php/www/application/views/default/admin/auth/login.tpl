<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>{lang('login_heading')}</title>
        {css('plugins/layui/css/layui.css')}
        {css('css/login.css')}
    </head>

    <body class="beg-login-bg">
        <div class="container">
            <div id="large-header" class="large-header">
                <canvas id="demo-canvas"></canvas>
                <div class="beg-login-box">
                    <header>
                        <h1>{lang('login_heading')}</h1>
                    </header>
                    <div class="beg-login-main">
                        {form_open("auth/login",['class'=>'layui-form'])}
                        <div class="layui-form-item">
                            <label class="beg-login-icon">
                                <i class="layui-icon">&#xe612;</i>
                            </label>
                            {form_input($identity)}
                        </div>
                        <div class="layui-form-item">
                            <label class="beg-login-icon">
                                <i class="layui-icon">&#xe642;</i>
                            </label>
                            {form_input($password)}
                        </div>
                        <div class="layui-form-item">
                            <div class="beg-pull-left beg-login-remember">
                                <label>{lang('login_remember_label')}</label>
                                <input type="checkbox" name="remember" value="true" lay-skin="switch" checked title="{lang('login_remember_label')}">
                            </div>
                            <div class="beg-pull-right">
                                <button class="layui-btn layui-btn-primary" lay-submit lay-filter="login">
                                    <i class="layui-icon">&#xe650;</i> {lang('login_submit_btn')}
                                </button>
                            </div>
                            <div class="beg-clear"></div>
                        </div>
                        </form>
                    </div>
                    <footer>
                        合肥掌峰科技有限公司
                    </footer>
                </div>
            </div>
        </div>
        {js('plugins/layui/layui.js')}
        {js('js/layer.js')}
        {js('js/TweenLite.min.js')}
        {js('js/EasePack.min.js')}
        {js('js/rAF.js')}
        {js('js/login.js')}
        <script>

            layui.use('form', function () {
                var form = layui.form();

            });
        </script>
    </body>

</html>