<?php

namespace Miaoxing\WechatMemberCard\Service;

use miaoxing\plugin\BaseService;
use Miaoxing\WechatCard\Service\WechatCardRecord;

class WechatMemberCard extends BaseService
{
    public function addWechatCardData(WechatCardRecord $card, $data)
    {
        $data['member_card'] += [
            'background_pic_url' => $card['background_pic_url'],

            'supply_bonus' => (bool) $card['supply_bonus'],
            'bonus_url' => wei()->linkTo->getFullUrl($card['bonus_link_to']),
            'bonus_cleared' => $card['bonus_cleared'],
            'bonus_rules' => $card['bonus_rules'],
            'bonus_rule' => $card->getWechatBonusRule(),

            'supply_balance' => (bool) $card['supply_balance'],
            'balance_url' => wei()->linkTo->getFullUrl($card['balance_link_to']),
            'balance_rules' => $card['balance_rules'],

            'prerogative' => $card['detail'],

            'auto_activate' => $card['activate_type'] == WechatCardRecord::ACTIVATE_TYPE_AUTO,
            'wx_activate' => $card['activate_type'] == WechatCardRecord::ACTIVATE_TYPE_WX_ACTIVATE,
            'activate_url' => $card->getActivateUrl(),

            'custom_cell1' => $card->getWechatCustomCell(),
            'discount' => $card->getWechatDiscount(),
        ];

        $index = 1;
        foreach ([1, 2, 3] as $key) {
            if (!$card['custom_field' . $key]['enable']) {
                continue;
            }
            $data['member_card'] += ['custom_field' . $index => $card->getWechatCustomField($key)];
            $index++;
        }

        return $data;
    }
}
