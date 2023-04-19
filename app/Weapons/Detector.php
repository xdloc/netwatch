<?php

namespace App\Weapons;

class Detector
{
    private string|int $value;

    /**
     * @param string|int $value
     */
    public function __construct(string|int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int|string
     */
    public function getValue(): int|string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    public function isTaxCode(): bool
    {
        if (preg_match('/\D/', (int)$this->getValue())) {
            return false;
        }

        $length = strlen($this->getValue());

        if ($length === 10) {
            return $this->getValue()[9] === (string) (((
                            2 * $this->getValue()[0] + 4 * $this->getValue()[1] + 10 * $this->getValue()[2] +
                            3 * $this->getValue()[3] + 5 * $this->getValue()[4] + 9 * $this->getValue()[5] +
                            4 * $this->getValue()[6] + 6 * $this->getValue()[7] + 8 * $this->getValue()[8]
                        ) % 11) % 10);
        } elseif ($length === 12) {
            $num10 = (string) (((
                        7 * $this->getValue()[0] + 2 * $this->getValue()[1] + 4 * $this->getValue()[2] +
                        10 * $this->getValue()[3] + 3 * $this->getValue()[4] + 5 * $this->getValue()[5] +
                        9 * $this->getValue()[6] + 4 * $this->getValue()[7] + 6 * $this->getValue()[8] +
                        8 * $this->getValue()[9]
                    ) % 11) % 10);

            $num11 = (string) (((
                        3 * $this->getValue()[0] + 7 * $this->getValue()[1] + 2 * $this->getValue()[2] +
                        4 * $this->getValue()[3] + 10 * $this->getValue()[4] + 3 * $this->getValue()[5] +
                        5 * $this->getValue()[6] + 9 * $this->getValue()[7] + 4 * $this->getValue()[8] +
                        6 * $this->getValue()[9] + 8 * $this->getValue()[10]
                    ) % 11) % 10);

            return $this->getValue()[11] === $num11 && $this->getValue()[10] === $num10;
        }
        return false;
    }

    public function isStateRegistrationNumber(): bool
    {
        $stringNumber = (string)$this->getValue();
        $intNumber = (int)$this->getValue();
        if (!preg_match('#^\d{13,15}$#', $intNumber)){
            return false; // ОГРН должен состоять из 13 или 15 цифр

        } elseif ($intNumber > PHP_INT_MAX) {
            return false; // Проверка невозможна, т.к. скрипт запущен на 32х-разрядной версии PHP
        }

        if (strlen($stringNumber) == 13 && $stringNumber != substr((substr($stringNumber, 0, -1) % 11), -1)){
            return false; // 'Контрольное число равно ' . substr((substr($ogrn, 0, -1) % 11), -1) . '. Ожидалось ' . $ogrn[12]);
        } elseif (strlen($stringNumber) == 15 && $stringNumber[14] != substr(substr($stringNumber, 0, -1) % 13, -1)) {
            return false; //  'Контрольное число равно ' . substr(substr($ogrn, 0, -1) % 13, -1) . '. Ожидалось ' . $ogrn[14]);
        } elseif (strlen($stringNumber) != 13 && strlen($stringNumber) != 15) {
            return false; // 'ОГРН должен состоять из 13 или 15 цифр');
        }
        return true;
    }

/*    public function isLegalEntityName()
    {
        if(stristr($this->getValue(),'ИП') !== false
        || stristr($this->getValue(),'Индивидуальный предприниматель')
        || stristr($this->getValue(),'АО')
        || stristr($this->getValue(),'Акционерное общество')
        || stristr($this->getValue(),'ООО')
        || stristr($this->getValue(),'Общество с ограниченной ответственностью')
        || stristr($this->getValue(),'ОАО')
        || stristr($this->getValue(),'ОАО')
        ){
            return '';
        }
    }*/

    public function isAccount() {
        //if (!is_valid_biс($bic)) return false; // неверный БИК
        if(empty($this->getValue()) || !preg_match('#^\d{20}$#', $this->getValue())) return false; // р/с должен состоять из 20 цифр

/*        $bik_rs = substr((string) $bic, -3) . $rs;
        $checksum = 0;
        foreach ([7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1] as $i => $k) {
            $checksum += $k * ((int) $bik_rs{$i} % 10);
        }
        if ($checksum % 10 === 0) {
            return true;
        } else {
            return false; // Неверный контрольный разряд
        }*/
    }

/*    function isBankCode($bic) {
        if(empty($bic))return false; // Не передан обязательный параметр bic
        if(!preg_match('#^\d{9}$#', $bik)) return false; // БИК должен состоять из 9 цифр
        return true;
    }*/
}
