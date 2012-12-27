<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cierre_gestioninfo.php" ?>
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
$cierre_gestion_list = new ccierre_gestion_list();
$Page =& $cierre_gestion_list;

// Page init processing
$cierre_gestion_list->Page_Init();

// Page main processing
$cierre_gestion_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cierre_gestion->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cierre_gestion_list = new ew_Page("cierre_gestion_list");

// page properties
cierre_gestion_list.PageID = "list"; // page ID
var EW_PAGE_ID = cierre_gestion_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cierre_gestion_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cierre_gestion_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cierre_gestion_list.ValidateRequired = false; // no JavaScript validation
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
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<?php } ?>
<?php if ($cierre_gestion->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($cierre_gestion->Export == "" && $cierre_gestion->SelectLimit);
	if (!$bSelectLimit)
		$rs = $cierre_gestion_list->LoadRecordset();
	$cierre_gestion_list->lTotalRecs = ($bSelectLimit) ? $cierre_gestion->SelectRecordCount() : $rs->RecordCount();
	$cierre_gestion_list->lStartRec = 1;
	if ($cierre_gestion_list->lDisplayRecs <= 0) // Display all records
		$cierre_gestion_list->lDisplayRecs = $cierre_gestion_list->lTotalRecs;
	if (!($cierre_gestion->ExportAll && $cierre_gestion->Export <> ""))
		$cierre_gestion_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $cierre_gestion_list->LoadRecordset($cierre_gestion_list->lStartRec-1, $cierre_gestion_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">Vista personalizada: Cierre Gestion
<?php if ($cierre_gestion->Export == "" && $cierre_gestion->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $cierre_gestion_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $cierre_gestion_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fcierre_gestionlist" id="fcierre_gestionlist" class="ewForm" action="" method="post">
<?php if ($cierre_gestion_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$cierre_gestion_list->lOptionCnt = 0;
	$cierre_gestion_list->lOptionCnt += count($cierre_gestion_list->ListOptions->Items); // Custom list options
?>
<?php echo $cierre_gestion->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($cierre_gestion->idCuenta->Visible) { // idCuenta ?>
	<?php if ($cierre_gestion->SortUrl($cierre_gestion->idCuenta) == "") { ?>
		<td>Nro</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cierre_gestion->SortUrl($cierre_gestion->idCuenta) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nro</td><td style="width: 10px;"><?php if ($cierre_gestion->idCuenta->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cierre_gestion->idCuenta->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cierre_gestion->cuenta->Visible) { // cuenta ?>
	<?php if ($cierre_gestion->SortUrl($cierre_gestion->cuenta) == "") { ?>
		<td>Cuenta</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cierre_gestion->SortUrl($cierre_gestion->cuenta) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cuenta</td><td style="width: 10px;"><?php if ($cierre_gestion->cuenta->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cierre_gestion->cuenta->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cierre_gestion->saldo->Visible) { // saldo ?>
	<?php if ($cierre_gestion->SortUrl($cierre_gestion->saldo) == "") { ?>
		<td>Saldo</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cierre_gestion->SortUrl($cierre_gestion->saldo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Saldo</td><td style="width: 10px;"><?php if ($cierre_gestion->saldo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cierre_gestion->saldo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cierre_gestion->Export == "") { ?>
<?php

// Custom list options
foreach ($cierre_gestion_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($cierre_gestion->ExportAll && $cierre_gestion->Export <> "") {
	$cierre_gestion_list->lStopRec = $cierre_gestion_list->lTotalRecs;
} else {
	$cierre_gestion_list->lStopRec = $cierre_gestion_list->lStartRec + $cierre_gestion_list->lDisplayRecs - 1; // Set the last record to display
}
$cierre_gestion_list->lRecCount = $cierre_gestion_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$cierre_gestion->SelectLimit && $cierre_gestion_list->lStartRec > 1)
		$rs->Move($cierre_gestion_list->lStartRec - 1);
}
$cierre_gestion_list->lRowCnt = 0;
while (($cierre_gestion->CurrentAction == "gridadd" || !$rs->EOF) &&
	$cierre_gestion_list->lRecCount < $cierre_gestion_list->lStopRec) {
	$cierre_gestion_list->lRecCount++;
	if (intval($cierre_gestion_list->lRecCount) >= intval($cierre_gestion_list->lStartRec)) {
		$cierre_gestion_list->lRowCnt++;

	// Init row class and style
	$cierre_gestion->CssClass = "";
	$cierre_gestion->CssStyle = "";
	$cierre_gestion->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($cierre_gestion->CurrentAction == "gridadd") {
		$cierre_gestion_list->LoadDefaultValues(); // Load default values
	} else {
		$cierre_gestion_list->LoadRowValues($rs); // Load row values
	}
	$cierre_gestion->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$cierre_gestion_list->RenderRow();
?>
	<tr<?php echo $cierre_gestion->RowAttributes() ?>>
	<?php if ($cierre_gestion->idCuenta->Visible) { // idCuenta ?>
		<td<?php echo $cierre_gestion->idCuenta->CellAttributes() ?>>
<div<?php echo $cierre_gestion->idCuenta->ViewAttributes() ?>><?php echo $cierre_gestion->idCuenta->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cierre_gestion->cuenta->Visible) { // cuenta ?>
		<td<?php echo $cierre_gestion->cuenta->CellAttributes() ?>>
<div<?php echo $cierre_gestion->cuenta->ViewAttributes() ?>><?php echo $cierre_gestion->cuenta->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cierre_gestion->saldo->Visible) { // saldo ?>
		<td<?php echo $cierre_gestion->saldo->CellAttributes() ?>>
<div<?php echo $cierre_gestion->saldo->ViewAttributes() ?>><?php echo $cierre_gestion->saldo->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($cierre_gestion->Export == "") { ?>
<?php

// Custom list options
foreach ($cierre_gestion_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($cierre_gestion->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
</div>
<?php if ($cierre_gestion->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cierre_gestion->CurrentAction <> "gridadd" && $cierre_gestion->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cierre_gestion_list->Pager)) $cierre_gestion_list->Pager = new cPrevNextPager($cierre_gestion_list->lStartRec, $cierre_gestion_list->lDisplayRecs, $cierre_gestion_list->lTotalRecs) ?>
<?php if ($cierre_gestion_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P�gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($cierre_gestion_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cierre_gestion_list->PageUrl() ?>start=<?php echo $cierre_gestion_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cierre_gestion_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cierre_gestion_list->PageUrl() ?>start=<?php echo $cierre_gestion_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cierre_gestion_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cierre_gestion_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cierre_gestion_list->PageUrl() ?>start=<?php echo $cierre_gestion_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cierre_gestion_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cierre_gestion_list->PageUrl() ?>start=<?php echo $cierre_gestion_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $cierre_gestion_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $cierre_gestion_list->Pager->FromIndex ?> a <?php echo $cierre_gestion_list->Pager->ToIndex ?> de <?php echo $cierre_gestion_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($cierre_gestion_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($cierre_gestion_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por p�gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="cierre_gestion">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($cierre_gestion_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($cierre_gestion_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($cierre_gestion->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($cierre_gestion_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>

<br>
<br>
<?php
mysql_select_db($database_conexion, $conexion);
$query_cuentaSaldo = "SELECT * FROM cuenta";
$mostrar_cuentaSaldo= mysql_query($query_cuentaSaldo, $conexion) or die(mysql_error());
$total_cuentaSaldo= mysql_num_rows($mostrar_cuentaSaldo);
?>
<form method="post" action="cierre_gestion_guardar.php" >
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
    <tr>
        <td>Fecha 1er Registro</td>
        <td></td>
        <td>Fecha Ultimo Registro</td>
        <td></td>
    </tr>
<?php
?>
    <tr>
        <td>Fecha Inicial</td>
        <td><input type="text" name="fi" id="fi" size="12">
            &nbsp;<img src="images/calendar.png" id="cal_fi" name="cal_fi" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "fi", // ID of the input field
	ifFormat : "%d-%m-%Y", // the date format
	button : "cal_fi" // ID of the button
});
</script>
        </td>
        <td>Fecha Final</td>
        <td><input type="text" name="ff" id="ff" size="12">
        &nbsp;<img src="images/calendar.png" id="cal_ff" name="cal_ff" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "ff", // ID of the input field
	ifFormat : "%d-%m-%Y", // the date format
	button : "cal_ff" // ID of the button
});
</script>
        </td>
    </tr>
    <tr>
        <td colspan="4" align="center"><input type="submit" name="guardar" value="Cerrar Gestion" onSubmit="if(confirm('Esta seguro de cerrar la gestion?')) return true; return false;"></td>
    </tr>
</table>
</div></td></tr></table>
</form>
<?php if ($cierre_gestion->Export == "" && $cierre_gestion->CurrentAction == "") { ?>
<script type="text/javascript">

</script>
<?php } ?>
<?php if ($cierre_gestion->Export == "") { ?>
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
