<?php include "Connections/conexion.php" ?>
<script type="text/javascript" language="JavaScript1.2" src="ewmenu/stmenu.js"></script>
<?php

// Menu
define("EW_MENUBAR_VERTICAL_CLASSNAME", "ewMenuBarVertical", TRUE);
define("EW_MENUBAR_SUBMENU_CLASSNAME", "", TRUE);
define("EW_MENUBAR_RIGHTHOVER_IMAGE", "", TRUE);
?>
<?php
define("EW_SESSION_MENU_AR_USER_LEVEL_PRIV", "project1_arUserLevelPriv", TRUE); // User Level Privilege Array
define("EW_SESSION_MENU_USER_LEVEL", "project1_status_UserLevelValue", TRUE); // User level value
define("EW_MENU_ALLOW_ADMIN", 16, TRUE);

// Restore user level privilege
if (is_array(@$_SESSION[EW_SESSION_MENU_AR_USER_LEVEL_PRIV]))
	$arMenuUserLevelPriv = $_SESSION[EW_SESSION_MENU_AR_USER_LEVEL_PRIV];

// Check if menu item is allowed for current user level
function AllowListMenu($TableName) {
	global $arMenuUserLevelPriv;
	$userlevellist = "";
	if (function_exists("CurrentUserLevelList"))
		$userlevellist = CurrentUserLevelList(); // Get user level id list
	if (strval($userlevellist) == "") // Not defined, just get user level
		$userlevellist = CurrentUserLevel();
	if (IsLoggedIn()) {
		if (IsListItem($userlevellist, "-1")) {
			return TRUE;
		} else {
			$priv = 0;
			if (is_array($arMenuUserLevelPriv)) {
				foreach ($arMenuUserLevelPriv as $row) {
					if (strval($row[0]) == strval($TableName) &&
						IsListItem($userlevellist, $row[1])) {
						$thispriv = $row[2];
						if (is_null($thispriv)) $thispriv = 0;
						$thispriv = intval($thispriv);
						$priv = $priv | $thispriv;
					}
				}
			}
			return ($priv & 8);
		}
	} else {
		return FALSE;
	}
}

// Is list item
function IsListItem($list, $item) {
	if ($list == "") {
		return FALSE;
	} else {
		$ar = explode(",", $list);
		foreach ($ar as $level) {
			if (trim(strval($item)) == trim(strval($level)))
				return TRUE;
		}
		return FALSE;
	}
}

/**
 * Menu class
 */

class cMenu {
	var $Id;
	var $IsRoot = FALSE;
	var $NoItem = NULL;
	var $ItemData = array();

	function cMenu($id) {
		$this->Id = $id;
	}

	// Add a menu item
	function AddMenuItem($id, $text, $url, $parentid) {
		$item = new cMenuItem($id, $text, $url, $parentid);
		if (!MenuItem_Adding($item)) return;
		if ($item->ParentId < 0) {
			$this->AddItem($item);
		} else {
			if ($oParentMenu =& $this->FindItem($item->ParentId))
				$oParentMenu->AddItem($item);
		}
	}

	// Add item to internal array
	function AddItem($item) {
		$this->ItemData[] = $item;
	}

	// Find item
	function &FindItem($id) {
		$cnt = count($this->ItemData);
		for ($i = 0; $i < $cnt; $i++) {
			$item =& $this->ItemData[$i];
			if ($item->Id == $id) {
				return $item;
			} elseif (!is_null($item->SubMenu)) {
				if ($subitem =& $item->SubMenu->FindItem($id))
					return $subitem;
			}
		}
		return $this->NoItem;
	}

	// Render the menu
	function Render() {
		echo "<ul";
		if ($this->Id <> "") {
			if (is_numeric($this->Id)) {
				echo " id=\"menu_" . $this->Id . "\"";
			} else {
				echo " id=\"" . $this->Id . "\"";
			}
		}
		if ($this->IsRoot)
			echo " class=\"" . EW_MENUBAR_VERTICAL_CLASSNAME . "\"";
		echo ">\n";
		foreach ($this->ItemData as $item) {
			echo "<li><a";
			if (!is_null($item->SubMenu))
				echo " class=\"" . EW_MENUBAR_SUBMENU_CLASSNAME . "\"";
			if ($item->Url <> "")
				echo " href=\"" . htmlspecialchars(strval($item->Url)) . "\"";
			echo ">" . $item->Text . "</a>\n";
			if (!is_null($item->SubMenu))
				$item->SubMenu->Render();
			echo "</li>\n";
		}
		echo "</ul>\n";
	}
}

