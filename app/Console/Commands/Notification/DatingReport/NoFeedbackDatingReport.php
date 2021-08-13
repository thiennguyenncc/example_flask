<?php

namespace App\Console\Commands\Notification\DatingReport;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\DatingReport\Services\DatingReportDomainService;
use Bachelor\Domain\FeedbackManagement\Feedback\Enums\CalculateableDatingReport;
use Bachelor\Domain\FeedbackManagement\Feedback\Enums\FeedbackProperty;
use Bachelor\Domain\FeedbackManagement\Feedback\Interfaces\FeedbackRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\CompletedDatingNoFBByPartner;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\CollectionHelper;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Carbon\Carbon;

class NoFeedbackDatingReport extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:dating-report-no-feedback {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to users, who dont have feedback on 9am thursday or sunday';

    /**
     * @var FeedbackRepositoryInterface
     */
    protected FeedbackRepositoryInterface $feedbackRepository;

    /**
     * @var DatingReportRepositoryInterface
     */
    protected DatingReportRepositoryInterface $datingReportRepository;

    /**
     * @var DatingReportDomainService
     */
    protected DatingReportDomainService $datingReportDomainService;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        FeedbackRepositoryInterface $feedbackRepository,
        DatingReportRepositoryInterface $datingReportRepository,
        DatingReportDomainService $datingReportDomainService,
        CompletedDatingNoFBByPartner $completedDatingNoFBByPartner
    ) {
        $this->feedbackRepository = $feedbackRepository;
        $this->datingReportRepository = $datingReportRepository;
        $this->datingReportDomainService = $datingReportDomainService;
        $this->eligibleReceiver = $completedDatingNoFBByPartner;

        if (now()->isThursday()) {
            $this->eligibleReceiver->fromDatingDate = Carbon::today()->startOfWeek()->subDays(2);
            $this->eligibleReceiver->toDatingDate = Carbon::today()->startOfWeek();
        } elseif (now()->isSunday()) {
            $this->eligibleReceiver->fromDatingDate = Carbon::today()->subDays(4);
            $this->eligibleReceiver->toDatingDate = Carbon::today()->subDays(3);
        }

        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.dating_report_no_feedback_for_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.dating_report_no_feedback_for_male_users');
        }

        return null;
    }

    protected function proceedSendingNotification(User $user, Notification $notification): void
    {
        $notification->mapVariable('required_review_number_for_next_renewal', $this->variableMapDatas[$user->getId()] ?? config('constants.report_generate_frequency_fb'));

        parent::proceedSendingNotification($user, $notification);
    }

    /**
     * @return array
     */
    protected function addVariableMapDatas(): void
    {
        $userIds = CollectionHelper::convEntitiesToPropertyArray($this->eligibleUsers, UserProperty::Id);

        $feedbacks = $this->feedbackRepository->getLateFeedbacksForUserIds(
            $userIds,
            CalculateableDatingReport::Enable,
            [FeedbackProperty::DatingReportGenerateFeedbacks]
        );
        $feedbacksByFeedbackFor = $feedbacks->groupBy(function (Feedback $feedback) {
            return $feedback->getFeedbackFor()->getId();
        });

        $results = [];
        foreach ($feedbacksByFeedbackFor as $feedbackFor => $feedbacks) {
            $latestFeedbacks = $feedbacks->take(config('constants.calc_fb_num_per_report'));
            $results[$feedbackFor] = $this->datingReportDomainService->getRequiredFeedbackNumberForNext($latestFeedbacks);
        }

        $this->variableMapDatas = $results;
    }
}
