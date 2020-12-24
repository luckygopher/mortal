<?php
class ImageHandler
{
    public $PICTURE_URL;//要处理的图片
    public $DEST_URL="temp.jpg";//生成目标图片位置
    public $PICTURE_CREATE;//要创建的图片
    public $TURE_COLOR;//新建一个真彩图象
    public $PICTURE_WIDTH;//原图片宽度
    public $PICTURE_HEIGHT;//原图片高度

    public $MARK_TYPE=1;
    public $WORD;//经过UTF-8后的文字
    public $WORD_X;//文字横坐标
    public $WORD_Y;//文字纵坐标
    public $FONT_TYPE;//字体类型
    public $FONT_SIZE="12";//字体大小
    public $FONT_WORD;//文字
    public $ANGLE=0;//文字的角度，默认为0
    public $FONT_COLOR="#000000";//文字颜色
    public $FONT_PATH="font/simkai.ttf";//字体库，默认为宋体
    public $FORCE_URL;//水印图片
    public $FORCE_X=0;//水印横坐标
    public $FORCE_Y=0;//水印纵坐标
    public $FORCE_START_X=0;//切起水印的图片横坐标
    public $FORCE_START_Y=0;//切起水印的图片纵坐标
    public $PICTURE_TYPE;//图片类型
    public $PICTURE_MIME;//输出的头部

    public $ZOOM=1;//缩放类型
    public $ZOOM_MULTIPLE;//缩放比例
    public $ZOOM_WIDTH;//缩放宽度
    public $ZOOM_HEIGHT;//缩放高度

    public $CUT_TYPE=1;//裁切类型
    public $CUT_X=0;//裁切的横坐标
    public $CUT_Y=0;//裁切的纵坐标
    public $CUT_;//裁切的宽度
    public $CUT_HEIGHT=100;//裁切的高度

    public $SHARP="7.0";//锐化程度

    public $ALPHA='100';//透明度在0-127之间
    public $ALPHA_X="90";
    public $ALPHA_Y="50";

    public $CIRCUMROTATE="90.0";//注意，必须为浮点数

    public $ERROR=array(
        'unalviable'=>'没有找到相关图片!'
    );

    function __construct($PICTURE_URL)
    {
        $this->get_info($PICTURE_URL);
    }

    function get_info($PICTURE_URL)
    {
        /*
        处理原图片的信息,先检测图片是否存在,不存在则给出相应的信息
        */
        @$SIZE=getimagesize($PICTURE_URL);
        if(!$SIZE) {
            exit($this->ERROR['unalviable']);
        }
        //得到原图片的信息类型、宽度、高度
        $this->PICTURE_MIME=$SIZE['mime'];
        $this->PICTURE_;
        $this->PICTURE_HEIGHT=$SIZE[1];
        //创建图片
        switch($SIZE[2]) {
            case 1:
                $this->PICTURE_CREATE=imagecreatefromgif($PICTURE_URL);
                $this->PICTURE_TYPE="imagejpeg";
                $this->PICTURE_EXT="jpg";
                break;
            case 2:
                $this->PICTURE_CREATE=imagecreatefromjpeg($PICTURE_URL);
                $this->PICTURE_TYPE="imagegif";
                $this->PICTURE_EXT="gif";
                break;
            case 3:
                $this->PICTURE_CREATE=imagecreatefrompng($PICTURE_URL);
                $this->PICTURE_TYPE="imagepng";
                $this->PICTURE_EXT="png";
                break;
        }
        /*
        文字颜色转换16进制转换成10进制
        */
        preg_match_all("/([0-f]){2,2}/i",$this->FONT_COLOR,$MATCHES);
        if(count($MATCHES)==3) {
            $this->RED=hexdec($MATCHES[0][0]);
            $this->GREEN=hexdec($MATCHES[0][1]);
            $this->BLUE=hexdec($MATCHES[0][2]);
        }
    }

