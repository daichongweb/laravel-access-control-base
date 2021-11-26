<?php

namespace App\Listeners;

use App\Events\WechatMemberViewEvent;
use App\Models\WechatMemberViewLogsModel;
use App\Models\WechatMemberViewTagsModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

/**
 * 微信用户浏览文章监听器
 */
class WechatMemberViewListener implements ShouldQueue
{
    /**
     * 任务将被发送到的连接的名称。
     *
     * @var string|null
     */
    public $connection = 'redis';

    /**
     * 任务将被发送到的队列的名称。
     *
     * @var string|null
     */
    public $queue = 'wechatMemberView';

    /**
     * 任务被处理的延迟时间（秒）。
     *
     * @var int
     */
    public $delay = 1;

    /**
     * Handle the event.
     *
     * @param WechatMemberViewEvent $event
     * @return void
     */
    public function handle(WechatMemberViewEvent $event)
    {
        $enterpriseId = $event->currentUser->enterprise_id;
        $wechatMemberId = $event->currentUser->id;
        // 浏览记录
        WechatMemberViewLogsModel::query()->updateOrCreate(
            [
                'enterprise_id' => $enterpriseId,
                'wechat_member_id' => $wechatMemberId,
                'post_id' => $event->request['id']
            ], $event->request);
    }
}
