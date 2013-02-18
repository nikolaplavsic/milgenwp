<?php get_header(); ?>
			
	<div class="container">
		
		<div class="row" style="background:#fff">
			
			
			<div class="span8">
				
				<?php if ( have_posts() ) : ?>
		
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
		
					<?php if (function_exists('bones_page_navi')) { ?>
			            <?php bones_page_navi(); ?>
			        <?php } else { ?>
			            <nav class="wp-prev-next">
			                <ul class="clearfix">
			        	        <li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "bonestheme")) ?></li>
			        	        <li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestheme")) ?></li>
			                </ul>
			            </nav>
			        <?php } ?>
		
				<?php else : ?>
		
					<article id="post-0" class="post no-results not-found">
		
					<?php if ( current_user_can( 'edit_posts' ) ) :
						// Show a different message to a logged-in user who can add posts.
					?>
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'No posts to display', 'bonestheme' ); ?></h1>
						</header>
		
						<div class="entry-content">
							<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'bonestheme' ), admin_url( 'post-new.php' ) ); ?></p>
						</div><!-- .entry-content -->
		
					<?php else :
						// Show the default message to everyone else.
					?>
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'bonestheme' ); ?></h1>
						</header>
		
						<div class="entry-content">
							<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'bonestheme' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					<?php endif; // end current_user_can() check ?>
		
					</article><!-- #post-0 -->
		
				<?php endif; // end have_posts() check ?>
				
				
			</div>
			
			<div class="span4">
				<?php get_sidebar(); ?>
			</div>
			
		</div> <!-- end .row -->
		
	</div> <!-- end .container -->

<?php get_footer(); ?>
