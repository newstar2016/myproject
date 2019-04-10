<?php

namespace App\Http\Controllers\Demo\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Import;
use App\Models\Record;

class RecordController extends Controller
{
    /**
     * 导入记录列表
     * @param Request $request
     * @return mixed;
     */
    public function list()
    {    
        $result=Import::all();
        return response()->json($result, 200);
    }

    /**
     * 导入记录的详情
     * @param Request $request
     * @return mixed;
     */
    public function info(Request $request,$importsn)
    {   
        $result=Record::where('import_sn', $importsn)->get();    
        return response()->json($result, 200);
    }
}
