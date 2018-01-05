<?php

namespace Miaoxing\WechatMemberCard\Metadata;

/**
 * WechatPayGiftCardTrait
 *
 * @property int $id
 * @property int $appId
 * @property int $ruleId
 * @property int $type
 * @property string $mchIdList
 * @property string $beginTime
 * @property string $endTime
 * @property string $cardId
 * @property float $leastCost
 * @property float $maxCost
 * @property array $jumpLinkTo
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $deletedAt
 * @property int $deletedBy
 */
trait WechatPayGiftCardTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'app_id' => 'int',
        'rule_id' => 'int',
        'type' => 'int',
        'mch_id_list' => 'string',
        'begin_time' => 'datetime',
        'end_time' => 'datetime',
        'card_id' => 'string',
        'least_cost' => 'float',
        'max_cost' => 'float',
        'jump_link_to' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_at' => 'datetime',
        'deleted_by' => 'int',
    ];
}
