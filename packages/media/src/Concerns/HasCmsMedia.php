<?php

namespace JeffersonGoncalves\Cms\Media\Concerns;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Combine with Spatie\MediaLibrary\HasMedia on the implementing model.
 */
trait HasCmsMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        foreach (config('cms-media.collections', []) as $name => $options) {
            $collection = $this->addMediaCollection($name);

            if ($options['single'] ?? false) {
                $collection->singleFile();
            }

            if ($accepts = $options['accepts'] ?? null) {
                $collection->acceptsMimeTypes($accepts);
            }
        }
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        foreach (config('cms-media.conversions', []) as $name => $size) {
            $this->addMediaConversion($name)
                ->nonQueued()
                ->fit(Fit::Crop, $size['width'], $size['height']);
        }
    }
}
