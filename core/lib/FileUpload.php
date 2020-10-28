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

    /**
     * 把上传文件从临时目录移动到配置的保存目录
     *
     * @return void
     */
    private function copyFile()
    {
        if (!$this->errorNum) {
            $filePath = rtrim($this->filePath, '/').'/';
            $filePath .= $this->newFileName;

            if (is_uploaded_file($this->tmpFileName)) {
                if (move_uploaded_file($this->tmpFileName, $filePath)) {
                    return true;
                }else {
                    $this->setOption('errorNum', -3);
                    return false;
                }
            }else {
                return false;
            }

        }else {
            return false;
        }
    }

    /**
     * 设置$_FILES相关的参数
     *
     * @param string $name
     * @param string $tmp_name
     * @param integer $size
     * @param integer $error
     * @return void
     */
    private function setFiles($name="", $tmp_name='', $size=0, $error=0)
    {
        $this->setOption('errorNum', $error);
        if ($error) {
            return false;
        }
        $this->setOption('originName', $name);
        $this->setOption('tmpFileName', $tmp_name);
        //分割文件名，取最后一个后缀
        $arrStr = explode('.', $name);
        $this->setOption('fileType', strtolower($arrStr[count($arrStr)-1]));
        $this->setOption('fileSize', $size);
        return true;
    }

    /**
     * 上传一个或多个文件
     * 参数为文件上传input的名字
     * @param [type] $fileField
     * @return void
     */
    public function uploadFile($fileField)
    {
        $return = true;
        //检查存放上传文件的路径
        if (!$this->checkFilePath()) {
            $this->errorMess = $this->getError();
            return false;
        }
        $name = $_FILES[$fileField]['name'];
        $tmp_name = $_FILES[$fileField]['tmp_name'];
        $size = $_FILES[$fileField]['size'];
        $error = $_FILES[$fileField]['error'];
        //如果上传的是多个文件
        if (is_Array($name)) {
            //错误代号必须也是Array，因为一个文件对应一个错误代号
            $uploadErrors = array();
            //遍历检查文件
            for ($i=0; $i < count($name); $i++) {
                if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])) {
                    if (!$this->checkFileSize() || !$this->checkFileType()) {
                        $uploadErrors[] = $this->getError();
                        $return = false;
                    }
                }else {
                    $uploadErrors[] = $this->getError();
                    $return = false;
                }
                if (!$return){
                    $this->setFiles();
                }
            }

            if ($return) {
                $fileNames = array();
                for ($i=0; $i < count($name); $i++) {
                    if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])) {
                        $this->setNewFileName();
                        if (!$this->copyFile()) {
                            $uploadErrors[] = $this->getError();
                            $return = false;
                        }else {
                            $fileNames[] = $this->newFileName;
                        }
                    }
                }
                //是一个数组
                $this->newFileName = $fileNames;
            }

            //赋值错误信息
            $this->errorMess = $uploadErrors;
            return $return;
            //如果是单个文件上传
        } else {
            if ($this->setFiles($name, $tmp_name, $size, $error)) {
                if ($this->checkFileSize() && $this->checkFileType()) {
                    $this->setNewFileName();
                    if ($this->copyFile()) {
                        return true;
                    }else {
                        $return = false;
                    }
                }else {
                    $return = false;
                }
            }else {
                $return = false;
            }

            if (!$return) {
                $this->errorMess = $this->getError();
            }

            return $return;
        }
    }

    /**
     * 用户获取上传成功之后的新文件名
     *
     * @return void
     */
    public function getNewFileName()
    {
        return $this->newFileName;
    }

    /**
     * 如果上传失败，调用此方法查看错误信息
     *
     * @return void
     */
    public function getErrorMsg()
    {
        return $this->errorMess;
    }
}
