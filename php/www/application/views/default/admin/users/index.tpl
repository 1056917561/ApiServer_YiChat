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


            <form class="layui-form" action="{site_url('users/index')}" method="get">
                <div>
                    <div class="layui-input-inline">
                        <input type="text" name="userId" value="{$userId}" autocomplete="off" class="layui-input" placeholder="用户ID">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="fxid" value="{$fxid}" autocomplete="off" class="layui-input" placeholder="慈济号">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="usernick" value="{$usernick}" autocomplete="off" class="layui-input" placeholder="昵称">
                    </div>

                    <div class="layui-input-inline">
                        <input type="text" name="tel" value="{$tel}" autocomplete="off" class="layui-input" placeholder="手机号">
                    </div>

                    <div class="layui-inline">

                        <input type="text" name="date" id="date" value="{$date}" placeholder="注册时间" autocomplete="off" class="layui-input" {literal} onclick="layui.laydate({elem: this})"{/literal}>

                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1"><i class="layui-icon">&#xe615;</i> 搜索</button>
                    </div>
                </div>
            </form>

        </blockquote>
        {if !empty( $list)}

            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th>用户ID</th>
                            <th>慈济号</th>
                            <th>视频权限</th>
                            <th>活动权限</th>
                            <th>昵称</th>
                            <th>部门</th>
                            <th>手机号</th>
                            <th>职位</th>
                            <th>绑定</th>
                            <th>性别</th>
                            <th>注册时间</th>
                            <th>小组</th>
                            <th>省份</th>
                            <th>城市</th>
                            <th>上级</th>
                            <th>签名</th>
                            <th>黑名单/好友</th>
                            <th width="200px">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $list as $row}
                            <tr>
                                <td>{$row.userId}</td>
                                <td>{$row.fxid}</td>
                                <td>{if $row.meetingAuth}有{else}无{/if}</td>
                                <td>{if $row.activityAuth}有{else}无{/if}</td>
                                <td>{$row.usernick}</td>
                                <td>{$row.areaName}</td>
                                <td>
                                    {$row.tel}
                                </td>
                                <td>{$row.roleName}</td>
                                <td>
                                    {$row.type}
                                </td>
                                <td>
                                    {$row.sex}

                                </td>
                                <td>{$row.time}</td>
                                <td>{$row.groupName}</td>
                                <td>{$row.province}</td>
                                <td>{$row.city}</td>
                                <td>{$row.fatherName}</td>
                                <td>{$row.sign}</td>
                                <td style="line-height:27px">
                                    <a href="#" data-userid="blacks{$row.userId}" class="layui-btn layui-btn-primary layui-btn-mini friends">查看黑名单 {if is_array($row.blacks)}{count($row.blacks)}{else}0{/if}</a>
                                    <a href="#" data-userid="friends{$row.userId}" class="layui-btn layui-btn-primary layui-btn-mini friends">查看好友 {if is_array($row.friends)}{count($row.friends)}{else}0{/if}</a>
                                </td>
                                <td align="center" style="line-height:27px">
                                    <a href="{site_url('users/edit/')}{$row.userId}" class="layui-btn layui-btn-mini"><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                    <a href="{site_url('users/deleteusers/')}{$row.userId}" data-confirm="你确定要删除吗？" class="layui-btn layui-btn-danger layui-btn-mini"><i class="fa fa-remove" aria-hidden="true"></i> 删除</a>
                                    <br>
                                    {if !$row.meetingAuth}
                                        <a href="{site_url('users/meeting/')}{$row.userId}" data-confirm="你确定要给TA视频权限吗？" class="layui-btn  layui-btn-mini"><i class="fa fa-check" aria-hidden="true"></i> 视频权限</a>
                                    {/if}
                                    {if !$row.activityAuth}
                                        <a href="{site_url('users/activity/')}{$row.userId}" data-confirm="你确定要给TA活动权限吗？" class="layui-btn  layui-btn-mini"><i class="fa fa-check" aria-hidden="true"></i> 活动权限</a>
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="18">
                                    {if is_array($row.friends)}
                                        <table class="layui-table rowtable" id="friends{$row.userId}" lay-even lay-skin="nob" style="display:none">
                                            <thead>
                                                <tr>
                                                    <th>环信ID/UID</th>
                                                    <th>凡信号</th>
                                                    <th>昵称</th>
                                                    <th>手机号</th>
                                                    <th>绑定</th>
                                                    <th>性别</th>
                                                    <th>注册时间</th>
                                                    <th>城市</th>
                                                    <th>签名</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {foreach $row.friends as $vo}
                                                    <tr>
                                                        <td>{$vo.userId}</td>
                                                        <td>{$vo.fxid}</td>
                                                        <td>{$vo.nick}</td>
                                                        <td>
                                                            {$vo.tel}
                                                        </td>
                                                        <td>
                                                            {$vo.type}
                                                        </td>
                                                        <td>
                                                            {$vo.sex}

                                                        </td>
                                                        <td>{$vo.time}</td>
                                                        <td>{$vo.province}{$vo.city}</td>
                                                        <td>{$vo.sign}</td>
                                                    </tr>
                                                {/foreach}
                                            </tbody>
                                        </table>  
                                    {/if}
                                    {if is_array($row.blacks)}
                                        <table class="layui-table rowtable" id="blacks{$row.userId}" lay-even lay-skin="nob" style="display:none">
                                            <thead>
                                                <tr>
                                                    <th>环信ID/UID</th>
                                                    <th>凡信号</th>
                                                    <th>昵称</th>
                                                    <th>手机号</th>
                                                    <th>绑定</th>
                                                    <th>性别</th>
                                                    <th>注册时间</th>
                                                    <th>城市</th>
                                                    <th>签名</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {foreach $row.blacks as $vo}
                                                    <tr>
                                                        <td>{$vo.userId}</td>
                                                        <td>{$vo.fxid}</td>
                                                        <td>{$vo.nick}</td>
                                                        <td>
                                                            {$vo.tel}
                                                        </td>
                                                        <td>
                                                            {$vo.type}
                                                        </td>
                                                        <td>
                                                            {$vo.sex}

                                                        </td>
                                                        <td>{$vo.time}</td>
                                                        <td>{$vo.province}{$vo.city}</td>
                                                        <td>{$vo.sign}</td>
                                                    </tr>
                                                {/foreach}
                                            </tbody>
                                        </table>  
                                    {/if}
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