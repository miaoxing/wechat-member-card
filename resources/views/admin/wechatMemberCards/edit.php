<?php

use Miaoxing\WechatCard\Service\WechatCardRecord;

$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-default" href="<?= $url('admin/wechat-member-cards') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <form class="js-card-form form-horizontal" method="post" role="form">
      <fieldset>
        <legend class="grey bigger-130">基本信息</legend>

        <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-brand.php') ?>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="cover-type">
            卡券封面
          </label>

          <div class="col-lg-4">
            <label class="radio-inline">
              <input type="radio" class="js-editable js-cover-type js-toggle-display" name="cover_type" value="0" checked="checked"
                data-value=":checked" data-target=".js-cover-type-image" data-reverse-target=".js-cover-type-color">图片
            </label>
            <label class="radio-inline">
              <input type="radio" class="js-editable js-cover-type js-toggle-display" name="cover_type" value="1" data-value=":checked"
                data-target=".js-cover-type-color" data-reverse-target=".js-cover-type-image"> 颜色
            </label>

            <div class="js-cover-type-image m-t">
              <p class="upload_tips">请参照 <a
                href="https://mp.weixin.qq.com/cgi-bin/readtemplate?t=cardticket/card_cover_tmpl&type=info&lang=zh_CN"
                target="_blank">微信图片规范</a> 上传</p>
              <input type="text" name="background_pic_url" class="js-editable js-background-pic-url" required>
            </div>

            <div class="js-cover-type-color m-t display-none">
              <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-color.php') ?>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="title">
            <span class="text-warning">*</span>
            会员卡标题
          </label>

          <div class="col-lg-4">
            <input type="text" class="js-editable form-control" name="title" id="title" data-rule-required="true">
          </div>
          <label class="col-lg-6 help-text" for="title">
            <span class="js-edit-tips text-warning display-none">修改需审核</span>
            建议会员卡标题包含商户名或服务内容，如腾讯会员黄钻尊享卡
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="date-info-type">
            <span class="text-warning">*</span>
            有效期
          </label>

          <div class="col-lg-4">
            <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-date-info-fix-term.php') ?>
            <div class="radio">
              <label>
                <input class="<?= $card->isDateTypePermanentEditable() ? 'js-editable' : '' ?> js-toggle-display js-date-info-type"
                  id="date-info-type-3" type="radio" name="date_info[type]" value="3" checked
                  data-target=".js-date-range" data-value=":checked" data-on="disable" data-off="enable">
                永久有效
              </label>
            </div>
          </div>
          <label class="js-edit-tips col-lg-6 help-text" for="date-info-type">
            编辑时，仅支持扩大固定日期
          </label>
        </div>

        <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-time-limit.php') ?>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="supply-score">
            会员卡优惠
          </label>

          <div class="col-lg-4">
            <div class="checkbox-inline">
              <label>
                <input name="supply_score" type="hidden" value="0" data-populate-ignore>
                <input class="js-editable js-supply-score js-toggle-display" id="supply-score" name="supply_score" type="checkbox"
                  value="1" data-target=".js-supply-score-groups" data-value=":checked">
                积分优惠
                <span class="js-tooltips help-button help-button-xs"
                  title="积分有助于吸引用户成为忠实会员">?</span>
              </label>
            </div>
            <div class="checkbox-inline hide">
              <label>
                <input name="supply_discount" type="hidden" value="0" data-populate-ignore>
                <input class="js-editable js-supply-discount js-toggle-display" id="supply-discount" name="supply_discount"
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
              <input type="text" id="cost-money-unit" class="js-editable t-3 text-center" name="bonus_rule[cost_money_unit]"
                data-rule-required="true" data-rule-number="true" data-rule-min="0">
              元，赠送
              <input type="text" class="js-editable t-3 text-center" name="bonus_rule[increase_bonus]" data-rule-required="true"
                data-rule-number="true" data-rule-min="0">
              积分
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="max-increase-bonus">
              单次上限
            </label>

            <div class="col-lg-4">
              <input type="text" id="max-increase-bonus" class="js-editable t-3 text-center" name="bonus_rule[max_increase_bonus]" data-rule-number="true" data-rule-min="0">
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
              <input type="text" id="init-increase-bonus" class="js-editable t-3 text-center" name="bonus_rule[init_increase_bonus]" data-rule-number="true" data-rule-min="0">
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
              <input type="text" id="cost-bonus-unit" class="js-editable t-3 text-center" name="bonus_rule[cost_bonus_unit]" data-rule-required="true" data-rule-number="true" data-rule-min="0">
              积分，抵扣
              <input type="text" class="js-editable t-3 text-center" name="bonus_rule[reduce_money]" data-rule-required="true" data-rule-number="true" data-rule-min="0">
              元
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="least-money-to-use-bonus">
              抵扣条件
            </label>

            <div class="col-lg-4">
              订单满
              <input type="text" id="least-money-to-use-bonus" class="js-editable t-3 text-center" name="bonus_rule[least_money_to_use_bonus]" data-rule-number="true" data-rule-min="0">
              元可用，单笔上限
              <input type="text" class="js-editable t-3 text-center" name="bonus_rule[max_reduce_bonus]" data-rule-number="true" data-rule-min="0">
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
                <input type="text" class="js-editable form-control" name="discount" id="discount">
                <span class="input-group-append"><span class="input-group-text">折</span></span>
              </div>
            </div>

            <label class="control-label help-text">
              <span class="js-edit-tips text-warning display-none">修改需审核</span>
              请填写0-9.99之间的数字，精确到小数点后2位
            </label>
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
            <textarea class="js-editable form-control" name="detail" id="detail" rows="4" data-rule-required="true"></textarea>
          </div>

          <label class="col-lg-6 help-text" for="detail">
            注：1、上文设置中，如已经填写“积分优惠”“折扣优惠”的内容，将会自动在用户会员卡详情展示，无需重复填写。2、建议填写其他特权，举例：100积分可兑换精美礼品；会员日可享受折上折优惠等
          </label>
        </div>

        <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-description.php') ?>
        <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-text-image-list.php') ?>
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
                <input name="supply_bonus" type="hidden" value="0" data-populate-ignore>
                <input class="<?= $card['supply_bonus'] ? '' : 'js-editable' ?> js-custom-field js-supply-bonus js-toggle-display" id="supply-bonus" name="supply_bonus"
                  type="checkbox" value="1" data-target=".js-supply-bonus-groups" data-value=":checked">
                积分
              </label>
            </div>
          </div>
          <label class="help-text">
            <span class="js-edit-tips text-warning display-none">修改需审核</span>
            编辑时，仅支持增加，不支持取消该项
          </label>
        </div>

        <div class="js-supply-bonus-groups display-none">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="bonus-link-to">
              查看积分详情URL
            </label>

            <div class="col-lg-4">
              <p class="js-editable js-link-to form-control-static" data-name="bonus_link_to" id="bonus-link-to"></p>
            </div>
            <label for="bonus-url" class="col-lg-6 help-text">仅适用于积分无法通过激活接口同步的情况下使用该字段。</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="bonus-rules">
              积分规则
            </label>

            <div class="col-lg-4">
              <textarea type="text" class="js-editable form-control" name="bonus_rules" id="bonus-rules"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="bonus-cleared">
              积分清零规则
            </label>

            <div class="col-lg-4">
              <textarea type="text" class="js-editable form-control" name="bonus_cleared" id="bonus-cleared"></textarea>
            </div>
          </div>
          <hr>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label"></label>
          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input name="supply_balance" type="hidden" value="0" data-populate-ignore>
                <input class="<?= $card['supply_balance'] ? '' : 'js-editable' ?> js-custom-field js-supply-balance js-toggle-display" id="supply-balance" name="supply_balance"
                  type="checkbox" value="1" data-target=".js-supply-balance-groups" data-value=":checked">
                余额（支持储值）
              </label>
            </div>
          </div>
          <label class="help-text">
            <span class="js-edit-tips text-warning display-none">修改需审核</span>
            编辑时，仅支持增加，不支持取消该项
          </label>
        </div>

        <div class="js-supply-balance-groups display-none">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="balance-rules">
              储值说明
            </label>

            <div class="col-lg-4">
              <textarea class="js-editable form-control" name="balance_rules" id="balance-rules"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="balance-link-to">
              查看余额详情URL
            </label>

            <div class="col-lg-4">
              <p class="js-editable js-link-to form-control-static" data-name="balance_link_to" id="balance-link-to"></p>
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
                <input name="custom_field<?= $i ?>[enable]" type="hidden" value="0" data-populate-ignore>
                <input class="js-editable js-custom-field js-toggle-display js-custom-field<?= $i ?>-enable" id="custom-field<?= $i ?>-enable" name="custom_field<?= $i ?>[enable]"
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
              <select class="js-editable js-toggle-display form-control" id="custom-field<?= $i ?>-name-type" name="custom_field<?= $i ?>[name_type]"
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
              <input class="js-editable form-control" id="custom-field<?= $i ?>-name" type="text" name="custom_field<?= $i ?>[name]">
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
              <p class="js-editable js-link-to form-control-static" id="custom-field<?= $i ?>-url" data-name="custom_field<?= $i ?>[link_to]"></p>
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
                <input class="js-editable js-toggle-display" id="activate-type" type="radio" name="activate_type" value="0" checked data-value=":checked" data-reverse-target=".js-activate-link-to">
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
                <input class="js-editable js-toggle-display" type="radio" name="activate_type" value="1" data-value=":checked" data-reverse-target=".js-activate-link-to">
                一键激活
              </label>
              <label class="block text-muted">
                一键激活是微信提供的快速便捷的激活方案。详见微信文档
                <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025283" target="_blank">#6.2</a>
              </label>
            </div>
            <div class="radio">
              <label>
                <input class="js-editable js-toggle-display" type="radio" name="activate_type" value="2" data-value=":checked" data-target=".js-activate-link-to">
                接口激活
              </label>
              <label class="block text-muted">
                接口激活通常需要开发者开发用户填写资料的网页。详见微信文档
                <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025283" target="_blank">#6.1</a>
                <p class="js-editable js-link-to js-activate-link-to form-control-static" id="activate-link-to" data-name="activate_link_to"></p>
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
                <input class="js-editable" type="hidden" value="0" name="can_share" data-populate-ignore>
                <input class="js-editable" type="checkbox" value="1" name="can_share" id="can_share">
                用户可以分享领券链接
              </label>
            </div>
          </div>
        </div>

        <div class="form-group hide">
          <label class="col-lg-2 control-label" for="can-give-friend">
            激活信息
          </label>

          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input type="hidden" value="0" name="can_give_friend">
                <input class="js-editable" type="checkbox" value="1" name="can_give_friend" id="can-give-friend">
                允许用户自主修改以上信息
              </label>
            </div>
          </div>
        </div>

        <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-code-type.php') ?>
        <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-notice.php') ?>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="is-swipe-card">
          </label>

          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input name="pay_info[swipe_card][is_swipe_card]" type="hidden" value="0" data-populate-ignore>
                <input class="js-editable" id="is-swipe-card" type="checkbox" name="pay_info[swipe_card][is_swipe_card]" value="1">
                支持微信支付刷卡
              </label>
            </div>

          </div>
          <label for="is-swipe-card" class="col-lg-6 help-text">用户点击快速买单后即可拉出刷卡界面进行支付</label>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="use-dynamic-code">
          </label>

          <div class="col-lg-4">
            <div class="checkbox">
              <label>
                <input class="js-editable" name="use_dynamic_code" type="hidden" value="0" data-populate-ignore>
                <input class="js-editable" type="checkbox" name="use_dynamic_code" id="use-dynamic-code" value="1">
                支持动态码
              </label>
            </div>

          </div>
          <label for="is-swipe-card" class="col-lg-6 help-text">
            详情请参见<a href="https://mp.weixin.qq.com/cgi-bin/announce?action=getannouncement&key=1478005752&version=12020810&lang=zh_CN&platform=2"
              target="_blank">
              微信文档
            </a>
          </label>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">服务信息</legend>

        <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-shop.php') ?>
      </fieldset>

      <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-center-url.php') ?>
      <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-merchant-intro.php') ?>
      <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-custom-url.php') ?>
      <?php require $view->getFile('@wechat-card/admin/wechatCards/_form-promotion-url.php') ?>

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
              <input type="text" class="js-editable form-control" name="custom_cell[name]" id="custom-cell-name">
            </div>
            <label for="custom-cell-name" class="col-lg-6 help-text">长度限制在5个汉字内，激活后显示</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-cell-link-to">
              入口跳转链接
            </label>

            <div class="col-lg-4">
              <p class="js-editable js-link-to form-control-static" id="custom-cell-link-to" data-name="custom_cell[link_to]"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="custom-cell-tips">
              入口右侧提示语
            </label>

            <div class="col-lg-4">
              <input type="text" class="js-editable form-control" name="custom_cell[tips]" id="custom-cell-tips">
            </div>
            <label for="custom-cell-tips" class="col-lg-6 help-text">长度限制在6个汉字内</label>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">
          会员卡激活消息
          <small>(选填)</small>
          <a class="btn btn-link btn-sm" type="button" data-toggle="collapse" href="#activate-msg-operation-collapse"
            aria-expanded="false" aria-controls="activate-msg-operation-collapse" data-hide-text="收起">
            展开
          </a>
        </legend>

        <div class="js-collapse collapse" id="activate-msg-operation-collapse">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="activate-type">
              消息指向
            </label>

            <div class="col-lg-4">
              <label class="radio-inline">
                <input type="radio" class="js-editable js-toggle-display" name="activate_msg_operation[url_cell][type]"
                  value="0" checked="checked" data-value=":checked" data-reverse-target=".js-activate-link-to-form-group, .js-activate-card-id-list-form-group">不启用
              </label>
              <label class="radio-inline">
                <input type="radio" class="js-editable js-toggle-display" name="activate_msg_operation[url_cell][type]"
                  value="1" data-value=":checked" data-target=".js-activate-link-to-form-group" data-reverse-target=".js-activate-card-id-list-form-group"> 链接
              </label>
              <label class="radio-inline">
                <input type="radio" class="js-editable js-toggle-display" name="activate_msg_operation[url_cell][type]"
                  value="2" data-value=":checked" data-target=".js-activate-card-id-list-form-group" data-reverse-target=".js-activate-link-to-form-group"> 卡券
                </label>
            </div>
          </div>

          <div class="js-activate-link-to-form-group form-group display-none">
            <label class="col-lg-2 control-label" for="activate-link-to">
              链接
            </label>

            <div class="col-lg-4">
              <p class="js-editable js-link-to form-control-static" id="activate-msg-operation-link-to" data-name="activate_msg_operation[url_cell][link_to]"></p>
            </div>
          </div>

          <div class="js-activate-card-id-list-form-group form-group display-none">
            <label class="col-lg-2 control-label" for="activate-card-id-list">
              卡券
            </label>

            <div class="col-lg-4">
              <select class="js-activate-card-id-list form-control" id="activate-card-id-list"
                name="activate_msg_operation[url_cell][card_id_list][]" multiple>
                <?php foreach ($msgCards as $msgCard) : ?>
                  <option value="<?= $msgCard['wechat_id'] ?>"><?= $msgCard['title'] ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <label class="col-lg-4" for="activate-card-id-list">
              送券的列表，不支持普通券和朋友的券混合使用，最多填写10个
            </label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="activate-text">
            文本内容
            </label>

            <div class="col-lg-4">
              <input type="text" class="js-editable form-control" id="activate-text" name="activate_msg_operation[url_cell][text]">
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="activate-end-time">
              截止时间
            </label>

            <div class="col-lg-4">
              <input type="text" class="js-activate-end-time js-editable form-control" id="activate-end-time" name="activate_msg_operation[url_cell][end_time]">
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <legend class="grey bigger-130">
          会员卡积分余额等变动消息
          <small>(选填)</small>
          <a class="btn btn-link btn-sm" type="button" data-toggle="collapse" href="#modify-msg-operation-collapse"
            aria-expanded="false" aria-controls="modify-msg-operation-collapse" data-hide-text="收起">
            展开
          </a>
        </legend>

        <div class="js-collapse collapse" id="modify-msg-operation-collapse">
          <div class="form-group">
            <label class="col-lg-2 control-label" for="modify-type">
              消息指向
            </label>

            <div class="col-lg-4">
              <label class="radio-inline">
                <input type="radio" class="js-editable js-toggle-display" name="modify_msg_operation[url_cell][type]"
                  value="0" checked="checked" data-value=":checked" data-reverse-target=".js-modify-link-to-form-group, .js-modify-card-id-list-form-group">不启用
              </label>
              <label class="radio-inline">
                <input type="radio" class="js-editable js-toggle-display" name="modify_msg_operation[url_cell][type]"
                  value="1" data-value=":checked" data-target=".js-modify-link-to-form-group" data-reverse-target=".js-modify-card-id-list-form-group"> 链接
              </label>
              <label class="radio-inline">
                <input type="radio" class="js-editable js-toggle-display" name="modify_msg_operation[url_cell][type]"
                  value="2" data-value=":checked" data-target=".js-modify-card-id-list-form-group" data-reverse-target=".js-modify-link-to-form-group"> 卡券
              </label>
            </div>
          </div>

          <div class="js-modify-link-to-form-group form-group display-none">
            <label class="col-lg-2 control-label" for="modify-link-to">
              链接
            </label>

            <div class="col-lg-4">
              <p class="js-editable js-link-to form-control-static" id="modify-msg-operation-link-to" data-name="modify_msg_operation[url_cell][link_to]"></p>
            </div>
          </div>

          <div class="js-modify-card-id-list-form-group form-group display-none">
            <label class="col-lg-2 control-label" for="modify-card-id-list">
              卡券
            </label>

            <div class="col-lg-4">
              <select class="js-modify-card-id-list form-control" id="modify-card-id-list"
                name="modify_msg_operation[url_cell][card_id_list][]" multiple>
                <?php foreach ($msgCards as $msgCard) : ?>
                  <option value="<?= $msgCard['wechat_id'] ?>"><?= $msgCard['title'] ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <label class="col-lg-4" for="modify-card-id-list">
              送券的列表，不支持普通券和朋友的券混合使用，最多填写10个
            </label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="modify-text">
              文本内容
            </label>

            <div class="col-lg-4">
              <input type="text" class="js-editable form-control" id="modify-text" name="modify_msg_operation[url_cell][text]">
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="modify-end-time">
              截止时间
            </label>

            <div class="col-lg-4">
              <input type="text" class="js-modify-end-time js-editable form-control" id="modify-end-time" name="modify_msg_operation[url_cell][end_time]">
            </div>
          </div>
        </div>
      </fieldset>

      <input class="js-editable js-id" type="hidden" id="id" name="id">
      <input type="hidden" id="type" name="type" value="<?= WechatCardRecord::TYPE_MEMBER_CARD ?>">
      <input type="hidden" id="quantity" name="quantity" value="100000000">
      <input class="js-editable" type="hidden" id="get-limit" name="get_limit" value="1">

      <div class="clearfix form-actions form-group">
        <div class="offset-lg-2">
          <?php if ($card['source'] == WechatCardRecord::SOURCE_OUT) : ?>
            <p>外部来源的卡券保存将覆盖已有数据，可能丢失数据，暂不可编辑</p>
          <?php endif ?>

          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交微信
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

<?= $block->js() ?>
<script>
  require(['plugins/wechat-member-card/js/admin/wechat-member-cards'], function (card) {
    if (wei.card.source == <?= WechatCardRecord::SOURCE_OUT ?>) {
      $('.js-card-form :input').prop('disabled', true);
    }
    card.formAction({
      data: wei.card,
      shops: wei.shops
    });
  });
</script>
<?= $block->end() ?>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>
