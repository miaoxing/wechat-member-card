<?php

use Miaoxing\WechatCard\Service\WechatCardRecord;

$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-default" href="<?= $url('admin/wechat-member-cards') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form class="js-card-form form-horizontal" method="post" role="form">
      <fieldset>
        <legend class="grey bigger-130">基本信息</legend>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="brand-name">
            <span class="text-warning">*</span>
            商户名称
          </label>

          <div class="col-lg-4">
            <input type="text" class="form-control" name="brand_name" id="brand-name" data-rule-required="true">
          </div>
          <label class="col-lg-6 help-text" for="brand-name">提供服务的商户名</label>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="logo-url">
            <span class="text-warning">*</span>
            商家Logo
          </label>

          <div class="js-upload-container col-lg-4">
            <input type="file" class="js-logo-file"/>
            <input type="hidden" id="logo-url" name="logo_url" class="js-logo-url js-image-url"/>
          </div>

          <label class="col-lg-6 help-text">
            上传的图片限制文件大小限制 1MB，推荐像素为 300*300，支持 JPG格式。
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="cover-type">
            卡券封面
          </label>

          <div class="col-lg-4">
            <label class="radio-inline">
              <input type="radio" class="js-cover-type js-toggle-display" name="cover_type" value="0" checked="checked"
                data-value=":checked" data-target=".js-cover-type-image" data-reverse-target=".js-cover-type-color">图片
            </label>
            <label class="radio-inline">
              <input type="radio" class="js-cover-type js-toggle-display" name="cover_type" value="1" data-value=":checked"
                data-target=".js-cover-type-color" data-reverse-target=".js-cover-type-image"> 颜色
            </label>

            <div class="js-cover-type-image js-upload-container m-t">
              <p class="upload_tips">请参照 <a
                href="https://mp.weixin.qq.com/cgi-bin/readtemplate?t=cardticket/card_cover_tmpl&type=info&lang=zh_CN"
                target="_blank">微信图片规范</a> 上传</p>
              <input type="file" class="js-background-pic-file"/>
              <input type="hidden" name="background_pic_url" class="js-background-pic-url js-image-url"/>
            </div>

            <div class="js-cover-type-color m-t display-none">
              <select name="color" id="color" class="js-color form-control">
                <?php foreach (wei()->wechatCard->getColors() as $color => $wechatColor) : ?>
                  <option value="<?= $color ?>" data-color="<?= $color ?>"><?= $color ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="title">
            <span class="text-warning">*</span>
            会员卡标题
          </label>

          <div class="col-lg-4">
            <input type="text" class="form-control" name="title" id="title" data-rule-required="true">
          </div>
          <label class="col-lg-6 help-text" for="title">建议会员卡标题包含商户名或服务内容，如腾讯会员黄钻尊享卡</label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="date-info-type">
            有效期
          </label>

          <div class="col-lg-4" rel="date_info">
            <div class="radio p-t-0">
              <label>
                <input type="radio" class="js-date-info-type" name="date_info[type]" id="date-info-type" rel="type" value="1">
                固定日期
              </label>
              <input type="text" class="js-date-range t-11 text-center" placeholder="请选择日期范围">
              <input type="hidden" class="js-start-date" name="date_info[begin_time]" rel="begin_time">
              <input type="hidden" class="js-end-date" name="date_info[end_time]" rel="end_time">
            </div>
            <div class="radio">
              <label>
                <input type="radio" class="js-date-info-type" name="date_info[type]" id="date-info-type-2" rel="type" value="2" checked>
                永久有效
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="time-limit-type">
            可用时段
          </label>

          <div class="col-lg-6">
            <div class="radio">
              <label>
                <input type="radio" class="js-toggle-display" name="time_limit_type" id="time-limit-type" value="0"
                  data-value=":checked" data-reverse-target=".js-time-limit-type-part"
                  checked>
                全部时段
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" class="js-toggle-display" name="time_limit_type" id="time-limit-type-2" value="1" data-value=":checked" data-target=".js-time-limit-type-part">
                部分时段
              </label>
            </div>

            <div class="js-time-limit-type-part m-t display-none">
              <label class="pull-left control-label">日期：</label>
              <div>
                <div class="checkbox-inline">
                  <label>
                    <input type="checkbox" name="time_limit[days][]" value="MONDAY">
                    周一
                  </label>
                </div>
                <div class="checkbox-inline">
                  <label>
                    <input type="checkbox" name="time_limit[days][]" value="TUESDAY">
                    周二
                  </label>
                </div>
                <div class="checkbox-inline">
                  <label>
                    <input type="checkbox" name="time_limit[days][]" value="WEDNESDAY">
                    周三
                  </label>
                </div>
                <div class="checkbox-inline">
                  <label>
                    <input type="checkbox" name="time_limit[days][]" value="THURSDAY">
                    周四
                  </label>
                </div>
                <div class="checkbox-inline">
                  <label>
                    <input type="checkbox" name="time_limit[days][]" value="FRIDAY">
                    周五
                  </label>
                </div>
                <div class="checkbox-inline">
                  <label>
                    <input type="checkbox" name="time_limit[days][]" value="SATURDAY">
                    周六
                  </label>
                </div>
                <div class="checkbox-inline">
                  <label>
                    <input type="checkbox" name="time_limit[days][]" value="SUNDAY">
                    周日
                  </label>
                </div>
              </div>

              <div class="m-t">
                <label>时间：</label>
                <input type="text" class="text-center t-2" name="time_limit[times][1][begin]">
                至
                <input type="text" class="text-center t-2" name="time_limit[times][1][end]">
                &nbsp;&nbsp;
                <input type="text" class="text-center t-2" name="time_limit[times][2][begin]">
                至
                <input type="text" class="text-center t-2" name="time_limit[times][2][end]">

                <div class="m-t m-l-lg help-text">请使用24小时制输入时间，格式如11:00至14:30，留空表示全天。</div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="supply-score">
            会员卡优惠
          </label>

          <div class="col-lg-4">
            <div class="checkbox-inline">
              <label>
                <input name="supply_score" type="hidden" value="0" data-ignore>
                <input class="js-supply-score js-toggle-display" id="supply-score" name="supply_score" type="checkbox"
                  value="1" data-target=".js-supply-score-groups" data-value=":checked">
                积分优惠
                <span class="js-tooltips help-button help-button-xs"
                  title="积分有助于吸引用户成为忠实会员">?</span>
              </label>
            </div>
            <div class="checkbox-inline">
              <label>
                <input name="supply_discount" type="hidden" value="0" data-ignore="true">
                <input class="js-supply-discount js-toggle-display" id="supply-discount" name="supply_discount"
                  type="checkbox" value="1" data-target=".js-supply-discount-groups" data-value=":checked">
                折扣优惠
                <span class="js-tooltips help-button help-button-xs"
                  title="折扣优惠能够鼓励用户到店消费">?</span>
              </label>
            </div>
          </div>
        </div>

        <div class="js-supply-score-groups display-none">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="cost-money-unit">
              <span class="text-warning">*</span>
              消费送积分
            </label>

            <div class="col-lg-4">
              每消费
              <input type="text" id="cost-money-unit" class="t-3 text-center" name="bonus_rule[cost_money_unit]"
                data-rule-required="true" data-rule-number="true" data-rule-min="0">
              元，赠送
              <input type="text" class="t-3 text-center" name="bonus_rule[increase_bonus]" data-rule-required="true"
                data-rule-number="true" data-rule-min="0">
              积分
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="max-increase-bonus">
              单次上限
            </label>

            <div class="col-lg-4">
              <input type="text" id="max-increase-bonus" class="t-3 text-center" name="bonus_rule[max_increase_bonus]" data-rule-number="true" data-rule-min="0">
              积分
            </div>

            <label class="help-text" for="max-increase-bonus">
              请设置单次增加积分的上限，不填写表示无限制
            </label>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="init-increase-bonus">
              激活送积分
            </label>

            <div class="col-lg-4">
              <input type="text" id="init-increase-bonus" class="t-3 text-center" name="bonus_rule[init_increase_bonus]" data-rule-number="true" data-rule-min="0">
              积分
            </div>

            <label class="help-text" for="init-increase-bonus">
              请设置激活会员卡赠送的积分，不填写表示不赠送
            </label>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="cost-bonus-unit">
              <span class="text-warning">*</span>
              积分抵扣
            </label>

            <div class="col-lg-4">
              每使用
              <input type="text" id="cost-bonus-unit" class="t-3 text-center" name="bonus_rule[cost_bonus_unit]" data-rule-required="true" data-rule-number="true" data-rule-min="0">
              积分，抵扣
              <input type="text" class="t-3 text-center" name="bonus_rule[reduce_money]" data-rule-required="true" data-rule-number="true" data-rule-min="0">
              元
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="least-money-to-use-bonus">
              抵扣条件
            </label>

            <div class="col-lg-4">
              订单满
              <input type="text" id="least-money-to-use-bonus" class="t-3 text-center" name="bonus_rule[least_money_to_use_bonus]" data-rule-number="true" data-rule-min="0">
              元可用，单笔上限
              <input type="text" class="t-3 text-center" name="bonus_rule[max_reduce_bonus]" data-rule-number="true" data-rule-min="0">
              积分
            </div>
          </div>
        </div>

        <div class="js-supply-discount-groups display-none">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="discount">
              享受折扣
            </label>

            <div class="col-lg-4">
              <div class="input-group">
                <input type="text" class="form-control" name="discount" id="discount">
                <span class="input-group-addon">折</span>
              </div>
            </div>

            <label class="control-label help-text">请填写1-9.9之间的数字，精确到小数点后1位</label>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">会员卡详情</legend>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="detail">
            <span class="text-warning">*</span>
            特权说明
          </label>

          <div class="col-lg-4">
            <textarea class="form-control" name="detail" id="detail" rows="4" data-rule-required="true"></textarea>
          </div>

          <label class="col-lg-6 help-text" for="detail">
            注：1、上文设置中，如已经填写“积分优惠”“折扣优惠”的内容，将会自动在用户会员卡详情展示，无需重复填写。2、建议填写其他特权，举例：100积分可兑换精美礼品；会员日可享受折上折优惠等
          </label>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="description">
            使用须知
          </label>

          <div class="col-lg-4">
            <textarea class="form-control" name="description" id="description" rows="4"></textarea>
          </div>

          <label class="col-lg-6 help-text" for="description">
            注：1、上文设置中，如已经填写“积分优惠”“折扣优惠”的内容，将会自动在用户会员卡详情展示，无需重复填写。2、建议填写其他注意事项，举例：积分不支持兑换现金
          </label>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="description">
            图文介绍
          </label>

          <div class="col-lg-4">
            <p class="help-text">图片建议尺寸：900像素 * 500像素，大小不超过2M。<br>
              至少上传1组图文，最多输入5000字</p>
            <div class="js-article-list">

            </div>
            <hr class="m-t-0">
            <a href="javascript:;" class="js-add-article">添加图文</a>
          </div>

          <label class="col-lg-6 help-text" for="description">
            图文内容建议上传商品、服务、环境等优质图片，并辅之以简单描述。
          </label>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">
          会员信息类目
        </legend>

        <p>会员卡激活后呈现的信息类目，目前支持积分、余额、等级、优惠券、里程、印花、成就、折扣等类型，最多选择三项。</p>

        <div class="form-group">
          <label class="col-lg-2 control-label"></label>
          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input name="supply_bonus" type="hidden" value="0" data-ignore>
                <input class="js-field js-supply-bonus js-toggle-display" id="supply-bonus" name="supply_bonus"
                  type="checkbox" value="1" data-target=".js-supply-bonus-groups" data-value=":checked">
                积分
              </label>
            </div>
          </div>
        </div>

        <div class="js-supply-bonus-groups display-none">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="bonus-link-to">
              查看积分详情URL
            </label>

            <div class="col-lg-4">
              <p class="js-link-to form-control-static" data-name="bonus_link_to" id="bonus-link-to"></p>
            </div>
            <label for="bonus-url" class="col-lg-6 help-text">仅适用于积分无法通过激活接口同步的情况下使用该字段。</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="bonus-rules">
              积分规则
            </label>

            <div class="col-lg-4">
              <textarea type="text" class="form-control" name="bonus_rules" id="bonus-rules"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="bonus-cleared">
              积分清零规则
            </label>

            <div class="col-lg-4">
              <textarea type="text" class="form-control" name="bonus_cleared" id="bonus-cleared"></textarea>
            </div>
          </div>
          <hr>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label"></label>
          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input name="supply_balance" type="hidden" value="0" data-ignore>
                <input class="js-field js-supply-balance js-toggle-display" id="supply-balance" name="supply_balance"
                  type="checkbox" value="1" data-target=".js-supply-balance-groups" data-value=":checked">
                余额（支持储值）
              </label>
            </div>
          </div>
        </div>

        <div class="js-supply-balance-groups display-none">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="balance-rules">
              储值说明
            </label>

            <div class="col-lg-4">
              <textarea class="form-control" name="balance_rules" id="balance-rules"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="balance-link-to">
              查看余额详情URL
            </label>

            <div class="col-lg-4">
              <p class="js-link-to form-control-static" data-name="balance_link_to" id="balance-link-to"></p>
            </div>
            <label for="balance-url" class="col-lg-6 help-text">仅适用于余额无法通过激活接口同步的情况下使用该字段。</label>
          </div>
        </div>

        <?php for ($i = 1; $i <= 3; ++$i) : ?>
        <div class="form-group">
          <label class="col-lg-2 control-label"></label>
          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input name="custom_field<?= $i ?>[enable]" type="hidden" value="0" data-ignore>
                <input class="js-field js-toggle-display js-custom-field<?= $i ?>-enable" id="custom-field<?= $i ?>-enable" name="custom_field<?= $i ?>[enable]"
                  type="checkbox" value="1" data-target=".js-custom-field<?= $i ?>-enable-groups" data-value=":checked">
                自定义信息类目<?= $i ?>
              </label>
            </div>
          </div>
        </div>

        <div class="js-custom-field<?= $i ?>-enable-groups display-none">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-field<?= $i ?>-name-type">
              类名名称
            </label>

            <div class="col-lg-4">
              <select class="js-toggle-display form-control" id="custom-field<?= $i ?>-name-type" name="custom_field<?= $i ?>[name_type]"
                data-value="FIELD_NAME_TYPE_CUSTOM" data-target=".js-custom-field<?= $i ?>-name-group">
                <?php foreach (wei()->wechatCard->getFieldNameTypes() as $value => $name) : ?>
                  <option value="<?= $value ?>"><?= $name ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <label for="custom-field<?= $i ?>-name-type" class="col-lg-6 help-text">
              当这类类目的值更改时，可以选择触发系统模板消息通知用户。
            </label>
          </div>

          <div class="js-custom-field<?= $i ?>-name-group js-groups form-group display-none">
            <label class="col-lg-2 control-label" for="custom-field1-name">
              自定义名称
            </label>

            <div class="col-lg-4">
              <input class="form-control" id="custom-field<?= $i ?>-name" type="text" name="custom_field<?= $i ?>[name]">
            </div>
            <label for="custom-field<?= $i ?>-name" class="col-lg-6 help-text">
              自定义类目的值更改时，不会触发系统模板消息通知用户。
            </label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-field<?= $i ?>-url">
              点击类目跳转外链URL
            </label>

            <div class="col-lg-4">
              <p class="js-link-to form-control-static" id="custom-field<?= $i ?>-url" data-name="custom_field<?= $i ?>[url]"></p>
            </div>
          </div>
        </div>
        <?php endfor ?>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">使用设置</legend>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="activate-type">激活方式</label>
          <div class="col-lg-6">
            <div class="radio">
              <label>
                <input class="js-toggle-display" id="activate-type" type="radio" name="activate_type" value="0" checked data-value=":checked" data-reverse-target=".js-activate-link-to">
                自动激活
              </label>
              <label class="block text-muted">
                用户领取卡片之后，系统自动帮用户激活，积分、储值等自定义显示信息均为0。详见微信文档
                <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025283" target="_blank">#6.3</a>
              </label>
            </div>
            <!-- 暂不支持 -->
            <div class="radio hide">
              <label>
                <input class="js-toggle-display" type="radio" name="activate_type" value="1" data-value=":checked" data-reverse-target=".js-activate-link-to">
                一键激活
              </label>
              <label class="block text-muted">
                一键激活是微信提供的快速便捷的激活方案。详见微信文档
                <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025283" target="_blank">#6.2</a>
              </label>
            </div>
            <div class="radio">
              <label>
                <input class="js-toggle-display" type="radio" name="activate_type" value="2" data-value=":checked" data-target=".js-activate-link-to">
                接口激活
              </label>
              <label class="block text-muted">
                接口激活通常需要开发者开发用户填写资料的网页。详见微信文档
                <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025283" target="_blank">#6.1</a>
                <p class="js-link-to js-activate-link-to form-control-static" id="activate-link-to" data-name="activate_link_to"></p>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="can_share">

          </label>

          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input type="hidden" value="0" name="can_share" data-ignore>
                <input type="checkbox" value="1" name="can_share" id="can_share">
                用户可以分享领券链接
              </label>
            </div>
            <div class="checkbox">
              <label>
                <input type="hidden" value="0" name="auto_activate">
                <input type="checkbox" value="1" name="auto_activate" id="auto_activate">
                用户需激活后才能使用
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="can-give-friend">
            激活信息
          </label>

          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input type="hidden" value="0" name="can_give_friend">
                <input type="checkbox" value="1" name="can_give_friend" id="can-give-friend">
                允许用户自主修改以上信息
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="code-type-0">
            销券方式
          </label>

          <div class="col-lg-6">
            <div class="radio">
              <label>
                <input type="radio" value="0" checked name="code_type" id="code-type-0">
                不显示code和条形码类型
              </label>
              <label class="block text-muted">
                适用于线上核销
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="1" name="code_type" id="code-type-1">
                仅卡号
              </label>
              <label class="block text-muted">
                只显示卡券号，验证后可进行销券
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="3" name="code_type" id="code-type-3">
                二维码
              </label>
              <label class="block text-muted">
                包含卡券信息的二维码和卡号，扫描后可进行销券
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="2" name="code_type" id="code-type-2">
                条形码
              </label>
              <label class="block text-muted">
                包含卡券信息的条形码和卡号，扫描后可进行销券
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="4" name="code_type" id="code-type-4">
                二维码，不显示卡号
              </label>
              <label class="block text-muted">
                只显示卡券信息的二维码，扫描后可进行销券
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="5" name="code_type" id="code-type-5">
                条形码，不显示卡号
              </label>
              <label class="block text-muted">
                只显示卡券信息的条形码，扫描后可进行销券
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="notice">
            <span class="text-warning">*</span>
            操作提示
          </label>

          <div class="col-lg-4">
            <input type="text" class="form-control" name="notice" id="notice">
          </div>
          <label for="notice" class="col-lg-6 help-text">建议引导用户到店出示卡券，由店员完成核销操作</label>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">服务信息</legend>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="shop-type">
            适用门店
          </label>

          <div class="col-lg-6 shop-radios">
            <p class="help-text hide">"适用门店"方便帮助用户到店消费。如有门店，请仔细配置。可在"微官网"-"门店管理"管理门店信息。</p>

            <div class="radio">
              <label>
                <input type="radio" value="1" checked name="shop_type" class="js-shop-type">
                全部门店适用
              </label>
            </div>

            <!-- 暂未实现 -->
            <div class="radio hide">
              <label>
                <input type="radio" value="2" name="shop_type" id="shop-type" class="js-shop-type">
                指定门店适用
              </label>

              <div class="js-shop-type-1">
                <table class="selected-shops-table table table-bordered">
                  <thead>
                  <tr>
                    <th>门店名称</th>
                    <th>地址</th>
                    <th class="text-center">操作</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <label class="block">
                  <a href="#" data-toggle="modal" data-target="#shops-modal">添加适用门店</a>
                </label>
                <input type="hidden" name="shopIds" id="shopIds">
                <input type="hidden" name="wechatLocationIds" id="wechatLocationIds">
              </div>
            </div>

            <div class="radio">
              <label>
                <input type="radio" value="0" name="shop_type" class="js-shop-type">
                无指定门店
              </label>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">自定义链接</legend>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="center-title">
            顶部居中的按钮
          </label>

          <div class="col-lg-4">
            <input type="text" class="form-control" name="center_title" id="center-title">
          </div>
          <label for="centerTitle" class="col-lg-6 help-text">仅在卡券状态正常(可以核销)时显示</label>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="center-sub-title">
            按钮下方的提示语
          </label>

          <div class="col-lg-4">
            <input type="text" class="form-control" name="center_sub_title" id="center-sub-title">
          </div>

        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="center-link-to">
            顶部居中的链接
          </label>

          <div class="col-lg-4">
            <p class="js-link-to form-control-static" id="center-link-to" data-name="center_link_to"></p>
          </div>
        </div>

      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">
          商户介绍
          <small>(选填)</small>
          <a class="btn btn-link btn-sm" type="button" data-toggle="collapse" href="#merchant-intro"
            aria-expanded="false" aria-controls="merchant-intro" data-hide-text="收起">
            展开
          </a>
        </legend>

        <div class="js-collapse collapse" id="merchant-intro">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="service-phone">
              服务电话
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="service_phone" id="service-phone">
            </div>
            <label for="service-phone" class="col-lg-6 help-text">手机或固话</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="business-service">
              商户服务
            </label>

            <div class="col-lg-4">
              <div class="checkbox-inline">
                <label>
                  <input id="business-service" class="business_service" name="business_service[]" type="checkbox" value="1">
                  免费WIFI
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input class="business_service" name="business_service[]" type="checkbox" value="2">
                  可带宠物
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input class="business_service" name="business_service[]" type="checkbox" value="3">
                  免费停车
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input class="business_service" name="business_service[]" type="checkbox" value="4">
                  可外卖
                </label>
              </div>
            </div>
          </div>
        </div>

      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">
          自定义入口
          <small>(选填)</small>
          <a class="btn btn-link btn-sm" type="button" data-toggle="collapse" href="#custom-url-collapse"
            aria-expanded="false" aria-controls="custom-url-collapse" data-hide-text="收起">
            展开
          </a>
        </legend>

        <div class="js-collapse collapse" id="custom-url-collapse">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-url-name">
              自定义入口名称
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="custom_url_name" id="custom-url-name">
            </div>
            <label for="customUrlName" class="col-lg-6 help-text">长度限制在5个汉字内,如"立即使用","在线预约"</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-link-to">
              自定义入口链接
            </label>

            <div class="col-lg-4">
              <p class="js-link-to form-control-static" id="custom-link-to" data-name="custom_link_to"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-url-sub-title">
              入口右侧的提示
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="custom_url_sub_title" id="custom-url-sub-title">
            </div>
            <label for="customUrlSubTitle" class="col-lg-6 help-text">长度限制在6个汉字内</label>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">
          营销场景自定义入口
          <small>(选填)</small>
          <a class="btn btn-link btn-sm" type="button" data-toggle="collapse" href="#promotion-url-collapse"
            aria-expanded="false" aria-controls="promotion-url-collapse" data-hide-text="收起">
            展开
          </a>
        </legend>

        <div class="js-collapse collapse" id="promotion-url-collapse">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="promotion-url-name">
              营销场景自定义入口
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="promotion_url_name" id="promotion-url-name">
            </div>
            <label for="promotion-url-name" class="col-lg-6 help-text">长度限制在5个汉字内,如"再次购买"</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="promotion-link-to">
              营销场景自定义入口链接
            </label>

            <div class="col-lg-4">
              <p class="js-link-to form-control-static" id="promotion-link-to" data-name="promotion_link_to"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="promotion-url-sub-title">
              营销场景入口右侧的提示
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="promotion_url_sub_title" id="promotion-url-sub-title">
            </div>
            <label for="promotion-url-sub-title" class="col-lg-6 help-text">长度限制在6个汉字内</label>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">
          自定义会员信息入口
          <small>(选填)</small>
          <a class="btn btn-link btn-sm" type="button" data-toggle="collapse" href="#custom-cell-collapse"
            aria-expanded="false" aria-controls="custom-cell-collapse" data-hide-text="收起">
            展开
          </a>
        </legend>

        <div class="js-collapse collapse" id="custom-cell-collapse">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-cell-name">
              入口名称
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="custom_cell[name]" id="custom-cell-name">
            </div>
            <label for="custom-cell-name" class="col-lg-6 help-text">长度限制在5个汉字内，激活后显示</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-cell-link-to">
              入口跳转链接
            </label>

            <div class="col-lg-4">
              <p class="js-link-to form-control-static" id="custom-cell-link-to" data-name="custom_cell[link_to]"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-cell-tips">
              入口右侧提示语
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="custom_cell[tips]" id="custom-cell-tips">
            </div>
            <label for="custom-cell-tips" class="col-lg-6 help-text">长度限制在6个汉字内</label>
          </div>
        </div>
      </fieldset>

      <input class="js-id" type="hidden" id="id" name="id">
      <input type="hidden" id="type" name="type" value="<?= WechatCardRecord::TYPE_MEMBER_CARD ?>">

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交微信审核
          </button>

          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/wechat-member-cards') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
  <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<!-- Modal -->
