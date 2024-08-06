<?php


namespace App\Http\Controllers;


use App\Service\EbanxService;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class EbanxController extends Controller
{
    public function reset()
    {
        $this->service()->resetService();

        return 'OK';

    }

    public function balance(Request $request)
    {
        $accountId = $request->input('account_id');
        if (!isset($accountId)){
            return new JsonResponse([404, 'Account ID deve ser informado!'], 404);
        }

        $service = $this->service()->balanceService($accountId);


        return new JsonResponse($service[1], $service[0]);
    }

    public function event(Request $request)
    {
        $type = $request->input('type');
        $destination = $request->input('destination') ?? '';
        $amount = $request->input('amount');
        $origin = $request->input('origin') ?? '';

        if (!isset($type) || !isset($destination) || !isset($amount)) {
            return new JsonResponse('Um ou mais campos não foram informados no payload', 404);
        }

        $service = $this->service()->eventService($type, $destination, $origin, $amount);

        return new JsonResponse($service['balance'], $service['status']);
    }

    public function service()
    {
        return new EbanxService;
    }
}
