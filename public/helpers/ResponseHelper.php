<?php
/**
 * @Overview 
 * ---------
 * ResponseDefination class keeps definations of all the response 
 * we are going to handle in our api, All Codes are according to 
 * guidelines in RFC7231
 *
 **/


class ResponseHelper {
    const HTTP_404 = 404;
    const HTTP_401 = 401;
    const HTTP_500 = 500;
    const HTTP_200 = 200;
    const HTTP_405 = 405;
    const HTTP_409 = 409;

    const HTTP_404_MSG = 'Error, File Not Found';
    const HTTP_401_MSG = 'Error, Unauthorized Access';
    const HTTP_500_MSG = 'Error, Internal Server Error';
    const HTTP_200_MSG = 'Success, Response Successfull';
    const HTTP_405_MSG = 'Error, Unable to connect database';
    const HTTP_409_MSG = 'Error, Resource Conflict';
}