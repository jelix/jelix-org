<?php

require_once(dirname(__FILE__).'/mysql.lib.php');

function tpl_load_book_page(){
    global $ID, $BOOK_PAGE;
    $BOOK_PAGE = loadBookPage($ID);
}


function loadBookPage($id){

    $db = new mysqlDb();

    $sql = 'SELECT bp.book_page_id as bp_id, bp.title as bp_title, bp.type as bp_type, bp.path as bp_path,
            pr.book_page_id as prev_id, pr.title as prev_title, pr.type as prev_type,
            ne.book_page_id as next_id, ne.title as next_title, ne.type as next_type,
            pa.book_page_id as parent_id, pa.title as parent_title, pa.type as parent_type,
            b.title_short as book_title, b.subtitle as book_subtitle,
            b.edition as book_edition, b.pagelegalnoticehtml as book_legal_notice,
            bp.book_id
            FROM book_pages bp 
            LEFT JOIN book_pages pr ON (bp.prev= pr.book_page_id)
            LEFT JOIN book_pages ne ON (bp.next= ne.book_page_id)
            LEFT JOIN book_pages pa ON (bp.parent= pa.book_page_id),
            books b
            WHERE bp.book_id = b.book_id AND  bp.book_page_id='.$db->quote($id);

    $page =  $db->fetchOne($sql);
    if($page) {
        $page->bp_path = unserialize($page->bp_path);
        $page->children = array();
        $cur = $db->query('SELECT book_page_id as id, title, type FROM book_pages WHERE parent = '.$db->quote($id).' ORDER BY contents_order asc');
        while ($rec = mysql_fetch_object($cur)){
            $page->children[] = $rec;
        }
        mysql_free_result($cur);
    }
    return $page;
}

function loadTopContents($book_id){

    $db = new mysqlDb();
    $contents = array();
    $cur = $db->query('SELECT book_page_id as id, title, type FROM book_pages WHERE parent = '.$db->quote($book_id).' ORDER BY contents_order asc');
    while ($rec = mysql_fetch_object($cur)){
        $contents[] = $rec;
    }
    mysql_free_result($cur);
    return $contents;
}


function tpl_book_page_header() {
    global $BOOK_PAGE, $ACT, $lang;
    if(!$BOOK_PAGE || $ACT != 'show') return;

?>
<div id="book-page-header">
    <div class="book-title"><?php
        tpl_link(wl($BOOK_PAGE->book_id),htmlspecialchars($BOOK_PAGE->book_title)); ?> <img src="/design/2011/icons/ui-menu-blue.png" alt="" />
        <div class="book-hierarchy">
        <?php tpl_book_contents() ?>
        </div>
    </div>
    <div class="book-edition"><?php echo htmlspecialchars($BOOK_PAGE->book_subtitle) ?></div>
    <h1 class="book-current"><?php echo htmlspecialchars($lang['book_current_'.$BOOK_PAGE->bp_type].': '.$BOOK_PAGE->bp_title) ?></h1>

    <?php book_nav() ?>
</div>
<?php

}

function tpl_book_page_footer() {
    global $BOOK_PAGE, $ACT;
    if(!$BOOK_PAGE || $ACT != 'show') return;


        if (count($BOOK_PAGE->children) && $BOOK_PAGE->bp_type != 'f') { // && $BOOK_PAGE->bp_type != 's') {
            echo '<hr /><ul>';
            foreach($BOOK_PAGE->children as $child) {
                echo '<li>';
                tpl_link(wl($child->id),htmlspecialchars($child->title));
                echo '</li>';
            }
            echo '</ul>';
        }

?>
<div id="book-page-footer">
    <?php book_nav() ?>
    <div class="book-legal-notice"><?php echo $BOOK_PAGE->book_legal_notice; ?></div>
</div>
<?php

}

