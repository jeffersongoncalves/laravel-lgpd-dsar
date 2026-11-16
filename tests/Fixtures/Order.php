<?php

namespace JeffersonGoncalves\LgpdDsar\Tests\Fixtures;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Lgpd\Attributes\PersonalData;
use JeffersonGoncalves\Lgpd\Concerns\InteractsWithPersonalData;
use JeffersonGoncalves\Lgpd\Contracts\HasPersonalData;
use JeffersonGoncalves\LgpdDsar\Contracts\ResolvesDataSubject;

#[PersonalData('shipping_address')]
class Order extends Model implements HasPersonalData, ResolvesDataSubject
{
    use InteractsWithPersonalData;

    protected $guarded = [];

    public $timestamps = false;

    public static function dataSubjectQuery(Model $subject): Builder
    {
        return static::query()->where('user_id', $subject->getKey());
    }
}
