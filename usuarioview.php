<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
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
$usuario_view = new cusuario_view();
$Page =& $usuario_view;

// Page init processing
$usuario_view->Page_Init();

// Page main processing
$usuario_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($usuario->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var usuario_view = new ew_Page("usuario_view");

// page properties
usuario_view.PageID = "view"; // page ID
var EW_PAGE_ID = usuario_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
usuario_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
usuario_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
usuario_view.ValidateRequired = false; // no JavaScript validation
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
<?php } ?>
<p><span class="phpmaker">Ver TABLA: Usuario
<br><br>
<?php if ($usuario->Export == "") { ?>
<a href="usuariolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $usuario->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $usuario->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $usuario->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $usuario_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($usuario->idUsuario->Visible) { // idUsuario ?>
	<tr<?php echo $usuario->idUsuario->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $usuario->idUsuario->CellAttributes() ?>>
<div<?php echo $usuario->idUsuario->ViewAttributes() ?>><?php echo $usuario->idUsuario->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($usuario->idRol->Visible) { // idRol ?>
	<tr<?php echo $usuario->idRol->RowAttributes ?>>
		<td class="ewTableHeader">Rol</td>
		<td<?php echo $usuario->idRol->CellAttributes() ?>>
<div<?php echo $usuario->idRol->ViewAttributes() ?>><?php echo $usuario->idRol->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($usuario->nombre->Visible) { // nombre ?>
	<tr<?php echo $usuario->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre(s)</td>
		<td<?php echo $usuario->nombre->CellAttributes() ?>>
<div<?php echo $usuario->nombre->ViewAttributes() ?>><?php echo $usuario->nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($usuario->paterno->Visible) { // paterno ?>
	<tr<?php echo $usuario->paterno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Paterno</td>
		<td<?php echo $usuario->paterno->CellAttributes() ?>>
<div<?php echo $usuario->paterno->ViewAttributes() ?>><?php echo $usuario->paterno->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($usuario->materno->Visible) { // materno ?>
	<tr<?php echo $usuario->materno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Materno</td>
		<td<?php echo $usuario->materno->CellAttributes() ?>>
<div<?php echo $usuario->materno->ViewAttributes() ?>><?php echo $usuario->materno->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($usuario->ci->Visible) { // ci ?>
	<tr<?php echo $usuario->ci->RowAttributes ?>>
		<td class="ewTableHeader">C.I</td>
		<td<?php echo $usuario->ci->CellAttributes() ?>>
<div<?php echo $usuario->ci->ViewAttributes() ?>><?php echo $usuario->ci->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($usuario->cargo->Visible) { // cargo ?>
	<tr<?php echo $usuario->cargo->RowAttributes ?>>
		<td class="ewTableHeader">Cargo en la Iglesia</td>
		<td<?php echo $usuario->cargo->CellAttributes() ?>>
<div<?php echo $usuario->cargo->ViewAttributes() ?>><?php echo $usuario->cargo->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($usuario->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cusuario_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'usuario';

	// Page Object Name
	var $PageObjName = 'usuario_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $usuario;
		if ($usuario->UseTokenInUrl) $PageUrl .= "t=" . $usuario->TableVar . "&"; // add page token
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
		global $objForm, $usuario;
		if ($usuario->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($usuario->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($usuario->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cusuario_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["usuario"] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $usuario;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("usuariolist.php");
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
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $lRecCnt;

	//
	// Page main processing
	//
	function Page_Main() {
		global $usuario;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idUsuario"] <> "") {
				$usuario->idUsuario->setQueryStringValue($_GET["idUsuario"]);
			} else {
				$sReturnUrl = "usuariolist.php"; // Return to list
			}

			// Get action
			$usuario->CurrentAction = "I"; // Display form
			switch ($usuario->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "usuariolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "usuariolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$usuario->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $usuario;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$usuario->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$usuario->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $usuario->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$usuario->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$usuario->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$usuario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $usuario;
		$sFilter = $usuario->KeyFilter();

		// Call Row Selecting event
		$usuario->Row_Selecting($sFilter);

		// Load sql based on filter
		$usuario->CurrentFilter = $sFilter;
		$sSql = $usuario->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$usuario->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $usuario;
		$usuario->idUsuario->setDbValue($rs->fields('idUsuario'));
		$usuario->idRol->setDbValue($rs->fields('idRol'));
		$usuario->nombre->setDbValue($rs->fields('nombre'));
		$usuario->paterno->setDbValue($rs->fields('paterno'));
		$usuario->materno->setDbValue($rs->fields('materno'));
		$usuario->ci->setDbValue($rs->fields('ci'));
		$usuario->cargo->setDbValue($rs->fields('cargo'));
		$usuario->zlogin->setDbValue($rs->fields('login'));
		$usuario->password->setDbValue($rs->fields('password'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $usuario;

		// Call Row_Rendering event
		$usuario->Row_Rendering();

		// Common render codes for all row types
		// idUsuario

		$usuario->idUsuario->CellCssStyle = "";
		$usuario->idUsuario->CellCssClass = "";

		// idRol
		$usuario->idRol->CellCssStyle = "";
		$usuario->idRol->CellCssClass = "";

		// nombre
		$usuario->nombre->CellCssStyle = "";
		$usuario->nombre->CellCssClass = "";

		// paterno
		$usuario->paterno->CellCssStyle = "";
		$usuario->paterno->CellCssClass = "";

		// materno
		$usuario->materno->CellCssStyle = "";
		$usuario->materno->CellCssClass = "";

		// ci
		$usuario->ci->CellCssStyle = "";
		$usuario->ci->CellCssClass = "";

		// cargo
		$usuario->cargo->CellCssStyle = "";
		$usuario->cargo->CellCssClass = "";
		if ($usuario->RowType == EW_ROWTYPE_VIEW) { // View row

			// idUsuario
			$usuario->idUsuario->ViewValue = $usuario->idUsuario->CurrentValue;
			$usuario->idUsuario->CssStyle = "";
			$usuario->idUsuario->CssClass = "";
			$usuario->idUsuario->ViewCustomAttributes = "";

			// idRol
			if ($Security->CanAdmin()) { // System admin
			if (strval($usuario->idRol->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre` FROM `rol` WHERE `idRol` = " . ew_AdjustSql($usuario->idRol->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$usuario->idRol->ViewValue = $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$usuario->idRol->ViewValue = $usuario->idRol->CurrentValue;
				}
			} else {
				$usuario->idRol->ViewValue = NULL;
			}
			} else {
				$usuario->idRol->ViewValue = "********";
			}
			$usuario->idRol->CssStyle = "";
			$usuario->idRol->CssClass = "";
			$usuario->idRol->ViewCustomAttributes = "";

			// nombre
			$usuario->nombre->ViewValue = $usuario->nombre->CurrentValue;
			$usuario->nombre->CssStyle = "";
			$usuario->nombre->CssClass = "";
			$usuario->nombre->ViewCustomAttributes = "";

			// paterno
			$usuario->paterno->ViewValue = $usuario->paterno->CurrentValue;
			$usuario->paterno->CssStyle = "";
			$usuario->paterno->CssClass = "";
			$usuario->paterno->ViewCustomAttributes = "";

			// materno
			$usuario->materno->ViewValue = $usuario->materno->CurrentValue;
			$usuario->materno->CssStyle = "";
			$usuario->materno->CssClass = "";
			$usuario->materno->ViewCustomAttributes = "";

			// ci
			$usuario->ci->ViewValue = $usuario->ci->CurrentValue;
			$usuario->ci->CssStyle = "";
			$usuario->ci->CssClass = "";
			$usuario->ci->ViewCustomAttributes = "";

			// cargo
			$usuario->cargo->ViewValue = $usuario->cargo->CurrentValue;
			$usuario->cargo->CssStyle = "";
			$usuario->cargo->CssClass = "";
			$usuario->cargo->ViewCustomAttributes = "";

			// idUsuario
			$usuario->idUsuario->HrefValue = "";

			// idRol
			$usuario->idRol->HrefValue = "";

			// nombre
			$usuario->nombre->HrefValue = "";

			// paterno
			$usuario->paterno->HrefValue = "";

			// materno
			$usuario->materno->HrefValue = "";

			// ci
			$usuario->ci->HrefValue = "";

			// cargo
			$usuario->cargo->HrefValue = "";
		}

		// Call Row Rendered event
		$usuario->Row_Rendered();
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