    /*
    将16进制的颜色转换成10进制的（R，G，B）
    */
    function hex2dec()
    {
        preg_match_all("/([0-f]){2,2}/i",$this->FONT_COLOR,$MATCHES);
        if(count($MATCHES)==3) {
            $this->RED=hexdec($MATCHES[0][0]);
            $this->GREEN=hexdec($MATCHES[0][1]);
            $this->BLUE=hexdec($MATCHES[0][2]);
        }
    }

    //缩放类型
    function zoom_type($ZOOM_TYPE)
    {
        $this->ZOOM=$ZOOM_TYPE;
    }

    //对图片进行缩放,如果不指定高度和宽度就进行缩放
    function zoom()
    {
        //缩放的大小
        if($this->ZOOM==0) {
            $this->ZOOM_;gt;PICTURE_WIDTH * $this->ZOOM_MULTIPLE;
            $this->ZOOM_HEIGHT=$this->PICTURE_HEIGHT * $this->ZOOM_MULTIPLE;
        }
        //新建一个真彩图象
        $this->TRUE_COLOR=imagecreatetruecolor($this->ZOOM_WIDTH,$this->ZOOM_HEIGHT);
        $WHITE=imagecolorallocate($this->TRUE_COLOR,255,255,255);
        imagefilledrectangle($this->TRUE_COLOR,0,0,$this->ZOOM_WIDTH,$this->ZOOM_HEIGHT,$WHITE);
        imagecopyresized($this->TRUE_COLOR,$this->PICTURE_CREATE,0,0,0,0,$this->ZOOM_WIDTH,$this->ZOOM_HEIGHT,$this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
    }

    //裁切图片,按坐标或自动
    function cut()
    {
        $this->TRUE_COLOR=imagecreatetruecolor($this->CUT_WIDTH,$this->CUT_WIDTH);
        imagecopy($this->TRUE_COLOR,$this->PICTURE_CREATE, 0, 0, $this->CUT_X, $this->CUT_Y,$this->CUT_WIDTH,$this->CUT_HEIGHT);
    }

    /*
    在图片上放文字或图片
    水印文字
    */
    function _mark_text()
    {
        $this->TRUE_COLOR=imagecreatetruecolor($this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        $this->WORD=mb_convert_encoding($this->FONT_WORD,'utf-8','gb2312');
        /*
        取得使用 TrueType 字体的文本的范围
        */
        $TEMP = imagettfbbox($this->FONT_SIZE,0,$this->FONT_PATH,$this->WORD);
        $WORD_LENGTH=strlen($this->WORD);
        $WORD_WIDTH =$TEMP[2] - $TEMP[6];
        $WORD_HEIGHT =$TEMP[3] - $TEMP[7];
        /*
        文字水印的默认位置为右下角
        */
        if($this->WORD_X=="") {
            $this->WORD_X=$this->PICTURE_WIDTH-$WORD_WIDTH;
        }
        if($this->WORD_Y=="") {
            $this->WORD_Y=$this->PICTURE_HEIGHT-$WORD_HEIGHT;
        }
        imagesettile($this->TRUE_COLOR,$this->PICTURE_CREATE);
        imagefilledrectangle($this->TRUE_COLOR,0,0,$this->PICTURE_WIDTH,$this->PICTURE_HEIGHT,IMG_COLOR_TILED);
        $TEXT2=imagecolorallocate($this->TRUE_COLOR,$this->RED,$this->GREEN,$this->Blue);
        imagettftext($this->TRUE_COLOR,$this->FONT_SIZE,$this->ANGLE,$this->WORD_X,$this->WORD_Y,$TEXT2,$this->FONT_PATH,$this->WORD);
    }

    /*
    水印图片
    */
    function _mark_picture()
    {
        /*
        获取水印图片的信息
        */
        @$SIZE=getimagesize($this->FORCE_URL);
        if(!$SIZE) {
            exit($this->ERROR['unalviable']);
        }

        $FORCE_PICTURE_HEIGHT=$SIZE[1];
        //创建水印图片
        switch($SIZE[2]) {
            case 1:
                $FORCE_PICTURE_CREATE=imagecreatefromgif($this->FORCE_URL);
                $FORCE_PICTURE_TYPE="gif";
                break;
            case 2:
                $FORCE_PICTURE_CREATE=imagecreatefromjpeg($this->FORCE_URL);
                $FORCE_PICTURE_TYPE="jpg";
                break;
            case 3:
                $FORCE_PICTURE_CREATE=imagecreatefrompng($this->FORCE_URL);
                $FORCE_PICTURE_TYPE="png";
                break;
        }
        /*
          判断水印图片的大小，并生成目标图片的大小，如果水印比图片大，则生成图片大小为水印图片的大小。否则生成的图片大小为原图片大小。
        */
        $this->NEW_PICTURE=$this->PICTURE_CREATE;
        if($this->FORCE_PICTURE_WIDTH>$this->PICTURE_WIDTH) {
            $CREATE_WIDTH=$this->FORCE_PICTURE_WIDTH-$this->FORCE_START_X;
        } else {
            $CREATE_WIDTH = $this->PICTURE_WIDTH;
        }

        if($this->FORCE_PICTURE_HEIGHT>$this->PICTURE_HEIGHT)
        {
            $CREATE_HEIGHT=$this->FORCE_PICTURE_HEIGHT-$this->FORCE_START_Y;
        } else {
            $CREATE_HEIGHT=$this->PICTURE_HEIGHT;
        }
        /*
        创建一个画布
        */
        $NEW_PICTURE_CREATE=imagecreatetruecolor($CREATE_WIDTH,$CREATE_HEIGHT);
        $WHITE=imagecolorallocate($NEW_PICTURE_CREATE,255,255,255);
        /*
        将背景图拷贝到画布中
        */
        imagecopy($NEW_PICTURE_CREATE, $this->PICTURE_CREATE, 0, 0, 0, 0,$this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        /*
        将目标图片拷贝到背景图片上
        */
        imagecopy($NEW_PICTURE_CREATE, $FORCE_PICTURE_CREATE, $this->FORCE_X, $this->FORCE_Y, $this->FORCE_START_X, $this->FORCE_START_Y,$FORCE_PICTURE_WIDTH,$FORCE_PICTURE_HEIGHT);
        $this->TRUE_COLOR=$NEW_PICTURE_CREATE;
    }

    function alpha_()
    {
        $this->TRUE_COLOR=imagecreatetruecolor($this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        $rgb="#CDCDCD";
        $tran_color="#000000";
        for($j=0;$j<=$this->PICTURE_HEIGHT-1;$j++) {
            for ($i=0;$i<=$this->PICTURE_WIDTH-1;$i++) {
                $rgb = imagecolorat($this->PICTURE_CREATE,$i,$j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $now_color=imagecolorallocate($this->PICTURE_CREATE,$r,$g,$b);
                if ($now_color==$tran_color) {
                    continue;
                } else {
                    $color=imagecolorallocatealpha($this->PICTURE_CREATE,$r,$g,$b,$ALPHA);
                    imagesetpixel($this->PICTURE_CREATE,$ALPHA_X+$i,$ALPHA_Y+$j,$color);
                }
                $this->TRUE_COLOR=$this->PICTURE_CREATE;
            }
        }
    }

    /*
    图片旋转:
    沿y轴旋转
    */
    function turn_y()
    {
        $this->TRUE_COLOR=imagecreatetruecolor($this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        for ($x = 0; $x < $this->PICTURE_WIDTH; $x++) {
            imagecopy($this->TRUE_COLOR, $this->PICTURE_CREATE, $this->PICTURE_WIDTH - $x - 1, 0, $x, 0, 1, $this->PICTURE_HEIGHT);
        }
    }

    /*
    沿X轴旋转
    */
    function turn_x()
    {
        $this->TRUE_COLOR=imagecreatetruecolor($this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        for ($y = 0; $y < $this->PICTURE_HEIGHT; $y++) {
            imagecopy($this->TRUE_COLOR, $this->PICTURE_CREATE, 0, $this->PICTURE_HEIGHT - $y - 1, 0, $y, $this->PICTURE_WIDTH, 1);
        }
    }

    /*
    任意角度旋转
    */
    function turn()
    {
        $this->TRUE_COLOR=imagecreatetruecolor($this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        imageCopyResized($this->TRUE_COLOR,$this->PICTURE_CREATE,0,0,0,0,$this->PICTURE_WIDTH,$this->PICTURE_HEIGHT,$this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        $WHITE=imagecolorallocate($this->TRUE_COLOR,255,255,255);
        $this->TRUE_COLOR=imagerotate ($this->TRUE_COLOR, $this->CIRCUMROTATE, $WHITE);
    }

    /*
    图片锐化
    */
    function sharp()
    {
        $this->TRUE_COLOR=imagecreatetruecolor($this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        $cnt=0;
        for ($x=0; $x<$this->PICTURE_WIDTH; $x++) {
            for ($y=0; $y<$this->PICTURE_HEIGHT; $y++) {
                $src_clr1 = imagecolorsforindex($this->TRUE_COLOR, imagecolorat($this->PICTURE_CREATE, $x-1, $y-1));
                $src_clr2 = imagecolorsforindex($this->TRUE_COLOR, imagecolorat($this->PICTURE_CREATE, $x, $y));
                $r = intval($src_clr2["red"]+$this->SHARP*($src_clr2["red"]-$src_clr1["red"]));
                $g = intval($src_clr2["green"]+$this->SHARP*($src_clr2["green"]-$src_clr1["green"]));
                $b = intval($src_clr2["blue"]+$this->SHARP*($src_clr2["blue"]-$src_clr1["blue"]));
                $r = min(255, max($r, 0));
                $g = min(255, max($g, 0));
                $b = min(255, max($b, 0));
                if (($DST_CLR=imagecolorexact($this->PICTURE_CREATE, $r, $g, $b))==-1)
                    $DST_CLR = imagecolorallocate($this->PICTURE_CREATE, $r, $g, $b);
                $cnt++;
                if ($DST_CLR==-1) die("color allocate faile at $x, $y ($cnt).");
                imagesetpixel($this->TRUE_COLOR, $x, $y, $DST_CLR);
            }
        }
    }

    /*
      将图片反色处理??
    */
    function return_color()
    {
        /*
        创建一个画布
        */
        $NEW_PICTURE_CREATE=imagecreate($this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        $WHITE=imagecolorallocate($NEW_PICTURE_CREATE,255,255,255);
        /*
        将背景图拷贝到画布中
        */
        imagecopy($NEW_PICTURE_CREATE, $this->PICTURE_CREATE, 0, 0, 0, 0,$this->PICTURE_WIDTH,$this->PICTURE_HEIGHT);
        $this->TRUE_COLOR=$NEW_PICTURE_CREATE;
    }

    /*
    生成目标图片并显示
    */
    function show()
    {
        // 判断浏览器,若是IE就不发送头
        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            $ua = strtoupper($_SERVER['HTTP_USER_AGENT']);
            if(!preg_match('/^.*MSIE.*\)$/i',$ua)) {
                header("Content-type:$this->PICTURE_MIME");
            }
        }
        $OUT=$this->PICTURE_TYPE;
        $OUT($this->TRUE_COLOR);
    }

    /*
    生成目标图片并保存
    */
    function save_picture()
    {
        // 以 JPEG 格式将图像输出到浏览器或文件
        $OUT=$this->PICTURE_TYPE;
        if(function_exists($OUT)) {
            // 判断浏览器,若是IE就不发送头
            if(isset($_SERVER['HTTP_USER_AGENT'])) {
                $ua = strtoupper($_SERVER['HTTP_USER_AGENT']);
                if(!preg_match('/^.*MSIE.*\)$/i',$ua)) {
                    header("Content-type:$this->PICTURE_MIME");
                }
            }
            if(!$this->TRUE_COLOR) {
                exit($this->ERROR['unavilable']);
            } else {
                $OUT($this->TRUE_COLOR,$this->DEST_URL);
                $OUT($this->TRUE_COLOR);
            }
        }
    }

    /*
    析构函数：释放图片
    */
    function __destruct()
    {
        /*释放图片*/
        imagedestroy($this->TRUE_COLOR);
        imagedestroy($this->PICTURE_CREATE);
    }
}
