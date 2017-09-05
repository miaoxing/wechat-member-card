<?php

namespace Miaoxing\WechatMemberCard;

use Miaoxing\Member\Service\MemberRecord;
use miaoxing\plugin\BasePlugin;
use Miaoxing\Plugin\Service\User;
use Miaoxing\WechatCard\Service\WechatCardRecord;
use Wei\WeChatApp;

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

    /**
     * 用户领取会员卡
     *
     * @param WeChatApp $app
     * @param User $user
     */
    public function onWechatUserGetCard(WeChatApp $app, User $user)
    {
        $this->logger->info('收到领卡事件', $app->getAttrs());

        $card = wei()->wechatCard()->find(['wechat_id' => $app->getAttr('CardId')]);
        if (!$card || $card['type'] != WechatCardRecord::TYPE_MEMBER_CARD) {
            return;
        }

        $member = wei()->member()->curApp()->findOrInit([
            'card_id' => $card['id'],
            'user_id' => $user['id'],
        ]);
        if (!$member->isNew()) {
            $this->logger->info('用户已有会员卡', $app->getAttrs());

            return;
        }

        // 如果是赠送,设置原来的卡号为无效
        if ($app->getAttr('IsGiveByFriend')) {
            $friendMember = wei()->member()->find(['card_code' => $app->getAttr('OldUserCardCode')]);
            /** @var MemberRecord $friendMember */
            if ($friendMember) {
                $friendMember->softDelete();
            } else {
                $this->logger->warning('找不到赠送用户的原始会员卡', $app->getAttrs());
            }
        }

        /** @var MemberRecord $member */
        $member->save([
            'card_id' => $card['id'],
            'card_wechat_id' => $card['wechat_id'],
            'code' => $app->getAttr('UserCardCode'),
            'membership_number' => $app->getAttr('UserCardCode'), // TODO 是否为同一个
            'wechat_open_id' => $user['wechatOpenId'],
            'is_give_by_friend' => $app->getAttr('IsGiveByFriend'),
            'outer_str' => (string) $app->getAttr('OuterStr'),
            'level_id' => wei()->setting->getValue('member.init_level_id', 0),
            'score' => (int) $card['bonus_rule']['init_increase_bonus'],
            'total_score' => (int) $card['bonus_rule']['init_increase_bonus'],
        ]);
    }
}
