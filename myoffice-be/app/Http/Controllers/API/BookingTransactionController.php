<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class BookingTransactionController extends Controller
{
    public function store(StoreBookingTransactionRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        $officeSpace = OfficeSpace::find($validatedData['office_space_id']); //cek apakah office space ada

        //cek apakah office space sudah dibooking
        $validatedData['is_paid'] = false;
        $validatedData['booking_trx_id'] = BookingTransaction::generateUniqeTrxId();
        $validatedData['duration'] = $officeSpace->duration;

        //cek kapan booking dimulai dan berakhir
        $validatedData['ended_date'] = (new \DateTime($validatedData['started_date']))->modify("+{$officeSpace->duration} days")->format('Y-m-d');

        $bookingTransaction = BookingTransaction::create($validatedData);
        $bookingTransaction->load('officeSpace'); //load office space relation

        return new BookingTransactionResource($bookingTransaction);

        //kirim notif via sms dan whatsapp with twilio
        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $messageBody = "Hi {$bookingTransaction->name}, Booking berhasil dilakukan. Terimakasih telah booking di kantor {$bookingTransaction->officeSpace->name}.\n\n";
        $messageBody = "Pesanan Anda sedang kami proses dengan Booking ID: {$bookingTransaction->booking_trx_id}.\n\n";
        $messageBody = "Kami akan menghubungi kembali untuk status booking anda.";
        // $meesageBody = "waktunya booking anda adalah {$bookingTransaction->started_date} s/d {$bookingTransaction->ended_date}.\n\n";
        // $messageBody = "Jika ada pertanyaan silahkan hubungi kami di 08123456789.\n\n";
        // $messageBody = "Terimakasih,\nMyOffice";

        //send SMS
        $message = $twilio->messages->create(
            // "+17626675287",
            "+{$bookingTransaction->phone_number}",
            [
                'from' => getenv('TWILIO_PHONE_NUMBER'),
                'body' => $messageBody,
            ]
        );

        //send whatsapp
        // $twilio->messages->create(
        //     "whatsapp:+{$bookingTransaction->phone_number}",
        //     [
        //         'from' => "whatsapp:" . getenv('TWILIO_PHONE_NUMBER'),
        //         'body' => $messageBody,
        //     ]
        // );

        
    }

    public function booking_details(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'booking_trx_id' => 'required|string',
        ]);

        $booking = BookingTransaction::where('phone_number', $request->phone_number)
            ->where('booking_trx_id', $request->booking_trx_id)
            // ->with('officeSpace')
            ->with(['officeSpace', 'officeSpace.city'])
            ->first();

        if (!$booking) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }
        return new ViewBookingResource($booking);
    }
}
