<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL;
use App\Models\Product;
use GraphQL\Type\Definition\Type; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rebing\GraphQL\Support\Type as GraphQLType; 

class ProductsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Products',
        'description' => 'A type',
        'model' => Product::class, // define model for users type
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user'
            ], 
            'category_id' => [
                'type' => Type::int(),
                'description' => 'The Category id of the product'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the product'
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'The price of the product'
            ], 
            
        ];
    }
}
