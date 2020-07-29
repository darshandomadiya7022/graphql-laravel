<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

// use Closure;
// use GraphQL\Type\Definition\ResolveInfo;
// use GraphQL\Type\Definition\Type;
// use Rebing\GraphQL\Support\Mutation;
// use Rebing\GraphQL\Support\SelectFields; 

use GraphQL; 
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Validation\Rule;
use App\User;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser'
    ];

    // public function authorize(array $args = [])
    // {
    //     return true;
    // }

    // public function rules($args = [])
    // {
    //     return [
    //         'name' => [
    //             'required', 'max:50'
    //         ],
    //         'email' => [
    //             'required', 'email', 'unique:users,email',
    //         ],
    //         'password' => [
    //             'required', 'string', 'min:5'
    //         ],
    //     ];
    // }

    public function type() :Type
    { 
        return GraphQL::type('users');
    }

    public function args():array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' =>  Type::nonNull(Type::string()),
                'rules' => ['required','max:50']
            ],
            'email' => [
                'name' => 'email',
                'type' =>  Type::nonNull(Type::string()),
                'rules' => ['required','email','unique:users,email']
            ],
            'password' => [
                'name' => 'password',
                'type' =>  Type::nonNull(Type::string()),
                'rules' => ['required','string','min:5']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = new User();
        $user->fill($args);
        $user->save();

        return $user;
    }

    // public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    // {
    //     $fields = $getSelectFields();
    //     $select = $fields->getSelect();
    //     $with = $fields->getRelations();

    //     return [];
    // }
}
