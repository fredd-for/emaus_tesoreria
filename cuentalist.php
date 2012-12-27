<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cuentainfo.php" ?>
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
$cuenta_list = new ccuenta_list();
$Page =& $cuenta_list;

// Page init processing
$cuenta_list->Page_Init();

// Page main processing
$cuenta_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cuenta->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cuenta_list = new ew_Page("cuenta_list");

// page properties
cuenta_list.PageID = "list"; // page ID
var EW_PAGE_ID = cuenta_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cuenta_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cuenta_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cuenta_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($cuenta->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($cuenta->Export == "" && $cuenta->SelectLimit);
	if (!$bSelectLimit)
		$rs = $cuenta_list->LoadRecordset();
	$cuenta_list->lTotalRecs = ($bSelectLimit) ? $cuenta->SelectRecordCount() : $rs->RecordCount();
	$cuenta_list->lStartRec = 1;
	if ($cuenta_list->lDisplayRecs <= 0) // Display all records
		$cuenta_list->lDisplayRecs = $cuenta_list->lTotalRecs;
	if (!($cuenta->ExportAll && $cuenta->Export <> ""))
		$cuenta_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $cuenta_list->LoadRecordset($cuenta_list->lStartRec-1, $cuenta_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Cuenta
<?php if ($cuenta->Export == "" && $cuenta->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $cuenta_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $cuenta_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fcuentalist" id="fcuentalist" class="ewForm" action="" method="post">
<?php if ($cuenta_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$cuenta_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$cuenta_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$cuenta_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$cuenta_list->lOptionCnt++; // Delete
}
	$cuenta_list->lOptionCnt += count($cuenta_list->ListOptions->Items); // Custom list options
?>
<?php echo $cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($cuenta->idCuenta->Visible) { // idCuenta ?>
	<?php if ($cuenta->SortUrl($cuenta->idCuenta) == "") { ?>
		<td>Nro</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cuenta->SortUrl($cuenta->idCuenta) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nro</td><td style="width: 10px;"><?php if ($cuenta->idCuenta->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cuenta->idCuenta->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->cuenta->Visible) { // cuenta ?>
	<?php if ($cuenta->SortUrl($cuenta->cuenta) == "") { ?>
		<td>Cuenta</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cuenta->SortUrl($cuenta->cuenta) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cuenta</td><td style="width: 10px;"><?php if ($cuenta->cuenta->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cuenta->cuenta->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->porcentaje->Visible) { // porcentaje ?>
	<?php if ($cuenta->SortUrl($cuenta->porcentaje) == "") { ?>
		<td>Porcentaje</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cuenta->SortUrl($cuenta->porcentaje) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Porcentaje</td><td style="width: 10px;"><?php if ($cuenta->porcentaje->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cuenta->porcentaje->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->Export == "") { ?>
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
foreach ($cuenta_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($cuenta->ExportAll && $cuenta->Export <> "") {
	$cuenta_list->lStopRec = $cuenta_list->lTotalRecs;
} else {
	$cuenta_list->lStopRec = $cuenta_list->lStartRec + $cuenta_list->lDisplayRecs - 1; // Set the last record to display
}
$cuenta_list->lRecCount = $cuenta_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$cuenta->SelectLimit && $cuenta_list->lStartRec > 1)
		$rs->Move($cuenta_list->lStartRec - 1);
}
$cuenta_list->lRowCnt = 0;
while (($cuenta->CurrentAction == "gridadd" || !$rs->EOF) &&
	$cuenta_list->lRecCount < $cuenta_list->lStopRec) {
	$cuenta_list->lRecCount++;
	if (intval($cuenta_list->lRecCount) >= intval($cuenta_list->lStartRec)) {
		$cuenta_list->lRowCnt++;

	// Init row class and style
	$cuenta->CssClass = "";
	$cuenta->CssStyle = "";
	$cuenta->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($cuenta->CurrentAction == "gridadd") {
		$cuenta_list->LoadDefaultValues(); // Load default values
	} else {
		$cuenta_list->LoadRowValues($rs); // Load row values
	}
	$cuenta->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$cuenta_list->RenderRow();
?>
	<tr<?php echo $cuenta->RowAttributes() ?>>
	<?php if ($cuenta->idCuenta->Visible) { // idCuenta ?>
		<td<?php echo $cuenta->idCuenta->CellAttributes() ?>>
<div<?php echo $cuenta->idCuenta->ViewAttributes() ?>><?php echo $cuenta->idCuenta->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cuenta->cuenta->Visible) { // cuenta ?>
		<td<?php echo $cuenta->cuenta->CellAttributes() ?>>
<div<?php echo $cuenta->cuenta->ViewAttributes() ?>><?php echo $cuenta->cuenta->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($cuenta->porcentaje->Visible) { // porcentaje ?>
		<td<?php echo $cuenta->porcentaje->CellAttributes() ?>>
<div<?php echo $cuenta->porcentaje->ViewAttributes() ?>><?php echo $cuenta->porcentaje->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($cuenta->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $cuenta->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $cuenta->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $cuenta_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $cuenta->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($cuenta_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($cuenta->CurrentAction <> "gridadd")
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
<?php if ($cuenta->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($cuenta->CurrentAction <> "gridadd" && $cuenta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cuenta_list->Pager)) $cuenta_list->Pager = new cPrevNextPager($cuenta_list->lStartRec, $cuenta_list->lDisplayRecs, $cuenta_list->lTotalRecs) ?>
<?php if ($cuenta_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Página&nbsp;</span></td>
<!--first page button-->
	<?php if ($cuenta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cuenta_list->PageUrl() ?>start=<?php echo $cuenta_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cuenta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cuenta_list->PageUrl() ?>start=<?php echo $cuenta_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cuenta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cuenta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cuenta_list->PageUrl() ?>start=<?php echo $cuenta_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cuenta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cuenta_list->PageUrl() ?>start=<?php echo $cuenta_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $cuenta_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $cuenta_list->Pager->FromIndex ?> a <?php echo $cuenta_list->Pager->ToIndex ?> de <?php echo $cuenta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($cuenta_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta página</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($cuenta_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por página&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="cuenta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($cuenta_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($cuenta_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($cuenta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($cuenta_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $cuenta->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($cuenta->Export == "" && $cuenta->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(cuenta_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($cuenta->Export == "") { ?>
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
class ccuenta_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'cuenta';

	// Page Object Name
	var $PageObjName = 'cuenta_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cuenta;
		if ($cuenta->UseTokenInUrl) $PageUrl .= "t=" . $cuenta->TableVar . "&"; // add page token
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
		global $objForm, $cuenta;
		if ($cuenta->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cuenta->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cuenta->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccuenta_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["cuenta"] = new ccuenta();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cuenta;
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
	$cuenta->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $cuenta->Export; // Get export parameter, used in header
	$gsExportFile = $cuenta->TableVar; // Get export file, used in header
	if ($cuenta->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $cuenta;
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
		if ($cuenta->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $cuenta->getRecordsPerPage(); // Restore from Session
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
		$cuenta->setSessionWhere($sFilter);
		$cuenta->CurrentFilter = "";

		// Export data only
		if (in_array($cuenta->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $cuenta;
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
			$cuenta->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$cuenta->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $cuenta;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$cuenta->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cuenta->CurrentOrderType = @$_GET["ordertype"];
			$cuenta->UpdateSort($cuenta->idCuenta); // Field 
			$cuenta->UpdateSort($cuenta->cuenta); // Field 
			$cuenta->UpdateSort($cuenta->porcentaje); // Field 
			$cuenta->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $cuenta;
		$sOrderBy = $cuenta->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($cuenta->SqlOrderBy() <> "") {
				$sOrderBy = $cuenta->SqlOrderBy();
				$cuenta->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $cuenta;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cuenta->setSessionOrderBy($sOrderBy);
				$cuenta->idCuenta->setSort("");
				$cuenta->cuenta->setSort("");
				$cuenta->porcentaje->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$cuenta->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $cuenta;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cuenta->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cuenta->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cuenta->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cuenta->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cuenta->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cuenta->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cuenta;

		// Call Recordset Selecting event
		$cuenta->Recordset_Selecting($cuenta->CurrentFilter);

		// Load list page SQL
		$sSql = $cuenta->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$cuenta->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cuenta;
		$sFilter = $cuenta->KeyFilter();

		// Call Row Selecting event
		$cuenta->Row_Selecting($sFilter);

		// Load sql based on filter
		$cuenta->CurrentFilter = $sFilter;
		$sSql = $cuenta->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cuenta->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cuenta;
		$cuenta->idCuenta->setDbValue($rs->fields('idCuenta'));
		$cuenta->cuenta->setDbValue($rs->fields('cuenta'));
		$cuenta->porcentaje->setDbValue($rs->fields('porcentaje'));
		$cuenta->estado->setDbValue($rs->fields('estado'));
		$cuenta->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$cuenta->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cuenta;

		// Call Row_Rendering event
		$cuenta->Row_Rendering();

		// Common render codes for all row types
		// idCuenta

		$cuenta->idCuenta->CellCssStyle = "";
		$cuenta->idCuenta->CellCssClass = "";

		// cuenta
		$cuenta->cuenta->CellCssStyle = "";
		$cuenta->cuenta->CellCssClass = "";

		// porcentaje
		$cuenta->porcentaje->CellCssStyle = "";
		$cuenta->porcentaje->CellCssClass = "";
		if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCuenta
			$cuenta->idCuenta->ViewValue = $cuenta->idCuenta->CurrentValue;
			$cuenta->idCuenta->CssStyle = "";
			$cuenta->idCuenta->CssClass = "";
			$cuenta->idCuenta->ViewCustomAttributes = "";

			// cuenta
			$cuenta->cuenta->ViewValue = $cuenta->cuenta->CurrentValue;
			$cuenta->cuenta->CssStyle = "";
			$cuenta->cuenta->CssClass = "";
			$cuenta->cuenta->ViewCustomAttributes = "";

			// porcentaje
			$cuenta->porcentaje->ViewValue = $cuenta->porcentaje->CurrentValue;
			$cuenta->porcentaje->CssStyle = "";
			$cuenta->porcentaje->CssClass = "";
			$cuenta->porcentaje->ViewCustomAttributes = "";

			// idCuenta
			$cuenta->idCuenta->HrefValue = "";

			// cuenta
			$cuenta->cuenta->HrefValue = "";

			// porcentaje
			$cuenta->porcentaje->HrefValue = "";
		}

		// Call Row Rendered event
		$cuenta->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $cuenta;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($cuenta->ExportAll) {
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
		if ($cuenta->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($cuenta->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $cuenta->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idCuenta', $cuenta->Export);
				ew_ExportAddValue($sExportStr, 'cuenta', $cuenta->Export);
				ew_ExportAddValue($sExportStr, 'porcentaje', $cuenta->Export);
				echo ew_ExportLine($sExportStr, $cuenta->Export);
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
				$cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($cuenta->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idCuenta', $cuenta->idCuenta->CurrentValue);
					$XmlDoc->AddField('cuenta', $cuenta->cuenta->CurrentValue);
					$XmlDoc->AddField('porcentaje', $cuenta->porcentaje->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $cuenta->Export <> "csv") { // Vertical format
						echo ew_ExportField('idCuenta', $cuenta->idCuenta->ExportValue($cuenta->Export, $cuenta->ExportOriginalValue), $cuenta->Export);
						echo ew_ExportField('cuenta', $cuenta->cuenta->ExportValue($cuenta->Export, $cuenta->ExportOriginalValue), $cuenta->Export);
						echo ew_ExportField('porcentaje', $cuenta->porcentaje->ExportValue($cuenta->Export, $cuenta->ExportOriginalValue), $cuenta->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $cuenta->idCuenta->ExportValue($cuenta->Export, $cuenta->ExportOriginalValue), $cuenta->Export);
						ew_ExportAddValue($sExportStr, $cuenta->cuenta->ExportValue($cuenta->Export, $cuenta->ExportOriginalValue), $cuenta->Export);
						ew_ExportAddValue($sExportStr, $cuenta->porcentaje->ExportValue($cuenta->Export, $cuenta->ExportOriginalValue), $cuenta->Export);
						echo ew_ExportLine($sExportStr, $cuenta->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($cuenta->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($cuenta->Export);
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
