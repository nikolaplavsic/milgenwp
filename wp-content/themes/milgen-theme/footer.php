<?php
/**
 * Default Footer
 *
 * @package WordPress
 * @subpackage VART-Bones
 */
?>
        <footer class="footer">
            <div class="container">
                <div class="row">
                	<div class="span3">
	                		
						<div class="vcard">
						   <span class="fn org col-heading">Milgen Power doo</span>
						     <div class="adr"> 
						     	<span class="street-address">Igora Vasiljeva 29a</span>,<br>
								<span class="postal-code">11210</span>
								<span class="locality">Beograd</span>,		      
								<span class="country-name">Srbija</span>
						     </div>   
						     <span class="geo">
						        <span class="latitude">
						           <span class="value-title" title="37.774929"></span>
						        </span>
						        <span class="longitude">
						           <span class="value-title" title="-122.419416"></span>
						        </span>
						     </span>
						   Tel: <span class="tel">011/331-8353</span><br>
						   Email: <a href="office@milgen.rs">office@milgen.rs</a>
						</div>
                	</div>
                	<div class="span3">
                		<span class="col-heading">Navigacija</span>
                		<?php vart_footer_links(); ?>
                	</div>
                	<div class="span3"></div>
                	<div class="span3"></div>
                </div>
            </div><!-- /container -->
        </footer>
		
		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>

	</body>
</html> <!-- end page. what a ride! -->
