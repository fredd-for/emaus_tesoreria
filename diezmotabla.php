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
$diezmo_list = new cdiezmo_list();
$Page =& $diezmo_list;

// Page init processing
$diezmo_list->Page_Init();

// Page main processing
$diezmo_list->Page_Main();
?>
<script type="text/javascript">
    $(function () {
        $('input#id_search').quicksearch('table table#table_example #contenidoTbody tr');
    });
</script>
<?php
mysql_select_db($database_conexion, $conexion);
$query_miembro = "SELECT * FROM miembro WHERE diezma=1 ORDER BY paterno, materno, nombre asc";
$mostrar_miembro= mysql_query($query_miembro, $conexion) or die(mysql_error());
$total_miembro= mysql_num_rows($mostrar_miembro);
//echo $_GET['x_fecha'];
$fechaExplode = explode("-", $_GET['x_fecha']);
$x_fecha = date("Y-m-d",mktime(0,0,0,$fechaExplode[1], $fechaExplode[0], $fechaExplode[2]));
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div>
        <fieldset>
            BUSCAR= <input type="text" name="search" value="" id="id_search" size="50"/>
        </fieldset>

</div>
            <div class="ewGridMiddlePanel">
<form name="fdiezmolist" id="fdiezmolist" class="ewForm" action="diezmo_guardar.php" method="post">
<table id="table_example" cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<thead><!-- Table header -->
	<tr class="ewTableHeader">
            <td>No</td>
            <td>Apellidos y Nombres</td>
            <td>Diezmo</td>
            <td>TOTAL</td>
        </tr>
</thead>
<tbody id="contenidoTbody">
<?php
$contador=1;
While($row_miembro=mysql_fetch_assoc($mostrar_miembro)){
mysql_select_db($database_conexion, $conexion);
$query_diezmo = "SELECT montoDiezmo FROM diezmo WHERE idMiembro='".$row_miembro['idMiembro']."' AND fecha='".$x_fecha."'";
$mostrar_diezmo= mysql_query($query_diezmo, $conexion) or die(mysql_error());
$row_diezmo=mysql_fetch_assoc($mostrar_diezmo);
$total_diezmo= mysql_num_rows($mostrar_diezmo);
    ?>
<tr>
    <td><?php echo $contador ?><input type="hidden" name="x_idMiembro<?php echo $contador?>" id="x_idMiembro<?php echo $contador?>" value="<?php echo $row_miembro['idMiembro']?>"></td>
    <td><?php echo utf8_encode($row_miembro['paterno']." ".$row_miembro['materno'].", ".$row_miembro['nombre']);?></td>
    <td><input type="text" name="x_diezmo<?php echo $contador?>" id="x_diezmo<?php echo $contador?>" size="5" value="<?php echo $row_diezmo['montoDiezmo']?>"></td>
    <td></td>
</tr>
<?php 
$contador++;
}
?>
</tbody>
<tr align="center"><td colspan="4">
<input type="hidden" name="x_contador" value="<?php echo $contador;?>">
<input type="hidden" name="x_fecha" value="<?php echo $x_fecha;?>">
<input type="submit" name="guardar" value="GUARDAR">
    </td></tr>
</table>
</form></div></td></tr></table>

<?php

//
// Page Class
//
class cdiezmo_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'diezmo';

	// Page Object Name
	var $PageObjName = 'diezmo_list';

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
	function cdiezmo_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["diezmo"] = new cdiezmo();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'diezmo', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$diezmo->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $diezmo->Export; // Get export parameter, used in header
	$gsExportFile = $diezmo->TableVar; // Get export file, used in header
	if ($diezmo->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $diezmo;
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
		if ($diezmo->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $diezmo->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList()) {
			$sFilter = "(0=1)"; // Filter all records
		}
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$diezmo->setSessionWhere($sFilter);
		$diezmo->CurrentFilter = "";

		// Export data only
		if (in_array($diezmo->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $diezmo;
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
			$diezmo->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$diezmo->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $diezmo;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$diezmo->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$diezmo->CurrentOrderType = @$_GET["ordertype"];
			$diezmo->UpdateSort($diezmo->idDiezmo); // Field 
			$diezmo->UpdateSort($diezmo->idMiembro); // Field 
			$diezmo->UpdateSort($diezmo->fecha); // Field 
			$diezmo->UpdateSort($diezmo->montoDiezmo); // Field 
			$diezmo->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $diezmo;
		$sOrderBy = $diezmo->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($diezmo->SqlOrderBy() <> "") {
				$sOrderBy = $diezmo->SqlOrderBy();
				$diezmo->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $diezmo;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$diezmo->setSessionOrderBy($sOrderBy);
				$diezmo->idDiezmo->setSort("");
				$diezmo->idMiembro->setSort("");
				$diezmo->fecha->setSort("");
				$diezmo->montoDiezmo->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$diezmo->setStartRecordNumber($this->lStartRec);
		}
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $diezmo;

		// Call Recordset Selecting event
		$diezmo->Recordset_Selecting($diezmo->CurrentFilter);

		// Load list page SQL
		$sSql = $diezmo->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$diezmo->Recordset_Selected($rs);
		return $rs;
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

	// Export data in XML or CSV format
	function ExportData() {
		global $diezmo;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($diezmo->ExportAll) {
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
		if ($diezmo->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($diezmo->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $diezmo->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idDiezmo', $diezmo->Export);
				ew_ExportAddValue($sExportStr, 'idMiembro', $diezmo->Export);
				ew_ExportAddValue($sExportStr, 'fecha', $diezmo->Export);
				ew_ExportAddValue($sExportStr, 'montoDiezmo', $diezmo->Export);
				echo ew_ExportLine($sExportStr, $diezmo->Export);
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
				$diezmo->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($diezmo->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idDiezmo', $diezmo->idDiezmo->CurrentValue);
					$XmlDoc->AddField('idMiembro', $diezmo->idMiembro->CurrentValue);
					$XmlDoc->AddField('fecha', $diezmo->fecha->CurrentValue);
					$XmlDoc->AddField('montoDiezmo', $diezmo->montoDiezmo->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $diezmo->Export <> "csv") { // Vertical format
						echo ew_ExportField('idDiezmo', $diezmo->idDiezmo->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
						echo ew_ExportField('idMiembro', $diezmo->idMiembro->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
						echo ew_ExportField('fecha', $diezmo->fecha->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
						echo ew_ExportField('montoDiezmo', $diezmo->montoDiezmo->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $diezmo->idDiezmo->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
						ew_ExportAddValue($sExportStr, $diezmo->idMiembro->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
						ew_ExportAddValue($sExportStr, $diezmo->fecha->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
						ew_ExportAddValue($sExportStr, $diezmo->montoDiezmo->ExportValue($diezmo->Export, $diezmo->ExportOriginalValue), $diezmo->Export);
						echo ew_ExportLine($sExportStr, $diezmo->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($diezmo->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($diezmo->Export);
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
