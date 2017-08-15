create database myshop;

use myshop;

set names gbk;

#创建商品表
create table shop_goods
(
	id mediumint unsigned not null auto_increment comment 'Id',
	goods_name varchar(150) not null comment '商品名称',
	market_price decimal(10,2) not null comment '市场价格',
	shop_price decimal(10,2) not null comment '本店价格',
	goods_desc longtext comment '商品描述',
	is_on_sale enum('是','否') not null default '是' comment '是否上架',
	is_delete enum('是','否')  not null default '否' comment '是否放到回收站',
	addtime datetime not null comment '添加时间',
	logo varchar(150) not null default '' comment '原图',
	sm_logo varchar(150) not null default '' comment '小图',
	mid_logo varchar(150) not null default '' comment '中图',
	big_logo varchar(150) not null default '' comment '大图',
	mbig_logo varchar(150) not null default '' comment '更大图',
	brand_id mediumint unsigned not null default '0' comment '品牌id',
	cat_id mediumint unsigned not null default '0' comment '主分类id',
	primary key (id),
	key shop_price(shop_price),     #单列索引
	key addtime(addtime),			#单列索引
	key is_on_sale(is_on_sale),		#单列索引
	key brand_id(brand_id),			#单列索引
	key cat_id(cat_id)			#单列索引
)engine = InnoDB default charset=utf8 comment '商品';

#创建品牌管理表
create table shop_brand
(
	id mediumint unsigned not null auto_increment comment 'Id',
	brand_name varchar(30) not null comment '品牌名称',
	site_url varchar(150) not null default '' comment '官方网址',
	logo varchar(150) not null default '' comment '品牌Logo地址',
	primary key (id)
)engine = InnoDB default charset=utf8 comment '品牌';

#创建会员表
drop table if exists shop_member_level;
create table shop_member_level
(
	id mediumint unsigned not null auto_increment comment 'Id',
	level_name varchar(30) not null comment '级别名称',
	jifen_bottom mediumint unsigned not null comment '积分下限',
	jifen_top mediumint unsigned not null comment '积分上限',
	primary key(id)	
)engine = InnoDB default charset=utf8 comment '会员级别';

#会员价格表
drop table if exists shop_member_price;
create table shop_member_price
(
	price decimal(10,2) not null comment '会员价格',
	level_id mediumint unsigned not null comment '级别id',
	goods_id mediumint unsigned not null comment '商品id',
	key level_id(level_id),
	key goods_id(goods_id)
)engine = InnoDB default charset=utf8 comment '会员价格';

#商品相册表
drop table if exists shop_goods_pic;
create table shop_goods_pic
(
	id mediumint unsigned not null auto_increment comment 'Id',
	pic varchar(150) not null comment '原图',
	sm_pic varchar(150) not null comment '小图',
	mid_pic varchar(150) not null comment '中图',
	big_pic varchar(150) not null comment '大图',
	goods_id mediumint unsigned not null comment '商品Id',
	primary key(id),	
	key goods_id(goods_id)
)engine = InnoDB default charset=utf8 comment '商品相册';

#分类菜单表
drop table if exists shop_category;
create table shop_category
(
	id mediumint unsigned not null auto_increment comment 'Id',
	cat_name varchar(30) not null comment '分类名称',
	parent_id mediumint unsigned not null default '0' comment '上级的分类Id,0：顶级分类',
	primary key(id)	
)engine = InnoDB default charset=utf8 comment '分类';

INSERT INTO `shop_category` (`id`, `cat_name`, `parent_id`) VALUES
(1, '家用电器', 0),
(2, '手机、数码、京东通信', 0),
(3, '电脑、办公', 0),
(4, '家居、家具、家装、厨具', 0),
(5, '男装、女装、内衣、珠宝', 0),
(6, '个护化妆', 0),
(21, 'iphone', 2),
(8, '运动户外', 0),
(9, '汽车、汽车用品', 0),
(10, '母婴、玩具乐器', 0),
(11, '食品、酒类、生鲜、特产', 0),
(12, '营养保健', 0),
(13, '图书、音像、电子书', 0),
(14, '彩票、旅行、充值、票务', 0),
(15, '理财、众筹、白条、保险', 0),
(16, '大家电', 1),
(17, '生活电器', 1),
(18, '厨房电器', 1),
(19, '个护健康', 1),
(20, '五金家装', 1),
(22, '冰箱', 16);