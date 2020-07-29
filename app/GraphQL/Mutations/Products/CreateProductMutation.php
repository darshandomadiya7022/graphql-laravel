<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Products;

use Closure; 
use GraphQL; 
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Validation\Rule;
use App\Models\Product;

class CreateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'products\CreateProduct',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('products');
    }

    public function args(): array
    {
        return [ 
            'category_id' => [
                'name' => 'category_id',
                'type' =>  Type::nonNull(Type::int()),
                'rules' => ['required']
            ], 
            'name' => [
                'name' => 'name',
                'type' =>  Type::nonNull(Type::string()),
                'rules' => ['required','max:50']
            ], 
            'price' => [
                'name' => 'price',
                'type' =>  Type::nonNull(Type::float()),
                'rules' => ['required']
            ], 
        ];
    }

    public function resolve($root, $args)
    {
        $product = new Product();
        $product->fill($args);
        $product->save();

        return $product;
    }
}
