<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AuthorResource;

class ArticleAuthorResource extends JsonResource
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
            'article_text' => $this->article_text,
            'date_of_publication' => $this->date_of_publication,
            'image' => $this->image,
            'authors' => AuthorResource::collection($this->authors),
        ];
    }
}