function tpl_book_contents() {
    global $BOOK_PAGE;
    if(!$BOOK_PAGE) return;

    /*echo '<h3>';
    tpl_link(wl($BOOK_PAGE->book_id),htmlspecialchars($BOOK_PAGE->book_title));
    echo '</h3>';*/

    if($BOOK_PAGE->bp_path && count($BOOK_PAGE->bp_path)) {
        echo '<ul>';
        foreach($BOOK_PAGE->bp_path as $item) {
            if($item == end($BOOK_PAGE->bp_path) && count($BOOK_PAGE->children) ==0)
                break;
            echo '<li>^ ';
            tpl_link(wl($item[0]),htmlspecialchars($item[1]));
            echo '</li>';
        }
        echo '</ul>';
    }

    if (count($BOOK_PAGE->children)) {
        echo '<ul>';
        echo '<li class="actif">';
        tpl_link(wl($BOOK_PAGE->bp_id),htmlspecialchars($BOOK_PAGE->bp_title));

        echo '<ul>';
        foreach($BOOK_PAGE->children as $child) {
            echo '<li>';
            tpl_link(wl($child->id),htmlspecialchars($child->title));
            echo '</li>';
        }
        echo '</ul></li></ul>';
    } else {
        if(count($BOOK_PAGE->bp_path)) {
            $last = end($BOOK_PAGE->bp_path);
            $last = loadBookPage($last[0]);

            echo '<ul>';
            echo '<li>^ ';
            tpl_link(wl($last->bp_id),htmlspecialchars($last->bp_title));

            echo '<ul>';
            foreach($last->children as $child) {
                if($child->id == $BOOK_PAGE->bp_id)
                    echo '<li class="actif">';
                else
                    echo '<li>';

                tpl_link(wl($child->id),htmlspecialchars($child->title));
                echo '</li>';
            }
            echo '</ul></li></ul>';

        }else {
            // rubrique top: on affiche toutes les rubriques top
            $contents = loadTopContents($BOOK_PAGE->book_id);
            echo '<ul>';
            foreach($contents as $child) {
                if($child->id == $BOOK_PAGE->bp_id)
                    echo '<li class="actif">';
                else
                    echo '<li>';

                tpl_link(wl($child->id),htmlspecialchars($child->title));
                echo '</li>';
            }
            echo '</ul>';
        }
    }
}

function tpl_book_page_title() {
    global $BOOK_PAGE;
    if(!$BOOK_PAGE) tpl_pagetitle();
    else echo htmlspecialchars($BOOK_PAGE->bp_title);
}


function book_nav() {
    global $BOOK_PAGE, $ACT, $lang;
    if(!$BOOK_PAGE || $ACT != 'show') return;
?>
    <table class="book-nav">
    <tr>
        <td class="book-nav-prev"><?php if($BOOK_PAGE->prev_id) { ?>&laquo; <?php tpl_link(wl($BOOK_PAGE->prev_id),htmlspecialchars($BOOK_PAGE->prev_title), ' title="'.$lang['book_prev_'.$BOOK_PAGE->next_type].'"'); } ?></td>
        <td class="book-nav-up"><?php if($BOOK_PAGE->parent_id) { ?>^ <?php tpl_link(wl($BOOK_PAGE->parent_id),htmlspecialchars($BOOK_PAGE->parent_title), ' title="'.$lang['book_up_'.$BOOK_PAGE->next_type].'"'); } ?></td>
        <td class="book-nav-next"><?php if($BOOK_PAGE->next_id) {  tpl_link(wl($BOOK_PAGE->next_id),htmlspecialchars($BOOK_PAGE->next_title), ' title="'.$lang['book_next_'.$BOOK_PAGE->next_type].'"')?> &raquo;<?php } ?></td>
    </tr></table>
    <div class="lang"><?php tpl_book_lang('Switch to language:');?></div>
<?php
}



function tpl_book_lang($label='') {
    global $INFO;
    if(isset($INFO['meta']['relative_page_lang'])) {
        echo htmlspecialchars($label);
        foreach($INFO['meta']['relative_page_lang'] as $lang=>$page) {
            /*$l = strtoupper($lang);
            if($l == 'FR') $lang = 'version française';
            else if($l == 'EN') $lang = 'english version';*/
            tpl_link(wl($page),htmlspecialchars($lang), '');
        }
    }
}


?>
