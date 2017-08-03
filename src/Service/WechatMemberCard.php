<?php

namespace Miaoxing\WechatMemberCard\Service;

use miaoxing\plugin\BaseService;

class WechatMemberCard extends BaseService
{
    protected $table = 'wechat_member_cards';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $appIdColumn = 'app_id';

    protected $createAtColumn = 'created_at';

    protected $updateAtColumn = 'updated_at';

    protected $createdByColumn = 'created_by';

    protected $updatedByColumn = 'updated_by';

    protected $deletedAtColumn = 'deleted_at';

    protected $deletedByColumn = 'deleted_by';
}
