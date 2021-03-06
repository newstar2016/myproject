<?php

namespace App\Http\Controllers\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Jobs\ReadCsvJob;
use App\Http\Common\CsvReader;
use App\Http\Common\ReadCsv;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{

    /**
     * 测试
     */
    public function index()
    {
//        $csvfile="C:\\users.csv";
        // $lines=100;
        // $offset=0;
        // $data=$this->csv_get_lines($csvfile,$lines,$offset);
        // echo "<pre>";
        // var_dump($data);exit;
        // $rowSize = 2;  //每次读取的行数
        // $startRow = 2;//从第二行开始读取
        // $endRow = $rowSize+1;  //最后一行
        // while (true) {
        //     $excel_orders = $this->csv_get_lines($excel_file, $startRow, $endRow);
        //     if(empty($excel_orders)) {
        //         break;
        //     }
        //     $startRow = $endRow + 1;
        //     $endRow = $endRow + $rowSize;
        //     echo "<pre>";
        //     var_dump($excel_orders);exit;
        // }
        // $start=time();
//        $result=$this->readCvs($csvfile);
//        foreach ($result as $key => $value) {
//          print_r($value);
//          echo "<br />";
//        }
        // $end=time();
        // echo $end-$start;
        // $readObj=new ReadCsv();
        // $readObj->index($csvfile);

        try{
            $hash1 = md5(uniqid());
            $hash2 = md5(uniqid()).rand(1,99999);
            var_dump($hash1.'----'.$hash2);exit;
//            $message = 'Some message'.LOG_ID;
//            $log = ['user_id'=>1,'user_name'=>'abcd'];
//            Log::info($message, $log);  //Log后的数组会自动转成Json存
        }catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function queue() {
        // 可以瞧瞧返回值，记得 use App\Jobs\BaseJob;
        BaseJob::dispatch()->delay(10);
        echo "队列演示";die;
    }


    /**
     * csv_get_lines 读取CSV文件中的某几行数据
     * @param $csvfile csv文件路径
     * @param $lines 读取行数
     * @param $offset 起始行数
     * @return array
     * */
    // public function csv_get_lines($csvfile, $lines, $offset = 0) {
    //  if(!$fp = fopen($csvfile, 'r')) {
    //     return false;
    //  }
    //     $i = $j = 0;
    //     while (false !== ($line = fgets($fp))) {
    //         if($i++ < $offset) {
    //             continue; 
    //         }
    //         break;
    //     }
    //     $data = array();
    //     while(($j++ < $lines) && !feof($fp)) {
    //         $data[] = fgetcsv($fp);
    //     }
    //     fclose($fp);
    //     return $data;
    // }

    public function readCvs($filepath){
        $handle= fopen($filepath, 'rb');
        while (feof($handle)===false) {
            yield fgetcsv($handle);
        }
        fclose($handle);
    }
}
