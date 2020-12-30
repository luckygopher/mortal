<?php

namespace core\lib;

class Excel
{
    static $instance=null;
    private $excel=null;
    private $workbook=null;
    private $workbookadd=null;
    private $worksheet=null;
    private $worksheetadd=null;
    private $sheetnum=1;
    private $cells=array();
    private $fields=array();
    private $maxrows;
    private $maxcols;
    private $filename;

    //构造函数
    private function Excel()
    {
        $this->excel = new COM("Excel.Application") or die("Did Not Connect");
    }

    //类入口
    public static function getInstance()
    {
        if(null == self::$instance)
        {
            self::$instance = new Excel();
        }
        return self::$instance;
    }

    //设置文件地址
    public function setFile($filename)
    {
        return $this->filename=$filename;
    }

    //打开文件
    public function Open()
    {
        $this->workbook=$this->excel->WorkBooks->Open($this->filename);
    }

    //设置Sheet
    public function setSheet($num=1)
    {
        if($num>0)
        {
            $this->sheetnum=$num;
            $this->worksheet=$this->excel->WorkSheets[$this->sheetnum];
            $this->maxcols=$this->maxCols();
            $this->maxrows=$this->maxRows();
            $this->getCells();
        }
    }

    //取得表所有值并写进数组
    private function getCells()
    {
        for($i=1;$i<$this->maxcols;$i++)
        {
            for($j=2;$j<$this->maxrows;$j++)
            {
                $this->cells[$this->worksheet->Cells(1,$i)->value][]=(string)$this->worksheet->Cells($j,$i)->value;
            }
        }
        return $this->cells;
    }

    //返回表格内容数组
    public function getAllData()
    {
        return $this->cells;
    }

    //返回指定单元格内容
    public function Cell($row,$col)
    {
        return $this->worksheet->Cells($row,$col)->Value;
    }

    //取得表格字段名数组
    public function getFields()
    {
        for($i=1;$i<$this->maxcols;$i++)
        {
            $this->fields[]=$this->worksheet->Cells(1,$i)->value;
        }
        return $this->fields;
    }

    //修改指定单元格内容
    public function editCell($row,$col,$value)
    {
        if($this->workbook==null || $this->worksheet==null)
        {
            echo "Error:Did Not Connect!";
        }else{
            $this->worksheet->Cells($row,$col)->Value=$value;
            $this->workbook->Save();
        }
    }

    //修改一行数据
    public function editOneRow($row,$arr)
    {
        if($this->workbook==null || $this->worksheet==null || $row>=2)
        {
            echo "Error:Did Not Connect!";
        }else{
            if(count($arr)==$this->maxcols-1)
            {
                $i=1;
                foreach($arr as $val)
                {
                    $this->worksheet->Cells($row,$i)->Value=$val;
                    $i++;
                }
                $this->workbook->Save();
            }
        }
    }

    //关闭对象
    public function Close()
    {
        $this->excel->WorkBooks->Close();
        $this->excel=null;
        $this->workbook=null;
        $this->worksheet=null;
        self::$instance=null;
    }

};
