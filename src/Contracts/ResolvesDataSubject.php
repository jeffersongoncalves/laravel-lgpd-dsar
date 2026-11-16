<?php

namespace JeffersonGoncalves\LgpdDsar\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Implemented by models in lgpd.models that belong to a data subject
 * (e.g. Order: where('user_id', $subject->getKey())).
 * The subject's own model is resolved without it.
 */
interface ResolvesDataSubject
{
    /**
     * @return Builder<covariant Model>
     */
    public static function dataSubjectQuery(Model $subject): Builder;
}
