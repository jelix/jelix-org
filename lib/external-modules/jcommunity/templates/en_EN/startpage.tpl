<div class="jcommunity-box">
{ifuserconnected}
    <p>{$login}, you are connected.</p>

    <p>You can :</p>
    <ul>
        <li><a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">View your account</a></li>
        <li><a href="{jurl 'jcommunity~login:out'}">Logout</a></a></li>
    </ul>
{else}
    <p>You are not authenticated.</p>

    <p>You can :</p>
    <ul>
        <li><a href="{jurl 'jcommunity~login:index'}">Login</a></li>
        <li><a href="{jurl 'jcommunity~registration:index'}">Create an account</a></li>
        <li><a href="{jurl 'jcommunity~password:index'}">Get a new password</a> if you don't remember it.</li>
    </ul>
{/ifuserconnected}
</div>