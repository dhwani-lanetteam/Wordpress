<?php
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 */
//echo 'hhii'; exit;
if ( is_active_sidebar( 'unique-sidebar-post_title' ) ) : ?>
	<div id="tertiary" class="sidebar-container" role="complementary">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php
					dynamic_sidebar( 'unique-sidebar-post_title' );
					//--- register_sidebar - id ---/
				?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #tertiary -->
<?php endif; ?>
