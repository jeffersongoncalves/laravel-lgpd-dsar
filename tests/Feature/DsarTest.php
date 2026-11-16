<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use JeffersonGoncalves\LgpdDsar\Enums\RequestStatus;
use JeffersonGoncalves\LgpdDsar\Enums\RequestType;
use JeffersonGoncalves\LgpdDsar\Events\DataSubjectRequestClosed;
use JeffersonGoncalves\LgpdDsar\Events\DataSubjectRequestOpened;
use JeffersonGoncalves\LgpdDsar\Events\DataSubjectRequestOverdue;
use JeffersonGoncalves\LgpdDsar\Facades\LgpdDsar;
use JeffersonGoncalves\LgpdDsar\Tests\Fixtures\Order;
use JeffersonGoncalves\LgpdDsar\Tests\Fixtures\User;

beforeEach(function () {
    $this->user = User::create(['name' => 'Maria Silva', 'email' => 'maria@example.com', 'tax_id' => '123']);
    Order::create(['user_id' => $this->user->id, 'shipping_address' => 'Rua A, 1', 'total' => 100]);
    Order::create(['user_id' => $this->user->id, 'shipping_address' => 'Rua B, 2', 'total' => 200]);

    $other = User::create(['name' => 'João', 'email' => 'joao@example.com']);
    Order::create(['user_id' => $other->id, 'shipping_address' => 'Rua C, 3', 'total' => 300]);
});

it('opens a request with the legal deadline', function () {
    Event::fake([DataSubjectRequestOpened::class]);
    $this->freezeSecond(); // datetime columns drop microseconds

    $request = LgpdDsar::open(RequestType::Access, requester: ['email' => 'maria@example.com']);

    expect($request->status)->toBe(RequestStatus::Pending)
        ->and($request->due_at->equalTo(now()->addDays(15)))->toBeTrue()
        ->and($request->subject)->toBeNull();

    Event::assertDispatched(DataSubjectRequestOpened::class);
});

it('exports only the subject data, keyed by table', function () {
    expect(LgpdDsar::export($this->user))->toBe([
        'users' => [['name' => 'Maria Silva', 'email' => 'maria@example.com', 'tax_id' => '123']],
        'orders' => [['shipping_address' => 'Rua A, 1'], ['shipping_address' => 'Rua B, 2']],
    ]);
});

it('refuses to fulfil an unverified request', function () {
    LgpdDsar::fulfil(LgpdDsar::open(RequestType::Access, $this->user));
})->throws(LogicException::class, 'Verify');

it('fulfils access with a JSON export on the private disk', function () {
    Storage::fake('local');
    Event::fake([DataSubjectRequestClosed::class]);

    $request = LgpdDsar::open(RequestType::Portability);
    LgpdDsar::verify($request, $this->user);
    LgpdDsar::fulfil($request, 'Sent by email');

    $request->refresh();

    expect($request->status)->toBe(RequestStatus::Completed)
        ->and($request->response)->toBe('Sent by email')
        ->and($request->export_path)->toBe("lgpd/dsar/request-{$request->id}.json")
        ->and(json_decode(Storage::disk('local')->get($request->export_path), true)['orders'])->toHaveCount(2);

    Event::assertDispatched(DataSubjectRequestClosed::class);
});

it('fulfils deletion by anonymizing every record of the subject only', function () {
    $request = LgpdDsar::verify(LgpdDsar::open(RequestType::Deletion, $this->user));
    LgpdDsar::fulfil($request);

    $user = $this->user->fresh();

    expect($user->name)->toBe('M**********')
        ->and($user->email)->not->toBe('maria@example.com')
        ->and($user->tax_id)->toBe('123') // Keep: legal retention
        ->and(Order::where('user_id', $user->id)->pluck('shipping_address')->all())->toBe([null, null])
        ->and(Order::whereNotNull('shipping_address')->pluck('shipping_address')->all())->toBe(['Rua C, 3']);
});

it('leaves manual types to complete()', function () {
    LgpdDsar::fulfil(LgpdDsar::verify(LgpdDsar::open(RequestType::SharingInformation, $this->user)));
})->throws(LogicException::class, 'by hand');

it('rejects with a reason and refuses to reopen', function () {
    $request = LgpdDsar::reject(LgpdDsar::open(RequestType::Deletion, $this->user), 'Legal retention');

    expect($request->status)->toBe(RequestStatus::Rejected);

    LgpdDsar::fulfil(LgpdDsar::verify($request));
})->throws(LogicException::class, 'closed');

it('dispatches an event per overdue request', function () {
    Event::fake([DataSubjectRequestOverdue::class]);
    LgpdDsar::open(RequestType::Access, $this->user);
    LgpdDsar::complete(LgpdDsar::open(RequestType::Access, $this->user));

    $this->travel(16)->days();
    Artisan::call('lgpd:dsar-overdue');

    Event::assertDispatchedTimes(DataSubjectRequestOverdue::class, 1);
});
