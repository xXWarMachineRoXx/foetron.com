<?php get_header(); ?>

			
<?php 
$comments = comments_open() && get_option("default_comment_status ") == "open"; 
$blog_single_page_style= get_option(BRANKIC_VAR_PREFIX."blog_single_page_style");

if (have_posts()) : while(have_posts()) : the_post(); 
$subtitle = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."subtitle", true);
$hide_title = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."hide_title", true); 
$centered_title = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."centered_title", true);
$select_blog_category = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."select_blog_category", true); 
$sidebar = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."select_sidebar", true);
$hide_featured_image = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."hide_featured_image", true); 
$hide_no_of_comments = get_option(BRANKIC_VAR_PREFIX."hide_no_of_comments");
if ($hide_no_of_comments == "yes" && get_comments_number() == 0) $hide_no_of_comments = "yes"; else $hide_no_of_comments = "no";
$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' ); 
if ($blog_single_page_style == 3) $featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog-square' ); 
$featured_image = $featured_image_array[0];

if (get_option(BRANKIC_VAR_PREFIX."blog_single_page_style_fullwidth") != "no") $full_width = 1; else $full_width = 0;


?>
<div class="divider" style="height:40px"></div>

 
<?php
if ($blog_single_page_style == 1) $inner_content_class = "blog1";
if ($blog_single_page_style == 2) $inner_content_class = "blog1"; 
if ($blog_single_page_style == 3) $inner_content_class = "blog3"; 
if ($blog_single_page_style == 4) $inner_content_class = "blog1"; 
if ($blog_single_page_style == 5) $inner_content_class = "blog5"; 
if ($blog_single_page_style == 6) $inner_content_class = "blog6"; 
?>

<?php
if ($full_width)
{
?> 
    <div class="one <?php echo $inner_content_class; ?>"> 
<?php
}
else
{
?>
    <div id="inner-content" class="<?php echo $inner_content_class; ?>">  
<?php
}
?>

            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<?php
if ($blog_single_page_style == "1")
{
?>
            
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <?php if ($hide_no_of_comments != "yes") { ?>
                    <div class="comments"><?php comments_popup_link( __('<span>0</span> Comments', BRANKIC_THEME_SHORT), __('<span>1</span> Comment', BRANKIC_THEME_SHORT), __('<span>%</span> Comments', BRANKIC_THEME_SHORT)); ?></div>                            
                    <?php } ?>
                </div><!--END POST-INFO-->        
                
                <div class="post-content">    
            
                    <div class="post-media">
                    <?php
                    $video_link = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."video_link", true);

                    if ($video_link != "")
                    {
                        if (bra_is_mov($video_link) || bra_is_swf($video_link))
                        {
                        ?>
                        <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }
                        if (bra_is_vimeo($video_link) || bra_is_youtube($video_link))
                        {
                            if (bra_is_vimeo($video_link))
                            {
                                $video_link = "http://player.vimeo.com/video/" . bra_get_vimeo_id($video_link);
                            }
                            if (bra_is_youtube($video_link))
                            {
                                $video_link = "http://www.youtube.com/embed/" . bra_get_youtube_id($video_link);
                            }
                            ?>
                            <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <?php
                        }
                    }
                    else
                    {
                        if ($full_width) $img_width = 850; else $img_width = 600; 
                    ?> 
                        <?php if (extra_images_exists()) { include ("slider.inc.php"); } else { ?>
                            <?php if ($hide_featured_image != "yes") { ?>       
                            <img src="<?php echo $featured_image; ?>" alt="" width="<?php echo $img_width; ?>" />
                            <?php } ?> 
                        <?php } ?>
                    <?php } ?> 
                    </div><!--END POST-MEDIA-->
                
                    <div class="post-title">                
                        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div><!--END POST-TITLE-->
                
                    <div class="post-meta">                
                        <ul>
                            <li><span><?php _e('Posted by', BRANKIC_THEME_SHORT); ?></span> <?php the_author_link(); ?></li>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_cats_blog_single_page") == "yes") { ?><li> <span><?php _e('in', BRANKIC_THEME_SHORT); ?></span> <?php the_category(', '); ?></li><?php } ?>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_tags_blog_single_page") == "yes") { ?><li> <span><?php _e(' Tagged with', BRANKIC_THEME_SHORT); ?></span> <?php the_tags('', ', ', ''); ?></li><?php } ?>
                        </ul>
                    </div><!--END POST-META-->  
