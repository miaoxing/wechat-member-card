<?php

namespace MiaoxingTest\WechatMemberCard;

use Miaoxing\Plugin\Test\BaseTestCase;
use Miaoxing\WechatCard\Service\WechatCardRecord;

/**
 * 会员卡插件
 */
class PluginTest extends BaseTestCase
{
    /**
     * 测试用户领取会员卡
     */
    public function testOnWechatUserGetCard()
    {
        $card = wei()->wechatCard()->setAppId()->save([
            'wechat_id' => wei()->seq(),
            'type' => WechatCardRecord::TYPE_MEMBER_CARD,
        ]);

        $cardCode = wei()->seq();
        wei()->tester->weChatReply('<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1366131865</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[user_get_card]]></Event>
<CardId><![CDATA[' . $card['wechat_id'] . ']]></CardId>
<IsGiveByFriend>0</IsGiveByFriend>
<UserCardCode><![CDATA[' . $cardCode . ']]></UserCardCode>
<FriendUserName><![CDATA[]]></FriendUserName>
<OuterId>0</OuterId>
<OldUserCardCode><![CDATA[]]></OldUserCardCode>
<OuterStr><![CDATA[12b]]></OuterStr>
<IsRestoreMemberCard>0</IsRestoreMemberCard>
<IsRecommendByFriend>0</IsRecommendByFriend>
</xml>');

        $member = wei()->member()->find(['code' => $cardCode]);
        $this->assertArraySubset([
            'card_id' => $card['id'],
            'card_wechat_id' => $card['wechat_id'],
            'code' => $cardCode,
            'wechat_open_id' => 'fromUser',
        ], $member->toArray());
    }
}
