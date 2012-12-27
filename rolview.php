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
$rol_view = new crol_view();
$Page =& $rol_view;

// Page init processing
$rol_view->Page_Init();

// Page main processing
$rol_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($rol->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var rol_view = new ew_Page("rol_view");

// page properties
rol_view.PageID = "view"; // page ID
var EW_PAGE_ID = rol_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
rol_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rol_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rol_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Rol
<br><br>
<?php if ($rol->Export == "") { ?>
<a href="rollist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $rol->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $rol->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $rol->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $rol_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($rol->idRol->Visible) { // idRol ?>
	<tr<?php echo $rol->idRol->RowAttributes ?>>
		<td class="ewTableHeader">Id Rol</td>
		<td<?php echo $rol->idRol->CellAttributes() ?>>
<div<?php echo $rol->idRol->ViewAttributes() ?>><?php echo $rol->idRol->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($rol->nombre->Visible) { // nombre ?>
	<tr<?php echo $rol->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre</td>
		<td<?php echo $rol->nombre->CellAttributes() ?>>
<div<?php echo $rol->nombre->ViewAttributes() ?>><?php echo $rol->nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($rol->Export == "") { ?>
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
class crol_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'rol';

	// Page Object Name
	var $PageObjName = 'rol_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $rol;
		if ($rol->UseTokenInUrl) $PageUrl .= "t=" . $rol->TableVar . "&"; // add page token
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
		global $objForm, $rol;
		if ($rol->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($rol->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($rol->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function crol_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["rol"] = new crol();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rol', TRUE);

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
		$Security->LoadCurrentUserLevel($this->TableName);
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
		global $rol;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idRol"] <> "") {
				$rol->idRol->setQueryStringValue($_GET["idRol"]);
			} else {
				$sReturnUrl = "rollist.php"; // Return to list
			}

			// Get action
			$rol->CurrentAction = "I"; // Display form
			switch ($rol->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "rollist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "rollist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$rol->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $rol;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$rol->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$rol->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $rol->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$rol->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$rol->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$rol->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $rol;
		$sFilter = $rol->KeyFilter();

		// Call Row Selecting event
		$rol->Row_Selecting($sFilter);

		// Load sql based on filter
		$rol->CurrentFilter = $sFilter;
		$sSql = $rol->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$rol->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $rol;
		$rol->idRol->setDbValue($rs->fields('idRol'));
		if (is_null($rol->idRol->CurrentValue)) {
			$rol->idRol->CurrentValue = 0;
		} else {
			$rol->idRol->CurrentValue = intval($rol->idRol->CurrentValue);
		}
		$rol->nombre->setDbValue($rs->fields('nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $rol;

		// Call Row_Rendering event
		$rol->Row_Rendering();

		// Common render codes for all row types
		// idRol

		$rol->idRol->CellCssStyle = "";
		$rol->idRol->CellCssClass = "";

		// nombre
		$rol->nombre->CellCssStyle = "";
		$rol->nombre->CellCssClass = "";
		if ($rol->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRol
			$rol->idRol->ViewValue = $rol->idRol->CurrentValue;
			$rol->idRol->CssStyle = "";
			$rol->idRol->CssClass = "";
			$rol->idRol->ViewCustomAttributes = "";

			// nombre
			$rol->nombre->ViewValue = $rol->nombre->CurrentValue;
			$rol->nombre->CssStyle = "";
			$rol->nombre->CssClass = "";
			$rol->nombre->ViewCustomAttributes = "";

			// idRol
			$rol->idRol->HrefValue = "";

			// nombre
			$rol->nombre->HrefValue = "";
		}

		// Call Row Rendered event
		$rol->Row_Rendered();
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
