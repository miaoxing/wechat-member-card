define([
  'plugins/wechat-card/js/admin/wechat-cards',
  'assets/dateTimePicker'
], function (wechatCards) {
  var MAX_CUSTOM_FIELDS = 3;

  var WechatMemberCards = function () {
    this.$el = $('body');
    this.data = {};
  };

  WechatMemberCards.prototype.$ = function (selector) {
    return this.$el.find(selector);
  };

  WechatMemberCards.prototype.formAction = function (options) {
    $.extend(this, options);

    this.loadFormData();
    this.initFormPlugins();
    this.initFormEvents();
  };

  WechatMemberCards.prototype.loadFormData = function () {
    var that = this;
    var data = this.data;

    this.$('.js-card-form')
      .populate(data)
      .loadParams()
      .ajaxForm({
        url: $.url('admin/wechat-member-cards', {_method: data.id ? 'PUT' : 'POST'}),
        type: 'post',
        dataType: 'json',
        loading: true,
        beforeSubmit: function (arr, $form) {
          if (!$form.valid()) {
            return false;
          }

          if (!that.$('.js-logo-url').val()) {
            that.$('.js-logo-file').focus();
            $.err('请上传商户Logo');
            return false;
          }

          if (that.$('.js-cover-type:checked').val() === '0'
            && !that.$('.js-background-pic-url').val()) {
            that.$('.js-background-pic-file').focus();
            $.err('请上传卡券封面');
            return false;
          }

          // 编辑时，仅支持扩大有效期的固定日期
          if (!wechatCards.checkDateInfo(data)) {
            return false;
          }

          return true;
        },
        success: function (ret) {
          // 保存失败,固定弹层展示
          if (ret.code !== 1) {
            $.alert(ret.message);
            return;
          }

          // 保存成功,头部提示并自动跳转
          $.msg(ret, function () {
            window.location = $.url('admin/wechat-member-cards');
          });
        }
      })
      .validate();

    this.changeCustomField();
    wechatCards.initEditStatus(data);
  };

  WechatMemberCards.prototype.initFormEvents = function () {
    var that = this;

    wechatCards.initCollapse();

    // 五个类目最多选择三个
    this.$('.js-custom-field').change(function () {
      that.changeCustomField();
    });

    // 选中某个值，显示/隐藏某区域
    this.$('.js-toggle-display').toggleDisplay();
  };

  WechatMemberCards.prototype.changeCustomField = function () {
    this.$('.js-custom-field.js-editable:unchecked').prop('disabled', this.$('.js-custom-field:checked').length >= MAX_CUSTOM_FIELDS);
  };

  WechatMemberCards.prototype.initFormPlugins = function () {
    wechatCards.initWechatMediaUpload(this.$('.js-logo-file'));
    wechatCards.initWechatMediaUpload(this.$('.js-background-pic-file'));
    wechatCards.initColor();
    wechatCards.initDateRange(this.data);
    wechatCards.initLinkTo(this.data);
    wechatCards.iniTextImageList(this.data);

    this.$('.js-tooltips').tooltip({
      container: 'body'
    });

    this.$('.js-activate-end-time, .js-modify-end-time').datetimepicker({
      showSecond: true,
      timeFormat: 'hh:mm:ss'
    });

    this.$('.js-activate-card-id-list, .js-modify-card-id-list').select2({
      maximumSelectionSize: 10
    });
  };

  return new WechatMemberCards();
});
