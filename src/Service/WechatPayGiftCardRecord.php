<?php

namespace Miaoxing\WechatMemberCard\Service;

use miaoxing\plugin\BaseModel;
use Miaoxing\Plugin\Traits\CamelCase;
use Miaoxing\WechatCard\Service\WechatCardRecord;

/**
 * @property WechatCardRecord $wechatCard
 */
class WechatPayGiftCardRecord extends BaseModel
{
    use CamelCase;

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

    protected $typeNames = [
        self::RULE_TYPE_PAY_MEMBER_CARD => 'RULE_TYPE_PAY_MEMBER_CARD',
    ];

    public function afterFind()
    {
        parent::afterFind();

        $this['jumpLinkTo'] = (array) json_decode($this['jumpLinkTo'], true);
    }

    public function beforeSave()
    {
        parent::beforeSave();

        $this['jumpLinkTo'] = json_encode($this['jumpLinkTo']);
    }

    public function getTypeName()
    {
        return $this->typeNames[$this['type']];
    }

    public function wechatCard()
    {
        return $this->belongsTo('wechatCard', 'wechat_id', 'cardId');
    }
}
