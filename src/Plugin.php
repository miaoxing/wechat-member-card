<?php

namespace Miaoxing\WechatMemberCard;

use Miaoxing\Plugin\BasePlugin;
use Miaoxing\WechatCard\Service\WechatCardRecord;

class Plugin extends BasePlugin
{
    /**
     * {@inheritdoc}
     */
    protected $name = '微信会员卡';

    /**
     * {@inheritdoc}
     */
    protected $description = '微信会员卡';

    protected $adminNavId = 'member';

    /**
     * 创建会员卡之前，附加会员卡的资料
     *
     * @param WechatCardRecord $card
     * @param $data
     */
    public function onPreWechatCreateCard(WechatCardRecord $card, &$data)
    {
        if ($card['type'] != WechatCardRecord::TYPE_MEMBER_CARD) {
            return;
        }

        $data = wei()->wechatMemberCard->addWechatCardData($card, $data);
    }

    public function onPreWechatUpdateCard(WechatCardRecord $card, &$data, $req)
    {
        if ($card['type'] != WechatCardRecord::TYPE_MEMBER_CARD) {
            return;
        }

        $data = wei()->wechatMemberCard->addWechatCardData($card, $data);
        $data = wei()->wechatCard->filterUnchangedAuditData($card, $data, [
            'supply_bonus', 'supply_balance', 'discount',
        ]);
    }

    public function onWechatCardSyncMemberCard(WechatCardRecord $card, array $data)
    {
        $baseInfo = $data['member_card']['base_info'];
        // TODO 更多信息
        $card->setData([
            'supply_bonus' => (bool) $baseInfo['supply_bonus'],
            'prerogative' => $baseInfo['prerogative'],
        ]);
    }

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $navs[] = [
            'parentId' => 'member-setting',
            'url' => 'admin/wechat-member-cards',
            'name' => '会员卡管理',
            'sort' => 1000,
        ];

        $navs[] = [
            'parentId' => 'member-setting',
            'url' => 'admin/wechat-pay-gift-cards',
            'name' => '支付后赠会员卡',
            'sort' => 1000,
        ];
    }
}
