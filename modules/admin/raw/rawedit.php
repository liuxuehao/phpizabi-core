<?php
///////////////////////////////////////////////////////////////////////////////////////
// PHPizabi 2.01 Alpha [Madison]                             http://www.phpizabi.org //
///////////////////////////////////////////////////////////////////////////////////////
//                                                                                   //
// Please read the LICENSE.md & README.md file before using/modifying this software  //
//                                                                                   //
// Developing Author:       Andrew James, RubberDucky - andy@phpizabi.org            //
// Last modification date:  December 13th, 201                                       //
// Version:                 PHPizabi 2.01 Alpha                                      //
//                                                                                   //
// (C) 2005, 2006 Real!ty Medias                                                     //
// (C) 2007-2012 AndyJames.Org                                                       //
//                                                                                   //
// PHPizabi Is the work of a very talented development team. This script is our      //
// Pride and Joy. We hope that you enjoy using this software as much as we enjoy     //
// Developing it for you. If you need anything: http://www.phpizabi.org              //
//                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////

	/* Check Structure Availability */
	if (!defined("CORE_STRAP")) die("Out of structure call");
	/* Administrative restriction */
	(!me('is_administrator')&&!me('is_superadministrator')?die("Access restricted"):NULL);

	$tpl = new template;
	$tpl -> Load("rawedit");
	$tpl -> GetObjects();
	
	// HANDLE POSTED DATA ////////////////////////////////////////////////////
	if (isset($_POST["Submit"])) {
		
		$restricted = array("id", "Submit", "is_superadministrator");
		
		foreach($_POST as $var => $val) {
			if (!in_array($var, $restricted)) $postSet[] = "`{$var}`='{$val}'";
		}
		
		myQ("
			UPDATE `[x]{$_GET["table"]}`
			SET ".implode(", ", $postSet)."
			WHERE `id`='{$_GET["id"]}'
		");
	}
	
	//
		
	
	$select = myQ("SELECT * FROM `[x]{$_GET["table"]}` WHERE `id`='{$_GET["id"]}'");
	$row = mysql_fetch_assoc($select);
	
	$i=0;
	foreach ($row as $var => $val) {
		
		$meta = mysql_fetch_field($select, $i);

		$replaceArray[] = array(
			"decompile" => ($meta->blob ? $OBJ["decompile"] : NULL),
			"enc" => base64_encode($val),
			"var" => $var,
			"val" => $val,
		);
		
		$i++;
	}
	
	$tpl -> Loop("rawRow", $replaceArray);
	
	// TEMPLATE REPROCESS & FLUSH ////////////////////////////////////////////////////
	$tpl -> CleanZones();

	/* Get the frame templates, flush the TPL result into it */
	$frame = new template;
	$frame -> Load("!theme/{$GLOBALS["THEME"]}/templates/admin/frame.tpl");
	$frame -> AssignArray(array(
		"jump" => $tpl->Flush(1)
	));
	
	/* Assign Location Value */
	$locationArray = explode(".", $_GET["L"]);
	for ($i=0; $i<count($locationArray); $i++) {
		$locationAppendResult[] = $locationArray[$i];
		if ($i > 0) $location[] = "<a href=\"?L=".implode(".", $locationAppendResult)."\">{$locationArray[$i]}</a>";
	}
	$frame -> AssignArray(array("location" => implode(" &raquo; ", $location)));
	
	/* Set the forced chromeless mode, flush the template */
	$GLOBALS["CHROMELESS_MODE"] = 1;
	$frame -> Flush();
	
?>