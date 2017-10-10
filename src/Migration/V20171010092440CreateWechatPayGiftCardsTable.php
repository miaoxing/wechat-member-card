<?php

namespace Miaoxing\WechatMemberCard\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20171010092440CreateWechatPayGiftCardsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('wechat_pay_gift_cards')
            ->id()
            ->int('app_id')
            ->int('rule_id')
            ->tinyInt('type')
            ->string('mch_id_list')
            ->timestamp('begin_time')
            ->timestamp('end_time')
            ->string('card_id', 32)
            ->decimal('least_cost', 10)
            ->decimal('max_cost', 10)
            ->string('jump_link_to')
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('wechat_pay_gift_cards');
    }
}
