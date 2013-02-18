<?php get_header(); ?>

	<div class="container">
		
		<div class="row" style="background:#fff">
			
			
			<div class="span8">
				
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php get_template_part( 'content', get_post_format() ); ?>
	
					<?php comments_template( '', true ); ?>
	
				<?php endwhile; // end of the loop. ?>
				
			</div>
			
			<div class="span4">
				<?php get_sidebar(); ?>
			</div>
			
		</div> <!-- end .row -->
		
	</div> <!-- end .container -->
	
<?php get_footer(); ?>