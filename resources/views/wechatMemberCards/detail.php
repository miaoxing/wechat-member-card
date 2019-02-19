<?php

$view->layout();
?>

<div class="container-fluid text-sm bg-light">
  <div class="ml-3">
  <div class="row list-header">
    <h4 class="list-heading">
      会员卡详情
    </h4>
  </div>
  <div class="row pb-2">
    <label class="col-3 list-label text-muted">特权说明</label>
    <div class="col-9 list-content">
      <?= $e($card['detail']) ?>
    </div>
  </div>
  <div class="row pb-2">
    <label class="col-3 list-label text-muted">有效日期</label>

    <div class="col-9 list-content">
      <?= $card->getDateText() ?>
    </div>
  </div>
  <?php if ($card['service_phone']) : ?>
    <div class="row pb-2">
      <div class="col-3 list-label text-muted">电话</div>
      <div class="col-9 list-content">
        <?= $card['service_phone'] ?>
      </div>
    </div>
  <?php endif ?>
  <?php if ($card['business_service']) : ?>
    <div class="row pb-2">
      <label class="col-3 list-label text-muted">商户服务</label>

      <div class="col-9 list-content">
        <?php foreach ($card['business_service'] as $service) : ?>
          <span class="badge badge-success"><?= $serviceNames[$service] ?></span>
        <?php endforeach ?>
      </div>
    </div>
  <?php endif ?>
  <?php if ($card['description']) : ?>
    <div class="row pb-2">
      <div class="col-3 list-label text-muted">使用须知</div>
      <div class="col-9 list-content">
        <?= $card['description'] ?>
      </div>
    </div>
  <?php endif ?>
  </div>
</div>
