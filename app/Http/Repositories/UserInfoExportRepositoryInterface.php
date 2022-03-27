<?php

namespace App\Http\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface UserInfoExportRepositoryInterface {

    public function getUsers(Request $reqeust): ?Collection;
    public function exportUserInfoAsCSV(Request $request);
    public function exportUserInfoAsPDF(Request $request);

}