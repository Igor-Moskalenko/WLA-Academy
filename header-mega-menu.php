<?php
/**
 * Header Mega Menu
 */
?>
<!-- BEGIN of header -->
<header class="header-mega-menu">
	<div class="grid-container menu-grid-container">
		<div class="grid-x grid-margin-x align-middle">
			<div class="medium-12 small-12 cell">
				<?php if (has_nav_menu('header-mega-menu')): ?>
					<nav class="top-bar mega-menu-nav">
						<?php wp_nav_menu(
							array(
								'theme_location' => 'header-mega-menu',
								'menu_class' => 'mega-menu',
								'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
							)
						); ?>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>
<!-- END of header -->