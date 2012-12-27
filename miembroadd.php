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
$miembro_add = new cmiembro_add();
$Page =& $miembro_add;

// Page init processing
$miembro_add->Page_Init();

// Page main processing
$miembro_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var miembro_add = new ew_Page("miembro_add");

// page properties
miembro_add.PageID = "add"; // page ID
var EW_PAGE_ID = miembro_add.PageID; // for backward compatibility

// extend page with ValidateForm function
miembro_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Nombre(s)");
		elm = fobj.elements["x" + infix + "_paterno"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Apellido Paterno");
		elm = fobj.elements["x" + infix + "_diezma"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Diezma");
		elm = fobj.elements["x" + infix + "_fechaCreacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Creacion");
		elm = fobj.elements["x" + infix + "_fechaCreacion"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Creacion");
		elm = fobj.elements["x" + infix + "_fechaModificacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Modificacion");
		elm = fobj.elements["x" + infix + "_fechaModificacion"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Modificacion");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
miembro_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
miembro_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
miembro_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Agregar a TABLA: Miembro<br><br>
<a href="<?php echo $miembro->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $miembro_add->ShowMessage() ?>
<form name="fmiembroadd" id="fmiembroadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return miembro_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="miembro">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($miembro->nombre->Visible) { // nombre ?>
	<tr<?php echo $miembro->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre(s)<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $miembro->nombre->CellAttributes() ?>><span id="el_nombre">
<input type="text" name="x_nombre" id="x_nombre" size="30" maxlength="100" value="<?php echo $miembro->nombre->EditValue ?>"<?php echo $miembro->nombre->EditAttributes() ?>>
</span><?php echo $miembro->nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($miembro->paterno->Visible) { // paterno ?>
	<tr<?php echo $miembro->paterno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Paterno<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $miembro->paterno->CellAttributes() ?>><span id="el_paterno">
<input type="text" name="x_paterno" id="x_paterno" size="30" maxlength="100" value="<?php echo $miembro->paterno->EditValue ?>"<?php echo $miembro->paterno->EditAttributes() ?>>
</span><?php echo $miembro->paterno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($miembro->materno->Visible) { // materno ?>
	<tr<?php echo $miembro->materno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Materno</td>
		<td<?php echo $miembro->materno->CellAttributes() ?>><span id="el_materno">
<input type="text" name="x_materno" id="x_materno" size="30" maxlength="100" value="<?php echo $miembro->materno->EditValue ?>"<?php echo $miembro->materno->EditAttributes() ?>>
</span><?php echo $miembro->materno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($miembro->cargo->Visible) { // cargo ?>
	<tr<?php echo $miembro->cargo->RowAttributes ?>>
		<td class="ewTableHeader">Cargo en la Iglesia</td>
		<td<?php echo $miembro->cargo->CellAttributes() ?>><span id="el_cargo">
<input type="text" name="x_cargo" id="x_cargo" size="30" maxlength="100" value="<?php echo $miembro->cargo->EditValue ?>"<?php echo $miembro->cargo->EditAttributes() ?>>
</span><?php echo $miembro->cargo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($miembro->diezma->Visible) { // diezma ?>
	<tr<?php echo $miembro->diezma->RowAttributes ?>>
		<td class="ewTableHeader">Diezma<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $miembro->diezma->CellAttributes() ?>><span id="el_diezma">
<div id="tp_x_diezma" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_diezma" id="x_diezma" value="{value}"<?php echo $miembro->diezma->EditAttributes() ?>></div>
<div id="dsl_x_diezma" repeatcolumn="1">
<?php
$arwrk = $miembro->diezma->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($miembro->diezma->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 1, 1) ?>
<label><input type="radio" name="x_diezma" id="x_diezma" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $miembro->diezma->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 1, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $miembro->diezma->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($miembro->fechaCreacion->Visible) { // fechaCreacion ?>
	<tr<?php echo $miembro->fechaCreacion->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Creacion<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $miembro->fechaCreacion->CellAttributes() ?>><span id="el_fechaCreacion">
<input type="text" name="x_fechaCreacion" id="x_fechaCreacion" value="<?php echo date("d-m-Y") ?>"<?php echo $miembro->fechaCreacion->EditAttributes() ?>>
</span><?php echo $miembro->fechaCreacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($miembro->fechaModificacion->Visible) { // fechaModificacion ?>
	<tr<?php echo $miembro->fechaModificacion->RowAttributes ?>>
		<td class="ewTableHeader">Fecha Modificacion<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $miembro->fechaModificacion->CellAttributes() ?>><span id="el_fechaModificacion">
<input type="text" name="x_fechaModificacion" id="x_fechaModificacion" value="<?php echo date("d-m-Y") ?>"<?php echo $miembro->fechaModificacion->EditAttributes() ?>>
</span><?php echo $miembro->fechaModificacion->CustomMsg ?></td>
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
class cmiembro_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'miembro';

	// Page Object Name
	var $PageObjName = 'miembro_add';

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
	function cmiembro_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["miembro"] = new cmiembro();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $miembro;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idMiembro"] != "") {
		  $miembro->idMiembro->setQueryStringValue($_GET["idMiembro"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $miembro->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$miembro->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $miembro->CurrentAction = "C"; // Copy Record
		  } else {
		    $miembro->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($miembro->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("miembrolist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$miembro->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $miembro->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$miembro->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $miembro;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $miembro;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $miembro;
		$miembro->nombre->setFormValue($objForm->GetValue("x_nombre"));
		$miembro->paterno->setFormValue($objForm->GetValue("x_paterno"));
		$miembro->materno->setFormValue($objForm->GetValue("x_materno"));
		$miembro->cargo->setFormValue($objForm->GetValue("x_cargo"));
		$miembro->diezma->setFormValue($objForm->GetValue("x_diezma"));
		$miembro->fechaCreacion->setFormValue($objForm->GetValue("x_fechaCreacion"));
		$miembro->fechaCreacion->CurrentValue = ew_UnFormatDateTime($miembro->fechaCreacion->CurrentValue, 7);
		$miembro->fechaModificacion->setFormValue($objForm->GetValue("x_fechaModificacion"));
		$miembro->fechaModificacion->CurrentValue = ew_UnFormatDateTime($miembro->fechaModificacion->CurrentValue, 7);
		$miembro->idMiembro->setFormValue($objForm->GetValue("x_idMiembro"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $miembro;
		$miembro->idMiembro->CurrentValue = $miembro->idMiembro->FormValue;
		$miembro->nombre->CurrentValue = $miembro->nombre->FormValue;
		$miembro->paterno->CurrentValue = $miembro->paterno->FormValue;
		$miembro->materno->CurrentValue = $miembro->materno->FormValue;
		$miembro->cargo->CurrentValue = $miembro->cargo->FormValue;
		$miembro->diezma->CurrentValue = $miembro->diezma->FormValue;
		$miembro->fechaCreacion->CurrentValue = $miembro->fechaCreacion->FormValue;
		$miembro->fechaCreacion->CurrentValue = ew_UnFormatDateTime($miembro->fechaCreacion->CurrentValue, 7);
		$miembro->fechaModificacion->CurrentValue = $miembro->fechaModificacion->FormValue;
		$miembro->fechaModificacion->CurrentValue = ew_UnFormatDateTime($miembro->fechaModificacion->CurrentValue, 7);
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

		// fechaCreacion
		$miembro->fechaCreacion->CellCssStyle = "";
		$miembro->fechaCreacion->CellCssClass = "";

		// fechaModificacion
		$miembro->fechaModificacion->CellCssStyle = "";
		$miembro->fechaModificacion->CellCssClass = "";
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

			// fechaCreacion
			$miembro->fechaCreacion->ViewValue = $miembro->fechaCreacion->CurrentValue;
			$miembro->fechaCreacion->ViewValue = ew_FormatDateTime($miembro->fechaCreacion->ViewValue, 7);
			$miembro->fechaCreacion->CssStyle = "";
			$miembro->fechaCreacion->CssClass = "";
			$miembro->fechaCreacion->ViewCustomAttributes = "";

			// fechaModificacion
			$miembro->fechaModificacion->ViewValue = $miembro->fechaModificacion->CurrentValue;
			$miembro->fechaModificacion->ViewValue = ew_FormatDateTime($miembro->fechaModificacion->ViewValue, 7);
			$miembro->fechaModificacion->CssStyle = "";
			$miembro->fechaModificacion->CssClass = "";
			$miembro->fechaModificacion->ViewCustomAttributes = "";

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

			// fechaCreacion
			$miembro->fechaCreacion->HrefValue = "";

			// fechaModificacion
			$miembro->fechaModificacion->HrefValue = "";
		} elseif ($miembro->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre
			$miembro->nombre->EditCustomAttributes = "";
			$miembro->nombre->EditValue = ew_HtmlEncode($miembro->nombre->CurrentValue);

			// paterno
			$miembro->paterno->EditCustomAttributes = "";
			$miembro->paterno->EditValue = ew_HtmlEncode($miembro->paterno->CurrentValue);

			// materno
			$miembro->materno->EditCustomAttributes = "";
			$miembro->materno->EditValue = ew_HtmlEncode($miembro->materno->CurrentValue);

			// cargo
			$miembro->cargo->EditCustomAttributes = "";
			$miembro->cargo->EditValue = ew_HtmlEncode($miembro->cargo->CurrentValue);

			// diezma
			$miembro->diezma->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", "SI");
			$arwrk[] = array("0", "NO");
			$miembro->diezma->EditValue = $arwrk;

			// fechaCreacion
			$miembro->fechaCreacion->EditCustomAttributes = "";
			$miembro->fechaCreacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($miembro->fechaCreacion->CurrentValue, 7));

			// fechaModificacion
			$miembro->fechaModificacion->EditCustomAttributes = "";
			$miembro->fechaModificacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($miembro->fechaModificacion->CurrentValue, 7));
		}

		// Call Row Rendered event
		$miembro->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $miembro;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($miembro->nombre->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Nombre(s)";
		}
		if ($miembro->paterno->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Apellido Paterno";
		}
		if ($miembro->diezma->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Diezma";
		}
		if ($miembro->fechaCreacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Creacion";
		}
		if (!ew_CheckEuroDate($miembro->fechaCreacion->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Creacion";
		}
		if ($miembro->fechaModificacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Modificacion";
		}
		if (!ew_CheckEuroDate($miembro->fechaModificacion->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Modificacion";
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
		global $conn, $Security, $miembro;
		$rsnew = array();

		// Field nombre
		$miembro->nombre->SetDbValueDef($miembro->nombre->CurrentValue, "");
		$rsnew['nombre'] =& $miembro->nombre->DbValue;

		// Field paterno
		$miembro->paterno->SetDbValueDef($miembro->paterno->CurrentValue, "");
		$rsnew['paterno'] =& $miembro->paterno->DbValue;

		// Field materno
		$miembro->materno->SetDbValueDef($miembro->materno->CurrentValue, NULL);
		$rsnew['materno'] =& $miembro->materno->DbValue;

		// Field cargo
		$miembro->cargo->SetDbValueDef($miembro->cargo->CurrentValue, NULL);
		$rsnew['cargo'] =& $miembro->cargo->DbValue;

		// Field diezma
		$miembro->diezma->SetDbValueDef($miembro->diezma->CurrentValue, 0);
		$rsnew['diezma'] =& $miembro->diezma->DbValue;

		// Field fechaCreacion
		$miembro->fechaCreacion->SetDbValueDef(ew_UnFormatDateTime($miembro->fechaCreacion->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaCreacion'] =& $miembro->fechaCreacion->DbValue;

		// Field fechaModificacion
		$miembro->fechaModificacion->SetDbValueDef(ew_UnFormatDateTime($miembro->fechaModificacion->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaModificacion'] =& $miembro->fechaModificacion->DbValue;

		// Call Row Inserting event
		$bInsertRow = $miembro->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($miembro->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($miembro->CancelMessage <> "") {
				$this->setMessage($miembro->CancelMessage);
				$miembro->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$miembro->idMiembro->setDbValue($conn->Insert_ID());
			$rsnew['idMiembro'] =& $miembro->idMiembro->DbValue;

			// Call Row Inserted event
			$miembro->Row_Inserted($rsnew);
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
