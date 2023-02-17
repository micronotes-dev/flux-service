<?php

namespace Micronotes\Flux\Enums;

enum FluxStatus: string
{
    case success = 'success';
    case failed = 'failed';
    case partial = 'partial';
    case waiting = 'waiting';
}
