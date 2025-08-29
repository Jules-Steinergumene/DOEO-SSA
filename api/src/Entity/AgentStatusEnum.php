<?php

namespace App\Entity;

enum AgentStatusEnum: string
{
    case ON_MISSION = 'On Mission';
    case RETIRED = 'Retired';
    case KILLED_IN_ACTION = 'Killed in Action';
    case AVAILABLE = 'Available';
}