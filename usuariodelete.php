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
$usuario_delete = new cusuario_delete();
$Page =& $usuario_delete;

// Page init processing
$usuario_delete->Page_Init();

// Page main processing
$usuario_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var usuario_delete = new ew_Page("usuario_delete");

// page properties
usuario_delete.PageID = "delete"; // page ID
var EW_PAGE_ID = usuario_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
usuario_delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
usuario_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
usuario_delete.ValidateRequired = false; // no JavaScript validation
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
$rs = $usuario_delete->LoadRecordset();
$usuario_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($usuario_deletelTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	$usuario_delete->Page_Terminate("usuariolist.php"); // Return to list
}
?>
<p><span class="phpmaker">Borrar de TABLA: Usuario<br><br>
<a href="<?php echo $usuario->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $usuario_delete->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="usuario">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($usuario_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $usuario->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top">No</td>
		<td valign="top">Rol</td>
		<td valign="top">Nombre(s)</td>
		<td valign="top">Apellido Paterno</td>
		<td valign="top">Apellido Materno</td>
		<td valign="top">C.I</td>
		<td valign="top">Cargo en la Iglesia</td>
	</tr>
	</thead>
	<tbody>
<?php
$usuario_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$usuario_delete->lRecCnt++;

	// Set row properties
	$usuario->CssClass = "";
	$usuario->CssStyle = "";
	$usuario->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$usuario_delete->LoadRowValues($rs);

	// Render row
	$usuario_delete->RenderRow();
?>
	<tr<?php echo $usuario->RowAttributes() ?>>
		<td<?php echo $usuario->idUsuario->CellAttributes() ?>>
<div<?php echo $usuario->idUsuario->ViewAttributes() ?>><?php echo $usuario->idUsuario->ListViewValue() ?></div></td>
		<td<?php echo $usuario->idRol->CellAttributes() ?>>
<div<?php echo $usuario->idRol->ViewAttributes() ?>><?php echo $usuario->idRol->ListViewValue() ?></div></td>
		<td<?php echo $usuario->nombre->CellAttributes() ?>>
<div<?php echo $usuario->nombre->ViewAttributes() ?>><?php echo $usuario->nombre->ListViewValue() ?></div></td>
		<td<?php echo $usuario->paterno->CellAttributes() ?>>
<div<?php echo $usuario->paterno->ViewAttributes() ?>><?php echo $usuario->paterno->ListViewValue() ?></div></td>
		<td<?php echo $usuario->materno->CellAttributes() ?>>
<div<?php echo $usuario->materno->ViewAttributes() ?>><?php echo $usuario->materno->ListViewValue() ?></div></td>
		<td<?php echo $usuario->ci->CellAttributes() ?>>
<div<?php echo $usuario->ci->ViewAttributes() ?>><?php echo $usuario->ci->ListViewValue() ?></div></td>
		<td<?php echo $usuario->cargo->CellAttributes() ?>>
<div<?php echo $usuario->cargo->ViewAttributes() ?>><?php echo $usuario->cargo->ListViewValue() ?></div></td>
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
class cusuario_delete {

	// Page ID
	var $PageID = 'delete';

	// Table Name
	var $TableName = 'usuario';

	// Page Object Name
	var $PageObjName = 'usuario_delete';

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
	function cusuario_delete() {
		global $conn;

		// Initialize table object
		$GLOBALS["usuario"] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuario', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("usuariolist.php");
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
		global $usuario;

		// Load Key Parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["idUsuario"] <> "") {
			$usuario->idUsuario->setQueryStringValue($_GET["idUsuario"]);
			if (!is_numeric($usuario->idUsuario->QueryStringValue))
				$this->Page_Terminate("usuariolist.php"); // Prevent SQL injection, exit
			$sKey .= $usuario->idUsuario->QueryStringValue;
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
			$this->Page_Terminate("usuariolist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("usuariolist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`idUsuario`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WhHERE clause) and get return SQL
		// SQL constructor in SQL constructor in usuario class, usuarioinfo.php

		$usuario->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$usuario->CurrentAction = $_POST["a_delete"];
		} else {
			$usuario->CurrentAction = "D"; // Delete record directly
		}
		switch ($usuario->CurrentAction) {
			case "D": // Delete
				$usuario->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage("Borrado Exitoso"); // Set up success message
					$this->Page_Terminate($usuario->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	//  Function DeleteRows
	//  - Delete Records based on current filter
	//
	function DeleteRows() {
		global $conn, $Security, $usuario;
		$DeleteRows = TRUE;
		$sWrkFilter = $usuario->CurrentFilter;

		// Set up filter (Sql Where Clause) and get Return SQL
		// SQL constructor in usuario class, usuarioinfo.php

		$usuario->CurrentFilter = $sWrkFilter;
		$sSql = $usuario->SQL();
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
				$DeleteRows = $usuario->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['idUsuario'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($usuario->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($usuario->CancelMessage <> "") {
				$this->setMessage($usuario->CancelMessage);
				$usuario->CancelMessage = "";
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
				$usuario->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
