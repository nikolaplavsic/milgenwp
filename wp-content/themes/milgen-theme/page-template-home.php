<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>
			
		<div class="container">
		
			<section class="margin-after">
				<div class="row-bg">
					<div class="row row-bleed-right">
						<div class="span12">
							<div style="height:300px;"></div>
						</div>
					</div>
				</div>
			</section>
			
			<div class="row">
				<div class="span4">
					<div class="cbox cbox-bordered darkblue" style="height:300px;"></div>
				</div>
				<div class="span4">
					<div class="cbox cbox-bordered blue" style="height:300px;"></div>
				</div>
				<div class="span4">
					<div class="cbox cbox-bordered lightblue" style="height:300px;"></div>
				</div>
			</div>
		
			
			<section class="margin-after">
				<div class="row-bg">
					<div class="row row-bleed-right">
						<div class="column-content grid-wrapper">
							<div class="span12">
								<section>
									<div class="row-fluid">
										<div class="span5">
											<h3>Usluge</h3>
											
											<ul class="">
											<?php 
												$args = array(
													'depth'        => 1,
													'child_of'     => 108,
													'title_li'     => '',
													'link_before'  => '',
													'link_after'   => '',
												    'post_status'  => 'publish' 
												);
												wp_list_pages( $args );
											?>
											</ul>
											
										</div>
										<div class="span7">
											<h2>MILGEN Elektro-Agregati<br>instalacije i rezervni delovi</h2>
											<p>Sigurno i neprekidno napajanje električnom energijom!</p>
											<p>MILGEN POWER d.o.o. sa sedištem u BEOGRADU kao i pokrivenom servisnom Službom u Novom Sadu , i Čačku, ukupno 10 stalno zaposlenih servisera čiji je prioritetni cilj zadovoljstvo klijenata koji su nam ukazali MAKSIMALNO POVERENJE i MINIMALNI RIZIK</p>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</section>
		
		</div> <!-- end .container -->

<?php get_footer(); ?>
