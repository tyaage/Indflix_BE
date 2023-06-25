<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Vip;
use Illuminate\Http\Request;

class VipController extends Controller
{
    public function index() {
        return view('langganan-vip');
    }

    public function subscribeVIP(Request $request)
    {
        $user = auth()->user();

        // Ambil durasi langganan dari permintaan
        $duration = $request->input('duration');

        // Hitung tanggal mulai dan berakhir langganan
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($duration);

        // Simpan data langganan VIP ke tabel 'vip'
        $vip = new Vip();
        $vip->user_id = $user->id;
        $vip->start_date = $startDate;
        $vip->end_date = $endDate;
        $vip->save();

        // Redirect ke halaman akun setelah berhasil berlangganan
        return redirect('/')->with('success', 'Berlangganan VIP berhasil!');
    }
}
