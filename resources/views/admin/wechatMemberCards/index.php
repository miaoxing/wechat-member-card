<?php

$view->layout();
$statType = wei()->member->statType ? (wei()->member->statType . '-') : '';
?>

<?= $block('header-actions') ?>
<a class="btn btn-success" href="<?= $url('admin/wechat-member-cards/new') ?>">新建会员卡</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <table class="js-card-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>会员卡</th>
          <th>来源</th>
          <th>状态</th>
          <th>创建时间</th>
          <th class="t-8">操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<!-- Modal -->
<div class="modal fade" id="send-out-modal" tabindex="-1" role="dialog" aria-labelledby="card-type-modal-label"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="card-type-modal-label">投放卡券</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="text-center">你可以通过以下方式投放卡券</h5>

        <!--<div class="radio radio-lg offset-2">
            <label>
                <input type="radio" name="type" class="sendOut" id="sendOut1" value="1">
                直接群发卡券
            </label>
            <label class="text-muted block" for="sendOut1">通过公众号消息，直接投放</label>
        </div>

        <div class="radio radio-lg offset-2">
            <label>
                <input type="radio" name="type" class="sendOut" id="sendOut2" value="2">
                嵌入图文消息
            </label>
            <label class="text-muted block" for="sendOut2">将卡券嵌入图文消息，再由公众号投放</label>
        </div>-->

        <div class="radio radio-lg offset-2">
          <label>
            <input type="radio" name="type" class="sendOut" id="sendOut3" value="3" checked>
            下载二维码
          </label>
          <label class="text-muted d-block" for="sendOut3">下载卡券二维码，通过打印张贴或其他渠道发放</label>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="confirm-send-out">确定</button>
      </div>
    </div>
  </div>
</div>

<script id="table-actions" type="text/html">
  <div class="action-links">
    <a href="<%= $.url('admin/member-<?= $statType ?>stats/show', {card_id: id}) %>">
      统计
    </a>
    <a href="<%= $.url('admin/wechat-member-cards/%s/edit', id) %>">
      编辑
    </a>
  </div>
</script>

<?= $block->js() ?>
<script>
  require(['plugins/admin/js/data-table', 'form', 'jquery-unparam'], function () {
    var recordTable = $('.js-card-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/wechat-member-cards.json')
      },
      columns: [
        {
          data: 'title'
        },
        {
          data: 'source_name'
        },
        {
          data: 'status_name',
          render: function (data, type, full) {
            return full.audit == 2 ? (data + '：' + full.audit_message) : data;
          }
        },
        {
          data: 'created_at',
        },
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data, type, full) {
            return template.render('table-actions', full);
          }
        }
      ]
    });

    recordTable.deletable('.delete-record', '删除后,已领取的卡券仍然有效,确认删除?');

    $('#search-form').update(function () {
      recordTable.reload($(this).serialize(), false);
    });

    // 投放
    var sendOutId;
    recordTable.on('click', '.send-out', function () {
      sendOutId = $(this).data('id');
      $('#send-out-modal').modal('show');
    });

    // 确定投放
    $('#confirm-send-out').click(function () {
      $.getJSON($.url('admin/cards/%s/qrcode', sendOutId), function (result) {
        if (result.code < 1) {
          $.msg(result);
        } else {
          var a = $('<a download>')
            .attr('href', result.url)
            .appendTo('body');
          a[0].click();
          a.remove();
        }
      });
    });
  });
</script>
<?= $block->end() ?>
