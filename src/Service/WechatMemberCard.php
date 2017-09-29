<?php

namespace Miaoxing\WechatMemberCard\Service;

use miaoxing\plugin\BaseService;
use Miaoxing\WechatCard\Service\WechatCardRecord;

class WechatMemberCard extends BaseService
{
    public function addWechatCardData(WechatCardRecord $card, $data)
    {
        // TODO 使用ret形式
        if ($card['background_pic_url']) {
            $backgroundPicUrl = wei()->wechatMedia->updateUrlToWechatUrl($card['background_pic_url']);
        } else {
            $backgroundPicUrl = '';
        }

        $data['member_card'] += [
            'background_pic_url' => $backgroundPicUrl,

            'supply_bonus' => (bool) $card['supply_bonus'],
            'bonus_url' => wei()->wechatCard->getUrl($card['bonus_link_to']),
            'bonus_cleared' => $card['bonus_cleared'],
            'bonus_rules' => $card['bonus_rules'],
            'bonus_rule' => $card->getWechatBonusRule(),

            'supply_balance' => (bool) $card['supply_balance'],
            'balance_url' => wei()->wechatCard->getUrl($card['balance_link_to']),
            'balance_rules' => $card['balance_rules'],

            'prerogative' => $card['detail'],

            'auto_activate' => $card['activate_type'] == WechatCardRecord::ACTIVATE_TYPE_AUTO,
            'wx_activate' => $card['activate_type'] == WechatCardRecord::ACTIVATE_TYPE_WX_ACTIVATE,
            'activate_url' => $card->getActivateUrl(),

            'custom_cell1' => $card->getWechatCustomCell(),
            'discount' => $card->getWechatDiscount(),

            'modify_msg_operation' => $card->getWechatMsgOperation('modify'),
            'activate_msg_operation' => $card->getWechatMsgOperation('activate'),
        ];

        $index = 1;
        foreach ([1, 2, 3] as $key) {
            if (!$card['custom_field' . $key]['enable']) {
                continue;
            }
            $data['member_card'] += ['custom_field' . $index => $card->getWechatCustomField($key)];
            ++$index;
        }

        return $data;
    }
}
