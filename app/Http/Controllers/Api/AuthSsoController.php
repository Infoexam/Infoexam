<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Account\Account;
use Illuminate\Http\Request;

class AuthSsoController extends Controller {

    public function index(Request $request)
    {
        $cid = $request->input('miXd');
        $ticket = $request->input('ticket');

        if ( ! (is_null($cid) || is_null($ticket) || strlen($cid) === 0 || strlen($ticket) === 0))
        {
            list($status, $person_id) = $this->auth_sso($cid, $ticket);

            if (1 === $status)
            {
                $id = Account::where('username', '=', $person_id)->first(['id']);

                if ( ! is_null($id))
                {
                    \Auth::loginUsingId($id->id);

                    flash()->success(trans('general.login.success'));

                    return redirect()->route('student.index');
                }
            }
        }

        flash()->success(trans('general.sso.failed'));

        return redirect()->route('student.login');
    }

    public function auth_sso($mix_info, $ticket) {
        if (is_null($sso_url = env('API_SSO_URL', null)))
        {
            return [0, null];
        }

        $url = $sso_url.'?cid='.$mix_info.'&ticket='.$ticket;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $xml_txt = curl_exec($curl);
        curl_close($curl);

        $dom = new \DOMDocument();
        $dom->loadXML($xml_txt);

        if ($dom) {
            if (false !== ($sess_info = simplexml_import_dom($dom)))
            {
                if('Y' == $sess_info->sess_alive)
                {
                    return [1, $sess_info->person_id];
                }
            }
        }

        return [0, null];
    }

}