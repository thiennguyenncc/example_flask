@routes
Feature: Health Check existing routes

    @ping_get_admin_route
    Scenario: The listed admin routes should exist and provide expected response
        Given Our application is online to receive requests
        When webapp make a 'get' request to "ping" with no payload
        Then it should get a response of 200

    @ping_get_api_route
    Scenario: The listed admin routes should exist and provide expected response
        Given Our application is online to receive requests
        When webapp make a 'get' request to an api route "ping" with no payload
        Then it should get a response of 200

    @sendVerificationCode_handler
   Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/SmsController' exists to serve the request with 'sendVerificationCode' function

        Examples:
        |  api |
        | send-verification-code |

    @api_exists_sendVerificationCode
    Scenario Outline: Webapp can utilize send_verification_code route to send verification code to the user
        When webapp make a request to "<api>" route with payload:
            |     param     |     value    |
            | mobileNumber |  09672721542 |
            |   country    |     Japan    |
        Then it should get a response of 200

        Examples:
            |  api |
            | send-verification-code |


    @api_exists_param_missing_sendVerificationCode
    Scenario Outline: Webapp can utilize send_verification_code route to send verification code to the user
        When webapp make a request to "<api>" route without param
        Then it should get a response of 302

        Examples:
            |  api |
            | send-verification-code |

    @verifyCode_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/SmsController' exists to serve the request with 'verifyCode' function

        Examples:
            |  api |
            | verify-code |

    @api_exists_verifyCode
    Scenario Outline: Webapp can utilize verify_code route to send verification code to the user
        When verification code was sent to '09672721542'
        And webapp make a request to "<api>" route with payload:
            |     param     |     value    |
            | mobileNumber |  09672721542 |
            | verificationCode |  1111 |
        Then it should get a response of 302

        Examples:
            |  api |
            | verify-code |

    @api_exists_param_missing_verifyCode
    Scenario Outline: Webapp can utilize send_verification_code route to send verification code to the user
        When webapp make a request to "<api>" route without param
        Then it should get a response of 302

        Examples:
            |  api |
            | verify-code |

    @socialLogin_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/AuthenticationController' exists to serve the request with 'socialLogin' function

        Examples:
            |  api |
            | social-login |

    @auth/login/facebook_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/AuthenticationController' exists to serve the request with 'redirectToFacebookProvider' function

        Examples:
            |  api |
            | auth/login/facebook |

    @facebook/callback_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/AuthenticationController' exists to serve the request with 'handleFacebookProviderCallback' function

        Examples:
            |  api |
            | facebook/callback |

    @auth/login/line_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/AuthenticationController' exists to serve the request with 'redirectToLineProvider' function

        Examples:
            |  api |
            | auth/login/line |

    @line/callback_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/AuthenticationController' exists to serve the request with 'handleLineProviderCallback' function

        Examples:
            |  api |
            | line/callback |

    @user/logout_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/AuthenticationController' exists to serve the request with 'logout' function

        Examples:
            |  api |
            | user/logout |

    @migrate-account_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/MigrationController' exists to serve the request with 'migrateAccount' function

        Examples:
            |  api |
            | user/migrate-account |

    @user/registration_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/UserRegistrationController' exists to serve the request with 'index' function

        Examples:
            |  api |
            | user/registration |

    @user/registration/{step}/store_handler
    Scenario Outline: If there is an api route send-verification-code exists in the application then there should be an handler Bachelor/Port/Primary/app/Http/Controller/Api/AuthenticationController@sendVerificationCode
        Given Our application is online to receive requests
        When there is an api route "<api>" exists in our application
        Then there should be an controller 'Bachelor/Port/Primary/WebApi/Controllers/Api/UserRegistrationController' exists to serve the request with 'store' function

        Examples:
            |  api |
            | user/registration/{step}/store |

