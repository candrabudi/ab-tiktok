<?php

namespace App\Exports;

use App\Models\VideoMetric;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VideoMetricsExport implements FromCollection, WithHeadings
{
    /**
     * Retrieve the data you want to export.
     */
    public function collection()
    {
        // Fetch data from the VideoMetric model
        return VideoMetric::select('tiktok_url', 'views', 'like', 'comment', 'share', 'save', 'created_at', 'updated_at')->get();
    }

    /**
     * Provide headings for the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'TikTok URL',
            'Views',
            'Likes',
            'Comments',
            'Shares',
            'Saves',
            'Created At',
            'Updated At',
        ];
    }
}
