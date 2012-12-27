<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cuentainfo.php" ?>
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
$cuenta_view = new ccuenta_view();
$Page =& $cuenta_view;

// Page init processing
$cuenta_view->Page_Init();

// Page main processing
$cuenta_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cuenta->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cuenta_view = new ew_Page("cuenta_view");

// page properties
cuenta_view.PageID = "view"; // page ID
var EW_PAGE_ID = cuenta_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cuenta_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cuenta_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cuenta_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Cuenta
<br><br>
<?php if ($cuenta->Export == "") { ?>
<a href="cuentalist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $cuenta->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $cuenta->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $cuenta->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $cuenta_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cuenta->idCuenta->Visible) { // idCuenta ?>
	<tr<?php echo $cuenta->idCuenta->RowAttributes ?>>
		<td class="ewTableHeader">Nro</td>
		<td<?php echo $cuenta->idCuenta->CellAttributes() ?>>
<div<?php echo $cuenta->idCuenta->ViewAttributes() ?>><?php echo $cuenta->idCuenta->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cuenta->cuenta->Visible) { // cuenta ?>
	<tr<?php echo $cuenta->cuenta->RowAttributes ?>>
		<td class="ewTableHeader">Cuenta</td>
		<td<?php echo $cuenta->cuenta->CellAttributes() ?>>
<div<?php echo $cuenta->cuenta->ViewAttributes() ?>><?php echo $cuenta->cuenta->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cuenta->porcentaje->Visible) { // porcentaje ?>
	<tr<?php echo $cuenta->porcentaje->RowAttributes ?>>
		<td class="ewTableHeader">Porcentaje</td>
		<td<?php echo $cuenta->porcentaje->CellAttributes() ?>>
<div<?php echo $cuenta->porcentaje->ViewAttributes() ?>><?php echo $cuenta->porcentaje->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cuenta->estado->Visible) { // estado ?>
	<tr<?php echo $cuenta->estado->RowAttributes ?>>
		<td class="ewTableHeader">Estado</td>
		<td<?php echo $cuenta->estado->CellAttributes() ?>>
<div<?php echo $cuenta->estado->ViewAttributes() ?>><?php echo $cuenta->estado->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cuenta->fechaCreacion->Visible) { // fechaCreacion ?>
	<tr<?php echo $cuenta->fechaCreacion->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Creacion</td>
		<td<?php echo $cuenta->fechaCreacion->CellAttributes() ?>>
<div<?php echo $cuenta->fechaCreacion->ViewAttributes() ?>><?php echo $cuenta->fechaCreacion->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cuenta->fechaModificacion->Visible) { // fechaModificacion ?>
	<tr<?php echo $cuenta->fechaModificacion->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Modificacion</td>
		<td<?php echo $cuenta->fechaModificacion->CellAttributes() ?>>
<div<?php echo $cuenta->fechaModificacion->ViewAttributes() ?>><?php echo $cuenta->fechaModificacion->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($cuenta->Export == "") { ?>
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
class ccuenta_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'cuenta';

	// Page Object Name
	var $PageObjName = 'cuenta_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cuenta;
		if ($cuenta->UseTokenInUrl) $PageUrl .= "t=" . $cuenta->TableVar . "&"; // add page token
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
		global $objForm, $cuenta;
		if ($cuenta->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cuenta->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cuenta->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccuenta_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["cuenta"] = new ccuenta();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cuenta;
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
			$this->Page_Terminate("cuentalist.php");
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
		global $cuenta;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idCuenta"] <> "") {
				$cuenta->idCuenta->setQueryStringValue($_GET["idCuenta"]);
			} else {
				$sReturnUrl = "cuentalist.php"; // Return to list
			}

			// Get action
			$cuenta->CurrentAction = "I"; // Display form
			switch ($cuenta->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "cuentalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "cuentalist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$cuenta->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $cuenta;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cuenta->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cuenta->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cuenta->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cuenta->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cuenta->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cuenta->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cuenta;
		$sFilter = $cuenta->KeyFilter();

		// Call Row Selecting event
		$cuenta->Row_Selecting($sFilter);

		// Load sql based on filter
		$cuenta->CurrentFilter = $sFilter;
		$sSql = $cuenta->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cuenta->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cuenta;
		$cuenta->idCuenta->setDbValue($rs->fields('idCuenta'));
		$cuenta->cuenta->setDbValue($rs->fields('cuenta'));
		$cuenta->porcentaje->setDbValue($rs->fields('porcentaje'));
		$cuenta->estado->setDbValue($rs->fields('estado'));
		$cuenta->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$cuenta->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cuenta;

		// Call Row_Rendering event
		$cuenta->Row_Rendering();

		// Common render codes for all row types
		// idCuenta

		$cuenta->idCuenta->CellCssStyle = "";
		$cuenta->idCuenta->CellCssClass = "";

		// cuenta
		$cuenta->cuenta->CellCssStyle = "";
		$cuenta->cuenta->CellCssClass = "";

		// porcentaje
		$cuenta->porcentaje->CellCssStyle = "";
		$cuenta->porcentaje->CellCssClass = "";

		// estado
		$cuenta->estado->CellCssStyle = "";
		$cuenta->estado->CellCssClass = "";

		// fechaCreacion
		$cuenta->fechaCreacion->CellCssStyle = "";
		$cuenta->fechaCreacion->CellCssClass = "";

		// fechaModificacion
		$cuenta->fechaModificacion->CellCssStyle = "";
		$cuenta->fechaModificacion->CellCssClass = "";
		if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCuenta
			$cuenta->idCuenta->ViewValue = $cuenta->idCuenta->CurrentValue;
			$cuenta->idCuenta->CssStyle = "";
			$cuenta->idCuenta->CssClass = "";
			$cuenta->idCuenta->ViewCustomAttributes = "";

			// cuenta
			$cuenta->cuenta->ViewValue = $cuenta->cuenta->CurrentValue;
			$cuenta->cuenta->CssStyle = "";
			$cuenta->cuenta->CssClass = "";
			$cuenta->cuenta->ViewCustomAttributes = "";

			// porcentaje
			$cuenta->porcentaje->ViewValue = $cuenta->porcentaje->CurrentValue;
			$cuenta->porcentaje->CssStyle = "";
			$cuenta->porcentaje->CssClass = "";
			$cuenta->porcentaje->ViewCustomAttributes = "";

			// estado
			$cuenta->estado->ViewValue = $cuenta->estado->CurrentValue;
			$cuenta->estado->CssStyle = "";
			$cuenta->estado->CssClass = "";
			$cuenta->estado->ViewCustomAttributes = "";

			// fechaCreacion
			$cuenta->fechaCreacion->ViewValue = $cuenta->fechaCreacion->CurrentValue;
			$cuenta->fechaCreacion->ViewValue = ew_FormatDateTime($cuenta->fechaCreacion->ViewValue, 7);
			$cuenta->fechaCreacion->CssStyle = "";
			$cuenta->fechaCreacion->CssClass = "";
			$cuenta->fechaCreacion->ViewCustomAttributes = "";

			// fechaModificacion
			$cuenta->fechaModificacion->ViewValue = $cuenta->fechaModificacion->CurrentValue;
			$cuenta->fechaModificacion->ViewValue = ew_FormatDateTime($cuenta->fechaModificacion->ViewValue, 7);
			$cuenta->fechaModificacion->CssStyle = "";
			$cuenta->fechaModificacion->CssClass = "";
			$cuenta->fechaModificacion->ViewCustomAttributes = "";

			// idCuenta
			$cuenta->idCuenta->HrefValue = "";

			// cuenta
			$cuenta->cuenta->HrefValue = "";

			// porcentaje
			$cuenta->porcentaje->HrefValue = "";

			// estado
			$cuenta->estado->HrefValue = "";

			// fechaCreacion
			$cuenta->fechaCreacion->HrefValue = "";

			// fechaModificacion
			$cuenta->fechaModificacion->HrefValue = "";
		}

		// Call Row Rendered event
		$cuenta->Row_Rendered();
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
