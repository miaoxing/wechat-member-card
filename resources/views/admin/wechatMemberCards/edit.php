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
            <label class="col-lg-6 help-text" for="brandName">提供服务的商户名</label>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="logoUrl">
              <span class="text-warning">*</span>
              商家Logo
            </label>

            <div class="col-lg-4">
              <div class="input-group">
                <input type="text" class="form-control" id="logoUrl" name="logoUrl" data-rule-required="true">
                <span class="input-group-btn">
                    <button id="select-thumb" class="btn btn-white" type="button">
                      <i class="fa fa-picture-o"></i>
                      选择图片
                    </button>
                </span>
              </div>
            </div>
            <div class="col-lg-6 help-text">
              上传的图片限制文件大小限制 1MB，推荐像素为 300*300，支持 JPG格式。
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="color">
              卡券颜色
            </label>

            <div class="col-lg-4">
              <select name="color" id="color" class="form-control">
                <?php foreach ($card->getColors() as $color => $wechatColor) : ?>
                  <option value="<?= $color ?>" data-color="<?= $color ?>"><?= $color ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <?php if ($type == '0') : ?>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="title">
                <span class="text-warning">*</span>
                优惠券标题
              </label>

              <div class="col-lg-4">
                <input type="text" class="form-control" name="title" id="title" data-rule-required="true">
              </div>
              <label class="col-lg-6 help-text" for="title">建议填写优惠券提供的服务或商品名称，描述卡券提供的具体优惠</label>
            </div>
          <?php endif ?>

          <?php if ($type == '3') : ?>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="title">
                <span class="text-warning">*</span>
                礼品券标题
              </label>

              <div class="col-lg-4">
                <input type="text" class="form-control" name="title" id="title" data-rule-required="true">
              </div>
              <label class="col-lg-6 help-text" for="title">建议填写礼品券提供的服务或礼品名称，描述卡券提供的具体优惠</label>
            </div>
          <?php endif ?>

          <?php if ($type == '4') : ?>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="title">
                <span class="text-warning">*</span>
                代金券标题
              </label>

              <div class="col-lg-4">
                <input type="text" class="form-control" name="title" id="title" data-rule-required="true">
              </div>
              <label class="col-lg-6 help-text" for="title">建议填写代金券“减免金额”及自定义内容，描述卡券提供的具体优惠</label>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="reduceCost">
                <span class="text-warning">*</span>
                减免金额
              </label>

              <div class="col-lg-4">
                <div class="input-group">
                  <input type="text" class="form-control" name="reduceCost" id="reduceCost" data-rule-required="true">
                  <span class="input-group-addon">元</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="leastCost">
                抵扣条件
              </label>

              <div class="col-lg-4">
                <div class="input-group">
                  <input type="text" class="form-control" name="leastCost" id="leastCost">
                  <span class="input-group-addon">元</span>
                </div>
              </div>
              <label class="col-lg-6 help-text">消费满多少元可用。如不填写则默认：消费满任意金额可用</label>
            </div>
          <?php endif ?>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="subTitle">
              副标题
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="subTitle" id="subTitle">
            </div>
          </div>

          <!-- 付费券 -->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="price">
              价格
            </label>

            <div class="col-lg-4">
              <div class="input-group">
                <input type="text" class="form-control" name="price" id="price">
                <span class="input-group-addon">元</span>
              </div>
            </div>
            <label class="col-lg-6 help-text">
              仅供统计
            </label>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="originalPrice">
              原价
            </label>

            <div class="col-lg-4">
              <div class="input-group">
                <input type="text" class="form-control" name="originalPrice" id="originalPrice">
                <span class="input-group-addon">元</span>
              </div>
            </div>
            <label class="col-lg-6 help-text">
              仅供统计
            </label>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="dateType">
              有效期
            </label>

            <div class="col-lg-4">
              <div class="radio">
                <label>
                  <input type="radio" name="dateType" id="dateType" class="dateType" value="1">
                  固定日期
                </label>
                <input type="text" id="dateTimeRange" placeholder="请选择日期范围">
                <input type="hidden" name="beginTime" id="beginTime">
                <input type="hidden" name="endTime" id="endTime">
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="dateType" id="dateType2" class="dateType" value="2">
                  领取后
                </label>

                <select name="fixedBeginTerm" id="fixedBeginTerm">
                  <option value="0" selected>当天</option>
                  <?php for ($day = 1; $day < 90; ++$day) : ?>
                    <option value="<?= $day ?>"><?= $day ?>天</option>
                  <?php endfor ?>
                </select>

                <label for="dateType2" class="label-condensed">生效，有效天数</label>

                <select name="fixedTerm" id="fixedTerm">
                  <?php for ($day = 1; $day < 90; ++$day) : ?>
                    <option value="<?= $day ?>" <?= $day == 30 ? 'selected' : '' ?>><?= $day ?>天</option>
                  <?php endfor ?>
                </select>
              </div>
            </div>
          </div>

          <?php require $this->getFile('product:admin/products/chooseProduct.php') ?>

        </fieldset>

        <fieldset>
          <legend class="grey bigger-130">领券设置</legend>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="quantity">
              <span class="text-warning">*</span>
              库存
            </label>

            <div class="col-lg-4">
              <div class="input-group">
                <input type="text" class="form-control" name="quantity" id="quantity" data-rule-required="true">
                <span class="input-group-addon">份</span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="getLimit">
              <span class="text-warning">*</span>
              领券限制
            </label>

            <div class="col-lg-4">
              <div class="input-group">
                <input type="text" class="form-control" name="getLimit" id="getLimit" value="1"
                  data-rule-required="true">
                <span class="input-group-addon">份</span>
              </div>
            </div>
            <label for="getLimit" class="col-lg-6 help-text">每个用户领券上限，默认为1</label>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="canShare">

            </label>

            <div class="col-lg-4">
              <div class="checkbox">
                <label>
                  <input type="hidden" value="0" name="canShare">
                  <input type="checkbox" value="1" name="canShare" id="canShare">
                  用户可以分享领券链接
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="hidden" value="0" name="canGiveFriend">
                  <input type="checkbox" value="1" name="canGiveFriend" id="canGiveFriend">
                  用户领券后可转赠其他好友
                </label>
              </div>
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend class="grey bigger-130">销券设置</legend>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="codeType-0">
              销券方式
            </label>

            <div class="col-lg-6">
              <div class="radio">
                <label>
                  <input type="radio" value="0" checked name="codeType" id="codeType-0">
                  不显示code和条形码类型
                </label>
                <label class="block text-muted">
                  适用于线上核销,须设置"顶部居中的按钮"跳转至H5页面
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" value="1" name="codeType" id="codeType-1">
                  仅卡券号
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
              <!--<div class="radio">
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
              </div>-->
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
          <legend class="grey bigger-130"><!--优惠券-->详情</legend>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="detail">
              <span class="text-warning">*</span>
              优惠详情
            </label>

            <div class="col-lg-4">
              <textarea class="form-control" name="detail[detail]" id="detail" rows="4"
                data-rule-required="true"></textarea>
            </div>
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
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="servicePhone">
              <span class="text-warning">*</span>
              服务电话
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="detail[servicePhone]" id="servicePhone"
                data-rule-required="true">
            </div>
            <label for="servicePhone" class="col-lg-6 help-text">手机或固话</label>
          </div>
        </fieldset>

        <fieldset>
          <legend class="grey bigger-130">服务信息</legend>

          <div class="form-group">
            <label class="col-lg-2 control-label" for="consumeType">
              适用门店
            </label>

            <div class="col-lg-6 shop-radios">
              <p class="help-text">"适用门店"方便帮助用户到店消费。如有门店，请仔细配置。可在"微官网"-"门店管理"管理门店信息。</p>

              <div class="radio">
                <label>
                  <input type="radio" value="1" checked name="shopType" id="shopType" class="shopType">
                  指定门店适用
                </label>

                <div class="shopType-1">
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
                  <input type="radio" value="2" name="shopType" id="shopType2" class="shopType">
                  无指定门店
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" value="3" name="shopType" id="shopType3" class="shopType">
                  全部门店适用
                </label>
              </div>
            </div>
          </div>
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
              提交
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

