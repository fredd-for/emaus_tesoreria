<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "permisoinfo.php" ?>
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
$permiso_view = new cpermiso_view();
$Page =& $permiso_view;

// Page init processing
$permiso_view->Page_Init();

// Page main processing
$permiso_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($permiso->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var permiso_view = new ew_Page("permiso_view");

// page properties
permiso_view.PageID = "view"; // page ID
var EW_PAGE_ID = permiso_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
permiso_view.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
permiso_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
permiso_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Ver TABLA: Permiso
<br><br>
<?php if ($permiso->Export == "") { ?>
<a href="permisolist.php">Volver al listado</a>&nbsp;
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $permiso->AddUrl() ?>">Adicionar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<a href="<?php echo $permiso->EditUrl() ?>">Editar</a>&nbsp;
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<a onclick="return ew_Confirm('¿Quiere borrar este registro?');" href="<?php echo $permiso->DeleteUrl() ?>">Borrar</a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php $permiso_view->ShowMessage() ?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($permiso->idRol->Visible) { // idRol ?>
	<tr<?php echo $permiso->idRol->RowAttributes ?>>
		<td class="ewTableHeader">Id Rol</td>
		<td<?php echo $permiso->idRol->CellAttributes() ?>>
<div<?php echo $permiso->idRol->ViewAttributes() ?>><?php echo $permiso->idRol->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($permiso->nombre->Visible) { // nombre ?>
	<tr<?php echo $permiso->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre</td>
		<td<?php echo $permiso->nombre->CellAttributes() ?>>
<div<?php echo $permiso->nombre->ViewAttributes() ?>><?php echo $permiso->nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($permiso->permiso->Visible) { // permiso ?>
	<tr<?php echo $permiso->permiso->RowAttributes ?>>
		<td class="ewTableHeader">Permiso</td>
		<td<?php echo $permiso->permiso->CellAttributes() ?>>
<div<?php echo $permiso->permiso->ViewAttributes() ?>><?php echo $permiso->permiso->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($permiso->Export == "") { ?>
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
class cpermiso_view {

	// Page ID
	var $PageID = 'view';

	// Table Name
	var $TableName = 'permiso';

	// Page Object Name
	var $PageObjName = 'permiso_view';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $permiso;
		if ($permiso->UseTokenInUrl) $PageUrl .= "t=" . $permiso->TableVar . "&"; // add page token
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
		global $objForm, $permiso;
		if ($permiso->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($permiso->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($permiso->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cpermiso_view() {
		global $conn;

		// Initialize table object
		$GLOBALS["permiso"] = new cpermiso();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'permiso', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $permiso;
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
		global $permiso;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idRol"] <> "") {
				$permiso->idRol->setQueryStringValue($_GET["idRol"]);
			} else {
				$sReturnUrl = "permisolist.php"; // Return to list
			}
			if (@$_GET["nombre"] <> "") {
				$permiso->nombre->setQueryStringValue($_GET["nombre"]);
			} else {
				$sReturnUrl = "permisolist.php"; // Return to list
			}

			// Get action
			$permiso->CurrentAction = "I"; // Display form
			switch ($permiso->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage("No se encontraron registros"); // Set no record message
						$sReturnUrl = "permisolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "permisolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$permiso->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $permiso;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$permiso->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$permiso->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $permiso->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$permiso->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$permiso->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$permiso->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $permiso;
		$sFilter = $permiso->KeyFilter();

		// Call Row Selecting event
		$permiso->Row_Selecting($sFilter);

		// Load sql based on filter
		$permiso->CurrentFilter = $sFilter;
		$sSql = $permiso->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$permiso->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $permiso;
		$permiso->idRol->setDbValue($rs->fields('idRol'));
		$permiso->nombre->setDbValue($rs->fields('nombre'));
		$permiso->permiso->setDbValue($rs->fields('permiso'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $permiso;

		// Call Row_Rendering event
		$permiso->Row_Rendering();

		// Common render codes for all row types
		// idRol

		$permiso->idRol->CellCssStyle = "";
		$permiso->idRol->CellCssClass = "";

		// nombre
		$permiso->nombre->CellCssStyle = "";
		$permiso->nombre->CellCssClass = "";

		// permiso
		$permiso->permiso->CellCssStyle = "";
		$permiso->permiso->CellCssClass = "";
		if ($permiso->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRol
			$permiso->idRol->ViewValue = $permiso->idRol->CurrentValue;
			$permiso->idRol->CssStyle = "";
			$permiso->idRol->CssClass = "";
			$permiso->idRol->ViewCustomAttributes = "";

			// nombre
			$permiso->nombre->ViewValue = $permiso->nombre->CurrentValue;
			$permiso->nombre->CssStyle = "";
			$permiso->nombre->CssClass = "";
			$permiso->nombre->ViewCustomAttributes = "";

			// permiso
			$permiso->permiso->ViewValue = $permiso->permiso->CurrentValue;
			$permiso->permiso->CssStyle = "";
			$permiso->permiso->CssClass = "";
			$permiso->permiso->ViewCustomAttributes = "";

			// idRol
			$permiso->idRol->HrefValue = "";

			// nombre
			$permiso->nombre->HrefValue = "";

			// permiso
			$permiso->permiso->HrefValue = "";
		}

		// Call Row Rendered event
		$permiso->Row_Rendered();
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
