<?php
/**
 * @category message.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/4/9 下午2:43
 * @since
 */


use yii\helpers\Html;
use yii\helpers\Url;

//echo $this->params['title'];

if ($url != null) {
    $url = Url::to( $url );
    $this->registerMetaTag( [ 'http-equiv' => "refresh", 'content' => "{$time};URL={$url}" ] );
}
?>
<div class="login-container ">
    <div class="center">
        <h1>
            &nbsp;
        </h1>
        <h1>
            &nbsp;
        </h1>
    </div>
    <div class="space-6"></div>
    <div class="position-relative ">
        <div id="login-box" class="login-box visible widget-box no-border ">
            <div class="widget-body ">
                <div class="widget-main alert-<?= $mode; ?>">
                    <h4 class="header lighter bigger">
                        <?= Html::encode( $title ) ?>
                    </h4>
                    <div class="space-6"></div>
                    <fieldset class="center">
                        <?= Html::encode( $message ) ?>
                        <div class="space"></div>
                    </fieldset>
                    <div class="social-or-login center">
                    </div>
                    <div class="social-login text-right">
                        <div class="clearfix">
                            <a href="<?php echo Url::to( $url ); ?>">如果<?= $time; ?>秒没有跳转，点击跳转</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
