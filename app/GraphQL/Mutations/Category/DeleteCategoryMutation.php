<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Category;

use Closure;
  
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Category;

class DeleteCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'category\DeleteCategory',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        'id' => [
            'name'  => 'id',
            'type'  => Type::int(),
            'rules' => ['required', 'numeric', 'min:1', 'exists:categories,id']
        ]
    }

    public function resolve($root, $args)
    {
        $category = Category::findOrFail($args['id']);

        return  $category->delete() ? true : false;
    }
}
