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
        });
    </script>
{/block}
{block name=body}
    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="" method="get">
                <div>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="{$name}" autocomplete="off" class="layui-input" placeholder="用户姓名">
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 提交</button>
                    </div>
                </div>
            </form>

        </blockquote>
        {if !empty( $list)}

            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>				    
                            <th>姓名</th>
                            <th>手机号</th>
                            <th>申请时间</th>                         
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $list as $row}
                            <tr>							   
                                <td>{$row.usernick}</td>
                                <td>{$row.tel}</td>
                                <td>{$row.time}</td>                               
                                <td align="center">
                                    <a href="{site_url('users/father')}?id={$row.userId}&faid={$row.fatherId}" class="layui-btn layui-btn-mini "><i class="fa fa-edit" aria-hidden="true"></i> 查看&nbsp;上下级</a>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>

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