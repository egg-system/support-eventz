<?php 
  get_template_part('parts/list-header');
?>

<div id="premium">
  <h2><img src="http://support.eventz.jp/wp-content/uploads/2017/05/icon_hoshi02-1.svg">
    プレミアムイベント
  </img></h2>
</div>

<br>

<div id="list">
<?php
if (have_posts()) : // WordPress ループ
  $count = 0;
  foreach ( $data as $post ) : setup_postdata( $post );
    include('parts/event_list.php');
  endforeach;  // 繰り返し処理終了 ?>
  <div class="clear"></div>
<?php 
  else : // ここから記事が見つからなかった場合の処理  
    get_template_part('parts/event_not_found');
  endif;
?>
</div>

<br>
<br>
<div id="event">
<h2><img src="http://support.eventz.jp/wp-content/uploads/2017/05/icon_hoshi02-1.svg">カフェ会</img></h2>
</div>
<br>

<div id="list">

<!-- 通常のイベント一覧 -->
<?php
if (have_posts()) : // WordPress ループ
  $count = 0;
  foreach ( $data as $post ) : setup_postdata( $post );
    include('parts/event_list.php');
  endforeach;  // 繰り返し処理終了 ?>
  <div class="clear"></div>
<?php 
  else : // ここから記事が見つからなかった場合の処理  
    get_template_part('parts/event_not_found');
  endif;
?>
</div><!-- /#list -->

<?php 
// タグのイベント取得条件をリセット
wp_reset_postdata();
?>

<?php
////////////////////////////
//ボトムの広告
////////////////////////////
if (!is_home() || is_ads_top_page_visible()) ://メインページ以外は広告を出す
  get_template_part('ad-article-footer' );
endif; ?>

<?php
////////////////////////////
//インデックスリストボトムウィジェット
////////////////////////////
if ( is_active_sidebar( 'widget-index-bottom' ) ):
  echo '<div id="widget-index-bottom" class="widgets">';
  dynamic_sidebar( 'widget-index-bottom' );
  echo '</div>';
endif; ?>

<div class="terms0408" style="text-align:center; padding: 30px 0 30px 0;">
<a style="font-size: 20px !important; background: #517fa4; padding: 0.1em 3.0em;" href="https://support.eventz.jp/events/tag/cafekai?order=desc&meta_key=_eventorganiser_schedule_start_start&orderby=meta_value">
もっと見る
</a>
</div>

<div id="Externalseminar">
<h2><img src="http://support.eventz.jp/wp-content/uploads/2017/05/icon_hoshi02-1.svg">外部セミナー</img></h2>
</div>
<br>


<div id="list">
<?php
  if (have_posts()) : // WordPress ループ
    $count = 0;
    foreach ( $data as $post ) : setup_postdata( $post );
      include('parts/event_list.php');
    endforeach;  // 繰り返し処理終了 
?>
  <div class="clear"></div>
<?php 
  else : // ここから記事が見つからなかった場合の処理  
    get_template_part('parts/event_not_found');
  endif;
?>
</div><!-- /#list -->
