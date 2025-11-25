<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $qr;

    public function __construct($order)
    {
        $this->order = $order;

        $this->qr = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate($this->order->order_code);

        // $this->qr = base64_encode(
        //     QrCode::format('png')
        //         ->size(300)
        //         ->errorCorrection('H')
        //         ->generate($this->order->order_code)
        // );
    }

    public function build()
    {
        // Generate PDF dengan QR base64
        $pdf = Pdf::loadView('frontend.page.e-ticket.e-ticket', [
            'order' => $this->order,
            'qr'    => $this->qr
        ]);

        return $this
            ->subject('E-Tiket Waterboom Jogja')
            ->view('frontend.page.e-ticket.e-ticket-print', [
                'order' => $this->order,
                'qr'    => $this->qr
            ])
            ->attachData(
                $pdf->output(),
                'e-ticket.pdf',
                ['mime' => 'application/pdf']
            );
    }
}
