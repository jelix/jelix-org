
<div class="content-box" id="article">
    <h2>{@news~news.page_title@}</h2>

<div class="news">

{if $news}
    <h3>{$news->title}</h3>
    <div class="news-infos">{$news->date_create|jdatetime}, {$news->author|escxml}.</div>
    <div class="news-content">{$news->content|wiki:"news_to_xhtml"}</div>
{else}
    <p>{@news~news.unknown@}</p>
{/if}
</div>

</div>