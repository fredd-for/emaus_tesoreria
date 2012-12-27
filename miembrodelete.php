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
$miembro_delete = new cmiembro_delete();
$Page =& $miembro_delete;

// Page init processing
$miembro_delete->Page_Init();

// Page main processing
$miembro_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var miembro_delete = new ew_Page("miembro_delete");

// page properties
miembro_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = miembro_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
miembro_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
miembro_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
miembro_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $miembro_delete->LoadRecordset();
$miembro_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($miembro_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$miembro_delete->Page_Terminate("miembrolist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Miembro<br><br>
<a href="<?php echo $miembro->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $miembro_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="miembro">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($miembro_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $miembro->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Nombre(s)</td>
		<td valign="top">Apellido Paterno</td>
		<td valign="top">Apellido Materno</td>
		<td valign="top">Cargo en la Iglesia</td>
		<td valign="top">Diezma</td>
	</tr>
	</thead>
	<tbody>
<?php
$miembro_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$miembro_delete->lRecCnt++;

	// Set row properties
	$miembro->CssClass = "";
	$miembro->CssStyle = "";
	$miembro->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$miembro_delete->LoadRowValues($rs);

	// Render row
	$miembro_delete->RenderRow();
?>
	<tr<?php echo $miembro->RowAttributes() ?>>
		<td<?php echo $miembro->idMiembro->CellAttributes() ?>>
<div<?php echo $miembro->idMiembro->ViewAttributes() ?>><?php echo $miembro->idMiembro->ListViewValue() ?></div></td>
		<td<?php echo $miembro->nombre->CellAttributes() ?>>
<div<?php echo $miembro->nombre->ViewAttributes() ?>><?php echo $miembro->nombre->ListViewValue() ?></div></td>
		<td<?php echo $miembro->paterno->CellAttributes() ?>>
<div<?php echo $miembro->paterno->ViewAttributes() ?>><?php echo $miembro->paterno->ListViewValue() ?></div></td>
		<td<?php echo $miembro->materno->CellAttributes() ?>>
<div<?php echo $miembro->materno->ViewAttributes() ?>><?php echo $miembro->materno->ListViewValue() ?></div></td>
		<td<?php echo $miembro->cargo->CellAttributes() ?>>
<div<?php echo $miembro->cargo->ViewAttributes() ?>><?php echo $miembro->cargo->ListViewValue() ?></div></td>
		<td<?php echo $miembro->diezma->CellAttributes() ?>>
<div<?php echo $miembro->diezma->ViewAttributes() ?>><?php echo $miembro->diezma->ListViewValue() ?></div></td>
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
class cmiembro_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'miembro';

	// Page Object Name
	var $PageObjName = 'miembro_delete';

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
	function cmiembro_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["miembro"] = new cmiembro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'miembro', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $miembro;
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
			$this->Page_Terminate("miembrolist.php");
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
		global $miembro;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idMiembro"] <> "") {
			$miembro->idMiembro->setQueryStringValue($_GET["idMiembro"]);
			if (!is_numeric($miembro->idMiembro->QueryStringValue))
				$this->Page_Terminate("miembrolist.php"); // Prevent SQL injection, exit
			$sKey .= $miembro->idMiembro->QueryStringValue;
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
			$this->Page_Terminate("miembrolist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("miembrolist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idMiembro`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in miembro class, miembroinfo.php

		$miembro->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$miembro->CurrentAction = $_POST["a_delete"];
		} else {
			$miembro->CurrentAction = "D"; // Delete record directly
		}
		switch ($miembro->CurrentAction) {
			case "D": // Delete
				$miembro->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($miembro->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $miembro;
		$DeleteRows = TRUE;
		$sWrkFilter = $miembro->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in miembro class, miembroinfo.php

		$miembro->CurrentFilter = $sWrkFilter;
		$sSql = $miembro->SQL();
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
				$DeleteRows = $miembro->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idMiembro'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($miembro->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($miembro->CancelMessage <> "") {
				$this->setMessage($miembro->CancelMessage);
				$miembro->CancelMessage = "";
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
				$miembro->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
