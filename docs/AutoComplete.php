<?php

namespace MiaoxingDoc\WechatMemberCard {

    /**
     * @property    \Miaoxing\WechatMemberCard\Service\WechatMemberCard $wechatMemberCard 微信会员卡服务
     *
     * @property    \Miaoxing\WechatMemberCard\Service\WechatPayGiftCard $wechatPayGiftCard 支付后赠会员卡服务
     *
     * @property    \Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel $wechatPayGiftCardModel
     * @method      \Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel|\Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel[] wechatPayGiftCardModel()
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return MiaoxingDoc\WechatMemberCard\AutoComplete
     */
    function wei()
    {
    }

    /** @var Miaoxing\WechatMemberCard\Service\WechatMemberCard $wechatMemberCard */
    $wechatMemberCard = wei()->wechatMemberCard;

    /** @var Miaoxing\WechatMemberCard\Service\WechatPayGiftCard $wechatPayGiftCard */
    $wechatPayGiftCard = wei()->wechatPayGiftCard;

    /** @var Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel $wechatPayGiftCardModel */
    $wechatPayGiftCard = wei()->wechatPayGiftCardModel();

    /** @var Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel|Miaoxing\WechatMemberCard\Service\WechatPayGiftCardModel[] $wechatPayGiftCardModels */
    $wechatPayGiftCards = wei()->wechatPayGiftCardModel();
}
