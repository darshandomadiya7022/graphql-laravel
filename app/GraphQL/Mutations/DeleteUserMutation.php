<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
/*use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;*/

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\User;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteUser',
        'description' => 'Delete a user'
    ];

    public function type(): Type
    {
        //return Type::listOf(Type::string());
        return Type::boolean();
    }

    public function args(): array
    {
        'id' => [
            'name'  => 'id',
            'type'  => Type::int(),
            'rules' => ['required', 'numeric', 'min:1', 'exists:users,id']
        ]
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /*$fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return [];*/

        $user = User::findOrFail($args['id']);

        return  $user->delete() ? true : false;
    }
}
