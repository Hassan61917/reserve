<?php

namespace App\Utils\CodeGenerator;

interface ICodeGenerator
{
    public function generate(int $count): string;
}

