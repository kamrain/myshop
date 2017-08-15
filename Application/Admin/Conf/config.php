<?php
return array(
	//设置数据库信息
	'DB_TYPE'               =>  'mysqli',     // 数据库类型
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'myshop',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  'root',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'shop_',    // 数据库表前缀
	'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
	'DB_FIELDS_CACHE'       =>  false,        // 启用字段缓存

	'DEFAULT_FILTER'		=> 	'trim,htmlspecialchars',//过滤特殊字符
	//模版引擎设置
	'LAYOUT_NAME'			=>  'layout',  //布局文件名

	//图片上传和显示配置
	'IMAGE_CONFIG'			=>array(
			'maxSize'		=>	1024*1024,
			'exts'			=> 	array('jpg','jpeg','png','gif'),
			'rootPath'		=>	'./Public/Uploads/',
			'viewPath'		=> 	__ROOT__.'/Public/Uploads/',
		),
);