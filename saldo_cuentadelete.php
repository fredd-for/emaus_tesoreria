<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "saldo_cuentainfo.php" ?>
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
$saldo_cuenta_delete = new csaldo_cuenta_delete();
$Page =& $saldo_cuenta_delete;

// Page init processing
$saldo_cuenta_delete->Page_Init();

// Page main processing
$saldo_cuenta_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var saldo_cuenta_delete = new ew_Page("saldo_cuenta_delete");

// page properties
saldo_cuenta_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = saldo_cuenta_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
saldo_cuenta_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
saldo_cuenta_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
saldo_cuenta_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $saldo_cuenta_delete->LoadRecordset();
$saldo_cuenta_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($saldo_cuenta_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$saldo_cuenta_delete->Page_Terminate("saldo_cuentalist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Saldo Cuenta<br><br>
<a href="<?php echo $saldo_cuenta->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $saldo_cuenta_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="saldo_cuenta">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($saldo_cuenta_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $saldo_cuenta->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Cuenta</td>
		<td valign="top">Fecha</td>
		<td valign="top">Nro Recibo</td>
		<td valign="top">Detalle</td>
		<td valign="top">Ingreso</td>
		<td valign="top">Egreso</td>
	</tr>
	</thead>
	<tbody>
<?php
$saldo_cuenta_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$saldo_cuenta_delete->lRecCnt++;

	// Set row properties
	$saldo_cuenta->CssClass = "";
	$saldo_cuenta->CssStyle = "";
	$saldo_cuenta->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$saldo_cuenta_delete->LoadRowValues($rs);

	// Render row
	$saldo_cuenta_delete->RenderRow();
?>
	<tr<?php echo $saldo_cuenta->RowAttributes() ?>>
		<td<?php echo $saldo_cuenta->idSaldoCuenta->CellAttributes() ?>>
<div<?php echo $saldo_cuenta->idSaldoCuenta->ViewAttributes() ?>><?php echo $saldo_cuenta->idSaldoCuenta->ListViewValue() ?></div></td>
		<td<?php echo $saldo_cuenta->idCuenta->CellAttributes() ?>>
<div<?php echo $saldo_cuenta->idCuenta->ViewAttributes() ?>><?php echo $saldo_cuenta->idCuenta->ListViewValue() ?></div></td>
		<td<?php echo $saldo_cuenta->fecha->CellAttributes() ?>>
<div<?php echo $saldo_cuenta->fecha->ViewAttributes() ?>><?php echo $saldo_cuenta->fecha->ListViewValue() ?></div></td>
		<td<?php echo $saldo_cuenta->nro_fact_recibo->CellAttributes() ?>>
<div<?php echo $saldo_cuenta->nro_fact_recibo->ViewAttributes() ?>><?php echo $saldo_cuenta->nro_fact_recibo->ListViewValue() ?></div></td>
		<td<?php echo $saldo_cuenta->detalle->CellAttributes() ?>>
<div<?php echo $saldo_cuenta->detalle->ViewAttributes() ?>><?php echo $saldo_cuenta->detalle->ListViewValue() ?></div></td>
		<td<?php echo $saldo_cuenta->ingreso->CellAttributes() ?>>
<div<?php echo $saldo_cuenta->ingreso->ViewAttributes() ?>><?php echo $saldo_cuenta->ingreso->ListViewValue() ?></div></td>
		<td<?php echo $saldo_cuenta->egreso->CellAttributes() ?>>
<div<?php echo $saldo_cuenta->egreso->ViewAttributes() ?>><?php echo $saldo_cuenta->egreso->ListViewValue() ?></div></td>
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
class csaldo_cuenta_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'saldo_cuenta';

	// Page Object Name
	var $PageObjName = 'saldo_cuenta_delete';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $saldo_cuenta;
		if ($saldo_cuenta->UseTokenInUrl) $PageUrl .= "t=" . $saldo_cuenta->TableVar . "&"; // add page token
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
		global $objForm, $saldo_cuenta;
		if ($saldo_cuenta->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($saldo_cuenta->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($saldo_cuenta->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function csaldo_cuenta_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["saldo_cuenta"] = new csaldo_cuenta();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'saldo_cuenta', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $saldo_cuenta;
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
		global $saldo_cuenta;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idSaldoCuenta"] <> "") {
			$saldo_cuenta->idSaldoCuenta->setQueryStringValue($_GET["idSaldoCuenta"]);
			if (!is_numeric($saldo_cuenta->idSaldoCuenta->QueryStringValue))
				$this->Page_Terminate("saldo_cuentalist.php"); // Prevent SQL injection, exit
			$sKey .= $saldo_cuenta->idSaldoCuenta->QueryStringValue;
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
			$this->Page_Terminate("saldo_cuentalist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("saldo_cuentalist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idSaldoCuenta`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in saldo_cuenta class, saldo_cuentainfo.php

		$saldo_cuenta->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$saldo_cuenta->CurrentAction = $_POST["a_delete"];
		} else {
			$saldo_cuenta->CurrentAction = "D"; // Delete record directly
		}
		switch ($saldo_cuenta->CurrentAction) {
			case "D": // Delete
				$saldo_cuenta->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($saldo_cuenta->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $saldo_cuenta;
		$DeleteRows = TRUE;
		$sWrkFilter = $saldo_cuenta->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in saldo_cuenta class, saldo_cuentainfo.php

		$saldo_cuenta->CurrentFilter = $sWrkFilter;
		$sSql = $saldo_cuenta->SQL();
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
				$DeleteRows = $saldo_cuenta->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idSaldoCuenta'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($saldo_cuenta->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($saldo_cuenta->CancelMessage <> "") {
				$this->setMessage($saldo_cuenta->CancelMessage);
				$saldo_cuenta->CancelMessage = "";
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
				$saldo_cuenta->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $saldo_cuenta;

		// Call Recordset Selecting event
		$saldo_cuenta->Recordset_Selecting($saldo_cuenta->CurrentFilter);

		// Load list page SQL
		$sSql = $saldo_cuenta->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$saldo_cuenta->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $saldo_cuenta;
		$sFilter = $saldo_cuenta->KeyFilter();

		// Call Row Selecting event
		$saldo_cuenta->Row_Selecting($sFilter);

		// Load sql based on filter
		$saldo_cuenta->CurrentFilter = $sFilter;
		$sSql = $saldo_cuenta->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$saldo_cuenta->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $saldo_cuenta;
		$saldo_cuenta->idSaldoCuenta->setDbValue($rs->fields('idSaldoCuenta'));
		$saldo_cuenta->idCuenta->setDbValue($rs->fields('idCuenta'));
		$saldo_cuenta->fecha->setDbValue($rs->fields('fecha'));
		$saldo_cuenta->nro_fact_recibo->setDbValue($rs->fields('nro_fact_recibo'));
		$saldo_cuenta->detalle->setDbValue($rs->fields('detalle'));
		$saldo_cuenta->ingreso->setDbValue($rs->fields('ingreso'));
		$saldo_cuenta->egreso->setDbValue($rs->fields('egreso'));
		$saldo_cuenta->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$saldo_cuenta->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
		$saldo_cuenta->diezmo->setDbValue($rs->fields('diezmo'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $saldo_cuenta;

		// Call Row_Rendering event
		$saldo_cuenta->Row_Rendering();

		// Common render codes for all row types
		// idSaldoCuenta

		$saldo_cuenta->idSaldoCuenta->CellCssStyle = "";
		$saldo_cuenta->idSaldoCuenta->CellCssClass = "";

		// idCuenta
		$saldo_cuenta->idCuenta->CellCssStyle = "";
		$saldo_cuenta->idCuenta->CellCssClass = "";

		// fecha
		$saldo_cuenta->fecha->CellCssStyle = "";
		$saldo_cuenta->fecha->CellCssClass = "";

		// nro_fact_recibo
		$saldo_cuenta->nro_fact_recibo->CellCssStyle = "";
		$saldo_cuenta->nro_fact_recibo->CellCssClass = "";

		// detalle
		$saldo_cuenta->detalle->CellCssStyle = "";
		$saldo_cuenta->detalle->CellCssClass = "";

		// ingreso
		$saldo_cuenta->ingreso->CellCssStyle = "";
		$saldo_cuenta->ingreso->CellCssClass = "";

		// egreso
		$saldo_cuenta->egreso->CellCssStyle = "";
		$saldo_cuenta->egreso->CellCssClass = "";
		if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View row

			// idSaldoCuenta
			$saldo_cuenta->idSaldoCuenta->ViewValue = $saldo_cuenta->idSaldoCuenta->CurrentValue;
			$saldo_cuenta->idSaldoCuenta->CssStyle = "";
			$saldo_cuenta->idSaldoCuenta->CssClass = "";
			$saldo_cuenta->idSaldoCuenta->ViewCustomAttributes = "";

			// idCuenta
			if (strval($saldo_cuenta->idCuenta->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `cuenta` FROM `cuenta` WHERE `idCuenta` = " . ew_AdjustSql($saldo_cuenta->idCuenta->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `cuenta` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$saldo_cuenta->idCuenta->ViewValue = $rswrk->fields('cuenta');
					$rswrk->Close();
				} else {
					$saldo_cuenta->idCuenta->ViewValue = $saldo_cuenta->idCuenta->CurrentValue;
				}
			} else {
				$saldo_cuenta->idCuenta->ViewValue = NULL;
			}
			$saldo_cuenta->idCuenta->CssStyle = "";
			$saldo_cuenta->idCuenta->CssClass = "";
			$saldo_cuenta->idCuenta->ViewCustomAttributes = "";

			// fecha
			$saldo_cuenta->fecha->ViewValue = $saldo_cuenta->fecha->CurrentValue;
			$saldo_cuenta->fecha->ViewValue = ew_FormatDateTime($saldo_cuenta->fecha->ViewValue, 7);
			$saldo_cuenta->fecha->CssStyle = "";
			$saldo_cuenta->fecha->CssClass = "";
			$saldo_cuenta->fecha->ViewCustomAttributes = "";

			// nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->ViewValue = $saldo_cuenta->nro_fact_recibo->CurrentValue;
			$saldo_cuenta->nro_fact_recibo->CssStyle = "";
			$saldo_cuenta->nro_fact_recibo->CssClass = "";
			$saldo_cuenta->nro_fact_recibo->ViewCustomAttributes = "";

			// detalle
			$saldo_cuenta->detalle->ViewValue = $saldo_cuenta->detalle->CurrentValue;
			$saldo_cuenta->detalle->CssStyle = "";
			$saldo_cuenta->detalle->CssClass = "";
			$saldo_cuenta->detalle->ViewCustomAttributes = "";

			// ingreso
			$saldo_cuenta->ingreso->ViewValue = $saldo_cuenta->ingreso->CurrentValue;
			$saldo_cuenta->ingreso->CssStyle = "";
			$saldo_cuenta->ingreso->CssClass = "";
			$saldo_cuenta->ingreso->ViewCustomAttributes = "";

			// egreso
			$saldo_cuenta->egreso->ViewValue = $saldo_cuenta->egreso->CurrentValue;
			$saldo_cuenta->egreso->CssStyle = "";
			$saldo_cuenta->egreso->CssClass = "";
			$saldo_cuenta->egreso->ViewCustomAttributes = "";

			// idSaldoCuenta
			$saldo_cuenta->idSaldoCuenta->HrefValue = "";

			// idCuenta
			$saldo_cuenta->idCuenta->HrefValue = "";

			// fecha
			$saldo_cuenta->fecha->HrefValue = "";

			// nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->HrefValue = "";

			// detalle
			$saldo_cuenta->detalle->HrefValue = "";

			// ingreso
			$saldo_cuenta->ingreso->HrefValue = "";

			// egreso
			$saldo_cuenta->egreso->HrefValue = "";
		}

		// Call Row Rendered event
		$saldo_cuenta->Row_Rendered();
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
