<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Category;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

use App\Models\Category; 
use Rebing\GraphQL\Support\Facades\GraphQL; 

class CategoryQuery extends Query
{
    protected $attributes = [
        'name' => 'category\Category',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        //return Type::listOf(Type::string());
        return GraphQL::paginate('category');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(), 
            ], 
            'name' => [
                'name' => 'name',
                'type' => Type::string()
            ], 
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
 
        };

        $user = Category::with(array_keys($fields->getRelations()))
            ->where($where)
            ->select($fields->getSelect())
            ->paginate();

        return $user;
    }
}
