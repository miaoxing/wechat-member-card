<?php

namespace Miaoxing\WechatMemberCard\Controller\Admin;

use Miaoxing\Plugin\BaseController;
use Miaoxing\WechatCard\Service\WechatCardRecord;

class WechatMemberCards extends BaseController
{
    protected $controllerName = '会员卡管理';

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
                $cards = wei()->wechatCard()
                    ->curApp()
                    ->andWhere(['type' => WechatCardRecord::TYPE_MEMBER_CARD]);

                // 分页
                $cards->limit($req['rows'])->page($req['page']);

                // 排序
                $cards->desc('id');

                $cards->notDeleted();

                $data = [];
                $cards->findAll();
                /** @var WechatCardRecord $card */
                foreach ($cards as $card) {
                    $data[] = $card->toArray() + [
                            'status_name' => $card->getStatusName(),
                            'source_name' => $card->getConstValue('source', $card['source'], 'text'),
                        ];
                }

                return $this->suc([
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $cards->count(),
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
        $card = wei()->wechatCard()
            ->curApp()
            ->notDeleted()
            ->findId($req['id'])
            ->fromArray($req);

        $shops = $card->getSelectedShops();

        $msgCards = wei()->wechatCard()
            ->select('wechat_id, title')
            ->curApp()
            ->notDeleted()
            ->andWhere("wechat_id != ''")
            ->andWhere('type != ?', WechatCardRecord::TYPE_MEMBER_CARD)
            ->fetchAll();

        $this->js += [
            'card' => $card,
            'shops' => $shops,
        ];

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function updateAction($req)
    {
        return wei()->wechatCard->save($req);
    }

    public function showAction($req)
    {
        $card = wei()->wechatCard()->findOneById($req['id']);

        $account = wei()->wechatAccount->getCurrentAccount();
        $api = $account->createApiService();

        $ret = $api->getCardRet($card['wechat_id']);

        return $ret;
    }
}
