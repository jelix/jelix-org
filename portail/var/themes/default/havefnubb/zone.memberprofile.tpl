{if $user === false}
<div class="post-author">
    <ul class="member-ident">
    {hook 'hfbMemberProfile',array('user'=>0)}
        <li class="user-name user-image">{@havefnubb~member.guest@}</li>
        <li class="user-rank user-image"><span>{@havefnubb~rank.rank_name@} : </span></li>
    </ul>
    <ul class="member-info">
        <li class="user-posts user-image">{@havefnubb~member.common.nb.messages@}: 0</li>
    </ul>
</div>
{else}
{hook 'hfbBeforeMemberProfile',array('user'=>$user->id)}
<div class="post-author">
    <ul class="member-ident">
        {hook 'hfbMemberProfile',array('user'=>$user->id)}
        <li class="user-name user-image">{zone 'activeusers~onlinestatus',array('login'=>$user->login)}<a href="{jurl 'jcommunity~account:show',array('user'=>$user->login)}" title="{jlocale 'havefnubb~member.common.view.the.profile.of',array($user->nickname)}">{$user->nickname|eschtml}</a></li>
        {if $user->member_gravatar == 1}
            <li>{gravatar $user->email,array('username'=>$user->login)}</li>
        {else}
            {if file_exists('hfnu/images/avatars/'. $user->id.'.png') }
            <li>{image 'hfnu/images/avatars/'. $user->id.'.png', array('alt'=>$user->nickname)}</li>
            {elseif file_exists('hfnu/images/avatars/'. $user->id.'.jpg')}
            <li>{image 'hfnu/images/avatars/'. $user->id.'.jpg', array('alt'=>$user->nickname)}</li>
            {elseif file_exists('hfnu/images/avatars/'. $user->id.'.jpeg')}
            <li>{image 'hfnu/images/avatars/'. $user->id.'.jpeg', array('alt'=>$user->nickname)}</li>
            {elseif file_exists('hfnu/images/avatars/'. $user->id.'.gif')}
            <li>{image 'hfnu/images/avatars/'. $user->id.'.gif', array('alt'=>$user->nickname)}</li>
            {/if}
        {/if}
        <li class="user-rank user-image"><span>{@havefnubb~rank.rank_name@} : {zone 'havefnubb~what_is_my_rank',array('nbMsg'=>$user->nb_msg)}</span></li>
    </ul>
    <ul class="member-info">
        <li class="user-posts user-image">{@havefnubb~member.common.nb.messages@}: {$user->nb_msg}</li>
    </ul>
</div>
{hook 'hfbAfterMemberProfile',array('user'=>$user->id)}
{/if}
