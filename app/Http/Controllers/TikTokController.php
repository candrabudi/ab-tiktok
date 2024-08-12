<?php

namespace App\Http\Controllers;

use App\Models\TiktokAccount;
use App\Models\TiktokAccountVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TiktokSearch;
use App\Models\TiktokResult;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\RapiApi;

class TikTokController extends Controller
{

    // func pencarian tiktok
    public function search(Request $request)
    {
        $rapidAPI = RapiApi::first();
        set_time_limit(3000);

        $startTime = microtime(true);
        $maxExecutionTime = 50 * 60;

        $keywords = $request->input('keywords', 'hallo');
        $count = 0;
        $cursor = 0;
        $videos = [];

        $tiktokSearch = new TiktokSearch();
        $tiktokSearch->keyword = $keywords;
        $tiktokSearch->type = 'username';
        $tiktokSearch->save();
        $tiktokSearch->fresh();

        while ($count < 200) {
            $currentTime = microtime(true);
            if (($currentTime - $startTime) >= $maxExecutionTime) {
                break;
            }

            $response = Http::withHeaders([
                'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
                'x-rapidapi-key' => $rapidAPI->rapid_key
            ])->get('https://tiktok-download-video1.p.rapidapi.com/feedSearch', [
                'keywords' => $keywords,
                'count' => 30,
                'cursor' => $cursor,
                'region' => 'ID',
                'publish_time' => 0,
                'sort_type' => 0
            ]);

            $result = $response->json();
            if ($result['code'] == 0 && isset($result['data']['videos'])) {
                foreach ($result['data']['videos'] as $video) {
                    $uniqueId = $video['author']['id'];

                    $checkTiktokResult = TiktokAccount::where('tiktok_account_id', $video['author']['id'])
                        ->select('id')
                        ->first();

                    if (!$checkTiktokResult) {
                        $tiktokAccount = new TiktokAccount();
                        $tiktokAccount->tiktok_search_id = $tiktokSearch->id;
                        $tiktokAccount->tiktok_account_id = $video['author']['id'];
                        $tiktokAccount->nickname = $video['author']['nickname'];
                        $tiktokAccount->verified = 0;
                        $tiktokAccount->unique_id = $uniqueId;
                        $tiktokAccount->avatar = $video['author']['avatar'];
                        

                        $responseAccount = Http::withHeaders([
                            'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
                            'x-rapidapi-key' => $rapidAPI->rapid_key
                        ])->get('https://tiktok-download-video1.p.rapidapi.com/userInfo', [
                            'user_id' => $video['author']['id'],
                        ]);
                
                        $resultAccount= $responseAccount->json();
                        if ($resultAccount['code'] == 0) {
                            $data = $resultAccount['data'];
                            $tiktokAccount->followers = $data['stats']['followerCount'];
                            $tiktokAccount->following = $data['stats']['followingCount'];
                            $tiktokAccount->likes = $data['stats']['heart'];
                            $tiktokAccount->likes = $data['stats']['heart'];
                            $tiktokAccount->total_video = $data['stats']['videoCount'];
                        }
                        $tiktokAccount->save();

                        $responseVideos = Http::withHeaders([
                            'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
                            'x-rapidapi-key' => $rapidAPI->rapid_key
                        ])->get('https://tiktok-download-video1.p.rapidapi.com/userPublishVideo', [
                            'user_id' => $video['author']['id'],
                            'count' => 30, 
                            'cursor' => 0,
                        ]);
                
                        $resultVideos = $responseVideos->json();
                        if ($resultVideos['code'] == 0) {
                            $accVideos = $resultVideos['data']['videos'];
            
                            foreach($accVideos as $accVideo) {
                                TiktokAccountVideo::create([
                                    'tiktok_account_id' => $video['author']['id'],
                                    'aweme_id' => $accVideo['aweme_id'],
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
                                ]);
                            }
                        }

                        $count++;
                    }
                }

                $cursor = $result['data']['cursor'];

                if (!$result['data']['hasMore']) {
                    break;
                }
            } else {
                break;
            }
        }

        return response()->json([
            "code" => 0,
            "msg" => "success",
            "processed_time" => round((microtime(true) - $startTime), 4),
            "total_data" => $cursor,
        ]);
    }

    // end func pencarian tiktok


    // list hasil pencarian tiktok
    public function searchResult(Request $request)
    {
        $results = TiktokSearch::paginate(10);
        $results->getCollection()->transform(function ($account) {
            $account->total_search = $account->getTiktokAccountCountAttribute();
            return $account;
        });

        foreach ($results as $result) {
            $result->account_count = $result->tiktokAccountCountAttribute;
        }

        if ($request->ajax()) {
            return view('tiktok_results', compact('results'))->render();
        }

        return view('tiktok_keyword', compact('results'));
    }


    public function loadSearchResult(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $results = TiktokSearch::paginate($perPage, ['*'], 'page', $page);
        $results->getCollection()->transform(function ($account) {
            $account->total_search = $account->getTiktokAccountCountAttribute();
            return $account;
        });
        return response()->json($results);
    }

    // end list hasil pencarian tiktok

