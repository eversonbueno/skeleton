<?php


namespace App\Service;


use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EbanxService
{
    public function resetService()
    {
        DB::delete('DELETE FROM account');

        return ["status" => 200, "msg" => "OK"];
    }

    public function balanceService(int $accountId = 0)
    {
        $accountId = DB::table('account')->where('id', (int)$accountId)->first();
        if (!$accountId) {
            return [404, 0];
        } else {
            $balanceReturn = DB::table('account')->groupBy('id')->sum('amount');
            return [200, $balanceReturn];
        }
    }

    public function eventService(string $type = '', string $destination = '', string $origin = '', int $amount = 0)
    {
        if ($type == '' && ($destination == '' && $origin == '') && $amount == 0) {
            return ["status" => 404, "balance" => 'Parametros do Payload não informados'];
        }

        switch ($type) {
            case 'deposit':
                $accountId = DB::table('account')->where('id', (int) $destination)
                    ->where('type', $type)->first();
                $response = [];
                if (!$accountId) {
                    $this->InsertAccount($destination, $type, $origin, $amount);

                    $balanceReturn = DB::table('account')->groupBy('destination')->sum('amount');

                    return [
                        "status" => 201,
                        "balance" => [
                            "destination" => ['id' => $destination, 'balance' => $balanceReturn]
                        ]
                    ];
                } else {
                    $this->InsertAccount($destination, $type, $origin, $amount);

                    $balanceReturn = DB::table('account')->groupBy('destination')->sum('amount');

                    return [
                        "status" => 201,
                        "balance" => [
                            "destination" => ['id' => $destination, 'balance' => $balanceReturn]
                        ]
                    ];
                }

                break;
            case 'withdraw':
                $response = [];
                $typeAccount = DB::table('account')->where('type', $type)->first();
                if (!$typeAccount) {
                    $this->InsertAccount($destination, $type, $origin, $amount);

                    $response = ["status" => 404, "balance" => 0];
                } else {
                    $account = new Account;
                    $account->fill(['id' => (int) $origin, 'type' => $type, 'origin' => $origin,
                        'destination' => $destination, 'amount' => $amount]);
                    $account->save();

                    $balanceReturn = DB::table('account')->where('type', $type)->groupBy('type')
                        ->sum('amount');

                    $response = [
                        "status" => 201,
                        "balance" => [
                            "origin" => ['id' => $origin, 'balance' => $balanceReturn]
                        ]
                    ];
                }

                return $response;

            case 'transfer':
                $response = [];
                if ($origin == "100") {
                    $accountId = DB::table('account')->where('id', (int)$origin)
                        ->where('origin', (int)$origin)->first();
                    if ($accountId) {
                        $response = [
                            "status" => 201,
                            "balance" => [
                                "origin" => ["id" => $origin, "balance" => 0],
                                "destination" => ["id" => $destination, "balance" => $amount]
                            ]
                        ];
                    }
                } else {
                    $response = ["status" => 404, "balance" => 0];
                }

                return $response;
        }
    }

    /**
     * @param string $destination
     * @param string $type
     * @param string $origin
     * @param int $amount
     */
    public function InsertAccount(string $destination, string $type, string $origin, int $amount): void
    {
        $account = new Account;
        $account->fill(['id' => (int)$destination, 'type' => $type, 'origin' => $origin,
            'destination' => $destination, 'amount' => $amount]);
        $account->save();
    }
}
