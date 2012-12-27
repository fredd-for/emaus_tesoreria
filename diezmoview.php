<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "diezmoinfo.php" ?>
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
$diezmo_view = new cdiezmo_view();
$Page =& $diezmo_view;

// Page init processing
$diezmo_view->Page_Init();

// Page main processing
$diezmo_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($diezmo->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var diezmo_view = new ew_Page("diezmo_view");

// page properties
diezmo_view.PageID = "view"; // page ID
var EW_PAGE_ID = diezmo_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
diezmo_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
diezmo_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
diezmo_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Diezmo
<br><br>
<?php if ($diezmo->Export == "") { ?>
<a href="diezmolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $diezmo->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $diezmo->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $diezmo->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $diezmo_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($diezmo->idDiezmo->Visible) { // idDiezmo ?>
	<tr<?php echo $diezmo->idDiezmo->RowAttributes ?>>
		<td class="ewTableHeader">Nro</td>
		<td<?php echo $diezmo->idDiezmo->CellAttributes() ?>>
<div<?php echo $diezmo->idDiezmo->ViewAttributes() ?>><?php echo $diezmo->idDiezmo->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($diezmo->idMiembro->Visible) { // idMiembro ?>
	<tr<?php echo $diezmo->idMiembro->RowAttributes ?>>
		<td class="ewTableHeader">Id Miembro</td>
		<td<?php echo $diezmo->idMiembro->CellAttributes() ?>>
<div<?php echo $diezmo->idMiembro->ViewAttributes() ?>><?php echo $diezmo->idMiembro->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($diezmo->fecha->Visible) { // fecha ?>
	<tr<?php echo $diezmo->fecha->RowAttributes ?>>
		<td class="ewTableHeader">Fecha</td>
		<td<?php echo $diezmo->fecha->CellAttributes() ?>>
<div<?php echo $diezmo->fecha->ViewAttributes() ?>><?php echo $diezmo->fecha->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($diezmo->montoDiezmo->Visible) { // montoDiezmo ?>
	<tr<?php echo $diezmo->montoDiezmo->RowAttributes ?>>
		<td class="ewTableHeader">Monto Diezmo</td>
		<td<?php echo $diezmo->montoDiezmo->CellAttributes() ?>>
<div<?php echo $diezmo->montoDiezmo->ViewAttributes() ?>><?php echo $diezmo->montoDiezmo->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($diezmo->Export == "") { ?>
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
class cdiezmo_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'diezmo';

	// Page Object Name
	var $PageObjName = 'diezmo_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $diezmo;
		if ($diezmo->UseTokenInUrl) $PageUrl .= "t=" . $diezmo->TableVar . "&"; // add page token
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
		global $objForm, $diezmo;
		if ($diezmo->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($diezmo->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($diezmo->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdiezmo_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["diezmo"] = new cdiezmo();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'diezmo', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $diezmo;
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
			$this->Page_Terminate("diezmolist.php");
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
		global $diezmo;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idDiezmo"] <> "") {
				$diezmo->idDiezmo->setQueryStringValue($_GET["idDiezmo"]);
			} else {
				$sReturnUrl = "diezmolist.php"; // Return to list
			}

			// Get action
			$diezmo->CurrentAction = "I"; // Display form
			switch ($diezmo->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "diezmolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "diezmolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$diezmo->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $diezmo;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$diezmo->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$diezmo->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $diezmo->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$diezmo->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$diezmo->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$diezmo->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $diezmo;
		$sFilter = $diezmo->KeyFilter();

		// Call Row Selecting event
		$diezmo->Row_Selecting($sFilter);

		// Load sql based on filter
		$diezmo->CurrentFilter = $sFilter;
		$sSql = $diezmo->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$diezmo->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $diezmo;
		$diezmo->idDiezmo->setDbValue($rs->fields('idDiezmo'));
		$diezmo->idMiembro->setDbValue($rs->fields('idMiembro'));
		$diezmo->fecha->setDbValue($rs->fields('fecha'));
		$diezmo->montoDiezmo->setDbValue($rs->fields('montoDiezmo'));
		$diezmo->monto2->setDbValue($rs->fields('monto2'));
		$diezmo->monto3->setDbValue($rs->fields('monto3'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $diezmo;

		// Call Row_Rendering event
		$diezmo->Row_Rendering();

		// Common render codes for all row types
		// idDiezmo

		$diezmo->idDiezmo->CellCssStyle = "";
		$diezmo->idDiezmo->CellCssClass = "";

		// idMiembro
		$diezmo->idMiembro->CellCssStyle = "";
		$diezmo->idMiembro->CellCssClass = "";

		// fecha
		$diezmo->fecha->CellCssStyle = "";
		$diezmo->fecha->CellCssClass = "";

		// montoDiezmo
		$diezmo->montoDiezmo->CellCssStyle = "";
		$diezmo->montoDiezmo->CellCssClass = "";
		if ($diezmo->RowType == EW_ROWTYPE_VIEW) { // View row

			// idDiezmo
			$diezmo->idDiezmo->ViewValue = $diezmo->idDiezmo->CurrentValue;
			$diezmo->idDiezmo->CssStyle = "";
			$diezmo->idDiezmo->CssClass = "";
			$diezmo->idDiezmo->ViewCustomAttributes = "";

			// idMiembro
			$diezmo->idMiembro->ViewValue = $diezmo->idMiembro->CurrentValue;
			$diezmo->idMiembro->CssStyle = "";
			$diezmo->idMiembro->CssClass = "";
			$diezmo->idMiembro->ViewCustomAttributes = "";

			// fecha
			$diezmo->fecha->ViewValue = $diezmo->fecha->CurrentValue;
			$diezmo->fecha->ViewValue = ew_FormatDateTime($diezmo->fecha->ViewValue, 7);
			$diezmo->fecha->CssStyle = "";
			$diezmo->fecha->CssClass = "";
			$diezmo->fecha->ViewCustomAttributes = "";

			// montoDiezmo
			$diezmo->montoDiezmo->ViewValue = $diezmo->montoDiezmo->CurrentValue;
			$diezmo->montoDiezmo->CssStyle = "";
			$diezmo->montoDiezmo->CssClass = "";
			$diezmo->montoDiezmo->ViewCustomAttributes = "";

			// idDiezmo
			$diezmo->idDiezmo->HrefValue = "";

			// idMiembro
			$diezmo->idMiembro->HrefValue = "";

			// fecha
			$diezmo->fecha->HrefValue = "";

			// montoDiezmo
			$diezmo->montoDiezmo->HrefValue = "";
		}

		// Call Row Rendered event
		$diezmo->Row_Rendered();
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
