<?php

namespace Miaoxing\WechatMemberCard\Service;

use miaoxing\plugin\BaseService;
use Wei\RetTrait;

class WechatPayGiftCard extends BaseService
{
    use RetTrait;

    public function __invoke()
    {
        return wei()->wechatPayGiftCardRecord();
    }

    public function save($req)
    {
        // 1. 初始化规则
        $card = wei()->wechatPayGiftCard()->curApp()->notDeleted()->findId($req['id']);
        $card->fromArray($req);

        // 2. 同步到微信
        $account = wei()->wechatAccount->getCurrentAccount();
        $api = $account->createApiService();
        $ret = $api->addPayGiftCard([
            'rule_info' => [
                'type' => $card->getTypeName(),
                'base_info' => [
                    'mchid_list' => explode(',', $card['mch_id_list']),
                    'begin_time' => strtotime($card['begin_time']),
                    'end_time' => strtotime($card['end_time']),
                ],
                'member_rule' => [
                    'card_id' => $card['card_id'],
                    'least_cost' => $card['least_cost'] * 100,
                    'max_cost' => $card['max_cost'] * 100,
                    'jump_url' => $card['jump_link_to'] ? wei()->linkTo->getFullUrl($card['jump_link_to']) : '',
                ]
            ]
        ]);
        if ($ret['code'] !== 1) {
            $ret['message'] = '保存失败，微信返回：' . $ret['message'];

            return $ret;
        }
        if (!$ret['rule_id']) {
            return $this->err(['message' => '保存失败'] + $ret);
        }

        // 记录成功的内容到规则中
        $card->save([
            'rule_id' => $ret['rule_id'],
            'mch_id_list' => implode(',', $ret['succ_mchid_list']),
        ]);

        return $this->suc($ret);
    }
}
