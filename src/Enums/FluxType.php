<?php

namespace Micronotes\Flux\Enums;

enum FluxType: string
{
    case import = 'import';
    case export = 'export';
}
