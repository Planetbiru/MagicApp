<?php

namespace MagicApp\XLSX;

use MagicObject\Database\PicoPageData;
use MagicObject\MagicObject;
use MagicObject\Util\PicoStringUtil;

class XLSXDocumentWriter
{
    private $headerFormat = array();
    
    /**
     * Check if never fetch data
     *
     * @param PicoPageData $pageData
     * @return boolean
     */
    public function noFetchData($pageData)
    {
        return $pageData->getFindOption() & MagicObject::FIND_OPTION_NO_FETCH_DATA;
    }
    
    /**
     * Write data
     *
     * @param PicoPageData $pageData
     * @param string $fileName
     * @param string $sheetName
     * @param string[] $headerFormat
     * @param callable $writerFunction
     * @return self
     */
    public function write($pageData, $fileName, $sheetName, $headerFormat, $writerFunction)
    {
        
        $writer = new XLSXWriter();
        if(isset($headerFormat) && is_array($headerFormat) && is_callable($writerFunction))
        {
            $writer = $this->writeDataWithFormat($writer, $pageData, $sheetName, $headerFormat, $writerFunction);
        }
        else
        {
            $writer = $this->writeDataWithoutFormat($writer, $pageData, $sheetName);
        }
        
        header('Content-disposition: attachment; filename="'.$fileName.'"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        $writer->writeToStdOut();

        return $this;
    }

    /**
     * Write data with format
     * @param XLSXWriter $writer
     * @param PicoPageData $pageData
     * @param string $sheetName
     * @return XLSXWriter
     */
    private function writeDataWithoutFormat($writer, $pageData, $sheetName)
    {
        $idx = 0;
        while($row = $pageData->fetch())
        {
            $keys = array_keys($row->valueArray());
            if($idx == 0)
            {
                foreach($keys as $key)
                {
                    $this->headerFormat[PicoStringUtil::camelToTitle($key)] = "string";
                }
                $writer->writeSheetHeader($sheetName, $this->headerFormat);
            }
            $data = array();
            foreach($keys as $key)
            {
                $data[] = $row->get($key);
            }            
            $writer->writeSheetRow($sheetName, $data);
            $idx++;
        }
        return $writer;
    }

    /**
     * Write data with format
     * @param XLSXWriter $writer
     * @param PicoPageData $pageData
     * @param string $sheetName
     * @param string[] $headerFormat
     * @param callable $writerFunction
     * @return XLSXWriter
     */
    private function writeDataWithFormat($writer, $pageData, $sheetName, $headerFormat, $writerFunction)
    {
        foreach($headerFormat as $key=>$value)
        {
            if($value instanceof XLSXDataType)
            {
                $headerFormat[$key] = $value->toString();
            }
        }
        $this->headerFormat = $headerFormat;
        
        $writer->writeSheetHeader($sheetName, $this->headerFormat);
        $idx = 0;
        if($this->noFetchData($pageData))
        {
            while($row = $pageData->fetch())
            {
                $data = call_user_func($writerFunction, $idx, $row);             
                $writer->writeSheetRow($sheetName, $data);
                $idx++;
            }
        }
        return $writer;
    }
}