    // data profile akun tiktok
    public function dataSearchProfile(Request $request, $a)
    {
        $rapidAPI = RapiApi::first();
        $tiktokResult = TiktokAccount::where('unique_id', $a)
            ->first();

        if(!$tiktokResult) {
            return redirect()->route('home');
        }

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
            'x-rapidapi-key' => $rapidAPI->rapid_key
        ])->get('https://tiktok-download-video1.p.rapidapi.com/userInfo', [
            'user_id' => $tiktokResult->tiktok_account_id,
        ]);

        $result = $response->json();
        if ($result['code'] == 0 && $tiktokResult->followers == 0) {
            $data = $result['data'];

            $tiktokResult->followers = $data['stats']['followerCount'];
            $tiktokResult->following = $data['stats']['followingCount'];
            $tiktokResult->likes = $data['stats']['heart'];
            $tiktokResult->likes = $data['stats']['heart'];
            $tiktokResult->total_video = $data['stats']['videoCount'];
            $tiktokResult->save();
        }

        $titkokAccountVideo = TiktokAccountVideo::where('tiktok_account_id', $a)
            ->count();

        $results = TiktokAccountVideo::where('tiktok_account_id', $a)
            ->paginate(10);

        if ($request->ajax()) {
            return view('tiktok_results', compact('results'))->render();
        }

        return view('tiktok_account', compact('tiktokResult', 'a'));
    }

    public function loadTiktokAccountVideo(Request $request, $a)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $products = TiktokAccountVideo::where('tiktok_account_id', $a)
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($products);
    }

    // end data profile akun tiktok

    // scrap video berdasarkan akun tiktok
    public function scrapVideoTiktokAccount($a) 
    {
        $rapidAPI = RapiApi::first();
        $accountTikTok = TiktokAccount::where('tiktok_account_id', $a)
            ->first();
        
        if(!$accountTikTok) {
            return redirect()->route('home');
        }
        $titkokAccountVideo = TiktokAccountVideo::where('tiktok_account_id', $a)
            ->count();

        if($titkokAccountVideo == 0) {
            $response = Http::withHeaders([
                'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
                'x-rapidapi-key' => $rapidAPI->rapid_key
            ])->get('https://tiktok-download-video1.p.rapidapi.com/userPublishVideo', [
                'user_id' => $accountTikTok->tiktok_account_id,
                'count' => 30, 
                'cursor' => 0,
            ]);
    
            $result = $response->json();
            if ($result['code'] == 0) {
                $videos = $result['data']['videos'];

                foreach($videos as $video) {
                    TiktokAccountVideo::create([
                        'tiktok_account_id' => $a,
                        'aweme_id' => $video['aweme_id'],
                        'video_id' => $video['video_id'],
                        'region' => $video['region'],
                        'title' => $video['title'],
                        'cover' => $video['cover'],
                        'duration' => $video['duration'],
                        'play' => $video['play'],
                        'play_count' => $video['play_count'],
                        'digg_count' => $video['digg_count'],
                        'comment_count' => $video['comment_count'],
                        'share_count' => $video['share_count'],
                        'download_count' => $video['download_count'],
                        'collect_count' => $video['collect_count'],
                        'create_time' => $video['create_time'],
                        'is_top' => $video['is_top']
                    ]);
                }
            }
        }

        return redirect()->back();
        
    }

    // end scrap video berdasarkan akun tiktok


    // detail list akun hasil scrap tiktok
    public function detailSearchResults(Request $request, $a)
    {
        $results = TiktokAccount::with('videos')
            ->where('tiktok_search_id', $a)
            ->where('nickname', 'LIKE', '%'. $request->search.'%')
            ->paginate(10);
    
        // Add the average play count to each account
        $results->getCollection()->transform(function ($account) {
            $account->top12_play_count_average = $account->getTop12PlayCountAverageAttribute();
            return $account;
        });
        if ($request->ajax()) {
            return view('tiktok_results', compact('results', 'a'))->render();
        }
    
        return view('tiktok_detail', compact('results', 'a'));
    }
    

    public function loadDetailSearchResults(Request $request, $a)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        $results = TiktokAccount::with('videos')
            ->where('tiktok_search_id', $a)
            ->where('nickname', 'LIKE', '%'. $request->search.'%')
            ->paginate($perPage, ['*'], 'page', $page);

        // Add the average play count to each account
        $results->getCollection()->transform(function ($account) {
            $account->top12_play_count_average = $account->getTop12PlayCountAverageAttribute();
            return $account;
        });

        return response()->json($results);
    }

    // end detail list akun hasil scrap tiktok

    

   // export list akun tiktok berdasarkan pencarian
    public function exportTikTokAccounts($a)
    {
        $tiktokAccounts = TiktokAccount::where('tiktok_search_id', $a)->get();
        $output = '';

        // Header CSV
        $output .= "Nickname,Unique ID,Followers,Likes,Total Video\n";

        foreach ($tiktokAccounts as $account) {
            $nickname = str_pad($this->escapeForCsv($account->nickname), 30); // Panjang 30
            $uniqueId = str_pad($this->escapeForCsv('https://tiktok.com/@' . $account->unique_id), 50); // Panjang 50
            $followers = str_pad($this->escapeForCsv($account->followers), 20); // Panjang 20
            $likes = str_pad($this->escapeForCsv($account->likes), 15); // Panjang 15
            $totalVideo = str_pad($this->escapeForCsv($account->total_video), 10); // Panjang 10

            $output .= $nickname . ',' . $uniqueId . ',' . $followers . ',' . $likes . ',' . $totalVideo . "\n";
        }

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment;filename="tiktok_accounts.csv"');
        header('Cache-Control: max-age=0');

        echo $output;
        exit;
    }

    private function escapeForCsv($value)
    {
        $escapedValue = str_replace('"', '""', $value);
        return '"' . $escapedValue . '"';
    }
    // end export list akun tiktok berdasarkan pencarian
}
