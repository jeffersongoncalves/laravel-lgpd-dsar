<?php

namespace JeffersonGoncalves\LgpdDsar\Events;

use JeffersonGoncalves\LgpdDsar\Models\DataSubjectRequest;

/**
 * Completed or rejected: check $request->status. Notify the requester from a listener.
 */
class DataSubjectRequestClosed
{
    public function __construct(public DataSubjectRequest $request) {}
}
