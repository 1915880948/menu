<?php
/**
 * login.php
 */
use apps\admin\models\form\AdminLogin;
use application\web\admin\models\AdminUseLoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "用户登录";
/** @var AdminUserLoginForm $model */
?>
<div class="login-container">
    <div style="height:100px;">&nbsp;</div>
    <div class="center">
        &nbsp;
    </div>
    <div class="space-6"></div>
    <div class="position-relative">
        <div id="login-box" class="login-box visible widget-box no-border">
            <div class="widget-body">
                <div class="widget-main">
                    <h4 class="header blue lighter bigger">
                        <i class="icon-coffee green"></i> 后台管理登录
                    </h4>
                    <div class="space-6"></div>
                    <?php $form = ActiveForm::begin([
                        'id'      => 'site-login',
                        'options' => ['class' => 'form-signin'],
                    ]); ?>
                    <fieldset>
                        <?php echo $form->field($model, 'username')->label('用户名')
                                        ->textInput(['placeholder' => '请输入用户名', 'class' => 'form-control']); ?>
                        <?php echo $form->field($model, 'password')->label('密  码')
                                        ->passwordInput(['placeholder' => '请输入密码', 'class' => 'form-control']); ?>
                        <div class="space"></div>
                        <div class="clearfix">
                            <label class="inline">
                                &nbsp;
                            </label>
                            <?php echo Html::submitButton('<i class="icon-key"></i> 登录', ['class' => 'width-35 pull-right btn btn-sm btn-primary']); ?>
                        </div>
                        <div class="space-4"></div>
                    </fieldset>
                    <?php $form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
