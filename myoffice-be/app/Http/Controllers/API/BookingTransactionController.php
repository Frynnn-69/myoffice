<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\BookingTransaction;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;

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
        // $this->sendNotification($bookingTransaction);
        // return response()->json([
        //     'message' => 'Booking transaction created successfully',
        //     'data' => $bookingTransaction,
        // ], 201);
        
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
