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
$diezmo_delete = new cdiezmo_delete();
$Page =& $diezmo_delete;

// Page init processing
$diezmo_delete->Page_Init();

// Page main processing
$diezmo_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var diezmo_delete = new ew_Page("diezmo_delete");

// page properties
diezmo_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = diezmo_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
diezmo_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
diezmo_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
diezmo_delete.ValidateRequired = false; // no JavaScript validation
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
<?php

// Load records for display
$rs = $diezmo_delete->LoadRecordset();
$diezmo_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($diezmo_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$diezmo_delete->Page_Terminate("diezmolist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Diezmo<br><br>
<a href="<?php echo $diezmo->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $diezmo_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="diezmo">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($diezmo_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $diezmo->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Nro</td>
		<td valign="top">Id Miembro</td>
		<td valign="top">Fecha</td>
		<td valign="top">Monto Diezmo</td>
	</tr>
	</thead>
	<tbody>
<?php
$diezmo_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$diezmo_delete->lRecCnt++;

	// Set row properties
	$diezmo->CssClass = "";
	$diezmo->CssStyle = "";
	$diezmo->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$diezmo_delete->LoadRowValues($rs);

	// Render row
	$diezmo_delete->RenderRow();
?>
	<tr<?php echo $diezmo->RowAttributes() ?>>
		<td<?php echo $diezmo->idDiezmo->CellAttributes() ?>>
<div<?php echo $diezmo->idDiezmo->ViewAttributes() ?>><?php echo $diezmo->idDiezmo->ListViewValue() ?></div></td>
		<td<?php echo $diezmo->idMiembro->CellAttributes() ?>>
<div<?php echo $diezmo->idMiembro->ViewAttributes() ?>><?php echo $diezmo->idMiembro->ListViewValue() ?></div></td>
		<td<?php echo $diezmo->fecha->CellAttributes() ?>>
<div<?php echo $diezmo->fecha->ViewAttributes() ?>><?php echo $diezmo->fecha->ListViewValue() ?></div></td>
		<td<?php echo $diezmo->montoDiezmo->CellAttributes() ?>>
<div<?php echo $diezmo->montoDiezmo->ViewAttributes() ?>><?php echo $diezmo->montoDiezmo->ListViewValue() ?></div></td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="CONFIRMAR BORRADO">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cdiezmo_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'diezmo';

	// Page Object Name
	var $PageObjName = 'diezmo_delete';

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
	function cdiezmo_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["diezmo"] = new cdiezmo();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'diezmo', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("diezmolist.php");
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
	var $lTotalRecs;
	var $lRecCnt;
	var $arRecKeys = array();

	// Page main processing
	function Page_Main() {
		global $diezmo;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idDiezmo"] <> "") {
			$diezmo->idDiezmo->setQueryStringValue($_GET["idDiezmo"]);
			if (!is_numeric($diezmo->idDiezmo->QueryStringValue))
				$this->Page_Terminate("diezmolist.php"); // Prevent SQL injection, exit
			$sKey .= $diezmo->idDiezmo->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if ($bSingleDelete) {
			$nKeySelected = 1; // Set up key selected count
			$this->arRecKeys[0] = $sKey;
		} else {
			if (isset($_POST["key_m"])) { // Key in form
				$nKeySelected = count($_POST["key_m"]); // Set up key selected count
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
			}
		}
		if ($nKeySelected <= 0)
			$this->Page_Terminate("diezmolist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("diezmolist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idDiezmo`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in diezmo class, diezmoinfo.php

		$diezmo->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$diezmo->CurrentAction = $_POST["a_delete"];
		} else {
			$diezmo->CurrentAction = "D"; // Delete record directly
		}
		switch ($diezmo->CurrentAction) {
			case "D": // Delete
				$diezmo->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($diezmo->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $diezmo;
		$DeleteRows = TRUE;
		$sWrkFilter = $diezmo->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in diezmo class, diezmoinfo.php

		$diezmo->CurrentFilter = $sWrkFilter;
		$sSql = $diezmo->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setMessage("No se encontraron registros"); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs) $rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $diezmo->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idDiezmo'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($diezmo->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($diezmo->CancelMessage <> "") {
				$this->setMessage($diezmo->CancelMessage);
				$diezmo->CancelMessage = "";
			} else {
				$this->setMessage("borrado cancelado");
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call recordset deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$diezmo->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
