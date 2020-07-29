<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

use App\User; 
use Rebing\GraphQL\Support\Facades\GraphQL;  

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'Users Query',
        'description' => 'A query of users'
    ];

    // public function type(): Type
    // {
    //     return Type::listOf(Type::string());
    // }

    // public function args(): array
    // {
    //     return [

    //     ];
    // }

    // public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    // {
    //     /** @var SelectFields $fields */
    //     $fields = $getSelectFields();
    //     $select = $fields->getSelect();
    //     $with = $fields->getRelations();

    //     return [
    //         'The users works',
    //     ];
    // }

    public function type(): Type
    {
        // result of query with pagination laravel
        return GraphQL::paginate('users');
    }
    
    // arguments to filter query
    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                //'rules' => ['required']
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string()
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

            if (isset($args['email'])) {
                $query->where('email',$args['email']);
            }
        };

        $user = User::with(array_keys($fields->getRelations()))
            ->where($where)
            ->select($fields->getSelect())
            ->paginate();
            return $user;
    }

    // public function resolve($root, $args, SelectFields $fields)
    // {
    //     $where = function ($query) use ($args) {
    //         if (isset($args['id'])) {
    //             $query->where('id',$args['id']);
    //         }

    //         if (isset($args['email'])) {
    //             $query->where('email',$args['email']);
    //         }
    //     };
    //     // $user = User::with(array_keys($fields->getRelations()))
    //         ->where($where)
    //         ->select($fields->getSelect())
    //         ->paginate();
 
    //     return $user;
    // }
}