// Menu item class
class cMenuItem {
	var $Id;
	var $Text;
	var $Url;
	var $ParentId; 
	var $SubMenu = NULL; // Data type = cMenu

	function cMenuItem($id, $text, $url, $parentid) {
		$this->Id = $id;
		$this->Text = $text;
		$this->Url = $url;
		$this->ParentId = $parentid;
	}

	function AddItem($item) { // Add submenu item
		if (is_null($this->SubMenu))
			$this->SubMenu = new cMenu($this->Id);
		$this->SubMenu->AddItem($item);
	}
}

// MenuItem Adding event
function MenuItem_Adding(&$Item) {

	//var_dump($Item);
	// Return FALSE if menu item not allowed

	return TRUE;
}
?>
<!-- Begin Main Menu -->
<div class="phpmaker">
<?php
mysql_select_db($database_conexion, $conexion);
$query_cuenta = "SELECT * FROM cuenta ORDER BY cuenta";
$mostrar_cuenta= mysql_query($query_cuenta, $conexion) or die(mysql_error());
$total_cuenta= mysql_num_rows($mostrar_cuenta);
// Generate all menu items
$RootMenu = new cMenu("RootMenu");
$RootMenu->IsRoot = TRUE;
?>

<table width="160" border="0" cellspacing="0" cellpadding="0">
 <tr><td>
    <script id="Sothink Widgets:sigma_ewmenu.pgt" type="text/javascript" language="JavaScript1.2">
<!--
stm_bm(["menu502e",720,"","ewmenu/blank.gif",0,"","",0,0,250,0,1000,1,0,0,"","",0,0,1,1,"default","hand",""],this);
stm_bp("p0",[1,4,0,0,1,2,16,18,100,"",-2,"",-2,90,0,0,"#000000","#40546A","",3,1,1,"#40546A"]);
stm_ai("p0i0",[6,1,"transparent","ewmenu/images.jpeg",170,140,0]);

