<?php

namespace App\Enums;

enum SeriesTypes: string
{
    case Collection = 'collection';
    case OneShot = 'one shot';
    case Limited = 'limited';
    case Ongoing = 'ongoing';
}
