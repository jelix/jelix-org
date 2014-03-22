<div class="content-box" id="article">
    <h2>{@news~news.page_title@}</h2>

{if $listnews}
{foreach $listnews as $news}
<div class="news" id="news{$news->news_id}">
    <h3>{$news->title}</h3>
    <div class="news-infos"><a href="{jurl 'news~default:article', array('newsid'=>$news->url, 'lang'=>$lang)}"
title="{@news~news.permanent.link@}"># {$news->date_create|jdatetime}</a>
         {$news->author|escxml}.</div>

{if $news->abstract ==''}
    <div class="news-content">{$news->content|wiki:"news_to_xhtml"}</div>
{else}
    <div class="news-content">{$news->abstract|wiki:"news_to_xhtml"}</div>
    <p><a href="{jurl 'news~default:article', array('newsid'=>$news->url, 'lang'=>$lang)}">{@news~news.full.article.label@}</a></p>
{/if}


</div>
{/foreach}
{else}
<p>No news.</p>
{/if}

</div>
