<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Knowledge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    protected Knowledge $knowledge;

    public function __construct()
    {
        $this->knowledge = new Knowledge();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->knowledge->orderBy('id', 'asc')->get(), 200);

    }

}
