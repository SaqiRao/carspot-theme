<footer>
    <div class="container-fluid">
        	<?php
				global $carspot_theme;
				if( isset( $carspot_theme['sb_footer'] ) && $carspot_theme['sb_footer'] != "" )
				{
					echo wp_kses( $carspot_theme['sb_footer'], carspot_required_tags() );
				}
				else 
				{
				   echo wp_kses( "Copyright 2019 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", carspot_required_tags() );
				}
			?>
    </div>
</footer>