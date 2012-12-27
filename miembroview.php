<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "miembroinfo.php" ?>
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
$miembro_view = new cmiembro_view();
$Page =& $miembro_view;

// Page init processing
$miembro_view->Page_Init();

// Page main processing
$miembro_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($miembro->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var miembro_view = new ew_Page("miembro_view");

// page properties
miembro_view.PageID = "view"; // page ID
var EW_PAGE_ID = miembro_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
miembro_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
miembro_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
miembro_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Miembro
<br><br>
<?php if ($miembro->Export == "") { ?>
<a href="miembrolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $miembro->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $miembro->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $miembro->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $miembro_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($miembro->idMiembro->Visible) { // idMiembro ?>
	<tr<?php echo $miembro->idMiembro->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $miembro->idMiembro->CellAttributes() ?>>
<div<?php echo $miembro->idMiembro->ViewAttributes() ?>><?php echo $miembro->idMiembro->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($miembro->nombre->Visible) { // nombre ?>
	<tr<?php echo $miembro->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre(s)</td>
		<td<?php echo $miembro->nombre->CellAttributes() ?>>
<div<?php echo $miembro->nombre->ViewAttributes() ?>><?php echo $miembro->nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($miembro->paterno->Visible) { // paterno ?>
	<tr<?php echo $miembro->paterno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Paterno</td>
		<td<?php echo $miembro->paterno->CellAttributes() ?>>
<div<?php echo $miembro->paterno->ViewAttributes() ?>><?php echo $miembro->paterno->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($miembro->materno->Visible) { // materno ?>
	<tr<?php echo $miembro->materno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Materno</td>
		<td<?php echo $miembro->materno->CellAttributes() ?>>
<div<?php echo $miembro->materno->ViewAttributes() ?>><?php echo $miembro->materno->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($miembro->cargo->Visible) { // cargo ?>
	<tr<?php echo $miembro->cargo->RowAttributes ?>>
		<td class="ewTableHeader">Cargo en la Iglesia</td>
		<td<?php echo $miembro->cargo->CellAttributes() ?>>
<div<?php echo $miembro->cargo->ViewAttributes() ?>><?php echo $miembro->cargo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($miembro->diezma->Visible) { // diezma ?>
	<tr<?php echo $miembro->diezma->RowAttributes ?>>
		<td class="ewTableHeader">Diezma</td>
		<td<?php echo $miembro->diezma->CellAttributes() ?>>
<div<?php echo $miembro->diezma->ViewAttributes() ?>><?php echo $miembro->diezma->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($miembro->Export == "") { ?>
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
class cmiembro_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'miembro';

	// Page Object Name
	var $PageObjName = 'miembro_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $miembro;
		if ($miembro->UseTokenInUrl) $PageUrl .= "t=" . $miembro->TableVar . "&"; // add page token
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
		global $objForm, $miembro;
		if ($miembro->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($miembro->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($miembro->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cmiembro_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["miembro"] = new cmiembro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'miembro', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $miembro;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();

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
		global $miembro;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idMiembro"] <> "") {
				$miembro->idMiembro->setQueryStringValue($_GET["idMiembro"]);
			} else {
				$sReturnUrl = "miembrolist.php"; // Return to list
			}

			// Get action
			$miembro->CurrentAction = "I"; // Display form
			switch ($miembro->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "miembrolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "miembrolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$miembro->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $miembro;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$miembro->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$miembro->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $miembro->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$miembro->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$miembro->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$miembro->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $miembro;
		$sFilter = $miembro->KeyFilter();

		// Call Row Selecting event
		$miembro->Row_Selecting($sFilter);

		// Load sql based on filter
		$miembro->CurrentFilter = $sFilter;
		$sSql = $miembro->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$miembro->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $miembro;
		$miembro->idMiembro->setDbValue($rs->fields('idMiembro'));
		$miembro->nombre->setDbValue($rs->fields('nombre'));
		$miembro->paterno->setDbValue($rs->fields('paterno'));
		$miembro->materno->setDbValue($rs->fields('materno'));
		$miembro->cargo->setDbValue($rs->fields('cargo'));
		$miembro->diezma->setDbValue($rs->fields('diezma'));
		$miembro->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$miembro->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $miembro;

		// Call Row_Rendering event
		$miembro->Row_Rendering();

		// Common render codes for all row types
		// idMiembro

		$miembro->idMiembro->CellCssStyle = "";
		$miembro->idMiembro->CellCssClass = "";

		// nombre
		$miembro->nombre->CellCssStyle = "";
		$miembro->nombre->CellCssClass = "";

		// paterno
		$miembro->paterno->CellCssStyle = "";
		$miembro->paterno->CellCssClass = "";

		// materno
		$miembro->materno->CellCssStyle = "";
		$miembro->materno->CellCssClass = "";

		// cargo
		$miembro->cargo->CellCssStyle = "";
		$miembro->cargo->CellCssClass = "";

		// diezma
		$miembro->diezma->CellCssStyle = "";
		$miembro->diezma->CellCssClass = "";
		if ($miembro->RowType == EW_ROWTYPE_VIEW) { // View row

			// idMiembro
			$miembro->idMiembro->ViewValue = $miembro->idMiembro->CurrentValue;
			$miembro->idMiembro->CssStyle = "";
			$miembro->idMiembro->CssClass = "";
			$miembro->idMiembro->ViewCustomAttributes = "";

			// nombre
			$miembro->nombre->ViewValue = $miembro->nombre->CurrentValue;
			$miembro->nombre->CssStyle = "";
			$miembro->nombre->CssClass = "";
			$miembro->nombre->ViewCustomAttributes = "";

			// paterno
			$miembro->paterno->ViewValue = $miembro->paterno->CurrentValue;
			$miembro->paterno->CssStyle = "";
			$miembro->paterno->CssClass = "";
			$miembro->paterno->ViewCustomAttributes = "";

			// materno
			$miembro->materno->ViewValue = $miembro->materno->CurrentValue;
			$miembro->materno->CssStyle = "";
			$miembro->materno->CssClass = "";
			$miembro->materno->ViewCustomAttributes = "";

			// cargo
			$miembro->cargo->ViewValue = $miembro->cargo->CurrentValue;
			$miembro->cargo->CssStyle = "";
			$miembro->cargo->CssClass = "";
			$miembro->cargo->ViewCustomAttributes = "";

			// diezma
			if (strval($miembro->diezma->CurrentValue) <> "") {
				switch ($miembro->diezma->CurrentValue) {
					case "1":
						$miembro->diezma->ViewValue = "SI";
						break;
					case "0":
						$miembro->diezma->ViewValue = "NO";
						break;
					default:
						$miembro->diezma->ViewValue = $miembro->diezma->CurrentValue;
				}
			} else {
				$miembro->diezma->ViewValue = NULL;
			}
			$miembro->diezma->CssStyle = "";
			$miembro->diezma->CssClass = "";
			$miembro->diezma->ViewCustomAttributes = "";

			// idMiembro
			$miembro->idMiembro->HrefValue = "";

			// nombre
			$miembro->nombre->HrefValue = "";

			// paterno
			$miembro->paterno->HrefValue = "";

			// materno
			$miembro->materno->HrefValue = "";

			// cargo
			$miembro->cargo->HrefValue = "";

			// diezma
			$miembro->diezma->HrefValue = "";
		}

		// Call Row Rendered event
		$miembro->Row_Rendered();
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
