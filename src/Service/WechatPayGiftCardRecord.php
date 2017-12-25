<?php

namespace Miaoxing\WechatMemberCard\Service;

use miaoxing\plugin\BaseModel;
use Miaoxing\WechatCard\Service\WechatCardRecord;

/**
 * @property WechatCardRecord $wechatCard
 */
class WechatPayGiftCardRecord extends BaseModel
{
    const RULE_TYPE_PAY_MEMBER_CARD = 1;

    protected $table = 'wechat_pay_gift_cards';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $appIdColumn = 'app_id';

    protected $createdAtColumn = 'created_at';

    protected $updatedAtColumn = 'updated_at';

    protected $createdByColumn = 'created_by';

    protected $updatedByColumn = 'updated_by';

    protected $deletedAtColumn = 'deleted_at';

    protected $deletedByColumn = 'deleted_by';

    protected $camel = true;

    protected $typeNames = [
        self::RULE_TYPE_PAY_MEMBER_CARD => 'RULE_TYPE_PAY_MEMBER_CARD',
    ];

    public function afterFind()
    {
        parent::afterFind();

        $this['jump_link_to'] = (array) json_decode($this['jump_link_to'], true);
    }

    public function beforeSave()
    {
        parent::beforeSave();

        $this['jump_link_to'] = json_encode($this['jump_link_to']);
    }

    public function getTypeName()
    {
        return $this->typeNames[$this['type']];
    }

    public function wechatCard()
    {
        return $this->belongsTo('wechatCard', 'wechat_id', 'card_id');
    }
}
