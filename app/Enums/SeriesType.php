<?php

namespace App\Enums;

enum SeriesType: string
{
    case Collection = 'collection';
    case OneShot = 'one shot';
    case Limited = 'limited';
    case Ongoing = 'ongoing';
}
