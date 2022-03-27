<?php

namespace App\Http\Repositories;
use App\Http\Repositories\UserInfoExportRepositoryInterface;
use App\Jobs\ExportUserDataAsCSV;
use App\Jobs\ExportUserDataAsPDF;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserInfoExportRepository implements UserInfoExportRepositoryInterface {

    private function getFilters(Request $request) {
        $filters = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'contract_start_date' => $request->contract_start_date ?? '',
            'contract_end_date' => $request->contract_end_date ?? '',
            'type' => $request->type ?? '',
            'verified' => $request->verified === 'true'? 1 : ($request->verified === 'false' ? 0: null),
        ];

        return $filters;
    }

    public function getUsers(Request $request): ?Collection {
        $filters = $this->getFilters($request);
        $users = User::query();
        foreach($filters as $key=>$value) {
            if($value !== '' && $value !== null) {
                $users->where($key, 'LIKE',$value);
            }
        }
        $retUsers = $users->get();
        return $retUsers;
    }

    public function exportUserInfoAsCSV(Request $request) {
        $users = Cache::get('users-for-' . $request->user()->id);
        if($users === null) {
            $users = $this->getUsers($request);
        }
        ExportUserDataAsCSV::dispatch($request->user(), $users);
    }

    public function exportUserInfoAsPDF(Request $request) {
        $users = Cache::get('users-for-' . $request->user()->id);
        if($users === null) {
            $users = $this->getUsers($request);
        }
        ExportUserDataAsPDF::dispatch($request->user(), $users);
    }

}