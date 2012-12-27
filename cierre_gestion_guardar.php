<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cierre_gestioninfo.php" ?>
<?php include "userfn6.php" ?>
<?php include "Connections/conexion.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$cierre_gestion_list = new ccierre_gestion_list();
$Page =& $cierre_gestion_list;

// Page init processing
$cierre_gestion_list->Page_Init();

// Page main processing
$cierre_gestion_list->Page_Main();
?>

<?php 
if($_POST['guardar']){

$fechaOnly = explode ("-",$_POST['fi']);
$fi=date("Y-m-d", mktime(0, 0, 0, $fechaOnly[1], $fechaOnly[0], $fechaOnly[2])); 

$fechaOnly = explode ("-",$_POST['ff']);
$ff=date("Y-m-d", mktime(0, 0, 0, $fechaOnly[1], $fechaOnly[0], $fechaOnly[2])); 

mysql_select_db($database_conexion, $conexion);
$query = "UPDATE saldo_cuenta SET estado = 2 WHERE fecha BETWEEN '".$fi."' AND '".date("Y-m-d", strtotime("$ff + 1 day"))."'";
$mostrar= mysql_query($query, $conexion) or die(mysql_error());

mysql_select_db($database_conexion, $conexion);
$query = "UPDATE diezmo SET estado = 2 WHERE fecha BETWEEN '".$fi."' AND '".date("Y-m-d", strtotime("$ff + 1 day"))."'";
$mostrar= mysql_query($query, $conexion) or die(mysql_error());
}
Header("Location: cierre_gestionlist.php");

?>

<?php

