<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThongBaoMuaHang extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $content;
    public $userName;
    public $tongtien;
    public function __construct($userName,$content,$tongtien)
    {
        
        $this->userName = $userName;
        $this->content = $content;
        $this->tongtien = $tongtien;

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     $now = now()->format('d-m-Y');
    //     return new Envelope(
    //         subject: 'Khách Hàng Nạp Tiền:'.$now
    //     );
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'Mail.ThongBaoNapTien',
    //         with: [
    //             'userName'    => $this->userName,
    //             'soTienDaNap' => $this->soTienDaNap,
    //         ],
    //     );
    // }

    public function build()
    {
        // dd($this->userName);
        return $this->subject($this->userName." Shopping Tại Web")->view('Mail.ThongBaoMuaHang')
       ->with([
                    'userName' => $this->userName,
                    'content'  => $this->content,
                    'tongtien' => $this->tongtien,
        ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    // public function attachments()
    // {
    //     return [];
    // }
}
