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
$permiso_delete = new cpermiso_delete();
$Page =& $permiso_delete;

// Page init processing
$permiso_delete->Page_Init();

// Page main processing
$permiso_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var permiso_delete = new ew_Page("permiso_delete");

// page properties
permiso_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = permiso_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
permiso_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
permiso_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
permiso_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $permiso_delete->LoadRecordset();
$permiso_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($permiso_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$permiso_delete->Page_Terminate("permisolist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Permiso<br><br>
<a href="<?php echo $permiso->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $permiso_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="permiso">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($permiso_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $permiso->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Id Rol</td>
		<td valign="top">Nombre</td>
		<td valign="top">Permiso</td>
	</tr>
	</thead>
	<tbody>
<?php
$permiso_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$permiso_delete->lRecCnt++;

	// Set row properties
	$permiso->CssClass = "";
	$permiso->CssStyle = "";
	$permiso->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$permiso_delete->LoadRowValues($rs);

	// Render row
	$permiso_delete->RenderRow();
?>
	<tr<?php echo $permiso->RowAttributes() ?>>
		<td<?php echo $permiso->idRol->CellAttributes() ?>>
<div<?php echo $permiso->idRol->ViewAttributes() ?>><?php echo $permiso->idRol->ListViewValue() ?></div></td>
		<td<?php echo $permiso->nombre->CellAttributes() ?>>
<div<?php echo $permiso->nombre->ViewAttributes() ?>><?php echo $permiso->nombre->ListViewValue() ?></div></td>
		<td<?php echo $permiso->permiso->CellAttributes() ?>>
<div<?php echo $permiso->permiso->ViewAttributes() ?>><?php echo $permiso->permiso->ListViewValue() ?></div></td>
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
class cpermiso_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'permiso';

	// Page Object Name
	var $PageObjName = 'permiso_delete';

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
	function cpermiso_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["permiso"] = new cpermiso();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'permiso', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
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
		global $permiso;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idRol"] <> "") {
			$permiso->idRol->setQueryStringValue($_GET["idRol"]);
			if (!is_numeric($permiso->idRol->QueryStringValue))
				$this->Page_Terminate("permisolist.php"); // Prevent SQL injection, exit
			$sKey .= $permiso->idRol->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if (@$_GET["nombre"] <> "") {
			$permiso->nombre->setQueryStringValue($_GET["nombre"]);
			if ($sKey <> "") $sKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sKey .= $permiso->nombre->QueryStringValue;
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
			$this->Page_Terminate("permisolist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";
			$arKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, trim($sKey)); // Split key by separator
			if (count($arKeyFlds) <> 2)
				$this->Page_Terminate($permiso->getReturnUrl()); // Invalid key, exit

			// Set up key field
			$sKeyFld = $arKeyFlds[0];
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("permisolist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idRol`=" . ew_AdjustSql($sKeyFld) . " AND ";

			// Set up key field
			$sKeyFld = $arKeyFlds[1];
			$sFilter .= "`nombre`='" . ew_AdjustSql($sKeyFld) . "' AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in permiso class, permisoinfo.php

		$permiso->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$permiso->CurrentAction = $_POST["a_delete"];
		} else {
			$permiso->CurrentAction = "D"; // Delete record directly
		}
		switch ($permiso->CurrentAction) {
			case "D": // Delete
				$permiso->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($permiso->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $permiso;
		$DeleteRows = TRUE;
		$sWrkFilter = $permiso->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in permiso class, permisoinfo.php

		$permiso->CurrentFilter = $sWrkFilter;
		$sSql = $permiso->SQL();
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
				$DeleteRows = $permiso->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idRol'];
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['nombre'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($permiso->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($permiso->CancelMessage <> "") {
				$this->setMessage($permiso->CancelMessage);
				$permiso->CancelMessage = "";
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
				$permiso->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
