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
$diezmo_list = new cdiezmo_list();
$Page =& $diezmo_list;

// Page init processing
$diezmo_list->Page_Init();

// Page main processing
$diezmo_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($diezmo->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var diezmo_list = new ew_Page("diezmo_list");

// page properties
diezmo_list.PageID = "list"; // page ID
var EW_PAGE_ID = diezmo_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
diezmo_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
diezmo_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
diezmo_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($diezmo->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($diezmo->Export == "" && $diezmo->SelectLimit);
	if (!$bSelectLimit)
		$rs = $diezmo_list->LoadRecordset();
	$diezmo_list->lTotalRecs = ($bSelectLimit) ? $diezmo->SelectRecordCount() : $rs->RecordCount();
	$diezmo_list->lStartRec = 1;
	if ($diezmo_list->lDisplayRecs <= 0) // Display all records
		$diezmo_list->lDisplayRecs = $diezmo_list->lTotalRecs;
	if (!($diezmo->ExportAll && $diezmo->Export <> ""))
		$diezmo_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $diezmo_list->LoadRecordset($diezmo_list->lStartRec-1, $diezmo_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Diezmo
<?php if ($diezmo->Export == "" && $diezmo->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $diezmo_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $diezmo_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fdiezmolist" id="fdiezmolist" class="ewForm" action="" method="post">
<?php if ($diezmo_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$diezmo_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$diezmo_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$diezmo_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$diezmo_list->lOptionCnt++; // Delete
}
	$diezmo_list->lOptionCnt += count($diezmo_list->ListOptions->Items); // Custom list options
?>
<?php echo $diezmo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($diezmo->idDiezmo->Visible) { // idDiezmo ?>
	<?php if ($diezmo->SortUrl($diezmo->idDiezmo) == "") { ?>
		<td>Nro</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $diezmo->SortUrl($diezmo->idDiezmo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nro</td><td style="width: 10px;"><?php if ($diezmo->idDiezmo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($diezmo->idDiezmo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($diezmo->idMiembro->Visible) { // idMiembro ?>
	<?php if ($diezmo->SortUrl($diezmo->idMiembro) == "") { ?>
		<td>Id Miembro</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $diezmo->SortUrl($diezmo->idMiembro) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id Miembro</td><td style="width: 10px;"><?php if ($diezmo->idMiembro->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($diezmo->idMiembro->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($diezmo->fecha->Visible) { // fecha ?>
	<?php if ($diezmo->SortUrl($diezmo->fecha) == "") { ?>
		<td>Fecha</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $diezmo->SortUrl($diezmo->fecha) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha</td><td style="width: 10px;"><?php if ($diezmo->fecha->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($diezmo->fecha->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($diezmo->montoDiezmo->Visible) { // montoDiezmo ?>
	<?php if ($diezmo->SortUrl($diezmo->montoDiezmo) == "") { ?>
		<td>Monto Diezmo</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $diezmo->SortUrl($diezmo->montoDiezmo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Monto Diezmo</td><td style="width: 10px;"><?php if ($diezmo->montoDiezmo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($diezmo->montoDiezmo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($diezmo->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($diezmo_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($diezmo->ExportAll && $diezmo->Export <> "") {
	$diezmo_list->lStopRec = $diezmo_list->lTotalRecs;
} else {
	$diezmo_list->lStopRec = $diezmo_list->lStartRec + $diezmo_list->lDisplayRecs - 1; // Set the last record to display
}
$diezmo_list->lRecCount = $diezmo_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$diezmo->SelectLimit && $diezmo_list->lStartRec > 1)
		$rs->Move($diezmo_list->lStartRec - 1);
}
$diezmo_list->lRowCnt = 0;
while (($diezmo->CurrentAction == "gridadd" || !$rs->EOF) &&
	$diezmo_list->lRecCount < $diezmo_list->lStopRec) {
	$diezmo_list->lRecCount++;
	if (intval($diezmo_list->lRecCount) >= intval($diezmo_list->lStartRec)) {
		$diezmo_list->lRowCnt++;

	// Init row class and style
	$diezmo->CssClass = "";
	$diezmo->CssStyle = "";
	$diezmo->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($diezmo->CurrentAction == "gridadd") {
		$diezmo_list->LoadDefaultValues(); // Load default values
	} else {
		$diezmo_list->LoadRowValues($rs); // Load row values
	}
	$diezmo->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$diezmo_list->RenderRow();
?>
	<tr<?php echo $diezmo->RowAttributes() ?>>
	<?php if ($diezmo->idDiezmo->Visible) { // idDiezmo ?>
		<td<?php echo $diezmo->idDiezmo->CellAttributes() ?>>
<div<?php echo $diezmo->idDiezmo->ViewAttributes() ?>><?php echo $diezmo->idDiezmo->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($diezmo->idMiembro->Visible) { // idMiembro ?>
		<td<?php echo $diezmo->idMiembro->CellAttributes() ?>>
<div<?php echo $diezmo->idMiembro->ViewAttributes() ?>><?php echo $diezmo->idMiembro->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($diezmo->fecha->Visible) { // fecha ?>
		<td<?php echo $diezmo->fecha->CellAttributes() ?>>
<div<?php echo $diezmo->fecha->ViewAttributes() ?>><?php echo $diezmo->fecha->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($diezmo->montoDiezmo->Visible) { // montoDiezmo ?>
		<td<?php echo $diezmo->montoDiezmo->CellAttributes() ?>>
<div<?php echo $diezmo->montoDiezmo->ViewAttributes() ?>><?php echo $diezmo->montoDiezmo->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($diezmo->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $diezmo->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $diezmo->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $diezmo_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $diezmo->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($diezmo_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($diezmo->CurrentAction <> "gridadd")
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
<?php if ($diezmo->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($diezmo->CurrentAction <> "gridadd" && $diezmo->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($diezmo_list->Pager)) $diezmo_list->Pager = new cPrevNextPager($diezmo_list->lStartRec, $diezmo_list->lDisplayRecs, $diezmo_list->lTotalRecs) ?>
<?php if ($diezmo_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Página&nbsp;</span></td>
<!--first page button-->
	<?php if ($diezmo_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $diezmo_list->PageUrl() ?>start=<?php echo $diezmo_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($diezmo_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $diezmo_list->PageUrl() ?>start=<?php echo $diezmo_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $diezmo_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($diezmo_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $diezmo_list->PageUrl() ?>start=<?php echo $diezmo_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($diezmo_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $diezmo_list->PageUrl() ?>start=<?php echo $diezmo_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $diezmo_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $diezmo_list->Pager->FromIndex ?> a <?php echo $diezmo_list->Pager->ToIndex ?> de <?php echo $diezmo_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($diezmo_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta página</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($diezmo_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por página&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="diezmo">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($diezmo_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($diezmo_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($diezmo->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($diezmo_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $diezmo->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($diezmo->Export == "" && $diezmo->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(diezmo_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
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
		$this->sDeleteConfirmMsg = "¿Quiere borrar este registro?"; // Delete confirm message

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
