<?php

namespace App\Console;

use App\Console\Commands\CreateMatchingDate;
use App\Console\Commands\IssueCouponForCancelledUser;
use App\Console\Commands\Notification\Feedback\CompletedDatingToday;
use App\Console\Commands\Notification\Feedback\NoFillFeedbackLastDating;
use App\Console\Commands\Notification\Matching\DatingReminderNotification;
use App\Console\Commands\Notification\Matching\MatchedRematchingNotification;
use App\Console\Commands\Notification\Matching\MatchingChatOpenForFakeUsersNotification;
use App\Console\Commands\Notification\Matching\MatchingChatOpenForUsersNotification;
use App\Console\Commands\Notification\Matching\MatchingReminderNotification;
use App\Console\Commands\Notification\Matching\NotMatchedForFeMaleUsersInMainMatchingNotification;
use App\Console\Commands\Notification\Matching\NotMatchedRematchingForTrialMaleUsers;
use App\Console\Commands\Notification\Matching\NotMatchedRematchingNotification;
use App\Console\Commands\Notification\Matching\NotMatchedRematchingRequested;
use App\Console\Commands\Notification\Matching\RematchingReminderFemaleUsersNotification;
use App\Console\Commands\Notification\Sms\SendSmsForUnreadEmailUsers;
use App\Console\Commands\PeriodicallyIssueCoupons;
use App\Console\Commands\ReturnCouponFromCanceledDating;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BachelorRepositoryGenerator;
use App\Console\Commands\BachelorControllerGenerator;
use App\Console\Commands\CancelFakeDating;
use App\Console\Commands\Notification\DatingReport\NoFeedbackDatingReport;
use App\Console\Commands\Notification\DatingReport\NoUpdatedDatingReport;
use App\Console\Commands\Notification\DatingReport\UpdatedDatingReport;
use App\Console\Commands\Notification\Dating\WeeklyDatingCouponIssuedForMaleUser;
use App\Console\Commands\Notification\Participation\ParticipationReminderHasParticipation;
use App\Console\Commands\Notification\Participation\ParticipationReminderHasNoParticipation;
use App\Console\Commands\CancelParticipantMainMatchOnDeadline;
use App\Console\Commands\CheckExpiredGracePeriod;
use App\Console\Commands\CompleteDating;
use App\Console\Commands\CompleteTrial;
use App\Console\Commands\Notification\RegistrationAndApproval\FinalReminderFor2ndRegistrationUsers;
use App\Console\Commands\Notification\RegistrationAndApproval\FirstDatingCompleted;
use App\Console\Commands\Notification\RegistrationAndApproval\FirstReminderFor2ndRegistrationUsers;
use App\Console\Commands\Notification\RegistrationAndApproval\ParticipationReminderTempCancel;
use App\Console\Commands\Notification\RegistrationAndApproval\SecondReminderFor2ndRegistrationUsers;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BachelorRepositoryGenerator::class,
        BachelorControllerGenerator::class,
        CreateMatchingDate::class,
    ];

    /**
     * dating day
     *
     * @var array
     */
    private $datingDays = [
        Schedule::WEDNESDAY,
        Schedule::SATURDAY,
        Schedule::SUNDAY
    ];

    /**
     * before dating day
     *
     * @var array
     */
    private $dayBeforeDatingDays = [
        Schedule::TUESDAY,
        Schedule::FRIDAY,
        Schedule::SATURDAY
    ];

    /**
     * after dating day
     *
     * @var array
     */
    private $dayAfterDatingDays = [
        Schedule::THURSDAY,
        Schedule::SUNDAY,
        Schedule::MONDAY
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->setNotificationSchedule($schedule);

        //send sms for user unread email
        $schedule->command(SendSmsForUnreadEmailUsers::class)->everyTenMinutes();

        //dating
        $schedule->command(CompleteDating::class)->dailyAt('21:00')->days($this->datingDays);
        $schedule->command(CancelFakeDating::class)->dailyAt('20:00')->days($this->dayBeforeDatingDays);

        //coupon
        $schedule->command(ReturnCouponFromCanceledDating::class)->dailyAt('21:00')->days($this->datingDays);
        $schedule->command(PeriodicallyIssueCoupons::class, ['--weekly'])->weeklyOn(Schedule::SUNDAY, '21:00');
        $schedule->command(IssueCouponForCancelledUser::class)->dailyAt('21:00')->days($this->datingDays);

        //Cancel Participant Main Match On Participate Deadline
        $schedule->command(CancelParticipantMainMatchOnDeadline::class)->dailyAt('0:00');

        //create new dating day
        $schedule->command(CreateMatchingDate::class)->weeklyOn(Schedule::MONDAY, '0:00');

        //payment
        $schedule->command(CompleteTrial::class)->dailyAt('0:00')->days($this->dayAfterDatingDays);
        $schedule->command(CheckExpiredGracePeriod::class)->dailyAt('0:00');
    }


    private function setNotificationSchedule(Schedule $schedule)
    {
        //registration reminder
        $schedule->command(FirstReminderFor2ndRegistrationUsers::class, ['female'])->dailyAt('18:00');
        $schedule->command(FirstReminderFor2ndRegistrationUsers::class, ['male'])->dailyAt('18:00');

        $schedule->command(SecondReminderFor2ndRegistrationUsers::class, ['female'])->dailyAt('18:00');
        $schedule->command(SecondReminderFor2ndRegistrationUsers::class, ['male'])->dailyAt('18:00');

        $schedule->command(FinalReminderFor2ndRegistrationUsers::class, ['female'])->dailyAt('12:00');
        $schedule->command(FinalReminderFor2ndRegistrationUsers::class, ['male'])->dailyAt('12:00');

        $schedule->command(ParticipationReminderTempCancel::class, ['male'])->weeklyOn(Schedule::MONDAY, '12:00');

        //dating
        $schedule->command(FirstDatingCompleted::class, ['female'])->weeklyOn(Schedule::MONDAY, '12:00');


        // Feedback Notification
        $schedule->command(CompletedDatingToday::class, ['male'])->dailyAt('21:00')->days($this->datingDays);
        $schedule->command(CompletedDatingToday::class, ['female'])->dailyAt('21:00')->days($this->datingDays);

        $schedule->command(NoFillFeedbackLastDating::class, ['female'])->days([Schedule::TUESDAY, Schedule::FRIDAY])->at('21:00');
        $schedule->command(NoFillFeedbackLastDating::class, ['male'])->days([Schedule::TUESDAY, Schedule::FRIDAY])->at('21:00');

        // Participation notification
        $schedule->command(ParticipationReminderHasNoParticipation::class, ['male'])->weeklyOn(Schedule::MONDAY, '12:00');
        $schedule->command(ParticipationReminderHasNoParticipation::class, ['female'])->weeklyOn(Schedule::MONDAY, '12:00');
        $schedule->command(ParticipationReminderHasParticipation::class, ['male'])->weeklyOn(Schedule::MONDAY, '12:00');
        $schedule->command(ParticipationReminderHasParticipation::class, ['female'])->weeklyOn(Schedule::MONDAY, '12:00');

        // Dating report notification
        $schedule->command(NoFeedbackDatingReport::class, ['male'])->dailyAt('9:00')->days([Schedule::THURSDAY, Schedule::SUNDAY]);
        $schedule->command(NoFeedbackDatingReport::class, ['female'])->dailyAt('9:00')->days([Schedule::THURSDAY, Schedule::SUNDAY]);
        $schedule->command(NoUpdatedDatingReport::class, ['male'])->dailyAt('9:00')->days([Schedule::THURSDAY, Schedule::SUNDAY]);
        $schedule->command(NoUpdatedDatingReport::class, ['female'])->dailyAt('9:00')->days([Schedule::THURSDAY, Schedule::SUNDAY]);
        $schedule->command(UpdatedDatingReport::class, ['male'])->dailyAt('9:00')->days([Schedule::THURSDAY, Schedule::SUNDAY]);
        $schedule->command(UpdatedDatingReport::class, ['female'])->dailyAt('9:00')->days([Schedule::THURSDAY, Schedule::SUNDAY]);

        // Coupon notification
        $schedule->command(WeeklyDatingCouponIssuedForMaleUser::class, ['male'])->weeklyOn(Schedule::SUNDAY, '21:00');

        // Dating Reminder
        $schedule->command(DatingReminderNotification::class, ['male'])->dailyAt('15:00')->days($this->datingDays);
        $schedule->command(DatingReminderNotification::class, ['female'])->dailyAt('15:00')->days($this->datingDays);

        // Matched rematching
        $schedule->command(MatchedRematchingNotification::class, ['male'])->dailyAt('13:00')->days($this->datingDays);
        $schedule->command(MatchedRematchingNotification::class, ['female'])->dailyAt('13:00')->days($this->datingDays);

        // Matching open chat for fake user
        $schedule->command(MatchingChatOpenForFakeUsersNotification::class, ['male'])->dailyAt('15:00')->days($this->dayBeforeDatingDays);
        $schedule->command(MatchingChatOpenForFakeUsersNotification::class, ['female'])->dailyAt('15:00')->days($this->dayBeforeDatingDays);

        // Matching open chat
        $schedule->command(MatchingChatOpenForUsersNotification::class, ['male'])->dailyAt('15:00')->days($this->dayBeforeDatingDays);
        $schedule->command(MatchingChatOpenForUsersNotification::class, ['female'])->dailyAt('15:00')->days($this->dayBeforeDatingDays);

        // Matching reminder
        $schedule->command(MatchingReminderNotification::class, ['male'])->dailyAt('9:00')->days($this->dayBeforeDatingDays);
        $schedule->command(MatchingReminderNotification::class, ['female'])->dailyAt('9:00')->days($this->dayBeforeDatingDays);

        // No matched on main matching
        $schedule->command(NotMatchedForFeMaleUsersInMainMatchingNotification::class, ['male'])->dailyAt('15:00')->days($this->dayBeforeDatingDays);

        // No matched on rematching
        $schedule->command(NotMatchedRematchingNotification::class, ['male'])->dailyAt('13:00')->days($this->datingDays);
        $schedule->command(NotMatchedRematchingNotification::class, ['female'])->dailyAt('13:00')->days($this->datingDays);

        // Rematching reminder
        $schedule->command(RematchingReminderFemaleUsersNotification::class, ['female'])->dailyAt('8:00')->days(Schedule::SATURDAY, Schedule::SUNDAY);
        $schedule->command(RematchingReminderFemaleUsersNotification::class, ['female'])->weeklyOn(Schedule::WEDNESDAY, '7:00');

        // Not matched rematching for trial
        $schedule->command(NotMatchedRematchingForTrialMaleUsers::class, ['male'])->dailyAt('13:00')->days($this->datingDays);

        //Not matched rematching requested
        $schedule->command(NotMatchedRematchingRequested::class, ['female'])->dailyAt('13:00')->days($this->datingDays);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
