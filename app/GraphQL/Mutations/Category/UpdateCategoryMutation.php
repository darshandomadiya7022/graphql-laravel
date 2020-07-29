<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Category;

use Closure;
  
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Validation\Rule;
use App\User;

class UpdateCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'category\UpdateCategory',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('category');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required','max:50']
            ], 
        ];
    }

    public function resolve($root, $args)
    { 
        $category = Category::findOrFail($args['id']);
        $category->fill($args);
        $category->save();
  
        return $category;
    }
}
