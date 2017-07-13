{extends file="mainlayout.tpl"}
{block name=javascript}
    <script type="text/javascript">
        layui.config({
            base: theme_url + 'plugins/layui/modules/'
        });
        layui.use(['jquery', 'form', 'icheck', 'laypage', 'layer', 'laydate', 'query'], function () {
            var $ = layui.jquery,
                    form = layui.form(),
                    laypage = layui.laypage,
                    layer = parent.layer === undefined ? layui.layer : parent.layer,
                    laydate = layui.laydate;
 $('input').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            })


            $("[data-tab]").on('click', function () {
                var t = $(this);
                parent.tab.tabAdd({
                    title: t.data('title'),
                    icon: t.data('icon'),
                    href: t.attr('href')
                });
                return false;
            });

        {if empty( $list)}
            layer.msg('没有任何数据');
        {elseif $pages>1}
            laypage({
                cont: 'page',
                pages: {$pages},
                curr:{$page},
                groups: 5,
                jump: function (obj, first) {

                    var curr = obj.curr;
                    if (!first) {
                        self.location = $.query.set("page", obj.curr);
                    }
                }
            });
        {/if}
            $('#deletes').on('click', function (event) {
                event.preventDefault();
                var t = $(this);
                parent.layer.confirm('你确定要删除已选择的吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    parent.layer.load();


                    $.post('{site_url('zone/deletescomments')}', $('#formdel').serializeArray(),
                            function (data) {
                                parent.layer.closeAll('loading');
                                if (data.status === 1) {
                                    parent.layer.msg(data.info, {
                                        icon: 1});
                                } else {
                                    parent.layer.msg(data.info, {
                                        icon: 2});
                                }
                                if (data.url !== '') {
                                    url = data.url;
                                    setTimeout("self.location=url", 1000);
                                } else {
                                    setTimeout("location.reload()", 1000);
                                }
                            }, "json").error(function () {
                        parent.layer.closeAll('loading');
                        parent.layer.msg('服务器出错', {
                            icon: 2});
                    });
                }, function () {
                });

            });


             $('.site-table tbody tr').on('click', function (event) {
                var $this = $(this);
                var $input = $this.children('td').eq(0).find('input');
                $input.on('ifChecked', function (e) {
                    $this.css('background-color', '#EEEEEE');
                });
                $input.on('ifUnchecked', function (e) {
                    $this.removeAttr('style');
                });
                $input.iCheck('toggle');
            }).find('input').each(function () {
                var $this = $(this);
                $this.on('ifChecked', function (e) {
                    $this.parents('tr').css('background-color', '#EEEEEE');
                });
                $this.on('ifUnchecked', function (e) {
                    $this.parents('tr').removeAttr('style');
                });
            });
            $('#selected-all').on('ifChanged', function (event) {
                var $input = $('.site-table tbody tr td').find('input');
                $input.iCheck(event.currentTarget.checked ? 'check' : 'uncheck');
            });


            $("[name='shelves']").each(function () {
                var $this = $(this);
                $this.on('ifChecked', function (e) {
                    $this.parents('tr').css('background-color', '#EEEEEE');
                });
                $this.on('ifUnchecked', function (e) {
                    $this.parents('tr').removeAttr('style');
                });
            });

        });
    </script>
{/block}
{block name=body}
    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="{site_url('zone/comments')}" method="get">
                <div>
                    <div class="layui-input-inline">
                        <input type="text" name="userId" value="{$userId}" autocomplete="off" class="layui-input" placeholder="环信ID">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="fxid" value="{$fxid}" autocomplete="off" class="layui-input" placeholder="凡信号">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="usernick" value="{$usernick}" autocomplete="off" class="layui-input" placeholder="昵称">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="keyword" value="{$keyword}" autocomplete="off" class="layui-input" placeholder="内容关键字">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="replyusernick" value="{$replyusernick}" autocomplete="off" class="layui-input" placeholder="回复人昵称">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="replykeyword" value="{$replykeyword}" autocomplete="off" class="layui-input" placeholder="回复内容关键字">
                    </div>

                    <div class="layui-inline">

                        <input type="text" name="date" id="date" value="{$date}" placeholder="发布时间" autocomplete="off" class="layui-input" {literal} onclick="layui.laydate({elem: this})"{/literal}>

                    </div>
                    <div class="layui-inline">

                        <input type="text" name="replydate" id="date" value="{$replydate}" placeholder="回复时间" autocomplete="off" class="layui-input" {literal} onclick="layui.laydate({elem: this})"{/literal}>

                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                    </div>
                    <div class="layui-inline">
                        <button type="button" class="layui-btn" id="deletes"><i class="fa fa-remove"></i> 批量删除</button>
                    </div>
                </div>
            </form>

        </blockquote>
        {if !empty( $list)}

            <div class="layui-field-box">
                <form id="formdel">
                    <table class="site-table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selected-all"></th>
                                <th>环信ID/UID</th>
                                <th>凡信号</th>
                                <th>ID</th>
                                <th>昵称</th>
                                <th>内容</th>
                                <th>发布时间</th>
                                <th>回复</th>
                                <th>回复内容</th>
                                <th>回复时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $list as $row}
                                <tr>
                                    <tr>
                                    <td style="width: 23px;"><input type="checkbox" name="ids[]" value="{$row.id}"></td>
                                    <td>{$row.userId}</td>
                                    <td>{$row.fxid}</td>
                                    <td>{$row.id}</td>
                                    <td>{$row.usernick}</td>
                                    <td>
                                        {$row.content}
                                    </td>

                                    <td>{$row.time}</td>
                                    <td>{$row.replyUsernick}</td>
                                    <td>{$row.replyContent}</td>
                                    <td>{$row.replyTime}</td>
                                    <td align="center">
                                        <a href="{site_url('zone/deletecomments/')}{$row.id}" data-confirm="你确定要删除吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 删除</a>
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </form>
            </div>


            {if $pages>1}
                <div class="admin-table-page">
                    <div id="page" class="page">
                    </div>
                </div>
            {/if}
        {/if}
    </div>
{/block}