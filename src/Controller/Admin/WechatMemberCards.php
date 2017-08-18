<?php

namespace Miaoxing\WechatMemberCard\Controller\Admin;

use miaoxing\plugin\BaseController;
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
                            'source_name' => $card->getConstantValue('source', $card['source'], 'text'),
                        ];
                }

                return $this->suc([
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $cards->count(),
                ]);
                break;

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
        $card = wei()->wechatCard()->curApp()->notDeleted()->findId($req['id']);
        $shops = $card->getShops();

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function updateAction($req)
    {
        $card = wei()->wechatCard()->curApp()->notDeleted()->findId($req['id']);

        $card->fromArray($req);
        $card['type'] = WechatCardRecord::TYPE_MEMBER_CARD;

        $card->save();

        return $this->suc();
    }
}
