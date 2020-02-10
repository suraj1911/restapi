<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->library("Authorization_Token");
    }

    public function users_get()
    {
        // Users from a data store e.g. database
        $users = [
            ['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
            ['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
        ];

        $id = $this->get( 'id' );

        if ( $id === null )
        {
            // Check if the users data store contains users
            if ( $users )
            {
                // Set the response and exit
                $this->response( $users, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No users were found'
                ], 404 );
            }
        }
        else
        {
            if ( array_key_exists( $id, $users ) )
            {
                $this->response( $users[$id], 200 );
            }
            else
            {
                $this->response( [
                    'status' => false,
                    'message' => 'No such user found'
                ], 404 );
            }
        }
    }
    public function users_post()
    {
        $name = $this->post("name");
        $password = $this->post("password");

        if($name == "Ravindra" && $password == "123456"){

            $token_data['name'] = "Ravindra";
            $token_data['last_name'] = "Warthi";
            $token_data['time'] = time();

            $token = $this->authorization_token->generateToken($token_data);
            
            //print_r($this->authorization_token->userData());exit;
            $this->response([
                "message"=>"Login Successfully",
                "data"=> $token
            ],RestController::HTTP_OK);

        }

        $this->response(["message"=>"User Not Login"], 400);

    }
}