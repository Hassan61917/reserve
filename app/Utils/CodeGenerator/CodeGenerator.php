<?php

namespace App\Utils\CodeGenerator;

class CodeGenerator implements ICodeGenerator
{
    private array $digits = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

    public function generate(int $count): string
    {
        $result = "";
        for ($i = 0; $i < $count; $i++) {
            $result .= array_rand($this->digits);
        }
        return $result;
    }
}
