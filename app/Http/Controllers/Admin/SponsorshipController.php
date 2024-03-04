<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSponsorshipRequest;
use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Braintree\Gateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SponsorshipController extends Controller
{

    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectApartment = Apartment::where("slug", "=", $request->apartment)->get();
        $apartment = $selectApartment[0];
        $sponsorships = ApartmentSponsorship::where("apartment_id", "=", $apartment->id)->get();
        $typeSponsorship = Sponsorship::all();
        return view("admin.sponsorships.index", compact("sponsorships", "apartment", "typeSponsorship"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $apartmentSelected = Apartment::where("slug", "=", $request->apartment)->get();
        $apartment = $apartmentSelected[0];
        $sponsorship = Sponsorship::all();
        $this->gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);
        $token = $this->gateway->clientToken()->generate();
        //  dd($token);
        return view("admin.sponsorships.create", compact('apartment', 'sponsorship', 'token'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSponsorshipRequest $request)
    {
        //Form data
        $form_data = $request->all();
        //Objects
        $sponsorship = Sponsorship::where("id", $form_data["sponsorship_id"])->get();
        $apartment = Apartment::where("id", $form_data["apartment_id"])->get();
        $allSponsorships = ApartmentSponsorship::where("apartment_id", $apartment[0]->id)->get();

        //sponsorship selected by the user
        $selectedSponsorship = $sponsorship[0];
        //Merging the date and the time selected
        $date = $form_data['start_date'];
        $time = $form_data['start_time'];
        $startDate = date('Y-m-d H:i:s', strtotime("$date $time"));
        //Calculation of expiration date
        $expirationDate = Carbon::parse($startDate)->addDays($selectedSponsorship->duration / 24);
        $expirationDate_string = $expirationDate->format("Y-m-d H:i:s");
        //Check if the start date is between the start and expiration date of another sponsorship
        $flag = true;



        if ($startDate < Carbon::now()) {
            $flag = false;
        }

        foreach ($allSponsorships as $checkSponsorship) {
            $from = $checkSponsorship->start_date;
            $to = $checkSponsorship->expiration_date;

            for ($i = 0; $i <= $selectedSponsorship->duration; $i++) {
                $check = Carbon::parse($startDate)->addHours($i);
                if (($check >= $from) && ($check <= $to)) {
                    $flag = false;
                }
            }
        }

        //Inserting the new sponsorship_apartment row in the table
        if ($flag) {
            // $apartment_sponsorship->start_date = $startDate;
            // $apartment_sponsorship->expiration_date = $expirationDate;
            // $apartment_sponsorship->sponsorship_id = $selectedSponsorship->id;
            // $apartment_sponsorship->apartment_id = $form_data['apartment_id'];
            // $apartment_sponsorship->save();

            $sponsorship_data = [
                'start_date' => $startDate,
                'expiration_date' => $expirationDate_string,
                'sponsorship_id' => $selectedSponsorship->id,
                'apartment_id' => $form_data['apartment_id'],
                'price' => $selectedSponsorship->price
            ];

            return redirect()->route('payment', ['apartment' => $apartment[0]->slug, 'sponsorship_data' => $sponsorship_data])->with('message', 'Successfull purchase!');
        }
        return redirect()->route('sponsorships.index', ['apartment' => $apartment[0]->slug])->with('error', 'Something went wrong, please check the dates');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApartmentSponsorship $sponsorship)
    {

        $apartmentData = Apartment::where("id", $sponsorship->apartment_id)->get();
        $apartment = $apartmentData[0];
        $sponsorship->delete();

        return redirect()->route('sponsorships.index', ['apartment' => $apartment->slug])->with('message', 'Sponsorship deleted!');
    }



    public function processPayment(Request $request)
    {
        $nonce = $request->input('payment_method_nonce');

        // Ottenere il prezzo della sponsorizzazione dal database
        $sponsorship = Sponsorship::findOrFail($request->sponsorship_id); // Supponendo che ci sia un campo 'sponsorship_id' nel tuo modulo di pagamento
        $amount = $sponsorship->price;

        // Utilizza il nonce di pagamento per elaborare il pagamento tramite Braintree Gateway
        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        // Gestisci il risultato del pagamento
        if ($result->success) {
            // Pagamento completato con successo
            return redirect()->back()->with('success_message', 'Pagamento completato con successo!');
        } else {
            // Errore durante il pagamento
            return redirect()->back()->with('error_message', 'Errore durante il pagamento: ' . $result->message);
        }
    }

    public function all()
    {

        $result = DB::table('users')
            ->select('apartment_sponsorship.apartment_id', 'apartments.slug', 'sponsorships.name', 'apartment_sponsorship.start_date','apartment_sponsorship.id', 'apartment_sponsorship.expiration_date', 'apartments.title')
            ->join('apartments', 'users.id', '=', 'apartments.user_id')
            ->join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->join('sponsorships', 'apartment_sponsorship.sponsorship_id', '=', 'sponsorships.id')
            ->where('users.id', Auth::user()->id)
            ->get();

        $unsponsoredApartments = DB::table('apartments')
            ->select('apartments.id', 'apartments.slug', 'apartments.title')
            ->leftJoin('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->whereNull('apartment_sponsorship.apartment_id')
            ->get();

        $groupedResult = $result->groupBy('title')->toArray();
        // dd($groupedResult, $unsponsoredApartments);
        return view("admin.sponsorships.all", compact('groupedResult', 'unsponsoredApartments'));
    }
}
