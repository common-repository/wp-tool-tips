<?php
/*
Plugin Name: WP Tool Tips 
Plugin URI:  http://grupomayan.org/wp-tool-tips/ 
Description: Plug-in that enable to show word definitions as tool tips, in your posts.
Author: Brian Hert
Version: 1.0
Author URI: http://grupomayan.org
*/


// *********** PARSER ***********


function wptooltips_setcontent($contenido_post)
{	
		preg_match_all('/\[(.*?)\|(.*?)\]/', $contenido_post, $ToolTiposIDs);
	
		foreach ($ToolTiposIDs[0] as $Instancia)
		{
			$palillo = strpos ($Instancia,'|');
			
			$palabrasubrayada = substr($Instancia,1,$palillo-1);
			$tooltip          = substr($Instancia,$palillo+1);
			$tooltip = substr($tooltip,0,strlen($tooltip)-1);
			
			$SpanToolTipo = '<span class="hotspot" onmouseover="tooltip.show(' . 
												"'" . $tooltip . "'" 
								. ');" onmouseout="tooltip.hide();">' . $palabrasubrayada . 
							'</span>&nbsp;' .
							'<span style="font-size:10px">'.
							'<a href="http://grupomayan.org" target="_TOP" title="grupo mayan">*</a></span>';
			
			$contenido_post = str_replace($Instancia,$SpanToolTipo,$contenido_post);
		}; 
	
	    return $contenido_post;
}



function wptooltips_setfiles()
{
	echo '<script type="text/javascript" src="' . get_option("siteurl") . '/wp-content/plugins/' 
			. basename(dirname(__FILE__))  . '/wptooltip_script.js">' .
		 '</script>';

	echo '<link rel="stylesheet" type="text/css" href="' . get_option("siteurl") . '/wp-content/plugins/' .
		        basename(dirname(__FILE__)) . '/wptooltip_style.css" />';			
	
}

add_action("wp_head","wptooltips_setfiles");
add_filter("the_content","wptooltips_setcontent");


?>