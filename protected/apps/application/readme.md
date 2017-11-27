#application 目录介绍 


#####application下面所有的项目，命名空间均从\application开始
---
* common 与项目相关的通用类
* config 全局配置和与项目相关的配置
* web 真正的项目目录
    * admin 后台目录
        * components admin项目中的components
        * controllers 控制器
        * models 该项目中的模型
        * views 模板目录
    * api 接口目录
        * 同上。。。
    * thumb 
        * 如果项目在apache下，thumb项目同于生成图片缩略图
        * 配置直接看/webroot/thumb/下的config文件
    * www 前台目录


#####文件介绍 
* bootstrap.php 一些常用路径的配置，也可以直接改和在这里定义
        
