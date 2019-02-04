<?php

$view->layout();
?>

<div class="container-fluid">
  <div class="row">
    <ul class="list list-sm list-condensed list-borderless text-normal">
      <li class="list-item list-header">
        <h4 class="list-heading">
          会员卡详情
        </h4>
      </li>
      <li class="list-item">
        <label class="col-xs-3 list-label text-muted">特权说明</label>

        <div class="col-xs-9 list-content">
          <?= $e($card['detail']) ?>
        </div>
      </li>
      <li class="list-item">
        <label class="col-xs-3 list-label text-muted">有效日期</label>

        <div class="col-xs-9 list-content">
          <?= $card->getDateText() ?>
        </div>
      </li>
      <?php if ($card['service_phone']) : ?>
        <li class="list-item">
          <div class="col-xs-3 list-label text-muted">电话</div>
          <div class="col-xs-9 list-content">
            <?= $card['service_phone'] ?>
          </div>
        </li>
      <?php endif ?>
      <?php if ($card['business_service']) : ?>
        <li class="list-item">
          <label class="col-xs-3 list-label text-muted">商户服务</label>

          <div class="col-xs-9 list-content">
            <?php foreach ($card['business_service'] as $service) : ?>
              <span class="badge badge-success"><?= $serviceNames[$service] ?></span>
            <?php endforeach ?>
          </div>
        </li>
      <?php endif ?>
      <?php if ($card['description']) : ?>
        <li class="list-item">
          <div class="col-xs-3 list-label text-muted">使用须知</div>
          <div class="col-xs-9 list-content">
            <?= $card['description'] ?>
          </div>
        </li>
      <?php endif ?>
    </ul>
  </div>
</div>
