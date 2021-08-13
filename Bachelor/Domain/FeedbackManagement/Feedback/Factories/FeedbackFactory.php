<?php

namespace Bachelor\Domain\FeedbackManagement\Feedback\Factories;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\FeedbackUserReview;
use Bachelor\Domain\UserManagement\User\Models\User;

class FeedbackFactory
{
    public function makeFeedbackEntity(Dating $feedbackByDating, User $feedbackForUser, User $feedbackByUser, array $feedbackFormParams): Feedback
    {
        $feedbackUserReview = new FeedbackUserReview();
        $feedbackUserReview->setFacePoint($feedbackFormParams['face_points'] ?? 0);
        $feedbackUserReview->setPersonalityPoint($feedbackFormParams['personality_points'] ?? 0);
        $feedbackUserReview->setBehaviourPoint($feedbackFormParams['behaviour_points'] ?? 0);
        if(isset($feedbackFormParams['face_points']) && $feedbackFormParams['face_points'] <= 5){
            $feedbackUserReview->setFaceComplaint(json_encode(explode(',', $feedbackFormParams['face_complaint']  ?? '')));
        } else {
            $feedbackUserReview->setFaceGoodFactor(json_encode(explode(',', $feedbackFormParams['face_good_factor']  ?? '')));
        }
        if(isset($feedbackFormParams['personality_points']) && $feedbackFormParams['personality_points'] <= 5){
            $feedbackUserReview->setPersonalityComplaint(json_encode(explode(',', $feedbackFormParams['personality_complaint']  ?? '')));
        } else {
            $feedbackUserReview->setPersonalityGoodFactor(json_encode(explode(',', $feedbackFormParams['personality_good_factor']  ?? '')));
        }
        if(isset($feedbackFormParams['behaviour_points']) && $feedbackFormParams['behaviour_points'] <= 5){
            $feedbackUserReview->setBehaviourComplaint(json_encode(explode(',', $feedbackFormParams['behaviour_complaint'] ?? '')));

        } else {
            $feedbackUserReview->setBehaviourGoodFactor(json_encode(explode(',', $feedbackFormParams['behaviour_good_factor'] ?? '')));
        }
        $feedbackUserReview->setFaceOtherComment($feedbackFormParams['face_other_comment'] ?? '');
        $feedbackUserReview->setPersonalityOtherComment($feedbackFormParams['personality_other_comment'] ?? '');
        $feedbackUserReview->setBehaviourOtherComment($feedbackFormParams['behaviour_other_comment'] ?? '');
        $feedbackUserReview->setBSuitable($feedbackFormParams['b_suitable'] ?? '');
        $feedbackUserReview->setBodyShape($feedbackFormParams['body_shape'] ?? 0);
        $feedbackUserReview->setTheBetterPoint($feedbackFormParams['the_better_point'] ?? 0);
        $feedbackUserReview->setTheWorsePoint($feedbackFormParams['the_worse_point'] ?? 0);
        $feedbackUserReview->setCommentSomethingDifferent($feedbackFormParams['comment_something_different'] ?? '');
        $feedback = new Feedback();
        $feedback->setDating($feedbackByDating);
        $feedback->setFeedbackBy($feedbackByUser);
        $feedback->setFeedbackFor($feedbackForUser);
        $feedback->setLastSatisfaction($feedbackFormParams['last_satisfaction'] ?? 0);
        $feedback->setFeedbackUserReview($feedbackUserReview);
        $feedback->setDatingPlaceReview($feedbackFormParams['dating_place_review'] ?? 0);
        $feedback->setFlex1($feedbackFormParams['flex1'] ?? 0);
        $feedback->setFlex2($feedbackFormParams['flex2'] ?? 0);
        $feedback->setDiscardedAt($feedbackFormParams['discarded_at'] ?? null);
        $feedback->setDatingPlaceReviewComment($feedbackFormParams['dating_place_review_comment'] ?? '');
        $feedback->setAbleToUseDatingPlace($feedbackFormParams['able_to_use_dating_place'] ?? 0);
        $feedback->setWhyNotAbleToUseDatingPlace($feedbackFormParams['why_not_able_to_use_dating_place'] ?? 0);
        $feedback->setDatingPlaceAnyComplaint($feedbackFormParams['dating_place_any_complaint'] ?? '');
        $feedback->setCalculateableDatingReport($feedbackFormParams['calculateable_dating_report'] ?? 1);

        return $feedback;
    }
}
