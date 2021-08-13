<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\RegistrationFormRequest;
use Bachelor\Application\User\Services\UserRegistrationService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRegistrationController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group User Registration
 */
class UserRegistrationController extends BaseController
{
    /**
     * Get data for specified step of registration form
     *
     * @param UserRegistrationService $userRegistration
     * @return JsonResponse
     *
     * @url /api/v2/user/registration/{step}
     * @routeParam step integer required current step Example: 1/2/3/4/5/6
     * @response 200 {
        "message": "Successful",
        "data": {
            "user": {
                "id": 2,
                "name": null,
                "gender": 1,
                "email": null,
                "mobile_number": "0967253526",
                "status": 1,
                "registration_steps": 0,
                "prefecture_id": 1,
                "support_tracking_url": null,
                "team_member_rate": 0,
                "flex_point": 0,
                "cost_plan": "normal",
                "is_fake": 0,
                "invitation_code": null,
                "invitation_url": null,
                "user_profile": null,
                "user_preference": null,
                "user_preferred_places": [],
                "prefecture": {
                    "id": 1,
                    "country_id": 1,
                    "admin_id": 1,
                    "name": "Tokyo",
                    "status": 1,
                    "prefecture_translation": [
                        {
                            "id": 1,
                            "prefecture_id": 1,
                            "language_id": 1,
                            "name": "Tokyo"
                        }
                    ]
                }
            }
        }
    }
     * @response 512 {
     *      "message":"Error Encountered while obtaining data to populate step '.$step .' of registration form in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/UserRegistrationController.php at 82 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function index(UserRegistrationService $userRegistration, int $step): JsonResponse
    {
        // Get data to populate the first step of the registration form
        $response = $userRegistration->retrieveDataAuthorizedUserForRegistration($step);

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Store registration data
     *
     * @param RegistrationFormRequest $request
     * @param UserRegistrationService $userRegistration
     * @return JsonResponse
     *
     *
     * @url /api/v2/user/registration/{step}/store
     * @routeParam step required int Indicates the current registration step. Example: 1/2/3/4/5/6
     *
     * Step One
     *
     * @url /api/v2/user/registration/{step}
     * @bodyParam prefectureId integer required The Id of the prefecture
     * @bodyParam userPreferredAreas array required The Ids of the preferred areas
     * @bodyParam name string required The name of the user
     * @bodyParam name integer required The gender of the user
     * @bodyParam year integer required The birthday year
     * @bodyParam month integer required The month year
     * @bodyParam day integer required The day year
     * @bodyParam email string required The email of the user
     *
     * Step Two
     *
     * @url /api/v2/user/registration/{step}
     * @bodyParam minAge integer required Min age preference. Example: 23
     * @bodyParam maxAge integer required Max age preference. Example: 31
     * @bodyParam minHeight integer required Min height preference. Example: 165
     * @bodyParam maxHeight integer required Max height preference. Example: 189
     * @bodyParam facePreferences array required Face preference. Example: [ "st_01", "st_02", "st_04" ]
     * @bodyParam job array required Job preference. Example: [ 1, 2, 3, 4, 5, 6, 7, 8 ]
     *
     * Step Three
     *
     * @bodyParam bodyType1 integer required Body type 1 preference. Example: 1
     * @bodyParam bodyType2 integer required Body type 2 preference. Example: 3
     *
     * Step Four
     *
     * @bodyParam height integer required Height of the user. Example: 190
     * @bodyParam bodyShape integer required Body Shape of the user. Example: 3
     * @bodyParam willingnessForMarriage integer required Willingness For Marriage of the user. Example: 2
     * @bodyParam smoking integer required Smoking Preference of the user. Example: 2
     * @bodyParam alcohol integer required Alcohol Preference of the user. Example: 2
     * @bodyParam divorce integer required Divorce Preference of the user. Example: 2
     * @bodyParam companyName string required Company Name of the user. Example: Freelancer
     * @bodyParam education integer required Education of the user. Example: 3
     * @bodyParam annualIncome integer required Annual Income of the user. Example: 9
     * @bodyParam job integer required Job of the user. Example: 6
     * @bodyParam schoolName string required School Name of the user. Example: メトロＩＴビジネスカレッジ
     * @bodyParam schoolCode string required School code of the user. Example: SC005111
     *
     * Step Five
     *
     * @bodyParam strengthsOfAppearance array required Strength of Appearance of the user. Example: ["st_02","st_03","st_08","st_10"]
     * @bodyParam featuresOfAppearance array required Feature of Appearance of the user. Example: ["fe_01","fe_03","fe_04","fe_06","fe_11"]
     * @bodyParam character array required Character of the user. Example: [3,5,7,10,19]
     * @bodyParam hobby array required Hobby of the user. Example: [1,3,5,7,8,9,10,11,14,17,18,19,21,23,25]
     *
     * Step Six
     *
     * TODO : Belongs to credit/debit card implementation part
     *
     * @response 200 {
        "message": "Successful",
        "data": {
        "user": {
            "id": 2,
            "name": "Test",
            "gender": 1,
            "email": "mavericksthinker@gmail.com",
            "mobile_number": "0967253526",
            "status": 1,
            "registration_steps": 1,
            "prefecture_id": 1,
            "support_tracking_url": null,
            "team_member_rate": 0,
            "flex_point": 0,
            "cost_plan": "normal",
            "is_fake": 0,
            "invitation_code": null,
            "invitation_url": null,
            "user_profile": {
            "id": 1,
            "user_id": 2,
            "birthday": "1994-09-12",
            "age": 26,
            "height": null,
            "body_type": {
            "displayName": null,
            "value": null
            },
            "marriage_intention": {
                "displayName": null,
                "value": null
            },
            "character": {
                "displayName": null,
                "value": null
            },
            "smoking": {
                "displayName": null,
                "value": null
            },
            "drinking": {
                "displayName": null,
                "value": null
            },
            "divorce": {
                "displayName": null,
                "value": null
            },
            "annual_income": {
                "displayName": null,
                "value": null
            },
            "appearance_strength": {
                "displayName": null,
                "value": null
            },
            "appearance_features": {
                "displayName": null,
                "value": null
            },
            "education": {
                "displayName": null,
                "value": null
            },
            "school_name": null,
            "company_name": null,
            "job": {
                "displayName": null,
                "value": null
            },
            "hobby": {
                "displayName": null,
                "value": null
            },
            "education_group": {
                "displayName": null,
                "value": null
            },
            "school_code": null
            },
            "user_preference": null,
            "user_preferred_places": [
                {
                    "id": 2,
                    "user_id": 2,
                    "area_id": 1,
                    "priority": 1
                },
                {
                    "id": 4,
                    "user_id": 2,
                    "area_id": 2,
                    "priority": 2
                },
                {
                    "id": 5,
                    "user_id": 2,
                    "area_id": 3,
                    "priority": 3
                }
            ],
            "prefecture": {
                "id": 1,
                "country_id": 1,
                "admin_id": 1,
                "name": "Tokyo",
                "status": 1,
                "prefecture_translation": [
                     {
                        "id": 1,
                        "prefecture_id": 1,
                        "language_id": 1,
                        "name": "Tokyo"
                    }
                ]
              }
            },
            "formData": {
            "preferredMinAge": [
                  {
                    "value": 20,
                    "sort": 0,
                    "status": 1,
                    "register_options_translations": [
                    {
                        "label_name": "Preferred Male Minimum Age",
                        "display_name": "Preferred Male Minimum Age"
                    },
                    {
                        "label_name": "Preferred Male Minimum Age",
                        "display_name": "相手の年齢(最小)"
                    }
                ]
                }
            ],
            "preferredMaxAge": [
            {
                "value": 45,
                "sort": 0,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Preferred Male Maximum Age",
                    "display_name": "Preferred Male Maximum Age"
                },
                {
                    "label_name": "Preferred Male Maximum Age",
                    "display_name": "相手の年齢(最大)"
                }
                ]
               }
            ],
            "preferredMinHeight": [
            {
                "value": 150,
                "sort": 0,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Preferred Male Minimum Height",
                    "display_name": "Less Than 159"
                },
                {
                    "label_name": "Preferred Male Minimum Height",
                    "display_name": "159cm以下"
                }
            ]
            }
            ],
            "preferredMaxHeight": [
                {
                "value": 180,
                "sort": 0,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Preferred Male Maximum Height",
                    "display_name": "More Than 191"
                },
                {
                    "label_name": "Preferred Male Maximum Height",
                    "display_name": "191cm以上"
                }
            ]
            }
            ],
            "preferredBodyShape": [
            {
                "value": 0,
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Skinny",
                    "display_name": "Skinny"
                },
                {
                    "label_name": "Skinny",
                    "display_name": "スリム"
                }
            ]
            },
            {
                "value": 1,
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Skinny Fit",
                    "display_name": "Skinny Fit"
                },
                {
                    "label_name": "Skinny Fit",
                    "display_name": "やや細め"
                }
            ]
            },
            {
                "value": 2,
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Fit",
                    "display_name": "Fit"
                },
                {
                    "label_name": "Fit",
                    "display_name": "普通"
                }
            ]
            },
            {
                "value": 3,
                "sort": 4,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Curvy",
                    "display_name": "Curvy"
                },
                {
                    "label_name": "Curvy",
                    "display_name": "ややぽっちゃり"
                }
            ]
            }
            ],
            "preferredSmoke": [
            {
                "value": 0,
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "I Don't Mind",
                    "display_name": "I Don't Mind"
                },
                {
                    "label_name": "I Don't Mind",
                    "display_name": "気にしない"
                }
            ]
            },
            {
                "value": 1,
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Electrical Smoker Is OK",
                    "display_name": "Electrical Smoker Is OK"
                },
                {
                    "label_name": "Electrical Smoker Is OK",
                    "display_name": "電子タバコならOK"
                }
            ]
            },
            {
                "value": 2,
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Sometimes Is OK",
                    "display_name": "Sometimes Is OK"
                },
                {
                    "label_name": "Sometimes Is OK",
                    "display_name": "時々ならOK"
                }
            ]
            },
            {
                "value": 3,
                "sort": 4,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Prefer Not Smoker",
                    "display_name": "Prefer Not Smoker"
                },
                {
                    "label_name": "Prefer Not Smoker",
                    "display_name": "吸わない人がいい"
                }
            ]
            }
            ],
            "preferredDrink": [
            {
                "value": 0,
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "I Don't Mind",
                    "display_name": "I Don't Mind"
                },
                {
                    "label_name": "I Don't Mind",
                    "display_name": "気にしない"
                }
            ]
            },
            {
                "value": 1,
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Prefers Drinker",
                    "display_name": "Prefers Drinker"
                },
                {
                    "label_name": "Prefers Drinker",
                    "display_name": "飲む人がいい"
                }
            ]
            },
            {
                "value": 2,
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Sometimes Is OK",
                    "display_name": "Sometimes Is OK"
                },
                {
                    "label_name": "Sometimes Is OK",
                    "display_name": "時々飲む人ならOK"
                }
            ]
            },
            {
                "value": 3,
                "sort": 4,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Prefer Not Drinker",
                    "display_name": "Prefer Not Drinker"
                },
                {
                    "label_name": "Prefer Not Drinker",
                    "display_name": "飲んで欲しくない"
                }
            ]
            }
            ],
            "preferredDivorced": [
            {
                "value": 0,
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "I Don't Mind",
                    "display_name": "I Don't Mind"
                },
                {
                    "label_name": "I Don't Mind",
                    "display_name": "気にしない"
                }
            ]
            },
            {
                "value": 1,
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "No history of divorce/No kids",
                    "display_name": "No history of divorce/No kids"
                },
                {
                    "label_name": "No history of divorce/No kids",
                    "display_name": "なしがいい"
                }
            ]
            },
            {
                "value": 2,
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Divorced OK but should have No kids",
                    "display_name": "Divorced OK but should have No kids"
                },
                {
                    "label_name": "Divorced OK but should have No kids",
                    "display_name": "子供がいなければいい"
                }
            ]
            },
            {
                "value": 3,
                "sort": 4,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Divorced OK / Have kids OK but must live separately",
                    "display_name": "Divorced OK / Have kids OK but must live separately"
                },
                {
                    "label_name": "Divorced OK / Have kids OK but must live separately",
                    "display_name": "別居していればいい"
                }
            ]
            }
            ],
            "appearanceStrength": [
            {
                "value": "st_00",
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Beautiful Teeth",
                    "display_name": "Beautiful Teeth"
                },
                {
                    "label_name": "Beautiful Teeth",
                    "display_name": "歯並び"
                }
            ]
            },
            {
                "value": "st_01",
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Beautiful Skin",
                    "display_name": "Beautiful Skin"
                },
                {
                    "label_name": "Beautiful Skin",
                    "display_name": "肌"
                }
            ]
            },
            {
                "value": "st_02",
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Beautiful Eyes",
                    "display_name": "Beautiful Eyes"
                },
                {
                    "label_name": "Beautiful Eyes",
                    "display_name": "目がぱっちり"
                }
            ]
            },
            {
                "value": "st_03",
                "sort": 4,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Beautiful Nose",
                    "display_name": "Beautiful Nose"
                },
                {
                    "label_name": "Beautiful Nose",
                    "display_name": "鼻筋"
                }
            ]
            },
            {
                "value": "st_04",
                "sort": 5,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Beautiful Face Shape",
                    "display_name": "Beautiful Face Shape"
                },
                {
                    "label_name": "Beautiful Face Shape",
                    "display_name": "小顔"
                }
            ]
            },
            {
                "value": "st_05",
                "sort": 6,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Dimple",
                    "display_name": "Dimple"
                },
                {
                    "label_name": "Dimple",
                    "display_name": "エクボ"
                }
            ]
            },
            {
                "value": "st_06",
                "sort": 7,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Double Tooth",
                    "display_name": "Double Tooth"
                },
                {
                    "label_name": "Double Tooth",
                    "display_name": "八重歯"
                }
            ]
            },
            {
                "value": "st_07",
                "sort": 8,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Beautiful Smile",
                    "display_name": "Beautiful Smile"
                },
                {
                    "label_name": "Beautiful Smile",
                    "display_name": "笑顔"
                }
            ]
            },
            {
                "value": "st_08",
                "sort": 9,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Sexy",
                    "display_name": "Sexy"
                },
                {
                    "label_name": "Sexy",
                    "display_name": "色気"
                }
            ]
            },
            {
                "value": "st_09",
                "sort": 10,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Smile Lines",
                    "display_name": "Smile Lines"
                },
                {
                    "label_name": "Smile Lines",
                    "display_name": "笑いジワ"
                }
            ]
            },
            {
                "value": "st_10",
                "sort": 11,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Voluptuous / Hunky",
                    "display_name": "Voluptuous / Hunky"
                },
                {
                    "label_name": "Voluptuous / Hunky",
                    "display_name": "グラマー / 筋肉質"
                }
            ]
            }
            ],
            "preferredEducation": [
            {
                "value": 0,
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "I Don't Mind",
                    "display_name": "I Don't Mind"
                },
                {
                    "label_name": "I Don't Mind",
                    "display_name": "気にしない"
                }
            ]
            },
            {
                "value": 1,
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Prefer More Than Uni",
                    "display_name": "Prefer More Than Uni"
                },
                {
                    "label_name": "Prefer More Than Uni",
                    "display_name": "大卒ならいい"
                }
            ]
            },
            {
                "value": 2,
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Prefer More Than Famous Uni",
                    "display_name": "Prefer More Than Famous Uni"
                },
                {
                    "label_name": "Prefer More Than Famous Uni",
                    "display_name": "有名大学卒がいい"
                }
            ]
            }
            ],
            "preferredAnnualIncome": [
            {
                "value": 2,
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "I Don't Mind",
                    "display_name": "I Don't Mind"
                },
                {
                    "label_name": "I Don't Mind",
                    "display_name": "気にしない"
                }
            ]
            },
            {
                "value": 3,
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "More Than 6 Million Yen",
                    "display_name": "More Than 6 Million Yen"
                },
                {
                    "label_name": "More Than 6 Million Yen",
                    "display_name": "600万円〜"
                }
            ]
            },
            {
                "value": 4,
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "More Than 8 Million Yen",
                    "display_name": "More Than 8 Million Yen"
                },
                {
                    "label_name": "More Than 8 Million Yen",
                    "display_name": "800万円~"
                }
            ]
            },
            {
                "value": 5,
                "sort": 4,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "More Than 10 Million Yen",
                    "display_name": "More Than 10 Million Yen"
                },
                {
                    "label_name": "More Than 10 Million Yen",
                    "display_name": "1000万円~"
                }
            ]
            },
            {
                "value": 6,
                "sort": 5,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "More Than 15 Million Yen",
                    "display_name": "More Than 15 Million Yen"
                },
                {
                    "label_name": "More Than 15 Million Yen",
                    "display_name": "1500万円~"
                }
            ]
            },
            {
                "value": 7,
                "sort": 6,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "More Than 20 Million Yen",
                    "display_name": "More Than 20 Million Yen"
                },
                {
                    "label_name": "More Than 20 Million Yen",
                    "display_name": "2000万円~"
                }
            ]
            }
            ],
            "preferredJob": [
            {
                "value": 1,
                "sort": 1,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Nurse",
                    "display_name": "Nurse"
                },
                {
                    "label_name": "Nurse",
                    "display_name": "看護師"
                }
            ]
            },
            {
                "value": 2,
                "sort": 2,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Childminder",
                    "display_name": "Childminder"
                },
                {
                    "label_name": "Childminder",
                    "display_name": "保育士"
                }
            ]
            },
            {
                "value": 3,
                "sort": 3,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Flight Attendant",
                    "display_name": "Flight Attendant"
                },
                {
                    "label_name": "Flight Attendant",
                    "display_name": "客室乗務員"
                }
            ]
            },
            {
                "value": 4,
                "sort": 4,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "A Secretary",
                    "display_name": "A Secretary"
                },
                {
                    "label_name": "A Secretary",
                    "display_name": "秘書"
                }
            ]
            },
            {
                "value": 5,
                "sort": 5,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Model",
                    "display_name": "Model"
                },
                {
                    "label_name": "Model",
                    "display_name": "モデル"
                }
            ]
            },
            {
                "value": 6,
                "sort": 6,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Doctor",
                    "display_name": "Doctor"
                },
                {
                    "label_name": "Doctor",
                    "display_name": "医者"
                }
            ]
            },
            {
                "value": 7,
                "sort": 7,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Management",
                    "display_name": "Management"
                },
                {
                    "label_name": "Management",
                    "display_name": "経営者"
                }
            ]
            },
            {
                "value": 8,
                "sort": 8,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Hairdresser",
                    "display_name": "Hairdresser"
                },
                {
                    "label_name": "Hairdresser",
                    "display_name": "美容師"
                }
            ]
            },
            {
                "value": 9,
                "sort": 9,
                "status": 1,
                "register_options_translations": [
                {
                    "label_name": "Esthetic / Nailist",
                    "display_name": "Esthetic / Nailist"
                },
                {
                    "label_name": "Esthetic / Nailist",
                    "display_name": "エステ/ネイリスト"
                }
            ]
            }
            ]
          }
        }
    }
     * @response 512 {
     *      "message":"Error Encountered while obtaining data to populate step'.request('step').' of registration form in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/UserRegistrationController.php at 82 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function store(RegistrationFormRequest $request, UserRegistrationService $userRegistration, int $step): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Retrieve all the request params
            $data = $request->all();

            // Store registration form data for authorized user and get data to populate the first step of the registration form
            $response = $userRegistration->storeAndRetrieveDataForNextRegistrationStep($data, $step);

            DB::commit();

            // set api response
            self::setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $exception) {

            DB::rollBack();
            throw $exception;
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * @param ImageUploadRequest $request
     * @param UserRegistrationService $userRegistration
     * @return JsonResponse
     */
    public function storeImage(ImageUploadRequest $request, UserRegistrationService $userRegistration)
    {
        try {
            DB::beginTransaction();
            // Store registration form data for authorized user and get data to populate the first step of the registration form
            $response = $userRegistration->storeImage($request);

            DB::commit();

            // set api response
            self::setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $exception) {

            DB::rollBack();

            throw $exception;
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