<div class="modal fade" id="shops-modal" tabindex="-1" role="dialog" aria-labelledby="shops-modal-label"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
            class="sr-only">Close</span></button>
        <h4 class="modal-title" id="shops-modal-label">选择门店</h4>
      </div>
      <div class="modal-body">
        <table id="shops-table" class="table table-bordered">
          <thead>
          <tr>
            <th style="width: 50px" class="text-center">
              <label>
                <input class="ace toggle-all" data-class="shop-id" type="checkbox">
                <span class="lbl"></span>
              </label>
            </th>
            <th>门店名称</th>
            <th class="text-right">地址</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">完成</button>
      </div>
    </div>
  </div>
</div>

<script type="text/html" id="shops-checkbox">
  <label>
    <input class="ace shop-id" type="checkbox" value="<%= id %>" <%= selectedShopIds.indexOf(id) != -1 ? 'checked' : ''
    %>>
    <span class="lbl"></span>
  </label>
</script>

<script type="text/html" id="shops-row">
  <tr>
    <td><%= name %></td>
    <td><%= address %></td>
    <td class="text-center bigger-110">
      <a class="remove-shop" href="javascript:" data-id="<%= id %>"><i class="fa fa-trash-o"></i></a>
    </td>
  </tr>
</script>

<script class="js-article-item-tpl" type="text/html">
  <div class="js-article-item">
    <div class="js-upload-container">
    <input type="file" class="js-article-url">
    <input type="hidden" name="text_image_list[<%= id %>][image_url]" class="js-image-url" value="<%= image_url %>">
    </div>
    <textarea class="form-control m-t" name="text_image_list[<%= id %>][text]" rows="4" data-rule-required="true"
      placeholder="图文内容建议上传商品、服务、环境等优质图片，并辅之以简单描述"><%= text %></textarea>
    <a class="js-remove-article pull-right m-y" href="javascript:;">删除</a>
    <div class="clearfix"></div>
  </div>
</script>

<?= $block('js') ?>
<script>
  require(['plugins/wechat-member-card/js/admin/wechat-member-cards'], function (card) {
    card.formAction({
      data: <?= $card->toJson() ?>
    });
  });
</script>
<?= $block->end() ?>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>