<?php
}
?>
<?php
if ($blog_single_page_style == "2")
{
?>
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <?php if ($hide_no_of_comments != "yes") { ?>
                    <div class="comments"><?php comments_popup_link( __('<span>0</span> Comments', BRANKIC_THEME_SHORT), __('<span>1</span> Comment', BRANKIC_THEME_SHORT), __('<span>%</span> Comments', BRANKIC_THEME_SHORT)); ?></div>                            
                    <?php } ?>                            
                </div><!--END POST-INFO-->        
                
                <div class="post-content">  
                
                    <div class="post-title">                
                        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div><!--END POST-TITLE-->
                    
                    <div class="post-meta">                
                        <ul>
                            <li><span><?php _e('Posted by', BRANKIC_THEME_SHORT); ?></span> <?php the_author_link(); ?></li>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_cats_blog_single_page") == "yes") { ?><li> <span><?php _e('in', BRANKIC_THEME_SHORT); ?></span> <?php the_category(', '); ?></li><?php } ?>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_tags_blog_single_page") == "yes") { ?><li> <span><?php _e(' Tagged with', BRANKIC_THEME_SHORT); ?></span> <?php the_tags('', ', ', ''); ?></li><?php } ?>
                        </ul>
                    </div><!--END POST-META-->  
            
                    <div class="post-media">
                    <?php
                    $video_link = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."video_link", true);

                    if ($video_link != "")
                    {
                        if (bra_is_mov($video_link) || bra_is_swf($video_link))
                        {
                        ?>
                        <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }
                        if (bra_is_vimeo($video_link) || bra_is_youtube($video_link))
                        {
                            if (bra_is_vimeo($video_link))
                            {
                                $video_link = "http://player.vimeo.com/video/" . bra_get_vimeo_id($video_link);
                            }
                            if (bra_is_youtube($video_link))
                            {
                                $video_link = "http://www.youtube.com/embed/" . bra_get_youtube_id($video_link);
                            }
                            ?>
                            <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <?php
                        }
                    }
                    else
                    {
                        if ($full_width) $img_width = 850; else $img_width = 600;
                    ?>        
                        <?php if (extra_images_exists()) { include ("slider.inc.php"); } else { ?>
                            <?php if ($hide_featured_image != "yes") { ?>          
                            <img src="<?php echo $featured_image; ?>" alt="" width="<?php echo $img_width; ?>" />
                            <?php } ?>
                        <?php } ?>
                    <?php } ?> 
                    </div><!--END POST-MEDIA-->
<?php
}
?>
<?php
if ($blog_single_page_style == "3")
{
?>
            
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <?php if ($hide_no_of_comments != "yes") { ?>
                    <div class="comments"><?php comments_popup_link( __('<span>0</span> Comments', BRANKIC_THEME_SHORT), __('<span>1</span> Comment', BRANKIC_THEME_SHORT), __('<span>%</span> Comments', BRANKIC_THEME_SHORT)); ?></div>                            
                    <?php } ?>                            
                </div><!--END POST-INFO-->          
            
                <div class="post-media">
                <?php
                    $video_link = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."video_link", true);

                    if ($video_link != "")
                    {
                        if (bra_is_mov($video_link) || bra_is_swf($video_link))
                        {
                        ?>
                        <iframe src="<?php echo $video_link; ?>" width="100%" height="200" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }
                        if (bra_is_vimeo($video_link) || bra_is_youtube($video_link))
                        {
                            if (bra_is_vimeo($video_link))
                            {
                                $video_link = "http://player.vimeo.com/video/" . bra_get_vimeo_id($video_link);
                            }
                            if (bra_is_youtube($video_link))
                            {
                                $video_link = "http://www.youtube.com/embed/" . bra_get_youtube_id($video_link);
                            }
                            ?>
                            <iframe src="<?php echo $video_link; ?>" width="100%" height="200" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <?php
                        }
                    }
                    else
                    {
                    ?>        
                        <?php if (extra_images_exists()) { include ("slider.inc.3.php"); } else { ?>
                            <?php if ($hide_featured_image != "yes") { ?>          
                            <img src="<?php echo $featured_image; ?>" alt="" width="270" height"270" />
                            <?php } ?>
                        <?php } ?>
                    <?php } ?> 
                </div><!--END POST-MEDIA-->
                
                <div class="post-content">
                    
                    <div class="post-title">                
                        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div><!--END POST-TITLE-->
                
                    <div class="post-meta">                
                        <ul>
                            <li><span><?php _e('Posted by', BRANKIC_THEME_SHORT); ?></span> <?php the_author_link(); ?></li>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_cats_blog_single_page") == "yes") { ?><li> <span><?php _e('in', BRANKIC_THEME_SHORT); ?></span> <?php the_category(', '); ?></li><?php } ?>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_tags_blog_single_page") == "yes") { ?><li> <span><?php _e(' Tagged with', BRANKIC_THEME_SHORT); ?></span> <?php the_tags('', ', ', ''); ?></li><?php } ?>
                        </ul>
                    </div><!--END POST-META-->  
