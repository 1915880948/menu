<?php
/**
 * @category KindeditActiveField
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/4/8 下午12:00
 * @since
 */
namespace common\assets\widgets;

use app\common\widget\ModalWidget;
use common\assets\editor\Kindeditor;
use Yii;
use yii\bootstrap\ActiveField;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * Class KindeditActiveField
 * @package common\base\widgets
 */
class KindeditActiveField extends ActiveField
{
    public function multiImageUploadInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $inputID = Html::getInputId($this->model, $this->attribute);
        /**
         * input
         */
        $inputString = Html::activeTextInput($this->model, $this->attribute, ArrayHelper::merge($options, [
            'id'  => "attach_{$inputID}",
            'abc' => 'def',
        ]));
        /**
         * button
         */
        $inputString .= Html::button((isset($options['btnLabel']) ? $options['btnLabel'] : '上传附件'), [
            'id'    => "upload_{$inputID}",
            'class' => 'btn btn-primary btn-minier middle',
            'style' => 'margin:2px 5px 0px 5px;',
        ]);
        if(isset($this->model[$this->attribute]) && $this->model[$this->attribute]){
            /**
             *
             */
            $imageString = "<div class='clearfix'></div><div class='col-xs-12 col-sm-5'>";
            $imageSrc = $this->model[$this->attribute];
            if(strpos($this->model[$this->attribute], "http://") === false){
                $imageSrc = \Yii::getAlias("@webuploads") . $imageSrc;
            }
            $imageString .= Html::img($imageSrc, [
                'style' => "max-width:100px;",
                "id"    => "img_{$inputID}",
            ]);
            $imageString .= "</div>";
            $this->template = "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{$imageString}\n{endWrapper}";
        }
        $this->parts['{input}'] = $inputString;
        Kindeditor::createImageUploadById("#upload_{$inputID}", "#attach_{$inputID}", Url::toRoute([
            'site/upload',
            //'_csrf' => \Yii::$app->getRequest()->getCsrfToken(),
        ]));

