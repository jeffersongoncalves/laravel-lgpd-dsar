<?php

namespace JeffersonGoncalves\LgpdDsar\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Lgpd\Attributes\PersonalData;
use JeffersonGoncalves\Lgpd\Concerns\InteractsWithPersonalData;
use JeffersonGoncalves\Lgpd\Contracts\HasPersonalData;
use JeffersonGoncalves\Lgpd\Enums\AnonymizeStrategy;
use JeffersonGoncalves\Lgpd\Enums\LegalBasis;
use JeffersonGoncalves\LgpdDsar\Enums\RequestStatus;
use JeffersonGoncalves\LgpdDsar\Enums\RequestType;

/**
 * @property RequestType $type
 * @property RequestStatus $status
 * @property string|null $export_path
 * @property Carbon $due_at
 * @property Carbon|null $verified_at
 * @property Carbon|null $completed_at
 * @property Model|null $subject
 */
#[PersonalData('requester_name', purpose: 'Answer data subject requests (art. 18)', legalBasis: LegalBasis::LegalObligation, anonymize: AnonymizeStrategy::Mask)]
#[PersonalData('requester_email', purpose: 'Answer data subject requests (art. 18)', legalBasis: LegalBasis::LegalObligation, anonymize: AnonymizeStrategy::Hash)]
class DataSubjectRequest extends Model implements HasPersonalData
{
    use InteractsWithPersonalData;

    protected $guarded = [];

    public function getTable(): string
    {
        return config('lgpd-dsar.table', 'lgpd_dsar_requests');
    }

    protected function casts(): array
    {
        return [
            'type' => RequestType::class,
            'status' => RequestStatus::class,
            'due_at' => 'datetime',
            'verified_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeOpen(Builder $query): void
    {
        $query->whereIn('status', RequestStatus::open());
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeOverdue(Builder $query): void
    {
        $query->whereIn('status', RequestStatus::open())->where('due_at', '<', now());
    }

    public function isOpen(): bool
    {
        return in_array($this->status, RequestStatus::open(), true);
    }

    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }
}
