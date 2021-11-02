<?php

namespace App\Jobs;

use App\Models\ChatGroupInfosModel;
use App\Models\ChatGroupMembersModel;
use App\Models\MemberModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *群详情同步队列
 */
class GroupChatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $groupMemberList;

    protected $memberModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MemberModel $memberModel, $groupMemberList)
    {
        $this->memberModel = $memberModel;
        $this->groupMemberList = $groupMemberList;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $enterprise_id = $this->memberModel->enterprise_id;
        $member_id = $this->memberModel->id;
        if ($this->groupMemberList) {
            $groupChat = $this->groupMemberList['group_chat'];
            $memberList = $groupChat['member_list'];
            $adminList = $groupChat['admin_list'];
            // 同步信息
            $infoModel = ChatGroupInfosModel::query()->updateOrCreate([
                'chat_id' => $groupChat['chat_id'],
                'enterprise_id' => $enterprise_id,
                'member_id' => $member_id
            ], [
                'chat_id' => $groupChat['chat_id'],
                'chat_name' => $groupChat['name'],
                'owner' => $groupChat['owner'],
                'member_num' => count($memberList),
                'admin_num' => count($adminList),
                'create_time' => $groupChat['create_time'],
                'enterprise_id' => $enterprise_id,
                'member_id' => $member_id
            ]);
            // 同步成员
            $members = [];
            if ($memberList) {
                foreach ($memberList as $member) {
                    array_push($members, [
                        'enterprise_id' => $enterprise_id,
                        'member_id' => $member_id,
                        'user_id' => $member['userid'],
                        'type' => $member['type'],
                        'join_scene' => $member['join_scene'],
                        'invitor' => $member['invitor']['userid'],
                        'group_nickname' => $member['group_nickname'],
                        'name' => $member['name'],
                        'join_time' => $member['join_time'],
                        'is_admin' => (int)in_array($member['userid'], array_column($adminList, 'userid')),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'info_id' => $infoModel->id
                    ]);
                }
                ChatGroupMembersModel::query()->delete();
                ChatGroupMembersModel::query()->insert($members);
            }
        }
    }
}
