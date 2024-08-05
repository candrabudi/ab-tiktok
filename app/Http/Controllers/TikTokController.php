<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TiktokSearch;
use App\Models\TiktokResult;

class TikTokController extends Controller
{
    public function search(Request $request)
    {
        $keywords = $request->input('keywords', 'hallo');
        $count = 0;
        $cursor = 0;
        $uniqueIds = [];

        $tiktokSearch = new TiktokSearch();
        $tiktokSearch->keyword = $keywords;
        $tiktokSearch->type = 'username';
        $tiktokSearch->save();
        $tiktokSearch->fresh();

        while ($count < 200) {
            $response = Http::withHeaders([
                'x-rapidapi-host' => 'tiktok-api23.p.rapidapi.com',
                'x-rapidapi-key' => 'b2d0328c9emsh70fb505520fda60p1fa0cfjsn15e4724016f0'
            ])->get('https://tiktok-api23.p.rapidapi.com/api/search/video', [
                'keyword' => $keywords,
                'cursor' => $cursor,
                'search_id' => ""
            ]);

            $videos = $response->json();

            if ($videos['status_code'] == 0 && isset($videos['item_list'])) {
                foreach ($videos['item_list'] as $video) {
                    $uniqueId = $video['author']['uniqueId'];
                    
                    // Check if the uniqueId is already processed
                    if (!in_array($uniqueId, $uniqueIds)) {
                        $checkTiktokResult = TiktokResult::where('unique_id', $uniqueId)
                            ->select('id')
                            ->first();

                        if (!$checkTiktokResult) {
                            $tiktokResult = new TiktokResult();
                            $tiktokResult->tiktok_search_id = $tiktokSearch->id;
                            $tiktokResult->tiktok_id = $video['author']['id'];
                            $tiktokResult->nickname = $video['author']['nickname'];
                            $tiktokResult->verified = $video['author']['verified'];
                            $tiktokResult->following = $video['authorStats']['followingCount'];
                            $tiktokResult->followers = $video['authorStats']['followerCount'];
                            $tiktokResult->likes = $video['authorStats']['heartCount'];
                            $tiktokResult->total_video = $video['authorStats']['videoCount'];
                            $tiktokResult->unique_id = $uniqueId;
                            $tiktokResult->signature = $video['author']['signature'];
                            $tiktokResult->avatar_thumb = $video['author']['avatarThumb'];
                            $tiktokResult->avatar_medium = $video['author']['avatarMedium'];
                            $tiktokResult->avatar_large = $video['author']['avatarLarger'];
                            $tiktokResult->is_scrapper = 1;
                            $tiktokResult->save();

                            // Add uniqueId to the array to avoid duplicates
                            $uniqueIds[] = $uniqueId;
                            $count++;
                        }
                    }
                }

                $cursor = $response->json()['cursor'];

                if (count($videos['item_list']) === 0) {
                    break;
                }
            } else {
                break;
            }
        }

        $dataTiktokResults = TiktokResult::where('tiktok_search_id', $tiktokSearch->id)
            ->get();

        return response()->json($dataTiktokResults);
    }


    public function scrapTikTokUsername(Request $request)
    {
        $results = TiktokResult::paginate(10);

        if ($request->ajax()) {
            return view('tiktok_results', compact('results'))->render();
        }

        // return $results;
        return view('tiktok_username', compact('results'));
    }

    public function loadScrapTikTokUsername(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $products = TiktokResult::paginate($perPage, ['*'], 'page', $page);

        return response()->json($products);
    }
   
    public function updateScrapTikTokUsername(Request $request)
    {
        ini_set('max_execution_time', 30000);
        $dataUpdates = TiktokResult::where('is_scrapper', 0)
            ->get();

        foreach($dataUpdates as $update) {
            $response = Http::withHeaders([
                'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
                'x-rapidapi-key' => 'fd95897d1fmsh16cd082ff4db73ep145e8fjsn5adfe90752d1'
            ])->get('https://tiktok-scraper7.p.rapidapi.com/user/info', [
                'user_id' => $update->tiktok_id,
            ]);

            $data = $response->json();
            if (isset($data['data'])) {
                $userData = $data['data']['user'] ?? [];
                $statsData = $data['data']['stats'] ?? [];

                $update->avatar_thumb = $userData['avatarThumb'] ?? null;
                $update->avatar_medium = $userData['avatarMedium'] ?? null;
                $update->avatar_large = $userData['avatarLarger'] ?? null;
                $update->signature = $userData['signature'] ?? null;
                $update->verified = !empty($userData['verified']) ? 1 : 0;
                $update->followers = $statsData['followerCount'] ?? 0;
                $update->following = $statsData['followingCount'] ?? 0;
                $update->likes = $statsData['heartCount'] ?? 0;
                $update->total_video = $statsData['videoCount'] ?? 0;
                $update->is_scrapper = 1;
                $update->save();
            } else {
                continue;
            }
        }
    }

    public function detail($id)
    {
        $tiktokResult = TiktokResult::where('id', $id)
            ->first();
        return view('tiktok_detail', compact('tiktokResult'));
    }

}
