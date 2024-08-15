<?php

namespace App\Jobs;

use App\Models\TiktokAccount;
use App\Models\TiktokAccountVideo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessTiktokData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $author_id;
    protected $tiktok_search_id;
    protected $rapid_key;

    public function __construct($author_id, $tiktok_search_id, $rapid_key)
    {
        $this->author_id = $author_id;
        $this->tiktok_search_id = $tiktok_search_id;
        $this->rapid_key = $rapid_key;
    }

    public function handle()
    {
        $urlUserInfo = "https://tiktok-download-video1.p.rapidapi.com/userInfo";
        $urlUserVideos = "https://tiktok-download-video1.p.rapidapi.com/userPublishVideo";

        // Mendapatkan data userInfo
        $responseAccount = Http::withHeaders([
            'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
            'x-rapidapi-key' => $this->rapid_key
        ])->get($urlUserInfo, [
            'user_id' => $this->author_id,
        ]);

        $resultAccount = $responseAccount->json();
        if ($resultAccount['code'] == 0) {
            $data = $resultAccount['data'];
            $tiktokAccount = TiktokAccount::where('tiktok_account_id', $this->author_id)->first();
            if ($tiktokAccount) {
                $tiktokAccount->followers = $data['stats']['followerCount'];
                $tiktokAccount->following = $data['stats']['followingCount'];
                $tiktokAccount->likes = $data['stats']['heart'];
                $tiktokAccount->total_video = $data['stats']['videoCount'];
                $tiktokAccount->save();
            }
        }

        // Mendapatkan data userPublishVideo
        $responseVideos = Http::withHeaders([
            'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
            'x-rapidapi-key' => $this->rapid_key
        ])->get($urlUserVideos, [
            'user_id' => $this->author_id,
            'count' => 12,
            'cursor' => 0,
        ]);

        $resultVideos = $responseVideos->json();
        if ($resultVideos['code'] == 0) {
            $accVideos = $resultVideos['data']['videos'];

            foreach ($accVideos as $accVideo) {
                TiktokAccountVideo::updateOrCreate(
                    ['aweme_id' => $accVideo['aweme_id']],
                    [
                        'tiktok_account_id' => $this->author_id,
                        'video_id' => $accVideo['video_id'],
                        'region' => $accVideo['region'],
                        'title' => $accVideo['title'],
                        'cover' => $accVideo['cover'],
                        'duration' => $accVideo['duration'],
                        'play' => $accVideo['play'],
                        'play_count' => $accVideo['play_count'],
                        'digg_count' => $accVideo['digg_count'],
                        'comment_count' => $accVideo['comment_count'],
                        'share_count' => $accVideo['share_count'],
                        'download_count' => $accVideo['download_count'],
                        'collect_count' => $accVideo['collect_count'],
                        'create_time' => $accVideo['create_time'],
                        'is_top' => $accVideo['is_top']
                    ]
                );
            }
        }
    }
}

