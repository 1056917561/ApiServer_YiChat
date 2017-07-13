{extends file="mainlayout.tpl"}
{block name=body}
    <div class="admin-main">
        <form class="layui-form" action="" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">慈济号</label>
                <div class="layui-input-block">
                    <input type="text" name="fxid" required  lay-verify="required"  value='{$list.fxid}' placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-block">
                    <input type="text" name="usernick" required value='{$list.usernick}' lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="tel" required value='{$list.tel}' lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">部门</label>
                <div class="layui-input-block">
                    <select name="area_id" lay-verify="required" class="select" style="display:block">
                        <option value="">请选择部门</option>
                        {foreach $area as $g}
                            <option value="{$g.id}" {if $g.id==$list.area_id} selected="selected"{/if}>{$g.name}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">省份</label>
                <div class="layui-input-block">
                    <input type="text" name="province" required value='{$list.province}'  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">城市</label>
                <div class="layui-input-block">
                    <input type="text" name="city" required value='{$list.city}' lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">职位</label>
                <div class="layui-input-block">
                    <select name="role" lay-verify="required"  class="select" style="display:block">
                        <option value="">请选择身份</option>
                        {foreach $roles as $g}
                            <option value="{$g.id}" {if $g.id==$list.role} selected="selected"{/if}>{$g.name}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">小组</label>
                <div class="layui-input-block">
                    <select name="group_id" lay-verify="required"  class="select" style="display:block">
                        <option value="">请选择分组</option>
                        {foreach $groups as $g}
                            <option value="{$g.id}" {if $g.id==$list.group_id} selected="selected"{/if}>{$g.name}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">签名</label>
                <div class="layui-input-block">
                    <textarea name="sign" placeholder="签名" class="layui-textarea">{$list.sign}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    <a href="{site_url('users/index')}" class="layui-btn layui-btn-primary">取消</a>
                </div>
            </div>
        </form>
                
    </div>
    <style>
        .select{
            width: 100%;
            line-height: 38px;
            height: 38px;
            border: 1px solid #e6e6e6;
        }
    </style>
{/block}