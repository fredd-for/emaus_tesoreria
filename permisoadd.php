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
$permiso_add = new cpermiso_add();
$Page =& $permiso_add;

// Page init processing
$permiso_add->Page_Init();

// Page main processing
$permiso_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var permiso_add = new ew_Page("permiso_add");

// page properties
permiso_add.PageID = "add"; // page ID
var EW_PAGE_ID = permiso_add.PageID; // for backward compatibility

// extend page with ValidateForm function
permiso_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idRol"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Id Rol");
		elm = fobj.elements["x" + infix + "_idRol"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Id Rol");
		elm = fobj.elements["x" + infix + "_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Nombre");
		elm = fobj.elements["x" + infix + "_permiso"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Permiso");
		elm = fobj.elements["x" + infix + "_permiso"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Permiso");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
permiso_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
permiso_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
permiso_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Agregar a TABLA: Permiso<br><br>
<a href="<?php echo $permiso->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $permiso_add->ShowMessage() ?>
<form name="fpermisoadd" id="fpermisoadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return permiso_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="permiso">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($permiso->idRol->Visible) { // idRol ?>
	<tr<?php echo $permiso->idRol->RowAttributes ?>>
		<td class="ewTableHeader">Id Rol<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $permiso->idRol->CellAttributes() ?>><span id="el_idRol">
<input type="text" name="x_idRol" id="x_idRol" size="30" value="<?php echo $permiso->idRol->EditValue ?>"<?php echo $permiso->idRol->EditAttributes() ?>>
</span><?php echo $permiso->idRol->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($permiso->nombre->Visible) { // nombre ?>
	<tr<?php echo $permiso->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $permiso->nombre->CellAttributes() ?>><span id="el_nombre">
<input type="text" name="x_nombre" id="x_nombre" size="30" maxlength="100" value="<?php echo $permiso->nombre->EditValue ?>"<?php echo $permiso->nombre->EditAttributes() ?>>
</span><?php echo $permiso->nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($permiso->permiso->Visible) { // permiso ?>
	<tr<?php echo $permiso->permiso->RowAttributes ?>>
		<td class="ewTableHeader">Permiso<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $permiso->permiso->CellAttributes() ?>><span id="el_permiso">
<input type="text" name="x_permiso" id="x_permiso" size="30" maxlength="100" value="<?php echo $permiso->permiso->EditValue ?>"<?php echo $permiso->permiso->EditAttributes() ?>>
</span><?php echo $permiso->permiso->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  AGREGAR  ">
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
class cpermiso_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'permiso';

	// Page Object Name
	var $PageObjName = 'permiso_add';

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
	function cpermiso_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["permiso"] = new cpermiso();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $permiso;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idRol"] != "") {
		  $permiso->idRol->setQueryStringValue($_GET["idRol"]);
		} else {
		  $bCopy = FALSE;
		}
		if (@$_GET["nombre"] != "") {
		  $permiso->nombre->setQueryStringValue($_GET["nombre"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $permiso->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$permiso->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $permiso->CurrentAction = "C"; // Copy Record
		  } else {
		    $permiso->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($permiso->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("permisolist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$permiso->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $permiso->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$permiso->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $permiso;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $permiso;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $permiso;
		$permiso->idRol->setFormValue($objForm->GetValue("x_idRol"));
		$permiso->nombre->setFormValue($objForm->GetValue("x_nombre"));
		$permiso->permiso->setFormValue($objForm->GetValue("x_permiso"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $permiso;
		$permiso->idRol->CurrentValue = $permiso->idRol->FormValue;
		$permiso->nombre->CurrentValue = $permiso->nombre->FormValue;
		$permiso->permiso->CurrentValue = $permiso->permiso->FormValue;
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
		} elseif ($permiso->RowType == EW_ROWTYPE_ADD) { // Add row

			// idRol
			$permiso->idRol->EditCustomAttributes = "";
			$permiso->idRol->EditValue = ew_HtmlEncode($permiso->idRol->CurrentValue);

			// nombre
			$permiso->nombre->EditCustomAttributes = "";
			$permiso->nombre->EditValue = ew_HtmlEncode($permiso->nombre->CurrentValue);

			// permiso
			$permiso->permiso->EditCustomAttributes = "";
			$permiso->permiso->EditValue = ew_HtmlEncode($permiso->permiso->CurrentValue);
		}

		// Call Row Rendered event
		$permiso->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $permiso;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($permiso->idRol->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Id Rol";
		}
		if (!ew_CheckInteger($permiso->idRol->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Id Rol";
		}
		if ($permiso->nombre->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Nombre";
		}
		if ($permiso->permiso->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Permiso";
		}
		if (!ew_CheckInteger($permiso->permiso->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Permiso";
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow() {
		global $conn, $Security, $permiso;

		// Check if key value entered
		if ($permiso->idRol->CurrentValue == "") {
			$this->setMessage("Valor de la llave incorrecto");
			return FALSE;
		}

		// Check if key value entered
		if ($permiso->nombre->CurrentValue == "") {
			$this->setMessage("Valor de la llave incorrecto");
			return FALSE;
		}

		// Check for duplicate key
		$bCheckKey = TRUE;
		$sFilter = $permiso->KeyFilter();
		if ($bCheckKey) {
			$rsChk = $permiso->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, "Llave primaria duplicado: '%f'");
				$this->setMessage($sKeyErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Field idRol
		$permiso->idRol->SetDbValueDef($permiso->idRol->CurrentValue, 0);
		$rsnew['idRol'] =& $permiso->idRol->DbValue;

		// Field nombre
		$permiso->nombre->SetDbValueDef($permiso->nombre->CurrentValue, "");
		$rsnew['nombre'] =& $permiso->nombre->DbValue;

		// Field permiso
		$permiso->permiso->SetDbValueDef($permiso->permiso->CurrentValue, 0);
		$rsnew['permiso'] =& $permiso->permiso->DbValue;

		// Call Row Inserting event
		$bInsertRow = $permiso->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($permiso->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($permiso->CancelMessage <> "") {
				$this->setMessage($permiso->CancelMessage);
				$permiso->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$permiso->Row_Inserted($rsnew);
		}
		return $AddRow;
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
