<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{

    /**
     * @api {get} /domain domain.index
     * @apiName domain.index
     * @apiGroup domain
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $domain = Domain::query()->where('user_id', auth()->id())->load('shop')->latest()->paginate($request->input('per_page', 10));
        return response()->json($domain);
    }

    /**
     * @api {post} /domain domain.store
     * @apiName domain.store
     * @apiGroup domain
     * @apiBody {String} name name
     * @apiBody {String} type type_consist of subdomain or domain
     * @apiBody {Number} shop_id shop_id
     */
    public function store(StoreDomainRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $domain = Domain::create($request->validated());
        return response()->json($domain);
    }

    /**
     * @api {get} /domain/:id domain.show
     * @apiName domain.show
     * @apiGroup domain
     * @apiParam {Number} id model id
     */
    public function show(Domain $domain)
    {
        return response()->json($domain);
    }


    /**
     * @api {put} /domain/:id domain.update
     * @apiName domain.update
     * @apiGroup domain
     * @apiParam {Number} id model id
     * @apiBody {String} name name
     * @apiBody {String} type type_consist of subdomain or domain
     * @apiBody {Number} shop_id shop_id
     */
    public function update(UpdateDomainRequest $request, Domain $domain)
    {
        $domain->update($request->validated());
        return response()->json($domain);
    }

    /**
     * @api {delete} /domain/:id domain.destroy
     * @apiName domain.destroy
     * @apiGroup domain
     * @apiParam {Number} id model id
     */
    public function destroy(Domain $domain)
    {
        $domain->delete();
        return response()->json([
            'message' => 'دامنه با موفقیت حذف شد',
        ]);
    }
}
