<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExportUserData extends Mailable
{
    use Queueable, SerializesModels;

    public string $filename;

    public function __construct(string $filename, public string $extension) {
        $this->filename = public_path("exports/$filename");
    }

    public function build()
    {
        $ext = $this->extension;
        return $this->from('exports@example.com', 'Exports')
                    ->view('mails.export')
                    ->attach($this->filename, [
                        'as' => "data.$ext",
        ]);
    }
}
