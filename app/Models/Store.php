<?php

namespace App\Models;

use DB;
use Datatables;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name'];

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating', 'store_id');
    }

    /**
     * API: Get list stores
     * @param $type
     * @param $filter
     * @param $keyword
     * @return \Illuminate\Database\Eloquent\Collection $store
     */
    public static function getAllStore($type, $filter, $keyword)
    {
        $stores = Store::select(
            'stores.id', 'stores.name', 'stores.address', 'stores.lat', 'stores.lng',
            DB::raw('COUNT(`ratings`.`store_id`) AS `total_comment`'),
            DB::raw('SUM(case when(`ratings`.`store_id` = `stores`.`id`) then `ratings`.`score` else 0 end) /
            COUNT(`ratings`.`store_id`) AS `ave_rating`'))
            ->where('type', $type)
            ->leftJoin('ratings', 'stores.id', '=', 'ratings.store_id')
            ->groupBy('stores.id');
        if ($filter != null) {
            $stores->where('stores.'.$filter, 'like', '%'.$keyword.'%');
        }
        return $stores->get();
    }

    /**
     * API: Get detail store
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection $store
     */
    public static function getDetail($id)
    {
        $store = Store::find($id);
        $ratings = Rating::where('store_id', $id)->get();
        $store->ratings = $ratings;
        return $store;
    }

    public static function getDataTables($request)
    {
        $stores = static::select('*');

        return Datatables::of($stores)
            ->filter(function ($query) use ($request) {
                if ($request->has('id')) {
                    $query->where('id', $request->get('id'));
                }

                if ($request->has('phone_number')) {
                    $query->where('phone_number', 'like', '%' . $request->get('phone_number') . '%');
                }

                if ($request->has('name')) {
                    $query->where('name', 'like', '%' . $request->get('name') . '%');
                }

                if ($request->has('type')) {
                    $query->where('type', $request->get('type'));
                }
            })
            ->editColumn('type', function ($store) {
                return config('system.stores.type_name')[$store->type];
            })
            ->addColumn('action', function ($store) {
                return
                    '<a class="table-action-btn" title="Chi tiết cửa hàng" href="#"><i class="fa fa-search text-success"></i></a>';
            })
            ->make(true);
    }
}
