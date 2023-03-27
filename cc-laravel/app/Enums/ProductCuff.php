<?php

namespace App\Enums;

enum ProductCuff: string {
    case YES            = 'Sim';
    case NO             = 'Não';
    case ANOTHER_COLOR  = 'Outra cor';
    case BIAS           = 'Viés';
}
