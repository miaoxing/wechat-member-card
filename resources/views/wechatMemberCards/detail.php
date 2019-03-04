<?php

$view->layout();
?>

<div class="container-fluid list list-condensed list-borderless">
  <div class="row list-item">
    <div class="col-12 text-lg">
      会员卡详情
    </div>
  </div>
  <div class="row list-item">
    <div class="col-4 text-muted">特权说明</div>
    <div class="col-8">
      <?= $e($card['detail']) ?>
    </div>
  </div>
  <div class="row list-item">
    <label class="col-4 text-muted">有效日期</label>
    <div class="col-8">
      <?= $card->getDateText() ?>
    </div>
  </div>
  <?php if ($card['service_phone']) : ?>
    <div class="row list-item">
      <div class="col-4 text-muted">电话</div>
      <div class="col-8">
        <?= $card['service_phone'] ?>
      </div>
    </div>
  <?php endif ?>
  <?php if ($card['business_service']) : ?>
    <div class="row list-item">
      <label class="col-4 text-muted">商户服务</label>

      <div class="col-8">
        <?php foreach ($card['business_service'] as $service) : ?>
          <span class="badge badge-success"><?= $serviceNames[$service] ?></span>
        <?php endforeach ?>
      </div>
    </div>
  <?php endif ?>
  <?php if ($card['description']) : ?>
    <div class="row list-item">
      <div class="col-4 text-muted">使用须知</div>
      <div class="col-8">
        <?= $card['description'] ?>
      </div>
    </div>
  <?php endif ?>
</div>
