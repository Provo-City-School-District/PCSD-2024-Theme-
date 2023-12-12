<?php
/*
Template Name: Front Page
*/
get_header();

//fetch all stored variables from the control post
$get_to_know_fields = get_fields();
// gather child theme variables
$theme_vars = my_theme_variables();
?>


<main id="mainContent" class="homeMainContent">

	<?php
	//query any alerts
	$my_query = new WP_Query(array('showposts' => $posts_to_show, 'category_name'  => 'alert', 'post_status' => 'publish'));
	?>
	<section class="alerts 
		<?php if ($my_query->found_posts <= 0) {
			echo 'hidden';
		} ?>">
		<?php
		while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<article class="post">
				<header class="postmeta">
					<ul>
						<li><img src="//globalassets.provo.edu/image/icons/calendar-lt.svg" alt="" /><?php the_time(' F jS, Y') ?></li>
					</ul>
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

				</header>

			</article>
			<button class="closeAlert"></button>
		<?php endwhile;
		?>

	</section>
	<div class="notgrid2">
		280 West 940 North Provo, Utah 801-374-4800
	</div>
	<?php
	wp_reset_query();
	?>

	<h1 class="novisibility"><?php echo $theme_vars['full_school_name']; ?></h1>
	<section id="announcments">
		<h2><?php echo $theme_vars['full_school_name']; ?> Announcements</h2>
		<?php

		if ($get_to_know_fields['video_or_slider'] == 'video') {
		?>

			<video id="heroVideo" autoplay loop controls>
				<source src="<?php echo $get_to_know_fields['video_url'] ?>" type="video/mp4">
				Your browser does not support MP4 Format videos or HTML5 Video.
			</video>
		<?php
		} elseif ($get_to_know_fields['video_or_slider'] == 'slider') {
		?>
			<div class="slick-wrapper">
				<?php
				$args = array('post_type' => 'announcement', 'posts_per_page' => 5, 'orderby'  => array('date' => 'DESC'));
				// Variable to call WP_Query.
				$the_query = new WP_Query($args);
				if ($the_query->have_posts()) :
					while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<?php
						if (get_field('announcement_link')) {
						?>
							<a href="<?php echo get_field('announcement_link')  ?>">
							<?php
						}
							?>
							<article class="slide" style="background-image: url('<?php the_field('announcement_image'); ?>')"></article>
							<?php
							if (get_field('announcement_link')) {
							?>
							</a>
						<?php
							}
						?>
				<?php endwhile;
				else :
					echo '<p>No Content Found</p>';
				endif;
				wp_reset_query();
				?>
			</div>
		<?php
		}

		?>
	</section>
	<div id="belowSlider">
		<section id="stayCurrent" class="grid2 calendar">
			<ul>
				<li><a href=""><?php echo get_svg('socialmedia-insta'); ?></a></li>
				<li><a href=""><?php echo get_svg('socialmedia-twitter'); ?></a></li>
				<li><a href=""><?php echo get_svg('socialmedia-facebook'); ?></a></li>
			</ul>
			<ul>
				<li><a href="<?php echo get_field('hero_link_address'); ?>"><?php echo get_field('hero_link_label'); ?></a></li>
			</ul>
		</section>

		<section class="wpMenu">
			<?php
			wp_reset_query();
			$topMenu = get_field('select_a_menu');
			wp_nav_menu(array('menu' => $topMenu));
			?>
		</section>
		<section id="homeNews">
			<!-- News Home Page Start -->
			<h1><?php echo $theme_vars['short_school_name']; ?> News & Events</h1>
			<p>The latest news from <?php echo $theme_vars['full_school_name']; ?></p>
			<div class="stories">
				<?php
				$the_query = new WP_Query(array('posts_per_page' => 3, 'category_name'  => 'news', 'post_type'  => 'post'));
				if ($the_query->have_posts()) :
					while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<article>
							<a href="<?php the_permalink(); ?>">
								<div class="featured-image">

									<?php
									if (get_field('featured_image', $post_id)) {
									?>
										<img src="<?php echo get_field('featured_image'); ?>" alt="" class="" />
									<?php
									} elseif (has_post_thumbnail()) {
										the_post_thumbnail();
									} else { ?>
										<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/building-image.jpg'; ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" width="217" height="175">
									<?php } ?>

								</div>
								<h2><?php the_title(); ?></h2>
							</a>
							<div class="articleContent">
								<?php
								echo get_excerpt();
								?>
								<!-- <a href="<?php the_permalink(); ?>">Read More <span class="rightarrow"></span></a> -->
							</div>
							<p class="readMore"><a href="<?php the_permalink(); ?>">Read More <span class="rightarrow"></span></a></p>
							<p class="postDate"><?php echo get_the_date(); ?></p>

						</article>
				<?php endwhile;
				else :
					echo '<p>No Content Found</p>';
				endif;
				?>
			</div>
			<p class="moreNews"><a href="https://provo.edu/news/">Read More <?php echo $theme_vars['short_school_name']; ?> News <span class="rightarrow"></span></a></p>
		</section> <!-- News Home Page End -->


		<section id="socialMediaFrontPage">
			<!-- Start Social Media -->
			<h1>Social Media</h1>
			See what's being discussed & shared
			<ul class="sociallinks">
				<li><a href=""><?php echo get_svg('socialmedia-insta'); ?></a></li>
				<li><a href=""><?php echo get_svg('socialmedia-twitter'); ?></a></li>
				<li><a href=""><?php echo get_svg('socialmedia-facebook'); ?></a></li>
			</ul>
		</section> <!-- End Social Media -->
	</div><!-- End of post slider content -->
</main><!-- End of #mainContent -->
<?php
get_footer();
?>