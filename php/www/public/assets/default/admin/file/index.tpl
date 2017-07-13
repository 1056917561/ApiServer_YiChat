{extends file="mainlayout.tpl"}
{block name=javascript}
    {js('ckfinder/ckfinder.js')}
    {js('js/ckfinder.js')}
{/block}
{block name=body}
    <div class="admin-main">
        <div class="ckfinder" id="ckfinder-widget"></div>
    </div>
{/block}