<?php

namespace App\Http\Controllers;

use App\Entity\Product;
use App\Entity\Code;
use App\Http\Requests;
use App\Repository\CodeRepository;
use App\Validation\CodeValidation;
use Illuminate\Http\Request;

class CodeController extends AbstractController
{
    private $codes;

    public function __construct(CodeRepository $codes)
    {
        $this->codes = $codes;
    }


    public function read()
    {
        
    }

    public function create(Request $request)
    {
        $this->validate($request, CodeValidation::$create);

        $product = Product::findOrFail($request->input('product_id'));

        $this->authorize('create', $product);

        $this->service->createCode($request);

        return (new Api($request))
            ->build();
    }

    public function update(Request $request)
    {
        
    }

    public function delete(Request $request)
    {
        
    }


}
