<?php

namespace Miaoxing\WechatMemberCard\Controller\Admin;

use miaoxing\plugin\BaseController;

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

        $card->save($req);

        return $this->suc();
    }
}
