<?php

return array(

    /* 性能设置 */
'URL_CASE_INSENSITIVE' =>false,
    'TMPL_CACHE_ON'=>false, // 模板缓存

    'HTML_CACHE_ON'=>false, // 静态缓存
    'URL_ROUTER_ON'=>true, // URL路由
	'URL_ROUTE_RULES'=>array(

	    'show'=>'Home/Index/index',
	    'make'=>'Home/Index/makeZh',
 
	),
    'DB_SQL_BUILD_CACHE'=>false, // SQL查询缓存

    'URL_MODEL'=>3, // URL访问模式
//     'DATA_CACHE_TYPE'       =>  'Memcache',
	'MEMCACHE_HOST'  => '127.0.0.1',
	'MEMCACHE_PORT'  => '11211',
	'DATA_CACHE_TIME' => '986400',

    'URL_HTML_SUFFIX'=>'html', // 伪静态后缀

	'DATA_CACHE_SUBDIR'     =>  true,    // 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)

   'DATA_PATH_LEVEL'       =>  2,        // 子目录缓存级别

);