<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/18 上午10:07
 * @since
 */
use application\web\admin\components\AdminAsset;
use yii\helpers\Html;
use yii\web\View;

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
    $this->registerCssFile('@webstatic/vendor/ace/assets/css/font-awesome.min.css', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerCssFile('@webstatic/vendor/ace/assets/css/font-awesome-ie7.min.css', [
        'depends'   => 'yii\web\JqueryAsset',
        'condition' => 'IE 7',
    ]);
    $this->registerCssFile('@webstatic/vendor/ace/assets/css/google-fonts.css', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerCssFile('@webstatic/vendor/ace/assets/css/ace.min.css', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerCssFile('@webstatic/vendor/ace/assets/css/ace-rtl.min.css', ['depends' => 'yii\web\JqueryAsset']);
    //$this->registerCssFile( '@webstatic/vendor/ace/assets/css/ace-skins.min.css', [ 'depends' => 'yii\web\JqueryAsset' ] );
    $this->registerCssFile('@webstatic/vendor/ace/assets/css/ace-ie.min.css', [
        'depends'   => 'yii\web\JqueryAsset',
        'condition' => 'lte IE 8',
    ]);
    $this->registerJsFile('@webstatic/vendor/ace/assets/js/ace-extra.min.js', ['position' => View::POS_HEAD]);
    //$this->registerJsFile( '@webstatic/vendor/ace/assets/js/html5shiv.js', [ 'position' => View::POS_HEAD, 'condition' => 'lte IE 9' ] );
    $this->registerJsFile('@webstatic/vendor/ace/assets/js/respond.min.js', [
        'position'  => View::POS_HEAD,
        'condition' => 'lte IE 9',
    ]);
    ?>
</head>
<body class="login-layout">
<?php $this->beginBody() ?>
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
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