<?php if (IsLoggedIn()) { ?>
stm_ai("p0i1",[0,"Cerrar Sesi\u00f3n","","",-1,-1,0,"logout.php","_self","","","ewmenu/lock_go.png","ewmenu/lock_go.png",16,16,0,"","",0,0,0,0,1,"#F5F5F5",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","9pt Arial","9pt Arial",0,0]);	
<?php } elseif (substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php") {?>
stm_ai("p0i1",[0,"Ingresar","","",-1,-1,0,"login.php","_self","","","ewmenu/lock_go.png","ewmenu/lock_go.png",16,16,0,"","",0,0,0,0,1,"#F5F5F5",0,"#E7EEAE",0,"","",3,3,0,0,"#CC9966","#FFD7B0","#000000","#000000","9pt Arial","9pt Arial",0,0]);	
<?php } ?>

<?php if ((@$_SESSION[EW_SESSION_MENU_USER_LEVEL] & EW_MENU_ALLOW_ADMIN) == EW_MENU_ALLOW_ADMIN) { ?>
stm_aix("p0i2","p0i1",[0,"Administracion Sistema","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
<?php if ((@$_SESSION[EW_SESSION_MENU_USER_LEVEL] & EW_MENU_ALLOW_ADMIN) == EW_MENU_ALLOW_ADMIN) { ?>
stm_aix("p1i2","p0i1",[0,"Permisos","","",-1,-1,0,"permisolist.php?cmd=resetall","_self","","","ewmenu/medal_gold_2.png","ewmenu/medal_gold_2.png"],150,0);
<?php } ?>

<?php if ((@$_SESSION[EW_SESSION_MENU_USER_LEVEL] & EW_MENU_ALLOW_ADMIN) == EW_MENU_ALLOW_ADMIN) { ?>
stm_aix("p1i3","p0i1",[0,"Rol","","",-1,-1,0,"rollist.php?cmd=resetall","_self","","","ewmenu/medal_gold_2.png","ewmenu/medal_gold_2.png"],150,0);
<?php } ?>
    
<?php if (IsLoggedIn() && !IsSysAdmin()) { ?>    
stm_aix("p1i4","p0i1",[0,"Cambio de Contrase\u00f1a","","",-1,-1,0,"changepwd.php?cmd=resetall","_self","","","ewmenu/medal_gold_2.png","ewmenu/medal_gold_2.png"],150,0);
<?php } ?>
    
stm_ep();
<?php } ?>


stm_aix("p0i2","p0i1",[0,"Administracion Iglesia","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
<?php if (AllowListMenu('cuenta')) { ?>
stm_aix("p1i2","p0i1",[0,"Cuentas","","",-1,-1,0,"cuentalist.php","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);
<?php } ?>

stm_aix("p1i3","p0i1",[0,"Miembros","","",-1,-1,0,"miembrolist.php","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);

<?php if (AllowListMenu('usuario')) { ?>
stm_aix("p1i4","p0i1",[0,"Usuarios","","",-1,-1,0,"usuariolist.php?cmd=resetall","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);
<?php } ?>
    
<?php if (AllowListMenu('cierre_gestion')) { ?>
stm_aix("p1i5","p0i1",[0,"Cierre de Gestion","","",-1,-1,0,"cierre_gestionlist.php?cmd=resetall","_self","","","ewmenu/world.png","ewmenu/world.png"],150,0);
<?php } ?>
    
stm_ep();

<?php if (AllowListMenu('saldo_cuenta')) {?>
stm_aix("p0i2","p0i1",[0,"Diezmo","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);
stm_aix("p1i2","p0i1",[0,"Registro de Diezmo","","",-1,-1,0,"diezmolist.php?total=0","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],250,0);
stm_ep();
<?php } ?>


<?php if (AllowListMenu('saldo_cuenta')) {?>
stm_aix("p0i2","p0i1",[0,"CUENTAS","","",-1,-1,0,"#","_self","","","ewmenu/folder.png","ewmenu/folder.png",16,16,0,"ewmenu/37-06_an0.gif","ewmenu/37-06_an.gif",18,13]);
stm_bpx("p1","p0",[1,2,0,0,1,2,16,0,100,"",-2,"",-2,90,0,0,"#000000","#F5F5F5"]);

<?php while($row_cuenta=mysql_fetch_assoc($mostrar_cuenta)){ ?>
stm_aix("p1i2","p0i1",[0,"<?php echo $row_cuenta['cuenta'] ?>","","",-1,-1,0,"saldo_cuentalist.php?idCuenta=<?php echo $row_cuenta['idCuenta']?>","_self","","","ewmenu/layout_sidebar.png","ewmenu/overlays.png"],250,0);
<?php } ?>
stm_ep();
<?php } ?>


stm_em();
//-->
    </script>
     </td></tr></table>
</div>

    
    
<?php    

//if (AllowListMenu('cuenta')) {
//	$RootMenu->AddMenuItem(1, "Cuenta", "cuentalist.php", -1);
//}
//if (AllowListMenu('diezmo')) {
//	$RootMenu->AddMenuItem(2, "Diezmo", "diezmolist.php", -1);
//}
//	$RootMenu->AddMenuItem(3, "Miembro", "miembrolist.php", -1);
//while($row_cuenta=mysql_fetch_assoc($mostrar_cuenta)){
//if (AllowListMenu('saldo_cuenta')) {
//	$RootMenu->AddMenuItem(4, strtoupper($row_cuenta['cuenta']), "saldo_cuentalist.php?idCuenta=".$row_cuenta['idCuenta'], -1);
//}
//}
////if (AllowListMenu('saldo_iglesia')) {
////	$RootMenu->AddMenuItem(5, "Saldo Iglesia", "saldo_iglesialist.php", -1);
////}
//if (AllowListMenu('usuario')) {
//	$RootMenu->AddMenuItem(6, "Usuario", "usuariolist.php", -1);
//}
//if ((@$_SESSION[EW_SESSION_MENU_USER_LEVEL] & EW_MENU_ALLOW_ADMIN) == EW_MENU_ALLOW_ADMIN) {
//	$RootMenu->AddMenuItem(7, "Permiso", "permisolist.php", -1);
//}
//if ((@$_SESSION[EW_SESSION_MENU_USER_LEVEL] & EW_MENU_ALLOW_ADMIN) == EW_MENU_ALLOW_ADMIN) {
//	$RootMenu->AddMenuItem(8, "Rol", "rollist.php", -1);
//}
//if (IsLoggedIn() && !IsSysAdmin()) {
//	$RootMenu->AddMenuItem(0xFFFFFFFE, "Cambiar Contrase�a", "changepwd.php", -1);
//}
//if (IsLoggedIn()) {
//	$RootMenu->AddMenuItem(0xFFFFFFFF, "Salir", "logout.php", -1);
//} elseif (substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php") {
//	$RootMenu->AddMenuItem(0xFFFFFFFF, "Ingresar", "login.php", -1);
//}



$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
