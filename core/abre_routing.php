<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
    
	//Required configuration files
	require_once('abre_verification.php');
	
?>

<script>
	
	//Register Material Design Lite Elements
	function mdlregister() {
		componentHandler.upgradeAllRegistered();	
	}
	
	//Redirect to profile if staff do not have streams
	function streamCheck() {
		$.ajax({ type: 'POST', url: 'modules/profile/check.php' })
		.done(function(html){ if(html=='no'){ window.location.href = '#profile'; } })
	}

	//Toggle slide navigation drawer
	function toggle_drawer() {
		var drawer = document.getElementsByClassName('mdl-layout__drawer')[0];
		var drawer_obfuscator = document.getElementsByClassName('mdl-layout__obfuscator')[0];
		drawer.classList.toggle("is-visible");
		drawer_obfuscator.classList.toggle("is-visible");
	}
	
	//Start the page
	function init_page(loader) {
		//Redirect to profile if staff do not have streams
		streamCheck();
		//Hide Loader
		if (loader === undefined | loader === "still"){ $( "#loader" ).hide(); }	
		//Scroll to Top
		var content = $(".mdl-layout__content");
		var target = top ? 0 : $(".content").height();
		content.stop().animate({ scrollTop: target }, 0);
		//Fade in Content
		$( "#content_holder" ).fadeTo(0,0);
		$( "#content_holder" ).css({marginTop: '100px'});
		$( "#content_holder" ).animate({ opacity: 1, marginTop: "0" }, 500, "swing");
		//Register MDL elements
		mdlregister();
		//Make sure top nav is present
		$("header").show();	
		//Remove an overlays
		$( ".lean-overlay" ).remove();
		//Add in menu
		$( ".mdl-layout__drawer-button" ).show();
		$( "#backbutton" ).remove();
	}
	
	//Back Button in Header
	function back_button(url) {
		$( ".mdl-layout__drawer-button" ).hide();
		$( ".mdl-layout__header" ).append( "<a href='"+url+"' class='mdl-layout__drawer-button' id='backbutton'><i class='material-icons'>arrow_back</i></a>" );
	}
	
	//Page Routing
	routie({		
		<?php
			if(isset($_SESSION['useremail']))
			{ 			
				$moduledirectory = dirname(__FILE__) . '/../modules';
				$modulefolders = scandir($moduledirectory);
				foreach ($modulefolders as $result)
				{
					if(file_exists(dirname(__FILE__) . '/../modules/'.$result.'/routing.php'))
					{
						include(dirname(__FILE__) . '/../modules/'.$result.'/routing.php');
					}
				}
			}			
		?>
	'*': function() {
				$( "#navigation_top" ).hide();
				$( "#content_holder" ).hide();
				$( "#loader" ).show();
				$( "#titletext" ).text("Not Found");
				document.title = '<?php echo sitesettings("sitetitle"); ?>';
				$( "#content_holder" ).load( "core/abre_404.php", function() { init_page(); });
			}
			
	});

</script>