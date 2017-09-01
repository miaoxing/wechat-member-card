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

        $data['member_card']['background_pic_url'] = $card['background_pic_url'];
        $data['member_card']['pay_info'] = $card['pay_info'];
        $data += [
            'supply_bonus' => (bool) $card['supply_bonus'],
            'supply_balance' => (bool) $card['supply_balance'],
            'prerogative' => $card['detail'],
            'auto_activate' => $card['activate_type'] == WechatCardRecord::ACTIVATE_TYPE_AUTO,
            'activate_url' => $card['activate_type'] == WechatCardRecord::ACTIVATE_TYPE_URL ?
                wei()->linkTo->getFullUrl($card['activate_link_to']) : '',
            'custom_cell' => $card->getWechatCustomCell(),
            'bonus_rule' => $card->getWechatBonusRule(),
            'discount' => $card->getWechatDiscount(),
        ];
    }

    public function onPreWechatUpdateCard()
    {
    }

    /**
     * 用户领取会员卡
     *
     * @param WeChatApp $app
     * @param User $user
     */
    public function onWechatUserGetCard(WeChatApp $app, User $user)
    {
        $card = wei()->wechatCard()->find(['wechat_id' => $app->getAttr('CardId')]);
        if (!$card || !$card['type'] == WechatCardRecord::TYPE_MEMBER_CARD) {
            return;
        }

        $member = wei()->member->getMember();
        if ($member) {
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
            'wechat_card_id' => $card['wechat_id'],
            'is_give_by_friend' => $app->getAttr('IsGiveByFriend'),
            'card_code' => $app->getAttr('UserCardCode'),
            'outer_str' => $app->getAttr('OuterStr'),
        ]);
    }
}
