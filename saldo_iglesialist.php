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
$saldo_iglesia_list = new csaldo_iglesia_list();
$Page =& $saldo_iglesia_list;

// Page init processing
$saldo_iglesia_list->Page_Init();

// Page main processing
$saldo_iglesia_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($saldo_iglesia->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var saldo_iglesia_list = new ew_Page("saldo_iglesia_list");

// page properties
saldo_iglesia_list.PageID = "list"; // page ID
var EW_PAGE_ID = saldo_iglesia_list.PageID; // for backward compatibility

// extend page with ValidateForm function
saldo_iglesia_list.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha");
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd-mm-yyyy - Fecha");
		elm = fobj.elements["x" + infix + "_nro_fact_recibo"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Recibo");
		elm = fobj.elements["x" + infix + "_detalle"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Detalle");
		elm = fobj.elements["x" + infix + "_ingreso"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Número de Punto Flotante Incorrecto - Ingreso");
		elm = fobj.elements["x" + infix + "_egreso"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Número de Punto Flotante Incorrecto - Egreso");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
saldo_iglesia_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
saldo_iglesia_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
saldo_iglesia_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($saldo_iglesia->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($saldo_iglesia->Export == "" && $saldo_iglesia->SelectLimit);
	if (!$bSelectLimit)
		$rs = $saldo_iglesia_list->LoadRecordset();
	$saldo_iglesia_list->lTotalRecs = ($bSelectLimit) ? $saldo_iglesia->SelectRecordCount() : $rs->RecordCount();
	$saldo_iglesia_list->lStartRec = 1;
	if ($saldo_iglesia_list->lDisplayRecs <= 0) // Display all records
		$saldo_iglesia_list->lDisplayRecs = $saldo_iglesia_list->lTotalRecs;
	if (!($saldo_iglesia->ExportAll && $saldo_iglesia->Export <> ""))
		$saldo_iglesia_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $saldo_iglesia_list->LoadRecordset($saldo_iglesia_list->lStartRec-1, $saldo_iglesia_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLA: Saldo Iglesia
<?php if ($saldo_iglesia->Export == "" && $saldo_iglesia->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $saldo_iglesia_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $saldo_iglesia_list->ShowMessage() ?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fsaldo_iglesialist" id="fsaldo_iglesialist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="saldo_iglesia">
<?php if ($saldo_iglesia_list->lTotalRecs > 0 || $saldo_iglesia->CurrentAction == "add" || $saldo_iglesia->CurrentAction == "copy") { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$saldo_iglesia_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$saldo_iglesia_list->lOptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$saldo_iglesia_list->lOptionCnt++; // Delete
}
	$saldo_iglesia_list->lOptionCnt += count($saldo_iglesia_list->ListOptions->Items); // Custom list options
?>
<?php echo $saldo_iglesia->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($saldo_iglesia->idSaldoIglesia->Visible) { // idSaldoIglesia ?>
	<?php if ($saldo_iglesia->SortUrl($saldo_iglesia->idSaldoIglesia) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_iglesia->SortUrl($saldo_iglesia->idSaldoIglesia) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($saldo_iglesia->idSaldoIglesia->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_iglesia->idSaldoIglesia->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_iglesia->fecha->Visible) { // fecha ?>
	<?php if ($saldo_iglesia->SortUrl($saldo_iglesia->fecha) == "") { ?>
		<td>Fecha</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_iglesia->SortUrl($saldo_iglesia->fecha) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha</td><td style="width: 10px;"><?php if ($saldo_iglesia->fecha->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_iglesia->fecha->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_iglesia->nro_fact_recibo->Visible) { // nro_fact_recibo ?>
	<?php if ($saldo_iglesia->SortUrl($saldo_iglesia->nro_fact_recibo) == "") { ?>
		<td>Recibo</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_iglesia->SortUrl($saldo_iglesia->nro_fact_recibo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Recibo</td><td style="width: 10px;"><?php if ($saldo_iglesia->nro_fact_recibo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_iglesia->nro_fact_recibo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_iglesia->detalle->Visible) { // detalle ?>
	<?php if ($saldo_iglesia->SortUrl($saldo_iglesia->detalle) == "") { ?>
		<td>Detalle</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_iglesia->SortUrl($saldo_iglesia->detalle) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Detalle</td><td style="width: 10px;"><?php if ($saldo_iglesia->detalle->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_iglesia->detalle->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_iglesia->ingreso->Visible) { // ingreso ?>
	<?php if ($saldo_iglesia->SortUrl($saldo_iglesia->ingreso) == "") { ?>
		<td>Ingreso</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_iglesia->SortUrl($saldo_iglesia->ingreso) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Ingreso</td><td style="width: 10px;"><?php if ($saldo_iglesia->ingreso->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_iglesia->ingreso->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_iglesia->egreso->Visible) { // egreso ?>
	<?php if ($saldo_iglesia->SortUrl($saldo_iglesia->egreso) == "") { ?>
		<td>Egreso</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_iglesia->SortUrl($saldo_iglesia->egreso) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Egreso</td><td style="width: 10px;"><?php if ($saldo_iglesia->egreso->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_iglesia->egreso->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_iglesia->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($saldo_iglesia_list->lOptionCnt == 0 && $saldo_iglesia->CurrentAction == "add") { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($saldo_iglesia_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
	if ($saldo_iglesia->CurrentAction == "add" || $saldo_iglesia->CurrentAction == "copy") {
		$saldo_iglesia_list->lRowIndex = 1;
		if ($saldo_iglesia->CurrentAction == "add")
			$saldo_iglesia_list->LoadDefaultValues();
		if ($saldo_iglesia->EventCancelled) // Insert failed
			$saldo_iglesia_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$saldo_iglesia->CssClass = "ewTableEditRow";
		$saldo_iglesia->CssStyle = "";
		$saldo_iglesia->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
		$saldo_iglesia->RowType = EW_ROWTYPE_ADD;

		// Render row
		$saldo_iglesia_list->RenderRow();
?>
	<tr<?php echo $saldo_iglesia->RowAttributes() ?>>
	<?php if ($saldo_iglesia->idSaldoIglesia->Visible) { // idSaldoIglesia ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($saldo_iglesia->fecha->Visible) { // fecha ?>
		<td>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" value="<?php echo $saldo_iglesia->fecha->EditValue ?>"<?php echo $saldo_iglesia->fecha->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" name="cal_x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha", // ID of the input field
	ifFormat : "%d-%m-%Y", // the date format
	button : "cal_x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" // ID of the button
});
</script>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->nro_fact_recibo->Visible) { // nro_fact_recibo ?>
		<td>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_nro_fact_recibo" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_nro_fact_recibo" size="10" value="<?php echo $saldo_iglesia->nro_fact_recibo->EditValue ?>"<?php echo $saldo_iglesia->nro_fact_recibo->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->detalle->Visible) { // detalle ?>
		<td>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_detalle" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_detalle" size="30" maxlength="255" value="<?php echo $saldo_iglesia->detalle->EditValue ?>"<?php echo $saldo_iglesia->detalle->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->ingreso->Visible) { // ingreso ?>
		<td>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_ingreso" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_ingreso" size="10" value="<?php echo $saldo_iglesia->ingreso->EditValue ?>"<?php echo $saldo_iglesia->ingreso->EditAttributes() ?>>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->egreso->Visible) { // egreso ?>
		<td>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_egreso" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_egreso" size="10" value="<?php echo $saldo_iglesia->egreso->EditValue ?>"<?php echo $saldo_iglesia->egreso->EditAttributes() ?>>
</td>
	<?php } ?>
<td colspan="<?php echo $saldo_iglesia_list->lOptionCnt ?>"><span class="phpmaker">
<a href="" onclick="if (saldo_iglesia_list.ValidateForm(document.fsaldo_iglesialist)) document.fsaldo_iglesialist.submit();return false;">Insertar</a>&nbsp;<a href="<?php echo $saldo_iglesia_list->PageUrl() ?>a=cancel">Cancelar</a>
<input type="hidden" name="a_list" id="a_list" value="insert">
</span></td>
	</tr>
<?php
}
?>
<?php
if ($saldo_iglesia->ExportAll && $saldo_iglesia->Export <> "") {
	$saldo_iglesia_list->lStopRec = $saldo_iglesia_list->lTotalRecs;
} else {
	$saldo_iglesia_list->lStopRec = $saldo_iglesia_list->lStartRec + $saldo_iglesia_list->lDisplayRecs - 1; // Set the last record to display
}
$saldo_iglesia_list->lRecCount = $saldo_iglesia_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$saldo_iglesia->SelectLimit && $saldo_iglesia_list->lStartRec > 1)
		$rs->Move($saldo_iglesia_list->lStartRec - 1);
}
$saldo_iglesia_list->lRowCnt = 0;
$saldo_iglesia_list->lEditRowCnt = 0;
if ($saldo_iglesia->CurrentAction == "edit")
	$saldo_iglesia_list->lRowIndex = 1;
while (($saldo_iglesia->CurrentAction == "gridadd" || !$rs->EOF) &&
	$saldo_iglesia_list->lRecCount < $saldo_iglesia_list->lStopRec) {
	$saldo_iglesia_list->lRecCount++;
	if (intval($saldo_iglesia_list->lRecCount) >= intval($saldo_iglesia_list->lStartRec)) {
		$saldo_iglesia_list->lRowCnt++;

	// Init row class and style
	$saldo_iglesia->CssClass = "";
	$saldo_iglesia->CssStyle = "";
	$saldo_iglesia->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($saldo_iglesia->CurrentAction == "gridadd") {
		$saldo_iglesia_list->LoadDefaultValues(); // Load default values
	} else {
		$saldo_iglesia_list->LoadRowValues($rs); // Load row values
	}
	$saldo_iglesia->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($saldo_iglesia->CurrentAction == "edit") {
		if ($saldo_iglesia_list->CheckInlineEditKey() && $saldo_iglesia_list->lEditRowCnt == 0) // Inline edit
			$saldo_iglesia->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT && $saldo_iglesia->EventCancelled) { // Update failed
		if ($saldo_iglesia->CurrentAction == "edit")
			$saldo_iglesia_list->RestoreFormValues(); // Restore form values
	}
	if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit row
		$saldo_iglesia_list->lEditRowCnt++;
		$saldo_iglesia->RowClientEvents = "onmouseover='this.edit=true;ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	}
	if ($saldo_iglesia->RowType == EW_ROWTYPE_ADD || $saldo_iglesia->RowType == EW_ROWTYPE_EDIT) // Add / Edit row
			$saldo_iglesia->CssClass = "ewTableEditRow";

	// Render row
	$saldo_iglesia_list->RenderRow();
?>
	<tr<?php echo $saldo_iglesia->RowAttributes() ?>>
	<?php if ($saldo_iglesia->idSaldoIglesia->Visible) { // idSaldoIglesia ?>
		<td<?php echo $saldo_iglesia->idSaldoIglesia->CellAttributes() ?>>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $saldo_iglesia->idSaldoIglesia->ViewAttributes() ?>><?php echo $saldo_iglesia->idSaldoIglesia->EditValue ?></div><input type="hidden" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_idSaldoIglesia" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_idSaldoIglesia" value="<?php echo ew_HtmlEncode($saldo_iglesia->idSaldoIglesia->CurrentValue) ?>">
<?php } ?>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_iglesia->idSaldoIglesia->ViewAttributes() ?>><?php echo $saldo_iglesia->idSaldoIglesia->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->fecha->Visible) { // fecha ?>
		<td<?php echo $saldo_iglesia->fecha->CellAttributes() ?>>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" value="<?php echo $saldo_iglesia->fecha->EditValue ?>"<?php echo $saldo_iglesia->fecha->EditAttributes() ?>>
&nbsp;<img src="images/calendar.png" id="cal_x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" name="cal_x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha", // ID of the input field
	ifFormat : "%d-%m-%Y", // the date format
	button : "cal_x<?php echo $saldo_iglesia_list->lRowIndex ?>_fecha" // ID of the button
});
</script>
<?php } ?>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_iglesia->fecha->ViewAttributes() ?>><?php echo $saldo_iglesia->fecha->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->nro_fact_recibo->Visible) { // nro_fact_recibo ?>
		<td<?php echo $saldo_iglesia->nro_fact_recibo->CellAttributes() ?>>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_nro_fact_recibo" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_nro_fact_recibo" size="10" value="<?php echo $saldo_iglesia->nro_fact_recibo->EditValue ?>"<?php echo $saldo_iglesia->nro_fact_recibo->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_iglesia->nro_fact_recibo->ViewAttributes() ?>><?php echo $saldo_iglesia->nro_fact_recibo->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->detalle->Visible) { // detalle ?>
		<td<?php echo $saldo_iglesia->detalle->CellAttributes() ?>>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_detalle" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_detalle" size="30" maxlength="255" value="<?php echo $saldo_iglesia->detalle->EditValue ?>"<?php echo $saldo_iglesia->detalle->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_iglesia->detalle->ViewAttributes() ?>><?php echo $saldo_iglesia->detalle->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->ingreso->Visible) { // ingreso ?>
		<td<?php echo $saldo_iglesia->ingreso->CellAttributes() ?>>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_ingreso" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_ingreso" size="10" value="<?php echo $saldo_iglesia->ingreso->EditValue ?>"<?php echo $saldo_iglesia->ingreso->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_iglesia->ingreso->ViewAttributes() ?>><?php echo $saldo_iglesia->ingreso->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_iglesia->egreso->Visible) { // egreso ?>
		<td<?php echo $saldo_iglesia->egreso->CellAttributes() ?>>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_iglesia_list->lRowIndex ?>_egreso" id="x<?php echo $saldo_iglesia_list->lRowIndex ?>_egreso" size="10" value="<?php echo $saldo_iglesia->egreso->EditValue ?>"<?php echo $saldo_iglesia->egreso->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_iglesia->egreso->ViewAttributes() ?>><?php echo $saldo_iglesia->egreso->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_ADD || $saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { ?>
<?php if ($saldo_iglesia->CurrentAction == "edit") { ?>
<td colspan="<?php echo $saldo_iglesia_list->lOptionCnt ?>"><span class="phpmaker">
<a href="" onclick="if (saldo_iglesia_list.ValidateForm(document.fsaldo_iglesialist)) document.fsaldo_iglesialist.submit();return false;">Actualizar</a>&nbsp;<a href="<?php echo $saldo_iglesia_list->PageUrl() ?>a=cancel">Cancelar</a>
<input type="hidden" name="a_list" id="a_list" value="update">
</span></td>
<?php } ?>
<?php } else { ?>
<?php if ($saldo_iglesia->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $saldo_iglesia->InlineEditUrl() ?>">Editar en linea</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($saldo_iglesia_list->lOptionCnt == 0 && $saldo_iglesia->CurrentAction == "add") { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $saldo_iglesia_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $saldo_iglesia->DeleteUrl() ?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($saldo_iglesia_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
<?php } ?>
	</tr>
<?php if ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	if ($saldo_iglesia->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($saldo_iglesia->CurrentAction == "add" || $saldo_iglesia->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $saldo_iglesia_list->lRowIndex ?>">
<?php } ?>
<?php if ($saldo_iglesia->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $saldo_iglesia_list->lRowIndex ?>">
<?php } ?>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
</div>
<?php if ($saldo_iglesia->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($saldo_iglesia->CurrentAction <> "gridadd" && $saldo_iglesia->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($saldo_iglesia_list->Pager)) $saldo_iglesia_list->Pager = new cPrevNextPager($saldo_iglesia_list->lStartRec, $saldo_iglesia_list->lDisplayRecs, $saldo_iglesia_list->lTotalRecs) ?>
<?php if ($saldo_iglesia_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Página&nbsp;</span></td>
<!--first page button-->
	<?php if ($saldo_iglesia_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_iglesia_list->PageUrl() ?>start=<?php echo $saldo_iglesia_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($saldo_iglesia_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_iglesia_list->PageUrl() ?>start=<?php echo $saldo_iglesia_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $saldo_iglesia_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($saldo_iglesia_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_iglesia_list->PageUrl() ?>start=<?php echo $saldo_iglesia_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($saldo_iglesia_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_iglesia_list->PageUrl() ?>start=<?php echo $saldo_iglesia_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $saldo_iglesia_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $saldo_iglesia_list->Pager->FromIndex ?> a <?php echo $saldo_iglesia_list->Pager->ToIndex ?> de <?php echo $saldo_iglesia_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($saldo_iglesia_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($saldo_iglesia_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por página&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="saldo_iglesia">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($saldo_iglesia_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($saldo_iglesia_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($saldo_iglesia->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($saldo_iglesia_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $saldo_iglesia_list->PageUrl() ?>a=add">Adicionar en linea</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($saldo_iglesia->Export == "" && $saldo_iglesia->CurrentAction == "") { ?>
<script type="text/javascript">
<!--

//ew_ToggleSearchPanel(saldo_iglesia_list); // uncomment to init search panel as collapsed
//-->

</script>
<?php } ?>
<?php if ($saldo_iglesia->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class csaldo_iglesia_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'saldo_iglesia';

	// Page Object Name
	var $PageObjName = 'saldo_iglesia_list';

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
	function csaldo_iglesia_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["saldo_iglesia"] = new csaldo_iglesia();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'saldo_iglesia', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
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
	$saldo_iglesia->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $saldo_iglesia->Export; // Get export parameter, used in header
	$gsExportFile = $saldo_iglesia->TableVar; // Get export file, used in header
	if ($saldo_iglesia->Export == "excel") {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
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
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $sSrchWhere;
	var $lRecCnt;
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex;
	var $lOptionCnt;
	var $lRecPerRow;
	var $lColCnt;
	var $sDeleteConfirmMsg; // Delete confirm message
	var $sDbMasterFilter;
	var $sDbDetailFilter;
	var $bMasterRecordExists;	
	var $ListOptions;
	var $sMultiSelectKey;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $Security, $saldo_iglesia;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
		$this->sDeleteConfirmMsg = "¿Quiere borrar este registro?"; // Delete confirm message

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter

		// Create form object
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page dynamically
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$saldo_iglesia->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($saldo_iglesia->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to inline edit mode
				if ($saldo_iglesia->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($saldo_iglesia->CurrentAction == "add" || $saldo_iglesia->CurrentAction == "copy")
					$this->InlineAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$saldo_iglesia->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if ($saldo_iglesia->CurrentAction == "update" && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($saldo_iglesia->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();
				}
			}

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($saldo_iglesia->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $saldo_iglesia->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$saldo_iglesia->setSessionWhere($sFilter);
		$saldo_iglesia->CurrentFilter = "";

		// Export data only
		if (in_array($saldo_iglesia->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $saldo_iglesia;
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->lDisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->lDisplayRecs = -1;
				} else {
					$this->lDisplayRecs = 20; // Non-numeric, load default
				}
			}
			$saldo_iglesia->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$saldo_iglesia->setStartRecordNumber($this->lStartRec);
		}
	}

	//  Exit out of inline mode
	function ClearInlineMode() {
		global $saldo_iglesia;
		$saldo_iglesia->setKey("idSaldoIglesia", ""); // Clear inline edit key
		$saldo_iglesia->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Inline Edit Mode
	function InlineEditMode() {
		global $Security, $saldo_iglesia;
		$bInlineEdit = TRUE;
		if (@$_GET["idSaldoIglesia"] <> "") {
			$saldo_iglesia->idSaldoIglesia->setQueryStringValue($_GET["idSaldoIglesia"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$saldo_iglesia->setKey("idSaldoIglesia", $saldo_iglesia->idSaldoIglesia->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Peform update to inline edit record
	function InlineUpdate() {
		global $objForm, $gsFormError, $saldo_iglesia;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate Form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;	
			if ($this->CheckInlineEditKey()) { // Check key
				$saldo_iglesia->SendEmail = TRUE; // Send email on update success
				$bInlineUpdate = $this->EditRow(); // Update record
			} else {
				$bInlineUpdate = FALSE;
			}
		}
		if ($bInlineUpdate) { // Update success
			$this->setMessage("Actualizacion exitosa"); // Set success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getMessage() == "")
				$this->setMessage("Actualizacion a fallado"); // Set update failed message
			$saldo_iglesia->EventCancelled = TRUE; // Cancel event
			$saldo_iglesia->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check inline edit key
	function CheckInlineEditKey() {
		global $saldo_iglesia;

		//CheckInlineEditKey = True
		if (strval($saldo_iglesia->getKey("idSaldoIglesia")) <> strval($saldo_iglesia->idSaldoIglesia->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add Mode
	function InlineAddMode() {
		global $Security, $saldo_iglesia;
		$saldo_iglesia->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Peform update to inline add/copy record
	function InlineInsert() {
		global $objForm, $gsFormError, $saldo_iglesia;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate Form
		if (!$this->ValidateForm()) {
			$this->setMessage($gsFormError); // Set validation error message
			$saldo_iglesia->EventCancelled = TRUE; // Set event cancelled
			$saldo_iglesia->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$saldo_iglesia->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow()) { // Add record
			$this->setMessage("Registro agregado satisfactoriamente"); // Set add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$saldo_iglesia->EventCancelled = TRUE; // Set event cancelled
			$saldo_iglesia->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $saldo_iglesia;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$saldo_iglesia->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$saldo_iglesia->CurrentOrderType = @$_GET["ordertype"];
			$saldo_iglesia->UpdateSort($saldo_iglesia->idSaldoIglesia); // Field 
			$saldo_iglesia->UpdateSort($saldo_iglesia->fecha); // Field 
			$saldo_iglesia->UpdateSort($saldo_iglesia->nro_fact_recibo); // Field 
			$saldo_iglesia->UpdateSort($saldo_iglesia->detalle); // Field 
			$saldo_iglesia->UpdateSort($saldo_iglesia->ingreso); // Field 
			$saldo_iglesia->UpdateSort($saldo_iglesia->egreso); // Field 
			$saldo_iglesia->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $saldo_iglesia;
		$sOrderBy = $saldo_iglesia->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($saldo_iglesia->SqlOrderBy() <> "") {
				$sOrderBy = $saldo_iglesia->SqlOrderBy();
				$saldo_iglesia->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $saldo_iglesia;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$saldo_iglesia->setSessionOrderBy($sOrderBy);
				$saldo_iglesia->idSaldoIglesia->setSort("");
				$saldo_iglesia->fecha->setSort("");
				$saldo_iglesia->nro_fact_recibo->setSort("");
				$saldo_iglesia->detalle->setSort("");
				$saldo_iglesia->ingreso->setSort("");
				$saldo_iglesia->egreso->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$saldo_iglesia->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $saldo_iglesia;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$saldo_iglesia->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$saldo_iglesia->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $saldo_iglesia->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$saldo_iglesia->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$saldo_iglesia->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$saldo_iglesia->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		global $saldo_iglesia;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $saldo_iglesia;
		$saldo_iglesia->idSaldoIglesia->setFormValue($objForm->GetValue("x_idSaldoIglesia"));
		$saldo_iglesia->fecha->setFormValue($objForm->GetValue("x_fecha"));
		$saldo_iglesia->fecha->CurrentValue = ew_UnFormatDateTime($saldo_iglesia->fecha->CurrentValue, 7);
		$saldo_iglesia->nro_fact_recibo->setFormValue($objForm->GetValue("x_nro_fact_recibo"));
		$saldo_iglesia->detalle->setFormValue($objForm->GetValue("x_detalle"));
		$saldo_iglesia->ingreso->setFormValue($objForm->GetValue("x_ingreso"));
		$saldo_iglesia->egreso->setFormValue($objForm->GetValue("x_egreso"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $saldo_iglesia;
		$saldo_iglesia->idSaldoIglesia->CurrentValue = $saldo_iglesia->idSaldoIglesia->FormValue;
		$saldo_iglesia->fecha->CurrentValue = $saldo_iglesia->fecha->FormValue;
		$saldo_iglesia->fecha->CurrentValue = ew_UnFormatDateTime($saldo_iglesia->fecha->CurrentValue, 7);
		$saldo_iglesia->nro_fact_recibo->CurrentValue = $saldo_iglesia->nro_fact_recibo->FormValue;
		$saldo_iglesia->detalle->CurrentValue = $saldo_iglesia->detalle->FormValue;
		$saldo_iglesia->ingreso->CurrentValue = $saldo_iglesia->ingreso->FormValue;
		$saldo_iglesia->egreso->CurrentValue = $saldo_iglesia->egreso->FormValue;
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
		} elseif ($saldo_iglesia->RowType == EW_ROWTYPE_ADD) { // Add row

			// idSaldoIglesia
			// fecha

			$saldo_iglesia->fecha->EditCustomAttributes = "";
			$saldo_iglesia->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($saldo_iglesia->fecha->CurrentValue, 7));

			// nro_fact_recibo
			$saldo_iglesia->nro_fact_recibo->EditCustomAttributes = "";
			$saldo_iglesia->nro_fact_recibo->EditValue = ew_HtmlEncode($saldo_iglesia->nro_fact_recibo->CurrentValue);

			// detalle
			$saldo_iglesia->detalle->EditCustomAttributes = "";
			$saldo_iglesia->detalle->EditValue = ew_HtmlEncode($saldo_iglesia->detalle->CurrentValue);

			// ingreso
			$saldo_iglesia->ingreso->EditCustomAttributes = "";
			$saldo_iglesia->ingreso->EditValue = ew_HtmlEncode($saldo_iglesia->ingreso->CurrentValue);

			// egreso
			$saldo_iglesia->egreso->EditCustomAttributes = "";
			$saldo_iglesia->egreso->EditValue = ew_HtmlEncode($saldo_iglesia->egreso->CurrentValue);
		} elseif ($saldo_iglesia->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idSaldoIglesia
			$saldo_iglesia->idSaldoIglesia->EditCustomAttributes = "";
			$saldo_iglesia->idSaldoIglesia->EditValue = $saldo_iglesia->idSaldoIglesia->CurrentValue;
			$saldo_iglesia->idSaldoIglesia->CssStyle = "";
			$saldo_iglesia->idSaldoIglesia->CssClass = "";
			$saldo_iglesia->idSaldoIglesia->ViewCustomAttributes = "";

			// fecha
			$saldo_iglesia->fecha->EditCustomAttributes = "";
			$saldo_iglesia->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($saldo_iglesia->fecha->CurrentValue, 7));

			// nro_fact_recibo
			$saldo_iglesia->nro_fact_recibo->EditCustomAttributes = "";
			$saldo_iglesia->nro_fact_recibo->EditValue = ew_HtmlEncode($saldo_iglesia->nro_fact_recibo->CurrentValue);

			// detalle
			$saldo_iglesia->detalle->EditCustomAttributes = "";
			$saldo_iglesia->detalle->EditValue = ew_HtmlEncode($saldo_iglesia->detalle->CurrentValue);

			// ingreso
			$saldo_iglesia->ingreso->EditCustomAttributes = "";
			$saldo_iglesia->ingreso->EditValue = ew_HtmlEncode($saldo_iglesia->ingreso->CurrentValue);

			// egreso
			$saldo_iglesia->egreso->EditCustomAttributes = "";
			$saldo_iglesia->egreso->EditValue = ew_HtmlEncode($saldo_iglesia->egreso->CurrentValue);

			// Edit refer script
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

	// Validate form
	function ValidateForm() {
		global $gsFormError, $saldo_iglesia;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($saldo_iglesia->fecha->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha";
		}
		if (!ew_CheckEuroDate($saldo_iglesia->fecha->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd-mm-yyyy - Fecha";
		}
		if (!ew_CheckInteger($saldo_iglesia->nro_fact_recibo->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Recibo";
		}
		if ($saldo_iglesia->detalle->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Detalle";
		}
		if (!ew_CheckNumber($saldo_iglesia->ingreso->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Número de Punto Flotante Incorrecto - Ingreso";
		}
		if (!ew_CheckNumber($saldo_iglesia->egreso->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Número de Punto Flotante Incorrecto - Egreso";
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $saldo_iglesia;
		$sFilter = $saldo_iglesia->KeyFilter();
		$saldo_iglesia->CurrentFilter = $sFilter;
		$sSql = $saldo_iglesia->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// Field idSaldoIglesia
			// Field fecha

			$saldo_iglesia->fecha->SetDbValueDef(ew_UnFormatDateTime($saldo_iglesia->fecha->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fecha'] =& $saldo_iglesia->fecha->DbValue;

			// Field nro_fact_recibo
			$saldo_iglesia->nro_fact_recibo->SetDbValueDef($saldo_iglesia->nro_fact_recibo->CurrentValue, NULL);
			$rsnew['nro_fact_recibo'] =& $saldo_iglesia->nro_fact_recibo->DbValue;

			// Field detalle
			$saldo_iglesia->detalle->SetDbValueDef($saldo_iglesia->detalle->CurrentValue, "");
			$rsnew['detalle'] =& $saldo_iglesia->detalle->DbValue;

			// Field ingreso
			$saldo_iglesia->ingreso->SetDbValueDef($saldo_iglesia->ingreso->CurrentValue, NULL);
			$rsnew['ingreso'] =& $saldo_iglesia->ingreso->DbValue;

			// Field egreso
			$saldo_iglesia->egreso->SetDbValueDef($saldo_iglesia->egreso->CurrentValue, NULL);
			$rsnew['egreso'] =& $saldo_iglesia->egreso->DbValue;

			// Call Row Updating event
			$bUpdateRow = $saldo_iglesia->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($saldo_iglesia->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($saldo_iglesia->CancelMessage <> "") {
					$this->setMessage($saldo_iglesia->CancelMessage);
					$saldo_iglesia->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$saldo_iglesia->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow() {
		global $conn, $Security, $saldo_iglesia;
		$rsnew = array();

		// Field idSaldoIglesia
		// Field fecha

		$saldo_iglesia->fecha->SetDbValueDef(ew_UnFormatDateTime($saldo_iglesia->fecha->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fecha'] =& $saldo_iglesia->fecha->DbValue;

		// Field nro_fact_recibo
		$saldo_iglesia->nro_fact_recibo->SetDbValueDef($saldo_iglesia->nro_fact_recibo->CurrentValue, NULL);
		$rsnew['nro_fact_recibo'] =& $saldo_iglesia->nro_fact_recibo->DbValue;

		// Field detalle
		$saldo_iglesia->detalle->SetDbValueDef($saldo_iglesia->detalle->CurrentValue, "");
		$rsnew['detalle'] =& $saldo_iglesia->detalle->DbValue;

		// Field ingreso
		$saldo_iglesia->ingreso->SetDbValueDef($saldo_iglesia->ingreso->CurrentValue, NULL);
		$rsnew['ingreso'] =& $saldo_iglesia->ingreso->DbValue;

		// Field egreso
		$saldo_iglesia->egreso->SetDbValueDef($saldo_iglesia->egreso->CurrentValue, NULL);
		$rsnew['egreso'] =& $saldo_iglesia->egreso->DbValue;

		// Call Row Inserting event
		$bInsertRow = $saldo_iglesia->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($saldo_iglesia->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($saldo_iglesia->CancelMessage <> "") {
				$this->setMessage($saldo_iglesia->CancelMessage);
				$saldo_iglesia->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$saldo_iglesia->idSaldoIglesia->setDbValue($conn->Insert_ID());
			$rsnew['idSaldoIglesia'] =& $saldo_iglesia->idSaldoIglesia->DbValue;

			// Call Row Inserted event
			$saldo_iglesia->Row_Inserted($rsnew);
		}
		return $AddRow;
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $saldo_iglesia;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($saldo_iglesia->ExportAll) {
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export 1 page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($saldo_iglesia->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($saldo_iglesia->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $saldo_iglesia->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idSaldoIglesia', $saldo_iglesia->Export);
				ew_ExportAddValue($sExportStr, 'fecha', $saldo_iglesia->Export);
				ew_ExportAddValue($sExportStr, 'nro_fact_recibo', $saldo_iglesia->Export);
				ew_ExportAddValue($sExportStr, 'detalle', $saldo_iglesia->Export);
				ew_ExportAddValue($sExportStr, 'ingreso', $saldo_iglesia->Export);
				ew_ExportAddValue($sExportStr, 'egreso', $saldo_iglesia->Export);
				echo ew_ExportLine($sExportStr, $saldo_iglesia->Export);
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row for display
				$saldo_iglesia->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($saldo_iglesia->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idSaldoIglesia', $saldo_iglesia->idSaldoIglesia->CurrentValue);
					$XmlDoc->AddField('fecha', $saldo_iglesia->fecha->CurrentValue);
					$XmlDoc->AddField('nro_fact_recibo', $saldo_iglesia->nro_fact_recibo->CurrentValue);
					$XmlDoc->AddField('detalle', $saldo_iglesia->detalle->CurrentValue);
					$XmlDoc->AddField('ingreso', $saldo_iglesia->ingreso->CurrentValue);
					$XmlDoc->AddField('egreso', $saldo_iglesia->egreso->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $saldo_iglesia->Export <> "csv") { // Vertical format
						echo ew_ExportField('idSaldoIglesia', $saldo_iglesia->idSaldoIglesia->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						echo ew_ExportField('fecha', $saldo_iglesia->fecha->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						echo ew_ExportField('nro_fact_recibo', $saldo_iglesia->nro_fact_recibo->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						echo ew_ExportField('detalle', $saldo_iglesia->detalle->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						echo ew_ExportField('ingreso', $saldo_iglesia->ingreso->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						echo ew_ExportField('egreso', $saldo_iglesia->egreso->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $saldo_iglesia->idSaldoIglesia->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						ew_ExportAddValue($sExportStr, $saldo_iglesia->fecha->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						ew_ExportAddValue($sExportStr, $saldo_iglesia->nro_fact_recibo->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						ew_ExportAddValue($sExportStr, $saldo_iglesia->detalle->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						ew_ExportAddValue($sExportStr, $saldo_iglesia->ingreso->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						ew_ExportAddValue($sExportStr, $saldo_iglesia->egreso->ExportValue($saldo_iglesia->Export, $saldo_iglesia->ExportOriginalValue), $saldo_iglesia->Export);
						echo ew_ExportLine($sExportStr, $saldo_iglesia->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($saldo_iglesia->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($saldo_iglesia->Export);
		}
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
