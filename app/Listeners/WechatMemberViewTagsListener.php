<?php

namespace App\Listeners;

use App\Events\WechatMemberViewTagsEvent;
use App\Models\WechatMemberViewTagsModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * 用户标签浏览
 */
class WechatMemberViewTagsListener implements ShouldQueue
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
    public $queue = 'wechatMemberViewTags';

    /**
     * 任务被处理的延迟时间（秒）。
     *
     * @var int
     */
    public $delay = 1;

    /**
     * Handle the event.
     *
     * @param WechatMemberViewTagsEvent $event
     * @return void
     */
    public function handle(WechatMemberViewTagsEvent $event)
    {
        $enterpriseId = $event->member->enterprise_id;
        $wechatMemberId = $event->member->id;
        $tags = $event->tags;
        foreach ($tags as $tag) {
            $arg = [
                'enterprise_id' => $enterpriseId,
                'wechat_member_id' => $wechatMemberId,
                'tag_id' => $tag->id
            ];
            WechatMemberViewTagsModel::query()->updateOrCreate($arg, $arg);
        }
    }
}
