<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Defina a tabela se o nome não seguir a convenção padrão
    protected $table = 'comments';

    // Defina os campos que podem ser preenchidos
    protected $fillable = ['user_id', 'content', 'status'];

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
