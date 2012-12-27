<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "rolinfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$userpriv = new cuserpriv();
$Page =& $userpriv;

// Page init processing
$userpriv->Page_Init();

// Page main processing
$userpriv->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var userpriv = new ew_Page("userpriv");

// page properties
userpriv.PageID = "userpriv"; // page ID
var EW_PAGE_ID = userpriv.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
userpriv.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
userpriv.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
userpriv.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Permisos de Nivel de Usuario<br><br>
<a href="rollist.php">Volver al listado</a></span></p>
<p><span class="phpmaker">Nivel de Usuario: <?php echo $Security->GetUserLevelName($rol->idRol->CurrentValue) ?>(<?php echo $rol->idRol->CurrentValue ?>)</span></p>
<?php $userpriv->ShowMessage() ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="userpriv" id="userpriv" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="rol">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<!-- hidden tag for User Level ID -->
<input type="hidden" name="x_idRol" id="x_idRol" value="<?php echo $rol->idRol->CurrentValue ?>">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
	<thead>
	<tr class="ewTableHeader">
		<td>Tablas/Vistas</td>
		<td>Agregar/Copiar<input type="checkbox" name="Add" id="Add" onclick="ew_SelectAll(this);"<?php echo $userpriv->sDisabled ?>></td>
		<td>Borrar<input type="checkbox" name="Delete" id="Delete" onclick="ew_SelectAll(this);"<?php echo $userpriv->sDisabled ?>></td>
		<td>Editar<input type="checkbox" name="Edit" id="Edit" onclick="ew_SelectAll(this);"<?php echo $userpriv->sDisabled ?>></td>
