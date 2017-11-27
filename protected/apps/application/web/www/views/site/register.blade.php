@extends('layouts.main');

@section('content')
  <div class="g-container g-bgimg login-wrap">
    <div class="reg-form">
      <h1 class="logo"><a href="/"><img src="{{Yii::getAlias('@web/static/images/logo.png')}}" alt=""></a></h1>
      <form id="register-form" method="post">
        <div class="ui-cells">
          <p class="tips">手机号（必填）<em>*</em></p>
          <input class="ui-input js_tooltips" name="mobile" id="mobile" type="text">
        </div>
        <div class="ui-cells">
          <p class="tips">输入验证码</p>
          <input class="ui-input js_tooltips" name="vcode" id="vcode" type="text"> <a href="javascript:;" class="ui-btn-vcode">点击获取验证码</a>
        </div>
        <div class="ui-cells">
          <p class="tips">医师姓名（必填）<em>*</em></p>
          <input class="ui-input js_tooltips" name="nickname" id="nickname" type="text">
        </div>
        <div class="ui-cells ui-cells-select">
          <p class="tips">省份（必填）<em>*</em></p>
          <input class="ui-input js_tooltips weui_input" name="district" id="city-picker" type="text">
        </div>
        <div class="ui-cells">
          <p class="tips">所在医疗机构（必填）<em>*</em></p>
          <input class="ui-input js_tooltips" name="hospital" id="hospital" type="text" >
        </div>
        <div class="ui-cells">
          <p class="tips">医院级别（必填）<em>*</em></p>
          <input class="ui-input js_tooltips weui_input" name="hospital_level" id="hospital_level" type="text" >
        </div>
        <div class="ui-cells">
          <p class="tips">科室（必填）<em>*</em></p>
          <input class="ui-input js_tooltips weui_input" name="department" id="department-picker" type="text" >
            <?php
            // echo Html::dropDownList('department', null, array_combine(YxzApi::$departments, YxzApi::$departments), [
            //     'class'  => 'ui-input js_tooltips',
            //     'prompt' => ''
            // ]);
            ?>
        </div>
        <div class="ui-cells">
          <p class="tips">职业（必填）<em>*</em></p>
          <input class="ui-input js_tooltips weui_input" name="type" id="type-picker" type="text" >
        </div>
        <div class="ui-cells ui-cells-select">
          <p class="tips">职称（必填）<em>*</em></p>
          <input class="ui-input js_tooltips weui_input" name="jobtitle" id="jobtitle-picker" type="text">
        </div>
      </form>
      <a class="ui-btn ui-btn-red ui-btn-register" href="javascript:;">完成注册</a>
    </div>
    <div class="support">技术支持：《医学界》传媒</div>
  </div>
@stop
<?php
use application\common\api\YxzApi;use yii\bootstrap\Html;use yii\helpers\Json;use yii\helpers\Url;

$vcodeUrl = Url::to(['site/sms']);
$deparments = Json::encode(YxzApi::$departments);
$types = [];
foreach(YxzApi::$types as $k => $value){
    $types[] = [
        'title' => $value,
        'value' => $k
    ];
}
$jobtypes = Json::encode($types);
$jobtitles = Json::encode(YxzApi::$jobtitles);
$hosLevels = Json::encode(YxzApi::$hospitalLevel);
$selfurl = Url::to([$selfurl], true);
?>
@section('foot-script')
  {{!! Html::jsFile('@web/static/js/weui/city-picker.min.js') !!}}
  <script>
      var vCodeUrl = '{{$vcodeUrl}}';
      var deparments = {!! $deparments !!};
      var jobtypes = {!!$jobtypes!!};
      var jobtitles = {!!$jobtitles!!};
      var hoslevels = {!!$hosLevels!!};
      var COUNT_DOWN_TIME = 120;
      // var currentUrl = '{$selfurl}';
      $(function () {
          $('#gender-picker').select({
              title: '请选择性别',
              items: [
                  {
                      title: '男',
                      value: 1
                  },
                  {
                      title: '女',
                      value: 2
                  },
              ]
          });
          $('#department-picker').select({
              title: '请选择科室',
              items: deparments
          });
          $('#jobtitle-picker').select({
              title: '请选择职称',
              items: jobtitles
          });
          $('#hospital_level').select({
              title: '请选择医院级别',
              items: hoslevels
          });
          $('#type-picker').select({
              title: '请选择职业',
              items: jobtypes
          });
          $('#city-picker').cityPicker({
              title: '请选择所在地区',
              showDistrict: false
          });
          $('.weui_input').on('input propertychange', function () {
              $(this).siblings('p').hide();
          }).on('change', function () {
              // console.log('bb' + $(this).val()+$(this).siblings('p'));
              $(this).siblings('p').hide();
          });
          var vcodeBtnClicked = false;
          $('.ui-btn-vcode').on('click', function () {
              var self = $(this);
              if ($(this).attr('disabled')) {
                  return;
              }
              var mobile = $('#mobile').val();
              var re = new RegExp(/^1[\d]{10}$/);
              if (mobile == '' || !re.test(mobile)) {
                  $.alert('对不起，手机号码不正确');
                  return;
              }
              var times = COUNT_DOWN_TIME;
              self.attr('disabled', true);
              $.post(vCodeUrl, {mobile: mobile, _csrf: $('meta[name=\"csrf-token\"]').attr('content')}, function (result) {
                  console.log(result);
                  $.alert(result.info);
              }, 'json');
              var c = setInterval(function () {
                  if (times <= 0) {
                      self.text('重新获取');
                      self.attr('disabled', false);
                      clearInterval(c);
                      return;
                  }
                  self.text(times + '秒');
                  times--;
              }, 1000);
          });
          $('.ui-btn-register').on('click', function () {
              var self = $(this);
              var mobile = $('#mobile').val();
              var vcode = $('#vcode').val();
              if (mobile == '') {
                  $.alert('请输入手机号码');
                  return;
              }
              if (vcode == '') {
                  $.alert('请输入验证码');
                  return;
              }
              var lang = {
                  mobile: '手机号码',
                  vcode: '验证码',
                  realname: '医师姓名',
                  gender: '性别',
                  city: '所在城市',
                  hospital: '所在医疗机构',
                  department: '科室',
                  type: '职业',
                  hospital_level: '医院级别',
                  jobtitle: '职称'
              };
              var postdata = {
                  _csrf: $('meta[name=\"csrf-token\"]').attr('content'),
                  mobile: mobile,
                  vcode: vcode,
                  realname: $('#nickname').val(),
                  gender: 1,
                  city: $('#city-picker').data('code'),
                  hospital: $('#hospital').val(),
                  department: $('#department-picker').val(),
                  type: $('#type-picker').data('values'),
                  hospital_level: $('#hospital_level').val(),
                  jobtitle: $('#jobtitle-picker').val()
              };
              // console.log(postdata);
              // return ;
              $.each(postdata, function (k, v) {
                  // console.log(v);
                  if ($.trim(v) == '' || (typeof v == 'undefined')) {
                      $.alert(lang[k] + '不能为空');
                      return;
                  }
              });
              $.showLoading('提交注册中....');
              self.attr('disabled', true);
              $.post(CURRENT_URL, postdata, function (result) {
                  self.attr('disabled', false);
                  console.log(result);
                  $.hideLoading();
                  if (0 == result.status) {
                      $.alert(result.info);
                      return;
                  }
                  location.href = SITE_URL;
              }, 'json');
              return;
          });
      });
  </script>
@stop
