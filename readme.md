####全目录配置

* datas 用于存放一些与项目相关文件。可以当成临时或者其他存储的目录
* deploy 项目部署文件，最终是通过deploy/httpd/__template.php进行配置
    * 视情况定，目前的基础配置是基于 nginx + apache 来进行管理的
* protected 整体项目
* runtime runtime目录
* vendor composer生成的目录
* webroot 前台WEB目录
    * admin
    * static 如果WEB是指向webroot的，这个static就可以直接用。否则要单独指一个域名
    * api
    * www
    * index.php (看想将哪个项目指定为默认的，就可以include哪个目录下的index.php文件) 


#####目录下的文件配置
* .env.example 配置文件模板，改成.env，就将被项目进行读取
* .gitignore 默认git忽略内容
* app.sh 用于生成默认的model。默认的只支持 yii::$app->db，生成后会调用yii cache/flush-schema --inactive=0
* init 是将deploy目录下的内容模板生成相应的配置
* composer.json 不解释 
