<?php

namespace App\Http\Controllers\Query;

use App\Models\GithubContribution;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Courses;
use QL\QueryList;
use App\Models\School;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use GuzzleHttp\Cookie\FileCookieJar;
use GitHub;

class GithubController extends Controller
{
    private $client;

    public function __construct()
    {
        set_time_limit(0);
        //设置cookie
        //初始化 client
        $this->client = new Client([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => '*/*',
            'Accept-Language' => 'en-US,en;q=0.8,hi;q=0.6,und;q=0.4',
        ]);
    }

    /**
     * 展示github贡献数据
     */
    public function contributions(GithubContribution $githubContributionModel)
    {
        // 获取全部的用户数据
        $data = $githubContributionModel->all()->toArray();
        // 获取日期数组
        $date = [];
        for ($i = 1; $i < 8; $i++) {
            $date[] = Carbon::now()->subDay($i)->toDateString();
        }
        foreach ($data as $k => $v) {
            $count = [];
            foreach ($date as $n) {
                $count[] = isset($v['content'][$n]) ? $v['content'][$n]: 0;
            }
            $name[] = $v['name'];
            $url [] = 'https://github.com/'.$v['nickname'];
            $series[] = [
                'name' => $v['name'],
                'type' => 'line',
                'data' => $count
            ];
        }
        $assign = compact('name', 'series', 'date', 'url');
        return view('query/github/contributions', $assign);
    }

    /**
     * 更新github贡献数据
     */
    public function updateContributions()
    {
        // 获取全部用户和url
        $githubContributionModel = new GithubContribution();
        $userData = $githubContributionModel->all();
        // 获取用户github全年的贡献
        $client = $this->client;
        foreach ($userData as $k => $v) {
            $response = $client->request('GET', $v->url)
                ->getBody()
                ->getContents();
            // 获取日期和贡献次数
            $count = QueryList::Query($response,array(
                //采集规则库
                //'规则名' => array('jQuery选择器','要采集的属性'),
                'date' => array('.height-full .js-calendar-graph-svg g .day', 'data-date'),
                'count' => array('.height-full .js-calendar-graph-svg g .day', 'data-count'),
            ))->data;
            // 把数组重组成 日期为key  次数为value 的格式
            $content = [];
            foreach ($count as $m => $n) {
                $content[$n['date']] = $n['count'];
            }
            // 保存到数据库
            $map = [
                'id' => $v->id
            ];
            $data = [
                'content' => $content
            ];
            $githubContributionModel->editData($map, $data);
        }
        echo '更新完毕';
    }

    public function api(GithubContribution $githubContributionModel)
    {
        set_time_limit(0);
        // 获取全部的用户数据
        $userData = $githubContributionModel
            ->select('id', 'nickname')
            ->get()
            ->toArray();

        $client = new \Github\Client();
        foreach ($userData as $k => $v) {
            $pushData = [];
            for ($i = 1; $i < 4; $i++) {
                $response = $client->getHttpClient()->get('users/'.$v['nickname'].'/events/public?page='.$i.'&per_page=300');
                $events     = \Github\HttpClient\Message\ResponseMediator::getContent($response);
                array_walk($events, function (&$v) {
                    $v['created_at'] = date('Y-m-d', strtotime($v['created_at']));
                });
                $pushData = collect($events)->where('type', 'PushEvent')->merge($pushData);
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
    }


}
