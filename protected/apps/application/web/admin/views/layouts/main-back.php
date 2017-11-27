<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/18 上午10:07
 * @since
 */
use application\web\admin\components\AdminAsset;
use application\web\admin\components\Menu;
use common\assets\ace\AceNav;
use common\assets\ace\FlashAlert;
use common\assets\ace\TipsWidget;
use yii\helpers\Html;
use yii\web\View;
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
    <?php
//    $this->registerCssFile('@webstatic/vendor/ace/assets/css/font-awesome.min.css', ['depends' => 'yii\web\JqueryAsset']);
//    $this->registerCssFile('@webstatic/vendor/ace/assets/css/font-awesome-ie7.min.css', [
//        'depends'   => 'yii\web\JqueryAsset',
//        'condition' => 'IE 7',
//    ]);
//    $this->registerCssFile('@webstatic/vendor/ace/assets/css/google-fonts.css', ['depends' => 'yii\web\JqueryAsset']);
//    $this->registerCssFile('@webstatic/vendor/ace/assets/css/ace.min.css', ['depends' => 'yii\web\JqueryAsset']);
//    $this->registerCssFile('@webstatic/vendor/ace/assets/css/ace-rtl.min.css', ['depends' => 'yii\web\JqueryAsset']);
//    $this->registerCssFile('@webstatic/vendor/ace/assets/css/ace-skins.min.css', ['depends' => 'yii\web\JqueryAsset']);
//    $this->registerCssFile('@webstatic/vendor/ace/assets/css/ace-ie.min.css', [
//        'depends'   => 'yii\web\JqueryAsset',
//        'condition' => 'lte IE 8',
//    ]);
//    $this->registerJsFile('@webstatic/vendor/ace/assets/js/ace-extra.min.js', ['position' => View::POS_HEAD]);
//    $this->registerJsFile('@webstatic/vendor/ace/assets/js/html5shiv.js', [
//        'position'  => View::POS_HEAD,
//        'condition' => 'lte IE 9',
//    ]);
//    $this->registerJsFile('@webstatic/vendor/ace/assets/js/respond.min.js', [
//        'position'  => View::POS_HEAD,
//        'condition' => 'lte IE 9',
//    ]);
    ?>
</head>
<body class="navbar-fixed breadcrumbs-fixed">
<?php $this->beginBody() ?>
<div class="navbar navbar-default navbar-fixed-top" id="navbar">
    <div class="navbar-container container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i> 后台管理系统
                </small>
            </a><!-- /.brand -->
        </div>
        <!-- /.navbar-header -->
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
        <!-- /.navbar-header -->
    </div>
    <!-- /.container -->
</div>
<div class="main-container container" id="main-container">
    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#"> <span class="menu-text"></span> </a>
        <div class="sidebar sidebar-fixed" id="sidebar">
            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                    <button class="btn btn-success">
                        <i class="icon-signal"></i>
                    </button>
                    <button class="btn btn-info">
                        <i class="icon-pencil"></i>
                    </button>
                    <button class="btn btn-warning">
                        <i class="icon-group"></i>
                    </button>
                    <button class="btn btn-danger">
                        <i class="icon-cogs"></i>
                    </button>
                </div>
                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span> <span class="btn btn-info"></span> <span class="btn btn-warning"></span>
                    <span class="btn btn-danger"></span>
                </div>
            </div>
            <?php

            echo AceNav::widget([
                'items'   => (new Menu())->toMenuArray(),
                'options' => ['class' => 'nav nav-list'],
            ]);
            ?>
            <!-- /.nav-list -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
            <div></div>
        </div>
        <div class="main-content">
            <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                    </li>
                    <?= Breadcrumbs::widget([
                        'links'        => isset($this->params['breadcrumbs'])
                            ? $this->params['breadcrumbs'] : ['DashBoard'],
                        'itemTemplate' => "<li>{link}</li>\n",
                    ]); ?>
                </ul>
                <!-- .breadcrumb -->
                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                        <span class="input-icon">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                            <i class="icon-search nav-search-icon"></i> </span>
                    </form>
                </div>
            </div>
            <div class="page-content">
                <?php echo FlashAlert::widget(); ?><?php echo $content; ?>
            </div>
        </div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
</div>
<!--<script src="--><?php //echo Yii::getAlias( '@webstatic/vendor/ace/assets/js/jquery-2.0.3.min.js' ); ?><!--"></script>-->
<?php
$this->registerJsFile('@webstatic/vendor/ace/assets/js/typeahead-bs2.min.js', [
    'depends'  => 'yii\web\JqueryAsset',
    'position' => View::POS_END,
]);
$this->registerJsFile('@webstatic/vendor/ace/assets/js/jquery-ui-1.10.3.custom.min.js', [
    'depends'  => 'yii\web\JqueryAsset',
    'position' => View::POS_END,
]);
$this->registerJsFile('@webstatic/vendor/ace/assets/js/jquery.ui.touch-punch.min.js', [
    'depends'  => 'yii\web\JqueryAsset',
    'position' => View::POS_END,
]);
$this->registerJsFile('@webstatic/vendor/ace/assets/js/jquery.slimscroll.min.js', [
    'depends'  => 'yii\web\JqueryAsset',
    'position' => View::POS_END,
]);
$this->registerJsFile('@webstatic/vendor/ace/assets/js/ace-elements.min.js', [
    'depends'  => 'yii\web\JqueryAsset',
    'position' => View::POS_END,
]);
$this->registerJsFile('@webstatic/vendor/ace/assets/js/ace.min.js', [
    'depends'  => 'yii\web\JqueryAsset',
    'position' => View::POS_END,
]);
$this->registerJsFile('@webstatic/vendor/ace/assets/js/bootbox.min.js', [
    'position' => View::POS_END,
    'depends'  => 'yii\web\JqueryAsset',
]);
?>

<?php $this->endBody() ?>
<script type="text/javascript">
    if ("ontouchend" in document) {
        document.write("<script src='<?php echo Yii::getAlias('@webstatic/vendor/ace/assets/js/jquery.mobile.custom.min.js');?>'>" + "<" + "script>");
    }
</script>
</body>
</html>
<?php $this->endPage() ?>


