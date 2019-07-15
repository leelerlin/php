<?php
	require_once  BASEPATH . 'libraries/PHPExcel/IOFactory.php';

	// Excel路径
	$fileName = 'C:/Users/Administrator/Desktop/test.xlsx';

	if (!file_exists($fileName)) {
		exit("文件".$fileName."不存在");
	}

	$objPHPExcel = PHPExcel_IOFactory::load($fileName);

	//获取sheet表格数目
	$sheetCount = $objPHPExcel->getSheetCount();

	//默认选中sheet0表
	$sheetSelected = 0;$objPHPExcel->setActiveSheetIndex($sheetSelected);

	//获取表格行数
	$rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();

	//获取表格列数
	$columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();

	$dataArr = array();
	/* 循环读取每个单元格的数据 */
	//行数循环
	for ($row = 1; $row <= $rowCount; $row++){

	 //列数循环 , 列数是以A列开始
		for ($column = 'A'; $column <= $columnCount; $column++) {
		 $dataArr[] = $objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue();
		}
	}
	var_dump($dataArr);