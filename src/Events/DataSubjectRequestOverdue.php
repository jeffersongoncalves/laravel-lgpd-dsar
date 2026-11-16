<?php

namespace JeffersonGoncalves\LgpdDsar\Events;

use JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest;

class DataSubjectRequestOverdue
{
    public function __construct(public DataSubjectRequest $request) {}
}
