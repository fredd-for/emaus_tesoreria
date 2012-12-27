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
$rol_list = new crol_list();
$Page =& $rol_list;

// Page init processing
$rol_list->Page_Init();

// Page main processing
$rol_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($rol->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var rol_list = new ew_Page("rol_list");

// page properties
rol_list.PageID = "list"; // page ID
var EW_PAGE_ID = rol_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
rol_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rol_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rol_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($rol->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($rol->Export == "" && $rol->SelectLimit);
	if (!$bSelectLimit)
		$rs = $rol_list->LoadRecordset();
	$rol_list->lTotalRecs = ($bSelectLimit) ? $rol->SelectRecordCount() : $rs->RecordCount();
	$rol_list->lStartRec = 1;
	if ($rol_list->lDisplayRecs <= 0) // Display all records
		$rol_list->lDisplayRecs = $rol_list->lTotalRecs;
	if (!($rol->ExportAll && $rol->Export <> ""))
		$rol_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $rol_list->LoadRecordset($rol_list->lStartRec-1, $rol_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Rol
<?php if ($rol->Export == "" && $rol->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $rol_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $rol_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="frollist" id="frollist" class="ewForm" action="" method="post">
<?php if ($rol_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$rol_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$rol_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$rol_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$rol_list->lOptionCnt++; // Delete
}
	$rol_list->lOptionCnt++; // Permission
	$rol_list->lOptionCnt += count($rol_list->ListOptions->Items); // Custom list options
?>
<?php echo $rol->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($rol->idRol->Visible) { // idRol ?>
	<?php if ($rol->SortUrl($rol->idRol) == "") { ?>
		<td>Id Rol</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rol->SortUrl($rol->idRol) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Id Rol</td><td style="width: 10px;"><?php if ($rol->idRol->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rol->idRol->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rol->nombre->Visible) { // nombre ?>
	<?php if ($rol->SortUrl($rol->nombre) == "") { ?>
		<td>Nombre</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $rol->SortUrl($rol->nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nombre</td><td style="width: 10px;"><?php if ($rol->nombre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($rol->nombre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($rol->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php

// Custom list options
foreach ($rol_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($rol->ExportAll && $rol->Export <> "") {
	$rol_list->lStopRec = $rol_list->lTotalRecs;
} else {
	$rol_list->lStopRec = $rol_list->lStartRec + $rol_list->lDisplayRecs - 1; // Set the last record to display
}
$rol_list->lRecCount = $rol_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$rol->SelectLimit && $rol_list->lStartRec > 1)
		$rs->Move($rol_list->lStartRec - 1);
}
$rol_list->lRowCnt = 0;
while (($rol->CurrentAction == "gridadd" || !$rs->EOF) &&
	$rol_list->lRecCount < $rol_list->lStopRec) {
	$rol_list->lRecCount++;
	if (intval($rol_list->lRecCount) >= intval($rol_list->lStartRec)) {
		$rol_list->lRowCnt++;

	// Init row class and style
	$rol->CssClass = "";
	$rol->CssStyle = "";
	$rol->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($rol->CurrentAction == "gridadd") {
		$rol_list->LoadDefaultValues(); // Load default values
	} else {
		$rol_list->LoadRowValues($rs); // Load row values
	}
	$rol->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$rol_list->RenderRow();
?>
	<tr<?php echo $rol->RowAttributes() ?>>
	<?php if ($rol->idRol->Visible) { // idRol ?>
		<td<?php echo $rol->idRol->CellAttributes() ?>>
<div<?php echo $rol->idRol->ViewAttributes() ?>><?php echo $rol->idRol->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($rol->nombre->Visible) { // nombre ?>
		<td<?php echo $rol->nombre->CellAttributes() ?>>
<div<?php echo $rol->nombre->ViewAttributes() ?>><?php echo $rol->nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($rol->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker"><?php if ($rol->idRol->CurrentValue <= 0) { ?>-<?php } else { ?>
<a href="<?php echo $rol->ViewUrl() ?>">Ver</a>
<?php } ?></span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker"><?php if ($rol->idRol->CurrentValue <= 0) { ?>-<?php } else { ?>
<a href="<?php echo $rol->EditUrl() ?>">Editar</a>
<?php } ?></span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker"><?php if ($rol->idRol->CurrentValue <= 0) { ?>-<?php } else { ?>
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $rol_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $rol->DeleteUrl() ?>">Borrar</a>
<?php } ?></span></td>
<?php } ?>
<td style="white-space: nowrap;"><span class="phpmaker"><?php if ($rol->idRol->CurrentValue < 0) { ?>-<?php } else { ?>
<a href="userpriv.php?idRol=<?php echo $rol->idRol->CurrentValue ?>">Permisos</a>
<?php } ?></span></td>
<?php

// Custom list options
foreach ($rol_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($rol->CurrentAction <> "gridadd")
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
<?php if ($rol->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($rol->CurrentAction <> "gridadd" && $rol->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($rol_list->Pager)) $rol_list->Pager = new cPrevNextPager($rol_list->lStartRec, $rol_list->lDisplayRecs, $rol_list->lTotalRecs) ?>
<?php if ($rol_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Página&nbsp;</span></td>
<!--first page button-->
	<?php if ($rol_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $rol_list->PageUrl() ?>start=<?php echo $rol_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($rol_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $rol_list->PageUrl() ?>start=<?php echo $rol_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $rol_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($rol_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $rol_list->PageUrl() ?>start=<?php echo $rol_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($rol_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $rol_list->PageUrl() ?>start=<?php echo $rol_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $rol_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $rol_list->Pager->FromIndex ?> a <?php echo $rol_list->Pager->ToIndex ?> de <?php echo $rol_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($rol_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta página</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($rol_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por página&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="rol">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($rol_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($rol_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($rol->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($rol_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $rol->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($rol->Export == "" && $rol->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(rol_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
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
class crol_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'rol';

	// Page Object Name
	var $PageObjName = 'rol_list';

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
	function crol_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["rol"] = new crol();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rol', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
	$rol->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $rol->Export; // Get export parameter, used in header
	$gsExportFile = $rol->TableVar; // Get export file, used in header
	if ($rol->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $rol;
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
		if ($rol->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $rol->getRecordsPerPage(); // Restore from Session
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
		$rol->setSessionWhere($sFilter);
		$rol->CurrentFilter = "";

		// Export data only
		if (in_array($rol->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $rol;
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
			$rol->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$rol->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $rol;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$rol->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$rol->CurrentOrderType = @$_GET["ordertype"];
			$rol->UpdateSort($rol->idRol); // Field 
			$rol->UpdateSort($rol->nombre); // Field 
			$rol->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $rol;
		$sOrderBy = $rol->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($rol->SqlOrderBy() <> "") {
				$sOrderBy = $rol->SqlOrderBy();
				$rol->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $rol;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$rol->setSessionOrderBy($sOrderBy);
				$rol->idRol->setSort("");
				$rol->nombre->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$rol->setStartRecordNumber($this->lStartRec);
		}
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $rol;

		// Call Recordset Selecting event
		$rol->Recordset_Selecting($rol->CurrentFilter);

		// Load list page SQL
		$sSql = $rol->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$rol->Recordset_Selected($rs);
		return $rs;
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

	// Export data in XML or CSV format
	function ExportData() {
		global $rol;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($rol->ExportAll) {
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
		if ($rol->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($rol->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $rol->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idRol', $rol->Export);
				ew_ExportAddValue($sExportStr, 'nombre', $rol->Export);
				echo ew_ExportLine($sExportStr, $rol->Export);
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
				$rol->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($rol->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idRol', $rol->idRol->CurrentValue);
					$XmlDoc->AddField('nombre', $rol->nombre->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $rol->Export <> "csv") { // Vertical format
						echo ew_ExportField('idRol', $rol->idRol->ExportValue($rol->Export, $rol->ExportOriginalValue), $rol->Export);
						echo ew_ExportField('nombre', $rol->nombre->ExportValue($rol->Export, $rol->ExportOriginalValue), $rol->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $rol->idRol->ExportValue($rol->Export, $rol->ExportOriginalValue), $rol->Export);
						ew_ExportAddValue($sExportStr, $rol->nombre->ExportValue($rol->Export, $rol->ExportOriginalValue), $rol->Export);
						echo ew_ExportLine($sExportStr, $rol->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($rol->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($rol->Export);
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
