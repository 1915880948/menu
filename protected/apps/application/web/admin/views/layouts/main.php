<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/18 上午10:07
 * @since
 */
use application\web\admin\components\AdminAsset;
use application\models\base\SystemMenu;
use common\assets\ace\AceNav;
use common\assets\ace\FlashAlert;
use common\assets\ace\TipsWidget;
use common\assets\widgets\SearchWidget;
use qiqi\helper\TreeHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo Html::encode($this->title); ?> - <?php echo Html::encode(Yii::$app->name); ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php echo Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="navbar navbar-default" id="navbar">
    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i> 后台管理系统
                </small>
            </a>
        </div>
        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <?php echo TipsWidget::widget(); ?>
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <!--<img class="nav-user-photo" src="-->
                        <?php //echo Yii::getAlias( '@webstatic/vendor/ace/assets/avatars/user.jpg' ); ?><!--" alt="Jason's Photo"/>-->
                        <span class="user-info">
                            <small>欢迎光临,</small>
                            <?php echo Yii::$app->getUser()
                                                ->getIdentity()->username; ?>
                        </span> <i class="icon-caret-down"></i> </a>
                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <?php echo Html::a('<i class="icon-cog"></i> 设置', ['user/setting']) ?>
                        </li>
                        <li>
                            <?php echo Html::a('<i class="icon-user"></i> 个人资料', ['user/profile']) ?>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?php echo Html::a('<i class="icon-off"></i> 退出', ['site/logout']) ?>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /.ace-nav -->
        </div>
    </div>
</div>
<div class="main-container" id="main-container">
    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#"> <span class="menu-text"></span> </a>
        <div class="sidebar" id="sidebar">
            <?php
            echo AceNav::widget([
                'items'   => TreeHelper::getInstance([
                    'model' => SystemMenu::find()
                                         ->active()
                ])
                                       ->toMenuArray(),
                'options' => ['class' => 'nav nav-list'],
            ]);
            ?>
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
            <div></div>
        </div>
        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                    </li>
                    <?= Breadcrumbs::widget([
                        'links'        => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : ['DashBoard'],
                        'itemTemplate' => "<li>{link}</li>\n",
                    ]); ?>
                </ul>
                <div class="nav-search" id="nav-search">
                    <?= SearchWidget::widget([
                        'forms' => isset($this->params['search']) ? $this->params['search'] : null
                    ]); ?>
                </div>
            </div>
            <div class="page-content">
                <?php
                echo FlashAlert::widget();
                echo $content; ?>
            </div>
        </div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
</div>
<?php $this->endBody() ?>
<script type="text/javascript">
    if ("ontouchend" in document) {
        document.write("<script src='<?php echo Yii::getAlias('@webstatic/vendor/ace/assets/js/jquery.mobile.custom.min.js');?>'>" + "<" + "script>");
    }
    $(function () {

        if (!$('.nav-list li:eq(0)').hasClass('active')) {
            $('.nav-list li:eq(0) a').trigger('click');
        }
    });
</script>
<div style="display:none"></div>
</body>
</html>
<?php $this->endPage() ?>


