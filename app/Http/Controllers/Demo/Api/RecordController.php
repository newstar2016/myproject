<?php

namespace App\Http\Controllers\Demo\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Import;
use App\Models\Record;
use Illuminate\Support\Facades\Redis;

class RecordController extends Controller
{
    /**
     * 导入记录列表
     * @param Request $request
     * @return mixed;
     */
    public function list()
    {
        $cacheImportList=Redis::get('importList');
        if($cacheImportList){
            $result=json_decode($cacheImportList,TRUE);
        }else{
            $result=Import::all();
            Redis::set('importList',json_encode($result));
        }
        return response()->json($result, 200);
    }

    /**
     * 导入记录的详情
     * @param Request $request
     * @return mixed;
     */
    public function info(Request $request,$importsn)
    {
        $cacheImportDetail=Redis::get('importDetail'.$importsn);
        if($cacheImportDetail){
            $result=json_decode($cacheImportDetail,TRUE);
        }else{
            $result=Record::where('import_sn', $importsn)->get();
            Redis::set('importDetail'.$importsn,json_encode($result));
        }
        return response()->json($result, 200);
    }
}
