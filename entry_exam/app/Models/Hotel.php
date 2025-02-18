<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Hotel extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var array
     */
    protected $guarded = ['hotel_id'];

    /**
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * Search hotel by hotel name
     *
     * @param string $hotelName
     * @return array
     */
    static public function getHotelListByCondition(Request $request): array
    {
        $searchTermName = '%' . $request->input('hotel_name') . '%';
        $filterPrefectureId = $request->input('prefecture_id');

        $result = Hotel::whereRaw('LOWER(hotel_name) LIKE ?', [$searchTermName])
            ->with('prefecture')
            ->when($filterPrefectureId, function ($query) use ($filterPrefectureId) {
                $query->where('prefecture_id', $filterPrefectureId);
            })
            ->get()
            ->toArray();

        return $result;
    }

    /**
     * Override serializeDate method to customize date format
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
