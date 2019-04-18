<?php
/**
 * Created by PhpStorm.
 * User: guoxingong
 * Date: 2019/4/18
 * Time: 10:30
 */

namespace App\Extensions\Log;

use Monolog\Formatter\JsonFormatter as BaseJsonFormatter;

class JsonFormatter extends BaseJsonFormatter
{
    public function format(array $record)
    {
        $action = \Route::currentRouteAction();
        // 这个就是最终要记录的数组，最后转成Json并记录进日志
        if (!empty($record['context'])) {
            $record['context'] = $record['context'];
        }else{
            $record['context']='';
        }
        $newRecord = [
            'request_id' => LOG_ID,
            'action' => $action,
            'time' => $record['datetime']->format('Y-m-d H:i:s'),
            'message' => $record['message'],
            'context' => $record['context'],
        ];

        $json = $this->toJson($this->normalize($newRecord), true) . ($this->appendNewline ? "\n" : '');

        return $json;
    }
}