//
// Page Class
//
class ccierre_gestion_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'cierre_gestion';

	// Page Object Name
	var $PageObjName = 'cierre_gestion_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cierre_gestion;
		if ($cierre_gestion->UseTokenInUrl) $PageUrl .= "t=" . $cierre_gestion->TableVar . "&"; // add page token
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
		global $objForm, $cierre_gestion;
		if ($cierre_gestion->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cierre_gestion->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cierre_gestion->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccierre_gestion_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["cierre_gestion"] = new ccierre_gestion();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cierre_gestion', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cierre_gestion;
	$cierre_gestion->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $cierre_gestion->Export; // Get export parameter, used in header
	$gsExportFile = $cierre_gestion->TableVar; // Get export file, used in header
	if ($cierre_gestion->Export == "excel") {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
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
	var $sSrchWhere;
	var $lRecCnt;
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex;
	var $lOptionCnt;
	var $lRecPerRow;
	var $lColCnt;
	var $sDeleteConfirmMsg; // Delete confirm message
	var $sDbMasterFilter;
	var $sDbDetailFilter;
	var $bMasterRecordExists;	
	var $ListOptions;
	var $sMultiSelectKey;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $Security, $cierre_gestion;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
		$this->sDeleteConfirmMsg = "�Quiere borrar este registro?"; // Delete confirm message

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page dynamically
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($cierre_gestion->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $cierre_gestion->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$cierre_gestion->setSessionWhere($sFilter);
		$cierre_gestion->CurrentFilter = "";

		// Export data only
		if (in_array($cierre_gestion->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $cierre_gestion;
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->lDisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->lDisplayRecs = -1;
				} else {
					$this->lDisplayRecs = 20; // Non-numeric, load default
				}
			}
			$cierre_gestion->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$cierre_gestion->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $cierre_gestion;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$cierre_gestion->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cierre_gestion->CurrentOrderType = @$_GET["ordertype"];
			$cierre_gestion->UpdateSort($cierre_gestion->idCuenta); // Field 
			$cierre_gestion->UpdateSort($cierre_gestion->cuenta); // Field 
			$cierre_gestion->UpdateSort($cierre_gestion->saldo); // Field 
			$cierre_gestion->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $cierre_gestion;
		$sOrderBy = $cierre_gestion->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($cierre_gestion->SqlOrderBy() <> "") {
				$sOrderBy = $cierre_gestion->SqlOrderBy();
				$cierre_gestion->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $cierre_gestion;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cierre_gestion->setSessionOrderBy($sOrderBy);
				$cierre_gestion->idCuenta->setSort("");
				$cierre_gestion->cuenta->setSort("");
				$cierre_gestion->saldo->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$cierre_gestion->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $cierre_gestion;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cierre_gestion->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cierre_gestion->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cierre_gestion->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cierre_gestion->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cierre_gestion->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cierre_gestion->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cierre_gestion;

		// Call Recordset Selecting event
		$cierre_gestion->Recordset_Selecting($cierre_gestion->CurrentFilter);

		// Load list page SQL
		$sSql = $cierre_gestion->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$cierre_gestion->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cierre_gestion;
		$sFilter = $cierre_gestion->KeyFilter();

		// Call Row Selecting event
		$cierre_gestion->Row_Selecting($sFilter);

		// Load sql based on filter
		$cierre_gestion->CurrentFilter = $sFilter;
		$sSql = $cierre_gestion->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cierre_gestion->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cierre_gestion;
		$cierre_gestion->idCuenta->setDbValue($rs->fields('idCuenta'));
		$cierre_gestion->cuenta->setDbValue($rs->fields('cuenta'));
		$cierre_gestion->porcentaje->setDbValue($rs->fields('porcentaje'));
		$cierre_gestion->saldo->setDbValue($rs->fields('saldo'));
		$cierre_gestion->estado->setDbValue($rs->fields('estado'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cierre_gestion;

		// Call Row_Rendering event
		$cierre_gestion->Row_Rendering();

		// Common render codes for all row types
		// idCuenta

		$cierre_gestion->idCuenta->CellCssStyle = "";
		$cierre_gestion->idCuenta->CellCssClass = "";

		// cuenta
		$cierre_gestion->cuenta->CellCssStyle = "";
		$cierre_gestion->cuenta->CellCssClass = "";

		// saldo
		$cierre_gestion->saldo->CellCssStyle = "";
		$cierre_gestion->saldo->CellCssClass = "";
		if ($cierre_gestion->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCuenta
			$cierre_gestion->idCuenta->ViewValue = $cierre_gestion->idCuenta->CurrentValue;
			$cierre_gestion->idCuenta->CssStyle = "";
			$cierre_gestion->idCuenta->CssClass = "";
			$cierre_gestion->idCuenta->ViewCustomAttributes = "";

			// cuenta
			$cierre_gestion->cuenta->ViewValue = $cierre_gestion->cuenta->CurrentValue;
			$cierre_gestion->cuenta->CssStyle = "";
			$cierre_gestion->cuenta->CssClass = "";
			$cierre_gestion->cuenta->ViewCustomAttributes = "";

			// saldo
			$cierre_gestion->saldo->ViewValue = $cierre_gestion->saldo->CurrentValue;
			$cierre_gestion->saldo->CssStyle = "";
			$cierre_gestion->saldo->CssClass = "";
			$cierre_gestion->saldo->ViewCustomAttributes = "";

			// idCuenta
			$cierre_gestion->idCuenta->HrefValue = "";

			// cuenta
			$cierre_gestion->cuenta->HrefValue = "";

			// saldo
			$cierre_gestion->saldo->HrefValue = "";
		}

		// Call Row Rendered event
		$cierre_gestion->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $cierre_gestion;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($cierre_gestion->ExportAll) {
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export 1 page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($cierre_gestion->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($cierre_gestion->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $cierre_gestion->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idCuenta', $cierre_gestion->Export);
				ew_ExportAddValue($sExportStr, 'saldo', $cierre_gestion->Export);
				echo ew_ExportLine($sExportStr, $cierre_gestion->Export);
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row for display
				$cierre_gestion->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($cierre_gestion->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idCuenta', $cierre_gestion->idCuenta->CurrentValue);
					$XmlDoc->AddField('saldo', $cierre_gestion->saldo->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $cierre_gestion->Export <> "csv") { // Vertical format
						echo ew_ExportField('idCuenta', $cierre_gestion->idCuenta->ExportValue($cierre_gestion->Export, $cierre_gestion->ExportOriginalValue), $cierre_gestion->Export);
						echo ew_ExportField('saldo', $cierre_gestion->saldo->ExportValue($cierre_gestion->Export, $cierre_gestion->ExportOriginalValue), $cierre_gestion->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $cierre_gestion->idCuenta->ExportValue($cierre_gestion->Export, $cierre_gestion->ExportOriginalValue), $cierre_gestion->Export);
						ew_ExportAddValue($sExportStr, $cierre_gestion->saldo->ExportValue($cierre_gestion->Export, $cierre_gestion->ExportOriginalValue), $cierre_gestion->Export);
						echo ew_ExportLine($sExportStr, $cierre_gestion->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($cierre_gestion->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($cierre_gestion->Export);
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
