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
            layer.msg('没有可操作用户数据');
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
        {if !$user.region}
            <blockquote id='searchform' class="layui-elem-quote">
                <form class="layui-form" action="" method="get">
                    <div>
                        <div class="layui-input-inline">
                            <select name="region" lay-verify="required">
                                <option value="">请选择部门</option>
                                {foreach $area as $g}
                                    <option value="{$g.id}" {if $g.id==$region} selected="selected"{/if}>{$g.name}</option>
                                {/foreach}
                            </select>
                        </div> 
                        <div class="layui-input-inline">
                            <input type="text" name="tel" value="{$tel}" autocomplete="off" class="layui-input" placeholder="手机号">
                        </div>    
                        <div class="layui-inline">
                            <!--<button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe62a;</i> 确定</button>-->
                            <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                        </div>
                    </div>
                </form>
            </blockquote>
        {/if}
        {if $data}
            {if $regionName}<div style="line-height:37px;padding-left:20px">当前部门：{$regionName}</div>{/if}
            <div style="line-height:37px;padding-left:20px">{if $regionName}当前{/if}部门管理员名单：</div>
            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>登录账号</th>
                            <th>姓名</th>
                            <th>身份</th>
                            <th>手机号</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $data as $row}
                            <tr>
                                <td>{$row.username}</td>
                                <td>{$row.first_name}</td>
                                <td>{$row.roleName}</td>
                                <td>{$row.phone}</td>
                                <td>
                                    <a href="{site_url('users/removeadmin')}?id={$row.id}&uid={$row.userId}" data-confirm="你确定要取消该管理员权限吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 取消权限</a>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        {/if}
        {if $list}

            <div style="line-height:37px;padding-left:20px">用户列表：</div>
            {if $user.region}
                <blockquote id='searchform' class="layui-elem-quote">
                    <form class="layui-form" action="" method="get">
                        <div>
                            <div class="layui-input-inline">
                                <input type="text" name="tel" value="{$tel}" autocomplete="off" class="layui-input" placeholder="手机号">
                            </div>    
                            <div class="layui-inline">
                                <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                            </div>
                        </div>
                    </form>
                </blockquote>
            {/if}
            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>职位</th>
                            <th>手机号</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $list as $row}
                            <tr>
                                <td>{$row.usernick}</td>
                                <td>{$row.roleName}</td>
                                <td>{$row.tel}</td>
                                <td>
                                    <a href="{site_url('users/addadmin/')}{$row.userId}" data-confirm="你确定给予该用户管理员权限吗？" class="layui-btn layui-btn-mini"><i class="fa fa-check" aria-hidden="true"></i> 管理员权限</a>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        {/if}

        {if $pages>1}
            <div class="admin-table-page">
                <div id="page" class="page">
                </div>
            </div>
        {/if}
    </div>
{/block}