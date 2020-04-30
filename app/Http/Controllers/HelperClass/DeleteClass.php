<?php

namespace App\Http\Controllers\HelperClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DeleteClass
{
    /**
     * @param $table
     * @param $field_id
     * @param $item_id
     * @return bool
     */
    public function canDelete($table, $field_id, $item_id): bool
    {
        $used = DB::table($table)->where($field_id, $item_id)->first();
        if ($used)
            return true;
        return false;
    }

    /**
     * @param $item
     * @param $table
     * @param $field_name
     * @return int
     */
    public function delete_it($item, $table, $field_name): int
    {
        if (!$item)
            return 404;
        if ($this->canDelete($table, $field_name, $item->id))
            return 402;
        $item->delete();
        if ($item) return 200;
        return 400;
    }


}
