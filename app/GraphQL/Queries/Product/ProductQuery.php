<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Product;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

use App\Models\Product; 
use Rebing\GraphQL\Support\Facades\GraphQL; 

class ProductQuery extends Query
{
    protected $attributes = [
        'name' => 'product\Product',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        //return Type::listOf(Type::string());
        return GraphQL::paginate('products');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(), 
            ],
            'category_id' => [
                'name' => 'category_id',
                'type' => Type::int()
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string()
            ],
            'price' => [
                'name' => 'price',
                'type' => Type::float()
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $where = function ($query) use ($args) {
            if (isset($args['id'])) {
                $query->where('id',$args['id']);
            }

            if (isset($args['name'])) {
                $query->where('name',$args['name']);
            }

            if (isset($args['price'])) {
                $query->where('price',$args['price']);
            }
        };

        $user = Product::with(array_keys($fields->getRelations()))
            ->where($where)
            ->select($fields->getSelect())
            ->paginate();

        return $user;
 
    }
}
