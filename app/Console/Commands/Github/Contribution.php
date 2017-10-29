<?php

namespace App\Console\Commands\Github;

use App\Models\GithubContribution;
use Illuminate\Console\Command;
use GitHub;
use Github\HttpClient\Message\ResponseMediator;

class Contribution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:contribution';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update github contribution';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $githubContributionModel = new GithubContribution();
        // 获取全部的用户数据
        $userData = $githubContributionModel
            ->select('id', 'nickname')
            ->get()
            ->toArray();
        foreach ($userData as $k => $v) {
            $pushData = [];
            for ($i = 1; $i <= 3; $i++) {
                $response = GitHub::getHttpClient()->get('users/'.$v['nickname'].'/events/public?page='.$i.'&per_page=300');
                $events = ResponseMediator::getContent($response);
                array_walk($events, function (&$v) {
                    $v['created_at'] = date('Y-m-d', strtotime($v['created_at']));
                });
                // 记录用户 push 事件
                $pushData = collect($events)->where('type', 'PushEvent')->merge($pushData);
                // 记录用户创建 仓库 事件
                $pushData = collect($events)->where('type', 'CreateEvent')->map(function ($v) {
                    // 因为创建仓库事件中没有 distinct_size 字段； 设置为算1此提交 方便后面的统计
                    $v['payload']['distinct_size'] = 1;
                    return $v;
                })->filter(function ($v) {
                    // ref_type=repository 的才算是创建仓库事件
                    return $v['payload']['ref_type'] === 'repository';
                })->merge($pushData);
            }
            $pushDataArray = $pushData->sortByDesc('created_at')->groupBy('created_at')->map(function ($v) {
                return array_sum(array_column(array_column($v->toArray(), 'payload'), 'distinct_size'));
            })->toArray();
            $map = [
                'id' => $v['id']
            ];
            $data = [
                'content' => $pushDataArray
            ];
            $githubContributionModel->editData($map, $data);
        }
        $this->info('更新完成');
    }
}
