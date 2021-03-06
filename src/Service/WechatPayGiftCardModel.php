<?php

namespace Miaoxing\WechatMemberCard\Service;

use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Plugin\Model\HasAppIdTrait;
use Miaoxing\WechatCard\Service\WechatCardRecord;
use Miaoxing\WechatMemberCard\Metadata\WechatPayGiftCardTrait;

/**
 * @property WechatCardRecord $wechatCard
 */
class WechatPayGiftCardModel extends BaseModelV2
{
    use WechatPayGiftCardTrait;
    use HasAppIdTrait;

    const RULE_TYPE_PAY_MEMBER_CARD = 1;

    protected $defaultCasts = [
        'jump_link_to' => 'array',
    ];

    protected $typeNames = [
        self::RULE_TYPE_PAY_MEMBER_CARD => 'RULE_TYPE_PAY_MEMBER_CARD',
    ];

    public function getTypeName()
    {
        return $this->typeNames[$this['type']];
    }

    public function wechatCard()
    {
        return $this->belongsTo(wei()->wechatCard(), 'wechat_id', 'card_id');
    }
}
