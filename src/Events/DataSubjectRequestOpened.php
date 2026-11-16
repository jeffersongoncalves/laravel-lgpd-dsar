<?php

namespace JeffersonGoncalves\LgpdDsar\Events;

use JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest;

class DataSubjectRequestOpened
{
    public function __construct(public DataSubjectRequest $request) {}
}
