<?php


$view->layout();
?>

<?= $block('header-actions') ?>
<a class="btn btn-success" href="<?= $url('admin/wechat-pay-gift-cards/new') ?>">添加规则</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">

      <table class="js-card-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>编号</th>
          <th>规则编号</th>
          <th>适用商户号</th>
          <th>投放会员卡</th>
          <th>消费金额</th>
          <th>有效期</th>
          <th>创建时间</th>
          <th>操作</th>
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

<script id="action-tpl" type="text/html">
  <a class="delete-record text-danger" href="javascript:"
    data-href="<%= $.url('admin/wechat-pay-gift-cards/%s/destroy', id) %>">删除</a>
</script>

<?= $block->js() ?>
<script>
  require(['form', 'plugins/admin/js/data-table'], function (form) {
    var $table = this.$('.js-card-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/wechat-pay-gift-cards.json')
      },
      columns: [
        {
          data: 'id',
          visible: false
        },
        {
          data: 'ruleId'
        },
        {
          data: 'mchIdList'
        },
        {
          data: 'wechatCard.title'
        },
        {
          data: 'leastCost',
          render: function (data, type, full) {
            return data + '~' + full.maxCost;
          }
        },
        {
          data: 'beginTime',
          render: function (data, type, full) {
            return data.substr(0, 10) + ' ~ ' + full.endTime.substr(0, 10);
          }
        },
        {
          data: 'createdAt'
        },
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data, type, full) {
            return template.render('action-tpl', full);
          }
        }
      ]
    });

    $table.deletable();
  });
</script>
<?= $block->end() ?>
