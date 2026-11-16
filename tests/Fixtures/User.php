<?php

namespace JeffersonGoncalves\LgpdDsar\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Lgpd\Attributes\PersonalData;
use JeffersonGoncalves\Lgpd\Concerns\InteractsWithPersonalData;
use JeffersonGoncalves\Lgpd\Contracts\HasPersonalData;
use JeffersonGoncalves\Lgpd\Enums\AnonymizeStrategy;

#[PersonalData('name', anonymize: AnonymizeStrategy::Mask)]
#[PersonalData('email', anonymize: AnonymizeStrategy::Hash)]
#[PersonalData('tax_id', anonymize: AnonymizeStrategy::Keep)]
class User extends Model implements HasPersonalData
{
    use InteractsWithPersonalData;

    protected $guarded = [];

    public $timestamps = false;
}
