<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\UrlClick;
use Carbon\Carbon;
use CodeIgniter\I18n\Time;

class Url extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'shorten_urls';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'url',
        'short_url',
        'code',
        'clicks',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function countClicksByCurrentYear($code)
    {
        $urls = new Url();
        $urlclicks = new UrlClick();
        $url = $urls->where('code', $code)->first();
        $columns = ['platform', 'browser', 'device'];
        $urlclick = $this->getCountByColumns($columns , $url['id'] , Carbon::now()->startOfYear() , Carbon::now()->endOfYear());
        $currentYear = date('Y');
        $currentClicks = [];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::createFromDate($currentYear, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($currentYear, $month, 1)->endOfMonth();
            $clickCount = $urlclicks->where('shorten_url_id', $url['id'])->where("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN  '{$startDate->toDateString()}'  AND   '{$endDate->toDateString()}'")->countAllResults();
            $currentClicks[$month-1] = [
                'clicks' => $clickCount
            ];
        }
        return [
            'months' => $currentClicks,
            'urlclicks' => $urlclick
        ];
    }

    public function countClicksByMonthRange($code ,$startDate, $endDate)
    {
        $startDate = Carbon::createFromDate($startDate);
        $endDate = Carbon::createFromDate($endDate);
        // return $startDate . ' ' . $endDate;
        $urls = new Url();
        $urlclicks = new UrlClick();
        $url = $urls->where('code', $code)->first();
        $columns = ['platform', 'browser', 'device'];
        $urlclick = $this->getCountByColumns($columns , $url['id'] , $startDate , $endDate);
        $currentClicks = [];
        $diffInMonths = $startDate->diffInMonths($endDate);
        $i = 0;
        // return $diffInMonths;
        while ($startDate->lte($endDate)) {
            // return $day;
            $end_date = $i == $diffInMonths ? $endDate->toDateString() : $startDate->endOfMonth()->toDateString();
            $clickCount = $urlclicks->where('shorten_url_id', $url['id'])->where("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN  '{$startDate->toDateString()}'  AND   '{$end_date}'")->countAllResults();
            $currentClicks[$startDate->month -1] = [
                'clicks' => $clickCount
            ];
            $startDate->addMonth()->startOfMonth();
            $i++;
        }
        return [
            'months' => $currentClicks,
            'urlclicks' => $urlclick
        ];
    }

    public function getCountByColumns($columns , $id , $startDate , $endDate)
    {
        $startDate = $startDate->format('Y-m-d');
        $endDate = $endDate->format('Y-m-d');
        $urlclick = new UrlClick();
        $result = [];
        foreach ($columns as $column) {
                $result[$column] = $urlclick->select($column . ', COUNT(*) as count_' . $column)->where('shorten_url_id' , $id)
                ->where("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN  '{$startDate}'  AND   '{$endDate}'")
                ->groupBy($column)->findAll();
        }

        return $result;

    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function clicks()
    {
        return $this->hasMany('App\Model\UrlClick', 'shorten_url_id', 'id');
    }
}
