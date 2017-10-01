<?php
class MenuUtil {

	public static function getMenuByRole($currentPage) {
		echo "<font color='red'>" . $currentPage . "</font>";
		
		$currentPage = str_replace(ConfigUtil::getAppName(), "", $currentPage);
		
		$listOfMenuInRole = '';
		// Get Current User role
		$cri = new CDbCriteria ();
		$cri->condition = " ROLE_ID=" . UserLoginUtils::getUserRole () . " AND IS_ACTIVE='1'";
		
		$mroles = MenuRole::model ()->findAll ( $cri );
		if (isset ( $mroles )) {
			foreach ( $mroles as $mr ) {
				$listOfMenuInRole .= $mr->MENU_ID . ',';
			}
			if (strlen ( $listOfMenuInRole ) > 0) {
				$navMenu = "";
				$criMP = new CDbCriteria ();
				$criMP->condition = " PREVIOUS_MENU_ID=-1 AND MENU_ID in (" . rtrim ( $listOfMenuInRole, ',' ) . ")";
				
				$Menus = Menu::model ()->findAll ( $criMP );
				if (isset ( $Menus )) {
					foreach ( $Menus as $parent ) {
						
// 						$criCh = new CDbCriteria ();
// 						$criCh->condition = " PREVIOUS_MENU_ID = '" . $parent->MENU_ID . "' AND MENU_ID in (" . rtrim ( $listOfMenuInRole, ',' ) . ")";
// 						$criCh->order ="MENU_ID,DISPLAY_ORDER";
						
						$criCh = new CDbCriteria ( array (
								'condition' => " PREVIOUS_MENU_ID = '" . $parent->MENU_ID . "' AND MENU_ID in (" . rtrim ( $listOfMenuInRole, ',' ) . ")",
								'order' => 'DISPLAY_ORDER ASC'
						) );
						
						
						$MenusChilds = Menu::model ()->findAll ( $criCh );
						
						$bActiveSelectedMenu = false;
						
						if (isset ( $MenusChilds )) {
							foreach ( $MenusChilds as $child ) {
								if (0 === strpos ( $currentPage, $child->URL_NAVIGATE )) {
									$bActiveSelectedMenu = true;
									break;
								}
							}
						}
						
						/* - BEGIN ADD MAIN MENU - */
						$navMenu = $navMenu . "<li class=\"nav-item " . ($bActiveSelectedMenu == true ? "start active open" : "") . "  \">";
						$navMenu = $navMenu . "<a href=\"javascript:;\" class=\"nav-link nav-toggle\">";
						$navMenu = $navMenu . "<i class=\"" . $parent->MENU_ICON . "\"></i>";
						$navMenu = $navMenu . "<span class=\"title\">" . $parent->MENU_NAME . "</span>";
						$navMenu = $navMenu . "<span class=\"arrow\"></span>";
						$navMenu = $navMenu . "</a>";
						/* - BEGIN ADD SUBMENU - */
						$navMenu = $navMenu . "<ul class=\"sub-menu\">";
						
						if (isset ( $MenusChilds )) {
							
							foreach ( $MenusChilds as $child ) {
								$isActive = false;
								if (0 === strpos ( $currentPage, $child->URL_NAVIGATE )) {
									$isActive = true;
								}
								
								$navMenu = $navMenu . "<li class=\"nav-item " . ($isActive == true ? "start active open" : "") . " \">";
								$navMenu = $navMenu . "<a href=\"" .ConfigUtil::getAppName(). $child->URL_NAVIGATE . "\" class=\"nav-link \">";
								$navMenu = $navMenu . "<span class=\"title\">" . $child->MENU_NAME . "</span>";
								$navMenu = $navMenu . "" . ($isActive == true ? '<span class=\"selected\"></span>' : '') . "</a>";
								$navMenu = $navMenu . "</li>";
							}
							$navMenu = $navMenu . "</ul>";
							/* - END SUBMENU - */
							$navMenu = $navMenu . "</li>";
							/* - END MAIN MENU - */
						}
					}
				}
			} else {
			}
		}
		return $navMenu;
	}
	public static function getNavigator($currentPage) {
		$currentPage = str_replace(ConfigUtil::getAppName(), "", $currentPage);
		
		$nav = "";
		
		$nav = $nav . "<li>";
		$nav = $nav . "<i class=\"fa fa-home\"></i>";
		$nav = $nav . "<a href=\"" . "#" . "\">Home</a>";
		$nav = $nav . "</li>";
		
		$criMenu = new CDbCriteria ();
		$criMenu->condition = "URL_NAVIGATE = '" . $currentPage . "'";
		
		$childs = Menu::model ()->findAll ();
		if (isset ( $childs )) {
			foreach ( $childs as $child ) {
				
				if (0 === strpos ( $currentPage, $child->URL_NAVIGATE )) {
					
					$criMenuParent = new CDbCriteria ();
					$criMenuParent->condition = "MENU_ID = " . $child ->PREVIOUS_MENU_ID;
					
					$parent = Menu::model ()->findAll ( $criMenuParent );
					if (isset ( $parent[0] )) {
						$nav = $nav . "<li>";
						$nav = $nav . "<i class=\"fa fa-angle-right\"></i>";
						$nav = $nav . "<a href=\"#\">" . $parent[0] ->MENU_NAME . "</a>";
						$nav = $nav . "</li>";
					}
					
					$nav = $nav . "<li>";
					$nav = $nav . "<i class=\"fa fa-angle-right\"></i>";
					$nav = $nav . "<a href=\"#\">" . $child ->MENU_NAME . "</a>";
					$nav = $nav . "</li>";
				}
			}
		}
		
		return $nav;
	}
}