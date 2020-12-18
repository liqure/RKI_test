<?php

if (!$_POST['name'] || !$_POST['email']) return;

echo ProstoySender::sendToTaskTable(
    '2889820',
    'f98865161364993199b22b96dcb68db9',
    [
        'AEFE97B47E3E6A6B' => $_POST['name'],
        'A9579A0474BF9C9F' => $_POST['email'],
    ]
);

class ProstoySender
{
    /**
     * Отправляет запись в таблицу Простого
     *
     * @param string $task_id
     * @param string $table_hash
     * @param array $fields
     * @param string $referer
     */
    public function sendToTaskTable($task_id, $table_hash, $fields, $referer = '')
    {
        $post_data = json_encode([
            'iform'    => "true",
            "action"   => "send_iform",
            "referer"  => $referer,
            "task_id"  => $task_id,
            "hash"     => $table_hash,
            "formdata" => $fields
        ]);

        self::postRequest('http://agent.prostoy.ru/api/crmform.php', $post_data);
    }

    /**
     * Отправка POST-запроса
     *
     * @param $url
     * @param $post_params
     * @return mixed
     */
    private static function postRequest($url, $post_params)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER,  true);
        curl_setopt($curl, CURLOPT_POST,            true);

        curl_setopt($curl, CURLOPT_URL,             $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS,      $post_params);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}