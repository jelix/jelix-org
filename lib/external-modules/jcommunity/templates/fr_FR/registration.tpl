<div class="jcommunity-box jcommunity-account">
<h1>Création d'un compte</h1>

<p>Pour pouvoir profiter au mieux des services du site, inscrivez-vous
en remplissant le formulaire suivant.</p>

{form $form,'jcommunity~registration:save', array()}
<fieldset>
    <legend>Informations</legend>
    <p>{ctrl_label 'reg_login'} : {ctrl_control 'reg_login'}</p>
    <p>{ctrl_label 'reg_email'} : {ctrl_control 'reg_email'}</p>
    <p>{ctrl_label 'reg_captcha'} : {ctrl_control 'reg_captcha'}</p>
</fieldset>
{if !$disable_mail_confirmation}
<p>Un e-mail vous sera envoyé pour que vous puissiez confirmer votre inscription
et ensuite pouvoir vous identifier sur le site.</p>
{/if}
<p>{formsubmit}</p>
{/form}
</div>