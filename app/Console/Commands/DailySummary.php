<?php

namespace App\Console\Commands;

use App\Services\Schedule\ScheduleServiceContract;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DailySummary extends Command
{
    const SCHEDULES_QUANTITY_KEY = 'schedulesQty';
    const TOTAL_HOURS_KEY = 'totalHours';
    const TOTAL_AMOUNT_KEY = 'totalAmount';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Daily Summary';

    protected $scheduleService;
    protected $informationLabels;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ScheduleServiceContract $scheduleServiceContract)
    {
        parent::__construct();
        $this->scheduleService = $scheduleServiceContract;
        $this->informationLabels = [
            self::SCHEDULES_QUANTITY_KEY => 'Quantity of appointments attendent',
            self::TOTAL_HOURS_KEY => 'Total of working hours',
            self::TOTAL_AMOUNT_KEY => 'Total amount',
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('This command will generate to you a Daily Schedule Summary, is it what you desire?', true)) {
            $date = Carbon::now();
            if ($this->confirm('First of all, I need to know if you have any specific date in mid', true)) {
                $receivedDate = $this->ask('Which day do you desire? Please, consider the format (YYYY-MM-DD)');
                $receivedDate = $receivedDate ? $receivedDate : $date->format('Y-m-d');

                try {
                    $receivedDate = Carbon::createFromFormat('Y-m-d', $receivedDate)->format('Y-m-d');
                } catch (Exception $exception) {
                    $receivedDate = $date->format('Y-m-d');
                }

                $this->info('So the Summary will be generated for this date: ' . $receivedDate);
            } else {
                $receivedDate = $date->format('Y-m-d');
                $this->info('So the Summary will be generated for this date: ' . $receivedDate);
            }

            $defaultIndex = 0;
            $fieldName = $this->choice(
                'Select 1 of these informations to share with me:',
                ['email', 'login', 'username'],
                $defaultIndex,
                $maxAttempts = null,
                $allowMultipleSelections = false
            );

            $fieldValue = '';
            $fieldValue = $this->ask('Ok, what is your '.$fieldName.'?');

            if (!$fieldValue) {
                $this->error('It is not possible to continue with empty answers. See you later.');
            } else {
                $this->newLine(2);
                $this->warn('The Summary will be generated for the date: '.$date->format('Y-m-d'));
                $this->warn('Using the '.$fieldName.': '.$fieldValue);
                $this->newLine(2);

                try {
                    $dailySummary = $this->scheduleService->generateDailySummary($receivedDate, $fieldName, $fieldValue);
                    $this->newLine(3);
                    $this->warn('################################################################################################################');
                    $this->newLine();
                    $this->line('This is your Daily Summary ('.$receivedDate.'): ');
                    $this->newLine(2);
                    foreach ($dailySummary as $key => $information) {
                        $label = $this->informationLabels[$key];
                        $this->line($label.': '.$information);
                        $this->newLine();
                    }
                    $this->newLine();
                    $this->warn('################################################################################################################');
                    $this->newLine(3);
                } catch (ModelNotFoundException $exception) {
                    $this->error('It was not possible to find an user with these parameters.');
                    $this->error('You are going to need to restart again.');
                } catch (Exception $exception) {
                    $this->error($exception->getMessage());
                    $this->error('You are going to need to restart again.');
                }
            }
        } else {
            $this->info('OK! Once you change your mind, I\'ll be here for you.');
        }
    }
}
