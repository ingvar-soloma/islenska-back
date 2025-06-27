<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/** @mixin \App\Models\Word */
class WordResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        $data['translations'] = $this->whenLoaded('translationsFrom', function () {
            return $this->getFormattedTranslations();
        });

        unset($data['translations_to'], $data['translations_from']);

        return array_merge($data, []);
    }

    /**
     * Get merged and formatted translations
     *
     * @return Collection|null
     */
    private function getFormattedTranslations(): ?Collection
    {
        if (!$this->hasRequiredRelations()) {
            return null;
        }

        $translations = $this->resource->mergedTranslations(
            $this->resource->translationsFrom,
            $this->resource->translationsTo
        );

        return $this->enrichTranslationsWithUserData($translations);
    }

    /**
     * Check if required relations are loaded
     *
     * @return bool
     */
    private function hasRequiredRelations(): bool
    {
        return $this->resource->relationLoaded('translationsFrom') &&
               $this->resource->relationLoaded('translationsTo');
    }

    /**
     * Add user-specific data to translations
     *
     * @param Collection $translations
     * @return Collection
     */
    private function enrichTranslationsWithUserData(Collection $translations): Collection
    {
        foreach ($translations as $key => $translation) {
            if (!isset($translation->users)) {
                continue;
            }

            $isPublic = $translation->isPublic();
            $userTranslation = $this->getUserTranslation($translation->users);

            $translations[$key]->is_public = $isPublic;
            $translations[$key]->is_user_translation = $userTranslation !== null;
            $translations[$key]->user_translation_public = $userTranslation ?
                $userTranslation->pivot->is_public :
                false;
        }

        return $translations;
    }

    /**
     * Get current user's translation if exists
     *
     * @param Collection $users
     * @return mixed
     */
    private function getUserTranslation(Collection $users)
    {
        if (!auth()->check()) {
            return null;
        }

        return $users->where('id', auth()->id())->first();
    }
}
