<?php

namespace Miaoxing\WechatMemberCard\Service;

use Miaoxing\Plugin\BaseService;
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
            'type' => $card->getTypeName(),
            'base_info' => [
                'mchid_list' => explode(',', $card['mchIdList']),
                'begin_time' => strtotime($card['beginTime']),
                'end_time' => strtotime($card['endTime']),
            ],
            'member_rule' => [
                'card_id' => $card['cardId'],
                'least_cost' => $card['leastCost'] * 100,
                'max_cost' => $card['maxCost'] * 100,
                'jump_url' => $card['jumpLinkTo'] ? wei()->linkTo->getFullUrl($card['jumpLinkTo']) : '',
            ],
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
            'ruleId' => $ret['rule_id'],
            'mchIdList' => implode(',', $ret['succ_mchid_list']),
        ]);

        return $this->suc($ret);
    }
}
