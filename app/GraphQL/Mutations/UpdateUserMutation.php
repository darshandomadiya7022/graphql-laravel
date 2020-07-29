<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
/*use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;*/

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Validation\Rule;
use App\User;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUser',
        'description' => 'A mutation'
    ];

    /*public function authorize(array $args = [])
    {
        return true;
    }*/

   /* public function rules(array $args = [])
    {
        return [
            'id' => [
                'required', 'numeric', 'min:1', 'exists:users,id'
            ],
            'name' => [
                'required', 'max:50'
            ],
            'email' => [
                'required', 'email', 'unique:users,email,'.$args['id'],
            ],
            'password' => [
                'sometimes', 'string', 'min:5'
            ],
        ];
    }*/

    public function type(): Type
    {
        //return Type::listOf(Type::string());

        return GraphQL::type('users');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' =>  Type::nonNull(Type::int()),
                'rules' => ['required','numeric', 'min:1', 'exists:users,id']
            ],
            'name' => [
                'name' => 'name',
                'type' =>  Type::nonNull(Type::string()),
                'rules' => ['required', 'max:50']
            ],
            'email' => [
                'name' => 'email',
                'type' =>  Type::nonNull(Type::string()),
                'rules' => ['required', 'email']
                //'rules' => ['required', 'email', 'unique:users,email,id']
            ],
            'password' => [
                'name' => 'password',
                'type' =>  Type::nonNull(Type::string()),
                'rules' => ['sometimes', 'string', 'min:5']
            ],
        ];
    }

    public function resolve($root, $args)
    { 
        $user = User::findOrFail($args['id']);
        $user->fill($args);
        $user->save();

        return $user;
    }

    /*public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return [];
    }*/
}
