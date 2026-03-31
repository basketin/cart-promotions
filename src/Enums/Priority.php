<?php

namespace Obelaw\Basketin\Cart\Promotions\Enums;

enum Priority: int
{
    case LOWEST = 0;
    case LOW = 10;
    case MEDIUM = 20;
    case HIGH = 30;
    case HIGHEST = 40;
}
