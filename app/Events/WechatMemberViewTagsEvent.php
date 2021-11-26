<?php

namespace App\Events;

use App\Models\WechatMembers;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WechatMemberViewTagsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $member;

    public $tags;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WechatMembers $member, $tags)
    {
        $this->member = $member;
        $this->tags = $tags;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
