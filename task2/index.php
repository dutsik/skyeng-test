<?php


// параметры
$count_path = __DIR__ . '/count/';
$count_file = $count_path . 'counter.';
$count_lock = $count_path . 'counter_lock';

// создаем неблокирующий лок для файла счетчика
$i = 0;
while (file_exists($count_lock . $i) || !@mkdir($count_lock . $i)) {
    $i++;
    if ($i > 100) {
        exit($count_lock . $i . ' writable?');
    }
}

// обновляем счетчик
$count = intval(@file_get_contents($count_file . $i));
$count++;

// иммитация большой нагрузки на скрипт
sleep(3);

// обновляем знечение счетчика
file_put_contents($count_file . $i, $count);

// убираем лок
rmdir($count_lock . $i);

// случайным образом запускаем процедуру суммирования счетчиков, чем больше нагрузка тем реже надо запускать данных блок
// если файлов счеткика много, больше 2, стоит задуматься над увеличением производительности системы
// данную кусок кода можно вынести в отдельный скрипт работающий, например, по крону
$load = 5;
if (mt_rand(0, $load) == 0) {
    if (!file_exists($count_lock) && @mkdir($count_lock)) {
        $count = intval(@file_get_contents($count_file . 'txt'));
        $count_files = glob($count_path . '*.[0-9]*');
        foreach ($count_files as $file) {
            $i = pathinfo($file, PATHINFO_EXTENSION);
            // читаем толко не заблокированные счетчики
            if (!file_exists($count_lock . $i) && @mkdir($count_lock . $i)) {
                $count += intval(@file_get_contents($file));
                file_put_contents($file, 0);
                rmdir($count_lock . $i);
            }
        }
        file_put_contents($count_file . 'txt', $count);
        rmdir($count_lock);
    }
}



