<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Telegram\Bot\Api;

//require '../vendor/autoload.php';

class ChatBot extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $client = new \GuzzleHttp\Client();
            $response = \Telegram::getUpdates();

            //variable comes here
            $city = "Benin City";
            $body = "TonyOsadolor";
            $chat_id = $response['0']['message']['from']['id'];

            $name = $response['1']['message']['from']['first_name'];

            $response = $client->request('GET', "https://api.github.com/users/$body");
            $githubResponse = json_decode($response->getBody());
            if ($response->getStatusCode() == 200) {
                $message = "Name: $githubResponse->name\n";
                $message .= "Bio: $githubResponse->bio\n";
                $message .= "Lives in: $githubResponse->location\n";
                $message .= "Number of Repos: $githubResponse->public_repos\n";
                $message .= "Followers: $githubResponse->followers devs\n";
                $message .= "Following: $githubResponse->following devs\n";
                $message .= "URL: $githubResponse->html_url\n";
            }

            $response = \Telegram::sendMessage([
                'chat_id' => $chat_id, 
                'text' => $message
              ]);
              
              $messageId = $response->getMessageId();
              return $messageId;

        } catch (RequestException $th){
            $response = \Telegram::sendMessage([
                'chat_id' => $chat_id, 
                'text' => 'Hello  ' .$name .' Your request could not be processed'
              ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'body' => 'required'
            ]);
            $body = $request->input('body');

            $client = new \GuzzleHttp\Client();
            $response = \Telegram::getUpdates();

            //variable comes here
            $chat_id = $response['0']['message']['from']['id'];

            $name = $response['1']['message']['from']['first_name'];

            $response = $client->request('GET', "https://api.github.com/users/$body");
            $githubResponse = json_decode($response->getBody());
            if ($response->getStatusCode() == 200) {
                $message = "Name: $githubResponse->name\n";
                $message .= "Bio: $githubResponse->bio\n";
                $message .= "Lives in: $githubResponse->location\n";
                $message .= "Number of Repos: $githubResponse->public_repos\n";
                $message .= "Followers: $githubResponse->followers devs\n";
                $message .= "Following: $githubResponse->following devs\n";
                $message .= "URL: $githubResponse->html_url\n";

                $response = \Telegram::sendMessage([
                    'chat_id' => $chat_id, 
                    'text' => $message
                  ]);
            } else {
                $response = \Telegram::sendMessage([
                    'chat_id' => $chat_id, 
                    'text' => 'Your Request could not b Processed'
                  ]);
            }              
              $messageId = $response->getMessageId();
              return $messageId;

        } catch (RequestException $th){
            $response = \Telegram::sendMessage([
                'chat_id' => $chat_id, 
                'text' => 'Hello  ' .$name .' Your request could not be processed'
              ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
