{extends file="mainlayout.tpl"}
{block name=body}
    <div class="admin-main">
        <blockquote id='searchform' class="layui-elem-quote">


            <form class="layui-form" action="" method="get">
                <div>
                    <div class="layui-input-inline">用户：{$userdata.usernick}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;职位：{$userdata.roleName}</div>
                    <div class="layui-inline" style="margin-left:30px;">
                        <a onclick="javascript:history.back();"  href="javascript:;" class="layui-btn layui-btn-small"><i class="fa fa-history" aria-hidden="true"></i>&nbsp;返回</a>
                    </div>
                </div>
            </form>

        </blockquote>
        {if !empty( $list)}

            <div class="layui-field-box">
                <table class="site-table table-hover">
                    <thead>
                        <tr>
                            <th></th>						    
                            <th>姓名</th>
                            <th>手机号</th>
                            <th>职位</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $fatherdata}
                            <tr>
                                <td style="color:red">上级</td>
                                <td>{$fatherdata.usernick}</td>
                                <td>{$fatherdata.tel}</td>
                                <td>{$fatherdata.roleName}</td>                               
                            </tr>
                        {/if}
                        {foreach $list as $row}
                            <tr>
                                <td style="color:red">下级</td>
                                <td>{$row.usernick}</td>
                                <td>{$row.tel}</td>
                                <td>{$row.roleName}</td>                               
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