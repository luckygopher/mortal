<?php
return array(
    'maxSize'=> '1000000', //允许上传文件的最大长度，单位B
    'allowType'=> [    //允许上传的文件类型
        'png',
        'jpeg',
        'jpg'
    ],
    'filePath'=> ROOT.'/storage/upload/',  //上传文件的保存路径
    'isRandName' => true  //上传文件保存，是否使用随机文件名 false使用原文件名
);