        return $this;
    }

    /**
     * Renders a text input.
     * This method will generate the "name" and "value" tag attributes automatically for the model
     * attribute unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered
     *                       as
     *                       the attributes of the resulting tag. The values will be HTML-encoded
     *                       using
     *                       [[Html::encode()]]. If you set a custom `id` for the input element,
     *                       you may need to adjust the [[$selectors]] accordingly.
     * @return static the field object itself
     */
    public function imageUploadInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $inputID = Html::getInputId($this->model, $this->attribute);
        Html::addCssClass($options, ["attach_{$inputID}"]);
        /**
         * input
         */
        $inputString = Html::activeTextInput($this->model, $this->attribute, $options);
        /**
         * button
         */
        $inputString .= Html::button((isset($options['btnLabel']) ? $options['btnLabel'] : '上传'), [
            // 'class'    => "upload_{$inputID}",
            'class' => "upload_{$inputID}" . ' btn btn-primary btn-minier middle',
            'style' => 'margin-left:5px;',
        ]);

        /**
         * 预览，如果有图片是这种预览
         */
        if(isset($this->model[$this->attribute]) && $this->model[$this->attribute]){
            $inputString .= Html::a('预览', "#preview-{$inputID}", [
                // 'class'    => "upload_{$inputID}",
                'class' => "preview_{$inputID}" . ' btn btn-primary btn-minier middle',
                'style' => 'margin-left:5px;',
                'data'  => ['toggle' => 'modal'],
            ]);
            $imageSrc = $this->model[$this->attribute];
            if(strpos($this->model[$this->attribute], "http://") === false){
                $imageSrc = \Yii::getAlias("@webuploads") . $imageSrc;
            }
            $imageString = ModalWidget::widget([
                'id'      => "preview-{$inputID}",
                'header'  => '图片预览',
                'content' => Html::img($imageSrc, [
                    'style' => "max-width:500px;",
                    "id"    => "img_{$inputID}",
                ])
            ]);
            // /**
            //  *
            //  */
            // $imageString = "<div class='clearfix'></div><div class='col-xs-12 col-sm-5'>";
            // $imageSrc = $this->model[$this->attribute];
            // if(strpos($this->model[$this->attribute], "http://") === false){
            //     $imageSrc = \Yii::getAlias("@webuploads") . $imageSrc;
            // }
            // $imageString .= Html::img($imageSrc, [
            //     'style' => "max-width:100px;",
            //     "id"    => "img_{$inputID}",
            // ]);
            // $imageString .= "</div>";
            $this->template = "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{$imageString}\n{endWrapper}";
        } else{//如果没有图片，或者刚上传完，怎么预览？
            $inputString .= Html::a('预览', "#preview-{$inputID}", [
                // 'class'    => "upload_{$inputID}",
                'class' => "preview_{$inputID}" . ' btn btn-primary btn-minier middle',
                'style' => 'margin-left:5px;',
                'data'  => ['toggle' => 'modal'],
            ]);
            $view = $this->form->getView();
            $imageString = ModalWidget::widget([
                'id'      => "preview-{$inputID}",
                'header'  => '图片预览',
                'content' => ''
            ]);
            $path = Yii::getAlias('@webuploads');
            $js = "
                $(\".preview_{$inputID}\").click(function(){
                     if($('.attach_{$inputID}').val()!=''){
                        var img = new Image;
                        img.src = '{$path}'+$('.attach_{$inputID}').val();
                        img.style='max-width:500px';
                        $('#preview-{$inputID} .modal-body').html(img);
                     }
                });
            ";
            $view->registerJs($js, View::POS_READY);
            $this->template = "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{$imageString}\n{endWrapper}";
        }
        $this->parts['{input}'] = $inputString;

        Kindeditor::createImageUploadById(".upload_{$inputID}", ".attach_{$inputID}", Url::toRoute(isset($options['url'])
            ? $options['url']
            : [
                'site/upload',
                //'_csrf' => \Yii::$app->getRequest()->getCsrfToken(),
            ]));

        return $this;
    }

    /**
     * Renders a text input.
     * This method will generate the "name" and "value" tag attributes automatically for the model
     * attribute unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered
     *                       as
     *                       the attributes of the resulting tag. The values will be HTML-encoded
     *                       using
     *                       [[Html::encode()]]. If you set a custom `id` for the input element,
     *                       you may need to adjust the [[$selectors]] accordingly.
     * @return static the field object itself
     */
    public function fileUploadInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $inputID = Html::getInputId($this->model, $this->attribute);
        /**
         * input
         */
        $inputString = Html::activeTextInput($this->model, $this->attribute, ArrayHelper::merge($options, ['id' => "attach_{$inputID}", 'abc' => 'def',]));
        /**
         * button
         */
        $inputString .= Html::button((isset($options['btnLabel']) ? $options['btnLabel'] : '上传附件'), [
            // 'id'    => "upload_{$inputID}",
            'class' => "upload_{$inputID}" . 'btn btn-primary btn-minier middle',
            'style' => 'margin:2px 5px 0px 5px;',
        ]);
        if(isset($this->model[$this->attribute]) && $this->model[$this->attribute]){
            /**
             *
             */
            $imageString = "<div class='clearfix'></div><div class='col-xs-12 col-sm-5'>";
            $imageSrc = $this->model[$this->attribute];
            if(strpos($this->model[$this->attribute], "http://") === false){
                $imageSrc = \Yii::getAlias("@webuploads") . $imageSrc;
            }
            $imageString .= Html::img($imageSrc, [
                'style' => "max-width:100px;",
                "class" => "img_{$inputID}",
            ]);
            $imageString .= "</div>";
            $this->template = "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{$imageString}\n{endWrapper}";
        }
        $this->parts['{input}'] = $inputString;
        Kindeditor::createFileUploadById(".upload_{$inputID}", ".attach_{$inputID}", Url::toRoute([
            'site/upload',
            'type' => 'audio',
            //'_csrf' => \Yii::$app->getRequest()->getCsrfToken(),
        ]));

        return $this;
    }

    public function btnUploadInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $inputID = Html::getInputId($this->model, $this->attribute);
        /**
         * input
         */
        $inputString = Html::activeTextInput($this->model, $this->attribute, ArrayHelper::merge($options, [
                'class' => "attach_{$inputID}",
            ])) . "&nbsp;&nbsp;&nbsp;";
        /**
         * button
         */
        $inputString .= Html::button((isset($options['btnLabel']) ? $options['btnLabel'] : '上传附件'), [
            // 'class'    => "upload_{$inputID}",
            'class' => 'btn btn-primary btn-minier ' . "upload_{$inputID}",
        ]);
        $this->parts['{input}'] = $inputString;
        Kindeditor::createBtnUploadById(".upload_{$inputID}", ".attach_{$inputID}", Url::toRoute([
            'site/upload',
        ]));

        return $this;
    }

    public function editorInput($options = [])
    {
        $inputID = Html::getInputId($this->model, $this->attribute);
        //$options['id'] = "editor_{$inputID}";
        $options['class'] = "editor_{$inputID}";
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        if(!isset($options['style'])){
            $options['style'] = "height:300px;";
        }
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);
        Kindeditor::createEditor(".editor_{$inputID}", isset($options['mode']) ? $options['mode'] : 'simple');

        return $this;
    }

    public function submitButton($options = [])
    {
        $inputString =
            Html::submitButton(isset($options['submit']) ? $options['submit'] : 'Submit', isset($options['submitOptions']) ? $options['submitOptions']
                : ['class' => 'btn btn-success']);
        if(isset($options['reset'])){
            $inputString .= Html::resetButton(isset($options['reset']) ? $options['reset'] : 'Reset', ArrayHelper::merge((isset($options['resetOptions'])
                ? $options['resetOptions'] : ['class' => 'btn btn-warning']), ['style' => 'margin-left:5px;']));
        }
        $this->parts['{label}'] = Html::tag('label', '&nbsp;', $this->labelOptions);
        $this->parts['{input}'] = $inputString;

        return $this;
    }

    /**
     * Renders a text input.
     * This method will generate the "name" and "value" tag attributes automatically for the model
     * attribute unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered
     *                       as
     *                       the attributes of the resulting tag. The values will be HTML-encoded
     *                       using
     *                       [[Html::encode()]]. If you set a custom `id` for the input element,
     *                       you may need to adjust the [[$selectors]] accordingly.
     * @return static the field object itself
     */
    public function qiniuUploadInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $inputID = Html::getInputId($this->model, $this->attribute);
        Html::addCssClass($options, ["qiniu_{$inputID}"]);
        $inputString = Html::beginTag("div", ['id' => 'container']);
        /**
         * input
         */
        $inputString .= Html::activeTextInput($this->model, $this->attribute, $options);
        /**
         * button
         */
        $inputString .= Html::button((isset($options['btnLabel']) ? $options['btnLabel'] : '上传'), [
            // 'class'    => "upload_{$inputID}",
            'class' => "upload_{$inputID}" . ' btn btn-primary btn-minier middle',
            'id'    => "upload_{$inputID}",
            'style' => 'margin-left:5px;',
        ]);
        $inputString .= Html::tag("div",'',['id'=>'fsUploadProgress','class'=>'col-xs-9','style'=>'padding:5px 0']);
        $inputString .= Html::endTag('div');

        $this->parts['{input}'] = $inputString;

        Kindeditor::createQiniuUploadById("upload_{$inputID}", $options['uptoken'], $options['domain'], $options['filename']);

        return $this;
    }
}
