<?php

namespace App\Http\Common;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Record;

class ImportRecord extends Controller
{

    /**
     * 将读取的记录存入数据库
     */
    public function index($import_sn,$record)
    {
    	$error=array('errnum'=>0,'message'=>'');
    	$num = count($record);

        //将校验合格的记录保存到数据库
	    for ($i = 0; $i < $num; $i++) {
	    	
	        $record[$i] = iconv("GB2312","UTF-8",$record[$i]);
	        //对每个单元格的内容进行校验,只举个例子
	        switch ($i) {
	        	case 2:
	        		if(preg_match("/^1[34578]\d{9}$/", $record[$i])){

					}else{
						$error['errnum']=1;
						$error['message']='手机号格式不正确';
					}
	        		break;
	        	default:
	        		break;
	        }
	    }

	    //保存原始记录
    	$result = Record::insert([
            'import_sn'    => $import_sn,
            'username'    => $record[0],
            'sex'    => $record[1],
            'mobile'    => $record[2],
            'birthday'    => $record[3],
            'address'    => $record[4],
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
		if($error['errnum']==0){
			$user = User::where('mobile', $record[2])->first();

		    if (!$user) {
		        $userResult = User::insert([
		            'username'    => $record[0],
		            'sex'    => $record[1],
		            'mobile'    => $record[2],
		            'birthday'    => $record[3],
		            'address'    => $record[4],
		            'created_at'    => date('Y-m-d H:i:s'),
		            'updated_at'    => date('Y-m-d H:i:s'),
		        ]);
		    // 更新原数据
		    } else {
		        $user->username = $record[0];
		        $user->sex = $record[1];
		        $user->mobile = $record[2];
		        $user->birthday = $record[3];
		        $user->address = $record[4];
		        $user->updated_at = date('Y-m-d H:i:s');
		        $user->save();
		    }
		}
		return $error;
	}
}
