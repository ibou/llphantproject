<?php

declare(strict_types=1);

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum VideoDescriptionSize implements TranslatableInterface
{
  case SMALL;
  case MEDIUM;
  case LARGE;


  public function trans(TranslatorInterface $translator, ?string $locale = null): string
  {
    return match ($this) {
      self::SMALL => 'Petite',
      self::MEDIUM => 'Moyenne',
      self::LARGE => 'Grande',
    };
  }

  public function minNumberOfCharacters(): int
  {
    return match ($this) {
      self::SMALL => 100,
      self::MEDIUM => 200,
      self::LARGE => 400,
    };
  }

  public function maxNumberOfCharacters(): int
  {
    return match ($this) {
      self::SMALL => 200,
      self::MEDIUM => 400,
      self::LARGE => 600,
    };
  }
}
