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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	//Set access token
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']){ $client->setAccessToken($_SESSION['access_token']); }
		
	?>
	
		
		<div class='mdl-card__title'>
			<div class='valign-wrapper'>
				<img src='core/images/icons_apps.png' class='icon_small'>
				<div><div class='mdl-card__title-text'>Apps</div><div class='card-text-small'>Your Top 6 Apps</div></div>
			</div>
		</div>
	
		<div class='row' style='margin-bottom:0;'>
			
			<?php

				$query = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
				$gafecards = databasequery($query);
				foreach ($gafecards as $value)
				{
					$apps_order=htmlspecialchars($value["apps_order"], ENT_QUOTES);
				}
				
				//Display default order, unless they have saved prefrences
				if($apps_order!=NULL)
				{
					$order = explode(',', $apps_order);
				}
				else
				{
					$order=array();
				}
				
				//print_r($order);
				if (!empty($order))
				{
					//Display customized list of apps
					$appcount=0;
					foreach($order as $key => $value) if ($appcount++ < 6)
					{
						include(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
						$sql = "SELECT * FROM apps WHERE id='$value'";
						$result = $db->query($sql);
	
						while($row = $result->fetch_assoc())
						{
							$id=htmlspecialchars($row["id"], ENT_QUOTES);
							$title=htmlspecialchars($row["title"], ENT_QUOTES);
							$image=htmlspecialchars($row["image"], ENT_QUOTES);
							$link=htmlspecialchars($row["link"], ENT_QUOTES);
							echo "<div class='app col s4'>";
								echo "<img src='$portal_root/core/images/$image' class='appicon_modal'>";
								echo "<span><a href='$link' class='applink truncate'>$title</a></span>";
							echo "</div>";
						}
					}	
				}
				else
				{
					include(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
					$sql = "SELECT * FROM apps WHERE ".$_SESSION['usertype']." = 1 AND required = 1 LIMIT 6";
					$result = $db->query($sql);
	
					while($row = $result->fetch_assoc())
					{
						$id=htmlspecialchars($row["id"], ENT_QUOTES);
						$title=htmlspecialchars($row["title"], ENT_QUOTES);
						$image=htmlspecialchars($row["image"], ENT_QUOTES);
						$link=htmlspecialchars($row["link"], ENT_QUOTES);
						echo "<div class='app col s4'>";
							echo "<img src='$portal_root/core/images/$image' class='appicon_modal'>";
							echo "<span><a href='$link' class='applink truncate'>$title</a></span>";
						echo "</div>";
					}
				}

			?>
		
	</div>