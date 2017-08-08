define([
  'template',
  'plugins/admin/js/image-input',
  'comps/bootstrap-colorselector/lib/bootstrap-colorselector-0.2.0/js/bootstrap-colorselector',
  'css!comps/bootstrap-colorselector/lib/bootstrap-colorselector-0.2.0/css/bootstrap-colorselector',
  'daterangepicker',
  'linkTo'
], function (template) {
  var COVER_TYPE_IMAGE = 0;
  var COVER_TYPE_COLOR = 1;
  var DATE_TYPE_FIX_TIME_RANGE = 1;
  var DATE_TYPE_FIX_TERM = 2;
  var MAX_CUSTOM_FIELDS = 3;
  var CUSTOM_FIELD_NAMES = {
    1: '一',
    2: '二',
    3: '三'
  };

  var WechatMemberCards = function () {
    this.$el = $('body');
    this.data = {};
  };

  WechatMemberCards.prototype.$ = function (selector) {
    return this.$el.find(selector);
  };

  WechatMemberCards.prototype.formAction = function (options) {
    $.extend(this, options);

    this.$articleItemTpl = template.compile(this.$('.js-article-item-tpl').html());
    this.$customFieldItemTpl = template.compile(this.$('.js-custom-field-item-tpl').html());
    this.$addCustomField = this.$('.js-add-custom-field');

    this.initFormPlugins();
    this.initFormEvents();
    this.loadFormData();
  };

  WechatMemberCards.prototype.loadFormData = function () {
    //this.changeShopType(data.shopType);
    //this.changeCoverType(this.data.coverType);
  };

  WechatMemberCards.prototype.initFormEvents = function () {
    var that = this;

    this.$('.js-cover-type').change(function () {
      that.changeCoverType($(this).val());
    });

    this.$('.js-date-type').change(function () {
      that.changeDateType($(this).val());
    });

    this.$('.js-time-limit-type').change(function () {
      that.changeTimeLimitType($(this).val());
    });

    this.$('.js-supply-bonus').change(function () {
      that.$('.js-bonus-form-groups').toggle($(this).prop('checked'));
    });

    this.$('.js-supply-discount').change(function () {
      that.$('.js-discount-form-groups').toggle($(this).prop('checked'));
    });

    this.$('.js-add-article').click(function () {
      that.addArticleItem();
    });

    this.$el.on('click', '.js-remove-article', function () {
       $(this).closest('.js-article-item').remove();
    });

    this.$addCustomField.click(function () {
      that.addCustomFieldItem();
    });

    this.$el.on('click', '.js-remove-custom-field', function () {
      that.removeCustomFieldItem(this);
    });

    // 适用门店
    this.$('.js-shop-type').change(function () {
      that.changeShopType(this.value);
    });
  };

  WechatMemberCards.prototype.changeShopType = function (type) {
    if (type == '1') {
      this.$('.js-shop-type-1').show();
    } else {
      this.$('.js-shop-type-1').hide();
    }
  };

  WechatMemberCards.prototype.addArticleItem = function (data) {
    data = data || {};
    data.id = data.id || $.guid++;

    var $tpl = $(this.$articleItemTpl(data));

    $tpl.find('.js-article-url').imageUploadInput({
      uploadUrl: $.url('admin/wechat-medias/upload-img')
    });

    this.$('.js-article-list').append($tpl);
  };

  WechatMemberCards.prototype.addCustomFieldItem = function (data) {
    data = data || {};

    var count = this.$('.js-custom-field-item').length;
    if (count >= MAX_CUSTOM_FIELDS) {
      $.warning('最多只能添加' + MAX_CUSTOM_FIELDS + '个自定义入口');
      return;
    }

    data.name = CUSTOM_FIELD_NAMES[count + 1];
    var $tpl = $(this.$customFieldItemTpl(data));
    $tpl.find('.js-custom-field-link-to').linkTo({
      data: {},
      name: 'dd',
      hide: {
        keyword: true,
        decorator: true
      }
    });

    this.$('.js-custom-field-list').append($tpl);

    if (count + 1 >= MAX_CUSTOM_FIELDS) {
      this.$addCustomField.prop('disabled', true);
    }
  };

  WechatMemberCards.prototype.removeCustomFieldItem = function (el) {
    $(el).closest('.js-custom-field-item').remove();

    var count = this.$('.js-custom-field-item').length;
    if (count < MAX_CUSTOM_FIELDS) {
      this.$addCustomField.prop('disabled', false);
    }

    // 更新入口的标题
    this.$('.js-custom-field-title').each(function (index) {
      $(this).html('入口' + CUSTOM_FIELD_NAMES[index + 1]);
    });
  };

  WechatMemberCards.prototype.changeDateType = function (type) {
    this.$('.js-date-range').prop('disabled', type != DATE_TYPE_FIX_TIME_RANGE);
  };

  WechatMemberCards.prototype.changeCoverType = function (type) {
    if (type == COVER_TYPE_IMAGE) {
      this.$('.js-cover-type-image').show();
      this.$('.js-cover-type-color').hide();
    } else {
      this.$('.js-cover-type-image').hide();
      this.$('.js-cover-type-color').show();
    }
  };

  WechatMemberCards.prototype.changeTimeLimitType = function (type) {
    if (type == 'part') {
      this.$('.js-time-limit-type-part').show();
    } else {
      this.$('.js-time-limit-type-part').hide();
    }
  };

  WechatMemberCards.prototype.initFormPlugins = function () {
    var that = this;

    // 商家Logo
    this.$('.js-logo-url').imageUploadInput({
      uploadUrl: $.url('admin/wechat-medias/upload-img')
    });

    // 卡券封面图片
    this.$('.js-background-pic-url').imageUploadInput({
      uploadUrl: $.url('admin/wechat-medias/upload-img')
    });

    this.$('.js-color').colorselector();

    // 日期范围选择
    this.$('.js-date-range').daterangepicker({
      format: 'YYYY.MM.DD',
      separator: '~'
    }, function (start, end) {
      that.$('.js-start-date').val(start.format(this.format));
      that.$('.js-end-date').val(end.format(this.format));
      this.element.trigger('change');
    });

    this.$('.js-tooltips').tooltip({
      container: 'body'
    });
  };

  return new WechatMemberCards();
});
