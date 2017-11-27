#####目录介绍 

* base 全局通用基类
* db   
    * base 全局通用引用的AR
    * behaviors 默认的行为，在数据库里加4个字段：
        * created_at ,updated_at created_by updated_by 
* image 就当没吊用吧
* job  早期引入的yii-queue的简单实现，2.12有yii-queue后，已废弃
* message 常用的一些提示，无用
* session 全局的session，用于存放一些默认的小变量
* template 
    * blade 模板（本来支持的blade类有些不适合，这里改过了）
        * 增加了 @define变量
        * 如果要支持blade默认的app方法，就是functions.php中的方法
            * blade对命名空间支持一般，所以functions里有一些简化的方法            