<?= $block('js') ?>
<script>
  require([
    'plugins/wechat-card/js/admin/cards',
    'css!plugins/wechat-card/css/admin/cards',
    'linkTo',
    'dataTable',
    'ueditor',
    'form',
    'jquery-deparam',
    'validator',
    'daterangepicker',
    'comps/bootstrap-colorselector/lib/bootstrap-colorselector-0.2.0/js/bootstrap-colorselector',
    'css!comps/bootstrap-colorselector/lib/bootstrap-colorselector-0.2.0/css/bootstrap-colorselector'
  ], function (cards) {
    cards.edit({
      data: <?= $card->toJson() ?>,
      shops: <?= $shops->toJson() ?>,
      isWechat: <?= $isWechat ? 'true' : 'false' ?>
    });
  });

  require(['linkTo'], function (linkTo) {
    var card = <?= $card->toJson() ?>;
    var newLinkTo = jQuery.extend(true,{}, linkTo);

    linkTo.init({
      $el: $('#link-to-2'),
      data: card.detail.customUrl,
      name: 'detail[customUrl]',
      hide: {
        keyword: true,
        decorator: true
      }
    });

    newLinkTo.init({
      $el: $('#link-to-1'),
      data: card.detail.centerUrl,
      name: 'detail[centerUrl]',
      hide: {
        keyword: true,
        decorator: true
      }
    });
  });

</script>
<?= $block->end() ?>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>
