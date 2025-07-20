<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case COACH = 'coach';
    case PLAYER = 'player';
    case FAN = 'fan';
}
