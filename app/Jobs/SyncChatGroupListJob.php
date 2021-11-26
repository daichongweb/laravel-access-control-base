<?php

namespace App\Jobs;

use App\Exceptions\ApiException;
use App\Models\ChatGroupsModel;
use App\Models\MemberModel;
use App\Services\CustomerGroupService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 同步群列表
 */
class SyncChatGroupListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $member;

    public $limit = 10;

    public $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MemberModel $member, $token)
    {
        $this->member = $member;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws ApiException
     */
    public function handle()
    {
        $this->sync();
    }

    /**
     * 同步
     * @param string $cursor
     * @throws ApiException
     */
    private function sync(string $cursor = '')
    {
        $customerGroupService = new CustomerGroupService();
        $customerGroupService->token = $this->token;
        $groupChatList = $customerGroupService->groupList($this->member->corp_user_id, $this->limit, $cursor);
        if ($groupChatList) {
            $list = [];
            foreach ($groupChatList['group_chat_list'] as $chat) {
                $chatInfo = $customerGroupService->groupInfo($chat['chat_id'], 0);
                $chat['name'] = $chatInfo['group_chat']['name'] ?: '未命名';
                array_push($list, [
                    'enterprise_id' => $this->member->enterprise_id,
                    'member_id' => $this->member->id,
                    'chat_id' => $chat['chat_id'],
                    'chat_name' => $chatInfo['group_chat']['name'] ?: '未命名',
                    'status' => $chat['status']
                ]);
            }
            if ($list) {
                ChatGroupsModel::query()->upsert($list, ['enterprise_id', 'member_id', 'chat_id'], ['chat_name', 'status']);
            }
            if ($cursor = $groupChatList['next_cursor'] ?? '') {
                $this->sync($cursor);
            }
        }
    }
}
