<?php

namespace App\Service;

use App\Entity\Product;
use App\Exceptions\ClientException\DatabaseException;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductService 
{
	private $products;

	public function __construct(ProductRepository $products)
	{
		$this->products = $products;
	}

	public function createProduct(Request $request)
	{
        $product = new Product($request->all());
		$product->user_id = $request->user()->getOwnerId();

		if ( ! $product->save())
		{
			throw DatabaseException::create();
		}
	}

	public function updateProduct(Product $product, $request)
	{
		$product = $product->fill($request->all());
		
		if ( ! $product->save())
		{
			throw DatabaseException::update();
		}
	}

}

