<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType; 

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Category',
        'description' => 'A type',
        'model' => Category::class, // define model for users type
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user'
            ],  
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the product'
            ], 
            'products' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('products')))),
                'description' => 'The models belonging to the Product',
                'args' => [
                    'id' => ['type' => Type::int()],
                ],
                'query' => function (array $args, HasMany $query) {
                    if (isset($args['id'])) {
                        return $query->where('id', $args['id']);
                    }
                    else {
                        return $query;
                    }
                },
            ],
        ];
    }
}
