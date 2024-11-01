<?php
 
/**
*
* Plugin Name: Social Media SEO
* Description: All the tools to help improve positioning and monitoring of your wordpress blog
* Version: 1.2
* Author: webhostri
*
**/

add_action( 'admin_menu', 'wp_btnmenu' );
//add_action('wp_footer','wp_seo_analitycs');
//add_action('wp_head','wp_seo_meta');
add_action('the_content', 'share_this');


function wp_btnmenu() {
    add_options_page( 'Opciones WP Skin @ Home', 'Social Media SEO', 'manage_options', 'wp_btnmenu', 'wp_panel_home_options' );
}



function wp_panel_home_options() {

	global $wpdb;
	
	?><br />
	Estadisticas de Facebook:
    <br /><br />
	<?php
	$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'page' ORDER BY $wpdb->posts.post_title ASC";
	
	$pageposts = $wpdb->get_results($querystr, OBJECT);
	
	if ($pageposts):
		?>
        <br /><br />
		<table border="0" align="center">
			<tr>
				<td>Title</td>
				<td>Link</td>
				<td>Total count</td>
				<td>Like count</td>
				<td>Comment count</td>
				<td>Share count</td>
				<td>Click count</td>
			</tr>
			<?php
			foreach ($pageposts as $post):
				?>
				<tr>
					<td><?=$post->post_title;?></td>
					<td><a href="<?=$post->guid;?>"><?=$post->guid;?></a></td>
					<?php 
					$fb_likes = reset( get_fb_likes($post->guid) ); 
					?>
					<td><?=$fb_likes->total_count;?></td>
					<td><?=$fb_likes->like_count;?></td>
					<td><?=$fb_likes->comment_count;?></td>
					<td><?=$fb_likes->share_count;?></td>
					<td><?=$fb_likes->click_count;?></td>
				</tr>
				<?php
			endforeach;
			?>
		</table>
		<?php
	else :
		echo 'Not Found';
	endif;

?>
	<br /><br /><br /><br /><br /><br />
    <center>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Plugin SocialMediaSeo -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-9329069495351013"
         data-ad-slot="1719102769"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </center>
<?php

}

 function get_fb_likes($url)
{
  $query = "select total_count,like_count,comment_count,share_count,click_count from link_stat where url='{$url}'";
   $call = "https://api.facebook.com/method/fql.query?query=" . rawurlencode($query) . "&format=json";

  $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $call);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $output = curl_exec($ch);
   curl_close($ch);
   return json_decode($output);
}

/*
function wp_seo_analitycs(){
	
	if(is_home()){
		$opt_name = 'seof_google_analitycs';
	
		$opt_val = get_option( $opt_name );
		?>
		<?php echo $opt_val; ?>
		<?php
	}
	
}
*/
function share_this($post_content){
	
	$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	
	/*******************/
	/*****Facebook******/
	/*******************/
	
	function dameURL(){
		$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		return $url;
	}
	?>

	<script type="text/javascript">
    (function() {
    var element = document.createElement('script');
    element.type = "text/javascript";
    element.async = true;
    element.id = "facebook-jssdk"
    element.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(element, s);
    })();
    </script>
	<?php
	$facebook = '<div class="fb-like" data-href="'.dameURL().'" data-width="292" data-layout="button_count" data-send="true"></div>';
	
	
	
	/****************/
	/****twitter*****/
	/****************/
	?>
	<script src="http://platform.twitter.com/widgets.js" type="text/javascript"> </script>
    <?php
	$twitter = '<a href="http://twitter.com/share" class="twitter-share-button">Tweet</a>';
	
	return $post_content.$facebook.$space.$twitter;	
}


/*
function wp_seo_meta(){
	
	if(is_home()){
		$opt_name_2 = 'seof_meta_description';
		$opt_name_3 = 'seof_meta_keywords';
	
		$opt_val_2 = get_option( $opt_name_2 );
		$opt_val_3 = get_option( $opt_name_3 );
	
		if($opt_val_2 != ''){
			?><meta name="description" content="<?=$opt_val_2; ?>"><?php
		}
		if($opt_val_3 != ''){
			?><meta name="keywords" content="<?=$opt_val_3; ?>"><?php
		}
	}
	
}
*/