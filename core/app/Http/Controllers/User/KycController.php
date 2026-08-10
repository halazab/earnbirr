<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function index()
    {
        $pageTitle = 'KYC Verification';
        $user = auth()->user();
        return view('templates.basic.user.kyc.index', compact('pageTitle', 'user'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'id_type' => 'required|in:passport,national_id,driving_license',
            'id_number' => 'required|string|max:100',
            'id_front' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'id_back' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $user = auth()->user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobile = $request->phone;

        $idFrontFile = $request->file('id_front');
        $user->kyc_id_front_data = base64_encode(file_get_contents($idFrontFile->getRealPath()));
        $user->kyc_id_front_type = $idFrontFile->getMimeType();

        $idBackData = null;
        $idBackType = null;
        if ($request->hasFile('id_back')) {
            $idBackFile = $request->file('id_back');
            $idBackData = base64_encode(file_get_contents($idBackFile->getRealPath()));
            $idBackType = $idBackFile->getMimeType();
        }
        $user->kyc_id_back_data = $idBackData;
        $user->kyc_id_back_type = $idBackType;

        $kycData = [
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
        ];
        $user->kyc_data = $kycData;
        $user->kyc_info = json_encode($kycData);
        $user->kv = 2;
        $user->save();

        return redirect()->route('user.home')->with('success', 'KYC documents submitted for review.');
    }
}
