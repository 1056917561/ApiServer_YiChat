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


            $(".friends").on('click', function (event) {
                event.preventDefault();
                //$('.rowtable').hide();
                $('#' + $(this).data('userid')).fadeToggle();
            });




        });
    </script>
{/block}
{block name=body}
    <div class="admin-main">

        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="{site_url('game/system')}" method="get">
                <input type="hidden" name="pid" value="{$pid}" />
                <div>
                    
                    <div class="layui-inline">
                        <a href="{site_url('game/systemadd')}?pid={$pid}" class="layui-btn"><i class="fa fa-plus"></i> 新增平台</a>
                    </div>
                </div>
            </form>

        </blockquote>
        <fieldset class="layui-elem-field">

            <legend>平台</legend>

            {if !empty( $list)}

                <div class="layui-field-box">
                    <table class="site-table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>平台</th>
                                <th>游戏</th>
                                <th>下载渠道</th>
                                <th>区服</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $list as $row}
                                <tr>
                                    <td>{$row.id}</td>
                                    <td>
                                        {if (int)$row.name===1}
                                            <i class="fa fa-android" aria-hidden="true"></i>
                                        {elseif (int)$row.name===2}
                                            <i class="fa fa-apple" aria-hidden="true"></i>
                                        {/if}
                                    </td>
                                    <td>{$row.game}</td>
                                    <td>{$row.channel}</td>
                                    <td>{$row.services}</td>
                                    <td align="center">
                                        <a href="{site_url('game/delete/')}{$row.id}" data-confirm="你确定要删除吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 删除</a>
                                        <a href="{site_url('game/systemedit/')}{$row.id}?pid={$pid}"  class="layui-btn layui-btn-mini"><i class="fa fa-edit" aria-hidden="true"></i> 更新</a>
                                    </td>
                                </tr>

                            {/foreach}
                        </tbody>
                    </table>

                </div>
            </fieldset>

            {if $pages>1}
                <div class="admin-table-page">
                    <div id="page" class="page">
                    </div>
                </div>
            {/if}
        {/if}

    </div>
{/block}