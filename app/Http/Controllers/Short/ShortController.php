<?php

namespace App\Http\Controllers\Short;

use App\Http\Requests\LinkStoreRequest;
use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Acme\Random\Generate;

class ShortController extends Controller
{
    /**
     * @param $shortLink
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($shortLink)
    {
        $originalLink = Link::where('short', $shortLink)
            ->where('is_active', 1)
            ->firstOrFail();

        return redirect($originalLink->original);
    }

    /**
     * @param LinkStoreRequest|Request $request
     * @return array
     */
    public function store(LinkStoreRequest $request)
    {
        sleep(3);
        $userId = Auth::id();
        $originalLink = $request->input('original');
        $expirationTime = $request->input('expiration');

        $short = new Generate();
        $short = $short->random(8);

        $link = new Link([
            'user_id'       => $userId,
            'original'      => $originalLink,
            'short'         => $short,
            'expiration'    => $expirationTime,
        ]);
        $link->save();

        $locUrl = env('APP_URL');

        return compact('link', 'locUrl');
    }
}