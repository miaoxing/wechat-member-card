<?php

namespace Miaoxing\WechatMemberCard\Controller;

use miaoxing\plugin\BaseController;
use Miaoxing\WechatCard\Service\WechatCardRecord;

class WechatMemberCards extends BaseController
{
    public function detailAction($req)
    {
        $card = wei()->wechatCard()
            ->andWhere(['type' => WechatCardRecord::TYPE_MEMBER_CARD])
            ->findOneById($req['id']);

        $serviceNames = $card->getBusinessServiceNames();

        return get_defined_vars();
    }
}
