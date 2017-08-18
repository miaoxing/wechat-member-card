<?php

namespace Miaoxing\WechatMemberCard\Service;

use miaoxing\plugin\BaseService;

class WechatMember extends BaseService
{
    public function __invoke()
    {
        return wei()->wechatMemberRecord();
    }
}
