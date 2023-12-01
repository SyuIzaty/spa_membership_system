<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use Carbon\Carbon;
use App\IsmApplication;
use App\IsmApplicationTrack;
use App\IsmConfirmationReminder;
use Illuminate\Console\Command;
use App\Mail\Stationery\StationeryConfirmationMail;

class StationeryConfirmationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stationery_confirm:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder for the manager to send a follow-up after three days from the initial reminder.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $applications = IsmApplication::where('current_status', 'AC')->get();

        foreach ($applications as $application) {

            $track = IsmApplicationTrack::where('application_id', $application->id)
                ->where('status_id', $application->current_status)
                ->first();

            $reminder = IsmConfirmationReminder::where('application_track_id', $track->id)
                ->latest('created_at')
                ->first();

            if ($reminder) {
                $createdAt = Carbon::parse($reminder->created_at);
                $now = Carbon::now();

                // Check if it's 3 days after the creation date
                if ($now->diffInDays($createdAt) >= 3) {

                    $managers = User::whereHas('roles', function ($query) {
                        $query->where('id', 'ISM002');
                    })->where('active', 'Y')->get();

                    foreach ($managers as $manager) {
                        try {
                            $email = new StationeryConfirmationMail($manager, $application);

                            $recipientEmail = $manager->email ?? 'norsyuhada.kahar@intec.edu.my';
                            Mail::to($recipientEmail)->send($email);

                        } catch (\Exception $e) {

                            // Handle email sending error, log it, or throw a custom exception
                            \Log::error('Error sending email: ' . $e->getMessage());

                        }
                    }

                }
            }
        }
    }

}
