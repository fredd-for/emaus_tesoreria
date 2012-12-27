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
$miembro_list = new cmiembro_list();
$Page =& $miembro_list;

// Page init processing
$miembro_list->Page_Init();

// Page main processing
$miembro_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($miembro->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var miembro_list = new ew_Page("miembro_list");

// page properties
miembro_list.PageID = "list"; // page ID
var EW_PAGE_ID = miembro_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
miembro_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
miembro_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
miembro_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($miembro->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($miembro->Export == "" && $miembro->SelectLimit);
	if (!$bSelectLimit)
		$rs = $miembro_list->LoadRecordset();
	$miembro_list->lTotalRecs = ($bSelectLimit) ? $miembro->SelectRecordCount() : $rs->RecordCount();
	$miembro_list->lStartRec = 1;
	if ($miembro_list->lDisplayRecs <= 0) // Display all records
		$miembro_list->lDisplayRecs = $miembro_list->lTotalRecs;
	if (!($miembro->ExportAll && $miembro->Export <> ""))
		$miembro_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $miembro_list->LoadRecordset($miembro_list->lStartRec-1, $miembro_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Miembro
<?php if ($miembro->Export == "" && $miembro->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $miembro_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $miembro_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fmiembrolist" id="fmiembrolist" class="ewForm" action="" method="post">
<?php if ($miembro_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$miembro_list->lOptionCnt = 0;
	$miembro_list->lOptionCnt++; // view
if ($Security->CanEdit()) {
	$miembro_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$miembro_list->lOptionCnt++; // Delete
}
	$miembro_list->lOptionCnt += count($miembro_list->ListOptions->Items); // Custom list options
?>
<?php echo $miembro->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($miembro->idMiembro->Visible) { // idMiembro ?>
	<?php if ($miembro->SortUrl($miembro->idMiembro) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $miembro->SortUrl($miembro->idMiembro) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($miembro->idMiembro->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($miembro->idMiembro->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($miembro->nombre->Visible) { // nombre ?>
	<?php if ($miembro->SortUrl($miembro->nombre) == "") { ?>
		<td>Nombre(s)</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $miembro->SortUrl($miembro->nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nombre(s)</td><td style="width: 10px;"><?php if ($miembro->nombre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($miembro->nombre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($miembro->paterno->Visible) { // paterno ?>
	<?php if ($miembro->SortUrl($miembro->paterno) == "") { ?>
		<td>Apellido Paterno</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $miembro->SortUrl($miembro->paterno) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Apellido Paterno</td><td style="width: 10px;"><?php if ($miembro->paterno->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($miembro->paterno->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($miembro->materno->Visible) { // materno ?>
	<?php if ($miembro->SortUrl($miembro->materno) == "") { ?>
		<td>Apellido Materno</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $miembro->SortUrl($miembro->materno) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Apellido Materno</td><td style="width: 10px;"><?php if ($miembro->materno->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($miembro->materno->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($miembro->cargo->Visible) { // cargo ?>
	<?php if ($miembro->SortUrl($miembro->cargo) == "") { ?>
		<td>Cargo en la Iglesia</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $miembro->SortUrl($miembro->cargo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cargo en la Iglesia</td><td style="width: 10px;"><?php if ($miembro->cargo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($miembro->cargo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($miembro->diezma->Visible) { // diezma ?>
	<?php if ($miembro->SortUrl($miembro->diezma) == "") { ?>
		<td>Diezma</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $miembro->SortUrl($miembro->diezma) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Diezma</td><td style="width: 10px;"><?php if ($miembro->diezma->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($miembro->diezma->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($miembro->Export == "") { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($miembro_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($miembro->ExportAll && $miembro->Export <> "") {
	$miembro_list->lStopRec = $miembro_list->lTotalRecs;
} else {
	$miembro_list->lStopRec = $miembro_list->lStartRec + $miembro_list->lDisplayRecs - 1; // Set the last record to display
}
$miembro_list->lRecCount = $miembro_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$miembro->SelectLimit && $miembro_list->lStartRec > 1)
		$rs->Move($miembro_list->lStartRec - 1);
}
$miembro_list->lRowCnt = 0;
while (($miembro->CurrentAction == "gridadd" || !$rs->EOF) &&
	$miembro_list->lRecCount < $miembro_list->lStopRec) {
	$miembro_list->lRecCount++;
	if (intval($miembro_list->lRecCount) >= intval($miembro_list->lStartRec)) {
		$miembro_list->lRowCnt++;

	// Init row class and style
	$miembro->CssClass = "";
	$miembro->CssStyle = "";
	$miembro->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($miembro->CurrentAction == "gridadd") {
		$miembro_list->LoadDefaultValues(); // Load default values
	} else {
		$miembro_list->LoadRowValues($rs); // Load row values
	}
	$miembro->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$miembro_list->RenderRow();
?>
	<tr<?php echo $miembro->RowAttributes() ?>>
	<?php if ($miembro->idMiembro->Visible) { // idMiembro ?>
		<td<?php echo $miembro->idMiembro->CellAttributes() ?>>
<div<?php echo $miembro->idMiembro->ViewAttributes() ?>><?php echo $miembro->idMiembro->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($miembro->nombre->Visible) { // nombre ?>
		<td<?php echo $miembro->nombre->CellAttributes() ?>>
<div<?php echo $miembro->nombre->ViewAttributes() ?>><?php echo $miembro->nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($miembro->paterno->Visible) { // paterno ?>
		<td<?php echo $miembro->paterno->CellAttributes() ?>>
<div<?php echo $miembro->paterno->ViewAttributes() ?>><?php echo $miembro->paterno->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($miembro->materno->Visible) { // materno ?>
		<td<?php echo $miembro->materno->CellAttributes() ?>>
<div<?php echo $miembro->materno->ViewAttributes() ?>><?php echo $miembro->materno->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($miembro->cargo->Visible) { // cargo ?>
		<td<?php echo $miembro->cargo->CellAttributes() ?>>
<div<?php echo $miembro->cargo->ViewAttributes() ?>><?php echo $miembro->cargo->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($miembro->diezma->Visible) { // diezma ?>
		<td<?php echo $miembro->diezma->CellAttributes() ?>>
<div<?php echo $miembro->diezma->ViewAttributes() ?>><?php echo $miembro->diezma->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($miembro->Export == "") { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $miembro->ViewUrl() ?>">Ver</a>
</span></td>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $miembro->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $miembro_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $miembro->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($miembro_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($miembro->CurrentAction <> "gridadd")
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
<?php if ($miembro->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($miembro->CurrentAction <> "gridadd" && $miembro->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($miembro_list->Pager)) $miembro_list->Pager = new cPrevNextPager($miembro_list->lStartRec, $miembro_list->lDisplayRecs, $miembro_list->lTotalRecs) ?>
<?php if ($miembro_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Página&nbsp;</span></td>
<!--first page button-->
	<?php if ($miembro_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $miembro_list->PageUrl() ?>start=<?php echo $miembro_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($miembro_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $miembro_list->PageUrl() ?>start=<?php echo $miembro_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $miembro_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($miembro_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $miembro_list->PageUrl() ?>start=<?php echo $miembro_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($miembro_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $miembro_list->PageUrl() ?>start=<?php echo $miembro_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $miembro_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $miembro_list->Pager->FromIndex ?> a <?php echo $miembro_list->Pager->ToIndex ?> de <?php echo $miembro_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($miembro_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($miembro_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por página&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="miembro">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($miembro_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($miembro_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($miembro->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($miembro_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $miembro->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($miembro->Export == "" && $miembro->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(miembro_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
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
class cmiembro_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'miembro';

	// Page Object Name
	var $PageObjName = 'miembro_list';

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
	function cmiembro_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["miembro"] = new cmiembro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'miembro', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
	$miembro->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $miembro->Export; // Get export parameter, used in header
	$gsExportFile = $miembro->TableVar; // Get export file, used in header
	if ($miembro->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $miembro;
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
		if ($miembro->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $miembro->getRecordsPerPage(); // Restore from Session
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
		$miembro->setSessionWhere($sFilter);
		$miembro->CurrentFilter = "";

		// Export data only
		if (in_array($miembro->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $miembro;
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
			$miembro->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$miembro->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $miembro;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$miembro->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$miembro->CurrentOrderType = @$_GET["ordertype"];
			$miembro->UpdateSort($miembro->idMiembro); // Field 
			$miembro->UpdateSort($miembro->nombre); // Field 
			$miembro->UpdateSort($miembro->paterno); // Field 
			$miembro->UpdateSort($miembro->materno); // Field 
			$miembro->UpdateSort($miembro->cargo); // Field 
			$miembro->UpdateSort($miembro->diezma); // Field 
			$miembro->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $miembro;
		$sOrderBy = $miembro->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($miembro->SqlOrderBy() <> "") {
				$sOrderBy = $miembro->SqlOrderBy();
				$miembro->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $miembro;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$miembro->setSessionOrderBy($sOrderBy);
				$miembro->idMiembro->setSort("");
				$miembro->nombre->setSort("");
				$miembro->paterno->setSort("");
				$miembro->materno->setSort("");
				$miembro->cargo->setSort("");
				$miembro->diezma->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$miembro->setStartRecordNumber($this->lStartRec);
		}
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $miembro;

		// Call Recordset Selecting event
		$miembro->Recordset_Selecting($miembro->CurrentFilter);

		// Load list page SQL
		$sSql = $miembro->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$miembro->Recordset_Selected($rs);
		return $rs;
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

	// Export data in XML or CSV format
	function ExportData() {
		global $miembro;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($miembro->ExportAll) {
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
		if ($miembro->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($miembro->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $miembro->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idMiembro', $miembro->Export);
				ew_ExportAddValue($sExportStr, 'nombre', $miembro->Export);
				ew_ExportAddValue($sExportStr, 'paterno', $miembro->Export);
				ew_ExportAddValue($sExportStr, 'materno', $miembro->Export);
				ew_ExportAddValue($sExportStr, 'cargo', $miembro->Export);
				ew_ExportAddValue($sExportStr, 'diezma', $miembro->Export);
				echo ew_ExportLine($sExportStr, $miembro->Export);
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
				$miembro->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($miembro->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idMiembro', $miembro->idMiembro->CurrentValue);
					$XmlDoc->AddField('nombre', $miembro->nombre->CurrentValue);
					$XmlDoc->AddField('paterno', $miembro->paterno->CurrentValue);
					$XmlDoc->AddField('materno', $miembro->materno->CurrentValue);
					$XmlDoc->AddField('cargo', $miembro->cargo->CurrentValue);
					$XmlDoc->AddField('diezma', $miembro->diezma->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $miembro->Export <> "csv") { // Vertical format
						echo ew_ExportField('idMiembro', $miembro->idMiembro->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						echo ew_ExportField('nombre', $miembro->nombre->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						echo ew_ExportField('paterno', $miembro->paterno->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						echo ew_ExportField('materno', $miembro->materno->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						echo ew_ExportField('cargo', $miembro->cargo->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						echo ew_ExportField('diezma', $miembro->diezma->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $miembro->idMiembro->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						ew_ExportAddValue($sExportStr, $miembro->nombre->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						ew_ExportAddValue($sExportStr, $miembro->paterno->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						ew_ExportAddValue($sExportStr, $miembro->materno->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						ew_ExportAddValue($sExportStr, $miembro->cargo->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						ew_ExportAddValue($sExportStr, $miembro->diezma->ExportValue($miembro->Export, $miembro->ExportOriginalValue), $miembro->Export);
						echo ew_ExportLine($sExportStr, $miembro->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($miembro->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($miembro->Export);
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
