<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">


	<title><?php bloginfo( 'name'); ?> Coming Soon</title>
	<?php wp_head(); ?>
</head>

<body style="margin: 0;">
	<div class="container-fluid">
        
		<?php 

        $settings = get_option( 'sw_maintenance_options');
        $templateOption = 'sw-maintenance-template';
        $template = 'sw-maintenance-custom-template';
        
        if ($settings[$templateOption] != 'custom') {
		  echo do_shortcode('[fl_builder_insert_layout slug="sw-maintenance-template" type="fl-builder-template"]');
        } else {
            echo do_shortcode('[fl_builder_insert_layout id="'. $settings[$template] . '"]');
        }

		wp_footer(); 
		
		?> 
	</div>
	
</body>
</html>
