<?php

namespace App\Events;

use App\Models\WechatMembers;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * 微信用户浏览素材事件
 */
class WechatMemberViewEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * 当前用户
     * @var WechatMembers
     */
    public $currentUser;

    public $request;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WechatMembers $wechatMember, array $request)
    {
        $this->currentUser = $wechatMember;
        $this->request = $request;
    }
}
