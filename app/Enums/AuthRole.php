<?php

namespace App\Enums;

enum AuthRole: int
{
    case Participant = 0;
    case parent = 1;
    case SupportCoordinator = 2;
    case Nominee = 3;
}
