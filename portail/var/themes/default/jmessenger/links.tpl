{ifuserconnected}
{meta_html jquery}

<script type="text/javascript">
{literal}
var read = {/literal}{urljsstring 'jmessenger~jmessenger:view'}{literal};
$(document).ready(function(){
	$('div.new').click(function(){
		var id = $(this).attr("id");
		$(this).removeClass("new");
		$.post( read+id );
	});
});
{/literal}
</script>
<div class="box">
	<h2>{@havefnubb~member.edit.account.header@}</h2>
	<div class="block">
		<div id="container">
			<ul class="nav ui-tabs-nav">
            <li><a href="{jurl 'jcommunity~account:edit',array('user'=>$login)}#user-profile-general">{@havefnubb~member.general@}</a></li>
            <li><a href="{jurl 'jcommunity~account:edit',array('user'=>$login)}#user-profile-pref">{@havefnubb~member.pref@}</a></li>
            <li><a href="{jurl 'jcommunity~account:edit',array('user'=>$login)}#user-profile-messenger">{@hfnuim~im.instant.messenger@}</a></li>
            <li><a href="{jurl 'jcommunity~account:edit',array('user'=>$login)}#user-profile-hardware">{@hfnuhardware~hw.hardware@}</a></li>
			</ul>
			<div class="clear"></div>
			<fieldset>
				<legend><span class="user-messenger user-image">{@havefnubb~member.private.messaging@}</span></legend>
					<ul class="section menu">
						<li>{zone 'jmessenger~nbNewMessage'}</li>
						<li>
							<ul>
								<li><a href="{jurl 'jmessenger~jmessenger:inbox'}"><span class="user-email-inbox user-image">{@jmessenger~message.msg.inbox@}</span></a></li>
								<li><a href="{jurl 'jmessenger~jmessenger:outbox'}"><span class="user-email-outbox user-image">{@jmessenger~message.msg.outbox@}</span></a></li>
								<li><a href="{jurl 'jmessenger~jmessenger:precreate'}"><span class="user-email-add user-image">{@jmessenger~message.title.new@}</span></a></li>
							</ul>
						</li>
					</ul>
			</fieldset>
		</div>
	</div>
</div>
{/ifuserconnected}
