<?php
/**
 * @category BaseStatus
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/2/21 10:28
 * @since
 */
namespace common\status;

/**
 * Class BaseStatus
 * @package common\status
 */
class BaseStatus
{
    /**
     * common status (2 VALUES)
     */
    const COMMON_STATUS_DISABLED = 0;
    const COMMON_STATUS_ENABLED = 1;
    /**
     * common status (3 values )
     */
    const COMMON_STATUS_CHECKED = 1;
    const COMMON_STATUS_UNCHECKED = 0;
    const COMMON_STATUS_DELETED = -1;
    /**
     * USER STATUS
     */
    const USER_STATUS_DELETED = -1;
    const USER_STATUS_UNVERIFIED = 0;
    const USER_STATUS_VERIFIED = 1;
    /**
     * WECHAT SUBSCRIBE STATUS
     */
    const WECHAT_STATUS_SUBSCRIBED = 1;
    const WECHAT_STATUS_UNSUBSCRIBED = 0;
    /**
     * PAY STATUS
     */
    const PAY_STATUS_CANCEL = -1;
    const PAY_STATUS_WAITTING = 0;
    const PAY_STATUS_SUCCESS = 1;
    const PAY_STATUS_ASK_REFUND = 2;
    const PAY_STATUS_APPLY_REFUND = 3;
    const PAY_STATUS_REFUND_PROCESS = 4;
    const PAY_STATUS_REFUND_SUCCESS = 5;
    /**
     * ORDER STATUS
     * #TRADE_NO_CREATE_PAY (没有创建支付交易)
     * WAIT_BUYER_PAY (等待买家付款)
     * WAIT_PAY_RETURN (等待支付确认)
     * WAIT_SELLER_SEND_GOODS (等待卖家发货，即：买家已付款)
     * WAIT_BUYER_CONFIRM_GOODS (等待买家确认收货，即：卖家已发货)
     * TRADE_BUYER_SIGNED (买家已签收)
     * TRADE_CLOSED (付款以后用户退款成功，交易自动关闭)
     * TRADE_CLOSED_BY_USER (付款以前，卖家或买家主动关闭交易)
     */
    const ORDER_STATUS_WAIT_BUYER_PAY = 'WAIT_BUYER_PAY';
    const ORDER_STATUS_WAIT_PAY_RETURN = 'WAIT_PAY_RETURN';
    const ORDER_STATUS_WAIT_SELLER_SEND_GOODS = 'WAIT_SELLER_SEND_GOODS';
    const ORDER_STATUS_WAIT_BUYER_CONFIRM_GOODS = 'WAIT_BUYER_CONFIRM_GOODS';
    const ORDER_STATUS_TRADE_BUYER_SIGNED = 'TRADE_BUYER_SIGNED';
    const ORDER_STATUS_TRADE_CLOSED = 'TRADE_CLOSED';
    const ORDER_STATUS_TRADE_CLOSED_BY_USER = 'TRADE_CLOSED_BY_USER';
    const ORDER_STATUS_TRADE_CLOSED_BY_STORE = 'TRADE_CLOSED_BY_STORE';
    /**
     * REFUND STATUS
     * NO_REFUND（无退款）
     * PARTIAL_REFUNDING（部分退款中）
     * PARTIAL_REFUNDED（已部分退款）
     * PARTIAL_REFUND_FAILED（部分退款失败）
     * FULL_REFUNDING（全额退款中）
     * FULL_REFUNDED（已全额退款）
     * FULL_REFUND_FAILED（全额退款失败）
     */
    const REFUND_STATUS_PARTIAL_REFUNDINGPARTIAL_REFUNDING = '';
    const REFUND_STATUS_PARTIAL_REFUNDED = 'PARTIAL_REFUNDED';
    const REFUND_STATUS_PARTIAL_REFUND_FAILED = 'PARTIAL_REFUND_FAILED';
    const REFUND_STATUS_FULL_REFUNDING = 'FULL_REFUNDING';
    const REFUND_STATUS_FULL_REFUNDED = 'FULL_REFUNDED';
    const REFUND_STATUS_FULL_REFUND_FAILED = 'FULL_REFUND_FAILED';
    /**
     * FEEDBACK STATUS
     * 0 无维权，1 顾客发起维权，2 顾客拒绝商家的处理结果，3 顾客接受商家的处理结果，9 商家正在处理,101 维权处理中,110 维权结束。
     */
    const FEEDBACK_STATUS_NONE = 0;
    const FEEDBACK_STATUS_FROM_USER = 1;
    const FEEDBACK_STATUS_USER_REFUSED = 2;
    const FEEDBACK_STATUS_USER_APPLIED = 3;
    const FEEDBACK_STATUS_STORE_PROCESSING = 9;
    const FEEDBACK_STATUS_PROCESSING = 101;
    const FEEDBACK_STATUS_CLOSED = 110;
    /**
     *
     */
}
