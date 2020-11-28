<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TasksMain;

//  игнорируем прерывание скрипта пользователем
ignore_user_abort();

// Говорим что время на выполнение скрипта не ограничено
set_time_limit(0);

// Говорим что соединение надо закрыть
header('Connection: close');

// Отчищаем все буферы вывода 
@ob_end_flush();
@ob_flush();
@flush();

// Заканчиваем сессию пользователя (именно сессия и не давала 
// запускать выполнение ещё одного скрипта для этого пользователя 
// т.к. запуск скриптов лочится на файл сессий)
if(session_id()){
    session_write_close();
}

class SendTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendTaskCommand {inputarr}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    //  токен бота
    const TELEGRAM_TOKEN = '1445980108:AAFCAXQvtQLC3InF2AziCT6nk5wI1g0CB5o';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $inputarr = $this->argument('inputarr');
        $inputarr = json_decode($inputarr, true);
        $userid = intval($inputarr['userid']);
        $id_task = intval($inputarr['id_task']);
        $minuts = intval($inputarr['minuts']);
        $chat_id = intval($inputarr['chat_id']);

        //cli_set_process_title("sendTask_" . $userid . "_" . $id_task);

        $upd_status = TasksMain::where([
                                            ['userid', "=", $userid], 
                                            ['id', '=', $id_task]
                                        ])->update(['sending_status' => 1]);
        $record = TasksMain::select('task')->where([
                                                        ['userid', "=", $userid], 
                                                        ['id', "=", $id_task]
                                                    ])->get()->toArray();
        $text = base64_decode($record[0]['task']);
        $sleep_sec = $minuts * 60;
        sleep($sleep_sec);
        $this->sendToTg($chat_id, $text);
        $upd_status = TasksMain::where([
                                            ['userid', "=", $userid], 
                                            ['id', '=', $id_task]
                                        ])->update(['sending_status' => 0]);
        exit();
    }

    protected function getArguments()
    {
        return array(
            array('inputarr', InputArgument::REQUIRED, 'inputarr'),
        );
    }

    private function sendToTg($chat_id, $text){
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . self::TELEGRAM_TOKEN . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => $chat_id,
                    'text' => $text,
                ),
            )
        );
        curl_exec($ch);
    }
}
