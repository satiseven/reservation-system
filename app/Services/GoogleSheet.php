<?php

namespace App\Services;

use Google_Client;

class GoogleSheet
{
    private $spreadSheetId;
    private $client;
    private $googleSheetService;

    public function __construct()
    {
        $this->spreadSheetId = config('google_sheet.google_sheet_id');
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('google_sheet.json'));
        $this->client->addScope(\Google_Service_Sheets::SPREADSHEETS);

        $this->googleSheetService = new \Google_Service_Sheets($this->client);


    }

    public function readGoogleSheet()
    {
        $range = "A1:C2";
        $response = $this->googleSheetService->spreadsheets_values->get($this->spreadSheetId, $range);

        return $response->getValues();
    }
}
