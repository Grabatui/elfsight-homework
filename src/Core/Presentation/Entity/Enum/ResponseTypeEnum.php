<?php

namespace App\Core\Presentation\Entity\Enum;

enum ResponseTypeEnum: string
{
    case error = 'error';
    case success = 'success';
}
