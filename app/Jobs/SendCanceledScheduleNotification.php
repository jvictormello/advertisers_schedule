<?php

namespace App\Jobs;

use App\Models\Schedule;
use App\Services\Notification\NotificationServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCanceledScheduleNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificationService;
    protected $schedule;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(NotificationServiceContract $notificationServiceContract, Schedule $schedule)
    {
        $this->notificationService = $notificationServiceContract;
        $this->schedule = $schedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationData = [
            'schedule_id' => $this->schedule->id,
            'message' => 'The schedule on '.$this->schedule->date.' at '.$this->schedule->starts_at.' has been canceled',
        ];

        $this->notificationService->createNotification($notificationData);
    }
}
