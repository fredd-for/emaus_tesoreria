<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
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
$usuario_list = new cusuario_list();
$Page =& $usuario_list;

// Page init processing
$usuario_list->Page_Init();

// Page main processing
$usuario_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($usuario->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var usuario_list = new ew_Page("usuario_list");

// page properties
usuario_list.PageID = "list"; // page ID
var EW_PAGE_ID = usuario_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
usuario_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
usuario_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
usuario_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($usuario->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($usuario->Export == "" && $usuario->SelectLimit);
	if (!$bSelectLimit)
		$rs = $usuario_list->LoadRecordset();
	$usuario_list->lTotalRecs = ($bSelectLimit) ? $usuario->SelectRecordCount() : $rs->RecordCount();
	$usuario_list->lStartRec = 1;
	if ($usuario_list->lDisplayRecs <= 0) // Display all records
		$usuario_list->lDisplayRecs = $usuario_list->lTotalRecs;
	if (!($usuario->ExportAll && $usuario->Export <> ""))
		$usuario_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $usuario_list->LoadRecordset($usuario_list->lStartRec-1, $usuario_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Usuario
<?php if ($usuario->Export == "" && $usuario->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $usuario_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $usuario_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fusuariolist" id="fusuariolist" class="ewForm" action="" method="post">
<?php if ($usuario_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$usuario_list->lOptionCnt = 0;
if ($Security->CanView()) {
	$usuario_list->lOptionCnt++; // view
}
if ($Security->CanEdit()) {
	$usuario_list->lOptionCnt++; // edit
}
if ($Security->CanDelete()) {
	$usuario_list->lOptionCnt++; // Delete
}
	$usuario_list->lOptionCnt += count($usuario_list->ListOptions->Items); // Custom list options
?>
<?php echo $usuario->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($usuario->idUsuario->Visible) { // idUsuario ?>
	<?php if ($usuario->SortUrl($usuario->idUsuario) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $usuario->SortUrl($usuario->idUsuario) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($usuario->idUsuario->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($usuario->idUsuario->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($usuario->idRol->Visible) { // idRol ?>
	<?php if ($usuario->SortUrl($usuario->idRol) == "") { ?>
		<td>Rol</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $usuario->SortUrl($usuario->idRol) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Rol</td><td style="width: 10px;"><?php if ($usuario->idRol->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($usuario->idRol->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($usuario->nombre->Visible) { // nombre ?>
	<?php if ($usuario->SortUrl($usuario->nombre) == "") { ?>
		<td>Nombre(s)</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $usuario->SortUrl($usuario->nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nombre(s)</td><td style="width: 10px;"><?php if ($usuario->nombre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($usuario->nombre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($usuario->paterno->Visible) { // paterno ?>
	<?php if ($usuario->SortUrl($usuario->paterno) == "") { ?>
		<td>Apellido Paterno</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $usuario->SortUrl($usuario->paterno) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Apellido Paterno</td><td style="width: 10px;"><?php if ($usuario->paterno->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($usuario->paterno->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($usuario->materno->Visible) { // materno ?>
	<?php if ($usuario->SortUrl($usuario->materno) == "") { ?>
		<td>Apellido Materno</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $usuario->SortUrl($usuario->materno) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Apellido Materno</td><td style="width: 10px;"><?php if ($usuario->materno->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($usuario->materno->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($usuario->ci->Visible) { // ci ?>
	<?php if ($usuario->SortUrl($usuario->ci) == "") { ?>
		<td>C.I</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $usuario->SortUrl($usuario->ci) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>C.I</td><td style="width: 10px;"><?php if ($usuario->ci->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($usuario->ci->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($usuario->cargo->Visible) { // cargo ?>
	<?php if ($usuario->SortUrl($usuario->cargo) == "") { ?>
		<td>Cargo en la Iglesia</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $usuario->SortUrl($usuario->cargo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Cargo en la Iglesia</td><td style="width: 10px;"><?php if ($usuario->cargo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($usuario->cargo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($usuario->Export == "") { ?>
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
foreach ($usuario_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($usuario->ExportAll && $usuario->Export <> "") {
	$usuario_list->lStopRec = $usuario_list->lTotalRecs;
} else {
	$usuario_list->lStopRec = $usuario_list->lStartRec + $usuario_list->lDisplayRecs - 1; // Set the last record to display
}
$usuario_list->lRecCount = $usuario_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$usuario->SelectLimit && $usuario_list->lStartRec > 1)
		$rs->Move($usuario_list->lStartRec - 1);
}
$usuario_list->lRowCnt = 0;
while (($usuario->CurrentAction == "gridadd" || !$rs->EOF) &&
	$usuario_list->lRecCount < $usuario_list->lStopRec) {
	$usuario_list->lRecCount++;
	if (intval($usuario_list->lRecCount) >= intval($usuario_list->lStartRec)) {
		$usuario_list->lRowCnt++;

	// Init row class and style
	$usuario->CssClass = "";
	$usuario->CssStyle = "";
	$usuario->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($usuario->CurrentAction == "gridadd") {
		$usuario_list->LoadDefaultValues(); // Load default values
	} else {
		$usuario_list->LoadRowValues($rs); // Load row values
	}
	$usuario->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$usuario_list->RenderRow();
?>
	<tr<?php echo $usuario->RowAttributes() ?>>
	<?php if ($usuario->idUsuario->Visible) { // idUsuario ?>
		<td<?php echo $usuario->idUsuario->CellAttributes() ?>>
<div<?php echo $usuario->idUsuario->ViewAttributes() ?>><?php echo $usuario->idUsuario->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($usuario->idRol->Visible) { // idRol ?>
		<td<?php echo $usuario->idRol->CellAttributes() ?>>
<div<?php echo $usuario->idRol->ViewAttributes() ?>><?php echo $usuario->idRol->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($usuario->nombre->Visible) { // nombre ?>
		<td<?php echo $usuario->nombre->CellAttributes() ?>>
<div<?php echo $usuario->nombre->ViewAttributes() ?>><?php echo $usuario->nombre->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($usuario->paterno->Visible) { // paterno ?>
		<td<?php echo $usuario->paterno->CellAttributes() ?>>
<div<?php echo $usuario->paterno->ViewAttributes() ?>><?php echo $usuario->paterno->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($usuario->materno->Visible) { // materno ?>
		<td<?php echo $usuario->materno->CellAttributes() ?>>
<div<?php echo $usuario->materno->ViewAttributes() ?>><?php echo $usuario->materno->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($usuario->ci->Visible) { // ci ?>
		<td<?php echo $usuario->ci->CellAttributes() ?>>
<div<?php echo $usuario->ci->ViewAttributes() ?>><?php echo $usuario->ci->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($usuario->cargo->Visible) { // cargo ?>
		<td<?php echo $usuario->cargo->CellAttributes() ?>>
<div<?php echo $usuario->cargo->ViewAttributes() ?>><?php echo $usuario->cargo->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php if ($usuario->Export == "") { ?>
<?php if ($Security->CanView()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $usuario->ViewUrl() ?>">Ver</a>
</span></td>
<?php } ?>
<?php if ($Security->CanEdit()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $usuario->EditUrl() ?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->CanDelete()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $usuario_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $usuario->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($usuario_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
	</tr>
<?php
	}
	if ($usuario->CurrentAction <> "gridadd")
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
<?php if ($usuario->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($usuario->CurrentAction <> "gridadd" && $usuario->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($usuario_list->Pager)) $usuario_list->Pager = new cPrevNextPager($usuario_list->lStartRec, $usuario_list->lDisplayRecs, $usuario_list->lTotalRecs) ?>
<?php if ($usuario_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Página&nbsp;</span></td>
<!--first page button-->
	<?php if ($usuario_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $usuario_list->PageUrl() ?>start=<?php echo $usuario_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($usuario_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $usuario_list->PageUrl() ?>start=<?php echo $usuario_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $usuario_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($usuario_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $usuario_list->PageUrl() ?>start=<?php echo $usuario_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($usuario_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $usuario_list->PageUrl() ?>start=<?php echo $usuario_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $usuario_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $usuario_list->Pager->FromIndex ?> a <?php echo $usuario_list->Pager->ToIndex ?> de <?php echo $usuario_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($usuario_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker">No tiene permisos para consultar esta página</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($usuario_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por página&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="usuario">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($usuario_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($usuario_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($usuario->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($usuario_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $usuario->AddUrl() ?>">Agregar</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($usuario->Export == "" && $usuario->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(usuario_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($usuario->Export == "") { ?>
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
class cusuario_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'usuario';

	// Page Object Name
	var $PageObjName = 'usuario_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $usuario;
		if ($usuario->UseTokenInUrl) $PageUrl .= "t=" . $usuario->TableVar . "&"; // add page token
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
		global $objForm, $usuario;
		if ($usuario->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($usuario->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($usuario->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cusuario_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["usuario"] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $usuario;
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
	$usuario->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $usuario->Export; // Get export parameter, used in header
	$gsExportFile = $usuario->TableVar; // Get export file, used in header
	if ($usuario->Export == "excel") {
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
		global $objForm, $gsSearchError, $Security, $usuario;
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
		if ($usuario->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $usuario->getRecordsPerPage(); // Restore from Session
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
		$usuario->setSessionWhere($sFilter);
		$usuario->CurrentFilter = "";

		// Export data only
		if (in_array($usuario->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $usuario;
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
			$usuario->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$usuario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $usuario;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$usuario->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$usuario->CurrentOrderType = @$_GET["ordertype"];
			$usuario->UpdateSort($usuario->idUsuario); // Field 
			$usuario->UpdateSort($usuario->idRol); // Field 
			$usuario->UpdateSort($usuario->nombre); // Field 
			$usuario->UpdateSort($usuario->paterno); // Field 
			$usuario->UpdateSort($usuario->materno); // Field 
			$usuario->UpdateSort($usuario->ci); // Field 
			$usuario->UpdateSort($usuario->cargo); // Field 
			$usuario->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $usuario;
		$sOrderBy = $usuario->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($usuario->SqlOrderBy() <> "") {
				$sOrderBy = $usuario->SqlOrderBy();
				$usuario->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $usuario;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$usuario->setSessionOrderBy($sOrderBy);
				$usuario->idUsuario->setSort("");
				$usuario->idRol->setSort("");
				$usuario->nombre->setSort("");
				$usuario->paterno->setSort("");
				$usuario->materno->setSort("");
				$usuario->ci->setSort("");
				$usuario->cargo->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$usuario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $usuario;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$usuario->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$usuario->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $usuario->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$usuario->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$usuario->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$usuario->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $usuario;

		// Call Recordset Selecting event
		$usuario->Recordset_Selecting($usuario->CurrentFilter);

		// Load list page SQL
		$sSql = $usuario->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$usuario->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $usuario;
		$sFilter = $usuario->KeyFilter();

		// Call Row Selecting event
		$usuario->Row_Selecting($sFilter);

		// Load sql based on filter
		$usuario->CurrentFilter = $sFilter;
		$sSql = $usuario->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$usuario->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $usuario;
		$usuario->idUsuario->setDbValue($rs->fields('idUsuario'));
		$usuario->idRol->setDbValue($rs->fields('idRol'));
		$usuario->nombre->setDbValue($rs->fields('nombre'));
		$usuario->paterno->setDbValue($rs->fields('paterno'));
		$usuario->materno->setDbValue($rs->fields('materno'));
		$usuario->ci->setDbValue($rs->fields('ci'));
		$usuario->cargo->setDbValue($rs->fields('cargo'));
		$usuario->zlogin->setDbValue($rs->fields('login'));
		$usuario->password->setDbValue($rs->fields('password'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $usuario;

		// Call Row_Rendering event
		$usuario->Row_Rendering();

		// Common render codes for all row types
		// idUsuario

		$usuario->idUsuario->CellCssStyle = "";
		$usuario->idUsuario->CellCssClass = "";

		// idRol
		$usuario->idRol->CellCssStyle = "";
		$usuario->idRol->CellCssClass = "";

		// nombre
		$usuario->nombre->CellCssStyle = "";
		$usuario->nombre->CellCssClass = "";

		// paterno
		$usuario->paterno->CellCssStyle = "";
		$usuario->paterno->CellCssClass = "";

		// materno
		$usuario->materno->CellCssStyle = "";
		$usuario->materno->CellCssClass = "";

		// ci
		$usuario->ci->CellCssStyle = "";
		$usuario->ci->CellCssClass = "";

		// cargo
		$usuario->cargo->CellCssStyle = "";
		$usuario->cargo->CellCssClass = "";
		if ($usuario->RowType == EW_ROWTYPE_VIEW) { // View row

			// idUsuario
			$usuario->idUsuario->ViewValue = $usuario->idUsuario->CurrentValue;
			$usuario->idUsuario->CssStyle = "";
			$usuario->idUsuario->CssClass = "";
			$usuario->idUsuario->ViewCustomAttributes = "";

			// idRol
			if ($Security->CanAdmin()) { // System admin
			if (strval($usuario->idRol->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre` FROM `rol` WHERE `idRol` = " . ew_AdjustSql($usuario->idRol->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$usuario->idRol->ViewValue = $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$usuario->idRol->ViewValue = $usuario->idRol->CurrentValue;
				}
			} else {
				$usuario->idRol->ViewValue = NULL;
			}
			} else {
				$usuario->idRol->ViewValue = "********";
			}
			$usuario->idRol->CssStyle = "";
			$usuario->idRol->CssClass = "";
			$usuario->idRol->ViewCustomAttributes = "";

			// nombre
			$usuario->nombre->ViewValue = $usuario->nombre->CurrentValue;
			$usuario->nombre->CssStyle = "";
			$usuario->nombre->CssClass = "";
			$usuario->nombre->ViewCustomAttributes = "";

			// paterno
			$usuario->paterno->ViewValue = $usuario->paterno->CurrentValue;
			$usuario->paterno->CssStyle = "";
			$usuario->paterno->CssClass = "";
			$usuario->paterno->ViewCustomAttributes = "";

			// materno
			$usuario->materno->ViewValue = $usuario->materno->CurrentValue;
			$usuario->materno->CssStyle = "";
			$usuario->materno->CssClass = "";
			$usuario->materno->ViewCustomAttributes = "";

			// ci
			$usuario->ci->ViewValue = $usuario->ci->CurrentValue;
			$usuario->ci->CssStyle = "";
			$usuario->ci->CssClass = "";
			$usuario->ci->ViewCustomAttributes = "";

			// cargo
			$usuario->cargo->ViewValue = $usuario->cargo->CurrentValue;
			$usuario->cargo->CssStyle = "";
			$usuario->cargo->CssClass = "";
			$usuario->cargo->ViewCustomAttributes = "";

			// idUsuario
			$usuario->idUsuario->HrefValue = "";

			// idRol
			$usuario->idRol->HrefValue = "";

			// nombre
			$usuario->nombre->HrefValue = "";

			// paterno
			$usuario->paterno->HrefValue = "";

			// materno
			$usuario->materno->HrefValue = "";

			// ci
			$usuario->ci->HrefValue = "";

			// cargo
			$usuario->cargo->HrefValue = "";
		}

		// Call Row Rendered event
		$usuario->Row_Rendered();
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $usuario;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($usuario->ExportAll) {
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
		if ($usuario->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($usuario->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $usuario->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idUsuario', $usuario->Export);
				ew_ExportAddValue($sExportStr, 'idRol', $usuario->Export);
				ew_ExportAddValue($sExportStr, 'nombre', $usuario->Export);
				ew_ExportAddValue($sExportStr, 'paterno', $usuario->Export);
				ew_ExportAddValue($sExportStr, 'materno', $usuario->Export);
				ew_ExportAddValue($sExportStr, 'ci', $usuario->Export);
				ew_ExportAddValue($sExportStr, 'cargo', $usuario->Export);
				echo ew_ExportLine($sExportStr, $usuario->Export);
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
				$usuario->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($usuario->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idUsuario', $usuario->idUsuario->CurrentValue);
					$XmlDoc->AddField('idRol', $usuario->idRol->CurrentValue);
					$XmlDoc->AddField('nombre', $usuario->nombre->CurrentValue);
					$XmlDoc->AddField('paterno', $usuario->paterno->CurrentValue);
					$XmlDoc->AddField('materno', $usuario->materno->CurrentValue);
					$XmlDoc->AddField('ci', $usuario->ci->CurrentValue);
					$XmlDoc->AddField('cargo', $usuario->cargo->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $usuario->Export <> "csv") { // Vertical format
						echo ew_ExportField('idUsuario', $usuario->idUsuario->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						echo ew_ExportField('idRol', $usuario->idRol->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						echo ew_ExportField('nombre', $usuario->nombre->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						echo ew_ExportField('paterno', $usuario->paterno->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						echo ew_ExportField('materno', $usuario->materno->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						echo ew_ExportField('ci', $usuario->ci->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						echo ew_ExportField('cargo', $usuario->cargo->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $usuario->idUsuario->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						ew_ExportAddValue($sExportStr, $usuario->idRol->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						ew_ExportAddValue($sExportStr, $usuario->nombre->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						ew_ExportAddValue($sExportStr, $usuario->paterno->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						ew_ExportAddValue($sExportStr, $usuario->materno->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						ew_ExportAddValue($sExportStr, $usuario->ci->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						ew_ExportAddValue($sExportStr, $usuario->cargo->ExportValue($usuario->Export, $usuario->ExportOriginalValue), $usuario->Export);
						echo ew_ExportLine($sExportStr, $usuario->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($usuario->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($usuario->Export);
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
