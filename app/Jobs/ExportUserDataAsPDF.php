<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\File;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExportUserData;

class ExportUserDataAsPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user, public $users){}

    public function middleware() {
        return [new RateLimited('exports')];
    }

    public function handle() {
        if (!File::exists(public_path()."/exports")) {
            File::makeDirectory(public_path() . "/exports");
        }
        $filename = 'export_' . $this->user->id . '.pdf';
        $data = [
            'users' => $this->users
        ];
        $pdf = PDF::loadView('exports.pdfTemplate', $data)->save(public_path("exports/$filename"));
        Mail::to($this->user)->send(new ExportUserData($filename, 'pdf'));
        unlink(public_path("exports/$filename"));
    }
}
