<?php


namespace App\Enums\Responses;

enum ApiResponseCodeEnum: int
{
    case OK = 200;
    case CREATED = 201;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case SERVER_ERROR = 500;
    case UNPROCESSABLE_ENTITY = 422;
    case BAD_REQUEST = 400;
    case CONFLICT = 409; 
}
