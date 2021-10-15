<?php

namespace Yanntyb\App\Model\Classes\Manager;

class LogManager
{

    /**
     * Parse log file
     * @return array
     */
    public function getAllLog(): array
    {
        $logs = explode("\n",file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/log/log.log"));
        $messages = [];
        foreach($logs as $log){
            if($log !== ""){
                $messages[] = [
                    "date" => explode("]",$log)[0] . "]",
                    "name" => explode(" {", explode("log.INFO:", $log)[1])[0],
                    "data" => "{" . explode("}",explode(" {", explode("log.INFO:", $log)[1])[1])[0] . "}",
                ];
            }
        }
        return $messages;
    }
}