<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Repositories\UserInfoExportRepositoryInterface;

class InfoExportController extends Controller {

    public function __construct(protected UserInfoExportRepositoryInterface $userInfoExportRepository){}

    public function fetchUsers(Request $request) {
        
        $users = $this->userInfoExportRepository->getUsers($request);
        return response([
            'users' => $users
        ], 200);
    }

    public function exportUserInfoAsPDF(Request $request) {
        try {
            $this->userInfoExportRepository->exportUserInfoAsPDF($request);
            return response([
                'message' => 'User information successfully exported'
            ], 200);
        }catch(Exception $e) {
            return response([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function exportUserInfoAsCSV(Request $request) {
        try {
            $this->userInfoExportRepository->exportUserInfoAsCSV($request);
            return response([
                'message' => 'User information successfully exported to your e-mail address'
            ], 200);
        }catch(Exception $e) {
            return response([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
