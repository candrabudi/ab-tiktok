<?php

namespace App\Exports;

use App\Models\TiktokAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TikTokAccountsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Menyediakan koleksi data yang akan diexport
     */
    public function collection()
    {
        return TiktokAccount::all();
    }

    /**
     * Menyediakan header kolom untuk file Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'TikTok Search ID',
            'TikTok Account ID',
            'Nickname',
            'Unique ID',
            'Following',
            'Followers',
            'Likes',
            'Total Video',
            'Avatar',
            'Verified',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Menyediakan format data untuk setiap baris
     */
    public function map($tiktokAccount): array
    {
        return [
            $tiktokAccount->id,
            $tiktokAccount->tiktok_search_id,
            $tiktokAccount->tiktok_account_id,
            $tiktokAccount->nickname,
            'https://tiktok.com/@' . $tiktokAccount->nickname,
            $tiktokAccount->following,
            $tiktokAccount->followers,
            $tiktokAccount->likes,
            $tiktokAccount->total_video,
            $tiktokAccount->avatar,
            $tiktokAccount->verified ? 'Yes' : 'No',
            $tiktokAccount->created_at,
            $tiktokAccount->updated_at,
        ];
    }
}
