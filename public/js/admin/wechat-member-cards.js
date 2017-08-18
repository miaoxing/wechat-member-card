define([
  'template',
  'css!plugins/wechat-card/css/admin/cards.css',
  'form',
  'jquery-deparam',
  'validator',
  'plugins/admin/js/image-input',
  'comps/bootstrap-colorselector/lib/bootstrap-colorselector-0.2.0/js/bootstrap-colorselector',
  'css!comps/bootstrap-colorselector/lib/bootstrap-colorselector-0.2.0/css/bootstrap-colorselector',
  'daterangepicker',
  'linkTo',
  'plugins/app/libs/jquery.populate/jquery.populate',
  'plugins/app/libs/jquery-toggle-display/jquery-toggle-display'
], function (template) {
  var DATE_TYPE_FIX_TIME_RANGE = 1;
  var DATE_TYPE_FIX_TERM = 2;
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

    this.$articleItemTpl = template.compile(this.$('.js-article-item-tpl').html());

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
        beforeSubmit: function (arr, $form) {
          return $form.valid();
        },
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.code === 1) {
              window.location = $.url('admin/wechat-member-cards');
            }
          });
        }
      })
      .validate();
    if (data.date_info.begin_time != null && data.date_info.begin_time != '0000-00-00 00:00:00') {
      this.$('.js-date-range').val(data.date_info.begin_time.substr(0, 10) + ' ~ ' + data.date_info.end_time.substr(0, 10));
    }

    this.changeDateInfoType(data.date_info.type);

    $.each(data.text_image_list, function (i, row) {
      that.addArticleItem(row);
    });
  };

  WechatMemberCards.prototype.initFormEvents = function () {
    var that = this;

    this.$('.js-date-info-type').change(function () {
      that.changeDateInfoType($(this).val());
    });

    this.$('.js-add-article').click(function () {
      that.addArticleItem();
    });

    this.$el.on('click', '.js-remove-article', function () {
       $(this).closest('.js-article-item').remove();
    });

    // 开关时，更新按钮文案
    this.$('.js-collapse')
      .on('show.bs.collapse', function () {
        var $trigger = $('[data-toggle="collapse"][href="#' + $(this).attr('id') + '"]');
        $trigger.data('show-text', $trigger.html());
        $trigger.html($trigger.data('hide-text'));
      })
      .on('hide.bs.collapse', function () {
        var $trigger = $('[data-toggle="collapse"][href="#' + $(this).attr('id') + '"]');
        $trigger.html($trigger.data('show-text'));
      });

    // 五个类目最多选择三个
    this.$('.js-field').change(function () {
      that.$('.js-field:unchecked').prop('disabled', that.$('.js-field:checked').length >= MAX_CUSTOM_FIELDS);
    });

    // 选中某个值，显示/隐藏某区域
    this.$('.js-toggle-display').toggleDisplay();
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

  WechatMemberCards.prototype.changeDateInfoType = function (type) {
    this.$('.js-date-range').prop('disabled', type != DATE_TYPE_FIX_TIME_RANGE);
  };

  WechatMemberCards.prototype.initFormPlugins = function () {
    var that = this;
    var data = this.data;

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
      format: 'YYYY-MM-DD',
      separator: ' ~ '
    }, function (start, end) {
      that.$('.js-start-date').val(start.format(this.format));
      that.$('.js-end-date').val(end.format(this.format));
      this.element.trigger('change');
    });

    this.$('.js-tooltips').tooltip({
      container: 'body'
    });

    var regex = /^([a-z0-9_]+)\[([a-z0-9_]+)\]$/;
    this.$('.js-link-to').each(function () {
      var $this = $(this);
      var name = $this.data('name');
      var value;

      // 适配单个和数组的情况 abc[def]
      var result = name.match(regex);
      if (result && result.length === 3) {
        value = data[result[1]] ? data[result[1]][result[2]] : {};
      } else {
        value = data[name];
      }

      $this.linkTo({
        data: value,
        name: name,
        hide: {
          keyword: true,
          decorator: true
        }
      });
    });
  };

  return new WechatMemberCards();
});
