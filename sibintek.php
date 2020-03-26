<?php

class sibintek
{
    /**
     * @array | array  - входной массив, с которым будем работать
     * @countArray | integer - количество интервалов в массиве
     * @start | float - время старта скрипта
     * @startInterval | integer - минимальное значение в интервале
     * @endInterval | integer - максимальное значение в интервале
     * @summInterval | integer - сумма интервалов
     * @flagInterval | bool- флаг, от которого зависит, будем ли проверять пересечение
     */
    private $array;
    private $countArray;
    private $start;
    private $startInterval;
    private $endInterval;
    private $summInterval;
    private $flagInterval;
    private $continueInterval;
    /**
     * sibintek constructor.
     *
     * формирует входной массив из случайного
     * количества интервалов в промежутке от 2 до 6
     *
     * запоминает время старта скрипта
     */
    public function __construct()
    {
        $this->start = microtime(true);
        $this->countArray = rand(2,6);
        $this->continueInterval = NULL;
        echo 'Количество интервалов в массиве : '.$this->countArray.'</br></br>';
    }

    public function __destruct()
    {
        echo '</br>Время работы скрипта : '.round(microtime(true) - $this->start, 4). ' сек';
    }

    /**
     * Интерфейс для доступа к классу из программы
     */
    public function start() {
        $this->getIntervalArray();
        $this->summIntervalArray();
    }

    /**
     * заполняется парой случайных значений массив из конструктора
     * от 0 до 9, первое из которых всегда меньше второго и следовательно,
     * они не могут быть равны
     */
    private  function getIntervalArray()
    {
        for ($i=0, $this->array = []; count($this->array) != $this->countArray; $i++) {

            $this->array[] = [
                rand(0, 9),
                rand(0, 9)
            ];
            if (($this->array[$i][0] > $this->array[$i][1]) OR
                ($this->array[$i][0] == $this->array[$i][1])) {
                    unset($this->array[$i]);
            }
        }
        $this->array = array_values($this->array);
        $this->arrayPrint('Массив интервалов : ', $this->array);
        echo '<hr>';
    }

    /**
     * Основной метод программы.
     * Проходится по всему массиву и проверяет
     * пересекаются ли интервалы в массиве
     *
     * Суммирует разницу значений всех интервалов
     */
    private function summIntervalArray()
    {
        echo 'Трассировка...</br>';

        for ($i=0, $this->flagInterval = false; $i < count($this->array); $i++) {
            $this->startInterval = $this->array[$i][0];
            $this->endInterval = $this->array[$i][1];

            if ($this->flagInterval == false ) {
                for ($j=0; $j < count($this->array); $j++) {
                    if (($j != $i) AND
                        ($this->startInterval <= $this->array[$j][0]) AND
                        ($this->array[$j][0] <= $this->endInterval) AND
                        ($this->array[$j][1] <= $this->endInterval)) {
                            $this->flagInterval = true;
                            $interval = max($this->array[$j][1], $this->endInterval) - min($this->startInterval, $this->array[$j][0]);
                            $this->summInterval += $interval - ($this->array[$j][1] - $this->array[$j][0]);
                            $this->continueInterval = $j;

                            echo '</br>'.$i.' интервал ['.$this->startInterval.','.$this->endInterval.']';
                            echo ' пересекается с '.$j.' интервалом ['.$this->array[$j][0].','.$this->array[$j][1].']';
                            echo ' их сумма равна '.$interval;

                            continue 2;
                    }
                }
            }
            $interval = $this->array[$i][1] - $this->array[$i][0];
            echo '</br> длина '.$i.' - го интервала = '.$interval;
            $this->summInterval += $interval;
        }
        if ($this->flagInterval == false) {
            echo '</br></br>Пересечений интервалов в массиве нет';
        }
        echo '</br></br>Сумма интервалов массива : '. $this->summInterval;
        echo '<hr>';
    }

    /**
     * @param $string
     * @param $array
     * Печатает входную строку и массив в читабельном виде
     */
    private function arrayPrint($string, $array)
    {
        echo $string.'<pre>';
        print_r($array);
        echo '</pre>';
    }
}
