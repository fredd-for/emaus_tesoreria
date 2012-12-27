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
$permiso_list = new cpermiso_list();
$Page =& $permiso_list;

// Page init processing
$permiso_list->Page_Init();

// Page main processing
$permiso_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($permiso->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var permiso_list = new ew_Page("permiso_list");

// page properties
permiso_list.PageID = "list"; // page ID
var EW_PAGE_ID = permiso_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
permiso_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
permiso_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
permiso_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($permiso->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($permiso->Export == "" && $permiso->SelectLimit);
	if (!$bSelectLimit)
		$rs = $permiso_list->LoadRecordset();
	$permiso_list->lTotalRecs = ($bSelectLimit) ? $permiso->SelectRecordCount() : $rs->RecordCount();
	$permiso_list->lStartRec = 1;
	if ($permiso_list->lDisplayRecs <= 0) // Display all records
		$permiso_list->lDisplayRecs = $permiso_list->lTotalRecs;
	if (!($permiso->ExportAll && $permiso->Export <> ""))
		$permiso_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $permiso_list->LoadRecordset($permiso_list->lStartRec-1, $permiso_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Permiso
<?php if ($permiso->Export == "" && $permiso->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $permiso_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $permiso_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fpermisolist" id="fpermisolist" class="ewForm" action="" method="post">
<?php if ($permiso_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$permiso_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$permiso_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$permiso_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$permiso_list->lOptionCnt++; // Delete
}
	$permiso_list->lOptionCnt += count($permiso_list->ListOptions->Items); // Custom list options
?>
<?php echo $permiso->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($permiso->idRol->Visible) { // idRol ?>
	<?php if ($permiso->SortUrl($permiso->idRol) == "") { ?>
		<td>Id Rol</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $permiso->SortUrl($permiso->idRol) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id Rol</td><td style="width: 10px;"><?php if ($permiso->idRol->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($permiso->idRol->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($permiso->nombre->Visible) { // nombre ?>
	<?php if ($permiso->SortUrl($permiso->nombre) == "") { ?>
		<td>Nombre</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $permiso->SortUrl($permiso->nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nombre</td><td style="width: 10px;"><?php if ($permiso->nombre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($permiso->nombre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($permiso->permiso->Visible) { // permiso ?>
	<?php if ($permiso->SortUrl($permiso->permiso) == "") { ?>
		<td>Permiso</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $permiso->SortUrl($permiso->permiso) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Permiso</td><td style="width: 10px;"><?php if ($permiso->permiso->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($permiso->permiso->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($permiso->Export == "") { ?>
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
foreach ($permiso_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($permiso->ExportAll && $permiso->Export <> "") {
	$permiso_list->lStopRec = $permiso_list->lTotalRecs;
} else {
	$permiso_list->lStopRec = $permiso_list->lStartRec + $permiso_list->lDisplayRecs - 1; // Set the last record to display
}
$permiso_list->lRecCount = $permiso_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$permiso->SelectLimit && $permiso_list->lStartRec > 1)
		$rs->Move($permiso_list->lStartRec - 1);
}
$permiso_list->lRowCnt = 0;
while (($permiso->CurrentAction == "gridadd" || !$rs->EOF) &&
	$permiso_list->lRecCount < $permiso_list->lStopRec) {
	$permiso_list->lRecCount++;
	if (intval($permiso_list->lRecCount) >= intval($permiso_list->lStartRec)) {
		$permiso_list->lRowCnt++;

	// Init row class and style
	$permiso->CssClass = "";
	$permiso->CssStyle = "";
	$permiso->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($permiso->CurrentAction == "gridadd") {
		$permiso_list->LoadDefaultValues(); // Load default values
	} else {
		$permiso_list->LoadRowValues($rs); // Load row values
	}
	$permiso->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$permiso_list->RenderRow();
?>
	<tr<?php echo $permiso->RowAttributes() ?>>
	<?php if ($permiso->idRol->Visible) { // idRol ?>
		<td<?php echo $permiso->idRol->CellAttributes() ?>>
<div<?php echo $permiso->idRol->ViewAttributes() ?>><?php echo $permiso->idRol->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($permiso->nombre->Visible) { // nombre ?>
		<td<?php echo $permiso->nombre->CellAttributes() ?>>
<div<?php echo $permiso->nombre->ViewAttributes() ?>><?php echo $permiso->nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($permiso->permiso->Visible) { // permiso ?>
		<td<?php echo $permiso->permiso->CellAttributes() ?>>
<div<?php echo $permiso->permiso->ViewAttributes() ?>><?php echo $permiso->permiso->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($permiso->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $permiso->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $permiso->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $permiso_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $permiso->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($permiso_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($permiso->CurrentAction <> "gridadd")
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
<?php if ($permiso->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($permiso->CurrentAction <> "gridadd" && $permiso->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($permiso_list->Pager)) $permiso_list->Pager = new cPrevNextPager($permiso_list->lStartRec, $permiso_list->lDisplayRecs, $permiso_list->lTotalRecs) ?>
<?php if ($permiso_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Página&nbsp;</span></td>
<!--first page button-->
	<?php if ($permiso_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $permiso_list->PageUrl() ?>start=<?php echo $permiso_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($permiso_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $permiso_list->PageUrl() ?>start=<?php echo $permiso_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $permiso_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($permiso_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $permiso_list->PageUrl() ?>start=<?php echo $permiso_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($permiso_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $permiso_list->PageUrl() ?>start=<?php echo $permiso_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $permiso_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $permiso_list->Pager->FromIndex ?> a <?php echo $permiso_list->Pager->ToIndex ?> de <?php echo $permiso_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($permiso_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta página</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($permiso_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por página&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="permiso">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($permiso_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($permiso_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($permiso->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($permiso_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $permiso->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($permiso->Export == "" && $permiso->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(permiso_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
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
class cpermiso_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'permiso';

	// Page Object Name
	var $PageObjName = 'permiso_list';

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
	function cpermiso_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["permiso"] = new cpermiso();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'permiso', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
	$permiso->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $permiso->Export; // Get export parameter, used in header
	$gsExportFile = $permiso->TableVar; // Get export file, used in header
	if ($permiso->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $permiso;
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
		if ($permiso->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $permiso->getRecordsPerPage(); // Restore from Session
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
		$permiso->setSessionWhere($sFilter);
		$permiso->CurrentFilter = "";

		// Export data only
		if (in_array($permiso->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $permiso;
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
			$permiso->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$permiso->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $permiso;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$permiso->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$permiso->CurrentOrderType = @$_GET["ordertype"];
			$permiso->UpdateSort($permiso->idRol); // Field 
			$permiso->UpdateSort($permiso->nombre); // Field 
			$permiso->UpdateSort($permiso->permiso); // Field 
			$permiso->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $permiso;
		$sOrderBy = $permiso->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($permiso->SqlOrderBy() <> "") {
				$sOrderBy = $permiso->SqlOrderBy();
				$permiso->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $permiso;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$permiso->setSessionOrderBy($sOrderBy);
				$permiso->idRol->setSort("");
				$permiso->nombre->setSort("");
				$permiso->permiso->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$permiso->setStartRecordNumber($this->lStartRec);
		}
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $permiso;

		// Call Recordset Selecting event
		$permiso->Recordset_Selecting($permiso->CurrentFilter);

		// Load list page SQL
		$sSql = $permiso->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$permiso->Recordset_Selected($rs);
		return $rs;
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

	// Export data in XML or CSV format
	function ExportData() {
		global $permiso;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($permiso->ExportAll) {
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
		if ($permiso->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($permiso->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $permiso->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idRol', $permiso->Export);
				ew_ExportAddValue($sExportStr, 'nombre', $permiso->Export);
				ew_ExportAddValue($sExportStr, 'permiso', $permiso->Export);
				echo ew_ExportLine($sExportStr, $permiso->Export);
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
				$permiso->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($permiso->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idRol', $permiso->idRol->CurrentValue);
					$XmlDoc->AddField('nombre', $permiso->nombre->CurrentValue);
					$XmlDoc->AddField('permiso', $permiso->permiso->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $permiso->Export <> "csv") { // Vertical format
						echo ew_ExportField('idRol', $permiso->idRol->ExportValue($permiso->Export, $permiso->ExportOriginalValue), $permiso->Export);
						echo ew_ExportField('nombre', $permiso->nombre->ExportValue($permiso->Export, $permiso->ExportOriginalValue), $permiso->Export);
						echo ew_ExportField('permiso', $permiso->permiso->ExportValue($permiso->Export, $permiso->ExportOriginalValue), $permiso->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $permiso->idRol->ExportValue($permiso->Export, $permiso->ExportOriginalValue), $permiso->Export);
						ew_ExportAddValue($sExportStr, $permiso->nombre->ExportValue($permiso->Export, $permiso->ExportOriginalValue), $permiso->Export);
						ew_ExportAddValue($sExportStr, $permiso->permiso->ExportValue($permiso->Export, $permiso->ExportOriginalValue), $permiso->Export);
						echo ew_ExportLine($sExportStr, $permiso->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($permiso->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($permiso->Export);
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
