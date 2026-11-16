<?php

namespace JeffersonGoncalves\LgpdDsar\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\LgpdDsar\DsarManager;

/**
 * @method static \JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest open(\JeffersonGoncalves\LgpdDsar\Enums\RequestType $type, ?\Illuminate\Database\Eloquent\Model $subject = null, array $requester = [])
 * @method static \JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest verify(\JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest $request, ?\Illuminate\Database\Eloquent\Model $subject = null)
 * @method static \JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest fulfil(\JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest $request, ?string $response = null)
 * @method static \JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest complete(\JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest $request, ?string $response = null)
 * @method static \JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest reject(\JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest $request, string $reason)
 * @method static array<string, list<array<string, mixed>>> export(\Illuminate\Database\Eloquent\Model $subject)
 * @method static string exportToFile(\Illuminate\Database\Eloquent\Model $subject, string $filename)
 * @method static int erase(\Illuminate\Database\Eloquent\Model $subject)
 *
 * @see DsarManager
 */
class LgpdDsar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DsarManager::class;
    }
}
