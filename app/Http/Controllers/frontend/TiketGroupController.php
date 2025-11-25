<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\GroupService;
use Illuminate\Http\Request;

class TiketGroupController extends Controller
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index()
    {
        $data   = $this->groupService->getData();

        return view('frontend.page.buyTicketGroup', [
            'title'         => 'Group || Waterboom Jogja ',
            'sales'         => $data['sales']
        ]);
    }

    public function search(Request $request)
    {

        $validated = $request->validate([
            'q' => 'nullable|string'
        ]);

        $query = $request->get('q');

        $sales = $this->groupService->getPencarian($query);

        return view('frontend.page.partial.sales_list', compact('sales'));
    }
}
