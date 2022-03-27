<?php

namespace App\Jobs;

use App\Mail\ExportUserData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ExportUserDataAsCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user, public $usersToExport){}

    public function middleware() {
        return [new RateLimited('exports')];
    }
    public function handle() {
        $columns = [
            'name',
            'email',
            'contract_start_date',
            'contract_end_date',
            'verified',
            'type'
        ];
        $filename = 'export_' . $this->user->id . '.csv';
        if (!File::exists(public_path()."/exports")) {
            File::makeDirectory(public_path() . "/exports");
        }
        $file = fopen(public_path("exports/$filename"), 'w');

        fputcsv($file, $columns); //stavi headere u file

        //ispuni file userima
        foreach($this->usersToExport as $userExport) {
            fputcsv(
                $file,
                [
                    $userExport->name,
                    $userExport->email,
                    $userExport->contract_start_date,
                    $userExport->contract_end_date,
                    $userExport->verified==1 ? 'true': 'false',
                    $userExport->type==1 ? 'Normal': 'Premium',
                ]

            );
        }

        fclose($file);

        Mail::to($this->user)->send(new ExportUserData($filename, 'csv'));
        unlink(public_path("exports/$filename"));
    }
}
