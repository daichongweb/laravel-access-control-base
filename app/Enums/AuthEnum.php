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

}
