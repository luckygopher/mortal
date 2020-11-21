<?php
/**
 * 配置模版全局变量
 */
use core\lib\App;

App::get('twig')->addGlobal('__PUBLIC__', __PUBLIC__);