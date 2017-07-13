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


            <form class="layui-form" action="{site_url('game/role')}" method="get">

                <div>
                    <div class="layui-input-inline">
                        <select name="status">

                            <option value="0"{if (int)$status===0} selected="selected"{/if}>未审核</option>
                            <option value="1"{if (int)$status===1} selected="selected"{/if}>已通过</option>
                            <option value="-1"{if (int)$status===-1} selected="selected"{/if}>已驳回</option>
                        </select>
                    </div>


                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                    </div>
                </div>
            </form>

        </blockquote>
        <fieldset class="layui-elem-field">

            {if !empty( $list)}

                <div class="layui-field-box">
                    <table class="site-table table-hover">
                        <thead>
                            <tr>
                                <th>状态</th>
                                <th>环信ID/UID</th>
                                <th>手机号</th>
                                <th>昵称</th>
                                <th>角色或称</th>
                                <th>游戏</th>
                                <th>下载渠道</th>
                                <th>区服</th>
                                <th>平台</th>
                                <th>角色名称</th>
                                <th>绑定手机</th>
                                <th>聊天</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $list as $row}
                                <tr>
                                    <td>
                                        {if (int)$row.status===1}
                                            已通过
                                        {elseif (int)$row.status===-1}
                                            已驳回
                                        {else}
                                            待审核
                                        {/if}

                                    </td>
                                    <td>{$row.userId}</td>
                                    <td>{$row.tel}</td>
                                    <td>{$row.usernick}</td>
                                    <td>{$row.name}</td>
                                    <td>{$row.game}</td>
                                    <td>{$row.channel}</td>
                                    <td>{$row.services}</td>
                                    <td>
                                        {if (int)$row.system===1}
                                            <i class="fa fa-android" aria-hidden="true"></i>
                                        {elseif (int)$row.system===2}
                                            <i class="fa fa-apple" aria-hidden="true"></i>
                                        {/if}
                                    </td>

                                    <td><a href="{$row.nameimg}" target="_blank">查看</a></td>
                                    <td><a href="{$row.phoneimg}" target="_blank">查看</a></td>
                                    <td><a href="{$row.imimg}" target="_blank">查看</a></td>

                                    <td align="center">
                                        {if (int)$row.status===0}
                                            <a href="{site_url('game/rolecheck/')}{$row.uid}" data-confirm="你确定要通过吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-check" aria-hidden="true"></i> 通过</a>
                                            <a href="{site_url('game/roleremove/')}{$row.uid}" data-confirm="你确定要驳回吗？" class="layui-btn layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 驳回</a>
                                        {/if}
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