  <div id="login-box">
{ifuserconnected}
    {$login} -
    {hook 'hfbJcommunityStatusConnected',array('login'=>$login)}
    <a href="{jurl 'jcommunity~account:prepareedit', array('user'=>$login)}">{@havefnubb~member.status.your.account@}</a> -
    <a href="{jurl 'jcommunity~login:out'}">{@havefnubb~main.logout@}</a>
{else}
    <a href="{jurl 'jcommunity~login:index'}">{@havefnubb~member.status.connect@}</a> -
    <a href="{jurl 'jcommunity~registration:index'}">{@havefnubb~member.status.register@}</a>
{/ifuserconnected}
</div>
