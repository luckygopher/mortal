<?php
/**
 * @category 文件上传下载
 * @author Augus <mr_augus@qq.com>
 */
namespace core\lib;

class FileUpload
{
    private $filePath;     //指定上传文件保存的路径
    private $allowType = ['png'];  //充许上传文件的类型
    private $maxSize = 1000000;  //允上传文件的最大长度 1M
    private $isRandName = true;  //是否随机重命名， true false不随机，使用原文件名

    private $originName;   //源文件名称
    private $tmpFileName;   //临时文件名
    private $fileType;  //文件类型
    private $fileSize;  //文件大小
    private $newFileName; //新文件名
    private $errorNum = 0;  //错误码
    private $errorMess = ""; //用来提供错误报告
    /**
     * 接收文件上传的配置信息并赋值给成员属性
     *
     * @param array $option
     */
    public function __construct($option = array())
    {
        foreach ($option as $key => $val) {
            $classOption = get_class_vars(get_class($this));
            if (!in_array($key,$classOption)) {
                continue;
            }
            $this->setOption($key, $val);
        }
    }
    /**
     * 给成员属性赋值
     *
     * @param [type] $key
     * @param [type] $val
     * @return void
     */
    private function setOption($key, $val)
    {
        $this->$key = $val;
    }
    /**
     * 根据错误码设置相应的错误信息
     *
     * @return void
     */
    private function getError()
    {
        $str = "上传文件<font color='red'>{$this->originName}</font>时出错：";
        switch ($this->errorNum) {
            case 4: $str .= "没有文件被上传"; break;
            case 3: $str .= "文件只被部分上传"; break;
            case 2: $str .= "上传文件超过了HTML表单中MAX_FILE_SIZE选项指定的值"; break;
            case 1: $str .= "上传文件超过了php.ini 中upload_max_filesize选项的值"; break;
            case -1: $str .= "不被充许的类型"; break;
            case -2: $str .= "文件过大，上传文件不能超过{$this->maxSize}个字节"; break;
            case -3: $str .= "上传失败"; break;
            case -4: $str .= "建立存放上传文件目录失败，请重新指定上传目录"; break;
            case -5: $str .= "必须指定上传文件的路径"; break;
            case -6: $str .= "存放上传文件目录不可写"; break;
            default: $str .=  "末知错误";
        }
        return $str;
    }
    /**
     * 检查上传文件的保存路径
     * 配置是否为空
     * 目录是否存在，不存在则建立
     * 目录是否有写权限，没有则修改权限
     *
     * @return void
     */
    private function checkFilePath()
    {
        if (empty($this->filePath)) {
            $this->setOption('errorNum', -5);
            return false;
        }
        if (!file_exists($this->filePath)) {
            if (!mkdir($this->filePath, 0755, true)) {
                $this->setOption('errorNum', -4);
                return false;
            }
        }
        if (!is_writable($this->filePath)) {
            if (!chmod($this->filePath,0755)) {
                $this->setOption('errorNum', -6);
                return false;
            }
        }

        return true;
    }
    /**
     * 检查上传文件大小是否超过允许大小
     *
     * @return void
     */
    private function checkFileSize()
    {
        if ($this->fileSize > $this->maxSize) {
            $this->setOption('errorNum', '-2');
            return false;
        }else {
            return true;
        }
    }
    /**
     * 检查文件是否为允许上传的文件类型
     *
     * @return void
     */
    private function checkFileType()
    {
        if (in_array(strtolower($this->fileType), $this->allowType)) {
            return true;
        }else {
            $this->setOption('errorNum', -1);
            return false;
        }
    }
    /**
     * 设置上传文件的新文件名
     *
     * @return void
     */
    private function setNewFileName()
    {
        if ($this->isRandName) {
            $this->setOption('newFileName', $this->randName());
        }else {
            $this->setOption('newFileName', $this->originName);
        }
    }
    /**
     * 生成上传文件的随机文件名
     *
     * @return void
     */
    private function randName()
    {
        $fileName = date('YmdHis').rand(100,999);
        return $fileName.'.'.$this->fileType;
    }
}