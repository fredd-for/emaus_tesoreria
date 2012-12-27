<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "saldo_iglesiainfo.php" ?>
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
$saldo_iglesia_delete = new csaldo_iglesia_delete();
$Page =& $saldo_iglesia_delete;

// Page init processing
$saldo_iglesia_delete->Page_Init();

// Page main processing
$saldo_iglesia_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var saldo_iglesia_delete = new ew_Page("saldo_iglesia_delete");

// page properties
saldo_iglesia_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = saldo_iglesia_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
saldo_iglesia_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
saldo_iglesia_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
saldo_iglesia_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $saldo_iglesia_delete->LoadRecordset();
$saldo_iglesia_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($saldo_iglesia_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$saldo_iglesia_delete->Page_Terminate("saldo_iglesialist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Saldo Iglesia<br><br>
<a href="<?php echo $saldo_iglesia->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $saldo_iglesia_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="saldo_iglesia">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($saldo_iglesia_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $saldo_iglesia->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Fecha</td>
		<td valign="top">Recibo</td>
		<td valign="top">Detalle</td>
		<td valign="top">Ingreso</td>
		<td valign="top">Egreso</td>
	</tr>
	</thead>
	<tbody>
<?php
$saldo_iglesia_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$saldo_iglesia_delete->lRecCnt++;

	// Set row properties
	$saldo_iglesia->CssClass = "";
	$saldo_iglesia->CssStyle = "";
	$saldo_iglesia->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$saldo_iglesia_delete->LoadRowValues($rs);

	// Render row
	$saldo_iglesia_delete->RenderRow();
?>
	<tr<?php echo $saldo_iglesia->RowAttributes() ?>>
		<td<?php echo $saldo_iglesia->idSaldoIglesia->CellAttributes() ?>>
<div<?php echo $saldo_iglesia->idSaldoIglesia->ViewAttributes() ?>><?php echo $saldo_iglesia->idSaldoIglesia->ListViewValue() ?></div></td>
		<td<?php echo $saldo_iglesia->fecha->CellAttributes() ?>>
<div<?php echo $saldo_iglesia->fecha->ViewAttributes() ?>><?php echo $saldo_iglesia->fecha->ListViewValue() ?></div></td>
		<td<?php echo $saldo_iglesia->nro_fact_recibo->CellAttributes() ?>>
<div<?php echo $saldo_iglesia->nro_fact_recibo->ViewAttributes() ?>><?php echo $saldo_iglesia->nro_fact_recibo->ListViewValue() ?></div></td>
		<td<?php echo $saldo_iglesia->detalle->CellAttributes() ?>>
<div<?php echo $saldo_iglesia->detalle->ViewAttributes() ?>><?php echo $saldo_iglesia->detalle->ListViewValue() ?></div></td>
		<td<?php echo $saldo_iglesia->ingreso->CellAttributes() ?>>
<div<?php echo $saldo_iglesia->ingreso->ViewAttributes() ?>><?php echo $saldo_iglesia->ingreso->ListViewValue() ?></div></td>
		<td<?php echo $saldo_iglesia->egreso->CellAttributes() ?>>
<div<?php echo $saldo_iglesia->egreso->ViewAttributes() ?>><?php echo $saldo_iglesia->egreso->ListViewValue() ?></div></td>
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
class csaldo_iglesia_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'saldo_iglesia';

	// Page Object Name
	var $PageObjName = 'saldo_iglesia_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $saldo_iglesia;
		if ($saldo_iglesia->UseTokenInUrl) $PageUrl .= "t=" . $saldo_iglesia->TableVar . "&"; // add page token
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
		global $objForm, $saldo_iglesia;
		if ($saldo_iglesia->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($saldo_iglesia->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($saldo_iglesia->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function csaldo_iglesia_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["saldo_iglesia"] = new csaldo_iglesia();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'saldo_iglesia', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $saldo_iglesia;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
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
		global $saldo_iglesia;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idSaldoIglesia"] <> "") {
			$saldo_iglesia->idSaldoIglesia->setQueryStringValue($_GET["idSaldoIglesia"]);
			if (!is_numeric($saldo_iglesia->idSaldoIglesia->QueryStringValue))
				$this->Page_Terminate("saldo_iglesialist.php"); // Prevent SQL injection, exit
			$sKey .= $saldo_iglesia->idSaldoIglesia->QueryStringValue;
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
			$this->Page_Terminate("saldo_iglesialist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("saldo_iglesialist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idSaldoIglesia`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in saldo_iglesia class, saldo_iglesiainfo.php

		$saldo_iglesia->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$saldo_iglesia->CurrentAction = $_POST["a_delete"];
		} else {
			$saldo_iglesia->CurrentAction = "D"; // Delete record directly
		}
		switch ($saldo_iglesia->CurrentAction) {
			case "D": // Delete
				$saldo_iglesia->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($saldo_iglesia->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $saldo_iglesia;
		$DeleteRows = TRUE;
		$sWrkFilter = $saldo_iglesia->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in saldo_iglesia class, saldo_iglesiainfo.php

		$saldo_iglesia->CurrentFilter = $sWrkFilter;
		$sSql = $saldo_iglesia->SQL();
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
				$DeleteRows = $saldo_iglesia->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idSaldoIglesia'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($saldo_iglesia->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($saldo_iglesia->CancelMessage <> "") {
				$this->setMessage($saldo_iglesia->CancelMessage);
				$saldo_iglesia->CancelMessage = "";
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
				$saldo_iglesia->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $saldo_iglesia;

		// Call Recordset Selecting event
		$saldo_iglesia->Recordset_Selecting($saldo_iglesia->CurrentFilter);

		// Load list page SQL
		$sSql = $saldo_iglesia->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$saldo_iglesia->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $saldo_iglesia;
		$sFilter = $saldo_iglesia->KeyFilter();

		// Call Row Selecting event
		$saldo_iglesia->Row_Selecting($sFilter);

		// Load sql based on filter
		$saldo_iglesia->CurrentFilter = $sFilter;
		$sSql = $saldo_iglesia->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$saldo_iglesia->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $saldo_iglesia;
		$saldo_iglesia->idSaldoIglesia->setDbValue($rs->fields('idSaldoIglesia'));
		$saldo_iglesia->fecha->setDbValue($rs->fields('fecha'));
		$saldo_iglesia->nro_fact_recibo->setDbValue($rs->fields('nro_fact_recibo'));
		$saldo_iglesia->detalle->setDbValue($rs->fields('detalle'));
		$saldo_iglesia->ingreso->setDbValue($rs->fields('ingreso'));
		$saldo_iglesia->egreso->setDbValue($rs->fields('egreso'));
		$saldo_iglesia->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$saldo_iglesia->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
		$saldo_iglesia->diezmo->setDbValue($rs->fields('diezmo'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $saldo_iglesia;

		// Call Row_Rendering event
		$saldo_iglesia->Row_Rendering();

		// Common render codes for all row types
		// idSaldoIglesia

		$saldo_iglesia->idSaldoIglesia->CellCssStyle = "";
		$saldo_iglesia->idSaldoIglesia->CellCssClass = "";

		// fecha
		$saldo_iglesia->fecha->CellCssStyle = "";
		$saldo_iglesia->fecha->CellCssClass = "";

		// nro_fact_recibo
		$saldo_iglesia->nro_fact_recibo->CellCssStyle = "";
		$saldo_iglesia->nro_fact_recibo->CellCssClass = "";

		// detalle
		$saldo_iglesia->detalle->CellCssStyle = "";
		$saldo_iglesia->detalle->CellCssClass = "";

		// ingreso
		$saldo_iglesia->ingreso->CellCssStyle = "";
		$saldo_iglesia->ingreso->CellCssClass = "";

		// egreso
		$saldo_iglesia->egreso->CellCssStyle = "";
		$saldo_iglesia->egreso->CellCssClass = "";
		if ($saldo_iglesia->RowType == EW_ROWTYPE_VIEW) { // View row

			// idSaldoIglesia
			$saldo_iglesia->idSaldoIglesia->ViewValue = $saldo_iglesia->idSaldoIglesia->CurrentValue;
			$saldo_iglesia->idSaldoIglesia->CssStyle = "";
			$saldo_iglesia->idSaldoIglesia->CssClass = "";
			$saldo_iglesia->idSaldoIglesia->ViewCustomAttributes = "";

			// fecha
			$saldo_iglesia->fecha->ViewValue = $saldo_iglesia->fecha->CurrentValue;
			$saldo_iglesia->fecha->ViewValue = ew_FormatDateTime($saldo_iglesia->fecha->ViewValue, 7);
			$saldo_iglesia->fecha->CssStyle = "";
			$saldo_iglesia->fecha->CssClass = "";
			$saldo_iglesia->fecha->ViewCustomAttributes = "";

			// nro_fact_recibo
			$saldo_iglesia->nro_fact_recibo->ViewValue = $saldo_iglesia->nro_fact_recibo->CurrentValue;
			$saldo_iglesia->nro_fact_recibo->CssStyle = "";
			$saldo_iglesia->nro_fact_recibo->CssClass = "";
			$saldo_iglesia->nro_fact_recibo->ViewCustomAttributes = "";

			// detalle
			$saldo_iglesia->detalle->ViewValue = $saldo_iglesia->detalle->CurrentValue;
			$saldo_iglesia->detalle->CssStyle = "";
			$saldo_iglesia->detalle->CssClass = "";
			$saldo_iglesia->detalle->ViewCustomAttributes = "";

			// ingreso
			$saldo_iglesia->ingreso->ViewValue = $saldo_iglesia->ingreso->CurrentValue;
			$saldo_iglesia->ingreso->CssStyle = "";
			$saldo_iglesia->ingreso->CssClass = "";
			$saldo_iglesia->ingreso->ViewCustomAttributes = "";

			// egreso
			$saldo_iglesia->egreso->ViewValue = $saldo_iglesia->egreso->CurrentValue;
			$saldo_iglesia->egreso->CssStyle = "";
			$saldo_iglesia->egreso->CssClass = "";
			$saldo_iglesia->egreso->ViewCustomAttributes = "";

			// idSaldoIglesia
			$saldo_iglesia->idSaldoIglesia->HrefValue = "";

			// fecha
			$saldo_iglesia->fecha->HrefValue = "";

			// nro_fact_recibo
			$saldo_iglesia->nro_fact_recibo->HrefValue = "";

			// detalle
			$saldo_iglesia->detalle->HrefValue = "";

			// ingreso
			$saldo_iglesia->ingreso->HrefValue = "";

			// egreso
			$saldo_iglesia->egreso->HrefValue = "";
		}

		// Call Row Rendered event
		$saldo_iglesia->Row_Rendered();
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
