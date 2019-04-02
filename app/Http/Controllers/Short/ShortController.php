<?php

namespace App\Http\Controllers\Short;

use App\Http\Requests\LinkStoreRequest;
use App\Http\Requests\LinkUpdateRequest;
use App\Jobs\DeleteExprirationLink;
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

        if ($expirationTime) {
            DeleteExprirationLink::dispatch($link)
                ->delay($expirationTime);
        }

        $locUrl = env('APP_URL');

        return compact('link', 'locUrl');
    }

    public function update(LinkUpdateRequest $request)
    {
        $lastShort = $request->input('lastShort');
        $short = $request->input('short');

        $link = Link::where('short', $lastShort)
            ->where('is_active', 1)
            ->firstOrFail();

        $link->update([
            'short' => $short
        ]);

        $locUrl = env('APP_URL');

        return compact('link', 'locUrl');
    }
}