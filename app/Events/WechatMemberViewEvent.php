<?php

namespace App\Events;

use App\Models\PostsModel;
use App\Models\WechatMembers;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

/**
 * 微信用户浏览素材事件
 */
class WechatMemberViewEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * 素材
     * @var PostsModel
     */
    public $post;

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
    public function __construct(WechatMembers $wechatMember, PostsModel $post, array $request)
    {
        $this->currentUser = $wechatMember;
        $this->post = $post;
        $this->request = $request;
    }
}
