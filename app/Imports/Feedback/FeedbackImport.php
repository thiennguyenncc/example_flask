<?php

namespace App\Imports\Feedback;

use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\FeedbackUserReview;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeedbackImport
{
    protected $reviews;

    public function __construct($reviews)
    {
        $this->reviews = $reviews;
    }

    public function handle()
    {
        try {
            foreach ($this->reviews as $review) {
                DB::beginTransaction();
                $userCount = User::whereIn('id', [$review['review_by'], $review['review_for']])->count();
                $dating = Dating::where('id', $review['dating_id'])->first();
                if ($userCount == 2 && $dating) {
                    $feedback = Feedback::create([
                        'id' => $review['id'],
                        'dating_id' => $review['dating_id'],
                        'feedback_by' => $review['review_by'],
                        'feedback_for' => $review['review_for'],
                        'last_satisfaction' => $review['last_satisfaction'],
                        'flex1' => $review['flex1'],
                        'flex2' => $review['flex2'],
                        'dating_place_review' => $review['cafe_review'],
                        'dating_place_review_comment' => $review['cafe_review_comment'],
                        'able_to_use_dating_place' => $review['able_to_use_cafe'],
                        'why_not_able_to_use_dating_place' => $review['not_able_to_use_cafe'],
                        'dating_place_any_complaint' => $review['any_complaint'],
                        'calculateable_dating_report' => $review['use_calculate_dating_report'],
                        'discarded_at' => $review['is_archived'] ? $review['updated_at'] : null,
                        'created_at' => $review['created_at'],
                        'updated_at' => $review['updated_at']
                    ]);

                    $feedbackUserReview = FeedbackUserReview::create([
                        'feedback_id' => $feedback->id,
                        'face_points' => $review['face_points'],
                        'personality_points' => $review['personality_points'],
                        'face_complaint' => json_decode($review['face_complaint']),
                        'face_good_factor' => json_decode($review['face_good_factor']),
                        'face_other_comment' => $review['face_other_comment'],
                        'personality_complaint' => json_decode($review['personality_complaint']),
                        'personality_good_factor' => json_decode($review['personality_good_factor']),
                        'personality_other_comment' => $review['personality_other_comment'],
                        'behaviour_complaint' => json_decode($review['behavior_complaint']),
                        'behaviour_good_factor' => json_decode($review['behavior_good_factor']),
                        'behaviour_other_comment' => $review['behavior_other_comment'],
                        'behaviour_points' => $review['behavior_points'],
                        'body_shape' => $review['body_shape'],
                        'the_better_point' => $review['the_better_point'],
                        'the_worse_point' => $review['the_worse_point'],
                        'comment_something_different' => $review['comment_something_different'],
                        'b_suitable' => $review['b_suitable'],
                        'created_at' => $review['created_at'],
                        'updated_at' => $review['updated_at']
                    ]);
                    if ($feedbackUserReview) {
                    DB::commit();
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Migrate review boxes data fail on id: ' . $review['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
