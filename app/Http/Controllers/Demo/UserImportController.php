<?php

namespace App\Http\Controllers\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImportRequest;
use App\Jobs\ReadCsvJob;

class UserImportController extends Controller
{

    /**
     * 首页
     */
    public function index()
    {
        return view('demo.index');
    }

    /**
     * 处理上传文件
     */

    public function upload(ImportRequest $request){
        //判断是否是POST上传
        if ($request->isMethod('POST')) {

            $fileCharater = $request->file('source');
 
            if ($fileCharater->isValid()) {
                //获取上传文件的名称
                $clientName = $fileCharater -> getClientOriginalName();

                //判断文件是否已经存在,如果提示失败
                if(file_exists(storage_path('app/public/'.$clientName))){
                    return "请勿重复上传相同的文件";
                }
                //获取文件的扩展名 
                $ext = $fileCharater->getClientOriginalExtension();
                $ext_lower=strtolower($ext);
                $allow_ext_array=array('csv','xls','xlsx');
                if(!in_array($ext_lower, $allow_ext_array)){
                    return "文件类型不在允许范围内";
                }
                //获取文件的绝对路径
                $path = $fileCharater->getRealPath();
 
                //定义文件名
                $filename = $clientName;

                //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
                Storage::disk('public')->put($filename, file_get_contents($path));

                //使用队列，读取上传文件,将数据存入数据库
                $this->dispatch(new ReadCsvJob(storage_path('app/public/'.$clientName)));
                return redirect('import/index');
            }
        }else{
            return "请使用post方式上传文件";
        }
        
    }
}
