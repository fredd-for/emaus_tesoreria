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
$rol_delete = new crol_delete();
$Page =& $rol_delete;

// Page init processing
$rol_delete->Page_Init();

// Page main processing
$rol_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var rol_delete = new ew_Page("rol_delete");

// page properties
rol_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = rol_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
rol_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rol_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rol_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $rol_delete->LoadRecordset();
$rol_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($rol_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$rol_delete->Page_Terminate("rollist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Rol<br><br>
<a href="<?php echo $rol->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $rol_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="rol">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($rol_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $rol->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">Id Rol</td>
		<td valign="top">Nombre</td>
	</tr>
	</thead>
	<tbody>
<?php
$rol_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$rol_delete->lRecCnt++;

	// Set row properties
	$rol->CssClass = "";
	$rol->CssStyle = "";
	$rol->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$rol_delete->LoadRowValues($rs);

	// Render row
	$rol_delete->RenderRow();
?>
	<tr<?php echo $rol->RowAttributes() ?>>
		<td<?php echo $rol->idRol->CellAttributes() ?>>
<div<?php echo $rol->idRol->ViewAttributes() ?>><?php echo $rol->idRol->ListViewValue() ?></div></td>
		<td<?php echo $rol->nombre->CellAttributes() ?>>
<div<?php echo $rol->nombre->ViewAttributes() ?>><?php echo $rol->nombre->ListViewValue() ?></div></td>
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
class crol_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'rol';

	// Page Object Name
	var $PageObjName = 'rol_delete';

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
	function crol_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["rol"] = new crol();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rol', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
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
		global $rol;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idRol"] <> "") {
			$rol->idRol->setQueryStringValue($_GET["idRol"]);
			if (!is_numeric($rol->idRol->QueryStringValue))
				$this->Page_Terminate("rollist.php"); // Prevent SQL injection, exit
			$sKey .= $rol->idRol->QueryStringValue;
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
			$this->Page_Terminate("rollist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("rollist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idRol`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in rol class, rolinfo.php

		$rol->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$rol->CurrentAction = $_POST["a_delete"];
		} else {
			$rol->CurrentAction = "D"; // Delete record directly
		}
		switch ($rol->CurrentAction) {
			case "D": // Delete
				$rol->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($rol->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $rol;
		$DeleteRows = TRUE;
		$sWrkFilter = $rol->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in rol class, rolinfo.php

		$rol->CurrentFilter = $sWrkFilter;
		$sSql = $rol->SQL();
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
				$DeleteRows = $rol->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idRol'];
				$x_idRol = $row['idRol']; // Get User Level id
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($rol->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
				if (!is_null($x_idRol)) {
					$conn->Execute("DELETE FROM " . EW_USER_LEVEL_PRIV_TABLE . " WHERE " . EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $x_idRol); // Delete user rights as well
				}
			}
		} else {

			// Set up error message
			if ($rol->CancelMessage <> "") {
				$this->setMessage($rol->CancelMessage);
				$rol->CancelMessage = "";
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
				$rol->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
