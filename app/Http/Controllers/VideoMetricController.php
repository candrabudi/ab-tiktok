<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RapiApi;
use App\Models\VideoMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class VideoMetricController extends Controller
{
    public function index()
    {
        return view('video_metrict');
    }

    public function loadVideoMetric(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $results = VideoMetric::orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results);
    }

    public function storeVideoMetric(Request $request)
    {
        $rapidAPI = RapiApi::first();
        $tiktokUrl = $request->input('tiktok_url');

        if (!$tiktokUrl || !filter_var($tiktokUrl, FILTER_VALIDATE_URL)) {
            return response()->json(['message' => 'Invalid or empty URL provided.'], 400);
        }

        $tiktokUrl = strtok($tiktokUrl, '?');

        $apiUrl = 'https://tiktok-download-video1.p.rapidapi.com/getVideo';
        $headers = [
            'x-rapidapi-host' => 'tiktok-download-video1.p.rapidapi.com',
            'x-rapidapi-key' => $rapidAPI->rapid_key,
        ];

        try {
            // Menambahkan timeout 5 menit (300 detik)
            $response = Http::timeout(300)
                ->withHeaders($headers)
                ->get($apiUrl, [
                    'url' => $tiktokUrl,
                    'hd' => 1,
                ]);

            if ($response->successful()) {
                $body = json_decode($response->body(), true);
                VideoMetric::create([
                    'tiktok_url' => $tiktokUrl,
                    'views' => $body['data']['play_count'],
                    'like' => $body['data']['digg_count'],
                    'comment' => $body['data']['comment_count'],
                    'share' => $body['data']['share_count'],
                    'save' => $body['data']['collect_count'],
                ]);

                return response()->json(['message' => 'URL processed successfully.'], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from TikTok API',
                'error' => $response->json(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function exportVideoMetrics()
    {
        // Fetch data from the VideoMetric model
        $metrics = VideoMetric::select('tiktok_url', 'views', 'like', 'comment', 'share', 'save', 'created_at', 'updated_at')->get();

        // XML-based Excel format (Excel 2003 XML)
        $excelData = '<?xml version="1.0"?>';
        $excelData .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
                        xmlns:o="urn:schemas-microsoft-com:office:office"
                        xmlns:x="urn:schemas-microsoft-com:office:excel"
                        xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
                        xmlns:html="http://www.w3.org/TR/REC-html40">';

        $excelData .= '<Worksheet ss:Name="Video Metrics">';
        $excelData .= '<Table>';

        // Define custom column widths (in points, 1 point = 1/72 inch)
        $columnWidths = [360, 80, 80, 80, 80, 80, 120, 120]; // Custom widths for each column

        // Apply column widths
        foreach ($columnWidths as $width) {
            $excelData .= '<Column ss:Width="' . $width . '"/>';
        }

        // Set the header row
        $headers = ['TikTok URL', 'Views', 'Likes', 'Comments', 'Shares', 'Saves', 'Created At', 'Updated At'];
        $excelData .= '<Row>';
        foreach ($headers as $header) {
            $excelData .= '<Cell><Data ss:Type="String">' . htmlspecialchars($header) . '</Data></Cell>';
        }
        $excelData .= '</Row>';

        // Add data rows
        foreach ($metrics as $metric) {
            $excelData .= '<Row>';
            $excelData .= '<Cell><Data ss:Type="String">' . htmlspecialchars($metric->tiktok_url) . '</Data></Cell>';
            $excelData .= '<Cell><Data ss:Type="Number">' . htmlspecialchars($metric->views) . '</Data></Cell>';
            $excelData .= '<Cell><Data ss:Type="Number">' . htmlspecialchars($metric->like) . '</Data></Cell>';
            $excelData .= '<Cell><Data ss:Type="Number">' . htmlspecialchars($metric->comment) . '</Data></Cell>';
            $excelData .= '<Cell><Data ss:Type="Number">' . htmlspecialchars($metric->share) . '</Data></Cell>';
            $excelData .= '<Cell><Data ss:Type="Number">' . htmlspecialchars($metric->save) . '</Data></Cell>';
            $excelData .= '<Cell><Data ss:Type="String">' . htmlspecialchars($metric->created_at) . '</Data></Cell>';
            $excelData .= '<Cell><Data ss:Type="String">' . htmlspecialchars($metric->updated_at) . '</Data></Cell>';
            $excelData .= '</Row>';
        }

        $excelData .= '</Table>';
        $excelData .= '</Worksheet>';
        $excelData .= '</Workbook>';

        // Add a timestamp to the filename
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = 'video_metrics_' . $timestamp . '.xls';

        // Set headers to force download of the Excel file
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment;filename="' . $filename . '"',
        ];

        return Response::make($excelData, 200, $headers);
    }

    
}
