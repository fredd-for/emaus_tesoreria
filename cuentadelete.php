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
$cuenta_delete = new ccuenta_delete();
$Page =& $cuenta_delete;

// Page init processing
$cuenta_delete->Page_Init();

// Page main processing
$cuenta_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cuenta_delete = new ew_Page("cuenta_delete");

// page properties
cuenta_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = cuenta_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cuenta_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cuenta_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cuenta_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $cuenta_delete->LoadRecordset();
$cuenta_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($cuenta_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$cuenta_delete->Page_Terminate("cuentalist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Cuenta<br><br>
<a href="<?php echo $cuenta->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $cuenta_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="cuenta">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cuenta_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $cuenta->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Nro</td>
		<td valign="top">Cuenta</td>
		<td valign="top">Porcentaje</td>
	</tr>
	</thead>
	<tbody>
<?php
$cuenta_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$cuenta_delete->lRecCnt++;

	// Set row properties
	$cuenta->CssClass = "";
	$cuenta->CssStyle = "";
	$cuenta->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cuenta_delete->LoadRowValues($rs);

	// Render row
	$cuenta_delete->RenderRow();
?>
	<tr<?php echo $cuenta->RowAttributes() ?>>
		<td<?php echo $cuenta->idCuenta->CellAttributes() ?>>
<div<?php echo $cuenta->idCuenta->ViewAttributes() ?>><?php echo $cuenta->idCuenta->ListViewValue() ?></div></td>
		<td<?php echo $cuenta->cuenta->CellAttributes() ?>>
<div<?php echo $cuenta->cuenta->ViewAttributes() ?>><?php echo $cuenta->cuenta->ListViewValue() ?></div></td>
		<td<?php echo $cuenta->porcentaje->CellAttributes() ?>>
<div<?php echo $cuenta->porcentaje->ViewAttributes() ?>><?php echo $cuenta->porcentaje->ListViewValue() ?></div></td>
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
class ccuenta_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'cuenta';

	// Page Object Name
	var $PageObjName = 'cuenta_delete';

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
	function ccuenta_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["cuenta"] = new ccuenta();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("cuentalist.php");
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
		global $cuenta;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idCuenta"] <> "") {
			$cuenta->idCuenta->setQueryStringValue($_GET["idCuenta"]);
			if (!is_numeric($cuenta->idCuenta->QueryStringValue))
				$this->Page_Terminate("cuentalist.php"); // Prevent SQL injection, exit
			$sKey .= $cuenta->idCuenta->QueryStringValue;
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
			$this->Page_Terminate("cuentalist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("cuentalist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idCuenta`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in cuenta class, cuentainfo.php

		$cuenta->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$cuenta->CurrentAction = $_POST["a_delete"];
		} else {
			$cuenta->CurrentAction = "D"; // Delete record directly
		}
		switch ($cuenta->CurrentAction) {
			case "D": // Delete
				$cuenta->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($cuenta->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $cuenta;
		$DeleteRows = TRUE;
		$sWrkFilter = $cuenta->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in cuenta class, cuentainfo.php

		$cuenta->CurrentFilter = $sWrkFilter;
		$sSql = $cuenta->SQL();
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
				$DeleteRows = $cuenta->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idCuenta'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($cuenta->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($cuenta->CancelMessage <> "") {
				$this->setMessage($cuenta->CancelMessage);
				$cuenta->CancelMessage = "";
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
				$cuenta->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