<?php
}
?>
<?php
if ($blog_single_page_style == "4")
{
?>
                <div class="post-media"> 
                <?php
                    $video_link = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."video_link", true);

                    if ($video_link != "")
                    {
                        if (bra_is_mov($video_link) || bra_is_swf($video_link))
                        {
                        ?>
                        <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }
                        if (bra_is_vimeo($video_link) || bra_is_youtube($video_link))
                        {
                            if (bra_is_vimeo($video_link))
                            {
                                $video_link = "http://player.vimeo.com/video/" . bra_get_vimeo_id($video_link);
                            }
                            if (bra_is_youtube($video_link))
                            {
                                $video_link = "http://www.youtube.com/embed/" . bra_get_youtube_id($video_link);
                            }
                            ?>
                            <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <?php
                        }
                    }
                    else
                    {
                        if ($full_width) $img_width = 950; else $img_width = 700; 
                    ?>       
                        <?php if (extra_images_exists()) { include ("slider.inc.php"); } else { ?>
                            <?php if ($hide_featured_image != "yes") { ?>         
                            <img src="<?php echo $featured_image; ?>" alt="" width="<?php echo $img_width; ?>" />
                            <?php } ?>
                        <?php } ?> 
                    <?php } ?> 
                </div><!--END POST-MEDIA-->
            
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <?php if ($hide_no_of_comments != "yes") { ?>
                    <div class="comments"><?php comments_popup_link( __('<span>0</span> Comments', BRANKIC_THEME_SHORT), __('<span>1</span> Comment', BRANKIC_THEME_SHORT), __('<span>%</span> Comments', BRANKIC_THEME_SHORT)); ?></div>                            
                    <?php } ?>          
                </div><!--END POST-INFO-->        
                
                <div class="post-content">    
                
                    <div class="post-title">                
                        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div><!--END POST-TITLE-->
                
                    <div class="post-meta">                
                        <ul>
                            <li><span><?php _e('Posted by', BRANKIC_THEME_SHORT); ?></span> <?php the_author_link(); ?></li>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_cats_blog_single_page") == "yes") { ?><li> <span><?php _e('in', BRANKIC_THEME_SHORT); ?></span> <?php the_category(', '); ?></li><?php } ?>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_tags_blog_single_page") == "yes") { ?><li> <span><?php _e(' Tagged with', BRANKIC_THEME_SHORT); ?></span> <?php the_tags('', ', ', ''); ?></li><?php } ?>
                        </ul>
                    </div><!--END POST-META-->  
<?php
}
?>
<?php
if ($blog_single_page_style == "5")
{
?>
                <div class="post-title">                
                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div><!--END POST-TITLE-->
                
                <div class="post-meta">                
                    <ul>
                        <li><span><?php _e('Posted by', BRANKIC_THEME_SHORT); ?></span> <?php the_author_link(); ?></li>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_cats_blog_single_page") == "yes") { ?><li> <span><?php _e('in', BRANKIC_THEME_SHORT); ?></span> <?php the_category(', '); ?></li><?php } ?>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_tags_blog_single_page") == "yes") { ?><li> <span><?php _e(' Tagged with', BRANKIC_THEME_SHORT); ?></span> <?php the_tags('', ', ', ''); ?></li><?php } ?>
                    </ul>
                </div><!--END POST-META-->
                
                <div class="post-media">
                <?php
                    $video_link = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."video_link", true);

                    if ($video_link != "")
                    {
                        if (bra_is_mov($video_link) || bra_is_swf($video_link))
                        {
                        ?>
                        <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }
                        if (bra_is_vimeo($video_link) || bra_is_youtube($video_link))
                        {
                            if (bra_is_vimeo($video_link))
                            {
                                $video_link = "http://player.vimeo.com/video/" . bra_get_vimeo_id($video_link);
                            }
                            if (bra_is_youtube($video_link))
                            {
                                $video_link = "http://www.youtube.com/embed/" . bra_get_youtube_id($video_link);
                            }
                            ?>
                            <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <?php
                        }
                    }
                    else
                    {
                        if ($full_width) $img_width = 950; else $img_width = 700; 
                    ?>        
                        <?php if (extra_images_exists()) { include ("slider.inc.php"); } else { ?>
                            <?php if ($hide_featured_image != "yes") { ?>         
                            <img src="<?php echo $featured_image; ?>" alt="" width="<?php echo $img_width; ?>" />
                            <?php } ?>
                        <?php } ?>  
                    <?php } ?> 
                </div><!--END POST-MEDIA-->
            
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <?php if ($hide_no_of_comments != "yes") { ?>
                    <div class="comments"><?php comments_popup_link( __('<span>0</span> Comments', BRANKIC_THEME_SHORT), __('<span>1</span> Comment', BRANKIC_THEME_SHORT), __('<span>%</span> Comments', BRANKIC_THEME_SHORT)); ?></div>                            
                    <?php } ?>                           
                </div><!--END POST-INFO-->        
                
                <div class="post-content">  
