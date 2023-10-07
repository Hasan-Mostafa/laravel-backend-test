<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date_of_publication' => $this->date_of_publication,
            'article_text' => $this->article_text, 
            'image' => $this->image, 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
