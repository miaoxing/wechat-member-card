<?php

namespace Miaoxing\WechatMemberCard\Controller\Admin;

use Miaoxing\Plugin\BaseController;
use Miaoxing\WechatCard\Service\WechatCardRecord;
use Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel;

class WechatPayGiftCards extends BaseController
{
    protected $controllerName = '支付后赠会员卡';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '创建',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];

    protected $displayPageHeader = true;

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $wechatPayGiftCards = wei()->wechatPayGiftCardModel()
                    ->limit($req['rows'])
                    ->page($req['page'])
                    ->setQueryParams($req)
                    ->sort();

                // 数据
                $data = [];
                /** @var WechatPayGiftCardModel $wechatPayGiftCard */
                foreach ($wechatPayGiftCards->findAll() as $wechatPayGiftCard) {
                    $data[] = $wechatPayGiftCard->toArray() + [
                            'wechatCard' => $wechatPayGiftCard->wechatCard,
                        ];
                }

                return $this->suc([
                    'data' => $data,
                    'page' => (int) $req['page'],
                    'rows' => (int) $req['rows'],
                    'records' => $wechatPayGiftCards->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $wechatPayGiftCard = wei()->wechatPayGiftCardModel()->findId($req['id']);

        $cards = wei()->wechatCard()
            ->curApp()
            ->notDeleted()
            ->andWhere(['type' => WechatCardRecord::TYPE_MEMBER_CARD]);

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        return wei()->wechatPayGiftCard->save($req);
    }

    public function destroyAction($req)
    {
        $wechatPayGiftCard = wei()->wechatPayGiftCardModel()->findOneById($req['id']);

        $account = wei()->wechatAccount->getCurrentAccount();
        $api = $account->createApiService();
        $ret = $api->deletePayGiftCard(['rule_id' => $wechatPayGiftCard['ruleId']]);
        if ($ret['code'] !== 1) {
            return $ret;
        }

        $wechatPayGiftCard->destroy();

        return $this->suc();
    }
}
