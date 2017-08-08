<?php

$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-default" href="<?= $url('admin/wechat-member-cards') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form id="record-form" class="form-horizontal" method="post" role="form">
      <div class="detail">
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
              <input type="file" class="js-logo-url"/>
              <input type="hidden" id="thumb" name="thumb" class="js-image-url"/>
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
                <input type="radio" class="js-cover-type" name="cover_type" value="0" checked="checked"> 图片
              </label>
              <label class="radio-inline">
                <input type="radio" class="js-cover-type" name="cover_type" value="1"> 颜色
              </label>

              <div class="js-cover-type-image js-upload-container m-t">
                <p class="upload_tips">请参照 <a
                  href="https://mp.weixin.qq.com/cgi-bin/readtemplate?t=cardticket/card_cover_tmpl&type=info&lang=zh_CN"
                  target="_blank">微信图片规范</a> 上传</p>
                <input type="file" class="js-background-pic-url"/>
                <input type="hidden" name="background_pic_url" class="js-image-url"/>
              </div>

              <div class="js-cover-type-color m-t display-none">
                <select name="color" id="color" class="js-color form-control">
                  <?php foreach ($card->getColors() as $color => $wechatColor) : ?>
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
            <label class="col-sm-2 control-label" for="date-type">
              有效期
            </label>

            <div class="col-lg-4">
              <div class="radio">
                <label>
                  <input type="radio" class="js-date-type" name="date_type" id="date-type" value="1">
                  固定日期
                </label>
                <input type="text" class="js-date-range" placeholder="请选择日期范围">
                <input type="hidden" class="js-start-date" name="begin_time">
                <input type="hidden" class="js-end-date" name="end_time">
              </div>
              <div class="radio">
                <label>
                  <input type="radio" class="js-date-type" name="date_type" id="date-type-2" value="2" checked>
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
                  <input type="radio" class="js-time-limit-type" name="time_limit_type" id="time-limit-type" checked>
                  全部时段
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" class="js-time-limit-type" name="time_limit_type" id="time-limit-type-2"
                    value="part">
                  部分时段
                </label>
              </div>

              <div class="js-time-limit-type-part m-t display-none">
                <label class="pull-left control-label">日期：</label>
                <div>
                  <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" name="time_limit[day][]" value="MONDAY">
                      周一
                    </label>
                  </div>
                  <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" name="time_limit[day][]" value="TUESDAY">
                      周二
                    </label>
                  </div>
                  <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" name="time_limit[day][]" value="WEDNESDAY">
                      周三
                    </label>
                  </div>
                  <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" name="time_limit[day][]" value="THURSDAY">
                      周四
                    </label>
                  </div>
                  <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" name="time_limit[day][]" value="FRIDAY">
                      周五
                    </label>
                  </div>
                  <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" name="time_limit[day][]" value="SATURDAY">
                      周六
                    </label>
                  </div>
                  <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" name="time_limit[day][]" value="SUNDAY">
                      周日
                    </label>
                  </div>
                </div>

                <div class="m-t">
                  <label>时间：</label>
                  <input type="text" class="text-center" name="time_limit_type" style="width: 60px">
                  至
                  <input type="text" class="text-center" name="time_limit_type" style="width: 60px">
                  &nbsp;&nbsp;
                  <input type="text" class="text-center" name="time_limit_type" style="width: 60px">
                  至
                  <input type="text" class="text-center" name="time_limit_type" style="width: 60px">

                  <div class="m-t m-l-lg help-text">请使用24小时制输入时间，格式如11:00至14:30，留空表示全天。</div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="supply-bonus">
              会员卡优惠
            </label>

            <div class="col-lg-4">
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" id="supply-bonus" class="js-supply-bonus">
                  积分优惠
                  <span class="js-tooltips help-button help-button-xs"
                    title="积分有助于吸引用户成为忠实会员">?</span>
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" class="js-supply-discount">
                  折扣优惠
                  <span class="js-tooltips help-button help-button-xs"
                    title="折扣优惠能够鼓励用户到店消费">?</span>
                </label>
              </div>
            </div>
          </div>

          <div class="js-bonus-form-groups display-none">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="discount">
                <span class="text-warning">*</span>
                消费送积分
              </label>

              <div class="col-lg-4">
                每消费
                <input type="text" class="t-3 text-center " name="tiers[0][amount]" data-rule-number="true" data-rule-min="0">
                赠送
                <input type="text" class="t-3 text-center" name="tiers[0][amount]" data-rule-number="true" data-rule-min="0">
                积分
              </div>

              <label class="control-label help-text">请填写1-9.9之间的数字，精确到小数点后1位</label>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="discount">
                单次上限
              </label>

              <div class="col-lg-4">
                <input type="text" class="t-3 text-center" name="tiers[0][amount]" data-rule-number="true" data-rule-min="0">
                积分
              </div>

              <label class="control-label help-text">请填写1-9.9之间的数字，精确到小数点后1位</label>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="discount">
                <span class="text-warning">*</span>
                积分抵扣
              </label>

              <div class="col-lg-4">
                每使用
                <input type="text" class="t-3 text-center " name="tiers[0][amount]" data-rule-number="true" data-rule-min="0">
                积分，抵扣
                <input type="text" class="t-3 text-center" name="tiers[0][amount]" data-rule-number="true" data-rule-min="0">
                元
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="discount">
                抵扣条件
              </label>

              <div class="col-lg-4">
                订单满
                <input type="text" class="t-3 text-center " name="tiers[0][amount]" data-rule-number="true" data-rule-min="0">
                元可用，单笔上限
                <input type="text" class="t-3 text-center" name="tiers[0][amount]" data-rule-number="true" data-rule-min="0">
                积分
              </div>
            </div>
          </div>

          <div class="js-discount-form-groups display-none">
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
            <label class="col-lg-2 control-label" for="prerogative">
              <span class="text-warning">*</span>
              特权说明
            </label>

            <div class="col-lg-4">
              <textarea class="form-control" name="prerogative" id="prerogative" rows="4"></textarea>
            </div>

            <label class="col-lg-6 help-text" for="prerogative">
              注：1、上文设置中，如已经填写“积分优惠”“折扣优惠”的内容，将会自动在用户会员卡详情展示，无需重复填写。2、建议填写其他特权，举例：100积分可兑换精美礼品；会员日可享受折上折优惠等
            </label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="description">
              <span class="text-warning">*</span>
              使用须知
            </label>

            <div class="col-lg-4">
              <textarea class="form-control" name="detail[description]" id="description" rows="4"
                data-rule-required="true"></textarea>
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
          <legend class="grey bigger-130">商户介绍(选填)</legend>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="servicePhone">
              服务电话
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[servicePhone]" id="servicePhone"
                data-rule-required="true">
            </div>
            <label for="servicePhone" class="col-lg-6 help-text">手机或固话</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="servicePhone">
              商户服务
            </label>

            <div class="col-lg-4">
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" name="dateType" id="dateType2" class="dateType" value="2">
                  免费WIFI
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" name="dateType" id="dateType" class="dateType" value="1">
                  可带宠物
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" name="dateType" id="dateType" class="dateType" value="1">
                  免费停车
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" name="dateType" id="dateType" class="dateType" value="1">
                  可外卖
                </label>
              </div>
            </div>
          </div>

        </fieldset>

        <div class="m-y">
          <div class="js-custom-field-list">
          </div>
          <button type="button" class="js-add-custom-field btn btn-default m-b">添加自定义入口</button>
          <p class="help-text">可配置图文消息、货架、网页链接,用户可查看详情或领取更多卡券。</p>
        </div>

        <fieldset>
          <legend class="grey bigger-130">使用设置</legend>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="can_share">

            </label>

            <div class="col-lg-4">
              <div class="checkbox">
                <label>
                  <input type="hidden" value="0" name="can_share">
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
            <label class="col-lg-2 control-label" for="auto-activate">
              自动激活
            </label>

            <div class="col-lg-4">
              <div class="radio-inline">
                <label>
                  <input type="radio" value="1" name="auto_activate" id="auto-activate">
                  是
                </label>
              </div>
              <div class="radio-inline">
                <label>
                  <input type="radio" value="0" name="auto_activate" checked>
                  否
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="wx-activate">
              一键开卡
            </label>

            <div class="col-lg-4">
              <div class="radio-inline">
                <label>
                  <input type="radio" value="1" name="wx_activate" id="wx-activate">
                  是
                </label>
              </div>
              <div class="radio-inline">
                <label>
                  <input type="radio" value="0" name="wx_activate" checked>
                  否
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="canShare">
              激活信息
            </label>

            <div class="col-lg-4">
              <div class="checkbox">
                <label>
                  <input type="hidden" value="0" name="canGiveFriend">
                  <input type="checkbox" value="1" name="canGiveFriend" id="canGiveFriend">
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
                  <input type="radio" value="0" checked name="codeType" id="codeType-0">
                  不显示code和条形码类型
                </label>
                <label class="block text-muted">
                  适用于线上核销
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" value="1" name="codeType" id="codeType-1">
                  仅卡号
                </label>
                <label class="block text-muted">
                  只显示卡券号，验证后可进行销券
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" value="3" name="codeType" id="codeType-3">
                  二维码
                </label>
                <label class="block text-muted">
                  包含卡券信息的二维码和卡号，扫描后可进行销券
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" value="2" name="codeType" id="codeType-2">
                  条形码
                </label>
                <label class="block text-muted">
                  包含卡券信息的条形码和卡号，扫描后可进行销券
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" value="4" name="codeType" id="codeType-4">
                  二维码，不显示卡号
                </label>
                <label class="block text-muted">
                  只显示卡券信息的二维码，扫描后可进行销券
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" value="5" name="codeType" id="codeType-5">
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
              <input type="text" class="form-control" name="detail[notice]" id="notice" data-rule-required="true">
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
              <p class="help-text">"适用门店"方便帮助用户到店消费。如有门店，请仔细配置。可在"微官网"-"门店管理"管理门店信息。</p>

              <div class="radio">
                <label>
                  <input type="radio" value="1" checked name="shop_type" id="shop-type" class="js-shop-type">
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
                  <input type="radio" value="2" name="shop_type" class="js-shop-type">
                  无指定门店
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" value="3" name="shop_type" class="js-shop-type">
                  全部门店适用
                </label>
              </div>
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend class="grey bigger-130">
            消息通知
            <small>卡券核销后，用户在卡包会收到消息通知</small>
          </legend>
        </fieldset>

        <fieldset>
          <legend class="grey bigger-130">自定义链接</legend>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="centerTitle">
              顶部居中的按钮
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[centerTitle]" id="centerTitle">
            </div>
            <label for="centerTitle" class="col-lg-6 help-text">仅在卡券状态正常(可以核销)时显示</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="centerSubTitle">
              按钮下方的提示语
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[centerSubTitle]" id="centerSubTitle">
            </div>

          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="link-to-1">
              顶部居中的链接
            </label>

            <div class="col-lg-4">
              <p class="form-control-static" id="link-to-1"></p>
            </div>
          </div>

          <hr>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="customUrlName">
              自定义入口名称
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[customUrlName]" id="customUrlName">
            </div>
            <label for="customUrlName" class="col-lg-6 help-text">长度限制在5个汉字内,如"立即使用","在线预约"</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="link-to-2">
              自定义入口链接
            </label>

            <div class="col-lg-4">
              <p class="form-control-static" id="link-to-2"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="customUrlSubTitle">
              入口右侧的提示
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[customUrlSubTitle]" id="customUrlSubTitle">
            </div>
            <label for="customUrlSubTitle" class="col-lg-6 help-text">长度限制在6个汉字内</label>
          </div>

          <hr>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="promotionUrlName">
              营销场景自定义入口
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[promotionUrlName]" id="promotionUrlName">
            </div>
            <label for="promotionUrlName" class="col-lg-6 help-text">长度限制在5个汉字内,如"再次购买"</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="promotionUrl">
              营销场景自定义入口链接
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[promotionUrl]" id="promotionUrl">
            </div>
            <label for="promotionUrl" class="col-lg-6 help-text"></label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="promotionUrlSubTitle">
              营销场景入口右侧的提示
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[promotionUrlSubTitle]" id="promotionUrlSubTitle">
            </div>
            <label for="promotionUrlSubTitle" class="col-lg-6 help-text">长度限制在6个汉字内</label>
          </div>

        </fieldset>

        <input type="hidden" id="id" name="id">
        <input type="hidden" id="type" name="type">

        <div class="clearfix form-actions form-group">
          <div class="col-lg-offset-2">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-check bigger-110"></i>
              提交微信审核
            </button>

            &nbsp; &nbsp; &nbsp;
            <a class="btn btn-default" href="<?= $url('admin/cards') ?>">
              <i class="fa fa-undo bigger-110"></i>
              返回列表
            </a>
          </div>
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
    <input type="file" class="js-article-url" name="text_image_list[<%= id %>][image_url]"/>
    <input type="hidden" id="thumb" name="thumb" class="js-image-url"/>
    </div>
    <textarea class="form-control m-t" name="text_image_list[<%= id %>][text]" rows="4" data-rule-required="true"
      placeholder="图文内容建议上传商品、服务、环境等优质图片，并辅之以简单描述"></textarea>
    <a class="js-remove-article pull-right m-y" href="javascript:;">删除</a>
    <div class="clearfix"></div>
  </div>
</script>

<script class="js-custom-field-item-tpl" type="text/html">
  <fieldset class="js-custom-field-item">
    <legend class="grey bigger-130">
      <span class="js-custom-field-title">入口<%= name %></span>
      <a class="js-remove-custom-field pull-right small" href="javascript:;">删除</a>
    </legend>

    <div class="form-group">
      <label class="col-lg-2 control-label" for="detail">
        <span class="text-warning">*</span>
        入口名称
      </label>

      <div class="col-lg-4">
        <input class="form-control" name="detail[detail]" id="detail"
          data-rule-required="true">
      </div>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label" for="description">
        引导语
      </label>

      <div class="col-lg-4">
        <input class="form-control" name="detail[detail]" id="detail">
      </div>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label" for="description">
        点击跳转
      </label>

      <div class="col-lg-4">
        <p class="js-custom-field-link-to form-control-static"></p>
      </div>
    </div>
    <hr>
  </fieldset>
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
