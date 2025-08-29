<?php

namespace App\Entity;

enum MissionStatusEnum: string
{
    case SUCCESS = 'Success';
    case FAILURE = 'Failure';
}