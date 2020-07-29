<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
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
            'models' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Model')))),
                'description' => 'The models belonging to the Product',
                'args' => [
                    'id' => ['type' => Type::int()],
                    'name' => ['type' => Type::string()],
                ],
                'query' => function (array $args, HasMany $query) {
                    if (isset($args['id'])) {
                        return $query->where('id', $args['id']);
                    }
                    elseif (isset($args['name'])) {
                        return $query->where('name', $args['name']);
                    }
                    else {
                        return $query;
                    }
                },
            ],
        ];
    }
}
