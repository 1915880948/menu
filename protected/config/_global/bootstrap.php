<?php
/**
 * webdomain
 */
Yii::setAlias("domain", (isset($_SERVER['SERVER_NAME'])
    ? ($start = strpos($_SERVER['SERVER_NAME'], '.')) !== false
        ? substr($_SERVER['SERVER_NAME'], $start + 1) : $_SERVER['SERVER_NAME'] : ""));
/**
 * 开启debug model
 */
/**
 * root 相关目录
 */
Yii::setAlias("root", PROJECT_ROOT);
Yii::setAlias("webroot", '@root/webroot');
Yii::setAlias("library", "@root/protected");

/**
 * library 目录
 */
Yii::setAlias("common", "@library/common");
Yii::setAlias("apps", "@library/apps");
Yii::setAlias("tools", "@library/tools");
Yii::setAlias("models", "@library/models");
Yii::setAlias("modules", "@library/modules");
Yii::setAlias("data", "@library/data");
Yii::setAlias("ext", "@library/ext");
Yii::setAlias("helper", "@library/helper");
Yii::setAlias("config", "@library/config");

/**
 * console 是全局的
 */
Yii::setAlias("console", "@apps/console");
/**
 * datas
 */
Yii::setAlias('datas', "@root/datas");
/**
 * 加载全局函数
 */
include Yii::getAlias("@common/functions.php");
