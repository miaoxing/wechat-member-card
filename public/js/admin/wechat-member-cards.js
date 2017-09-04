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
  var DELAY_SLOW = 5000;

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
          if (!$form.valid()) {
            return false;
          }

          if (!that.$('.js-logo-url').val()) {
            that.$('.js-logo-file').focus();
            $.err('请上传商家Logo');
            return false;
          }

          if (that.$('.js-cover-type:checked').val() === '0'
            && !that.$('.js-background-pic-url').val()) {
            that.$('.js-background-pic-file').focus();
            $.err('请上传卡券封面');
            return false;
          }

          // 编辑时，仅支持扩大有效期的固定日期
          var data = that.data;
          var dateInfo = data.date_info;
          if (data.wechat_id // 编辑状态
            && parseInt(dateInfo.type, 10) === DATE_TYPE_FIX_TIME_RANGE
            && (moment(dateInfo.begin_time) < moment(that.$('.js-start-date').val())
              || moment(dateInfo.end_time) > moment(that.$('.js-end-date').val())
            )
          ) {
            that.$('.js-date-range').focus();
            $.err('固定日期的范围应该大于 ' + dateInfo.begin_time + ' ~ ' + dateInfo.end_time, DELAY_SLOW);
            return false;
          }

          return true;
        },
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.data && ret.data.id) {
              that.$('.js-id').val(ret.data.id);
            }

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

    this.changeCustomField();

    // 编辑状态，显示编辑提醒，禁用不可编辑的控件
    if (data.wechat_id) {
      this.$('.js-add-article').hide();
      this.$('.js-edit-tips').show();
      this.$('.js-card-form :input:not(.js-editable):not([type=submit])').prop('disabled', true);
    }
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
    this.$('.js-custom-field').change(function () {
      that.changeCustomField();
    });

    // 选中某个值，显示/隐藏某区域
    this.$('.js-toggle-display').toggleDisplay();
  };

  WechatMemberCards.prototype.addArticleItem = function (data) {
    data = data || {};
    data.id = data.id || $.guid++;
    data.disable = !!this.data.wechat_id;

    var $tpl = $(this.$articleItemTpl(data));

    var $url = $tpl.find('.js-article-url');
    $url.imageUploadInput();
    this.createWechatMediaAfterUpload($url);

    this.$('.js-article-list').append($tpl);
  };

  /**
   * 在图片上传之后，再异步上传到微信资源库
   */
  WechatMemberCards.prototype.createWechatMediaAfterUpload = function ($input) {
    $input.on('fileuploaded', function (event, data) {
      $.ajax({
        url: $.url('admin/wechat-medias/create'),
        type: 'post',
        dataType: 'json',
        data: {
          url: data.response.url
        }
      });
    });
  };

  WechatMemberCards.prototype.changeCustomField = function () {
    this.$('.js-custom-field.js-editable:unchecked').prop('disabled', this.$('.js-custom-field:checked').length >= MAX_CUSTOM_FIELDS);
  };

  WechatMemberCards.prototype.changeDateInfoType = function (type) {
    this.$('.js-date-range').prop('disabled', type != DATE_TYPE_FIX_TIME_RANGE);
  };

  WechatMemberCards.prototype.initFormPlugins = function () {
    var that = this;
    var data = this.data;

    // 商家Logo
    var $logoFile = this.$('.js-logo-file');
    $logoFile.imageUploadInput();
    this.createWechatMediaAfterUpload($logoFile);

    // 卡券封面图片
    var $picFile = this.$('.js-background-pic-file');
    $picFile.imageUploadInput();
    this.createWechatMediaAfterUpload($picFile);

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
