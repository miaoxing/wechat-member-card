<?php

use Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel;

$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-default" href="<?= $url('admin/wechat-pay-gift-cards') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-12">
    <form class="js-card-form form-horizontal" role="form" method="post">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="card-id">
          <span class="text-warning">*</span>
          要投放的卡
        </label>

        <div class="col-lg-4">
          <select class="form-control" id="card-id" name="cardId" required>
            <?php foreach ($cards as $card) : ?>
              <option value="<?= $card['wechat_id'] ?>"><?= $card['title'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="mch-id-list">
          <span class="text-warning">*</span>
          适用商户号
        </label>

        <div class="col-lg-4">
          <input type="text" name="mchIdList" id="mch-id-list" class="form-control" required>
        </div>

        <label class="col-lg-6 help-text" for="mch-id-list">
          1. 商户号可在"卡券功能"-"卡券投放"-"支付后赠会员卡"-"添加规则"-"适用商户号"中查看<br>
          2. 多个商户号请使用半角逗号<code>,</code>隔开<br>
          3. 每个商户号只能配置一条规则
        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="least-cost">
          <span class="text-warning">*</span>
          消费金额
        </label>

        <div class="col-lg-4">
          <div class="input-group">
            <input type="text" name="leastCost" id="least-cost" class="form-control text-center" value="0" required>
            <div class="input-group-prepend input-group-append">
              <div class="input-group-text">~</div>
            </div>
            <input type="text" name="maxCost" id="max-cost" class="form-control text-center" required>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="begin-time">
          <span class="text-warning">*</span>
          开始时间
        </label>

        <div class="col-lg-4">
          <div>
            <input type="text" class="js-begin-time form-control" name="beginTime" id="begin-time" required>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="end-time">
          <span class="text-warning">*</span>
          结束时间
        </label>

        <div class="col-lg-4">
          <div>
            <input type="text" class="js-end-time form-control" name="endTime" id="end-time" required>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="jump-link-to">
          领卡地址
        </label>

        <div class="col-lg-4">
          <p class="js-jump-link-to form-control-plaintext" id="jump-link-to"></p>
        </div>

        <label class="col-lg-6 help-text" for="jump-link-to">
          填入后点击支付即会员消息会跳转至商户网页领卡
        </label>
      </div>

      <div class="clearfix form-actions form-group">
        <input type="hidden" name="type" value="<?= WechatPayGiftCardModel::RULE_TYPE_PAY_MEMBER_CARD ?>">
        <input type="hidden" name="id" id="id">

        <div class="offset-lg-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/wechat-pay-gift-cards') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>

<script type="text/html" class="js-modal-tpl">
  <div class="modal fade" id="ret-modal" tabindex="-1" role="dialog" aria-labelledby="ret-modal-label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ret-modal-label">操作结果</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><%= message %>，存在失败的商户号：</p>
          <table class="table table-center table-hover table-bordered">
            <thead>
              <tr>
                <th>商户号</th>
                <th>错误码</th>
                <th>错误信息</th>
                <th>该商户号被占用的Appid</th>
                <th>该商户号被占用的规则编号</th>
              </tr>
            </thead>
            <tbody>
              <% for (var i in fail_mchid_list) { %>
                <tr>
                  <td><%= fail_mchid_list[i].mchid %></td>
                  <td><%= fail_mchid_list[i].errcode %></td>
                  <td><%= fail_mchid_list[i].errmsg %></td>
                  <td><%= fail_mchid_list[i].occupy_appid || '-' %></td>
                  <td><%= fail_mchid_list[i].occupy_rule_id || '-' %></td>
                </tr>
              <% } %>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
        </div>
      </div>
    </div>
  </div>
</script>

<?= $block->js() ?>
<script>
  require([
    'form',
    'plugins/link-to/js/link-to',
    'plugins/app/js/validation',
    'plugins/admin/js/range-date-time-picker',
    'plugins/app/libs/jquery.populate/jquery.populate'
  ], function (form) {
    var card = <?= $wechatPayGiftCard->toJson() ?>;

    this.$('.js-card-form')
      .populate(card)
      .ajaxForm({
        url: $.url('admin/wechat-pay-gift-cards/update'),
        dataType: 'json',
        beforeSubmit: function (arr, $form) {
          return $form.valid();
        },
        success: function (ret) {
          // 存在失败的商户号，展示出来
          if (ret.fail_mchid_list && ret.fail_mchid_list.length !== 0) {
            var $modal = $(template.compile($('.js-modal-tpl').html())(ret));
            $modal.modal('show');
            $modal.on('hidden.bs.modal', function () {
              $modal.remove();
            });
            return;
          }

          // 操作成功或常规错误则直接提示
          $.msg(ret, function () {
            if (ret.code === 1) {
              window.location.href = $.url('admin/wechat-pay-gift-cards');
            }
          });
        }
      })
      .validate();

    $('.js-jump-link-to').linkTo({
      data: card.jumpLinkTo,
      name: 'jumpLinkTo',
      hide: {
        keyword: true
      }
    });

    // 开始结束时间使用日期时间范围选择器
    $('.js-begin-time, .js-end-time').rangeDateTimePicker({
      showSecond: true,
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });
  });
</script>
<?= $block->end() ?>
