<?php

namespace App;
use Illuminate\Support\Facades\DB;


class Filter extends Model
{
    public function getFilterWords()
    {
        $filter = DB::table('filters')->where('id', '1')->first();
        return $filter;
    }

    public function setFilterWords($body)
    {
        DB::table('filters')
            ->where('id', 1)
            ->update(['body' => $body]);
    }

}
