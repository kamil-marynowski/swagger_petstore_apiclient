<?php

declare(strict_types=1);

namespace App\Enums;

enum PetCategories: int
{
    case DOG    = 1;
    case CAT    = 2;
    case TURTLE = 3;
    case RABBIT = 4;
}
