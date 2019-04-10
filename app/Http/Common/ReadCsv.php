<?php
namespace App\Http\Common;

use App\Http\Controllers\Controller;
use App\Http\Common\ImportRecord;
use App\Models\Import;
use Illuminate\Support\Facades\Log;

class ReadCsv extends Controller
{
	public $import_sn='';//本次导入的记录编号
	public $ImportRecord_obj=''; //导入对象

	public function __construct(){
		$this->import_sn='P'.time().rand(1000,9999);
		$this->ImportRecord_obj=new ImportRecord();
	}
    /**
     * 读取上传文件的内容,进行校验,存储
     */
    public function index($filepath)
    {
        $error_num=0;//本次导入的失败数
        $success_num=0;//本次导入的成功数
        //创建导入记录
        $result = Import::insert([
            'import_sn'    => $this->import_sn,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
       
        Log::channel('importLog')->info('批次'.$this->import_sn.'导入开始');
        $startTime=time();
        //导入文件中的用户信息
        $result=$this->readCvs($filepath);        
        foreach ($result as $key => $value) {
            if($value[1]){
	            $import_res=$this->ImportRecord_obj->index($this->import_sn,$value);
				if($import_res==1){
					Log::channel('importLog')->info('导入批次号：'.$this->import_sn.'手机号：'.$value[2].'的用户信息导入失败');
					$error_num++;
				}else{
					Log::channel('importLog')->info('导入批次号：'.$this->import_sn.'手机号：'.$value[2].'的用户信息导入成功');
					$success_num++;
				}
            }            	
        }
        
		$endTime=time();
		$useTime=$endTime-$startTime;
		Log::channel('importLog')->info('批次'.$this->import_sn.'导入结束,共导入'.($success_num+$error_num).'条,成功'.$error_num.'条失败'.$success_num.'条');
		Log::channel('importLog')->info('批次'.$this->import_sn.'导入耗时：'.$useTime.'秒');
	    //导入结束后,对结果进行汇总
	    $result = Import::where('import_sn',$this->import_sn)->update([
            'import_success'    => $this->success_num,
            'import_error'    => $this->error_num,
        ]);
	}

	/**
     * 读取csv文件
     * @param $filepath csv文件路径
     * */
    public function readCvs($filepath){
        $handle= fopen($filepath, 'rb');
        while (feof($handle)===false) {
            yield fgetcsv($handle);
        }
        fclose($handle);
    }
}
