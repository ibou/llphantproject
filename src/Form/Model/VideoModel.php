<?php

declare(strict_types=1);

namespace App\Form\Model;

use App\Enum\VideoDescriptionSize;

class VideoModel
{
  
  public function __construct(
    public ?string $subject = null,
    public VideoDescriptionSize $descriptionSize = VideoDescriptionSize::MEDIUM,
    public ?int $numberOfTags = null,
  ) {
  }
}