<?php if (EW_USER_LEVEL_COMPAT) { ?>
		<td>Listar/Buscar/Ver<input type="checkbox" name="List" id="List" onclick="ew_SelectAll(this);"<?php echo $userpriv->sDisabled ?>></td>
<?php } else { ?>
		<td>Listar<input type="checkbox" name="List" id="List" onclick="ew_SelectAll(this);"<?php echo $userpriv->sDisabled ?>></td>
		<td>Ver<input type="checkbox" name="View" id="View" onclick="ew_SelectAll(this);"<?php echo $userpriv->sDisabled ?>></td>
		<td>Buscar<input type="checkbox" name="Search" id="Search" onclick="ew_SelectAll(this);"<?php echo $userpriv->sDisabled ?>></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
for ($i = 0; $i < count($EW_USER_LEVEL_TABLE_NAME); $i++) {
	$userpriv->TempPriv = $Security->GetUserLevelPrivEx($EW_USER_LEVEL_TABLE_NAME[$i], $rol->idRol->CurrentValue);

	// Set row properties
	$rol->CssClass = "";
	$rol->CssStyle = "";
	$rol->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
?>
	<tr<?php echo $rol->RowAttributes() ?>>
		<td><span class="phpmaker"><?php echo $EW_USER_LEVEL_TABLE_CAPTION[$i] ?><?php if (defined("EW_REPORT_TABLE_PREFIX") && substr($EW_USER_LEVEL_TABLE_NAME[$i], 0, strlen(EW_REPORT_TABLE_PREFIX) == EW_REPORT_TABLE_PREFIX)) { ?> (REPORTE)<?php } ?></span></td>
		<td align="center"><input type="checkbox" name="Add_<?php echo $i ?>" id="Add_<?php echo $i ?>" value="1"<?php if (($userpriv->TempPriv & EW_ALLOW_ADD) == EW_ALLOW_ADD) { ?> checked="checked"<?php } ?><?php echo $userpriv->sDisabled ?>></td>
		<td align="center"><input type="checkbox" name="Delete_<?php echo $i ?>" id="Delete_<?php echo $i ?>" value="2"<?php if (($userpriv->TempPriv & EW_ALLOW_DELETE) == EW_ALLOW_DELETE) { ?> checked="checked"<?php } ?><?php echo $userpriv->sDisabled ?>></td>
		<td align="center"><input type="checkbox" name="Edit_<?php echo $i ?>" id="Edit_<?php echo $i ?>" value="4"<?php if (($userpriv->TempPriv & EW_ALLOW_EDIT) == EW_ALLOW_EDIT) { ?> checked="checked"<?php } ?><?php echo $userpriv->sDisabled ?>></td>
<?php if (EW_USER_LEVEL_COMPAT) { ?>
		<td align="center"><input type="checkbox" name="List_<?php echo $i ?>" id="List_<?php echo $i ?>" value="8"<?php if (($userpriv->TempPriv & EW_ALLOW_LIST) == EW_ALLOW_LIST) { ?> checked="checked"<?php } ?><?php echo $userpriv->sDisabled ?>></td>
<?php } else { ?>
		<td align="center"><input type="checkbox" name="List_<?php echo $i ?>" id="List_<?php echo $i ?>" value="8"<?php if (($userpriv->TempPriv & EW_ALLOW_LIST) == EW_ALLOW_LIST) { ?> checked="checked"<?php } ?><?php echo $userpriv->sDisabled ?>></td>
		<td align="center"><input type="checkbox" name="View_<?php echo $i ?>" id="View_<?php echo $i ?>" value="32"<?php if (($userpriv->TempPriv & EW_ALLOW_VIEW) == EW_ALLOW_VIEW) { ?> checked="checked"<?php } ?><?php echo $userpriv->sDisabled ?>></td>
		<td align="center"><input type="checkbox" name="Search_<?php echo $i ?>" id="Search_<?php echo $i ?>" value="64"<?php if (($userpriv->TempPriv & EW_ALLOW_SEARCH) == EW_ALLOW_SEARCH) { ?> checked="checked"<?php } ?><?php echo $userpriv->sDisabled ?>></td>
<?php } ?>
	</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnSubmit" id="btnSubmit" value="Actualizar"<?php echo $userpriv->sDisabled ?>>
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cuserpriv {

	// Page ID
	var $PageID = 'userpriv';

	// Page Object Name
	var $PageObjName = 'userpriv';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show Message
	function ShowMessage() {
		if ($this->getMessage() <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $this->getMessage() . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate Page request
	function IsPageRequest() {
		return TRUE;
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cuserpriv() {
		global $conn;

		// Initialize table object
		$GLOBALS["rol"] = new crol();

	  // Initialize user table object
		$GLOBALS["usuario"] = new cusuario;

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'userpriv', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $rol;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel('rol');
		$Security->TablePermission_Loaded();
		if (!$Security->CanAdmin()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Global page loading event (in userfn6.php)
		Page_Loading();

		// Page load event, used in current page
		$this->Page_Load();
	}

	//
	//  Page_Terminate
	//  - called when exit page
	//  - if URL specified, redirect to the URL
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page unload event, used in current page
		$this->Page_Unload();

		// Global page unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close Connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			ob_end_clean();
			header("Location: $url");
		}
		exit();
	}
	var $TempPriv;
	var $sDisabled;
	var $arPriv;

	//
	// Page main processing
	//
	function Page_Main() {
		global $rol, $EW_USER_LEVEL_TABLE_NAME, $Security;
		if (!is_array($EW_USER_LEVEL_TABLE_NAME)) {
		  $this->setMessage("No hay tablas generadas");
			$this->Page_Terminate("rollist.php"); // Return to list
		}
		$this->arPriv = ew_InitArray(count($EW_USER_LEVEL_TABLE_NAME), 0);

		// Get action
		if (@$_POST["a_edit"] == "") {
			$rol->CurrentAction = "I"; // Display with input box

			// Load key from QueryString
			if (@$_GET["idRol"] <> "") {
				$rol->idRol->setQueryStringValue($_GET["idRol"]);
			} else {
				$this->Page_Terminate("rollist.php"); // Return to list
			}
			if ($rol->idRol->QueryStringValue == "-1") {
				$this->sDisabled = " disabled=\"disabled\"";
			} else {
				$this->sDisabled = "";
			}
		} else {
			$rol->CurrentAction = $_POST["a_edit"];

			// Get fields from form
			$rol->idRol->setFormValue($_POST["x_idRol"]);
			for ($i = 0; $i < count($EW_USER_LEVEL_TABLE_NAME); $i++) {
				if (defined("EW_USER_LEVEL_COMPAT")) {
					$this->arPriv[$i] = intval(@$_POST["Add_" . $i]) + 
						intval(@$_POST["Delete_" . $i]) + intval(@$_POST["Edit_" . $i]) +
						intval(@$_POST["List_" . $i]);
				} else {
					$this->arPriv[$i] = intval(@$_POST["Add_" . $i]) +
						intval(@$_POST["Delete_" . $i]) + intval(@$_POST["Edit_" . $i]) +
						intval(@$_POST["List_" . $i]) + intval(@$_POST["View_" . $i]) +
						intval(@$_POST["Search_" . $i]);
				}
			}
		}
		switch ($rol->CurrentAction) {
			case "I": // Display
				$Security->SetUpUserLevelEx(); // Get all User Level info
				break;
			case "U": // Update
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Set update success message

					// Alternatively, comment out the following line to go back to this page
					$this->Page_Terminate("rollist.php"); // Return to list
				}
		}
	}

	// Update privileges
	function EditRow() {
		global $conn, $EW_USER_LEVEL_TABLE_NAME, $rol;
		for ($i = 0; $i < count($EW_USER_LEVEL_TABLE_NAME); $i++) {
			$Sql = "SELECT * FROM " . EW_USER_LEVEL_PRIV_TABLE . " WHERE " . 
				EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . ew_AdjustSql($EW_USER_LEVEL_TABLE_NAME[$i]) . "' AND " .
				EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $rol->idRol->CurrentValue;
			$rs = $conn->Execute($Sql);
			if ($rs && !$rs->EOF) {
				$Sql = "UPDATE " . EW_USER_LEVEL_PRIV_TABLE . " SET " . EW_USER_LEVEL_PRIV_PRIV_FIELD . " = " . $this->arPriv[$i] . " WHERE " .
					EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . ew_AdjustSql($EW_USER_LEVEL_TABLE_NAME[$i]) . "' AND " .
					EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $rol->idRol->CurrentValue;
				$conn->Execute($Sql);
			} else {
				$Sql = "INSERT INTO " . EW_USER_LEVEL_PRIV_TABLE . " (" . EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . ", " . EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . ", " . EW_USER_LEVEL_PRIV_PRIV_FIELD . ") VALUES ('" . ew_AdjustSql($EW_USER_LEVEL_TABLE_NAME[$i]) . "', " . $rol->idRol->CurrentValue . ", " . $this->arPriv[$i] . ")";
				$conn->Execute($Sql);
			}
			if ($rs) $rs->Close();
		}
		return TRUE;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}
}
?>
