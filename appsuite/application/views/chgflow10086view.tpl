{literal}
<style type="text/css">
.chgflow10086view {padding: 5px;border-bottom: 1px solid #a6c9e2;}
.chgflow10086viewgroupname {padding-right: 150px; background-color: #ffffff; font-size: 14px;font-weight: bold; border-bottom: 1px dotted #e6e8eb;}
.chgflow10086viewiplist {color:#915608;}
.chgflow10086viewiplist span {padding-right: 5px; border-left: 2px solid #f98821;}/*a6c9e2*/
</style>
<script type="text/javascript">
</script>
{/literal}
{foreach from=$chgflowData item=item}
<div class="chgflow10086view" id="{$item.id}">
	<span class="chgflow10086viewgroupname">{$item.title}</span>
	{foreach from=$item.list item=itemlist}
	<div>服务器：
		<span class="chgflow10086viewiplist">
		{foreach from=$itemlist.iplist item=itemlip}
		<span>{$itemlip}</span> 
		{/foreach}
		</span>
	</div>
	<div style="margin-bottom: 8px;">{$itemlist.value}</div>
	{/foreach}
</div>
{/foreach}
