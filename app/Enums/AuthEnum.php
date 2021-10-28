<?php

namespace App\Enums;
/**
 *权限控制枚举
 */
class AuthEnum
{
    /**
     * 获取企业token
     */
    const ENTERPRISE_TOKEN = 'enterprise:token';

    /**
     * 创建企业
     */
    const ENTERPRISE_CREATE = 'enterprise:create';

    /**
     * 客户群列表
     */
    const CUSTOMER_GROUP_LIST = 'customer-group:list';

    /**
     * 客户群详情
     */
    const CUSTOMER_GROUP_INFO = 'customer-group:info';

    /**
     * 客户详情
     */
    const CUSTOMER_INFO = 'customer:info';

    /**
     * 企业成员列表
     */
    const MEMBER_FOLLOW_LIST = 'member:follow-list';

    /**
     * 创建企业成员
     */
    const MEMBER_CREATE = 'member:create';

    /**
     * 企业成员绑定企业微信
     */
    const MEMBER_BIND = 'member:bind';

    /**
     * 企业一般成员
     * @return string[]
     */
    public static function enterprise_ordinary(): array
    {
        return [
            self::ENTERPRISE_TOKEN,
            self::CUSTOMER_GROUP_INFO,
            self::CUSTOMER_GROUP_LIST,
            self::MEMBER_BIND,
            self::CUSTOMER_INFO
        ];
    }

    /**
     * 企业管理员
     * @return array
     */
    public static function enterprise_admin(): array
    {
        return [
            self::enterprise_ordinary(),
            self::ENTERPRISE_CREATE,
            self::MEMBER_CREATE,
            self::MEMBER_FOLLOW_LIST
        ];
    }
}
