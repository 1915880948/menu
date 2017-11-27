<?php
/**
 * @category Kindeditor
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  11/30/14 15:35
 * @since
 */
namespace common\assets\editor;

use app\web\admin\components\assets\QiniuUploadAsset;
use Yii;
use yii\base\Object;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Class Kindeditor
 * @package common\extension
 */
class Kindeditor extends Object
{
    public static $initUpload = false;
    public static $initEditor = false;
    public static $csrfCookieParam = '_csrfCookie';

    static public function createEditor($id, $type = 'simple')
    {
        $options = [
            'default' => ['allowImageUpload' => true,],
            'simple'  => [
                'allowFileManager'      => false,
                'resizeType'            => 1,
                'allowPreviewEmoticons' => false,
                'allowImageUpload'      => true,
                'uploadJson'            => Url::toRoute(['site/upload']),
                'items'                 => [
                    'fontname',
                    'fontsize',
                    '|',
                    'forecolor',
                    'hilitecolor',
                    'bold',
                    'italic',
                    'underline',
                    'removeformat',
                    '|',
                    'justifyleft',
                    'justifycenter',
                    'justifyright',
                    'insertorderedlist',
                    'insertunorderedlist',
                    '|',
                    'emoticons',
                    'link',
                ],
            ],
            'image'   => [
                'allowFileManager'      => false,
                'resizeType'            => 1,
                'allowPreviewEmoticons' => false,
                'allowImageUpload'      => true,
                'uploadJson'            => Url::toRoute(['site/upload', 'full' => 1]),
                'items'                 => [
                    'fontname',
                    'fontsize',
                    '|',
                    'forecolor',
                    'hilitecolor',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'removeformat',
                    'hr',
                    '|',
                    'justifyleft',
                    'justifycenter',
                    'justifyright',
                    'insertorderedlist',
                    'insertunorderedlist',
                    '|',
                    'emoticons',
                    'image',
                    'link',
                    '|',
                    'source',
                    'fullscreen',
                ],
            ],
        ];
        if(!isset($options[$type])){
            $type = 'simple';
        }
        if(isset($options[$type]['allowImageUpload']) && $options[$type]['allowImageUpload'] == true){
            $uploadParams[Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
            $uploadParams[Yii::$app->session->name] = Yii::$app->session->id;
            if(Yii::$app->request->enableCsrfCookie){
                $uploadParams[self::$csrfCookieParam] = $_COOKIE[Yii::$app->request->csrfParam];
            }
            $options[$type]['extraFileUploadParams'] = $uploadParams;
        }
        $options[$type]['afterBlur'] = new JsExpression('function(){this.sync();}');
        $option = Json::encode($options[$type]);
        $editor = <<<EOT
        KindEditor.ready(function(K){
            var editor = K.create('{$id}', $option);
        });
EOT;
        Yii::$app->getView()
                 ->registerJs($editor, View::POS_END);
    }

    static public function createImageUploadById($id, $retid, $uploadurl)
    {
        $defaultOpts = [
            'uploadJson'       => $uploadurl,
            'allowFileManager' => true,
        ];
        $uploadParams[Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
        $uploadParams[Yii::$app->session->name] = Yii::$app->session->id;
        if(Yii::$app->request->enableCsrfCookie){
            $uploadParams[self::$csrfCookieParam] = $_COOKIE[Yii::$app->request->csrfParam];
        }
        $defaultOpts['extraFileUploadParams'] = $uploadParams;
        $optsdata = json_encode($defaultOpts);
        $initUploadString = <<<EOT
KindEditor.ready(function(K) {
   var editor = K.editor({$optsdata});
    K('{$id}').click(function() {
        editor.loadPlugin('image', function() {
            editor.plugin.imageDialog({
                showRemote : false,
                //imageUrl : '{$uploadurl}',
                clickFn : function(url, title, width, height, border, align) {
                    K('{$retid}').val(url);
                    editor.hideDialog();
                }
            });
        });
    });
});
EOT;
        \Yii::$app->getView()
                  ->registerJs($initUploadString, View::POS_END);
    }

    static public function createFileUploadById($id, $retid, $uploadurl)
    {
        $defaultOpts = [
            'uploadJson'       => $uploadurl,
            'allowFileManager' => false,
        ];
        $uploadParams[Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
        $uploadParams[Yii::$app->session->name] = Yii::$app->session->id;
        if(Yii::$app->request->enableCsrfCookie){
            $uploadParams[self::$csrfCookieParam] = $_COOKIE[Yii::$app->request->csrfParam];
        }
        $defaultOpts['extraFileUploadParams'] = $uploadParams;
        $optsdata = json_encode($defaultOpts);
        $initUploadString = <<<EOT
KindEditor.ready(function(K) {
   var editor = K.editor({$optsdata});
    K('{$id}').click(function() {
        editor.loadPlugin('insertfile', function() {
            editor.plugin.fileDialog({
                showRemote : false,
                //fileUrl : '{$uploadurl}',
                clickFn : function(url, title, width, height, border, align) {
                    K('{$retid}').val(url);
                    editor.hideDialog();
                }
            });
        });
    });
});
EOT;
        \Yii::$app->getView()
                  ->registerJs($initUploadString, View::POS_END);
    }

    static public function createBtnUploadById($id, $retId, $uploadURL)
    {
        $uploadString = <<<EOT
KindEditor.ready(function(K) {
    var uploadbutton = K.uploadbutton({
        button : K('{$id}')[0],
        fieldName : 'imgFile',
        url : '{$uploadURL}',
        afterUpload : function(data) {
            if (data.error === 0) {
                var url = K.formatUrl(data.url, 'absolute');
                K('{$retId}').val(url);
            } else {
                alert(data.message);
            }
        },
        afterError : function(str) {
            alert(str);
        }
    });
    uploadbutton.fileBox.change(function(e) {
        uploadbutton.submit();
    });
});
EOT;
        \Yii::$app->getView()
                  ->registerJs($uploadString, View::POS_END);
    }

    static public function createMultiImageUploadById($id, $retId, $uploadURL)
    {
        $defaultOpts = [
            'uploadJson'       => $uploadURL,
            'allowFileManager' => true,
        ];
        $uploadParams[Yii::$app->request->csrfParam] = Yii::$app->request->getCsrfToken();
        $uploadParams[Yii::$app->session->name] = Yii::$app->session->id;
        if(Yii::$app->request->enableCsrfCookie){
            $uploadParams[self::$csrfCookieParam] = $_COOKIE[Yii::$app->request->csrfParam];
        }
        $defaultOpts['extraFileUploadParams'] = $uploadParams;
        $optsdata = json_encode($defaultOpts);
        $uploadString = <<<EOT
KindEditor.ready(function(K) {
    var editor = K.editor({$optsdata});
    K('{$id}}').click(function() {
        editor.loadPlugin('multiimage', function() {
            editor.plugin.multiImageDialog({
                clickFn : function(urlList) {
                    var div = K('{$retId}');
                    div.html('');
                    K.each(urlList, function(i, data) {
                        div.append('<img src="' + data.url + '" style="width:150px;height:150px;">');
                    });
                    editor.hideDialog();
                }
            });
        });
    });
});
EOT;
        \Yii::$app->getView()
                  ->registerJs($uploadString, View::POS_END);
    }

    static public function createQiniuUploadById($id, $uploadToken, $domain,$filename = '')
    {
        $input = str_replace('upload_','',$id);
        QiniuUploadAsset::register(Yii::$app->getView());
        $moxie = Yii::getAlias('@webstatic/plupload/Moxie.swf');
        $domain = rtrim($domain,"/");
        $initUploadString = <<<EOT
var tokenStr =  '{$uploadToken}';     
var filename = '{$filename}';
var uploader = Qiniu.uploader({
    runtimes: 'html5,flash,html4',    //上传模式,依次退化
    browse_button: '{$id}',       //上传选择的点选按钮，**必需**
    // uptoken_url: '/token',            //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
    uptoken:tokenStr,  //若未指定uptoken_url,则必须指定 uptoken ,uptoken由其他程序生成
    unique_names: true, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
    // save_key: true,   // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
    domain: '{$domain}',   //bucket 域名，下载资源时用到，**必需**
    get_new_uptoken: false,  //设置上传文件的时候是否每次都重新获取新的token
    // container: 'container',           //上传区域DOM ID，默认是browser_button的父元素，
    max_file_size: '1000mb',           //最大文件体积限制
    flash_swf_url: '{$moxie}',  //引入flash,相对路径
    max_retries: 10,                   //上传失败最大重试次数
    dragdrop: false,                   //开启可拖曳上传
    // drop_element: 'container',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
    chunk_size: '4mb',                //分块上传时，每片的体积
    multi_selection: !(mOxie.Env.OS.toLowerCase() === "ios"),
    auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
    log_level: 5,
    multi_selection: false,
    filters: {
        mime_types: [ //只允许上传文件格式
            {title: "mp4 files", extensions: "mp4,flv"}
        ]
    },
    init: {
        'FilesAdded': function (up, files) {
            $('#{$input}').val('');
        },
        'BeforeUpload': function (up, file) {
        },
        'UploadProgress': function (up, file) {
           $('#fsUploadProgress').html('<div class="progress" data-percent="'+file.percent+'%"><div class="progress-bar" style="width:'+file.percent+'%;"></div></div>');
        },
        'UploadComplete': function () {
        },
        'FileUploaded': function (up, file, info) {
            var res = $.parseJSON(info);
            var url;
            $('#{$input}').val(res.key);
            if (res.url) {
                $('#{$input}').val(res.url);
            } else {
                var domain = up.getOption('domain');
                if(filename!=""){
                    url = domain +'/' + encodeURI(filename);
                }else{
                    url = domain +'/' + encodeURI(res.key);
                }
                $('#{$input}').val(url);
                $('#fsUploadProgress').html('上传已完成');
            }            
        },
        'Error': function (up, err, errTip) {}
    }
});
EOT;
        \Yii::$app->getView()
                  ->registerJs($initUploadString, View::POS_READY);
    }

    public function init()
    {
    }
}
