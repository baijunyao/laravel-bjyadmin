<?php

namespace App\Http\Controllers\Query;

use App\Models\GithubContribution;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GithubController extends Controller
{
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

}