<?php
}
?>
<?php
if ($blog_single_page_style == "6")
{
?>
                <div class="post-title">                
                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div><!--END POST-TITLE-->
                
                <div class="post-meta">                
                    <ul>
                        <li><span><?php _e('Posted by', BRANKIC_THEME_SHORT); ?></span> <?php the_author_link(); ?></li>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_cats_blog_single_page") == "yes") { ?><li> <span><?php _e('in', BRANKIC_THEME_SHORT); ?></span> <?php the_category(', '); ?></li><?php } ?>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_tags_blog_single_page") == "yes") { ?><li> <span><?php _e(' Tagged with', BRANKIC_THEME_SHORT); ?></span> <?php the_tags('', ', ', ''); ?></li><?php } ?>
                    </ul>
                </div><!--END POST-META--> 
                
                <div class="post-media"> 
                <?php
                    $video_link = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."video_link", true);

                    if ($video_link != "")
                    {
                        if (bra_is_mov($video_link) || bra_is_swf($video_link))
                        {
                        ?>
                        <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }
                        if (bra_is_vimeo($video_link) || bra_is_youtube($video_link))
                        {
                            if (bra_is_vimeo($video_link))
                            {
                                $video_link = "http://player.vimeo.com/video/" . bra_get_vimeo_id($video_link);
                            }
                            if (bra_is_youtube($video_link))
                            {
                                $video_link = "http://www.youtube.com/embed/" . bra_get_youtube_id($video_link);
                            }
                            ?>
                            <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <?php
                        }
                    }
                    else
                    {
                        if ($full_width) $img_width = 950; else $img_width = 700; 
                    ?>       
                        <?php if (extra_images_exists()) { include ("slider.inc.php"); } else { ?> 
                            <?php if ($hide_featured_image != "yes") { ?>         
                            <img src="<?php echo $featured_image; ?>" alt="" width="<?php echo $img_width; ?>" />
                            <?php } ?>
                        <?php } ?>
                    <?php } ?> 
                </div><!--END POST-MEDIA-->
            
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <?php if ($hide_no_of_comments != "yes") { ?>
                    <div class="comments"><?php comments_popup_link( __('<span>0</span> Comments', BRANKIC_THEME_SHORT), __('<span>1</span> Comment', BRANKIC_THEME_SHORT), __('<span>%</span> Comments', BRANKIC_THEME_SHORT)); ?></div>                            
                    <?php } ?>                            
                </div><!--END POST-INFO-->        
                
                <div class="post-content"> 
<?php
}
?>




  
<?php

the_content();
?>

<?php if (get_option(BRANKIC_VAR_PREFIX."show_share") == "yes") include("share.inc.php") ; ?>

                </div><!--END POST-CONTENT -->
                
            </div><!--END POST-->




          
            <?php if ($comments) 
            {  
                comments_template(); 
            }?>
          
     </div><!--END INNER-CONTENT-->
          
          <?php 
if (!($full_width)) get_sidebar(); 



endwhile; ?>


<?php else: //If no posts are present ?>
	
				<div class="entry">						
					<p><?php _e('No posts were found.', BRANKIC_THEME_SHORT); ?></p>	
				</div>
				
<?php endif; ?>

<script type='text/javascript'>
jQuery(document).ready(function($){
    $(".post img, .one img").parent("a").attr("data-rel", "prettyPhoto[]");
})        
</script>

			
<?php get_footer(); ?>
			