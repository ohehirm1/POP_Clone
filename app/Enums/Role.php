<?php

namespace App\Enums;

enum Role: int
{
    case Admin = 0;
    case Staff = 1;
    case Provider = 2;
}
