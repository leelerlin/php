<?php

/*
参考   https://www.cnblogs.com/woider/p/6443854.html
 */

class Loader
{
    /* 路径映射 */
    public static $vendorMap = array(
        'app' => __DIR__ . DIRECTORY_SEPARATOR . 'app',
    );

    /**
     * 自动加载器
     */
    public static function autoload($class)
    {
        $file = self::findFile($class);
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }

    /**
     * 解析文件路径
     */
    private static function findFile($class)
    {
        $vendor = substr($class, 0, strpos($class, '\\')); // 顶级命名空间
        $vendorDir = self::$vendorMap[$vendor]; // 文件基目录
        $filePath = substr($class, strlen($vendor)) . '.php'; // 文件相对路径
        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR); // 文件标准路径
    }

    /**
     * 引入文件
     */
    private static function includeFile($file)
    {
        if (is_file($file)) {
            include $file;
        }
    }
}


include 'Loader.php'; // 引入加载器
spl_autoload_register('Loader::autoload'); // 注册自动加载
// 首先我们创建一个文件 Index.php，它处于 \app\mvc\view\home 目录中：
new \app\mvc\view\home\Index(); // 实例化未引用的类
